<?php

class Cohort extends GObject
{
	public function __construct()
	{
		$this->table = 'planning_cohort';
		$this->fields['cohort_id'] = new GInteger('planning_cohort', 'cohort_id', 11, FALSE, 0);
		$this->fields['libelle'] = new GString('planning_cohort', 'libelle', 100, FALSE, '');
		$this->fields['annee'] = new GString('planning_cohort', 'annee', 20, TRUE, NULL);
		$this->fields['population'] = new GEnum('planning_cohort', 'population', array('trainee', 'supervisor'), FALSE, 'trainee');
		$this->primaryKeys = array('cohort_id');
		parent::__construct();
	}

	// When a cohort is deleted, detach its trainees and drop its requirements
	// (requirement rows cascade at the DB level; this keeps user rows valid).
	public function db_delete()
	{
		$users = new GCollection('User');
		$users->db_load(array('cohort_id', '=', $this->cohort_id));
		while ($user = $users->fetch()) {
			$user->cohort_id = NULL;
			$user->db_save();
		}
		return parent::db_delete();
	}
}
