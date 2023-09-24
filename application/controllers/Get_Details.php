<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Get_details extends CI_Controller {
		
		public function __construct() 
		{
			parent::__construct();
		}
		
		public function index()
		{
			die;
		}
		
		/*-----------------Get Setting Details------------------*/
		
		public function get_setting_details()
		{
			$this->db->where('m00_id',$this->input->post('id'));
			$query['rec'] = $this->db->get('m00_setconfig')->result();
			$json=json_encode($query);
			echo $json;
		}
		
		/*----------------- UPDATE FROM ADMIN------------------*/
		
		public function update_value()
		{
			if( post('val') <> "" && session('profile_id') == 0) {
				if(post('proc') == 'bank'){		// of Unit Master
					$this->db->set("bank_name", post('val'))->where('bank_id',post('id'))->update("m01_bank");
				}
				elseif(post('proc') == 'setConfig'){		// of Set Configuration
					$this->db->set("m00_value", post('val'))->where('m00_id',post('id'))->update("m00_setconfig");
				}
				elseif(post('proc') == 'adminBankName'){		// of Admin Bank Name Master
					$this->db->set("ad_bank_bank_id", post('val'))->where('ad_bank_id',post('id'))->update("m09_admin_bank");
				}
				elseif(post('proc') == 'adminBankAc'){		// of Admin Bank AC Master
					$this->db->set("ad_bank_ac", post('val'))->where('ad_bank_id',post('id'))->update("m09_admin_bank");
				}
				elseif(post('proc') == 'adminBankIfsc'){		// of Admin Bank IFSC Master
					$this->db->set("ad_bank_ifsc", post('val'))->where('ad_bank_id',post('id'))->update("m09_admin_bank");
				}
				elseif(post('proc') == 'adminBankBranch'){		// of Admin Bank Branch Master
					$this->db->set("ad_bank_branch", post('val'))->where('ad_bank_id',post('id'))->update("m09_admin_bank");
				}
				elseif(post('proc') == 'adminBankAddress'){		// of Admin Bank Address Master
					$this->db->set("ad_bank_address", post('val'))->where('ad_bank_id',post('id'))->update("m09_admin_bank");
				}

			}
		}
		
		/*----------------- CHANGE STATUS FROM ADMIN------------------*/
		
		public function change_status()
		{
			if(post('status') == 0 || post('status') == 1 || post('status') == 2 || post('status') == 3 && session('profile_id') == 0){
				if(post('proc') == 'bank'){       // of Bank Master
					$this->db->set("bank_status", post('status'))->where('bank_id',post('id'))->update("m01_bank");
					success("Bank status changed.");
				}
				elseif(post('proc') == 'adminBank'){       // of Admin Bank Master
					$this->db->set("ad_bank_status", post('status'))->where('ad_bank_id',post('id'))->update("m09_admin_bank");
					success("Admin Bank status changed.");
				}
			}
		}
		
		/*----------------- CHANGE STATUS FROM BOTH SIDE------------------*/
		public function change_user_status()
		{
			if(post('status') == 0 || post('status') == 1 || post('status') == 2){
			/*	if(post('proc') == 1){       // of Unit Master
					$this->db->set("unit_status", post('status'))->where('unit_id',post('id'))->update("p01_unit");
					success("Unit status changed.");
				} */
			}
		}
		
		
		/*----------------- UPDATE FROM BOTH SIDE------------------*/
		
		public function update_user_value()
		{ 
			if( post('val') <> "") {
				if(post('proc') == 1){		// of User DOB
					$this->db->set("user_dob", post('val'))->where('user_reg_id',post('id'))->update("m03_user_detail");
				}
				elseif(post('proc') == 2){		// of User Mobile
					$this->db->set("user_mobile_no", post('val'))->where('user_reg_id',post('id'))->update("m03_user_detail");
				} 
				elseif(post('proc') == 3){		// of User Email
					$this->db->set("user_email", post('val'))->where('user_reg_id',post('id'))->update("m03_user_detail");
				} 
				elseif(post('proc') == 4){		// of User State
					$this->db->set("user_state", post('val'))->where('user_reg_id',post('id'))->update("m03_user_detail");
				} 
				elseif(post('proc') == 5){		// of User City
					$this->db->set("user_city", post('val'))->where('user_reg_id',post('id'))->update("m03_user_detail");
				} 
				elseif(post('proc') == 6){		// of User Pincode
					$this->db->set("user_pincode", post('val'))->where('user_reg_id',post('id'))->update("m03_user_detail");
				} 
				elseif(post('proc') == 7){		// of User Address
					$this->db->set("user_address", post('val'))->where('user_reg_id',post('id'))->update("m03_user_detail");
				} 
				
			}
		}
				
		/*----------------- Get Slot Timing ------------------*/
		
		public function get_slot_timing()
		{
			print_r($this->input->post()); die;
			$this->db->where('m00_id',$this->input->post('id'));
			$query['rec'] = $this->db->get('m00_setconfig')->result();
			$json=json_encode($query);
			echo $json;
		}

		/*-------------------Remove Product Images------------------*/
		
		public function remove_product_image()
		{
			$img_id		= post('img_id');
			$pr_vari_id	= post('pr_vari_id');
			$img_name = $this->db->where('pr_img_id', $img_id)->get('p09_product_img')->row()->pr_img_name;
			remove_images('images/product/'.$pr_vari_id.'/', $img_name);						
			delete('p09_product_img',['pr_img_id' => $img_id]);
			echo json_encode('done');
		}	
		
		/*-------------------Remove Product VIDEO------------------*/
		
		public function remove_product_video()
		{
			$vid_id		= post('vid_id');
			$pr_vari_id	= post('pr_vari_id');
			delete('p10_product_video',['pr_v_id' => $vid_id]);
			echo json_encode('done');
		}
		
	/*-------------------Remove Product Assigned Menu ------------------*/
	
		public function remove_product_menu()
		{
			$vid_id		= post('vid_id');
			$menu_id	= post('menu_id');
			delete('p12_product_show_menu',['pr_sh_m_id' => $menu_id]);
			echo json_encode('done');
		}	
		
	/*-------------------Cart Update ------------------*/
				
		public function qty_update()
		{
			$id="";
			$type="";
			$id = $this->input->post('id');
			$type = $this->input->post('type');
			$qty= '';
			
			if($type == 1) // Updated to Minus one
			{
				$this->db->query("UPDATE `tr44_cart_product` SET `tr44_qty` = tr44_qty-1 WHERE `tr44_id` = ".$id);
				$qty = $this->db->query("SELECT `tr44_qty` AS qty FROM `tr44_cart_product` WHERE `tr44_id` = ".$id)->row()->qty;
				if($qty == 0)
				{
					$qty = $this->db->query("DELETE FROM `admin_uniqueforce`.`tr44_cart_product` WHERE `tr44_id` = ".$id);
				}
			}
			if($type == 2) // Updated to Plus one
			{
				$this->db->query("UPDATE `tr44_cart_product` SET `tr44_qty` = tr44_qty+1 WHERE `tr44_id` = ".$id);
			}
			echo 'Quantity updated'; 
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		



		
		//-------------------Get member name------------------
		
		public function get_member_name()
		{
			$id="";
			$id=$this->input->post('txtintuserid');
			$query['name'] = get_intro_name($id);						// Get Details From Admin_Helper
			$json=json_encode($query);
			echo $json;;
		}
		
		public function get_city()
		{
			$this->db->where('m_parent_id',$this->input->post('ddstate'));
			$this->db->where('m_status',1);
			$query['rec'] = $this->db->get('m02_location')->result();
			$json=json_encode($query);
			echo $json;
		}
		
		//Validate Mobile No
		public function validate_mobile()
		{
			$query_D = $this->db->query("SELECT COUNT(*) as count_mobile FROM `m03_user_detail` where `or_m_mobile_no`=".$this->input->post('phone'));
			$rows = $query_D->row();
			$query['mob'] = $rows->count_mobile;
			$json=json_encode($query);
			echo $json;
		}
		
		
	}


	
?>