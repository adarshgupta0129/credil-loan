<?php 
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Member extends CI_Controller {
		
		/////////////////////////////////////////////////////////////////////////
		//////////     Constructor In Member Controller    ///////
		//////////////////////////////////////////////////////////////////////
		
		public function __construct()
		{
			parent::__construct();
			$this->_is_logged_in();
			$this->data['page'] = "Member Panel";
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
		
		public function index()
		{
			header("Location:".base_url()."master/view_mainconfig");
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
			$this->load->view('Member/'.$page_name, $data);
			$this->load->view('common/footer');		
		}

		/*|-----------------------------------------|*/
		/*|------     USER REGISTRATION      -------|*/
		/*|-----------------------------------------|*/
		
		public function join_member()
		{
			$data['form_name'] = "Member Joining";
			
			$this->db->where('m_parent_id',1);
			$this->db->where('m_status',1);
			$data['state']=$this->db->get('m02_location');
			
			$data['bank']=$this->db->where("m_bank_status",1)->get('m01_bank');
			
			$this->db->where('m_pack_status',1);
			$data['pack']=$this->db->where('m_pack_id',1)->get('m06_package');
			
			$this->view('registration',$data);
		}
		
		// -------------USER REGISTRATION INSERTION---------------
		
		public function register_candidate()
		{
			$output = $this->member_model->signup();
			echo $output;
		}
		
		// -------------USER DETAILS UPDATION VIEW---------------
		
		public function view_member_edit()
		{	
			$data['form_name'] = "Edit Member";
			
			$data['uid'] = $uid = $this->input->post('txtlogin');
			if(!$uid)
			{
				$data['uid'] = $uid = get_user_id_by_reg_id(uri(3));
			}
			$data['rec'] = '';
			
			if($uid != '')
			{
				$this->db->where('m_parent_id',1);
				$this->db->where('m_status',1);
				$data['state']=$this->db->get('m02_location');
				
				$id = get_uid($uid);
				
				$condition = "`m03_user_detail`.`or_m_reg_id` = '".$id."'";
				$call_procedure = ' CALL sp_member_detail("'. $condition .'")';
				$data['rec'] = $this->db->query($call_procedure)->row();
				mysqli_next_result( $this->db->conn_id );
			}
			$this->view('view_member_edit',$data);
		}
		
		// -------------USER DETAILS UPDATION---------------
		
		public function update_member()
		{
			$this->member_model->update_member();
			$this->session->set_flashdata('success','Profile Updated Successfully!!');
			header("Location:".base_url()."member/view_member_edit");
		}
		
		/*|--------------------------------------|*/
		/*|------     VIEW USER PROFILE   -------|*/
		/*|--------------------------------------|*/
		
		public function view_member_details()
		{	
			$data['form_name'] = "View Member Profile";
			$data['uid'] = $uid = $this->input->post('txtlogin');
			
			$data['rec'] = '';
			if($uid)
			{
				$id = get_uid($uid);
				$condition = "`m03_user_detail`.`or_m_reg_id` = '".$id."'";
				$call_procedure = ' CALL sp_member_detail("'. $condition .'")';
				$data['rec'] = $this->db->query($call_procedure)->row();
				mysqli_next_result( $this->db->conn_id );
			}	
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('Member/view_member_details',$data);
			$this->load->view('common/footer');
		}
		
		/*|------------------------------------------|*/
		/*|------     USER SEARCH MEMEBR      -------|*/
		/*|------------------------------------------|*/
		
		public function view_all_member()
		{
			$data['form_name'] = "View Search Member";
			$data['table_name'] = "View All Member";
			
			$todate=0;
			$fromdate=0;
			$condition='';
			$data['rank'] = $this->db->get('m03_designation');
			if($this->input->post('start')!="")
			{
				$fromdate=$this->input->post('start');
			}
			
			if($this->input->post('end')!="")
			{
				$todate=$this->input->post('end');
			}
			
			if($todate!='0' && $fromdate!='0')
			{
				$condition=$condition."`m03_user_detail`.`or_member_joining_date` >= DATE_FORMAT('$fromdate','%Y-%m-%d') and `m03_user_detail`.`or_member_joining_date` <= DATE_FORMAT('$todate','%Y-%m-%d')and ";
			}
			if($this->input->post('txtlogin')!="" && $this->input->post('txtlogin')!="0")
			{
				$id=get_uid($this->input->post('txtlogin'));
				$condition=$condition." `m03_user_detail`.`or_m_reg_id`= ".$id."  and";
			}			
			if($this->input->post('txtmob')!="" && $this->input->post('txtmob')!="0")
			{
				$condition=$condition." `m03_user_detail`.`or_m_mobile_no`= ".$this->input->post('txtmob')."  and";
			}
			if($this->input->post('txtname')!="" && $this->input->post('txtname')!="0")
			{
				$condition=$condition." `m03_user_detail`.`or_m_name`= '".$this->input->post('txtname')."'  and";
			}
			if($this->input->post('ddtype')!="-1" && $this->input->post('ddtype')!="")
			{
				$condition=$condition." `m03_user_detail`.`or_m_designation`= '".$this->input->post('ddtype')."'  and";
			}
			if(count($this->input->post()) == 0)
			{
				$condition=$condition."DATE_FORMAT(`m03_user_detail`.`or_member_joining_date`,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d') and ";
			}
			
			$condition=$condition." `m03_user_detail`.`or_m_reg_id` !=0 ";
			$condition=$condition." ORDER BY `m03_user_detail`.`or_m_reg_id` DESC";
			
			$call_procedure = ' CALL sp_member_detail_lite("'.$condition.'")';
			$data['rid']=$this->db->query($call_procedure);
			mysqli_next_result( $this->db->conn_id );
			
			$this->view('view_all_member',$data);
		}
		
		
		/*|--------------------------------------------|*/
		/*|------     USER RESEND MESSAGE       -------|*/
		/*|--------------------------------------------|*/
		
		public function resend_msg($id)
		{
			$data = $this->db->query(" CALL sp_member_detail('m03_user_detail.or_m_reg_id =".$id."')")->row();
			mysqli_next_result( $this->db->conn_id );
			if($data->Mobile_No != '')
			{
				$msg1="Dear ".$data->Associate_Name." Thanks for register with ".SITE_NAME.". Your Username : ".$data->Login_Id.",
				Password : ".$data->Password.", URL : ".WEBSITE_NAME;
				if(SMS_SEND_STATUS==1)
                $this->crud_model->send_sms(trim($data->Mobile_No),$msg1);
			}
			header("location:".base_url()."member/view_all_member");
		}
		
		/*|--------------------------------------------|*/
		/*|------     USER ACTIVATION VIEW      -------|*/
		/*|--------------------------------------------|*/
		
		public function view_activate_members()
		{
			$data['form_name'] = "Activate Member";
			$data['table_name'] = "View Deactive Member";
			
			$todate=0;
			$fromdate=0;
			$data['rec'] = $condition = '';
			
			if($this->input->post('start')!="")
			{
				$fromdate=$this->input->post('start');
			}
			
			if($this->input->post('end')!="")
			{
				$todate=$this->input->post('end');
			}
			
			if($todate!='0' && $fromdate!='0')
			{
				$condition=$condition."`m03_user_detail`.`or_member_joining_date` >= DATE_FORMAT('$fromdate','%Y-%m-%d') and `m03_user_detail`.`or_member_joining_date` <= DATE_FORMAT('$todate','%Y-%m-%d')and ";
			}
			if($this->input->post('txtlogin')!="" && $this->input->post('txtlogin')!="0")
			{
				$id=get_uid($this->input->post('txtlogin'));
				$condition=$condition." `m03_user_detail`.`or_m_reg_id`= ".$id."  and";
			}			
			if($this->input->post('txtmob')!="" && $this->input->post('txtmob')!="0")
			{
				$condition=$condition." `m03_user_detail`.`or_m_mobile_no`= ".$this->input->post('txtmob')."  and";
			}
			if($this->input->post('txtname')!="" && $this->input->post('txtname')!="0")
			{
				$condition=$condition." `m03_user_detail`.`or_m_name`= '".$this->input->post('txtname')."'  and";
			}
			if($this->input->post('ddtype')!="-1" && $this->input->post('ddtype')!="")
			{
				$condition=$condition." `m03_user_detail`.`or_m_designation`= '".$this->input->post('ddtype')."'  and";
			}
			
			if($condition)
			{
				$condition=$condition." `m03_user_detail`.`or_m_status` = 0 ";
				$condition=$condition." ORDER BY `m03_user_detail`.`or_m_reg_id` DESC";
				
				$call_procedure = ' CALL sp_member_detail_lite("'.$condition.'")';
				$data['rec']=$this->db->query($call_procedure);
				mysqli_next_result( $this->db->conn_id );
			}
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('member/view_activate_member',$data);
			$this->load->view('common/footer');
		}
		
		/*-------------ACTIVATE USER-------------------*/
		
		public function update_activate_member()
		{
			$regid=$this->input->post('txtquid');
			$this->db->query("CALL sp_change_status_of_user('".$regid."',1)");
			$this->session->set_flashdata('success','Member Activated Successfully!!');
			header("Location:".base_url()."member/view_activate_members");
		}
		
		/*|----------------------------------------------|*/
		/*|------     USER DEACTIVATION VIEW      -------|*/
		/*|----------------------------------------------|*/
		
		public function view_deactivate_members()
		{
			$data['form_name'] = "Deactivate Member";
			$data['table_name'] = "View Active Member";
			$todate=0;
			$fromdate=0;
			$data['rec'] = $condition='';
			
			if($this->input->post('start')!="")
			{
				$fromdate=$this->input->post('start');
			}
			
			if($this->input->post('end')!="")
			{
				$todate=$this->input->post('end');
			}
			
			if($todate!='0' && $fromdate!='0')
			{
				$condition=$condition."`m03_user_detail`.`or_member_joining_date` >= DATE_FORMAT('$fromdate','%Y-%m-%d') and `m03_user_detail`.`or_member_joining_date` <= DATE_FORMAT('$todate','%Y-%m-%d')and ";
			}
			if($this->input->post('txtlogin')!="" && $this->input->post('txtlogin')!="0")
			{
				$id=get_uid($this->input->post('txtlogin'));
				$condition=$condition." `m03_user_detail`.`or_m_reg_id`= ".$id."  and";
			}			
			if($this->input->post('txtmob')!="" && $this->input->post('txtmob')!="0")
			{
				$condition=$condition." `m03_user_detail`.`or_m_mobile_no`= ".$this->input->post('txtmob')."  and";
			}
			if($this->input->post('txtname')!="" && $this->input->post('txtname')!="0")
			{
				$condition=$condition." `m03_user_detail`.`or_m_name`= '".$this->input->post('txtname')."'  and";
			}
			if($this->input->post('ddtype')!="-1" && $this->input->post('ddtype')!="")
			{
				$condition=$condition." `m03_user_detail`.`or_m_designation`= '".$this->input->post('ddtype')."'  and";
			}
			
			if($condition)
			{
				$condition=$condition." `m03_user_detail`.`or_m_status` = 1 ";
				$condition=$condition." ORDER BY `m03_user_detail`.`or_m_reg_id` DESC";
				
				$call_procedure = ' CALL sp_member_detail_lite("'.$condition.'")';
				$data['rec']=$this->db->query($call_procedure);
				mysqli_next_result( $this->db->conn_id );
			}
			
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('member/view_deactivate_member',$data);
			$this->load->view('common/footer');
		}
		
		public function view_block_members()
		{
			$data['form_name'] = "Block Member";
			$data['table_name'] = "View Block Member";
			$todate=0;
			$fromdate=0;
			$data['rec'] = $condition='';
			
			if($this->input->post('start')!="")
			{
				$fromdate=$this->input->post('start');
			}
			
			if($this->input->post('end')!="")
			{
				$todate=$this->input->post('end');
			}
			
			if($todate!='0' && $fromdate!='0')
			{
				$condition=$condition."`m03_user_detail`.`or_member_joining_date` >= DATE_FORMAT('$fromdate','%Y-%m-%d') and `m03_user_detail`.`or_member_joining_date` <= DATE_FORMAT('$todate','%Y-%m-%d')and ";
			}
			if($this->input->post('txtlogin')!="" && $this->input->post('txtlogin')!="0")
			{
				$id=get_uid($this->input->post('txtlogin'));
				$condition=$condition." `m03_user_detail`.`or_m_reg_id`= ".$id."  and";
			}			
			if($this->input->post('txtmob')!="" && $this->input->post('txtmob')!="0")
			{
				$condition=$condition." `m03_user_detail`.`or_m_mobile_no`= ".$this->input->post('txtmob')."  and";
			}
			if($this->input->post('txtname')!="" && $this->input->post('txtname')!="0")
			{
				$condition=$condition." `m03_user_detail`.`or_m_name`= '".$this->input->post('txtname')."'  and";
			}
			if($this->input->post('ddtype')!="-1" && $this->input->post('ddtype')!="")
			{
				$condition=$condition." `m03_user_detail`.`or_m_designation`= '".$this->input->post('ddtype')."'  and";
			}
			
			if($condition)
			{
				$condition=$condition." ORDER BY `m03_user_detail`.`or_m_reg_id` DESC";
				
				$call_procedure = ' CALL sp_member_detail_lite("'.$condition.'")';
				$data['rec']=$this->db->query($call_procedure);
				mysqli_next_result( $this->db->conn_id );
			}
			
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('member/view_block_members',$data);
			$this->load->view('common/footer');
		}
		
		
		
		/*-------------DEACTIVATE USER-------------------*/
		
		public function update_block_member()
		{
			$regid=$this->input->post('txtquid');
			$this->db->query("CALL sp_change_status_of_user('".$regid."',3)");
			
			$this->session->set_flashdata('success','Member Blocked Successfully!!');
			header("Location:".base_url()."member/view_block_members");
		}
		
		public function update_deactivate_member()
		{
			$regid=$this->input->post('txtquid');
			$this->db->query("CALL sp_change_status_of_user('".$regid."',2)");
			
			$this->session->set_flashdata('success','Member Deactivated Successfully!!');
			header("Location:".base_url()."member/view_deactivate_members");
		}
		
		/*|-----------------------------------------------------|*/
		/*|------   ADD BANK DETAILS      -------|*/
		/*|-----------------------------------------------------|*/
		
		public function view_bank_details()
		{
			$data['form_name'] = "View Bank Details";
			$data['table_name'] = "Update Bank Details";
			
			$data['bank'] = $this->db->where("m_bank_status",1)->get("m01_bank");
			
			$todate=0;
			$fromdate=0;
			$condition='';
			
			if($this->input->post('start')!="")
			{
				$fromdate=$this->input->post('start');
			}
			
			if($this->input->post('end')!="")
			{
				$todate=$this->input->post('end');
			}
			
			if($todate!='0' && $fromdate!='0')
			{
				$condition=$condition."`m03_user_detail`.`or_member_joining_date` >= DATE_FORMAT('$fromdate','%Y-%m-%d') and `m03_user_detail`.`or_member_joining_date` <= DATE_FORMAT('$todate','%Y-%m-%d')and ";
			}
			if($this->input->post('txtlogin')!="" && $this->input->post('txtlogin')!="0")
			{
				$id=get_uid($this->input->post('txtlogin'));
				$condition=$condition." `m03_user_detail`.`or_m_reg_id`= ".$id."  and";
			}			
			if($this->input->post('txtmob')!="" && $this->input->post('txtmob')!="0")
			{
				$condition=$condition." `m03_user_detail`.`or_m_mobile_no`= ".$this->input->post('txtmob')."  and";
			}			
			if($this->input->post('txtspancard') != "" && $this->input->post('txtspancard') != "0")
			{
				$condition=$condition." `m04_user_bank`.`or_m_b_pancard`= '".$this->input->post('txtspancard')."'  and";
			}			
			if($this->input->post('txtname')!="" && $this->input->post('txtname')!="0")
			{
				$condition=$condition." `m03_user_detail`.`or_m_name` like '%".$this->input->post('txtname')."%'  and";
			}
			if($condition != "")
			{
				$condition=$condition." `m03_user_detail`.`or_m_status` = 1 ";
				$call_procedure = ' CALL sp_member_detail("'.$condition.'")';
				$data['bank_details']=$this->db->query($call_procedure);
				mysqli_next_result( $this->db->conn_id );
			}
			
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('member/view_bank_details',$data);
			$this->load->view('common/footer');
		}
		
		public function update_bank_details()
		{
			$this->member_model->update_bank_details();
			$this->session->set_flashdata('success','Bank Details Updated Successfully!!');
			header("Location:".base_url()."member/view_bank_details");
		}
		
		
		/*|--------------------------------------------------|*/
		/*|------     	USER UPDATE PASSWORD	      -------|*/
		/*|--------------------------------------------------|*/
		
		
		public function change_password()
		{
			$data['form_name'] = "Change Password";
			$data['table_name'] = "View All Member";
			
			$todate=0;
			$fromdate=0;
			$condition='';
			
			if($this->input->post('start')!="")
			{
				$fromdate=$this->input->post('start');
			}
			
			if($this->input->post('end')!="")
			{
				$todate=$this->input->post('end');
			}
			
			if($todate!='0' && $fromdate!='0')
			{
				$condition=$condition."`m03_user_detail`.`or_m_regdate` BETWEEN DATE_FORMAT('$fromdate','%Y-%m-%d') and DATE_FORMAT('$todate','%Y-%m-%d') and ";
			}
			
			if($this->input->post('txtlogin')!="" && $this->input->post('txtlogin')!="0")
			{
				$id=get_uid($this->input->post('txtlogin'));
				$condition=$condition." `m03_user_detail`.`or_m_reg_id`= ".$id."  and";
			}
			
			if($this->input->post('txtmob')!="" && $this->input->post('txtmob')!="0")
			{
				$condition=$condition." `m03_user_detail`.`or_m_mobile_no`= ".$this->input->post('txtmob')."  and";
			} 
			
			if($this->input->post('txtemail')!="" && $this->input->post('txtemail')!="0")
			{
				$condition=$condition." `m03_user_detail`.`or_m_email`= '".$this->input->post('txtemail')."'  and";
			}
			
			if(count($this->input->post()) == 0)
			{
				$condition=$condition."DATE_FORMAT(`m03_user_detail`.`or_member_joining_date`,'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d') and ";
			}
			
			$condition=$condition." `m03_user_detail`.`or_m_reg_id` !=0 ";
			$condition=$condition." ORDER BY `m03_user_detail`.`or_m_reg_id` DESC";
			
			$call_procedure = ' CALL sp_member_detail("'.$condition.'")';
			$data['rid']=$this->db->query($call_procedure);
			mysqli_next_result( $this->db->conn_id );
			
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('Member/view_change_password',$data);
			$this->load->view('common/footer');
		}
		
		/*-------------UPDATE PASSWORD---------------*/
		
		public function update_password($id)
		{
			$ulgpd=array(
            'or_login_pwd'=>$this->input->post('txtnew')
			);
			$this->db->where('or_user_id',$id);
			$this->db->update('tr01_login',$ulgpd);
			
			$this->db->where('or_user_id',$id);
			$login = $this->db->get('tr01_login')->row();
			
			$this->db->where('or_m_reg_id',$id);
			$email = $this->db->get('m03_user_detail')->row();
			
			$msg = "Welcome To ".SITE_NAME.", Your UID is ".$login->or_login_id.", Password ".$login->or_login_pwd." and Tr. password ".$login->or_pin_pwd.".  Thanks for Choosing ".WEBSITE_NAME;
			
			$this->crud_model->send_sms(trim($email->or_m_mobile_no),$msg);
			
			$this->session->set_flashdata('success','Password Updated Successfully!!');
			header("Location:".base_url()."member/change_password");
		}
		
		/*|---------------------------------------------------------------------|*/
		/*|------    			  LEDGER REPORT OF USER            		 -------|*/
		/*|---------------------------------------------------------------------|*/
		
		public function view_ledger_report()
		{
			$condition="";
			$todate=0;
			$fromdate=0;
			
			$data['form_name'] = "Search Member Ledger";
			$data['table_name'] = "View Member Ledger";
			
			$uid = get_uid(post('txtuserid'));
			
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
			
			if($uid !='false')
			{
				$condition=$condition." `LEDGER_UID` = $uid AND ";
			}
			
			
			if($condition != '')
			{
				$condition=$condition." `LEDGER_UID` != 0 AND";
				$condition=$condition." `LEDGER_BALTYPE` = 1 ";
				
				$data['rid']=$this->db->query("SELECT * FROM view_ledger WHERE ".$condition);
			}
			
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('member/view_ledger_report',$data);
			$this->load->view('common/footer');
		}
		
		
		/*|------------------------------------------------|*/
		/*|------  			ADMIN REPLY      		-------|*/
		/*|------------------------------------------------|*/
		
		public function view_admin_reply()
		{
			$data['form_name'] = "Admin Reply";
			$data['table_name'] = "View Member Ticket";
			
			$this->db->where('TICKET_STATUS_ID',1);
			$this->db->where('TICKET_REPLY','');
			$data['rec']=$this->db->order_by("TICKET_ID","desc")->get('view_ticket');
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('member/view_admin_reply',$data);
			$this->load->view('common/footer');
		}
		
		/*-------------DEACTIVATE TICKET---------------*/
		
		public function deactive_ticket()
		{
			$data=array(
            'tr_ticket_id'=>$this->uri->segment(3),
            'tr_ticket_userid'=> '',
            'tr_ticket_title'=>'',
            'tr_ticket_desc'=>'',
            'tr_ticket_reply'=>'',
            'tr_ticket_status'=>$this->uri->segment(4),
            'tr_ticket_date'=>'',
            'proc'=>3
			);
			$query = " CALL sp_ticket(?" . str_repeat(",?", count($data)-1) . ",@msg) ";
			$this->db->query($query, $data);
			$query1=$this->db->query("SELECT @msg as message");
			$row = $query1->row()->message;
			$this->session->set_flashdata('success',$row);
			header("Location:".base_url()."member/view_admin_reply");
		}
		
		/*-------------UPDATE REPLY---------------*/
		
		public function update_reply()
		{
			$data=array(
            'tr_ticket_id'=>trim($this->input->post('txtid')),
            'tr_ticket_userid'=> '',
            'tr_ticket_title'=>'',
            'tr_ticket_desc'=>'',
            'tr_ticket_reply'=>trim($this->input->post('txtreply')),
            'tr_ticket_status'=>'',
            'tr_ticket_date'=>'',
            'proc'=>2
			);
			$query = " CALL sp_ticket(?" . str_repeat(",?", count($data)-1) . ",@msg) ";
			$this->db->query($query, $data);
			$query1=$this->db->query("SELECT @msg as message");
			$row = $query1->row()->message;
			$this->session->set_flashdata('success',$row);
			header("Location:".base_url()."member/view_admin_reply");
		}
				
		public function customers(){			
			
			$data['customer']=$this->db->query("SELECT cus.user_reg_id,cus.user_name,cus.user_joining_date,cus.user_gender,cus.user_email,cus.user_mobile_no,cus.user_address_p,cus.user_pincode,intro.`user_mobile_no` AS  intro_mobile,intro.`user_name` AS intro FROM m03_user_detail AS cus INNER JOIN m03_user_detail AS intro ON intro.`user_reg_id`=cus.user_intr_id  WHERE cus.user_designation = 'Customer'")->result();
			
			$this->load->view('common/header');
		    $this->load->view('common/menu');
			$this->load->view('member/customer_detail',$data);
			$this->load->view('common/footer');
		}
		
	}
?>