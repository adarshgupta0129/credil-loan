<?php 
	
	class Branch extends CI_Controller 
	{
		
		public function __construct() 
		{
			parent::__construct();
			$this->data['page'] = "Branch";
			$this->load->model('Master_model');
			$this->load->model('Branch_model');
		}
		
		public function index()
		{
			$this->load->view('common/header',$this->data);
			$this->load->view('common/menu');
			$this->load->view('branch/registration');
			$this->load->view('common/footer');
		}

		
		public function view($page_name = null, $data = null)
		{
			$this->load->view('common/header', $this->data);
			if (session('usertype') == "4") {
				$this->data['menu'] = $this->db->query("SELECT * FROM `tr36_menu` WHERE `menu_id` IN (SELECT as_parent_id FROM `view_all_assigned_menu` WHERE `as_sub_admin` = " . session('profile_id') . " and menu_status = 1 GROUP BY as_parent_id) ORDER BY `menu_id`");
				$this->load->view('common/subadmin_menu', $this->data);
			} else {
				$this->load->view('common/menu', $this->data);
			}
			$this->load->view('Master/' . $page_name, $data);
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
			'loc' 		=> $this->db->where('loc_parent_id',1)->get('m02_location')->result(),
			'branchList' 	=> $this->db->get("v02_branch_detail")->result()
			];

			$this->view('view_branch_registration',$data);
		}

		public function add_branch()
		{
			$output = $this->Branch_model->insert_branch();			
			header("Location:".base_url()."Branch/view_branch_reg");
		}

	

	 public function view_branch_edit()
		{	
			$data['form_name'] = "Edit Branch";
			$data['form'] = "Edit Branch";

			$data = [
				'table'			=> "Edit Branch",
				'form' 			=> "Edit Branch",
				'loc' 		=> $this->db->where('loc_parent_id',1)->get('m02_location')->result()
				];

			$bid = uri(3);
			$call_query = $this->db->query("SELECT * FROM `m03_branch` WHERE `m03_branch`.`branch_id` = '".$bid."'");
			$data['rec'] = $call_query->row();

			if($bid != '' && $call_query->num_rows()>0)
			{
				$stateid = $call_query->row()->branch_state;
				$data['city_list'] = $this->db->where('loc_parent_id',$stateid)->get('m02_location')->result();
				$this->view('view_branch_edit',$data);	
			}
			
		}


		public function update_branch()
		{
			$bid = uri(3);
			$output = $this->Branch_model->update_branch($bid);			
			header("Location:".base_url()."Branch/view_branch_edit/".$bid);
		}
	}
?>