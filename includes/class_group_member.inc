<?php

class Group_member extends GObject
{
	public function __construct()
	{
		$this->table = 'planning_group_member';
		$this->fields['group_id'] = new GInteger('planning_group_member', 'group_id', 11, FALSE, 0);
		$this->fields['trainee_id'] = new GString('planning_group_member', 'trainee_id', 20, FALSE, '');
		$this->primaryKeys = array('group_id', 'trainee_id');
		parent::__construct();
	}
}
