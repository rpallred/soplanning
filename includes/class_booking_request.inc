<?php

class Booking_request extends GObject
{
	public function __construct()
	{
		$this->table = 'planning_booking_request';
		$this->fields['request_id'] = new GInteger('planning_booking_request', 'request_id', 11, FALSE, 0);
		$this->fields['user_id'] = new GString('planning_booking_request', 'user_id', 20, FALSE, '');
		$this->fields['resource_id'] = new GString('planning_booking_request', 'resource_id', 20, FALSE, '');
		$this->fields['date_debut'] = new GDate('planning_booking_request', 'date_debut', 10, FALSE, NULL);
		$this->fields['date_fin'] = new GDate('planning_booking_request', 'date_fin', 10, TRUE, NULL);
		$this->fields['note'] = new GString('planning_booking_request', 'note', 255, TRUE, NULL);
		$this->fields['statut'] = new GEnum('planning_booking_request', 'statut', array('pending', 'approved', 'denied'), FALSE, 'pending');
		$this->fields['created_at'] = new GDatetime('planning_booking_request', 'created_at', 19, TRUE, NULL);
		$this->fields['decided_by'] = new GString('planning_booking_request', 'decided_by', 20, TRUE, NULL);
		$this->fields['decided_at'] = new GDatetime('planning_booking_request', 'decided_at', 19, TRUE, NULL);
		$this->fields['decision_note'] = new GString('planning_booking_request', 'decision_note', 255, TRUE, NULL);
		$this->primaryKeys = array('request_id');
		parent::__construct();
	}
}
