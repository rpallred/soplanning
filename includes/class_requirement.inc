<?php

class Requirement extends GObject
{
	public function __construct()
	{
		$this->table = 'planning_requirement';
		$this->fields['requirement_id'] = new GInteger('planning_requirement', 'requirement_id', 11, FALSE, 0);
		$this->fields['cohort_id'] = new GInteger('planning_requirement', 'cohort_id', 11, FALSE, 0);
		$this->fields['libelle'] = new GString('planning_requirement', 'libelle', 255, FALSE, '');
		$this->fields['response_type'] = new GEnum('planning_requirement', 'response_type', array('date', 'bool', 'link', 'file'), FALSE, 'bool');
		$this->fields['ordre'] = new GInteger('planning_requirement', 'ordre', 11, TRUE, 0);
		$this->fields['actif'] = new GEnum('planning_requirement', 'actif', array('oui', 'non'), FALSE, 'oui');
		$this->primaryKeys = array('requirement_id');
		parent::__construct();
	}

	// Deleting a requirement removes its completion rows (cascade at DB level too).
	public function db_delete()
	{
		$completions = new GCollection('Requirement_completion');
		$completions->db_load(array('requirement_id', '=', $this->requirement_id));
		while ($c = $completions->fetch()) {
			$c->db_delete();
		}
		return parent::db_delete();
	}
}
