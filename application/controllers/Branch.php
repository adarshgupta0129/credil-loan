<?php 
	
	class Branch extends CI_Controller 
	{
		
		public function __construct() 
		{
			parent::__construct();
			$this->data['page'] = "Branch";
		}
		
		public function index()
		{
			$this->load->view('common/header',$this->data);
			$this->load->view('common/menu',);
			$this->load->view('branch/registration');
			$this->load->view('common/footer');
		}

		
		
	}
?>