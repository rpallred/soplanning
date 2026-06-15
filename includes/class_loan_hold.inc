<?php

class Loan_hold extends GObject
{
	public function __construct()
	{
		$this->table = 'planning_loan_hold';
		$this->fields['hold_id'] = new GInteger('planning_loan_hold', 'hold_id', 11, FALSE, 0);
		$this->fields['resource_id'] = new GString('planning_loan_hold', 'resource_id', 20, FALSE, '');
		$this->fields['user_id'] = new GString('planning_loan_hold', 'user_id', 20, TRUE, NULL);
		$this->fields['borrower_name'] = new GString('planning_loan_hold', 'borrower_name', 100, TRUE, NULL);
		$this->fields['requested_at'] = new GDatetime('planning_loan_hold', 'requested_at', 19, FALSE, NULL);
		$this->fields['statut'] = new GEnum('planning_loan_hold', 'statut', array('waiting', 'notified', 'fulfilled', 'cancelled'), FALSE, 'waiting');
		$this->primaryKeys = array('hold_id');
		parent::__construct();
	}
}
