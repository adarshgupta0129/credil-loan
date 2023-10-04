<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Member_model extends CI_Model
	{
		/*--------------MAKE REGISTRATION DATA-----------------*/
		
		public function reg_data($pass = null, $file = null)
		{
			$data = array(
			'txt_reg_id'		=> trim(post('txtregid')),
			'txt_name'			=> trim(post('txtname')),
			'txt_rel_type'		=> trim(post('ddrel')),
			'txt_guardian'		=> trim(post('txtparent')),
			'txt_gender'		=> (post('rbgender') == '')?1:post('rbgender'),
			'txt_dob'			=> date('Y-m-d', strtotime(post('txtdob'))),
			'txt_email'			=> trim(post('txtemail')),
			'txt_mobile'		=> trim(post('txtmobile')),
			'txt_stateid'		=> trim(post('ddstate')),
			'txt_cityid'		=> trim(post('ddcity')),
			'txt_pincode'		=> trim(post('txtpincode')),
			'txt_address'		=> trim(post('txtaddress')),
			'txt_user_type'		=> trim(post('txtusertype')),
			'txt_login_pwd'		=> trim($pass),
			'txt_reg_from'		=> 1 ,
			'txt_date'			=> YmdHis,
			'proc' 				=> trim(post('txtproc')),
			);
			
			return $data;
		}
		
		/*--------------MAKE USER REGISTRATION-----------------*/
		
		public function signup()
		{
			if(post('txtpassword') == '') {
				$pass = rand(100000,999999);
				} else {
				$pass = post('txtpassword');
			}
			
			$mob 		= trim(post('txtmobile')); 
			$userType 	= trim(post('txtusertype')); 
			$msg 		= $status = '';
			$coun 		= q("SELECT COUNT(*) coun FROM `m03_user_detail` WHERE `user_mobile_no` = '$mob' and user_type = $userType")->row()->coun;
			
			if(strlen($mob) == 10 ) {
				if($coun == 0 ) {
					
					$data = $this->reg_data($pass, '');
					$query = " CALL sp03_member(?" . str_repeat(",?", count($data)-1) . ",@msg) ";
					$this->db->query($query, $data);
					$status = $this->db->query("SELECT @msg as message")->row()->message;
					
					if($status == true){
						$msg="Welcome ".post('txtname').", your login details are - Userid:  ".$mob." Password: ".$pass;
						//send_sms(trim(post('txtmobile')),registration_success(post("txtname"),trim(post('txtmobile'))) );
					}
					} else {
					$msg = "Mobile number already in use!";
				}
				} else {
				$msg = "Invalid mobile number!";
			}
			return $msg;
		}
		
		/*--------------MAKE USER PROFILE UPDATE-----------------*/
		
		public function update_member()
		{
			$file_name = $_FILES['userfile']['name'];
			if($file_name!='')
			{
				$config['upload_path']   =   "application/user_image/";
				$config['allowed_types'] =   "gif|jpg|jpeg|png|bmp"; 
				$config['max_size']      =   "5000";
				$config['max_width']     =   "5000";
				$config['max_height']    =   "5000";
				$this->load->library('upload',$config);
				$this->upload->do_upload();
				$finfo=$this->upload->data();
				$file=($finfo['raw_name'].$finfo['file_ext']);
			}
			else
			{
				$file = trim($this->input->post('txtpic'));
			}
			$data = $this->reg_data('', $file);
			$query = " CALL sp_member(?" . str_repeat(",?", count($data)-1) . ",@msg) ";
			$this->db->query($query, $data);
			
			$this->db->query("SELECT @msg as message")->row()->message;
		}

		public function globalSearch(){
			
			$todate = $fromdate = 0;
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
				$condition=$condition."`m03_user_detail`.`user_joining_date` >= DATE_FORMAT('$fromdate','%Y-%m-%d') and `m03_user_detail`.`user_joining_date` <= DATE_FORMAT('$todate','%Y-%m-%d')and ";
			}
			if($this->input->post('txtlogin')!="" && $this->input->post('txtlogin')!="0")
			{
				$id=get_uid($this->input->post('txtlogin'));
				$condition=$condition." `m03_user_detail`.`user_reg_id`= ".$id."  and";
			}			
			if($this->input->post('txtmob')!="" && $this->input->post('txtmob')!="0")
			{
				$condition=$condition." `m03_user_detail`.`user_mobile_no`= ".$this->input->post('txtmob')."  and";
			}
			if($this->input->post('txtname')!="" && $this->input->post('txtname')!="0")
			{
				$condition=$condition." `m03_user_detail`.`user_name`= '".$this->input->post('txtname')."'  and";
			}
			if($this->input->post('ddtype')!="-1" && $this->input->post('ddtype')!="")
			{
				$condition=$condition." `m03_user_detail`.`user_designation`= '".$this->input->post('ddtype')."'  and";
			}
			// if(count($this->input->post()) == 0)
			// {
			// 	$condition=$condition."DATE_FORMAT(`m03_user_detail`.`user_joining_date`,'%Y-%m') = DATE_FORMAT(curdate(),'%Y-%m') and ";
			// }
			
			$condition=$condition." `m03_user_detail`.`user_reg_id` !=0 ";

			return $condition;
		}

	
		public function view_user_wallet($uid,$amount)
		{
			$data=array(
			'm_u_id' =>$uid,
			'm_trans_id' =>get_transid(),
			'm_cramount' =>$amount,
			'm_dramount' =>0,
			'm_description' =>"User Place Order Credited",
			'm_transdate' =>YmdHis,
			'm_ledger_type' =>1,
			'm_bal_type' =>1,
			'm_datetime' => YmdHis
			);
			$this->db->insert('tr07_manage_ledger',$data);
			
			$data2=array(
			'm_u_id' =>$uid,
			'm_trans_id' =>get_transid(),
			'm_cramount' =>0,
			'm_dramount' =>$amount,
			'm_description' =>"User Place Order Debited",
			'm_transdate' =>YmdHis,
			'm_ledger_type' =>2,
			'm_bal_type' =>1,
			'm_datetime' => YmdHis
			);
			$this->db->insert('tr07_manage_ledger',$data2);
		}
		
		
		public function viewOrders($invId = null, $uid = null)
		{			
			$cond = '';
			/*$array1 = $array2 = $array3 = array();$i=0;
				
				$data['orders'] = $orders1 = q("SELECT `tr06_order_detail`.*,user_name AS NAME,`user_u_id` AS uid FROM `tr06_order_detail`
				left JOIN `m03_user_detail`ON `tr06_order_detail`.`order_reg_id`=`m03_user_detail`.user_reg_id")->result();
				
				foreach($orders1 as $p1)
				{
				$orders2 	= q('SELECT * FROM `tr04_purchase` WHERE `pur_order_trans_id` = '.$p1->order_trans_id)->result();
				
				foreach($orders2 as $p2)
				{
				$orders3 	= q('SELECT * FROM `v15_product_purchase_all` WHERE `pur_all_trans_id` = '.$p2->pur_trans_id." group by pur_all_variant_id")->result();
				
				foreach($orders3 as $k=>$p3)
				{
				//echo $p3->pur_all_trans_id."<br>";
				//unset($da3);
				
				$da3['SUB_ORD_ID']		= $p3->pur_all_trans_id;
				//$da3['PRODUCT_ID']		= $p3->pur_all_product_id;
				//$da3['VARIANT_ID']		= $p3->pur_all_variant_id;
				//$da3['PRODUCT_NAME']	= $p3->pur_all_product_name;
				//$da3['UNIT']			= $p3->pur_all_unit_value.' '.$p3->unit_name;
				//$da3['QUANTITY']		= $p3->pur_all_qty;
				//$da3['PROD_TYPE']		= $p3->pur_all_type;
				//$da3['PROD_IMG'] 		= $p3->pr_img_name;
				//$da3['ADDON_IMG'] 		= $p3->addon_image;
				
				$array3[] = $da3;$i++;
				
				}
				
				$da3=[];
				
				$da2['MAIN_ORD_ID']			= $p2->pur_order_trans_id;
				$da2['SUB_ORD_ID']			= $p2->pur_trans_id;
				$da2['ORD_DELI_CHRG']		= $p2->pur_delivery_charges;
				$da2['ORD_AMT']				= $p2->pur_tot_amt;
				$da2['ORD_DELI_PINCODE']	= $p2->pur_delivery_pincode;
				$da2['ORD_STATUS']			= $p2->pur_current_status;
				$da2['ORD_DELI_DATE']		= $p2->pur_delivery_date;
				$da2['ORD_DELIVERED_TIME'] 	= $p2->pur_delivered_on_date;
				
				$da2['PRODUCT'] 			= $array3;					
				$array2[]					= $da2;				
				unset($da2);					
				}
				
				$da1['ORD_ID']			= $p1->order_id;
				$da1['MAIN_ORD_ID']		= $p1->order_trans_id;
				$da1['DISCOUNT'] 		= $p1->order_discount_amt;
				$da1['PAYBLT_AMT'] 		= $p1->order_payble_amt;
				$da1['ADDRESS'] 		= $p1->order_address;
				$da1['NAME'] 			= $p1->NAME;
				$da1['UID'] 			= $p1->uid;
				
				$da1['SUB_ORDERS'] 		= $array2;
				$array1[]				= $da1;				
				unset($da1);
				}
				//return $array1;
			*/
			
			$res=[];
			if($invId == null && $uid <> null) {
				$cond = "where order_reg_id = ".$uid;
			}
			if($invId <> null && $uid <> null) {
				$cond = "where `tr06_order_detail`.`order_trans_id` = ".$invId." and order_reg_id = ".$uid;
			}
			
			$data['orders'] = $orders1 = q("SELECT `tr06_order_detail`.*,user_name AS NAME,`user_u_id` AS uid FROM `tr06_order_detail`
			left JOIN `m03_user_detail`ON `tr06_order_detail`.`order_reg_id`=`m03_user_detail`.user_reg_id ".$cond." order by order_id desc")->result();
			
			foreach($orders1 as $k1=>$p1)
			{
				$orders2 	= q('SELECT * FROM `tr04_purchase` WHERE `pur_order_trans_id` = '.$p1->order_trans_id)->result();
				$res[$k1]['ORD_ID']				= $p1->order_id;
				$res[$k1]['MAIN_ORD_ID']		= $p1->order_trans_id;
				$res[$k1]['DISCOUNT'] 			= $p1->order_discount_amt;
				$res[$k1]['PAYBLT_AMT'] 		= $p1->order_payble_amt;
				$res[$k1]['ADDRESS'] 			= $p1->order_address;
				$res[$k1]['NAME'] 				= $p1->NAME;
				$res[$k1]['UID'] 				= $p1->uid;
				$res[$k1]['MODE'] 				= $p1->order_pay_mode;
				foreach($orders2 as $k2=>$p2)
				{
					$orders3 	= q('SELECT * FROM `v15_product_purchase_all` WHERE `pur_all_trans_id` = '.$p2->pur_trans_id." group by pur_all_variant_id")->result();
					$res[$k1][$k2]['MAIN_ORD_ID']			= $p2->pur_order_trans_id;
					$res[$k1][$k2]['SUB_ORD_ID']			= $p2->pur_trans_id;
					$res[$k1][$k2]['ORD_DELI_CHRG']		= $p2->pur_delivery_charges;
					$res[$k1][$k2]['ORD_AMT']				= $p2->pur_tot_amt;
					$res[$k1][$k2]['ORD_DELI_PINCODE']	= $p2->pur_delivery_pincode;
					$res[$k1][$k2]['ORD_STATUS']			= $p2->pur_current_status;
					$res[$k1][$k2]['ORD_DELI_DATE']		= $p2->pur_delivery_date;
					$res[$k1][$k2]['ORD_DELIVERED_TIME'] 	= $p2->pur_delivered_on_date;
					
					foreach($orders3 as $k3=>$p3)
					{
						$res[$k1][$k2][$k3]['SUB_ORD_ID']		= $p3->pur_all_trans_id;
						$res[$k1][$k2][$k3]['PRODUCT_ID']		= $p3->pur_all_product_id;
						$res[$k1][$k2][$k3]['VARIANT_ID']		= $p3->pur_all_variant_id;
						$res[$k1][$k2][$k3]['PRODUCT_NAME']	= $p3->pur_all_product_name;
						$res[$k1][$k2][$k3]['UNIT']			= $p3->pur_all_unit_value.' '.$p3->unit_name;
						$res[$k1][$k2][$k3]['QUANTITY']		= $p3->pur_all_qty;
						$res[$k1][$k2][$k3]['PROD_TYPE']		= $p3->pur_all_type;
						$res[$k1][$k2][$k3]['PROD_IMG'] 		= $p3->pr_img_name;
						$res[$k1][$k2][$k3]['ADDON_IMG'] 		= $p3->addon_image;						
					}
				}
			}
			
			return $res;
			
		}
		
		
		
		
		public function viewSubOrders($invId = null, $uid = null)
		{			
			$cond = '';
			$res=[];
			if($invId == null && $uid <> null) {
				$cond = " where pur_reg_id = ".$uid;
			}
			if($invId <> null && $uid <> null) {
				$cond = " where `tr04_purchase`.`pur_trans_id` = ".$invId." and pur_reg_id = ".$uid;
			}
			$orders2 	= q('SELECT * FROM `tr04_purchase` '.$cond)->result();
			
			foreach($orders2 as $k2=>$p2)
			{
				$orders3 	= q('SELECT * FROM `v15_product_purchase_all` WHERE `pur_all_trans_id` = '.$p2->pur_trans_id." group by pur_all_variant_id")->result();
				$res[$k2]['MAIN_ORD_ID']			= $p2->pur_order_trans_id;
				$res[$k2]['SUB_ORD_ID']			= $p2->pur_trans_id;
				$res[$k2]['ORD_DELI_CHRG']			= $p2->pur_delivery_charges;
				$res[$k2]['ORD_AMT']				= $p2->pur_tot_amt;
				$res[$k2]['ORD_DELI_PINCODE']		= $p2->pur_delivery_pincode;
				$res[$k2]['ORD_STATUS']			= $p2->pur_current_status;
				$res[$k2]['ORD_DELI_DATE']			= $p2->pur_delivery_date;
				$res[$k2]['ORD_DELIVERED_TIME'] 	= $p2->pur_delivered_on_date;
				
				foreach($orders3 as $k3=>$p3)
				{
					$res[$k2][$k3]['SUB_ORD_ID']		= $p3->pur_all_trans_id;
					$res[$k2][$k3]['PRODUCT_ID']		= $p3->pur_all_product_id;
					$res[$k2][$k3]['VARIANT_ID']		= $p3->pur_all_variant_id;
					$res[$k2][$k3]['PRODUCT_NAME']		= $p3->pur_all_product_name;
					$res[$k2][$k3]['UNIT']				= $p3->pur_all_unit_value.' '.$p3->unit_name;
					$res[$k2][$k3]['QUANTITY']			= $p3->pur_all_qty;
					$res[$k2][$k3]['PROD_TYPE']		= $p3->pur_all_type;
					$res[$k2][$k3]['PROD_IMG'] 		= $p3->pr_img_name;
					$res[$k2][$k3]['ADDON_IMG'] 		= $p3->addon_image;						
				}
			}
			//	l();
			return $res;
			
		}
		
		public function view_purchase_details($id)
		{
			
			$data['purchase']= $this->db->query("select * from v14_product_purchase where pur_trans_id=$id")->row();
			$data['product']= $this->db->query("SELECT * from v15_product_purchase_all WHERE pur_all_trans_id = $id GROUP BY pur_all_id")->result();
			// echo $this->db->last_query();die;
			return $data;
		} 
		public function view_order_details($id)
		{
			$data['purchase']= $this->db->query("select * from v14_product_purchase where pur_order_trans_id=$id ")->result();
			return $data;
		} 
		
	}
?>						