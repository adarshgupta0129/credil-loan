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
 			if(uri(3)!='to_pdf'){
				if($page_name <> null) {
					$this->load->view('common/header');
					if(session('usertype') == "4") {
						$this->data['menu'] = $this->db->query("SELECT * FROM `tr36_menu` WHERE `menu_id` IN (SELECT as_parent_id FROM `view_all_assigned_menu` WHERE `as_sub_admin` = ".session('profile_id')." and menu_status = 1 GROUP BY as_parent_id) ORDER BY `menu_id`");
						$this->load->view('common/subadmin_menu', $this->data);
						} else {
						$this->load->view('common/menu', $this->data);
					}
					$this->load->view('Member/'.$page_name, $data);
					$this->load->view('common/footer');
					} else {
					header("Location:".APP_URL."master/dashboard");
				} 
				} else {
				$this->crud_model->topdf('Member/'.$page_name,array_merge($data,$this->data),'ctoc');
			}			
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
		
		// -------------USER REGISTRATION INSERTION---------------
		
		public function view_member_topup()
		{
			$data['form_name'] = "Member Topup";
			$data['table_name'] = "View Topup Report";
			$data['pack'] = $this->db->where('m_pack_status',1)->get("m06_package");
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('Member/view_member_topup',$data);
			$this->load->view('common/footer');
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
		
		/*-------------DEACTIVATE USER-------------------*/
		
		public function deactivate_member_via_bank($id = null)
		{
			$regid = $id;
			$this->db->query("CALL sp_change_status_of_user('".$regid."',2)");
			
			$this->session->set_flashdata('success','Member Deactivated Successfully!!');
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
		
		/*-------------UPDATE PIN PASSWORD---------------*/
		
		public function update_pin_password($id)
		{
			$ulgpd=array(
            'or_pin_pwd'=>$this->input->post('txtnew')
			);
			$this->db->where('or_user_id',$id);
			$this->db->update('tr01_login',$ulgpd);
			
			$this->db->where('or_user_id',$id);
			$login = $this->db->get('tr01_login')->row();
			
			$this->db->where('or_m_reg_id',$id);
			$email = $this->db->get('m03_user_detail')->row();
			
			$msg = "Welcome To ".SITE_NAME.", Your UID is ".$login->or_login_id.", Password ".$login->or_login_pwd." and Tr. password ".$login->or_pin_pwd.".  Thanks for Choosing ".WEBSITE_NAME;
			
			$this->crud_model->send_sms(trim($email->or_m_mobile_no),$msg);
			
			$this->session->set_flashdata('success','Transaction Password Updated Successfully!!');
			header("Location:".base_url()."member/change_password");
		}
		
		/*|---------------------------------------------------------|*/
		/*|------  		     USER DIRECT REFFERAL            -------|*/
		/*|---------------------------------------------------------|*/
		
		public function view_direct_referal()
		{
			$data['form_name'] = "Search Direct Referal";
			$data['table_name'] = "View Direct Referal";
			
			$data['rec'] = '';
			$condition = '';
			$this->input->post('txtuserid');
			if($this->input->post('txtuserid'))
			{
				$id = get_uid($this->input->post('txtuserid'));
				$condition = "`m03_user_detail`.`or_m_intr_id` = $id ";
				
				$call_procedure = ' CALL sp_member_detail("'.$condition.'")';
				$data['rec'] = $this->db->query($call_procedure); 
				mysqli_next_result( $this->db->conn_id );
			}
			
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('member/view_direct_referal',$data);
			$this->load->view('common/footer');
		}
		
		/*|--------------------------------------------------------|*/
		/*|------        			USER DIRECT DOWNLINE   	    -------|*/
		/*|--------------------------------------------------------|*/
		
		public function view_direct_downline()
		{
 			$data['rec'] = '';
			$data['form_name'] = "Direct Team Member";
			$data['table_name'] = "View Direct Team Member";
 			
        	if(post('txtuserid'))
			{
				$uid = get_uid(post('txtuserid')); 
				if($uid)
				{
					$data['rec'] = $this->db->query("CALL`get_intro_downline`($uid);");					
					mysqli_next_result( $this->db->conn_id );
				}
			}
			$this->view('view_direct_downline',$data);
		}
		
		/*|--------------------------------------------------------|*/
		/*|------        			USER DOWNLINE   	    -------|*/
		/*|--------------------------------------------------------|*/
		
		public function view_user_downline()
		{
			$data['form_name'] 	= "Downline Member";
			$data['table_name'] = "View Downline Member";
			
			if(post('txtuserid'))
			{
				$uid 		= get_uid(post('txtuserid'));
				if(ISLEVEL == 0)
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
			}
			$this->view('view_user_downline',$data);
			
		}
		public function view_user_downline_form()
		{
			//print_r($this->input->post());
			$this->crud_model->ledger_download($this->input->post(),"","tab");
			
		}
		
		/*|--------------------------------------------------|*/
		/*|------     		USER TREE STRUCTURE	      -------|*/
		/*|--------------------------------------------------|*/
		
		public function tree()
		{
			$data['form_name'] = "Tree Stucture";
			
			$id=$this->uri->segment(3);
			$this->db->query("CALL `sp_user_at_level`($id,3)");
			$data['tr']=$this->db->query("SELECT * FROM `view_tree` WHERE `REGID` IN (SELECT * FROM total_user) ");
			
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('member/view_tree',$data);
			$this->load->view('common/footer');
		}
		
		/*----------------SEARCH USER ID IN TREE-------------------*/
		
		public function get_tree()
		{
			if($this->input->post('search_id')!='' || $this->input->post('search_id')!='0')
			{
				$this->db->where('or_m_user_id',trim($this->input->post('search_id')));
				$data['rec']=$this->db->get('m03_user_detail');
				$reg_id=$data['rec']->row()->or_m_reg_id;
				header("Location:".base_url()."index.php/member/tree/".$reg_id);
			}
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
		
		/*|---------------------------------------------------------------------|*/
		/*|------    			  LEDGER REPORT OF USER            		 -------|*/
		/*|---------------------------------------------------------------------|*/
		
		public function view_repurchase_wallet()
		{
			$condition="";
			$todate=0;
			$fromdate=0;
			
			$data['form_name'] = "Search Member Fund Ledger";
			$data['table_name'] = "View Member Fund Ledger";
			
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
			
			if(count($this->input->post()) == 0)
			{
				$condition=$condition." date_format(`LEDGER_DATETIME1`,'%Y-%m-%d') = date_format(NOW(),'%Y-%m-%d') AND ";
			}
			
			$condition=$condition." `LEDGER_UID` != 0 AND";
			$condition=$condition." `LEDGER_BALTYPE` = 2 ";
			
			$data['rid']=$this->db->query("SELECT * FROM view_ledger WHERE ".$condition);
			
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('member/view_ledger_report',$data);
			$this->load->view('common/footer');
		}
		
		
		/*|-----------------------------------------------------------------------------------------|*/
		/*|------    	REPURCHASE LEDGER REPORT OF USER            -------|*/
		/*|-----------------------------------------------------------------------------------------|*/
		
		public function view_rep_ledger_report()
		{
			$condition="";
			$fromdate = $todate = 0;
			
			$data['form_name'] = "Search Repurchase Wallet";
			$data['table_name'] = "View Repurchase Wallet";
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
				$condition = $condition." date(`LEDGER_DATETIME1`) >= date('$fromdate') AND date(`LEDGER_DATETIME1`) <= date('$todate') AND ";
			}
			
			if($uid !='false')
			{
				$condition=$condition." `LEDGER_UID` = $uid AND ";
			}
			
			if($condition != '')
			{
				$condition=$condition." `LEDGER_UID` != 0 AND";
				$condition=$condition." `LEDGER_BALTYPE` = 2 ";
				
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
		
		/*-------------FUND REQUEST---------------*/
		
		public function view_fund_request()
		{
			$data['form_name'] = "Fund Request";
			$data['table_name']= "Manage Fund Request";
			
			$condition="";
			$fromdate = $todate = 0;
			
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
				$condition = $condition." date(`m_top_reqdate`) >= date('$fromdate') AND date(`m_top_reqdate`) <= date('$todate') AND ";
			}
			
			if($this->input->post('user_id')!="")
			{
				$id = get_store_uid($this->input->post('user_id'));
				if($id != 'false')
				$condition = $condition." `tr09_req_uid` = $id and ";
			}
			
			if($this->input->post('ddstatus')!="")
			{
				$condition = $condition." `m_top_status` = ".$this->input->post('ddstatus')." and ";
			}
			
			if(count($this->input->post()) == 0)
			{
				$condition = $condition." `m_top_status` = 2 and ";
			}
			$condition = $condition." `tr09_req_id` <> 0 ";
			
			$data['rid'] = $this->db->query("SELECT * FROM `view_fund_request` where ".$condition);
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('member/view_fund_request',$data);
			$this->load->view('common/footer');
		}
		
		public function fund_request_action($id, $status)
		{
			$res = $this->member_model->fund_request_action($id, $status);
			if($status == "1")
			$this->session->set_flashdata('success',$res);
			else
			$this->session->set_flashdata('error',"Fund Request Rejected.");
			
			header("Location:".base_url()."member/view_fund_request");
		}
		
		/*-------------FUND REQUEST---------------*/
		
		public function view_reward_list()
		{
			$data['form_name'] = "Reward";
			$data['table_name']= "Reward List";
			$data['rid'] = $this->db->query("SELECT 
			`tr_user_id`,
			get_detail(`tr_user_id`,2) uname,
			get_detail(`tr_user_id`,4) uid,
			`tr_seven_day`,
			(SELECT `m_reward` FROM `m31_rewards` WHERE `m_rd_point`<=`tr_seven_day` AND `m_rd_day`=7) rew
			FROM
			`admin_assvig`.`tr14_reward`");
			
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('member/view_reward_list',$data);
			$this->load->view('common/footer');
		}
		public function view_fund_transfer()
		{
			$data['form_name'] = "Fund Transfer";
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('Member/view_fund_transfer',$data);
			$this->load->view('common/footer');
		}
		
		public function insert_fund_transfer()
		{
			$res = $this->member_model->insert_fund_transfer();
			$this->session->set_flashdata('success',$res);
			header("Location:".base_url()."member/view_fund_transfer"); 
		}
		
		public function view_disable_roi()
		{
			$data['form_name'] = " Disable ROI";
			$data['table_name'] = "View Disable ROI";
			
			$data['roi'] = $this->db->where("tr_reject_status",1)->get("tr28_reject_roi_user");
			
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('member/view_disable_roi',$data);
			$this->load->view('common/footer');
		}
		
		public function inser_disable_roi()
		{			
			$id=get_uid($this->input->post('txtuserid'));
			$data=array(
            'tr_reject_uid'=>$id,
            'tr_reject_status'=>'1',
            'tr_reject_date'=>date('Y-m-d H:i:s')
			);
			$this->db->insert('tr28_reject_roi_user', $data);
			$this->session->set_flashdata('success',$this->input->post('txtuserid').' Inserted Successfully!!');
			header("Location:".base_url()."member/view_disable_roi");
		} 
		public function view_delete_entry()
		{			
			$id=$this->uri->segment(3);
			$this->db->where('tr_reject_id', $id)->delete('tr28_reject_roi_user');;
			$this->session->set_flashdata('success',$id.' Deleted Successfully!!');
			header("Location:".base_url()."member/view_disable_roi");
		}
		
		/*|---------------------------------------------------------------------|*/
		/*|------    			  ROI REPORT OF All USER            	 -------|*/
		/*|---------------------------------------------------------------------|*/
		
		public function view_roi_statement()
		{
			$condition="";
			$todate=0;
			$fromdate=0;
			
			$data['form_name'] = "Search ROI Report";
			$data['table_name'] = "View ROI Report";
			
			if($this->input->post('end') != "")
			{
				$todate=$this->input->post('end');
			}
			
			if($this->input->post('start') != "")
			{
				$fromdate=$this->input->post('start');
			}
			
			if($todate!='0' && $fromdate!='0')
			{
				$condition = $condition." date_format(`tr_pay_date`,'%Y-%m-%d') >= date_format('$fromdate','%Y-%m-%d') AND date_format(`tr_pay_date`,'%Y-%m-%d') <= date_format('$todate','%Y-%m-%d') and";
			}
			else
			{
				$condition = $condition." date_format(`tr_pay_date`,'%Y-%m-%d') = date_format(now(),'%Y-%m-%d') and";
			}
			$condition = $condition." tr_status in (3,1) group by date_format(`tr_pay_date`,'%Y-%m-%d'),m03_user_detail.or_m_reg_id";
			$data['rid']=$this->db->query("SELECT 
			m03_user_detail.or_m_user_id,
			m03_user_detail.or_m_reg_id,
			m03_user_detail.or_m_name,
			sum(tr27_roi_dates.tr_pay_amount+tr27_roi_dates.tr_admin_charges+tr27_roi_dates.tr_tds_charges)  as  ttotal,
			tr27_roi_dates.*  FROM tr27_roi_dates
			left JOIN m03_user_detail 
			ON m03_user_detail.or_m_reg_id = tr27_roi_dates.tr_user_id
			where ".$condition);
			//echo $this->db->last_query(); die;
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('member/view_roi_statement',$data);
			$this->load->view('common/footer');
		}
		
		/*|---------------------------------------------------------|*/
		/*|------  		   USER WITHDRAWAL RERQUEST          -------|*/
		/*|---------------------------------------------------------|*/
		
		public function view_withdrawal_report()
		{
			$data['form_name']="View Withdrawal";
			$data['table_name']="View Withdrawal Report";
			$fromdate	=	$todate		=	0;
			$condition = '1 ';
			
			if($this->input->post('start') != "")
			{
				$fromdate=$this->input->post('start');
			}
			
			if($this->input->post('end') != "")
			{
				$todate=$this->input->post('end');
			}
			
			if($todate!='0' && $fromdate!='0')
			{
				$condition = $condition." and date(`m_w_reqdate1`) >= date('$fromdate') AND date(`m_w_reqdate1`) <= date('$todate') ";
			}
			
			if(post('ddstatus') != '' && post('ddstatus') != -1)
			$condition = $condition.' and `view_withdawal_report`.`m_w_status` = '.post('ddstatus');
			
			if(empty($this->input->post()))
			{
				$condition = $condition.' and `view_withdawal_report`.`m_w_status` = 1';
			}
			
			$data['rid'] = $this->db->query("SELECT * FROM `view_withdawal_report` where ".$condition." ORDER BY `view_withdawal_report`.`m_w_status` asc, `view_withdawal_report`.`m_w_reqdate1` DESC");
			//echo $this->db->last_query();die;
			$this->view('view_withdrawal_report',$data);
		}
		
		function update_member_withdrawal($wid,$status)
		{
			$res = $this->member_model->update_member_withdrawal($wid,$status);
			$this->session->set_flashdata('success',$res);
			redirect($this->agent->referrer());
		}
		
		
		public function view_admin_query()
		{
			$data['form_name'] = "Query Details";
			$data['table_name'] = "View Query Details";
			
			$data['rec']=$this->db->query("SELECT * FROM `tr29_contact_form`");
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('member/view_admin_query',$data);
			$this->load->view('common/footer');
		}
		
		public function delete_query($id)
		{
			$this->db->where("tr_form_id",$id)->delete("tr29_contact_form");
			redirect("member/view_admin_query");
		}
		
		// -------------USER TOPUP REPORT ---------------
		
		public function view_topup_report()
		{
			$data['form_name'] = "Member Topup";
			$data['table_name'] = "Member Topup";
			
			$condition="";
			$todate=0;
			$fromdate=0;
			
			if($this->input->post('end') != "")
			{
				$todate=$this->input->post('end');
			}
			
			if($this->input->post('start') != "")
			{
				$fromdate=$this->input->post('start');
			}
			
			if($todate!='0' && $fromdate!='0')
			{
				$condition = $condition."  date_format(`tr_date`,'%Y-%m-%d') >= date_format('$fromdate','%Y-%m-%d') AND date_format(`tr_date`,'%Y-%m-%d') <= date_format('$todate','%Y-%m-%d') and ";
			}
			
			if($this->input->post('txtuserid') != '0' && $this->input->post('txtuserid') != '')
			{
				$uid = get_uid(post('txtuserid'));
				if($uid != 'false')
				$condition = $condition." `tr_user_id` = $uid and ";
			}
			
			
			if(count($this->input->post()) == 0)
			{
				$condition = $condition." date_format(`tr_date`,'%Y-%m') = date_format(now(),'%Y-%m') and ";
			}
			
			$data['rid'] = $this->db->query("select * from view_retopup WHERE ".$condition." 1"); 
			
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('member/view_topup_report',$data);
			$this->load->view('common/footer');	
		}
		
		
		public function view_term_condition()
		{ 
			
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('member/view_term_condition');
			$this->load->view('common/footer');
			
		}
		
		////////////////////////////////////
		/////////  	PAN CARD REPORT   ////
		///////////////////////////////////////	
		
		public function view_pan_report()
		{
			$data['form_name'] = "Pancard report";
			$data['table_name'] = "Pancard report";
			$id=$this->session->userdata('profile_id');
			$data['pan_report']=$this->db->query("SELECT or_m_user_id,or_m_name,or_m_old_pancard,or_m_new_pancard,or_m_date FROM m04_user_pancard  LEFT JOIN `m03_user_detail` ON m03_user_detail.or_m_reg_id=m04_user_pancard.or_m_id  ORDER BY or_m_date DESC ")->result();
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('Member/view_pan_report',$data);
			$this->load->view('common/footer'); 
		}
		
		public function view_business_report()
		{
			$data['form_name'] = "Business report";
			$data['table_name'] = "View Business report";
			$id=$this->input->post('user_id');
			
			$userid = get_uid($id);
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
				$condition = $condition." WHERE `tr03_datewise_pair`.`or_m_reg_id` = $userid";
				if($todate!='0' && $fromdate!='0')
				{
					$condition = $condition." and date_format(`tr_date`,'%Y-%m-%d') >= date_format('$fromdate','%Y-%m-%d') AND date_format(`tr_date`,'%Y-%m-%d') <= date_format('$todate','%Y-%m-%d')";
				}
			}
			
			if($condition != "")
			{
				$data['report'] = $this->db->query("SELECT SUM(`tr_today_lvol`) lpv, SUM(`tr_today_rvol`) rpv, `tr_date`, `or_m_user_id`, `or_m_name` FROM `tr03_datewise_pair`
				LEFT JOIN `m03_user_detail`
				ON `m03_user_detail`.`or_m_reg_id` = `tr03_datewise_pair`.`or_m_reg_id` 
				".$condition." GROUP BY DATE_FORMAT(`tr_date`,'%Y-%m-%d')")->result();
			}
			
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('Member/view_business_report',$data);
			$this->load->view('common/footer');
		}
		
		public function view_rbusiness_report()
		{
			$data['form_name'] = "Purchase Business report";
			$data['table_name'] = "View Purchase Business report";
			$id=$this->input->post('user_id');
			
			$userid = get_uid($id);
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
				$condition = $condition." WHERE `tr30_repurchase_datewise`.`or_m_reg_id` = $userid";
				if($todate!='0' && $fromdate!='0')
				{
					$condition = $condition." and date_format(`tr_re_date`,'%Y-%m-%d') >= date_format('$fromdate','%Y-%m-%d') AND date_format(`tr_re_date`,'%Y-%m-%d') <= date_format('$todate','%Y-%m-%d')";
				}
				
				if(post('ddtype') == '1')
				{
					$condition = $condition." and `tr30_repurchase_datewise`.`or_m_reg_id` = `tr_re_uid_by`";
				}
				else
				{
					$condition = $condition." and `tr30_repurchase_datewise`.`or_m_reg_id` <> `tr_re_uid_by`";					
				}
			}
			
			if($condition != "")
			{
				$data['report'] = $this->db->query("SELECT ROUND(SUM(`tr_re_today_lvol`),2) lpv, ROUND(SUM(`tr_re_today_rvol`),2) rpv,
				`tr_re_date`, `or_m_user_id`, `or_m_name` ,`tr_re_purchase_time`, tr_re_uid_by, `tr30_repurchase_datewise`.`or_m_reg_id`
				FROM `tr30_repurchase_datewise`
				LEFT JOIN `m03_user_detail`
				ON `m03_user_detail`.`or_m_reg_id` = `tr30_repurchase_datewise`.`or_m_reg_id` 
				".$condition." GROUP BY DATE_FORMAT(`tr_re_date`,'%Y-%m-%d'),`tr_re_purchase_time`")->result();
			} 
			//l();
 			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('Member/view_rbusiness_report',$data);
			$this->load->view('common/footer');
		}
		
		public function team_growth_income()
		{
			$data['form_name'] = "Team Growth Income";
			$data['table_name'] = "View Team Growth Income";
			
			$id = $this->input->post('txtlogin');
			
			$userid = get_uid($id);
			$condition = "";
			$fromdate = $todate = 0;
			
			if($this->input->post('txtto') != "")
			{
				$todate=$this->input->post('txtto');
			}
			if($this->input->post('txtfrom') != "")
			{
				$fromdate=$this->input->post('txtfrom');
			}
			if($userid != '' && $userid != 'false')
			{
				$condition = $condition." `tr42_uid` = $userid and ";
			}
			if($todate!='0' && $fromdate!='0')
			{
				$condition = $condition." date_format(`tr42_date`,'%Y-%m-%d') >= date_format('$fromdate','%Y-%m-%d') AND date_format(`tr42_date`,'%Y-%m-%d') <= date_format('$todate','%Y-%m-%d')  and ";
			}
			$condition = $condition." tr42_uid <> 0";
			if($condition)
			{
				$data['res'] = $this->db->query("SELECT * FROM `tr42_designation_income`
				LEFT JOIN `m03_user_detail`
				ON `m03_user_detail`.`or_m_reg_id` = `tr42_designation_income`.`tr42_uid`
				WHERE `tr42_designation_income`.`tr42_type` = 10 and ".$condition);
			}
			
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('closing/view_team_grouth_income',$data);
			$this->load->view('common/footer');
		}
		
		public function view_user_income()
		{
			$data['form_name'] = "User Income";
			$data['table_name'] = "View User Income";
			$userid = get_uid($this->input->post('txtuserid'));
			$income_date =$this->input->post('dd_date');
			
			$condition = "";
			$fromdate = $todate = 0;
			
			if($userid != '' && $userid != 'false')
			{
				$condition = $condition." `tr51_uid` = $userid and ";
			}
			if($income_date != '' && $income_date != '-1')
			{
				$condition = $condition." DATE_FORMAT(tr51_month,'%Y-%m-%d') = DATE_FORMAT('$income_date' ,'%Y-%m-%d') and ";
			}
			else
			{
				$condition = $condition." tr51_month = DATE_SUB(NOW(), INTERVAL 1 MONTH) and ";
			}
			$condition = $condition." tr51_month <> ''";
			$data['detail'] = $this->db->query("SELECT * FROM view_user_income where $condition")->result();
			//echo $this->db->last_query();die;
			$data['user_date'] = $this->db->query("SELECT * FROM view_user_income GROUP BY tr51_month")->result();
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('member/view_user_income',$data);
			$this->load->view('common/footer');
		}
		
		public function transfer_amount_shoppingwallet()
		{
			$data['form_name'] = "AMOUNT TRANSFER To SHOPPING WALLET";
			$data['table_name'] = "View Repurchase Business report";			
			$userid = $this->session->userdata('profile_id');			
			$data['total_amount'] = $this->db->query("SELECT `get_available_bal`($userid,1) AS amount")->row()->amount;			
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('member/view_transfer_amount',$data);
			$this->load->view('common/footer');
		}
		public function user_transfer_amount()
		{			
			$res = $this->user_model->user_transfer_amount();
			$this->session->set_flashdata('info',$res);
			echo $res;
		}
		
		public function view_champoin_bons()
		{
			$data['form_name'] = "Champion Bons";
			$data['table_name'] = "View Champion Bons";			
			$userid = $this->session->userdata('profile_id');			
			$data['res'] = $this->db->query("SELECT `or_m_user_id`,`or_m_name`,`tr42_tot_l_team`,`tr42_tot_r_team`,`tr42_purchase`,`tr42_income`,`tr42_date`,`tr42_type`,`tr42_admin`,
			`tr42_tds` FROM  `tr42_designation_income` LEFT JOIN `m03_user_detail` ON(`tr42_designation_income`.`tr42_uid` = `m03_user_detail`.`or_m_reg_id`)  WHERE tr42_type ='Champion Bonus' order by tr42_date desc")->result();			
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('member/view_champoin_bons',$data);
			$this->load->view('common/footer');
		}
		
		public function view_royalty_report()
		{
			$data['form_name'] = "View Royalty Report";
			$data['table_name'] = "View Royalty Report";
			$condition = "";			
			$data['clos_date'] = $this->db->query("SELECT DATE_FORMAT(tr42_date,'%Y-%m-%d') as closind_date FROM `tr42_all_income` ORDER BY `tr42_id` DESC")->result();
			
			$userid = $this->session->userdata('profile_id');	
			$selt_date = $this->input->post('dd_closdt');
			
			
			
			if($selt_date!='0' && $selt_date!='-1' && $selt_date!='')
			{
				$condition = $condition."  date_format(`tr42_date`,'%Y-%m-%d') >= date_format('$selt_date','%Y-%m-%d') and";
			}
			
			$condition = $condition." `or_m_reg_id` = 0 ";		
			$data['res'] = $this->db->query("SELECT `or_m_user_id`,`or_m_name` FROM `m03_user_detail` LEFT JOIN `tr42_all_income` ON(`m03_user_detail`.`or_m_reg_id` = `tr42_all_income`.`tr42_uid`) WHERE  $condition");
			
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('member/view_royalty_report',$data);
			$this->load->view('common/footer');
		}
		
		public function view_topup_from_report()
		{
			$data['form_name'] = "Member Topup";
			$data['table_name'] = "Member Topup";
			
			$condition="";
			$todate=0;
			$fromdate=0;
			
			if($this->input->post('end') != "")
			{
				$todate=$this->input->post('end');
			}
			
			if($this->input->post('start') != "")
			{
				$fromdate=$this->input->post('start');
			}
			
			if($todate!='0' && $fromdate!='0')
			{
				$condition = $condition."  date_format(`tr_date`,'%Y-%m-%d') >= date_format('$fromdate','%Y-%m-%d') AND date_format(`tr_date`,'%Y-%m-%d') <= date_format('$todate','%Y-%m-%d') and ";
			}
			
			if($this->input->post('txtuserid') != '0' && $this->input->post('txtuserid') != '')
			{
				$uid = get_uid(post('txtuserid'));
				if($uid != 'false')
				$condition = $condition." `tr_user_id` = $uid and ";
			}
			
			
			if(count($this->input->post()) == 0)
			{
				$condition = $condition." date_format(`tr_date`,'%Y-%m') = date_format(now(),'%Y-%m') and ";
			}
			
			$data['rid'] = $this->db->query("select * from view_retopup WHERE ".$condition." 1"); 
			
			$this->load->view('common/header');
			$this->load->view('common/menu',$this->data);
			$this->load->view('member/view_topup_from_report',$data);
			$this->load->view('common/footer');	
			
		}
		
		function tree_view_level($id = null)
		{
			$data["form_name"] = "Tree View";
			
			if($this->input->post('search_id') <> '')
			{
				$id = get_uid($this->input->post('search_id'));
				$res = 'true';
			}
			elseif($id <> null)
			{
				$res = $this->member_model->scan_team($id);
			}
			else
			{
				$id = 1;
				$res = 'true';
			}
			
			if($res == 'true')
			{
				$data['result'] = $this->user_model->user_tree_level($id);
			}
			else
			{
				$id = $this->session->userdata('profile_id');
				$data['result'] = $this->user_model->user_tree_level($id);
			}
			$this->load->view('common/header');
			$this->load->view('common/menu');
			$this->load->view('user/tree_view_level', $data);
			$this->load->view('common/footer');
		}
		
		public function viewOrders()
		{
			$this->load->model('Member_model');
			$data['form'] 	= "Order Detail";
			$data['table'] 	= "Order";
			$condition="";
			
			//$query 	= $this->Member_model->viewOrders(0);
			
			// $data['res'] =  json_decode(json_encode($query), true);
			// p($data['res']);
			
			/* $data['purchase']= $this->db->query("SELECT `tr04_purchase`.*,user_name AS NAME FROM `tr04_purchase` JOIN `m03_user_detail`ON `tr04_purchase`.pur_reg_id=`m03_user_detail`.user_reg_id")->result(); */
			
			if(!empty($this->input->post()))
			{
				$condition=$condition."`tr06_order_detail`.`order_trans_id` =".$this->input->post('txt_invoice');
			}
			else
			{
				$condition=$condition."`tr06_order_detail`.`order_trans_id` <> '' ";
			}
			$data['purchase']= q("SELECT `tr06_order_detail`.*,user_name AS NAME,`user_u_id` AS uid FROM `tr06_order_detail`
			left JOIN `m03_user_detail`ON `tr06_order_detail`.`order_reg_id`=`m03_user_detail`.user_reg_id where $condition order by order_id desc ")->result();
			// echo $this->db->last_query();die;
			$this->load->view('common/header');
			$this->load->view('common/menu');
			$this->load->view('member/view_purchase_detail',$data);
			$this->load->view('common/footer');
			
		}
		public function prodcut_summery()
		{
			
			$data['form'] 	= "Product Order Summery";
			$data['table'] 	= "Product Order";
			$condition="";
			$id = $this->uri->segment(3);
			$data['invoice'] = $id;
			if(!empty($this->input->post()))
			{
				$condition=$condition."`tr04_purchase`.`pur_current_status` =".$this->input->post('dd_status');
			}
			
			$condition=$condition."pur_order_trans_id = $id ";
			
			$data['rid'] = $this->db->query("SELECT `tr04_purchase`.*,user_name AS NAME FROM `tr04_purchase` JOIN `m03_user_detail`ON `tr04_purchase`.pur_reg_id=`m03_user_detail`.user_reg_id where $condition ")->result();
			
			$this->load->model('Member_model');
			$data['purchase'] = $this->Member_model->view_order_details($id);
			//echo '<pre>';print_r($data['purchase']);exit;
			
			$this->load->view('common/header');
			$this->load->view('common/menu');
			$this->load->view('member/prodcut_summery',$data);
			$this->load->view('common/footer');
			
		}
		public function view_purchase_histroy()
		{
			
			$data['form'] 	= "Product Order Summary";
			$data['table'] 	= "Product Order";
			$id = $this->uri->segment(3);
			$data['transid'] = $id;
			$data['rid'] = $this->db->query("SELECT * from v15_product_purchase_all where pur_all_trans_id = $id GROUP BY pur_all_variant_id, pur_all_type")->result();
			
			$this->load->view('common/header');
			$this->load->view('common/menu');
			$this->load->view('member/view_purchase_histroy',$data);
			$this->load->view('common/footer');
			
		}
		
		
		public function view_update_status()
		{
			
			$trans_id = $this->input->post('txt_transid');
			
			 $status = $this->input->post('dd_status');
			$dt = YmdHis;
			
			$this->db->query("update tr04_purchase set pur_delivered_on_date = '$dt',pur_current_status=$status where pur_trans_id = $trans_id");
			$this->session->set_flashdata('info','Product Status Update Successfully !!');
			$mobile=$this->db->query("SELECT `m03_user_detail`.`user_mobile_no` as mobile FROM `tr04_purchase` 
			JOIN`m03_user_detail` ON `m03_user_detail`.`user_reg_id`=`tr04_purchase`.`pur_reg_id`
			WHERE `tr04_purchase`.`pur_trans_id`=$trans_id")->row()->mobile;
			if($status==3){
			send_sms($mobile,cancel_order($trans_id));
			}else
			{
			send_sms($mobile,dell_order($trans_id));
			}
			//update main order status (incomplete)
			// $sub_order=$this->db->query("SELECT pur_current_status FROM tr04_purchase WHERE pur_order_trans_id = (SELECT pur_order_trans_id FROM tr04_purchase WHERE pur_trans_id = $trans_id)")->result();
			// if($this->db->affected_rows() > 0){
			// 	$main_order_status="Pending";
			// 	foreach($sub_order as $v){
			// 		if($v->pur_current_status == "Delivered")
			// 			$main_order_status = "Delivered";
			// 		else
			// 			$main_order_status = "Pending";
			// 	}
			// }
			
			redirect("member/viewOrders");
			
		}
		
		public function view_purchase_details($id)
		{			
			$this->load->model('Member_model');
			$data = $this->Member_model->view_purchase_details($id);
			$this->load->view('common/header');
		    $this->load->view('common/menu');
			$this->load->view('user/invoice',$data);
			$this->load->view('common/footer');
		}
		public function view_order_details($id)
		{			
			$this->load->model('Member_model');
			$data = $this->Member_model->view_order_details($id);
			$this->load->view('common/header');
		    $this->load->view('common/menu');
			$this->load->view('user/invoice2',$data);
			$this->load->view('common/footer');
		}
		
		//ajax request form Member/viewOrders
		function update_main_order_status(){
			$status=$this->input->post("status");
			$invoice=$this->input->post("invoice");
			
			if($status == "Delivered" || $status == "AllDelivered"){
				
				$this->db->where("order_trans_id",$invoice)->update("tr06_order_detail",["order_status"=>"Delivered"]);
				// $user_id=$this->db->query("SELECT order_reg_id FROM `tr06_order_detail` WHERE order_trans_id = ".$invoice)->row()->order_reg_id;
				// $this->db->query("CALL sp07_referal_income('".$user_id."','1')");
				mysqli_next_result( $this->db->conn_id );
				
			}elseif($status == "AllCancel")
			$this->db->where("order_trans_id",$invoice)->update("tr06_order_detail",["order_status"=>"Cancel"]);
			
			
			$status_="Delivered";
			if($status == "AllCancel")
			$status_ = "Cancel";
			
			$purchase=$this->db->query("SELECT pur_id,pur_current_status FROM `tr04_purchase` WHERE pur_order_trans_id = ".$invoice)->result();
			foreach($purchase as $v){
				if($v->pur_current_status == "Placed")
				$this->db->where("pur_id",$v->pur_id)->update("tr04_purchase",["pur_current_status"=>$status_,"pur_delivered_on_date"=>date("Y-m-d H:i:s")]);
			}
			
			
			echo "OK";
			exit;
		}
		
		
		
		
		
		public function customers(){			
			
			$data['customer']=$this->db->query("SELECT cus.user_reg_id,cus.user_name,cus.user_joining_date,cus.user_gender,cus.user_email,cus.user_mobile_no,cus.user_address,cus.user_pincode,intro.`user_mobile_no` AS  intro_mobile,intro.`user_name` AS intro FROM m03_user_detail AS cus INNER JOIN m03_user_detail AS intro ON intro.`user_reg_id`=cus.user_intr_id  WHERE cus.user_designation = 'Customer'")->result();
			
			$this->load->view('common/header');
		    $this->load->view('common/menu');
			$this->load->view('member/customer_detail',$data);
			$this->load->view('common/footer');
		}
		
	}
?>