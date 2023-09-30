<?php

class Dummy extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->data['page'] = "Authorization";
	}

	public function index()
	{
		$this->load->view('common/header', $this->data);
		$this->load->view('auth/login');
	}

	
	public function loan_calculator()
	{
		$data['form_name'] = "Loan calculator";

		$this->load->view('common/header', $this->data);
		

		$this->load->view('auth/view_loan_calculator', $data);
		$this->load->view('common/footer');
	}

	
}
