<?php

class Requirement_completion extends GObject
{
	public function __construct()
	{
		$this->table = 'planning_requirement_completion';
		$this->fields['requirement_id'] = new GInteger('planning_requirement_completion', 'requirement_id', 11, FALSE, 0);
		$this->fields['subject_type'] = new GEnum('planning_requirement_completion', 'subject_type', array('user', 'resource'), FALSE, 'user');
		$this->fields['subject_id'] = new GString('planning_requirement_completion', 'subject_id', 20, FALSE, '');
		$this->fields['valeur'] = new GString('planning_requirement_completion', 'valeur', 255, TRUE, NULL);
		$this->fields['fichier'] = new GString('planning_requirement_completion', 'fichier', 255, TRUE, NULL);
		$this->fields['date_completion'] = new GDatetime('planning_requirement_completion', 'date_completion', 19, TRUE, NULL);
		$this->fields['completed_by'] = new GString('planning_requirement_completion', 'completed_by', 20, TRUE, NULL);
		$this->primaryKeys = array('requirement_id', 'subject_type', 'subject_id');
		parent::__construct();
	}
}
