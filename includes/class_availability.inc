<?php

class Availability extends GObject
{
	public function __construct()
	{
		$this->table = 'planning_availability';
		$this->fields['avail_id'] = new GInteger('planning_availability', 'avail_id', 11, FALSE, 0);
		$this->fields['resource_id'] = new GString('planning_availability', 'resource_id', 20, FALSE, '');
		$this->fields['type'] = new GEnum('planning_availability', 'type', array('window', 'blackout'), FALSE, 'window');
		$this->fields['jour_semaine'] = new GInteger('planning_availability', 'jour_semaine', 4, TRUE, NULL);
		$this->fields['heure_debut'] = new GTime('planning_availability', 'heure_debut', 8, TRUE, NULL);
		$this->fields['heure_fin'] = new GTime('planning_availability', 'heure_fin', 8, TRUE, NULL);
		$this->fields['date_debut'] = new GDate('planning_availability', 'date_debut', 10, TRUE, NULL);
		$this->fields['date_fin'] = new GDate('planning_availability', 'date_fin', 10, TRUE, NULL);
		$this->fields['note'] = new GString('planning_availability', 'note', 255, TRUE, NULL);
		$this->primaryKeys = array('avail_id');
		parent::__construct();
	}

	/**
	 * Why a booking of $resourceId over [$dateStart..$dateEnd] is NOT allowed by
	 * the resource's availability rules, or '' if it is allowed.
	 *
	 * Rules:
	 *  - Any 'blackout' row overlapping the requested range blocks it.
	 *  - If the resource defines any 'window' rows, every day in the requested
	 *    range must fall on a weekday covered by a window (time-of-day windows
	 *    are advisory here; day coverage is what's enforced for date-range loans).
	 *    With no window rows, the resource is available any day.
	 *
	 * @return string  reason it is unavailable, or '' when available
	 */
	public static function bookingConflict($resourceId, $dateStart, $dateEnd = null)
	{
		$dateEnd = $dateEnd ?: $dateStart;

		// Blackouts overlapping the range
		$res = db_query("SELECT date_debut, date_fin, note FROM planning_availability
			WHERE resource_id = " . val2sql($resourceId) . " AND type = 'blackout'
			  AND date_debut IS NOT NULL AND date_fin IS NOT NULL
			  AND date_debut <= " . val2sql($dateEnd) . " AND date_fin >= " . val2sql($dateStart));
		if ($row = db_fetch_array($res)) {
			$why = 'unavailable ' . $row['date_debut'] . ' to ' . $row['date_fin'];
			return ($row['note'] !== null && $row['note'] !== '') ? ($why . ' (' . $row['note'] . ')') : $why;
		}

		// Recurring weekly windows (only enforced if the resource defines some)
		$days = array();
		$res = db_query("SELECT DISTINCT jour_semaine FROM planning_availability
			WHERE resource_id = " . val2sql($resourceId) . " AND type = 'window' AND jour_semaine IS NOT NULL");
		while ($r = db_fetch_array($res)) { $days[(int) $r['jour_semaine']] = true; }
		if (count($days) > 0) {
			$d = new DateTime($dateStart);
			$end = new DateTime($dateEnd);
			while ($d <= $end) {
				if (!isset($days[(int) $d->format('N')])) {
					return 'outside the available weekdays for this resource';
				}
				$d->modify('+1 day');
			}
		}
		return '';
	}
}
