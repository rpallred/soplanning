<?php

class Group_session extends GObject
{
	public function __construct()
	{
		$this->table = 'planning_group_session';
		$this->fields['group_id'] = new GInteger('planning_group_session', 'group_id', 11, FALSE, 0);
		$this->fields['libelle'] = new GString('planning_group_session', 'libelle', 100, FALSE, '');
		$this->fields['lead_ref'] = new GString('planning_group_session', 'lead_ref', 20, FALSE, '');
		$this->fields['jour_semaine'] = new GInteger('planning_group_session', 'jour_semaine', 4, TRUE, NULL);
		$this->fields['heure_debut'] = new GTime('planning_group_session', 'heure_debut', 8, TRUE, NULL);
		$this->fields['heure_fin'] = new GTime('planning_group_session', 'heure_fin', 8, TRUE, NULL);
		$this->fields['date_debut'] = new GDate('planning_group_session', 'date_debut', 10, TRUE, NULL);
		$this->fields['date_fin'] = new GDate('planning_group_session', 'date_fin', 10, TRUE, NULL);
		$this->fields['actif'] = new GEnum('planning_group_session', 'actif', array('oui', 'non'), FALSE, 'oui');
		$this->primaryKeys = array('group_id');
		parent::__construct();
	}

	// Remove member rows when a group is deleted (FK cascade handles MySQL;
	// this keeps behaviour explicit and works on backends without cascade).
	public function db_delete()
	{
		if ((int) $this->group_id > 0) {
			db_query("DELETE FROM planning_group_member WHERE group_id = " . (int) $this->group_id);
		}
		return parent::db_delete();
	}
}
