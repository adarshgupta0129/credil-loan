<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Master extends CI_Controller
{

	/////////////////////////////////////////////////////////////////////////
	//////////     Constructor In Master Controller    ///////
	//////////////////////////////////////////////////////////////////////

	public function __construct()
	{
		parent::__construct();
		$this->_is_logged_in();
		$this->data['page'] = "Master Panel";
		$this->load->model('Master_model');
	}

	/////////////////////////////////////////////////////////////////////////
	//////////     Check Login    ///////
	//////////////////////////////////////////////////////////////////////

	public function _is_logged_in()
	{
		if (session('user_id') == "" || session('usertype') == "2"  || session('usertype') == "3") {
			redirect('auth/logout');
		}
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
		$this->load->view('master/' . $page_name, $data);
		$this->load->view('common/footer');
	}

	public function dashboard_data()
	{
		$data['form_name'] = "Dashboard";
		$call_procedure = ' CALL sp01_admin_dashboard()';
		$data['rid'] = $this->db->query($call_procedure)->row();
		mysqli_next_result($this->db->conn_id);
		return $data;
	}

	public function index()
	{
		$data = $this->dashboard_data();
		$this->view('dashboard', $data);
	}

	public function dashboard()
	{
		$data = $this->dashboard_data();
		$this->view('dashboard', $data);
	}

	/////////////////////////////////////////////////////////////////////////
	//////////     Main Admin Login    ///////
	//////////////////////////////////////////////////////////////////////

	public function view_soft_login()
	{
		$data['form'] = "Admin Login Details";
		$data['config'] = $this->Master_model->select_config();
		$this->view('view_soft_login', $data);
	}

	public function update_mainconfig()
	{
		success($this->Master_model->update_config());
		header("Location:" . base_url() . "master/view_soft_login");
	}

	/////////////////////////////////////////////////////////////////////////
	//////////     Main Admin Login    ///////
	//////////////////////////////////////////////////////////////////////

	public function view_soft_setting()
	{
		$data['form'] = "Admin Setting Details";
		$data['table'] = "Admin Setting Details";
		$data['config'] = $this->db->where('m00_visible', 1)->get("m00_setconfig");
		$this->view('view_soft_setting', $data);
	}

	/////////////////////////////////////////////////////////////////////////
	//////////     Start City Master    ///////
	//////////////////////////////////////////////////////////////////////

	public function view_location()
	{
		$data = [
			'table'		=> "View Location",
			'form' 		=> "Action in Location",
			//'menu' 		=> $this->db->where("loc_id!=",0)->where("loc_parent_id",1)->get('m02_location')->result(),
			'menu' 		=> q("SELECT * FROM `m02_location` WHERE `loc_id` !=0 AND `loc_id` = 35")->result(),
		];
		//	l();
		$this->view('view_location', $data);
	}

	public function set_location()
	{
		if (post('menu_id') <> '0') {
			$this->db
				->set('loc_name', post('loc_name'))
				->set('loc_status', post('ddstatus'))
				->where('loc_id', post('loc_id'))->update('m02_location');
			success("Location updated");
		} else {
			$data = [
				'loc_name' 		=> post('loc_name'),
				'loc_parent_id' => post('loc_parent_id'),
				'loc_status' 	=> post('ddstatus')
			];
			$this->db->insert("m02_location", $data);
			success("Location Added");
		}
	}


	/////////////////////////////////////////////////////////////////////////
	//////////   			  Start Bank Master 			   ///////
	//////////////////////////////////////////////////////////////////////

	public function view_bank()
	{
		$data = [
			'table'	=> "View Bank",
			'form' 	=> "View Banks",
			'banks' 	=> $this->db->where('bank_id<>', 0)->order_by("bank_name", "asc")->get("m01_bank")->result()
		];
		$this->view('view_bank', $data);
	}

	public function add_bank()
	{
		insert("m01_bank", ["bank_name" => post('txtbank')]);
		success(post('txtbank') . " added as bank.");
		header("Location:" . base_url() . "Master/view_bank");
	}


	/////////////////////////////////////////////////////////////////////////
	//////////   			  Start Admin Bank Master 			   ///////
	//////////////////////////////////////////////////////////////////////

	public function view_admin_bank()
	{
		$data = [
			'table'			=> "View Admin Bank",
			'form' 			=> "View Admin Banks",
			'banks' 		=> $this->db->where('bank_id<>', 0)->order_by("bank_name", "asc")->get("m01_bank")->result(),
			'adminBank' 	=> $this->db->get("v03_admin_bank")->result()
		];
		$this->view('view_admin_bank', $data);
	}

	public function add_admin_bank()
	{
		$data = [
			"ad_bank_bank_id" 	=> post('ddbank'),
			"ad_bank_ac" 		=> post('txtac'),
			"ad_bank_ifsc" 		=> post('txtifsc'),
			"ad_bank_branch" 	=> post('txtbranch'),
			"ad_bank_address" 	=> post('txtaddress')
		];
		insert("m09_admin_bank", $data);
		success("Admin bank added.");
		header("Location:" . base_url() . "Master/view_admin_bank");
	}

	/////////////////////////////////////////////////////////////////////////
	//////////   			  Start Payemnt Mode Master 			   ///////
	//////////////////////////////////////////////////////////////////////


	public function view_payment_mode()
	{
		$data = [
			'table'	=> "View Payment Mode",
			'form' 	=> "View Payments Mode",
			'payment' 	=> $this->db->where('pay_mode_id<>', 0)->get("m10_payment_mode")->result()
		];
		$this->view('view_payment_mode', $data);
	}

	public function add_payment_mode()
	{
		insert("m10_payment_mode", ["pay_mode_name" => post('txtpaymentmode')]);
		success(post('txtpaymentmode') . " added as Payment Mode.");
		header("Location:" . base_url() . "Master/view_payment_mode");
	}

	/////////////////////////////////////////////////////////////////////////
	//////////   			  Start Relation Master 			   ///////
	//////////////////////////////////////////////////////////////////////


	public function view_relation()
	{
		$data = [
			'table'	=> "View Relation",
			'form' 	=> "View Relation",
			'relation' 	=> $this->db->where('relation_id<>', 0)->order_by("relation_name", "asc")->get("m11_relations")->result()
		];
		$this->view('view_relation', $data);
	}

	public function add_relation()
	{
		insert("m11_relations", ["relation_name" => post('txtname'), "relation_gender" => post('ddgender')]);
		success(post('txtname') . " added as Relation.");
		header("Location:" . base_url() . "Master/view_relation");
	}

	/////////////////////////////////////////////////////////////////////////
	//////////   			  Start Proof Master 			   ///////
	//////////////////////////////////////////////////////////////////////


	public function view_proof()
	{
		$data = [
			'table'	=> "View Proof",
			'form' 	=> "View Proof",
			'proof' 	=> $this->db->where('proof_id<>', 0)->order_by("proof_name", "asc")->get("m08_proof_type")->result()
		];
		$this->view('view_proof', $data);
	}

	public function add_proof()
	{
		insert("m08_proof_type", ["proof_type" => post('ddprooft'), "proof_name" => post('txtname')]);
		success(post('txtname') . " added as Proof.");
		header("Location:" . base_url() . "Master/view_proof");
	}


	/////////////////////////////////////////////////////////////////////////
	//////////   			  Start Loan Type 			   ///////
	//////////////////////////////////////////////////////////////////////


	public function view_loan_type()
	{
		$data = [
			'table'	=> "View Loan Type",
			'form' 	=> "View Loan Type",
			'loan' 	=> $this->db->where('ln_type_id<>', 0)->order_by("ln_type_name", "asc")->get("ln01_loan_type")->result()
		];
		$this->view('view_loan_type', $data);
	}

	public function add_loan_type()
	{
		insert("ln01_loan_type", ["ln_type_name" => post('txtloantype')]);
		success(post('txtloantype') . " added as Loan Type.");
		header("Location:" . base_url() . "Master/view_loan_type");
	}

	/////////////////////////////////////////////////////////////////////////
	//////////   			  Start Loan Plan 			   ///////
	//////////////////////////////////////////////////////////////////////


	public function view_loan_plan()
	{
		$data = [
			'table'	=> "View Loan Plan",
			'form' 	=> "View Loan Plan",
			'loanType' 	=> $this->db->where('ln_type_id<>', 0)->order_by("ln_type_name", "asc")->get("ln01_loan_type")->result(),
			'loanPlan' 	=> $this->db->get("ln02_loan_plan")->result()
		];
		// p($data);
		$this->view('view_loan_plan', $data);
	}

	public function add_loan_plan()
	{
		$data = [
			"ln_plan_type_id" 	=> post('ddloantype'),
			"ln_plan_name" 		=> post('txtplanname'),
			"ln_plan_min_amt" 		=> post('txtminamt'),
			"ln_plan_max_amt" 	=> post('txtmaxamt'),
			"ln_plan_annual_interest" 	=> post('txtanint'),
			"ln_plan_proc_fee_percent" 	=> post('txtcharges'),
			"ln_plan_min_tanure" 	=> post('txtminmonth'),
			"ln_plan_max_tanure" 	=> post('txtmaxmonth')
		];
		insert("ln02_loan_plan", $data);
		success("Loan Plan  added.");
		header("Location:" . base_url() . "Master/view_loan_plan");
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
			'loc' 			=> $this->db->where('loc_parent_id',1)->where('loc_status',1)->get('m02_location')->result(),
			'branchList' 	=> $this->db->get("v02_branch_detail")->result()
		];
		
		$this->view('view_branch_registration',$data);
	}
	
	public function add_branch()
	{
		$output = $this->Branch_model->insert_branch();			
		header("Location:".base_url()."Master/view_branch_reg");
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
		$output = $this->Master_model->update_branch($bid);			
		header("Location:".base_url()."Master/view_branch_reg");
	}


























	/*
		/////////////////////////////////////////////////////////////////////////
		//////////     Start Location Group Master    ///////
		//////////////////////////////////////////////////////////////////////
		
		public function view_location_group()
		{
			$data = [
			'table'		=> "Location Group",
			'form' 		=> "View Location Group",
			'group' 	=> $this->db->order_by("loc_gr_name","asc")->get("m09_location_group")->result()
			];
  			$this->view('view_location_group',$data);
		}
		
		public function add_location_group()
		{
			insert("m09_location_group", ["loc_gr_name" => post('txtgroup')]);			
			success(post('txtgroup'). " added as location group.");
			header("Location:".base_url()."Master/view_location_group");
		}
		
		/////////////////////////////////////////////////////////////////////////
		//////////     Start Location Group City Master    ///////
		//////////////////////////////////////////////////////////////////////
		
		public function view_location_group_city()
		{
			$data = [
			'table'				=> "Location Group",
			'form' 				=> "View Location Group",			
			'group' 			=> $this->db->where("loc_gr_status",1)->order_by("loc_gr_name","asc")->get("m09_location_group")->result(),
			'location' 			=> $this->db->where('loc_status', 1)->where('loc_parent_id!=', -1)->get('m02_location')->result(),
			'group_location' 	=> $this->db->order_by("loc_gr_name",'asc')->get('v04_location_group')->result()
			];
  			$this->view('view_location_group_city',$data);
		}
		
		public function add_location_group_city()
		{
			$ddlocgrgoup 	= post('ddlocgrgoup');
			$txtcity 		= explode(',', post('txtcity'));
			$ddpincode 		= post('ddpincode');
 			if($ddlocgrgoup <> "" && $ddlocgrgoup > 0)
			{
				if(!empty($txtcity)) {
					foreach($txtcity as $t) {
						$city = [
						"loc_gr_c_gr_id" 	=> $ddlocgrgoup,
						"loc_gr_c_city_id" 	=> $t,
						"loc_gr_c_if_allow"	=> 1
						];
						insert("m10_loc_group_city", $city);
					}
				}
				if(!empty($ddpincode)) {
					foreach($ddpincode as $p) {
						$pin = [
						"loc_gr_c_gr_id" 	=> $ddlocgrgoup,
						"loc_gr_c_city_id"  => $p,
						"loc_gr_c_if_allow" => 0
						];
						insert("m10_loc_group_city", $pin);
					}
				}
				success(" Location saved in Group");
			}
			else 
			{
				error(" Please select Group");
			}
			header("Location:".base_url()."Master/view_location_group_city");
		}
		
	
		/////////////////////////////////////////////////////////////////////////
		//////////     Start Location Group Master    ///////
		//////////////////////////////////////////////////////////////////////
		
		public function view_delivery_days()
		{
			$data = [
			'table'		=> "Delivery Days",
			'form' 		=> "View Delivery Days",
			'days' 	=> $this->db->get("m11_delivery_days")->result()
			];
  			$this->view('view_delivery_days',$data);
		}
		
		public function add_delivery_days()
		{
			insert("m11_delivery_days", ["deli_day_name" => post('txtdeliveryday'),"deli_day_date" => post('txtdeliverydate')]);			
			success(post('txtdeliveryday'). " added as Day.");
			header("Location:".base_url()."Master/view_delivery_days");
		}
		
		/////////////////////////////////////////////////////////////////////////
		//////////     Start Location Group City Master    ///////
		//////////////////////////////////////////////////////////////////////
		
		public function view_delivery_slots()
		{
			$data = [
				'table'		=> "Delivery Slots",
				'form' 		=> "View All Slots",	
				'days' 		=> $this->db->where('deli_day_status', 1)->get("m11_delivery_days")->result(),
				'slot'		=> $this->db->where('deli_day_status', 1)->order_by("deli_slot_day_id",'asc')->get('v07_delivery_slot')->result(),
				'group'		=> $this->db->get("m12_delivery_slot_group")->result()
			];
  			$this->view('view_delivery_slots',$data);
		}
		
		public function add_delivery_slots()
		{
			$dddelivery_day 	= post('dddelivery_day');
			$txtdeli_charge 	= post('txtdeli_charge');
			$dddelivery_start 	= post('dddelivery_start');
			$dddelivery_end 	= post('dddelivery_end');
			if($dddelivery_day <> "" && $dddelivery_day > 0 && $txtdeli_charge <> "" && $txtdeli_charge > 0 && $dddelivery_start <> "" && $dddelivery_start > 0 && $dddelivery_end <> "" && $dddelivery_end > 0)
			{
				$day=post('dddelivery_day');
				foreach($day as $v){
					insert("m12_delivery_slot", 
						[
							"deli_slot_day_id" 		=> $v,
							"deli_slot_charges" 	=> post('txtdeli_charge'),
							"deli_slot_start_time" 	=> post('dddelivery_start'),
							"deli_slot_end_time" 	=> post('dddelivery_end'),
							"deli_group_id"=>$this->input->post('ddGroup')
						]
					);
				}
				
			}
			header("Location:".base_url()."Master/view_delivery_slots");
		}

		function add_delivery_slot_group(){
			if(!empty($this->input->post("group"))){
				$this->db->where("group_name",$this->input->post("group"))->get("m12_delivery_slot_group");
				if($this->db->affected_rows() == 0)
					$this->db->insert("m12_delivery_slot_group",["group_name"=>$this->input->post("group"),"group_status"=>1]);
			}
			redirect("master/view_delivery_slots");
		}

		function update_time_slog_group(){
			$this->db->where("deli_slot_id",$this->input->post('slot'))->update('m12_delivery_slot',["deli_group_id"=>$this->input->post('group')]);
			echo "OK";return;
		}
		
		/////////////////////////////////////////////////////////////////////////
		//////////     Start Front Menu Master    ///////
		//////////////////////////////////////////////////////////////////////
		
		public function view_menu()
		{
			$data = [
			'table'		=> "View Menu",
			'form' 		=> "Action in Menu",
			'menu' 		=> $this->db->where("front_menu_id!=",0)->where("front_menu_parent_id",0)->order_by("front_menu_orderby",'asc')->get('m06_front_menu')->result(),
			'badges' 	=> $this->db->where("badges_status",1)->order_by("badges_id",'asc')->get('m05_badges')->result(),
			'location'  => $this->db->where("loc_gr_status",1)->get("m09_location_group")->result()
			];
 			$this->view('view_menu',$data);
		}
		
		public function set_front_menu()
		{
			$file = '';
			$path = 'images/menu/';
			
			if(post('menu_id') <> '0')
			{
				$this->db
				->set('front_menu_name', post('menu_name'))
				->set('front_menu_badges', post('ddbadges'))
				->set('front_menu_status', post('ddstatus'))
				->set('front_menu_isDisplay', post('isdisplay'))
				->where('front_menu_id',post('menu_id'))->update('m06_front_menu');
				
				$file = $this->Master_model->upload_image($path, post('menu_id'), 'userfile');
				
				if($file <> "")
				{
 					$img_upt = [
					'front_menu_img'	=> $file
					];
					update("m06_front_menu", $img_upt, ['front_menu_id'=>post('menu_id')]);
				}
				
				//update location 
				$this->db->where("menu_id",post('menu_id'))->delete("m06_front_menu_location_group");
				foreach(post('ddlocationGroup') as $v){
					$this->db->insert("m06_front_menu_location_group",[
						"menu_id"=>post('menu_id'),
						"location_group_id"=>$v
					]);
				}

				success("Menu updated");
			}
			else 
			{
				$data = [
					'front_menu_name' 		=> post('menu_name'),
					'front_menu_parent_id' 	=> post('menu_parent_id'),
					'front_menu_status' 	=> post('ddstatus'),
					'front_menu_badges' 	=> post('ddbadges'),
					'front_menu_isDisplay' 	=> post('isdisplay')
				];
				$this->db->insert("m06_front_menu",$data);
				
				$cat_id = $this->db->insert_id();
				$file = $this->Master_model->upload_image($path, $cat_id, 'userfile');
				
				if($file <> "")
				{
 					$img_upt = [
					'front_menu_img'		=> $file
					];
					update("m06_front_menu", $img_upt, ['front_menu_id'=>$cat_id]);
				}

				//update location 
				$this->db->where("menu_id",$cat_id)->delete("m06_front_menu_location_group");
				foreach(post('ddlocationGroup') as $v){
					$this->db->insert("m06_front_menu_location_group",[
						"menu_id"=>$cat_id,
						"location_group_id"=>$v
					]);
				}
				
				success("Menu Added");
			}
			header("Location:".base_url()."master/view_menu");
		}
		
		function get_menu_location(){
			$menu=$this->input->post("menu");
			$data=$this->db->select("location_group_id")->where("menu_id",$menu)->get("m06_front_menu_location_group")->result();
			$data=array_map(function($v){return $v->location_group_id;},$data);
			$this->output
					->set_status_header(200)
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode(['data'=>$data]))
					->_display();
			exit;
		}
		
		/////////////////////////////////////////////////
		//////////     Start Send SMS Master    ///////
		////////////////////////////////////////////////
		
		public function view_send_sms()
		{
			$data['form_name'] = "Send Message";
			$data['table_name'] = "All Users";
			
			$condition='';
			
			if($this->input->post('txtfrom')!='' && $this->input->post('txtfrom')!='0' && $this->input->post('txtto')!='' && $this->input->post('txtto')!='0')
			{
				$condition=$condition."DATE_FORMAT(`m03_user_detail`.`user_joining_date`,'%Y-%m-%d') BETWEEN DATE_FORMAT('".$this->input->post('txtfrom')."','%Y-%m-%d') and  DATE_FORMAT('".$this->input->post('txtto')." ','%Y-%m-%d') and ";
			}
			if($this->input->post('txtstatus')!="" && $this->input->post('txtstatus')!="-1")
			{
				$condition=$condition." `m03_user_detail`.`or_m_status`= ".$this->input->post('txtstatus')." and ";
			}			
			if($this->input->post('txtmob')!="" && $this->input->post('txtmob')!="0")
			{
				$condition=$condition." `m03_user_detail`.`user_mobile_no`= ".$this->input->post('txtmob')." and";
			}
			if(count($this->input->post()) == 0)
			{
				$condition=$condition."DATE_FORMAT(`m03_user_detail`.`user_joining_date`,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')  and";
			}
			
			$condition=$condition." user_mobile_no <> '' AND LENGTH(user_mobile_no) > 9";
			
			$data['rid']=$this->db->query(" SELECT user_mobile_no,user_name FROM m03_user_detail where    $condition  GROUP BY user_mobile_no ");
			
			$this->view('view_sms',$data);
		}
		
		public function send_sms_hid()
		{
			$mid=$this->input->post('txtquid');
			$msg=$this->input->post('txtdesc');
			$pr=explode(',',$mid);
			for($t=0;count($pr)>$t;$t++)
			{
				$uid=$pr[$t];
				$this->crud_model->send_sms($uid,$msg);
			}
		}
		
		/////////////////////////////////////
		///////   		IMAGES		  //////
		//////////////////////////////////
		
		public function images()
		{
			$data = [
				'form' 			=> "Add new Images",
				'userId' 		=> select_col('user_reg_id, user_u_id, user_name', 'm03_user_detail', ['user_status' => 1]),
				'menu' 			=> $this->db->where('front_menu_status', 1)->order_by('front_menu_orderby', 'asc')->get('m06_front_menu')->result(),
				'product' 		=> select_col('pr_id, pr_name, pr_code', 'p07_product', ['pr_status' => 1]),
				'section'	 	=> getEnum('img_section', 'tr11_images'),
			];
			$this->view('images',$data);
		}
		
			
		///////////////////////////////////////////////////////////////
		/////////////////////     Add New Coupon    ////////////////
		///////////////////////////////////////////////////////////////
		
		public function add_images()
		{
			if(post('ddsection') <> '0' && post('ddsection') <> '' )
			{
				$path = 'images/front/';				
				$file = $this->Master_model->upload_image($path, post('ddsection'), 'userfile');
				if($file <> "")
				{
					$data = [
						'img_section'     	=> trim(post('ddsection')),
						'img_image'   		=> $file,
						'img_content'     	=> post('txttitle'),
						'img_short_content' => post('txtdesc'),
						'img_valid_till'    => trim(post('txtdate')),
						'img_product' 		=> (post('txtproducts')==''? 0 :post('txtproducts')),
						'img_show_menu' 	=> post('ddmenu3')
					];
					$this->db->insert("tr11_images", $data);
					success('Image uploaded successfully');
				}
				else
				{
					error('Please upload Image');
				}
			}
			else
			{
				error('Please fill all required box');
			}
			header("location:".base_url()."Master/view_images");
		}
		
		///////////////////////////////////////////////////////////////
		/////////////////////     View Images    ////////////////
		///////////////////////////////////////////////////////////////
		
		public function view_images()
		{
			$data = [
				'form' 			=> "All Images",
				'table' 		=> "All Images",
				'images' 		=> q("select * from v17_images")->result()
			];
			$this->view('view_images', $data);
		}	
		
		
		
		public function delete_image($id, $name)
		{
			remove_images('images/front/'.$id.'/', $name);	
			$this->db->query("DELETE from `tr11_images` WHERE `img_id` = $id ");
			$this->session->set_flashdata('info','Image Deleted');			
			header("Location:".base_url()."master/view_images");		
		}
		
		public function view_customized()
		{
			$data = [
				'form' 			=> "Customized Cake",				
				'menu' 			=> $this->db->where('front_menu_status', 1)->order_by('front_menu_orderby', 'asc')->get('m06_front_menu')->result(),
				'cust' 		=> $this->db->where('tr38_status', 1)->order_by('tr38_regid', 'asc')->get('tr38_customize')->result(),
				
			];
			$this->view('view_customized',$data);
		}
		
		public function disable_customize()
		{
			$id= $this->uri->segment(3);
			$this->db->query("update tr38_customize set tr38_status = 0 where tr38_regid = $id ");
			$this->session->set_flashdata('success','Customized Cake Deleted Successfully||');			
			header("Location:".base_url()."master/view_customized");	
		}
		
						
		public function getTable()
		{		echo "<pre>";
			$column = "'m00_username', 'm00_password', 'm00_admin_type'";
			$table = "m00_admin_login";
			$data['columns'] = getColumns($column, $table);
			$data['rows'] = select_col_tes($column,  $table, []);
			print_r($data['columns']);die;
			$this->view('testing',$data);
		}
		
		/////////////////////////////////////////////////////////////////////////
		//////////     Start Location Group City Master    ///////
		//////////////////////////////////////////////////////////////////////
		
		public function view_flavors()
		{
			$data = [
				'table'		=> "Manage Flavors",
				'form' 		=> "View All Flavors",	
				'flavors'	=> $this->db->get("m13_flavors")->result(),
			];
  			$this->view('view_flavors',$data);
		}
		
		public function add_flavors()
		{
			$txtFlavor 	= post('txtFlavor');
			$txtdeli_charge 	= post('txtdeli_charge');
			if($txtFlavor <> "" && $txtdeli_charge <> "" )
			{
				insert("m13_flavors", 
					[
						"m13_flavor" 	=> $txtFlavor,
						"m13_price" 	=> $txtdeli_charge,
					]
				);
			}
			
			success("Flavour added in system successfully.");
			redirect("master/view_flavors");
		}
		*/
}
