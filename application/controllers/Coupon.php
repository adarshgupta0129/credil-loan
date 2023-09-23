<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Coupon extends CI_Controller {
		
		/////////////////////////////////////////////////////////////////////////
		//////////     Constructor In Master Controller    ///////
		//////////////////////////////////////////////////////////////////////
		
		public function __construct()
		{
			parent::__construct();      
			$this->_is_logged_in();
			$this->data['page'] = "Coupon Panel";
			$this->load->model('Master_model');
		}
		
		/////////////////////////////////////////////////////////////////////////
		//////////     Check Login    ///////
		//////////////////////////////////////////////////////////////////////
		
		public function _is_logged_in() 
		{
			if (session('user_id') == "" || session('usertype') == "2"  || session('usertype') == "3")
			{
				redirect('auth/logout');
			}
		}
		
		public function view($page_name = null, $data = null)
		{
			$this->load->view('common/header');
			if(session('usertype') == "4") {
				$this->data['menu'] = $this->db->query("SELECT * FROM `tr36_menu` WHERE `menu_id` IN (SELECT as_parent_id FROM `view_all_assigned_menu` WHERE `as_sub_admin` = ".session('profile_id')." and menu_status = 1 GROUP BY as_parent_id) ORDER BY `menu_id`");
				$this->load->view('common/subadmin_menu', $this->data);
				} else {
				$this->load->view('common/menu', $this->data);
			}
			$this->load->view('coupon/'.$page_name, $data);
			$this->load->view('common/footer');
			
		}	
		
		///////////////////////////////////////////////////////////////
		/////////////////////     Add New Coupon    ////////////////
		///////////////////////////////////////////////////////////////
		
		public function index()
		{
			$data = [
				'form' 			=> "Add new Coupon",
				'userId' 		=> select_col('user_reg_id, user_u_id, user_name', 'm03_user_detail', ['user_status' => 1]),
				'product' 		=> select_col('pr_id, pr_name, pr_code', 'p07_product', ['pr_status' => 1]),
				'applyTime' 	=> getEnum('coupon_apply_time', 'tr08_coupons'),
			];
			$this->view('add_new_coupon', $data);
		}
		
		///////////////////////////////////////////////////////////////
		/////////////////////     Add New Coupon    ////////////////
		///////////////////////////////////////////////////////////////
		
		public function add_coupon()
		{
			if(post('txtcode') <> '')
			{				
				$data = [
					'coupon_code'     		=> trim(post('txtcode')),
					'coupon_title'     		=> trim(post('txttitle')),
					'coupon_description'   	=> trim(post('txtdesc')),
					'coupon_min_amount'     => post('txtminamount'),
					'coupon_amount'   		=> post('txtamount'),
					'coupon_valid_date'     => trim(post('txtdate')),
					'coupon_apply_time'    	=> trim(post('ddapplytime')),
					'coupon_status'    		=> 1,
					'coupon_user_id' 		=> (post('txtusers')==''? 0 :post('txtusers')),
					'coupon_product_id' 	=> (post('txtproducts')==''? 0 :post('txtproducts'))
				];
				$this->db->insert("tr08_coupons", $data);
				success('Coupon created successfully');
			}
			else
			{
				error('Please fill all required box');
			}
			header("location:".base_url()."Coupon/index");
		}
		
		///////////////////////////////////////////////////////////////
		/////////////////////     View Coupon    ////////////////
		///////////////////////////////////////////////////////////////
		
		public function view_coupons()
		{
			$data = [
				'form' 			=> "All Coupons",
				'table' 		=> "All Coupons",
				'coupons' 		=> select('v16_coupan_detail',  ['coupon_status!=' => 3])
			];
			$this->view('view_coupons', $data);
		}	
		
		
	}
?>															