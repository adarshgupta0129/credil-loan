<?php 
class Financer extends CI_Controller 
{
	
	public function __construct() 
	{
		parent::__construct();
		$this->_is_logged_in();
		$this->data['page'] = "Financer";
	}
	
	
	
	public function _is_logged_in()
	{
		if (session('user_id') == "" || session('usertype') == "3"  || session('usertype') == "5") {
			redirect('auth/logout');
		}
	}
	
	public function view($page_name = null, $data = null)
	{
		$this->load->view('common/header', $this->data);
		$this->load->view('common/financer_menu');
		$this->load->view('financer/' . $page_name, $data);
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
			$this->load->view('common/financer_menu');
			$this->load->view('member/view_all_member', $data);
			$this->load->view('common/footer');

		}
		
		
	/////////////////////////////////////////////////////////////////////////
	//////////   			  Vew Loan Request 			   ///////
	//////////////////////////////////////////////////////////////////////

	public function view_loan_request()
	{

		$data = [
			'table_name'	=> "View All Request",
			'form_name' 	=> "View Loan Request",
			'applyLoan' 	=> $this->db->get("v04_loan_request")->result()
		];
		$this->view('view_loan_request', $data);
	}

	public function approve_loan($id, $status)
	{
		$this->db->set('ap_ln_status', $status);
		$this->db->where('ap_ln_id', $id);
		$this->db->update('tr04_apply_loan');
		redirect('Financer/view_loan_request', $status);
	}

	public function Reject_loan($id)
	{
		$this->db->set('ap_ln_status', 3);
		$this->db->where('ap_ln_id', $id);
		$this->db->update('tr04_apply_loan');
		redirect('Financer/view_loan_request');
	}


}
?>