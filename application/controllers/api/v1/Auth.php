<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Auth extends CI_Controller {
		
		function __construct()
		{
			parent::__construct();
			header("Content-Type:application/json");
			$this->_is_tokenexist_in();
		}
		
		/////////////////////////////////////////////////////////////////////////
		//////////     			Check Token Is valid		  	  ///////
		//////////////////////////////////////////////////////////////////////
		
		public function _is_tokenexist_in()
		{			 
			if($this->input->server('REQUEST_METHOD') !== "POST") 
			{ 
				fail_response('Request method is wrong.');
			}
		}
		
		public function login()
		{
			$login_data = array(
			'login_id'	=> trim(post('txtlogin')),
			'user_pwd'	=> trim(post('txtpwd')),
			'user_type'	=> trim(post('ddtype'))
			);
			$query="CALL sp00_login(?" . str_repeat(",?", count($login_data)-1) . ",@msg,@msg1)";
			$query_result = $this->db->query($query,$login_data);
		//	l();
			/*-----------------------Check User Logged In or Not-----------------------------*/
			$count = $query_result->num_rows();
			
			/*-----------------------Free Result For Next Query-----------------------------*/
			mysqli_next_result( $this->db->conn_id );
			$msg['msg'] = $this->db->query("SELECT @msg as message")->row()->message;
			$msg1 = $this->db->query("SELECT @msg1 as message1")->row()->message1;
			
			if($msg1 != 0)
			{
				/*-----------------------Fetch Data And Create Session For Login -----------------------------*/
				
				$row = $query_result->row();
				$sessiondata=array(
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
				'msg' 			=> 	'Successfully Login',
				);
				
				if($msg1 == 2)
				{
					success_response($sessiondata);
				}
				else
				{
					fail_response($msg);
				}
			}
			else
			{
				fail_response($msg);
			}
		}
		
		
		public function registration()
		{
 			$this->load->model('Member_model');
			$data = $this->Member_model->signup();
			if($data == 'Invalid mobile number!' || $data == '' || $data == 'Mobile number already in use!')
			fail_response($data);
			else 
			success_response($data);
		}
		
		public function forgotPassword()
		{
			$userid = post('txtuserid');
			$id = get_uid(post('txtuserid'));
			if($id <> 'false'){
				$this->db->where('login_u_id',$userid);
				$loginpwd = $this->db->get('tr01_login')->row();
				
				$this->db->where('user_u_id',$userid);
				$email = $this->db->get('m03_user_detail')->row();
				
				$msg = "Welcome ".$email->user_name.", your login details are - Userid : ".$userid." Password : ".$loginpwd->login_pwd;
				$msg1 = "Your password sent to your registered mobile number.";
				if(SMS_SEND_STATUS==1)
				$this->crud_model->send_sms(trim($email->user_mobile_no),$msg);
				success_response($msg1);
			}
			else  
			{
				fail_response('Incorrect UserId!');
			}
		}
		
	}
	
?>			