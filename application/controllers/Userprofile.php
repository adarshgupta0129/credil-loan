<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Userprofile extends CI_Controller {
		
		//////////////////////////////////////////////////////////////////////////
		//////////     Constructor In Member Controller    ///////
		/////////////////////////////////////////////////////////////////////////
		
		public function __construct()
		{
			parent::__construct();
			$this->_is_logged_in();
			$this->data['page'] = "Customer Panel";
			$this->load->model('Master_model');
		}
		
		/////////////////////////////////////////////////////////////////////////
		//////////     Check Login    ///////
		//////////////////////////////////////////////////////////////////////
		
		public function _is_logged_in() 
		{
			if($this->session->userdata('user_id') == "" && $this->session->userdata('profile_id') == 0)
			{
				redirect('auth/index');
				die();
			}
		}
		
		public function index()
		{
			$this->dashboard();
		}
		
		public function view($page_name = null, $data = null)
		{
			$this->load->view('common/header');
			$this->load->view('common/user_menu',$this->data);
			$this->load->view('user/'.$page_name,$data);
			$this->load->view('common/footer');	
		}
		
		/*----------------------User Dashboard----------------------------*/
		
		public function dashboard()
		{
			$data['form'] = "Dashboard";
			$query = "CALL sp04_user_dashboard(".session('profile_id').")";
			$data['user']=$this->db->query($query)->row();
			mysqli_next_result( $this->db->conn_id );
			
			$call_procedure = ' CALL sp05_member_details("`m03_user_detail`.`user_reg_id` = '.session('profile_id').'")';
			$query1 = $this->db->query($call_procedure);
			$data['rec1'] = $row = $query1->row();
			mysqli_next_result( $this->db->conn_id );
			
			$this->view('dashboard',$data);
		}
		
		/*|------     USER DETAILS      -------|*/
		
		public function member_profile()
		{	
			$data['form'] = "Customer Profile";			
			$data['location'] = $this->db->where('loc_status', 1)->get("m02_location")->result();
			$condition = "`m03_user_detail`.`user_reg_id` = '".session('profile_id')."'";
			$call_procedure = ' CALL sp05_member_details("'. $condition .'")';
			$data['rec'] = $this->db->query($call_procedure)->row();
			mysqli_next_result( $this->db->conn_id );			 
			$this->view('member_profile',$data);
		}
		
		/*|------     USER PASSWORD      -------|*/
		
		public function change_password()
		{
			$data['form'] = "Change Password";
			$this->view('view_change_password',$data);
		}
		
		public function update_password()
		{
			if(post('txtpassword') <> post('txtcpassword')) {
				$ulgpd = array(
				'login_pwd'=>$this->input->post('txtpassword')
				);
				$this->db->where('login_reg_id',session('profile_id'));
				if($this->db->update('tr01_login',$ulgpd)){
					success('Updated Successfully!!');
					} else {
					error('Oh Snap!! Something went wrong.');
					header("Location:".base_url()."userprofile/change_password");
				}
				} else {
				error('Oh Snap!! Password does not match!');
				header("Location:".base_url()."userprofile/change_password");
			}
		}
		
		/*|------  		      USER QUERY      	     -------|*/
		
		public function query_form()
		{
			$data['form'] = "Submit Query Here";
			$data['table'] = "View All Query";
			$data['rec']=$this->db->where('TICKET_REGID',session('profile_id'))->get('v09_query_ticket');
			$this->view('query_form',$data);
		}
		
		public function insert_ticket()
		{
			$data=array(
			'qr_ticket_id'		=> 0,
			'qr_ticket_userid'	=> trim(post('txtuserid')),
			'qr_ticket_title'	=> trim(post('txttitle')),
			'qr_ticket_desc'	=> trim(post('txtmsg')),
			'qr_ticket_reply'	=> 0,
			'qr_ticket_status'	=> 1,
			'qr_ticket_date'	=> YmdHis,
			'proc'				=> 1
			);
			$query = " CALL sp06_query_ticket(?" . str_repeat(",?", count($data)-1) . ",@msg) ";
			$this->db->query($query, $data);
			$query1=$this->db->query("SELECT @msg as message");
			$row = $query1->row();
			success($row->message);
			header("Location:".base_url()."userprofile/query_form");
		}
		
		
		/*|------  		      MEMBER ADDRESS      	     -------|*/
		
		
		public function member_address(){
			$data['form'] = "Member Address";
			$id=$this->session->userdata('profile_id');
			$data['result'] = $this->db->where('user_reg_id',$id)->where('user_addr_status',1)->get('v12_user_address')->result();
			$data['loc'] = $this->db->where('loc_parent_id',1)->get('m02_location')->result();
			//print_r($data['result']);exit;
			$this->view('member_address',$data);
		}
		public function member_address_delete(){
			$id = $this->input->post('id');
			$data['user_addr_status'] = 0;
			$this->db->where('user_addr_id',$id)->update('m04_user_address',$data);
			echo json_encode(['status'=>true,'message'=>'One Record Successfully Deleted !']);
		}
		public function member_address_data(){
			$id = $this->input->post('id');
			$post = $this->db->where('user_addr_id',$id)->get('m04_user_address')->row();
			$data = array('status'=>true,'user_data'=>$post);
			echo json_encode($data);
		}
		
		public function update_address(){
			$data = $this->Master_model->validate_form_address(session('profile_id'));
			$id = $this->input->post('userid');
			$result = $this->db->where('user_addr_id',$id)->update('m04_user_address',$data);
			if($result){
				echo json_encode(['success'=>true,'message'=>'Your Address Successfully Updated !']);
				die;
			}
			else{
				echo json_encode(['success'=>false,'message'=>'Address Not Update ! Try again...']);
				die;
			}
		}
		
		public function delete_address($id){
			$data=[
			'user_addr_status'=>0
			];
			$this->db->where('user_addr_id',$id);
			$this->db->update('m04_user_address',$data);
			redirect('userprofile/member_address');
		}
		
		public function edit_address(){
	    	$id=$this->input->post('id');
			$this->db->select('*');
			$this->db->from('v12_user_address');
			$this->db->where('user_addr_id', $id);
			if ( $post = $this->db->get()->row()){
				$data = array('response' => "success", 'post' => $post);
			} 
			echo json_encode($data);
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		/*|--------------------------------------|*/
		/*|------   UPDATE USER PROFILE   -------|*/
		/*|--------------------------------------|*/
		
		public function view_member_edit()
		{	
			$data['form_name'] = "Edit Associate";
			
			$this->db->where('loc_parent_id',1);
			$this->db->where('loc_status',1);
			$data['state']=$this->db->get('m02_location');
			$data['relation']=$this->db->get('m07_relation');
			
			$condition = "`m03_user_detail`.`user_reg_id` = '".$this->session->userdata('profile_id')."'";
			$call_procedure = ' CALL sp05_member_details("'. $condition .'")';
			$data['rec'] = $this->db->query($call_procedure)->row();
			mysqli_next_result( $this->db->conn_id );
			
			$topup=$this->db->where('tr_user_id',$this->session->userdata('profile_id'))->get('tr34_retopup');
			if($topup->num_rows() > 0)
			{
				$data['readonly']='';
			}
			else
			{
				$data['readonly']='';
			}
			
			$this->view('view_member_edit',$data);
		}
		
		/*-------------UPDATE USER DETAILS-----------------*/
		
		public function update_member()
		{
			$this->member_model->update_member();
			$this->session->set_flashdata('info','Updated Successfully!!');
			header("Location:".base_url()."userprofile/view_member_edit");
		}
		
		/*|--------------------------------------|*/
		/*|------     VIEW USER PROFILE   -------|*/
		/*|--------------------------------------|*/
		
		
		/*|-----------------------------------------------------|*/
		/*|------   ADD BANK DETAILS      -------|*/
		/*|-----------------------------------------------------|*/
		
		public function view_bank_details()
		{
			$data['form_name'] = "View Bank Details";
			$data['table_name'] = "Update Bank Details";
			
			$data['bank'] = $this->db->where("m_bank_status",1)->get("m01_bank");
			
			$data['dt'] = $this->db->query("SELECT MAX(`or_m_date`) as dt FROM `m04_user_pancard` WHERE `or_m_id` = ".$this->session->userdata('profile_id'))->row()->dt;
			
			$call_procedure = ' CALL sp05_member_details("`m03_user_detail`.`user_reg_id` = '.$this->session->userdata('profile_id').'")';
			$data['bank_details']=$this->db->query($call_procedure);
			mysqli_next_result( $this->db->conn_id );
			// echo "<pre>";
			//print_r($data['bank_details']->result());die;
			$this->view('view_bank_details',$data);
		}
		
		public function update_bank_details()
		{
			$insert=array(
			'or_m_id' =>$this->session->userdata('profile_id') , 
			'or_m_old_pancard'=>$this->input->post('txtoldpan'),
			'or_m_new_pancard'=>$this->input->post('txtpancard')
			);
			$this->db->insert('m04_user_pancard',$insert);
			
			$this->member_model->update_bank_details();
			$this->session->set_flashdata('info','Bank Details Updated Successfully!!');
			header("Location:".base_url()."userprofile/view_bank_details");
		}
		
		/*|--------------------------------------|*/
		/*|------     Welcome Letter     -------|*/
		/*|--------------------------------------|*/
		
		public function member_welcome_letter()
		{
			$data['form_name'] = "Welcome Letter";
			
			$call_procedure = ' CALL sp05_member_details("`m03_user_detail`.`user_reg_id` = '.session('profile_id').'")';
			$data['info']=$this->db->query($call_procedure);
			mysqli_next_result( $this->db->conn_id );
			
			$this->view('member_welcome_letter',$data);
		}
		
		
		public function member_icard()
		{
			$call_procedure = ' CALL sp05_member_details("`m03_user_detail`.`user_reg_id` = '.session('profile_id').'")';
			$data['row']=$this->db->query($call_procedure)->row();
			mysqli_next_result( $this->db->conn_id );
			$page_path = 'user/view_i_card';
			
 			if(uri(3)!='topdf')
			{
				$this->load->view($page_path,$data);
			}
			else
			{
				$this->crud_model->topdf($page_path,$data,'I-card');
			}
		}
		
		/*|--------------------------------------|*/
		/*|------     Welcome Invoice     -------|*/
		/*|--------------------------------------|*/
		
		public function member_welcome_invoice()
		{
			$data['form_name'] = "User Invoice";
			
			$call_procedure = ' CALL sp05_member_details("`m03_user_detail`.`user_reg_id` = '.$this->session->userdata('profile_id').'")';
			$data['info']=$this->db->query($call_procedure);
			mysqli_next_result( $this->db->conn_id );
			
			$this->load->view('common/header');
			$this->load->view('common/user_menu',$this->data);
			$this->load->view('user/member_welcome_invoice',$data);
			$this->load->view('common/footer');
		}
		
		/*|-------------------------------------------|*/
		/*|------     Welcome GST Invoice Ist  -------|*/
		/*|-------------------------------------------|*/
		
		public function member_gst_submit()
		{
			$data['form_name'] = "User Invoice";
			
			$call_procedure = "select * from tr34_retopup where `tr_user_id` = ".$this->session->userdata('profile_id');
			$data['info']=$this->db->query($call_procedure);
			
			$this->load->view('common/header');
			$this->load->view('common/user_menu',$this->data);
			$this->load->view('user/member_gst_submit',$data);
			$this->load->view('common/footer');
		}
		
		/*|-------------------------------------------|*/
		/*|------     Welcome GST Invoice Ist  -------|*/
		/*|-------------------------------------------|*/
		
		public function member_bussiness()
		{
			$data['form_name'] = "Bussiness Plan";
			
			$this->load->view('common/header');
			$this->load->view('common/user_menu',$this->data);
			$this->load->view('user/member_bussiness',$data);
			$this->load->view('common/footer');
		}
		
		/*|------------------------------------------|*/
		/*|------     Welcome GST Invoice     -------|*/
		/*|------------------------------------------|*/
		
		public function member_gst_invoice()
		{
			$data['form_name'] = "User Invoice";
			$id = $this->input->post('ddinvoice');
			
			$call_procedure = "select * from view_retopup where `tr_invoice` = '$id' and `tr_user_id` = ".$this->session->userdata('profile_id');
			$data['info']=$this->db->query($call_procedure)->row();
			
			$this->load->view('common/header');
			$this->load->view('common/user_menu',$this->data);
			$this->load->view('user/invoice',$data);
			$this->load->view('common/footer');
		}
		
		/*|--------------------------------------|*/
		/*|------     UPDATE Password     -------|*/
		/*|--------------------------------------|*/
		
		
		
		public function update_tr_password()
		{
			$ulgpd=array(
			'or_pin_pwd'=>$this->input->post('txtpassword')
			);
			$this->db->where('or_user_id',$this->session->userdata('profile_id'));
			
			if($this->db->update('tr01_login',$ulgpd))
			$this->session->set_flashdata('info','Updated Successfully!!');
			else
			$this->session->set_flashdata('info','Oh Snap!! Some thing went wrong.');
			header("Location:".base_url()."userprofile/change_password");
		}
		
		/*|---------------------------------------------------------|*/
		/*|------  		    USER DIRECT REFFERAL             -------|*/
		/*|---------------------------------------------------------|*/
		
		public function view_direct_referal()
		{
			$data['form_name'] = "Search Direct Referal";
			$data['table_name'] = "View Direct Referal";
			$condition = $data['rec'] = '';
			
			$id = $this->session->userdata('profile_id');
			
			$condition=$condition.' `m03_user_detail`.`or_m_intr_id` = '.$id;
			
			$call_procedure = " CALL sp05_member_details('$condition')";
			$data['rec'] = $this->db->query($call_procedure ); 
			mysqli_next_result( $this->db->conn_id );
			
			$this->view('view_direct_referal',$data);
		}
		
		/*|--------------------------------------------------------|*/
		/*|------        		USER DOWNLINE  		 	    -------|*/
		/*|--------------------------------------------------------|*/
		
		public function view_user_downline()
		{
			$data['form_name'] 	= "Downline Member";
			$data['table_name'] = "View Downline Member";
			$uid 				= $this->session->userdata('profile_id');
			
			if(ISLEVEL==0)
			{	if(post('ddposition'))
				{
					$leg = post('ddposition');
					if($leg=='' || $leg=='1')
					{
						$leg = 1;
					}
					$data['rec'] = $this->db->query("CALL`get_downline`($uid,'$leg');");					
					mysqli_next_result( $this->db->conn_id );
				}
			}			
			$this->view('view_user_downline',$data);
		}
		
		/*|--------------------------------------------------------|*/
		/*|------        			USER DIRECT DOWNLINE   	    -------|*/
		/*|--------------------------------------------------------|*/
		
		public function view_direct_downline()
		{
			$data['rec'] = '';
			$data['form_name'] = "Direct Team Member";
			$data['table_name'] = "View Direct Team Member";
			
			$uid = session('profile_id');
			$data['rec'] = $this->db->query("CALL`get_intro_downline`($uid);");					
			mysqli_next_result( $this->db->conn_id );
			$this->view('view_direct_downline',$data);
		}		
		/*|--------------------------------------------------|*/
		/*|------     		USER TREE STRUCTURE	      -------|*/
		/*|--------------------------------------------------|*/
		
		public function tree()
		{
			$data['form_name'] = "Tree Structure";
			
			$id = uri(3);
			$res = $this->member_model->scan_team($id);
			if($res == "false")
			{	
				header('location:'.base_url().'userprofile/tree/'.session('profile_id'));
			}
			$this->db->query("CALL `sp_user_at_level`($id,3)");
			$data['tr']=$this->db->query("SELECT * FROM `view_tree` WHERE `REGID` IN (SELECT * FROM total_user)");
			$this->view('view_tree',$data);
		}
		
		/*----------------SEARCH USER ID IN TREE-------------------*/
		
		public function get_tree()
		{
			if($this->input->post('search_id')!='' || $this->input->post('search_id')!='0')
			{
				$this->db->where('or_m_user_id',trim($this->input->post('search_id')));
				$uid=$this->db->get('m03_user_detail')->row()->user_reg_id;
				header("Location:".base_url()."userprofile/tree/".$uid);
			}
		}
		
		/*|--------------------------------------------------------------------|*/
		/*|------    LEDGER REPORT OF USER        -------|*/
		/*|--------------------------------------------------------------------|*/
		
		public function view_ledger_report()
		{
			$condition="";
			$todate=0;
			$fromdate=0;
			
			$data['form_name'] = "Search Member Ledger";
			$data['table_name'] = "View Member Ledger";
			
			$data["det"] = $this->db->query("SELECT SUM(`m_cramount`) cr, SUM(`m_dramount`) dr FROM `tr07_manage_ledger` WHERE `tr07_manage_ledger`.`m_u_id` = ".$this->session->userdata('profile_id')." and `tr07_manage_ledger`.`m_bal_type` = 1")->row();
			
			if($this->input->post('end')!="")
			{
				$todate=date('Y-m-d',strtotime($this->input->post('end')));
			}
			
			if($this->input->post('start')!="")
			{
				$fromdate=date('Y-m-d',strtotime($this->input->post('start')));
			}
			
			if($todate!='0' && $fromdate!='0')
			{
				$condition=$condition." `LEDGER_DATETIME1`>='$fromdate' AND `LEDGER_DATETIME1`<='$todate' AND ";
			}
			
			$condition=$condition." `LEDGER_UID` = ".$this->session->userdata('profile_id');
			$condition=$condition." and `LEDGER_BALTYPE`=1";
			
			$data['rid']=$this->db->query("SELECT * FROM view_ledger WHERE ".$condition);
			
			$this->load->view('common/header');
			$this->load->view('common/user_menu',$this->data);
			$this->load->view('user/view_ledger_report',$data);
			$this->load->view('common/footer');
		}
		
		public function view_eshop_wallet()
		{
			$condition="";
			$todate=0;
			$fromdate=0;
			
			$data['form_name'] = "Search E-Shop Wallet";
			$data['table_name'] = "View E-Shop Wallet";
			
			$data["det"] = $this->db->query("SELECT SUM(`m_cramount`) cr, SUM(`m_dramount`) dr FROM `tr07_manage_ledger` WHERE `tr07_manage_ledger`.`m_u_id` = ".$this->session->userdata('profile_id')." and `tr07_manage_ledger`.`m_bal_type` = 2")->row();
			
			if($this->input->post('end')!="")
			{
				$todate=date('Y-m-d',strtotime($this->input->post('end')));
			}
			
			if($this->input->post('start')!="")
			{
				$fromdate=date('Y-m-d',strtotime($this->input->post('start')));
			}
			
			if($todate!='0' && $fromdate!='0')
			{
				$condition=$condition." `LEDGER_DATETIME1`>='$fromdate' AND `LEDGER_DATETIME1`<='$todate' AND ";
			}
			
			$condition=$condition." `LEDGER_UID`=".$this->session->userdata('profile_id');
			$condition=$condition." and `LEDGER_BALTYPE`=2 and LEDGER_DESC not in ('Cash Purchase Amount Credited','Cash Purchase Amount Debited')";
			
			$data['rid']=$this->db->query("SELECT * FROM view_ledger WHERE ".$condition);
			
			$this->load->view('common/header');
			$this->load->view('common/user_menu',$this->data);
			$this->load->view('user/view_ledger_report',$data);
			$this->load->view('common/footer');
		}
		
		/*|----------------------------------------------------------------------------------------|*/
		/*|------   REPURCHASE LEDGER REPORT OF USER     -------|*/
		/*|----------------------------------------------------------------------------------------|*/
		
		public function view_roi_ledger_report()
		{
			$condition="";
			$todate=0;
			$fromdate=0;
			
			$data['form_name'] = "Search Daily Benifit Statement";
			$data['table_name'] = "View Daily Benifit Ledger";
			$data["det"] = $this->db->query("SELECT SUM(`m_cramount`) cr, SUM(`m_dramount`) dr FROM `tr07_manage_ledger` WHERE `tr07_manage_ledger`.`m_u_id` = ".$this->session->userdata('profile_id')." and `tr07_manage_ledger`.`m_bal_type` = 3")->row();
			
			if($this->input->post('end')!="")
			{
				$todate=date('Y-m-d',strtotime($this->input->post('end')));
			}
			
			if($this->input->post('start')!="")
			{
				$fromdate=date('Y-m-d',strtotime($this->input->post('start')));
			}
			
			if($todate!='0' && $fromdate!='0')
			{
				$condition=$condition." date(`LEDGER_DATETIME1`)>=date('$fromdate') AND date(`LEDGER_DATETIME1`)<=date('$todate') AND ";
			}
			
			$condition=$condition." `LEDGER_UID`=".$this->session->userdata('profile_id');
			$condition=$condition." and `LEDGER_BALTYPE`=3";
			
			$data['rid']=$this->db->query("SELECT * FROM view_ledger WHERE ".$condition);
			$this->load->view('common/header');
			$this->load->view('common/user_menu',$this->data);
			$this->load->view('user/view_ledger_report',$data);
			$this->load->view('common/footer');
		}
		
		/*|-----------------------------------------------------|*/
		/*|------  		    BEGIN TRANSFER IN TEAM 	     -------|*/
		/*|-----------------------------------------------------|*/
		
		public function find_in_team()
		{
			$sessionid=$this->input->post('sessionid');
			$userid=$this->input->post('userid');
			$info=$this->db->query("SELECT get_member_in_team('".$sessionid."','".$userid."') as find_result");
			$row=$info->row();
			echo $row->find_result;
		}
		
		/*|---------------------------------------------------------|*/
		/*|------  		      BEGIN VIEW ALL NEWS      	     -------|*/
		/*|---------------------------------------------------------|*/
		
		public function view_all_news()
		{
			$data['form_name'] = "View All News";
			$this->db->where('m_news_status',1);
			$data['news']=$this->db->order_by("m_news_id","desc")->get('m24_news');
			$this->load->view('common/header');
			$this->load->view('common/user_menu',$this->data);
			$this->load->view('user/view_all_news',$data);
			$this->load->view('common/footer');
		}
		
		
		
		/*---------------Buy Product Report---------------*/
		
		public function view_buy_report($status = null, $buy_for = null)
		{
			$data['form_name'] = "User Order History";
			$data['table_name'] = "User Order History";
			$id = session('profile_id');
			
			$data['rec'] = $condition = "";
			$fromdate = $todate = 0;
			if($status == 0)
			{
				$status  = "";
			}
			if($this->input->post('txtfrom')!="")
			{
				$fromdate=$this->input->post('txtfrom');
			}
			
			if($this->input->post('txtto')!="")
			{
				$todate=$this->input->post('txtto');
			}
			
			if($todate != '' && $fromdate != '')
			{
				$condition = $condition." and DATE(`m27_buy_product`.`m_buy_prod_date`) >= DATE('$fromdate') and DATE(`m27_buy_product`.`m_buy_prod_date`) <= DATE('$todate') ";
			}
			
			if(post('ddmode')!="" && post('ddmode')!="0" && post('ddmode')!="-1")
			{
				$condition = $condition." and `m27_buy_product`.`m_buy_mode`= ".post('ddmode')." ";
			}  
			if(post('ddpur_for')!="" && post('ddpur_for')!="0" && post('ddpur_for')!="-1")
			{
				$condition = $condition." and `m27_buy_product`.`m_buy_for` = ".post('ddpur_for')." ";
			} 
			/*		if(post('txtbuyer_id')!="" && post('txtbuyer_id')!="0")
				{
				$condition=$condition." and `m03_user_detail`.`or_m_user_id`= '".post('txtbuyer_id')."' ";
			} */
			if($status != "")
			{
				$condition=$condition." and `m27_buy_product`.`m_buy_status`= ".$status;
			} 
			
			//$condition=$condition." and `m27_buy_product`.`m_buy_for` = ".$buy_for; 
			$condition=$condition." and `m27_buy_product`.`m_buy_for` in (1,2,3) ";
			$condition=$condition." and `m03_user_detail`.`or_m_user_id` = '".session('user_id')."' ";
			$call_procedure = ' CALL sp_user_purchase_report("'.$condition.'")';
			$data['rec']=$this->db->query($call_procedure);
			mysqli_next_result( $this->db->conn_id );
			//l();
			$this->view('view_buy_product_details',$data);
			
		}
		
		function purchase_invoice()
		{
			$condition ='';
			$invoice_id = $this->uri->segment(4);
			
			$condition = $condition." `m27_buy_product`.`m_buy_user_id` = ".session('profile_id');
			
			$condition = $condition." and `m27_buy_product`.`m_buy_invoiceid` = ".$invoice_id ;
			
			$record=array(
			'query'=>$condition
			);
			$query = " CALL sp_buy_product_details(?" . str_repeat(",?", count($record)-1) . ") ";
			$data['info']=$this->db->query($query, $record);
			mysqli_next_result( $this->db->conn_id );
			$this->load->view('User/recipt',$data);
		}
		
		function coupon_list(){
			$data['form_name'] = "Product Purchase History";
			$userid= $this->session->userdata('profile_id');
			$data['table_name'] = "Coupon List";
			$this->db->where('tr_coupan_user',$userid);
			$data['rows']=$this->db->where_in('tr_coupan_status',array('1','2'))
			->from('tr15_user_coupan')->get()->result();
			$this->load->view('common/header');
			$this->load->view('common/user_menu',$this->data);
			$this->load->view('user/coupon_list',$data);
			$this->load->view('common/footer');
		}
		
		/*---------------Buy Product Details---------------*/
		
		public function view_buy_product_here($type = null)
		{
			if($type == "3"){
				$data['form_name'] = "Retopup Here";
				$data['table_name'] = "Retopup Here";
				} elseif($type == "2"){
				$data['form_name'] = "Product Re-Purchase Here";
				$data['table_name'] = "Product Re-Purchase Here";
				} else {
				$data['form_name'] = "Product Purchase Here";
				$data['table_name'] = "Product Purchase Here";
			}
			$condition = "";
			$condition = $condition . " `m21_product_details`.`m_product_id` > 0 and `m21_product_details`.`m_product_status` = 1";
			$record = array(
			'querey' => $condition
			);
			$query = " CALL sp_product_display(?" . str_repeat(",?", count($record) - 1) . ") ";
			$data['rec'] = $this->db->query($query, $record);
			mysqli_next_result( $this->db->conn_id );
			$this->load->view('common/header');
			$this->load->view('common/user_menu',$this->data);
			$this->load->view('user/view_buy_product_here',$data);
			$this->load->view('common/footer');
		}
		
		function buy_user_product($type = null) 
		{
			//	$this->db->trans_begin();
			$id 			= $txtuserid =  session('profile_id');
			$capping 		= q("SELECT `m_user_capping` FROM `m03_user_detail` WHERE `user_reg_id` = ".$id)->row()->m_user_capping;
			$is_topup 		= q("SELECT COUNT(*) as coun FROM `tr34_retopup` WHERE `tr34_retopup`.`tr_user_id` = ".$id)->row()->coun;
			$is_pending 	= q("SELECT COUNT(*) AS coun FROM `m27_buy_product` WHERE `m27_buy_product`.`m_buy_user_id` = ".$id." AND `m_buy_status` = 2")->row()->coun;
			$tAmt_pp 		= post('tAmt_pp');
			$txt_seed_exist = post('txt_seed_exist');
			$allow = "";
			if($is_pending > 0 && $is_topup == 0) {
				error("You already have pending request(s)!");
				header('location:'.base_url().'userprofile/view_buy_product_here/'.uri(3));
				die;
			}
			if($is_topup == 0) {
				$puchase_for = 1;
			}
			else if($is_topup > 0) {
				$puchase_for = 2;
			}
			if($type == "3" && $is_topup == 0) {
				error("Do your first purchase, then come to Retopup");
				header('location:'.base_url().'userprofile/view_buy_product_here/'.uri(3));
				die;
			}
			else if($type == "3" &&  $is_topup > 0) {
				if($capping < $tAmt_pp){
					$puchase_for = 3;
					} else {
					error("Retopup PP should be above than your last purchase.");
					header('location:'.base_url().'userprofile/view_buy_product_here/'.uri(3));		
					die;	
				}
			}
			if($type == "3" && $is_topup == 2) {
				error("Retopup only two times");
				header('location:'.base_url().'userprofile/view_buy_product_here/'.uri(3));
				die;
			}
			
			
			if($txt_seed_exist == 1)
			{
				$coun_train 	= q("SELECT COUNT(*) AS coun FROM `m27_buy_product` WHERE `m_buy_user_id` = ".$id." AND `m_buy_prod_id` = ".SEED_PRODUCT_TRAINING." AND `m_buy_status` <> 3")->row()->coun;
				if($coun_train == 0 && post('txt_training_exist') == 0)
				{
					error("If you purchase Seeds then, Your purchase should contain Mushroom Farming Training.");
					header('location:'.base_url().'userprofile/view_buy_product_here/'.uri(3));
					die;						
				}
			}
			
			if($tAmt_pp >= 1500)
			{
				//	echo "working"; die;
				$coupon 	= post('coupon');
				$str 		= post('txtquid');
				$ddmode 	= (post('txtdesc') == "")?post('ddmode'):post('ddmode').": ".post('txtdesc');
				$userid 	= post('txtuserid');
				$tAmt 		= post('tAmt');
				$transid 	= get_transid();
				$invid 		= get_invoice_id(2);
				$c 			= explode(',', $str);
				$no 		= count($c);
				$image 		= '';
				if($str <> "" && $txtuserid > 0)
				{
					$taxsgst = $taxgst = $tax = 0;
					if (!empty($_FILES['image']) && $_FILES['image']['size'] > 0) 
					{
						$config['upload_path'] = 'application/uploads/';
						$config['allowed_types'] = 'gif|jpg|png|jpeg';
						$config['file_name'] = strtotime(date('YmdHis'));
						$this->load->library('upload', $config);
						if (!$this->upload->do_upload('image')) 
						{
							$this->session->flashdata('error', $this->upload->display_errors());
							print_r($this->upload->display_errors());die;
							//redirect($this->agent->referrer(), 'refresh');
						}
						else
						{
							$image = base_url() . 'application/uploads/' . $this->upload->data()['file_name'];
						}
					}
					
					for ($i = 0; $i < $no - 1; $i++)
					{
						$co = explode(',', $str);
						$co1 = explode('-', $co[$i]);
						$productid = $co1['0'];
						$txtqut = $co1['1'];
						$tax=($taxgst+$taxsgst)*$txtqut;
						if($txtuserid && $productid) 
						{
							$data = array(
							'm_buy_user_id'	 	=> $txtuserid,
							'm_buy_prod_id' 	=> $productid,
							'm_buy_qunatity' 	=> $txtqut,
							'm_buy_mode' 		=> $ddmode,
							'invoce_id' 		=> $invid,
							'store_id' 			=> 0,
							'transid' 			=> $transid,
							'receipt' 			=> $image,
							'pur_for' 			=> $puchase_for
							);
							$query = " CALL sp_user_product_request(?" . str_repeat(",?", count($data) - 1) . ")";
							$this->db->query($query, $data);
						}
					}
					success("Product Request Successfully added.");
				}
				else
				{
					error("Select At least one product!");
				}
			}
			else
			{
				error("Minimum purchase should be 1500 PP.");
			}
			/*	if( $this->db->trans_status() === FALSE){$this->db->trans_rollback();}
			else{ $this->db->trans_commit();} */
			header('location:'.base_url().'userprofile/view_buy_product_here/'.uri(3));
		}
		
		
		public function view_topup_report()
		{
			$data['form_name'] = "Associate Activation";
			$data['table_name'] = "View Associate Activation";
			$data['rid'] = $this->db->query("SELECT * FROM `view_retopup` WHERE `tr_user_id` = ".$this->session->userdata('profile_id')."");
			
			$this->load->view('common/header');
			$this->load->view('common/user_menu',$this->data);
			$this->load->view('user/view_topup_report',$data);
			$this->load->view('common/footer');
		}
		
		
		public function view_cust_topup_report()
		{
			$data['form_name'] = "Associate Activation";
			$data['table_name'] = "View Associate Activation";
			$data['rid'] = $this->db->query("SELECT * FROM `view_retopup` WHERE `tr_customer_id` = ".$this->session->userdata('profile_id'));
			
			$this->load->view('common/header');
			$this->load->view('common/user_menu',$this->data);
			$this->load->view('user/view_customer_topup_report',$data);
			$this->load->view('common/footer');
		}		
		
		public function view_topup_by_report()
		{
			$data['form_name'] = "Topup By Report";
			$data['table_name'] = "View Topup By Report";
			$data['rid'] = $this->db->where('tr_topuby',$this->session->userdata('profile_id'))->get("view_retopup");
			$this->load->view('common/header');
			$this->load->view('common/user_menu',$this->data);
			$this->load->view('user/view_topup_report',$data);
			$this->load->view('common/footer');
		}
		
		public function view_bussiness_report()
		{
			$data['form_name'] = "Member Business Report";
			$data['table_name'] = "Member Business Report";
			$data['rec'] = "";
			
			$start = $this->input->post('start');
			$end = $this->input->post('end');
			
			if($start != '' && $end != '')
			$queery = " and DATE_FORMAT(tr03_datewise_pair.`tr_date`,'%Y-%m-%d') between DATE_FORMAT('".$start."','%Y-%m-%d') and  DATE_FORMAT('".$end."','%Y-%m-%d')";
			
			if(!empty($this->input->post()))
			{
				$data['rec'] = $this->db->query("SELECT 
				SUM(`tr_today_lvol`) lvol,
				SUM(`tr_today_rvol`) rvol,
				tr_today_type,
				DATE_FORMAT(tr_date,'%Y-%m-%d') tr_date
				FROM `tr03_datewise_pair` 
				WHERE `tr03_datewise_pair`.`user_reg_id` = ".$this->session->userdata('profile_id')." $queery
				GROUP BY DATE_FORMAT(`tr_date`,'%Y-%m-%d') order by tr_date desc");
			}
			$this->load->view('common/header');
			$this->load->view('common/user_menu',$this->data);
			$this->load->view('user/view_bussiness_report',$data);
			$this->load->view('common/footer');
		}
		
		public function view_rbusiness_report()
		{
			$data['form_name'] = "Repurchase Business report";
			$data['table_name'] = "View Repurchase Business report";
			$id=$this->input->post('user_id');
			
			$userid = $this->session->userdata('profile_id');
			$data['report'] = $condition = "";
			$fromdate = $todate = 0;
			
			if($this->input->post('end') != "")
			{
				$todate=$this->input->post('end');
			}
			if($this->input->post('start') != "")
			{
				$fromdate=$this->input->post('start');
			}
			if($userid != '' && $userid != 'false')
			{
				$condition = $condition." WHERE `tr30_repurchase_datewise`.`user_reg_id` = $userid";
				if($todate!='0' && $fromdate!='0')
				{
					$condition = $condition." and date_format(`tr_re_date`,'%Y-%m-%d') >= date_format('$fromdate','%Y-%m-%d') AND date_format(`tr_re_date`,'%Y-%m-%d') <= date_format('$todate','%Y-%m-%d')";
				}
				
				if(post('ddtype') == '1')
				{
					$condition = $condition." and `tr30_repurchase_datewise`.`user_reg_id` = `tr_re_uid_by`";
				}
				else
				{
					$condition = $condition." and `tr30_repurchase_datewise`.`user_reg_id` <> `tr_re_uid_by`";					
				}
			}
			
			if($condition != "")
			{
				$data['report'] = $this->db->query("SELECT ROUND(SUM(`tr_re_today_lvol`),2) lpv, ROUND(SUM(`tr_re_today_rvol`),2) rpv,
				`tr_re_date`, `or_m_user_id`, `or_m_name` , tr_re_uid_by, `tr30_repurchase_datewise`.`user_reg_id`
				FROM `tr30_repurchase_datewise`
				LEFT JOIN `m03_user_detail`
				ON `m03_user_detail`.`user_reg_id` = `tr30_repurchase_datewise`.`user_reg_id` 
				".$condition." GROUP BY DATE_FORMAT(`tr_re_date`,'%Y-%m-%d') order by `tr_re_date` desc")->result();
			}
			
			$this->load->view('common/header');
			$this->load->view('common/user_menu',$this->data);
			$this->load->view('user/view_rbusiness_report',$data);
			$this->load->view('common/footer');
		}
		
		
		public function view_term_condition()
		{ 
			$this->load->view('common/header');
			$this->load->view('common/user_menu',$this->data);
			$this->load->view('member/view_term_condition');
			$this->load->view('common/footer');
		}
		
		/*--------------------------------------------
			----------------Upload Kyc Section------------
		----------------------------------------------*/
		
		public function view_kyc()
		{
			$data['form_name'] = "Upload KYC";
			$profile_id=$this->session->userdata('profile_id');
			$data['info'] = ''; 
			$query = $this->db->where("tr_user_id",$this->session->userdata('profile_id'))->get("tr35_kyc_status");
			$data['get_count'] = $num = $query->num_rows();
			
			if($num > 0)
			{
				$data['info'] = $query->row();
			}
			$this->load->view('common/header');
			$this->load->view('common/user_menu',$this->data);
			$this->load->view('user/view_kyc',$data);
			$this->load->view('common/footer');
		}
		
		public function upload_pan_card()
		{
			$config['upload_path']   =   "application/kyc/";
			$config['allowed_types'] =   "gif|jpg|jpeg|png|bmp";
			$config['max_size'] = '100000';
			$config['remove_spaces'] = true;
			$this->load->library('upload',$config);
			$this->upload->do_upload();
			$finfo=$this->upload->data();
			$fileupload = ($finfo['raw_name'].$finfo['file_ext']);
			$query = $this->db->where("tr_user_id",$this->session->userdata('profile_id'))->get("tr35_kyc_status");
			$num = $query->num_rows();
			if($num>0)
			{
				$data = array("tr_pannumber"=>$fileupload);
				$this->db->where("tr_user_id",$this->session->userdata('profile_id'))->update("tr35_kyc_status",$data);
			}
			else
			{
				$data = array(
				"tr_user_id"=>$this->session->userdata('profile_id'),
				"tr_pannumber"=>$fileupload,
				"tr_status"=>1,
				);
				$this->db->insert("tr35_kyc_status",$data);
			}
			redirect("userprofile/view_kyc");
		}
		
		public function upload_front_adhar()
		{
			$config['upload_path']   =   "application/kyc/";
			$config['allowed_types'] =   "gif|jpg|jpeg|png|bmp"; 
			$config['max_size'] = '100000'; 
			$config['remove_spaces'] = true;
			$this->load->library('upload',$config);
			$this->upload->do_upload();
			$finfo=$this->upload->data();
			$fileupload = ($finfo['raw_name'].$finfo['file_ext']);
			$query = $this->db->where("tr_user_id",$this->session->userdata('profile_id'))->get("tr35_kyc_status");
			$num = $query->num_rows();
			if($num>0)
			{
				$data = array("tr_address"=>$fileupload);
				$this->db->where("tr_user_id",$this->session->userdata('profile_id'))->update("tr35_kyc_status",$data);
			}
			else
			{
				$data = array(
				"tr_user_id"=>$this->session->userdata('profile_id'),
				"tr_address"=>$fileupload,
				"tr_status"=>1,
				);
				$this->db->insert("tr35_kyc_status",$data);
			}
			redirect("userprofile/view_kyc");
		}
		
		public function upload_back_adhar()
		{
			$config['upload_path']   =   "application/kyc/";
			$config['allowed_types'] =   "gif|jpg|jpeg|png|bmp"; 
			$config['max_size'] = '100000';
			$config['remove_spaces'] = true;
			$this->load->library('upload',$config);
			$this->upload->do_upload();
			$finfo=$this->upload->data();
			$fileupload = ($finfo['raw_name'].$finfo['file_ext']);
			$query = $this->db->where("tr_user_id",$this->session->userdata('profile_id'))->get("tr35_kyc_status");
			$num = $query->num_rows();
			if($num>0)
			{
				$data = array("tr_address2"=>$fileupload);
				$this->db->where("tr_user_id",$this->session->userdata('profile_id'))->update("tr35_kyc_status",$data);
			}
			else
			{
				$data = array(
				"tr_user_id"=>$this->session->userdata('profile_id'),
				"tr_address2"=>$fileupload,
				"tr_status"=>1,
				);
				$this->db->insert("tr35_kyc_status",$data);
			}
			redirect("userprofile/view_kyc");
		}
		
		public function upload_cheque_passbook()
		{
			$config['upload_path']   =   "application/kyc/";
			$config['allowed_types'] =   "gif|jpg|jpeg|png|bmp"; 
			$config['max_size'] = '100000';
			$config['remove_spaces'] = true;
			$this->load->library('upload',$config);
			$this->upload->do_upload();
			$finfo=$this->upload->data();
			$fileupload = ($finfo['raw_name'].$finfo['file_ext']);
			$query = $this->db->where("tr_user_id",$this->session->userdata('profile_id'))->get("tr35_kyc_status");
			$num = $query->num_rows();
			if($num>0)
			{
				$data = array("tr_cheque"=>$fileupload);
				$this->db->where("tr_user_id",$this->session->userdata('profile_id'))->update("tr35_kyc_status",$data);
			}
			else
			{
				$data = array(
				"tr_user_id"=>$this->session->userdata('profile_id'),
				"tr_cheque"=>$fileupload,
				"tr_status"=>1,
				);
				$this->db->insert("tr35_kyc_status",$data);
			}
			redirect("userprofile/view_kyc");
		}
		
		public function update_remove_kyc()
		{
			$id = $this->uri->segment(3);
			$file = '';
			$r = $this->db->where("tr_user_id",$this->session->userdata('profile_id'))->get('tr35_kyc_status')->row();
			
			if($id==1)
			{
				$data = array("tr_pannumber"=>'');
				$file = $r->tr_pannumber;
			}
			if($id==2)
			{
				$data = array("tr_address"=>'');
				$file = $r->tr_address;
			}
			if($id==3)
			{
				$data = array("tr_address2"=>'');
				$file = $r->tr_address2;
			}
			if($id==4)
			{
				$data = array("tr_cheque"=>'');
				$file = $r->tr_cheque;
			}
			$this->db->where("tr_user_id",$this->session->userdata('profile_id'))->update("tr35_kyc_status",$data);
			
			unlink("application/kyc/".$file);
			redirect("userprofile/view_kyc");
		}
		
		/////////////////////////////////////////
		////////////  pan report  /////////////
		/////////////////////////////////////////
		
		public function view_pan_report()
		{
			$data['form_name'] = "Pancard report";
			$data['table_name'] = "Pancard report";
			$id=$this->session->userdata('profile_id');
			
			$data['pan_report']=$this->db->query("SELECT 
			or_m_user_id, or_m_name, or_m_old_pancard, or_m_new_pancard, or_m_date 
			FROM m03_user_detail 
			LEFT JOIN `m04_user_pancard` 
			ON m03_user_detail.user_reg_id = m04_user_pancard.or_m_id 
			WHERE or_m_id='$id' ORDER BY or_m_date DESC limit 1")->result();
			
			$this->load->view('common/header');
			$this->load->view('common/user_menu',$this->data);
			$this->load->view('user/view_user_pan_report',$data);
			$this->load->view('common/footer'); 
		}
		
		/*|----------------------------------------------------------------------------------------|*/
		/*|------   REPURCHASE LEDGER REPORT OF USER     -------|*/
		/*|----------------------------------------------------------------------------------------|*/
		
		public function view_rep_ledger_report()
		{
			$condition="";
			$todate=0;
			$fromdate=0;
			
			$data['form_name'] = "Search Member Repurchase Ledger";
			$data['table_name'] = "View Member Repurchase Ledger";
			
			$data["det"] = $this->db->query("SELECT SUM(`m_cramount`) cr, SUM(`m_dramount`) dr FROM `tr07_manage_ledger` WHERE `tr07_manage_ledger`.`m_u_id` = ".$this->session->userdata('profile_id')." and `tr07_manage_ledger`.`m_bal_type` = 3")->row();
			
			if($this->input->post('end')!="")
			{
				$todate=date('Y-m-d',strtotime($this->input->post('end')));
			}
			
			if($this->input->post('start')!="")
			{
				$fromdate=date('Y-m-d',strtotime($this->input->post('start')));
			}
			
			if($todate!='0' && $fromdate!='0')
			{
				$condition=$condition." date(`LEDGER_DATETIME1`)>=date('$fromdate') AND date(`LEDGER_DATETIME1`)<=date('$todate') AND ";
			}
			
			$condition=$condition." `LEDGER_UID`=".$this->session->userdata('profile_id');
			$condition=$condition." and `LEDGER_BALTYPE`=2";
			
			$data['rid']=$this->db->query("SELECT * FROM view_ledger WHERE ".$condition);
			$this->load->view('common/header');
			$this->load->view('common/user_menu',$this->data);
			$this->load->view('user/view_ledger_report',$data);
			$this->load->view('common/footer');
		}
		
		public function update_mobile()
		{
			$id = $this->session->userdata('profile_id');			
			$this->load->view('common/header');
			$this->load->view('user/update_mobile');
		}
		
		public function verify_mobile()
		{
			$mobile = $this->input->post('txtmobile');
			$otp = random_string('numeric',4);
			
			$msg = "Your OTP for mobile no update is ".$otp;
			$this->crud_model->send_sms($mobile, $msg);
			
			$newdata = array(
			'otp'  => $otp,
			'mobile'=>$mobile,
			'logged_in' => TRUE
			);
			
			$data = $this->session->set_userdata($newdata);			
			$this->load->view('common/header');
			$this->load->view('user/verify_mobile',$data);
		}
		
		public function verify_otp()
		{
			$mobile = $this->session->userdata('mobile');
			$id = $this->session->userdata('profile_id');
			$user_opt = $this->input->post('txtotp');
			$session_opt =  $this->input->post('session_opt');
			
			if($user_opt == $session_opt)
			{
				$ct = $this->db->query("select count(*) as ct from m03_user_detail where or_m_mobile_no = '$mobile'")->row()->ct;
				if($ct <= 2)
				{
					$this->db->query("update m03_user_detail set or_m_mobile_no = '$mobile' where user_reg_id = $id");
					redirect("userprofile/dashboard");
				}
				else
				{
					$this->session->set_flashdata('error', ' Mobile No already in use');
					redirect("userprofile/update_mobile");
				}
			}
			else
			{
				redirect("userprofile/update_mobile");
			}
		}
		
		
		///////////////////// view_pv_incentive ////////////////////
		
		public function view_pv_incentive()
		{
			$data['form_name'] = "Select Date";
			$data['table_name'] = "PV BASE INCENTIVE STATEMENT ";
			$queery = '';
			$data['clsd'] = $this->db->order_by("tr_closing_id", "desc")->where("tr_closing_status !=",1)->get("tr05_closing_date");
			
			$data['closingdt'] = $currdate = $this->input->post('dddate');
			$queery = $queery." `tr04_payout_detail`.`tr_payout_ispublish` = 1 AND ";
			$queery = $queery." `tr04_payout_detail`.`user_reg_id` = ".$this->session->userdata('profile_id')." AND ";
			
			if($currdate != '' && $currdate != '-1' && $currdate != '-1')
			{
				$queery = $queery." DATE_FORMAT(tr04_payout_detail.`tr_to_payout_date`,'%Y-%m-%d') = DATE_FORMAT('$currdate','%Y-%m-%d')";
				
				$data['payout_details'] = $this->db->query("SELECT
				`tr04_payout_detail`.`user_reg_id`				AS `User_Reg`,
				`m03_user_detail`.`or_m_user_id` 				AS `Associate_Id`,
				`m03_user_detail`.`or_m_name` 					AS `Associate_Name`,
				(SELECT `m_des_short` FROM `m03_designation` WHERE `m_des_id` = `m03_user_detail`.`or_m_designation`)   AS design,
				`tr04_payout_detail`.`tr_to_payout_date`		AS `To_Date`,
				`tr04_payout_detail`.`tr_payout_type`			AS `Payout_Type`,
				`tr04_payout_detail`.`tr_payout_level` 			AS `Payout_Level`,
				`tr04_payout_detail`.`tr_payout_amount` 		AS `Payout_Amount`,
				`tr04_payout_detail`.`tr_previous_lcarry`  		AS `Payout_PreLcarry`,
				`tr04_payout_detail`.`tr_previous_rcarry`  		AS `Payout_PreRcarry`,
				`tr04_payout_detail`.`tr_payout_lcarry`  		AS `Payout_Lcarry`,
				`tr04_payout_detail`.`tr_payout_rcarry`  		AS `Payout_Rcarry`,
				`tr04_payout_detail`.`tr_payout_tot_lft`  		AS `Payout_Total_leftpayout`,
				`tr04_payout_detail`.`tr_payout_tot_rht`  		AS `Payout_Total_rightpayout`,
				`tr04_payout_detail`.`tr_payout_pair`  			AS `TOTAL_PAIR`,
				`tr04_payout_detail`.`tr_payout_admincharges` 	AS `Admin_Charges`,
				`tr04_payout_detail`.`tr_payout_tdscharges` 	AS `TDS_Charges`,
				`tr04_payout_detail`.`tr_payout_proce_charge`	AS `Processing_charge`,
				`tr04_payout_detail`.`tr_payout_final_income` 	AS `Final_Amount`,
				`tr04_payout_detail`.`tr_payout_paidpair`		AS `paidpair`
				FROM (`tr04_payout_detail`
				LEFT JOIN `m03_user_detail`
				ON (`tr04_payout_detail`.`user_reg_id` = `m03_user_detail`.`user_reg_id`)) where $queery");
				
				$fromdt = $this->db->query("SELECT MAX(`tr_closing_date`) as fromdt FROM `tr05_closing_date` WHERE DATE(`tr_closing_date`) < DATE('$currdate')")->row()->fromdt;
				
				$data['direct'] = $this->db->query("SELECT SUM(`tr_payout_amount`) as amount, SUM(`tr_payout_admincharges`) as admin,
				SUM(`tr_payout_tdscharges`) as tds,
				SUM(`tr_payout_final_income`) as final_amt, SUM(`tr_payout_proce_charge`) as eshop
				FROM `tr04_payout_detail` WHERE `tr_payout_type` = 2 AND `user_reg_id` = ".session('profile_id')."
				AND DATE(`tr_to_payout_date`) > DATE('$fromdt') AND DATE(`tr_to_payout_date`) <= DATE('$currdate')")->row();
			}
			
			$this->load->view('common/header');
			$this->load->view('common/user_menu',$this->data);
			$this->load->view('user/view_pv_incentive',$data);
			$this->load->view('common/footer');
		}
		
		
		function tree_view_level($id = null)
		{
			$data["form_name"] = "Tree View";
			
			if($this->input->post('search_id') <> '')
			{
				$id = get_uid($this->input->post('search_id'));
			}
			if($id <> "")
			{
				$res = $this->member_model->scan_team($id);
			}
			else
			{
				$id = $this->session->userdata('profile_id');
				$res = 'true';
			}
			if($res == 'true')
			{
				$data['result'] = $this->user_model->user_tree_level($id);
			}
			elseif($res == 'false')
			{
				error("User Id not in your team!");
				$id = $this->session->userdata('profile_id');
				$data['result'] = $this->user_model->user_tree_level($id);
			}
			else
			{
				$id = $this->session->userdata('profile_id');
				$data['result'] = $this->user_model->user_tree_level($id);
			}
			$this->load->view('common/header');
			$this->load->view('common/user_menu');
			$this->load->view('user/tree_view_level', $data);
			$this->load->view('common/footer');
		}
		
		public function viewOrders()
		{
			$id = $this->session->userdata('profile_id');
			$data['form'] 		= "Purchase Detail";
			$data['table'] 	= "Purchase";
			/* $data['purchase']= $this->db->query("SELECT `tr04_purchase`.*,user_name AS NAME FROM `tr04_purchase` JOIN `m03_user_detail`ON `tr04_purchase`.pur_reg_id=`m03_user_detail`.user_reg_id where pur_reg_id=$id")->result(); */			
			
			$data['purchase']= q("SELECT `tr06_order_detail`.*,user_name AS NAME,`user_u_id` AS uid, SUM(order_discount_amt) AS discount, SUM(order_delivery_charges) AS delivery_charge,SUM(order_amt) AS order_amt1,SUM(order_payble_amt) AS pay_amt FROM `tr06_order_detail` left JOIN `m03_user_detail`ON `tr06_order_detail`.`order_reg_id`=`m03_user_detail`.user_reg_id LEFT JOIN `tr04_purchase` ON `tr06_order_detail`.`order_trans_id` = `tr04_purchase`.`pur_order_trans_id` WHERE `tr04_purchase`.`pur_reg_id` = $id GROUP BY `tr04_purchase`.`pur_order_trans_id` order by order_id desc")->result();
			// echo $this->db->last_query();die;
			$this->load->view('common/header');
			$this->load->view('common/user_menu');
			$this->load->view('user/view_purchase_detail',$data);
			$this->load->view('common/footer');			
		}
		
		public function prodcut_summery()
		{
			
			$data['form'] 	= "Product Order Summery";
			$data['table'] 	= "Product Order";
			$condition="";
			$uid = $this->session->userdata('profile_id');
			$id = $this->uri->segment(3);
			$data['invoice'] = $id;
			if(!empty($this->input->post()))
			{
				$condition=$condition."`tr04_purchase`.`pur_current_status` =".$this->input->post('dd_status');
			}
			
			
			//$data['rid'] = $this->db->query("SELECT `tr04_purchase`.*,user_name AS NAME FROM `tr04_purchase` JOIN `m03_user_detail`ON `tr04_purchase`.pur_reg_id=`m03_user_detail`.user_reg_id where pur_order_trans_id = $id and `tr04_purchase`.`pur_reg_id` = $uid")->result();
			$this->load->model('Member_model');
			$data['purchase'] = $this->Member_model->view_order_details($id);
			
			$this->load->view('common/header');
			$this->load->view('common/user_menu');
			$this->load->view('user/prodcut_summery',$data);
			$this->load->view('common/footer');
			
		}
		public function view_purchase_histroy()
		{
			
			$data['form'] 	= "Product Order Summary";
			$data['table'] 	= "Product Order";
			$id = $this->uri->segment(3);
			$uid = $this->session->userdata('profile_id');
			$data['transid'] = $id;
			$data['rid'] = $this->db->query("SELECT * from v15_product_purchase_all where pur_all_trans_id = $id and pur_all_reg_id = $uid GROUP BY pur_all_variant_id, pur_all_type")->result();
			
			$this->load->view('common/header');
			$this->load->view('common/user_menu');
			$this->load->view('user/view_purchase_histroy',$data);
			$this->load->view('common/footer');
			
		}
		
		public function viewOrderInvoice($id){
			
			$this->load->model('Member_model');
			$data = $this->Member_model->view_purchase_details($id);
			$data['purchase']= $this->db->query("select * from v14_product_purchase where pur_trans_id=$id")->row();
 			$data['product']= $this->db->query("SELECT * from v15_product_purchase_all WHERE pur_all_trans_id = $id GROUP BY pur_all_id")->result();

			$this->load->view('common/header');
		    $this->load->view('common/user_menu');
			$this->load->view('user/invoice',$data);
			$this->load->view('common/footer');
		}
		
		
		
		public function view_purchase_details($id)
		{			
			$this->load->model('Member_model');
			$data = $this->Member_model->view_purchase_details($id);
			
			$this->load->view('common/header');
		    $this->load->view('common/user_menu');
			$this->load->view('user/invoice',$data);
			$this->load->view('common/footer');
		}
		
		public function view_order_details($id)
		{			
			$this->load->model('Member_model');
			$data = $this->Member_model->view_order_details($id);
			$this->load->view('common/header');
		    $this->load->view('common/user_menu');
			$this->load->view('user/invoice2',$data);
			$this->load->view('common/footer');
		}

		function wallet_transactions(){
			$data['form']="Wallet Transection";
			$data["data"] = $this->db->where("m_u_id",$this->session->userdata("profile_id"))->order_by("m_datetime","desc")->get("tr07_manage_ledger")->result();
			
			$this->load->view('common/header');
		    $this->load->view('common/user_menu');
			$this->load->view('user/wallet_transactions',$data);
			$this->load->view('common/footer');
		}
	}
?>						