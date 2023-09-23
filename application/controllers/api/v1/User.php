<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class User extends CI_Controller {
		
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
		
		public function myAddresses()
		{
			$id = post('txtprofile_id');
			$data = $this->db->where('user_reg_id', $id)->get('v12_user_address')->result();
			success_response($data);
		}
		
		public function addAddress()
		{
			$this->load->model('Master_model');
			$data = $this->Master_model->validate_form_address(post('txtprofile_id'));
  			if(isset($data['errors'])){
				fail_response($data['errors']);
			} else {
				$result = $this->db->insert('m04_user_address',$data);
				success_response('Address Added');
			}
		}
		
		public function updateAddress()
		{
			$this->load->model('Master_model');
			$data = $this->Master_model->validate_form_address(post('txtprofile_id'));
  			if(isset($data['errors'])){
				fail_response($data['errors']);
			} else {
				$id = $this->input->post('addressId');
				$result = $this->db->where('user_addr_id',$id)->update('m04_user_address',$data);
				success_response('Address Updated');
			}
		}
		
		public function changePassword()
		{ 
			$id = post('txtprofile_id');
			if(post('txtpassword') == post('txtcpassword')) {
				$ulgpd = array(
					'login_pwd'=>post('txtpassword')
				);
				$this->db->where('login_reg_id', $id);
				if($this->db->update('tr01_login',$ulgpd)){
					success_response('Updated Successfully!!');
				} else {
						fail_response('Something went wrong.');
				}
			} else {
				fail_response('Password does not match!!!');
			}
		}
		
	}
	
?>			