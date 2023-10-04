<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Master_model extends CI_Model
	{
		
		/////////////////////////////////////////////////////////////////////////
		//////////     Configuration Data In Model     ///////
		//////////////////////////////////////////////////////////////////////
		
		public function select_config()
		{
			$this->db->where('m00_login_id',1);
			return $this->db->get('m00_admin_login');
		}
 
		//////////////////////////////////////////////////////////////////
		//////////     Insert New Branch     ///////
		//////////////////////////////////////////////////////////////
		
		public function insert_branch()
		{

           $bcode=  trim(post('txtbcode'));
           $bmobile=  trim(post('txtmobile'));
            $code_coun 		= q("SELECT COUNT(*) coun FROM `m03_branch` WHERE `branch_code` = '$bcode'")->row()->coun;
			if($code_coun > 0 ) {
                $msg = "Branch Code already in use!";
                error($msg);
                return;
            }

            $bmobile_coun 		= q("SELECT COUNT(*) coun FROM `m03_branch` WHERE `branch_contact_no` = '$bmobile'")->row()->coun;
			if($code_coun > 0 ) {
                $msg = "Branch Mobile already in use!";
                error($msg);
                return;
            }

			$info = array(
				'branch_id'			=>	'',
				'branch_code'		=>	$bcode,
				'branch_name'		=>	post('txtname'),
				'contact_person'	=>	post('txtbhead'),
				'contact_no'		=>	post('txtmobile'),
				'branch_email'		=>	post('txtemail'),
				'state_id'			=>	post('branch_state'),
				'city_id'			=>	post('branch_city'),
				'branch_address'	=>	post('txtaddress'),
				'branch_password'	=>	post('txtpassword'),
				'proc'				=>	1
			);
			
			$query 		= " CALL sp06_branch(?" . str_repeat(",?", count($info)-1) . ",@msg) ";
			$this->db->query($query, $info);
			$login_id 	= $this->db->query("SELECT @msg as message")->row()->message;
			
			$data['pass'] = post('txtpassword');
			$data['login'] = $login_id;
			success("Branch added.");
			return $data;
		}
	
		//////////////////////////////////////////////////////////////////
		//////////     Update Branch     ///////
		//////////////////////////////////////////////////////////////
		
		public function update_branch($id)
		{

			$code_coun 		= q("SELECT COUNT(*) coun FROM `m03_branch` WHERE `branch_id` = '$id'")->row()->coun;
			if($code_coun == 0 ) {
                $msg = "Branch Not in use!";
                error($msg);
                return;
            }

			$info = array(
				'branch_id'		=>	$id,
				'branch_code'		=>	$bcode,
				'branch_name'				=>	post('txtname'),
				'contact_person'				=>	post('txtbhead'),
				'contact_no'			=>	post('txtmobile'),
				'branch_email'				=>	post('txtemail'),
				'state_id'				=>	post('branch_state'),
				'city_id'			=>	post('branch_city'),
				'branch_address'				=>	post('txtaddress'),
				'branch_password'				=>	post('txtpassword'),
				'proc'					=>	2
			);
 			$query = " CALL sp06_branch(?" . str_repeat(",?", count($info)-1) . ",@msg) ";
			$this->db->query($query, $info);
			$data['login_id'] = $this->db->query("SELECT @msg as message")->row()->message;
			success("Branch updated.");
			return $data;
		}
		








		
		public function update_config()
		{
			if(post('txtuserpass') == post('txtuserpinpass')){
				$mcf=array(
				'm00_login_id'		=> $this->uri->segment(3),
				'm00_username'		=> post('txtusername'),
				'm00_password'		=> post('txtuserpass'),
				'm00_pinpassword'	=> post('txtuserpinpass'),
				'm00_admin_type'	=> post('txtusertype'),
				'm00_admin_status'	=> post('txtuserstatus')
				);
				$query="CALL sp_setconfig(?" . str_repeat(",?", count($mcf)-1) . ")";
				$this->db->query($query,$mcf);
				return "Login details updated successfully!!";
				} else {
				return "Confirm Password not matched!";
			}
		}
 
		/////////////////////////////////////////////////////////////////////////
		//////////     Upload Images in Multiple size    ///////
		//////////////////////////////////////////////////////////////////////
		 
		 
		function _create_thumbs($path, $product_id, $file_name){
		// Image resizing config
		
		//	if (!file_exists($path.$product_id.'/l/')) {   mkdir($path.$product_id.'/l/', 0777, true);}
			if (!file_exists($path.$product_id.'/m/')) {   mkdir($path.$product_id.'/m/', 0777, true);}
			if (!file_exists($path.$product_id.'/s/')) {   mkdir($path.$product_id.'/s/', 0777, true);}
			
			$config = [
            // Large Image
			  /*  [
					'image_library' => 'GD2',
					'source_image'  => $path.$product_id.'/x/'.$file_name,
					'maintain_ratio'=> TRUE,
					'width'         => 525,
					'height'        => 525,
					'new_image'     => $path.$product_id.'/l/'.$file_name
				], */
				// Medium Image
				[
					'image_library' => 'GD2',
					'source_image'  => $path.$product_id.'/x/'.$file_name,
					'maintain_ratio'=> TRUE,
					'width'         => 400,
					'height'        => 400,
					'quality'       => 80,
					'new_image'     => $path.$product_id.'/m/'.$file_name
				],
				// Small Image
			   [
					'image_library' => 'GD2',
					'source_image'  => $path.$product_id.'/x/'.$file_name,
					'maintain_ratio'=> TRUE,
					'width'         => 75,
					'height'        => 75,
					'new_image'     => $path.$product_id.'/s/'.$file_name
			   ]
		   ];
			
			$this->load->library('image_lib', $config[0]);
			
			foreach ($config as $item){
				$this->image_lib->initialize($item);
				if(!$this->image_lib->resize()){
					return false;
				}
				$this->image_lib->clear();
			}
		}
	
		/////////////////////////////////////////////////////////////////////////
		//////////     Upload Image     ///////
		//////////////////////////////////////////////////////////////////////
	 
		public function upload_image($path, $id, $file)
		{
			if (!file_exists($path.$id.'/x/')) { mkdir($path.$id.'/x/', 0777, true);}
			$file_name = $_FILES[$file]['name'];	
			$filealias = "";
			$this->load->library('upload');	
			
			if($file_name != '')
			{
				$config = [
					'upload_path'   => $path.$id.'/x/',
					'allowed_types' => 'gif|jpg|png|jpeg',
					'encrypt_name'	=> TRUE,
					'max_size'      => "5000",
					'max_width'     => "5000",
					'max_height'    => "5000",
					'overwrite'     => FALSE
					];
				
				$this->upload->initialize($config);
				$this->upload->do_upload();
				$finfo=$this->upload->data();
				$filealias=($finfo['file_name']);
				$this->_create_thumbs($path, $id, $filealias);
				return $filealias;
			}
			else
			{
				return $filealias;
			}
		}
		
		/////////////////////////////////////////////////////////////////////////
		//////////     Get All Products     ///////
		//////////////////////////////////////////////////////////////////////
	 
		public function allProducts()
		{
			$offset = 0;
			$cond = "select * from v03_product_detail_lite where ";
			if(get('menuId')){
			$first 	= q("SELECT GROUP_CONCAT(`front_menu_id`) AS k FROM `m06_front_menu` WHERE `front_menu_parent_id` = ".get('menuId'))->row()->k;
			$second = q("SELECT GROUP_CONCAT(`front_menu_id`) as k FROM `m06_front_menu` WHERE FIND_IN_SET(`front_menu_parent_id`, ('$first'))")->row()->k;
				$cond.= "( pr_sh_m_fr_menu_id = ".get('menuId')." or  pr_sh_m_fr_menu_id in ('$first') or pr_sh_m_fr_menu_id in ('$second')) and ";
			}
			if(get('page')){
				$offset = (get('page')-1)*PAGE_LIMIT;
			}
			$cond.= "pr_status = 1 and pr_vari_status = 1 ";
			$cond.= "group by pr_id ";
			
			if(get('filter') <> 'recomm') {
			if(get('filter') == 'new')
				$cond.= "order by pr_date desc,  badges_id asc  ";
			if(get('filter') == 'plow')
				$cond.= "order by pr_vari_actual_price asc  ";
			if(get('filter') == 'phigh')
				$cond.= "order by pr_vari_actual_price desc  ";
			}		
			
			$cond.= "limit $offset, ".PAGE_LIMIT;
			$rec = q($cond)->result();
			//l();
			return $rec;
		}
		
		/////////////////////////////////////////////////////////////////////////
		//////////      Get One Product with Details     ///////
		//////////////////////////////////////////////////////////////////////
	 
		public function product()
		{
			$productId 	= get('productId');
			$variantId 	= get('variantId');
			$data 		= "";
			if($productId <> "" && $variantId <> ""){
				$data['product'] =	$this->db->where('pr_id', $productId)->where('pr_vari_id', $variantId)
											->group_by('pr_id')
											->get('v05_product_detail')->row(); 
				$data['product_variant'] = $this->db->where('pr_vari_pr_id', $productId)->where('pr_vari_status', 1)->group_by('pr_vari_id')->get('v06_product_variant')->result();
			//	l();
			}
   			return $data;
		}
		
		/////////////////////////////////////////////////////////////////////////
		//////////      Get One Product with Details     ///////
		//////////////////////////////////////////////////////////////////////
	 
		public function category()
		{
			$data['cat'] = $this->db->query('SELECT * FROM `p03_category` WHERE `pr_cat_status` = 1 AND (`pr_cat_id` IN (1,5,13));')->result();
   			return $data;
		}
		
		/////////////////////////////////////////////////////////////////////////
		//////////      Form validation     ///////
		//////////////////////////////////////////////////////////////////////
		
		
		public function validate_form_address($id){
			$this->form_validation->set_rules('user_addr_name', 'Name', 'required');
			$this->form_validation->set_rules('user_addr_mobile', 'Mobile', 'required|min_length[10]|max_length[10]');
			$this->form_validation->set_rules('user_addr_address', 'Address', 'required');
/* 			$this->form_validation->set_rules('user_addr_state', 'State', 'required');
			$this->form_validation->set_rules('user_addr_city', 'City', 'required'); */
			$this->form_validation->set_rules('user_addr_pincode', 'Zipcode', 'required|min_length[6]|max_length[6]');
			if($this->form_validation->run() == FALSE){
			if(fetch_class() <> "User"){
				echo json_encode(['success'=>false, 'errors'=>$this->form_validation->error_array()]);
				die();
			} else {
				return ['success'=>false, 'errors'=>$this->form_validation->error_array()];
			}
			}
			$data['user_addr_name'] 		= post('user_addr_name');
			$data['user_addr_mobile'] 		= post('user_addr_mobile');
			$data['user_addr_address'] 		= post('user_addr_address');
			$data['user_addr_state'] 		= post('user_addr_state');
			$data['user_addr_city'] 		= post('user_addr_city');
			$data['user_addr_pincode'] 		= post('user_addr_pincode');
	     	$data['user_addr_landmark1'] 	= post('user_Landmark1');
			$data['user_addr_landmark2'] 	= post('user_Landmark2');
			$data['user_reg_id'] = $id;
			
			return($data);
		}
		
	}
?>		