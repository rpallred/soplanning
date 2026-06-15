<?php

class Supervision_coverage extends GObject
{
	public function __construct()
	{
		$this->table = 'planning_supervision_coverage';
		$this->fields['cov_id'] = new GInteger('planning_supervision_coverage', 'cov_id', 11, FALSE, 0);
		$this->fields['trainee_id'] = new GString('planning_supervision_coverage', 'trainee_id', 20, FALSE, '');
		$this->fields['fonction'] = new GEnum('planning_supervision_coverage', 'fonction', array('assigned', 'individual', 'notes', 'all'), FALSE, 'all');
		$this->fields['covering_ref'] = new GString('planning_supervision_coverage', 'covering_ref', 20, FALSE, '');
		$this->fields['date_debut'] = new GDate('planning_supervision_coverage', 'date_debut', 10, FALSE, NULL);
		$this->fields['date_fin'] = new GDate('planning_supervision_coverage', 'date_fin', 10, FALSE, NULL);
		$this->fields['note'] = new GString('planning_supervision_coverage', 'note', 255, TRUE, NULL);
		$this->primaryKeys = array('cov_id');
		parent::__construct();
	}
}
