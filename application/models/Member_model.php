<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Member_model extends CI_Model
	{
		/*--------------MAKE REGISTRATION DATA-----------------*/
		
		public function reg_data($pass = null, $file = null)
		{
			$data = array(
			'u_id'			=> trim(post('txtregid')),
			'designation'	=> 1,
			'user_name'		=> trim(post('txtname')),
			'dob'			=> date('Y-m-d', strtotime(post('txtdob'))),
			'joining_date'	=> YmdHis,
			'gender'		=> (post('rbgender') == '')?1:post('rbgender'),
			'email'			=> trim(post('txtemail')),
			'mobile_no'		=> trim(post('txtmobile')),
			'country'		=> 1,
			'state'			=> trim(post('ddstate')),
			'city'			=> trim(post('ddcity')),
			'pincode'		=> trim(post('txtpincode')),
			'address'		=> trim(post('txtaddress')),
			'userimage'		=> $file,
			'stat'			=> 1,
			'intr_id'		=> (post('txtreferral') == '') ? 1 : get_uid(post('txtreferral')),
			'login_pwd'		=> trim($pass),
			'reg_from'		=> trim(post('txtreg_from')),
			'proc' 			=> trim(post('txtproc')),
			);
			
			return $data;
		}
		
		/*--------------MAKE USER REGISTRATION-----------------*/
		
		public function signup()
		{
			if(post('txtpassword') == '')
			{
				$pass = rand(100000,999999);
			}
			else
			{
				$pass	 = post('txtpassword');
			}
			$mob = trim(post('txtmobile')); $msg = $status = '';
			$coun = q("SELECT COUNT(*) coun FROM `m03_user_detail` WHERE `user_mobile_no` = '$mob'")->row()->coun;
			
			if(strlen($mob) == 10 )
			{
				if($coun == 0 )
				{
					$data = $this->reg_data($pass, '');
					$query = " CALL sp03_member(?" . str_repeat(",?", count($data)-1) . ",@msg) ";
					$this->db->query($query, $data);				
					$status = $this->db->query("SELECT @msg as message")->row()->message;
					if($status == 'true'){
						$msg="Welcome ".post('txtname').", your login details are - Userid : ".$mob." Password : ".$pass;
						send_sms(trim(post('txtmobile')),registration_success(post("txtname"),trim(post('txtmobile'))) );
						//generate referral income
						$user_id=$this->db->query("SELECT user_reg_id AS  user_id from m03_user_detail where user_mobile_no = ".trim(post('txtmobile')))->row()->user_id;
						$this->db->query("CALL sp07_referal_income('".$user_id."','0','1')");
					}
					
					/*
						$msg1="Welcome ".$this->input->post('txtassociate_name')."<br>Your login details are - <br>
						<br>URL : ".WEBSITE_NAME."<br> Userid : ".$id."<br>Password : ".$pass."<br>Tran. Password : ".$pinpass."<br><br>Thankyou";
						
						$msg2="Welcome ".$this->input->post('txtassociate_name').", Your login details are - 
						URL: ".WEBSITE_NAME." Userid: ".$id." Password: ".$pass.", TXN Password: ".$pinpass." Thankyou.";
						
						if(SMS_SEND_STATUS==1)
						$this->crud_model->send_sms(trim($this->input->post('txtmobile')),$msg2);
						
						if(EMAIL_SEND_STATUS==1)
						$this->crud_model->send_email($this->input->post('txtemail'),'Login Details',$msg1,'Login Details');
					*/
				}
				else
				{
					$msg = "Mobile number already in use!";
				}
			}
			else
			{
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
		
		/*--------------MAKE USER PROFILE UPDATE-----------------*/
		public function placeOrder($id, $type,$addr_id,$instruc,$payMode,$couponId)
		{ 
			$file = $cart_addon = $transid = $transid2 = '';
			$deli_charge = $couponAmt = $amt = $totAmt = $deli = 0;
			$addr 		= $addr_id;
			$instruc 	= $instruc;
			$payMode 	= $payMode; 
			$couponId 	= $couponId;	
			
			if($couponId == '') {
					$couponId = 0;
			} else {
					updateUsedCoupon($id, $couponId);
					$temp = q("select coupon_amount from tr08_coupons where coupon_id = $couponId and coupon_status = 1")->result();
					if($this->db->affected_rows() > 0)
						$couponAmt = $temp[0]->coupon_amount;
			}
			
			$transid2 = q("select fn00_transid2() id")->row()->id;
				
			if($addr > 0 && $payMode <> '')
			{
				if(isset($_FILES['userfile']['name'])) 
				{
					$file_name 	= $_FILES['userfile']['name'];
					if($_FILES['userfile']['name'] <> "")
					{
						$config['upload_path']   =   "application/user_order/";
						$config['allowed_types'] =   "gif|jpg|jpeg|png|bmp"; 
						$config['max_size']      =   "5000";
						$config['max_width']     =   "5000";
						$config['max_height']    =   "5000";
						$this->load->library('upload',$config);
						$this->upload->do_upload();
						$finfo=$this->upload->data();
						$file=($finfo['raw_name'].$finfo['file_ext']);
					}
				}
					
 				$cart = $this->db->where("cart_reg_id", $id)->group_by('cart_variant_id')->get("v10_cart")->result();
				//p($cart);
				if(!empty($cart) && $cart <> null)
				{
					foreach($cart as $row)
					{
						if($row->cart_type == 'Product' )
						{
							$transid = q("select fn01_transid() id")->row()->id;
							$amt = $amt+($row->pr_vari_actual_price*$row->cart_qty);
							$deli_charge  = $row->deli_slot_charges;
							
							$data = [
							"pur_all_trans_id" 		=> $transid,
							"pur_all_reg_id" 		=> $id,
							"pur_all_product_id" 	=> $row->cart_product_id,
							"pur_all_variant_id" 	=> $row->cart_variant_id,
							"pur_all_product_name" 	=> $row->pr_name,
							"pur_all_unit_price" 	=> $row->pr_vari_actual_price,
							"pur_all_unit_value" 	=> $row->pr_vari_unit_value,
							"pur_all_unit_id" 		=> $row->unit_id,
							"pur_all_qty" 			=> $row->cart_qty,
							"pur_all_type" 			=> $row->cart_type,
							"order_instruction" 	=> $row->cart_message,
							"order_flavour" 		=> $row->flavour_name,
							"order_design_img" 		=> $row->cart_custom_img
							];
							insert("tr05_purchase_all", $data);
							
							$cart_addon = cart_addon_product($id, $row->cart_id);
							if(!empty($cart_addon))
							{
								foreach($cart_addon as $row1)
								{
									$amt = $amt+($row1->pr_vari_actual_price*$row1->cart_qty);
									$data1 = [
									"pur_all_trans_id" 		=> $transid,
									"pur_all_reg_id" 		=> $id,
									"pur_all_product_id" 	=> $row1->cart_product_id,
									"pur_all_variant_id" 	=> $row1->cart_variant_id,
									"pur_all_product_name" 	=> $row1->pr_name,
									"pur_all_unit_price" 	=> $row1->pr_vari_actual_price,
									"pur_all_qty" 			=> $row1->cart_qty,
									"pur_all_type" 			=> $row1->cart_type,
									];
									insert("tr05_purchase_all", $data1);
								}
							}
						}
						
						$data2 = [
						"pur_order_trans_id" 	=> $transid2,
						"pur_trans_id" 			=> $transid,
						"pur_reg_id" 			=> $id,
						"pur_tot_amt" 			=> $amt,
						"pur_delivery_date" 	=> $row->cart_delivery_date,
						"pur_delivery_slot" 	=> $row->cart_delivery_slot,
						"pur_delivery_charges" 	=> $deli_charge,
						"pur_delivery_pincode" 	=> $row->cart_pincode,
						"pur_instruction" 		=> $instruc,
						"pur_image" 			=> $file,
						"pur_type_id"			=> $row->cart_type_id,
						"pur_type_charge"		=> $row->cart_type_charge
						];
						insert("tr04_purchase", $data2);
						
						$totAmt = $totAmt + $amt; 
						$deli = $deli + $deli_charge;
						$type_extra_charge = $row->cart_type_id == 2 ? egg_less_charge($row->cart_product_id)["fee"] : "0";
						$totAmt +=$type_extra_charge;
						$amt=0;

						$mobile=$this->db->select("user_mobile_no")->where("user_reg_id",$id)->get("m03_user_detail")->row()->user_mobile_no;
						send_sms($mobile,order_placed($transid,$totAmt,$row->cart_delivery_date,$row->cart_delivery_slot));
					}
					
					
					$wallet_off=checkout_wallet_off($id);	
					$addr_det = q("select * from m04_user_address where user_addr_id = $addr")->row();
					$data3 = [
						"order_trans_id" 		=> $transid2,
						"order_reg_id" 			=> $id,
						"order_discount_amt" 	=> $couponAmt,
						"order_wallet_off"		=> $wallet_off,
						"order_delivery_charges"=> $deli,
						"order_amt" 			=> $totAmt,
						"order_payble_amt" 		=> (($totAmt+$deli)-($couponAmt+$wallet_off)),
						"order_address" 		=> $addr_det->user_addr_name.' | '.$addr_det->user_addr_mobile.' | '.$addr_det->user_addr_address.' | '.$addr_det->user_addr_landmark1.' | '.$addr_det->user_addr_landmark2.' | '.$addr_det->user_addr_pincode,
						"order_pay_mode" 		=> $payMode,
						"order_coupon_id" 		=> $couponId,
						"order_from" 			=> $type,
						];
						insert("tr06_order_detail", $data3);
						
						//deduct wallet balance
						if($wallet_off > 0){
							$data=array(
								'm_u_id' =>$id,
								'm_trans_id' =>get_transid(),
								'm_cramount' =>0,
								'm_dramount' =>$wallet_off,
								'm_description' =>"Used in Product Purchase #".$transid2,
								'm_transdate' =>YmdHis,
								'm_ledger_type' =>1,
								'm_bal_type' =>1,
								'm_datetime' => YmdHis
							);
							$this->db->insert('tr07_manage_ledger',$data);
						}
						//$this->view_user_wallet($id,$totAmt);
					
					$this->db->where('cart_reg_id', $id)->delete('tr03_cart_product');
					
					return ['msg' => 1, 'res' => $transid2];				
				} 
				else 
				{
					return ['msg' => 0, 'res' => 'No products in your cart!'];				
				}	
			}
			else 
			{
				return ['msg' => 0, 'res' => 'Missing Required field!'];				
			}
			
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