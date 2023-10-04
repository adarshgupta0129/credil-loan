<?php

class Auth extends CI_Controller
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

	public function check_sms()
	{
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->database();
		$mob = '9450810364';
		$msg = "TestingFinal";
		echo $this->crud_model->send_sms($mob, $msg);
	}

	public function login()
	{
		$src = get('login_src');
		if ($this->session->userdata('user_id') == "") {
			/*-----------------------Create Array For Login-----------------------------*/

			$login_data = array(
				'login_id'	=> trim(post('txtlogin')),
				'user_pwd'	=> trim(post('txtpwd')),
				'user_type'	=> trim(post('ddtype'))
			);
			$query = "CALL sp00_login(?" . str_repeat(",?", count($login_data) - 1) . ",@msg,@msg1)";
			$query_result = $this->db->query($query, $login_data);
			
			/*-----------------------Check User Logged In or Not-----------------------------*/
			$count = $query_result->num_rows();


			
			/*-----------------------Free Result For Next Query-----------------------------*/
			mysqli_next_result($this->db->conn_id);
			$msg = $this->db->query("SELECT @msg as message")->row()->message;
			$msg1 = $this->db->query("SELECT @msg1 as message1")->row()->message1;

			/*-----------------------Set Message Of Status Or Reason-----------------------------*/
			

			if ($msg1 != 0) {
				/*-----------------------Fetch Data And Create Session For Login -----------------------------*/

				$row = $query_result->row();
				$sessiondata = array(
					'user_id'		=>	$row->user_id,
					'profile_id'	=>	$row->profile_id,
					'email'  		=>	$row->e_email,
					'name'     		=> 	$row->name,
					'designation' 	=>	$row->designation,
					'mobile_no' 	=>	$row->mobile_no,
					'doj' 			=>	$row->doj,
					'profile_pic' 	=>	$row->or_m_userimage,
					'logged_in' 	=> 	$row->logged_in,
					'usertype' 		=> 	$row->usertype,
				);
				
				$this->session->set_userdata($sessiondata);

				/*-----------------Redirect Url For Different User-----------------*/
				
				if ($msg1 == 1) {
					header("Location:" . base_url() . "Master/index");
				} elseif ($msg1 == 2) {
					success($msg);
					header("Location:" . base_url() . "Branch/index");					
				} elseif ($msg1 == 3) {
					success($msg);
					header("Location:" . base_url() . "Support/index");					
				} elseif ($msg1 == 4) {
					success($msg);
					header("Location:" . base_url() . "Financer/index");					
				} elseif ($msg1 == 5) {
					success($msg);
					header("Location:" . base_url() . "Advisor/index");					
				} elseif ($msg1 == 6) {
					success($msg);
					header("Location:" . base_url() . "Userprofile/dashboard");
				} else {
					error($msg);
					redirect($this->agent->referrer());
				}
			} else {
				error($msg);
				redirect($this->agent->referrer());
			}
		} else {
			$this->session->sess_destroy();
			redirect($this->agent->referrer());
		}
	}

	public function registration()
	{
		$data['form_name'] = "Customer Registration";

		$this->load->view('common/header', $this->data);
		$this->db->where('loc_parent_id', 1);
		$this->db->where('loc_status', 1);
		$data['state'] = $this->db->get('m02_location');

		$data['bank'] = $this->db->where("bank_status", 1)->get('m01_bank');
		$data['relation'] = getEnum('user_rel_type', 'm03_user_detail');

		$this->load->view('auth/registration', $data);
		$this->load->view('common/footer');
	}

	public function view_term_condition()
	{
		$data['form_name'] = "View Terms & Condition";

		$this->load->view('common/header', $this->data);
		$this->load->view('auth/view_term_condition', $data);
		$this->load->view('common/footer');
	}

	// -------------USER REGISTRATION INSERTION---------------

	public function register_candidate()
	{
		$output = $this->Member_model->signup();
		echo $output;
	}

		
	public function loan_calculator()
	{
		$data['form_name'] = "Loan calculator";

		$this->load->view('common/header', $this->data);
		$this->load->view('auth/view_loan_calculator', $data);
		$this->load->view('common/footer');
	}

	public function logout()
	{
		$data['msg'] = "Logout Successfully";
		$this->session->sess_destroy();
		header("Location:" . base_url());
	}

	////////-------Forgot Password---------////////

	public function forgot_password()
	{
		$this->load->view('common/header', $this->data);
		$this->load->view('auth/view_forgot_password');
	}

	public function resetpassword()
	{
		$userid = $this->input->post('txtuserid');
		$this->db->where('or_login_id', $userid);
		$loginpwd = $this->db->get('tr01_login')->row();

		$this->db->where('or_m_user_id', $userid);
		$email = $this->db->get('m03_user_detail')->row();

		echo $msg = "Welcome To " . SITE_NAME . " " . $loginpwd->user_name . "  Your Userid : " . $userid . " and , Password : " . $loginpwd->or_login_pwd . " Thanks for Choosing " . WEBSITE_NAME;

		$this->crud_model->send_sms(trim($email->user_mobile_no), $msg);

		$this->crud_model->send_email(trim($email->or_m_email), 'Your Password Details in assvigroup.in', $msg, 'Forget Password');

		header("Location:" . base_url());
	}
}
