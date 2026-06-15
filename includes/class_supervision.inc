<?php

class Supervision extends GObject
{
	public function __construct()
	{
		$this->table = 'planning_supervision';
		$this->fields['sup_id'] = new GInteger('planning_supervision', 'sup_id', 11, FALSE, 0);
		$this->fields['trainee_id'] = new GString('planning_supervision', 'trainee_id', 20, FALSE, '');
		$this->fields['fonction'] = new GEnum('planning_supervision', 'fonction', array('assigned', 'individual', 'notes'), FALSE, 'assigned');
		$this->fields['supervisor_ref'] = new GString('planning_supervision', 'supervisor_ref', 20, FALSE, '');
		$this->fields['date_debut'] = new GDate('planning_supervision', 'date_debut', 10, FALSE, NULL);
		$this->fields['date_fin'] = new GDate('planning_supervision', 'date_fin', 10, TRUE, NULL);
		$this->fields['jour_semaine'] = new GInteger('planning_supervision', 'jour_semaine', 4, TRUE, NULL);
		$this->fields['heure_debut'] = new GTime('planning_supervision', 'heure_debut', 8, TRUE, NULL);
		$this->fields['heure_fin'] = new GTime('planning_supervision', 'heure_fin', 8, TRUE, NULL);
		$this->fields['actif'] = new GEnum('planning_supervision', 'actif', array('oui', 'non'), FALSE, 'oui');
		$this->primaryKeys = array('sup_id');
		parent::__construct();
	}

	/**
	 * Resolve who supervises a trainee on a given date, per function.
	 *
	 * For each of the three functions returns the base supervisor (an explicit
	 * row for that function, else the 'assigned' supervisor as fallback), any
	 * active coverage (a row matching that function or 'all'), and the effective
	 * supervisor (coverage overrides base).
	 *
	 * @return array fonction => ['base'=>ref|null, 'covered_by'=>ref|null, 'effective'=>ref|null]
	 */
	public static function resolveForDate($traineeId, $date)
	{
		$functions = array('assigned', 'individual', 'notes');

		$bases = array();
		$res = db_query("SELECT fonction, supervisor_ref FROM planning_supervision
			WHERE trainee_id = " . val2sql($traineeId) . " AND actif = 'oui'
			  AND date_debut <= " . val2sql($date) . "
			  AND (date_fin IS NULL OR date_fin >= " . val2sql($date) . ")");
		while ($r = db_fetch_array($res)) { $bases[$r['fonction']] = $r['supervisor_ref']; }
		$assigned = $bases['assigned'] ?? null;

		$cov = array();
		$res = db_query("SELECT fonction, covering_ref FROM planning_supervision_coverage
			WHERE trainee_id = " . val2sql($traineeId) . "
			  AND date_debut <= " . val2sql($date) . " AND date_fin >= " . val2sql($date));
		while ($r = db_fetch_array($res)) { $cov[$r['fonction']] = $r['covering_ref']; }

		$result = array();
		foreach ($functions as $f) {
			$base = $bases[$f] ?? $assigned;            // fall back to the assigned supervisor
			$coveredBy = $cov[$f] ?? ($cov['all'] ?? null);
			$result[$f] = array(
				'base' => $base,
				'covered_by' => $coveredBy,
				'effective' => $coveredBy ?: $base,
			);
		}
		return $result;
	}
}
