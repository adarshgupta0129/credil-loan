<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Front_API extends CI_Controller {
		
		function __construct()
		{
			parent::__construct();
			header("Content-Type:application/json");
			$this->load->model('Master_model');
			$this->_is_tokenexist_in();
		}
		
		/////////////////////////////////////////////////////////////////////////
		//////////     			Check Token Is valid		  	  ///////
		//////////////////////////////////////////////////////////////////////
		
		public function _is_tokenexist_in()
		{			 
			if($this->input->server('REQUEST_METHOD') !== "GET") 
			{ 
				fail_response('Request method is wrong.');
			}
		}
		
		public function allProducts()
		{
			$prod_array = array();
			$rec = $this->Master_model->allProducts();	
  			foreach($rec as $row)
			{
				$image = get_product_one_image($row->pr_vari_id);
				/*$image = get_product_image($row->pr_id);
					foreach($image as $img)
					{
					$images =  $img->pr_img_name;
					$img_array[] = $images;
				}*/ 
				$da['PR_ID']				= $row->pr_id;
				$da['PR_VARIANT_ID'] 		= $row->pr_vari_id;
				$da['PR_NAME'] 				= $row->pr_name;
				//$da['PR_IMAGE'] 			= $img_array;
				//$da['PR_SINGLE_IMAGE'] 		= $images;
				$da['PR_SINGLE_IMAGE'] 		= $image->pr_img_name;
				$da['PR_CATEGORY_ID_L1'] 	= $row->pr_cat1;
				$da['PR_CATEGORY_ID_L2'] 	= $row->pr_cat2;
				$da['PR_CATEGORY_ID_L3'] 	= $row->pr_cat3;
				$da['PR_CODE'] 				= $row->pr_code;
				$da['PR_SHOW_PRICE']	 	= $row->pr_vari_show_price;
				$da['PR_PRICE'] 			= $row->pr_vari_actual_price;
 				$da['PR_BADGE_STYLE']		= $row->badges_style;
				$da['PR_BADGE_NAME'] 		= $row->badges_name;
				$prod_array[] = $da;
			}
			success_response($prod_array);
		}
		
		public function product()
		{
			$data = $this->Master_model->product();
			
			$product = $data['product'];
			$variant = $data['product_variant'];
			$image   = get_product_one_image($product->pr_vari_id);

			$da['PR_ID']				= $product->pr_id;
			$da['PR_VARIANT_ID'] 		= $product->pr_vari_id;
			$da['PR_DESCRIPTION'] 		= $product->pr_description;
			$da['PR_NAME'] 				= $product->pr_name;
			$da['PR_SINGLE_IMAGE'] 		= $image->pr_img_name;
			$da['PR_CATEGORY_ID_L1'] 	= $product->pr_cat1;
			$da['PR_CATEGORY_ID_L2'] 	= $product->pr_cat2;
			$da['PR_CATEGORY_ID_L3'] 	= $product->pr_cat3;
			$da['PR_CODE'] 				= $product->pr_code;
			$da['PR_SHOW_PRICE']	 	= $product->pr_vari_show_price;
			$da['PR_PRICE'] 			= $product->pr_vari_actual_price;
			$da['PR_BADGE_STYLE']		= $product->badges_style;
			$da['PR_BADGE_NAME'] 		= $product->badges_name; 
			$prod_array['product']	= $da;
			
			$images = get_product_image($product->pr_id, $product->pr_vari_id);
			foreach($images as $img)
			{
				$da1['IMG']					 	=  $img->pr_img_name;
				
				$prod_array['product_images'][] = $da1;
			}
			
			foreach($variant as $row)
			{
				$da2['VR_VARIANT_ID'] 				= $row->pr_vari_id;
				$da2['VR_PR_ID']					= $row->pr_vari_pr_id;
				$da2['VR_NAME'] 					= $row->vari_name;
				$da2['VR_SINGLE_IMAGE'] 			= $row->pr_img_name;
				$da2['VR_SHOW_PRICE']	 			= $row->pr_vari_show_price;
				$da2['VR_PRICE'] 					= $row->pr_vari_actual_price;
				$da2['VR_UNIT_VALUE']				= $row->pr_vari_unit_value;
				$da2['VR_UNIT'] 					= $row->unit_name;
				
				$prod_array['product_variant'][] 	= $da2;
			}
			
			success_response($prod_array);
		}	
		
		public function category()
		{
			$array = array();
			$array1 = array();
			$array2 = array();
			
			$cat = $data['cat'] = q("SELECT front_menu_id, front_menu_name, ifnull(front_menu_img, '') front_menu_img FROM `m06_front_menu` WHERE `front_menu_parent_id` = 0 and front_menu_status = 1")->result();
			
			foreach($cat as $p)
			{
				$id = $p->front_menu_id;
				$show_cat = q("SELECT front_menu_id, front_menu_name, ifnull(front_menu_img, '') front_menu_img FROM `m06_front_menu` WHERE `front_menu_parent_id` = $id and front_menu_status = 1")->result();
				
				foreach($show_cat as $c)
				{
					$id = $c->front_menu_id;
					$show_cat1 = q("SELECT front_menu_id, front_menu_name, ifnull(front_menu_img, '') front_menu_img FROM `m06_front_menu` WHERE `front_menu_parent_id` = $id and front_menu_status = 1")->result();
					
					foreach($show_cat1 as $m)
					{
						$da2['L_CAT_ID']		= $m->front_menu_id;
						$da2['L_CAT_NAME'] 		= $m->front_menu_name; 
						$da2['L_CAT_IMG'] 		= $m->front_menu_img;
						
						$array2[] = $da2;
						unset($da2);
					}
					
				
					$da1['S_CAT_ID']		= $c->front_menu_id;
					$da1['S_CAT_NAME'] 		= $c->front_menu_name; 
					$da1['S_CAT_IMG'] 		= $c->front_menu_img;
					$da1['S_CAT_SUB'] 		= $array2; 
					
					$array1[] = $da1;
					unset($da1);
				
				}
				
				$da['CAT_ID']			= $p->front_menu_id;
				$da['CAT_NAME'] 		= $p->front_menu_name;
				$da['CAT_IMG'] 			= $p->front_menu_img;
				$da['SUB_CAT'] 			= $array1;
				$array[]				= $da;
				
				unset($da);
			}
			
			success_response($array);
		}	
		
		public function addon()
		{
			$data['addon'] = $this->db->where('addon_status',1)->get('p14_addons')->result();
			success_response($data);
		}	
		
		public function location()
		{
			$data = $this->db->where('loc_id!=',0)->where('loc_status',1)->limit(100,0)->get('m02_location')->result();
			success_response($data);
		}	
		
		
	}
	
?>			