<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Purchase extends CI_Controller {
		
		function __construct()
		{
			parent::__construct();
			header("Content-Type:application/json");
			$this->load->model('Member_model');
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
		
		public function coupons(){
			$id = post('txtprofile_id');
			$res = validateCoupon($id);
			if($res <> ''){
				success_response($res);
			} else {
				fail_response('No coupons available!');
			}
			
		}
		
		public function placeOrder()
		{
			$data = $this->Member_model->placeOrder(post('txtProfileId'), 2);
		//	print_r( $data);die;
			if($data['msg'] == "0"){
				fail_response(['msg'=>$data['res']]);
			} else {
				$data = q("SELECT `order_trans_id`, `order_payble_amt`, `order_discount_amt`, `order_address`,
						`order_pay_mode`, `order_date`, 'Order placed successfully' msg FROM `tr06_order_detail` WHERE `order_trans_id` =  ".$data['res'])->row();
				success_response($data);
			}
		} 
		
		public function viewOrders(){
			$id = post('profileId');
			$oid = post('orderId');
			$data = $this->Member_model->viewOrders($oid, $id);
			success_response($data);
			
		}
		
		public function viewSubOrders(){
			$id = post('profileId');
			$oid = post('subOrderId');
			$data = $this->Member_model->viewSubOrders($oid, $id);
			success_response($data);
			
		}
	}
	
?>			