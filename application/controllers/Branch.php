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

		
		

		/////////////////////////////////////////////////////////////////////////
		//////////   			  Start Branch Master 			   ///////
		//////////////////////////////////////////////////////////////////////
		
		public function view_branch_reg()
		{
			$data = [
			'table'			=> "View Branch",
			'form' 			=> "Branch Registraion",
			'banks' 		=> $this->db->where('bank_id<>',0)->order_by("bank_name","asc")->get("m01_bank")->result(),
			'branchList' 	=> $this->db->get("m03_branch")->result()
			];

			
  			$this->view('view_branch_registration',$data);
		}

		public function add_branch()
		{
			$_POST;
			die;
			$data = [
				"branch_code" 	=> post('ddbank'),
				"branch_name" 		=> post('txtac'),
				"branch_conatct_person" 		=> post('txtifsc'),
				"branch_contact_no" 	=> post('txtbranch'),
				"branch_email" 	=> post('txtaddress'),
				"branch_password" 	=> post('txtaddress'),
				"branch_state" 	=> post('txtaddress'),
				"branch_city" 	=> post('txtaddress'),
				"branch_address" 	=> post('txtaddress'),
				"branch_entry_date" 	=> post('txtaddress'),
				"branch_status" 	=> post('txtaddress')
			];
			insert("m03_branch", $data);			
			success("Branch added.");
			header("Location:".base_url()."Master/view_branch_reg");
		}
	}
?>