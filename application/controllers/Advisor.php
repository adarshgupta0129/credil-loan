<?php 
class Advisor extends CI_Controller 
{
	
	public function __construct() 
	{
		parent::__construct();
		$this->_is_logged_in();
		$this->data['page'] = "Advisor";
	}
	
	
	
	public function _is_logged_in()
	{
		if (session('user_id') == "" || session('usertype') == "3"  || session('usertype') == "4") {
			redirect('auth/logout');
		}
	}
	
	public function view($page_name = null, $data = null)
	{
		$this->load->view('common/header', $this->data);
		$this->load->view('common/advisor_menu');
		$this->load->view('advisor/' . $page_name, $data);
		$this->load->view('common/footer');
	}
    
	public function index()
	{
		$data['form_name'] = "Dashboard";		
		$this->view('dashboard', $data);
	}

		/*|------------------------------------------|*/
		/*|------     USER SEARCH MEMEBR      -------|*/
		/*|------------------------------------------|*/
		
		public function view_all_member($type)
		{
			$data['form_name'] = "View Search Member";
			$data['table_name'] = "View All Member";
			$data['rank'] = $this->db->get('m03_designation');	

			$condition = $this->Member_model->globalSearch();
			$condition=$condition." and `m03_user_detail`.`user_type` = ".$type;
			$condition=$condition." ORDER BY `m03_user_detail`.`user_reg_id` DESC";
			
			$call_procedure = ' CALL sp05_member_details("'.$condition.'")';
			$data['rid']=$this->db->query($call_procedure);
			mysqli_next_result( $this->db->conn_id );

			$this->load->view('common/header', $this->data);
			$this->load->view('common/advisor_menu');
			$this->load->view('member/view_all_member', $data);
			$this->load->view('common/footer');

		}
		
		
		/////////////////////////////////////
		///////   		KYC		  //////
		//////////////////////////////////
		
		public function view_kyc()
		{
			$data['form_name']="View Customer KYC";
			$data['table_name'] = "View All Member";
			
			$data['rank'] = $this->db->get('m03_designation');

			$condition = $this->Member_model->globalSearch();
			$condition=$condition." and `m03_user_detail`.`user_type` = 6";
			$condition=$condition." ORDER BY `m03_user_detail`.`user_reg_id` DESC";
			
			$call_procedure = ' CALL sp05_member_details("'.$condition.'")';
			$data['rid']=$this->db->query($call_procedure);
			mysqli_next_result( $this->db->conn_id );
			
			$this->load->view('common/header', $this->data);
			$this->load->view('common/advisor_menu');
			$this->load->view('member/view_kyc', $data);
			$this->load->view('common/footer');
		}
		
		public function approve_kyc($id,$status) 
		{
			$this->db->set('kyc_admin_status',$status);
			$this->db->set('kyc_status',1);
			$this->db->where('kyc_user_id',$id);
			$this->db->update('tr03_kyc');
			redirect('Advisor/view_kyc', $status);
		}
		
		public function delete_kyc($id) 
		{
			$this->db->where('kyc_user_id',$id);
			$this->db->delete('tr03_kyc');
			insert('tr03_kyc',['kyc_user_id' => $id]);
			redirect('Advisor/view_kyc', $status);
		}
	
}
?>