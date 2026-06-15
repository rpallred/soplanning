<?php

class Loan extends GObject
{
	public function __construct()
	{
		$this->table = 'planning_loan';
		$this->fields['loan_id'] = new GInteger('planning_loan', 'loan_id', 11, FALSE, 0);
		$this->fields['resource_id'] = new GString('planning_loan', 'resource_id', 20, FALSE, '');
		$this->fields['user_id'] = new GString('planning_loan', 'user_id', 20, TRUE, NULL);
		$this->fields['borrower_name'] = new GString('planning_loan', 'borrower_name', 100, TRUE, NULL);
		$this->fields['date_out'] = new GDate('planning_loan', 'date_out', 10, FALSE, NULL);
		$this->fields['date_due'] = new GDate('planning_loan', 'date_due', 10, TRUE, NULL);
		$this->fields['date_in'] = new GDate('planning_loan', 'date_in', 10, TRUE, NULL);
		$this->fields['statut'] = new GEnum('planning_loan', 'statut', array('out', 'returned', 'lost'), FALSE, 'out');
		$this->fields['note'] = new GString('planning_loan', 'note', 255, TRUE, NULL);
		$this->fields['reminded_at'] = new GDatetime('planning_loan', 'reminded_at', 19, TRUE, NULL);
		$this->primaryKeys = array('loan_id');
		parent::__construct();
	}

	// A loan is overdue when it is still out and past its due date.
	public function isOverdue()
	{
		// read magic props into locals (GObject has no __isset, so empty() is unreliable)
		$statut = (string) $this->statut;
		$due = (string) $this->date_due;
		return ($statut === 'out' && $due !== '' && $due < date('Y-m-d'));
	}
}
