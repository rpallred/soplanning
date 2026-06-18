<?php

class Supervisor_level extends GObject
{
	public function __construct()
	{
		$this->table = 'planning_supervisor_level';
		$this->fields['level_id'] = new GInteger('planning_supervisor_level', 'level_id', 11, FALSE, 0);
		$this->fields['code'] = new GString('planning_supervisor_level', 'code', 20, FALSE, '');
		$this->fields['label'] = new GString('planning_supervisor_level', 'label', 60, FALSE, '');
		$this->fields['ordre'] = new GInteger('planning_supervisor_level', 'ordre', 11, FALSE, 0);
		$this->fields['lead_group'] = new GEnum('planning_supervisor_level', 'lead_group', array('oui', 'non'), FALSE, 'oui');
		$this->fields['cover'] = new GEnum('planning_supervisor_level', 'cover', array('oui', 'non'), FALSE, 'non');
		$this->fields['assignable'] = new GEnum('planning_supervisor_level', 'assignable', array('oui', 'non'), FALSE, 'non');
		$this->primaryKeys = array('level_id');
		parent::__construct();
	}
}
