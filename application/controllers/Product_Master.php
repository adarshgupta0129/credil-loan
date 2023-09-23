<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Product_Master extends CI_Controller {
		
		/////////////////////////////////////////////////////////////////////////
		//////////     Constructor In Master Controller    ///////
		//////////////////////////////////////////////////////////////////////
		
		public function __construct()
		{
			parent::__construct();      
			$this->_is_logged_in();
			$this->data['page'] = "Product Master";
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
			$this->load->view('productmaster/'.$page_name, $data);
			$this->load->view('common/footer');
			
		}
		
		
		/////////////////////////////////////////////////////////////////////////
		//////////     Start UNIT Master    ///////
		//////////////////////////////////////////////////////////////////////
		
		public function view_unit()
		{
			$data = [
			'form' 	=> "Unit Master",
			'table' => "View All Units",
			'units' => $this->db->order_by("unit_name",'asc')->get('p01_unit')->result()
			];
 			$this->view('view_unit',$data);
		}
		
		public function add_unit()
		{
			insert("p01_unit", ["unit_name" => post('txtunit')]);			
			success(post('txtunit'). " added as unit.");
			header("Location:".base_url()."Product_Master/view_unit");
		}	
		
		/////////////////////////////////////////////////////////////////////////
		//////////     Start VARIANT Master    ///////
		//////////////////////////////////////////////////////////////////////
		
		public function view_variant()
		{
			$data = [
			'form' 	=> "Variant Master",
			'table' => "View All Variant",
			'variants' => $this->db->where('vari_id!=',0)->order_by("vari_name",'asc')->get('p02_variant')->result()
			];
 			$this->view('view_variant',$data);
		}
		
		public function add_variant()
		{
			insert("p02_variant", ["vari_name" => post('txtvariant')]);			
			success(post('txtunit'). " added as Variant.");
			header("Location:".base_url()."Product_Master/view_variant");
		}
		
		//////////////////////////////////////////////
		//////////     Start Category Master    ///////
		///////////////////////////////////////////
		
		public function view_category()
		{
			$data = [
				'table'	=> "View Category",
				'form' 	=> "Action in Category",
				'cat'	=> $this->db->where("pr_cat_id!=",0)->where("pr_cat_parent_id",0)->get('p03_category')->result()
 			];
 			$this->view('view_category',$data);
		}
		
		public function set_category()
		{
			$file = '';
			$path = 'images/category/';
			/* echo "<pre>";
				print_r($_FILES);die;
			p(); */
			if(post('cat_id') <> '0' && post('cat_name') <> "" && post('ddstatus') <> "")
			{
				$this->db
				->set('pr_cat_name', post('cat_name'))
				->set('pr_cat_status', post('ddstatus'))
				->where('pr_cat_id', post('cat_id'))->update('p03_category');
				$file = $this->Master_model->upload_image($path, post('cat_id'), 'userfile');
				
				if($file <> "")
				{
 					$img_upt = [
					'pr_cat_img'	=> $file
					];
					update("p03_category", $img_upt, ['pr_cat_id'=>post('cat_id')]);
				}
				success("Category updated");
			}
			else if(post('cat_name') <> "" && post('cat_parent_id') <> "" && post('ddstatus'))
			{
  			 	$data = [
				'pr_cat_name' 		=> post('cat_name'),
				'pr_cat_parent_id' 	=> post('cat_parent_id'),
				'pr_cat_status' 	=> post('ddstatus')
				];
				$this->db->insert("p03_category",$data);
				$cat_id = $this->db->insert_id();
				$file = $this->Master_model->upload_image($path, $cat_id, 'userfile');
				if($file <> "")
				{
 					$img_upt = [
					'pr_cat_img'		=> $file
					];
					update("p03_category", $img_upt, ['pr_cat_id'=>$cat_id]);
				}
				success("Category Added");
			}
			header("Location:".base_url()."Product_Master/view_category");
		}
		
		/////////////////////////////////////////////////////////////////////////
		//////////     Start Product Type Master    ///////
		//////////////////////////////////////////////////////////////////////
		
		public function view_type()
		{
			$data = [
			'form' 		=> "Product Type",
			'table' 	=> "View All Type",
			'type' 		=> $this->db->order_by("type_name","asc")->where("type_name!=",null)->get("p04_type	")->result()
			];
			//	l();
 			$this->view('view_type',$data);
		}
		
		public function add_type()
		{
			insert("p04_type", ["type_name" => post('txtpr_type')]);			
			success(post('txtprtype'). " added as product sub category.");
			header("Location:".base_url()."Product_Master/view_type");
		}
		/////////////////////////////////////////////
		//////////     Start Product Master    /////
		///////////////////////////////////////////
		
		public function view_add_product()
		{
			$data = [
			'form' 		=> "Add New Product",
			'table' 	=> "Add New Product",
			'variants' 	=> $this->db->where("vari_status",'1')->order_by("vari_name",'asc')->get('p02_variant')->result(),
			'units' 	=> $this->db->where("unit_status",'1')->order_by("unit_name",'asc')->get('p01_unit')->result(),
			'menu' 		=> $this->db->where('front_menu_status', 1)->order_by('front_menu_orderby', 'asc')->get('m06_front_menu')->result(),
			'category' 	=> $this->db->where('pr_cat_id!=', 0)->where('pr_cat_status', 1)->order_by('pr_cat_name', 'asc')->get('p03_category')->result(),
			'type' 		=> $this->db->where('type_id!=', 0)->where('type_status', 1)->order_by('type_name', 'asc')->get('p04_type')->result(),
			'badges' 	=> $this->db->where('badges_id!=', 0)->where('badges_status', 1)->order_by('badges_name', 'asc')->get('m05_badges')->result(),
			'group' 	=> $this->db->order_by("loc_gr_name","asc")->get("m09_location_group")->result(),
			'addons'	=> $this->db->query("SELECT addon_id,addon_name FROM `p14_addons`")->result(),
			'deli_slot_goup'=>$this->db->query("SELECT m12_delivery_slot_group.* FROM `m12_delivery_slot_group` ")->result(),
			];
 			$this->view('view_add_product',$data);
		}
		
		public function add_product()
		{		
			$this->db->trans_begin();
			$txtname 		= post('txtname');
			$txtdesc 		= post('txtdesc');
			$ddcat1 		= post('ddcat1');
			$ddcat2 		= post('ddcat2');
			$ddcat3 		= post('ddcat3');
			$userfile 		= post('userfile');
			$ddbadges 		= post('ddbadges');
			$txtprcode 		= post('txtprcode');
			
			$txtvideo 		= post('txtvideo');
			$txtamt 		= post('txtamt');
			$txtshowamt 	= post('txtshowamt');
			$txtunit 		= post('txtunit');
			$ddunit 		= post('ddunit');
			$txthsn 		= post('txthsn');
			$txthour 		= post('txthour');
			$txtmenu3 		= explode(',', post('txtmenu3'));
			
			$ddtype 		= post('ddtype');
			$ddlocgrgoup 	= post('ddlocgrgoup');
			$videos			= explode(',', post('txtvideo'));
			//p($ddtype );
			if($txtname <> "" && $txtdesc <> "" /*&& $ddcat1 <> "" && $ddcat1 <> 0 && $ddcat2 <> "" && $ddcat2 <> 0 */)
			{
				$pr = [
					'pr_name'		 		=> $txtname,
					'pr_description' 		=> trim($txtdesc),
					'pr_badges' 			=> $ddbadges,
					'pr_code' 				=> $txtprcode,
					'pr_cat1'		 		=> $ddcat1,
					'pr_cat2'		 		=> $ddcat2,
					'pr_cat3'		 		=> $ddcat3,
					'pr_min_order_timing'	=> $txthour,
					'pr_hsn'		 		=> $txthsn,
					'pr_is_designer'		=> !empty(post("is_designer")) ? post("is_designer") : "NO"
				];
				insert("p07_product", $pr);
				$mainId = $product_id = $this->db->insert_id();
				
				
				if($product_id <> "" && $product_id <> 0)
				{
					$vari = [
					'pr_vari_show_price'	=> $txtshowamt,
					'pr_vari_actual_price'	=> $txtamt,
					'pr_vari_pr_id'			=> $product_id,
					'pr_vari_unit_value'	=> $txtunit,
					'pr_vari_unit_id'		=> $ddunit
					];
					insert("p08_product_variant", $vari);	
					$product_id = $this->db->insert_id();
					
					if($product_id <> "" && $product_id <> 0)
					{
						if(!empty($ddtype)) {
							foreach($ddtype as $t) {
								$ty = [
								"pr_type_pr_id" => $mainId,
								"pr_type_type_id" => $t
								];
								insert("p13_product_type", $ty);
							}
						}
						
						if(!empty($videos)) {
							foreach($videos as $v) {
								$vi = [
								'pr_v_pr_id'	=> $mainId,
								'pr_v_url'		=> $v
								];
								insert("p10_product_video", $vi);
							}
						}
						
						if(!empty($ddlocgrgoup)) {
							foreach($ddlocgrgoup as $g) {
								$gr = [
								'pr_loc_pr_id'	=> $mainId,
								'pr_loc_gr_id'	=> $g
								];
								insert("p11_product_location", $gr);
							}
						}

						if(!empty(post("ddaddons"))) {
							foreach(post("ddaddons") as $addon) {
								$gr = [
								'product_id'	=> $mainId,
								'add_on_id'		=> $addon
								];
								insert("product_addons", $gr);
							}
						}

						if(!empty(post("ddTimeSlotGroup"))) {
							foreach(post("ddTimeSlotGroup") as $timeSlotGroup) {
								$gr = [
								'product_id'	=> $mainId,
								'group_id'		=> $timeSlotGroup
								];
								insert("p14_pro_deli_slot_groups", $gr);
							}
						}
						
						if(!empty($txtmenu3)) {
							foreach($txtmenu3 as $m) {
								$me = [
								'pr_sh_m_pr_id'		=> $mainId,
								'pr_sh_m_fr_menu_id'	=> $m,
								];
								insert("p12_product_show_menu", $me);
							}
						}
						$this->_upload_product_image($product_id);
						success("Product added");
					}
					else 
					{
						error("Something went wrong!");					
					}
				}
				else 
				{
					error("Something went wrong!");					
				}
			}
			else 
			{
				error("Please fill all the required fields");			
			}
			
			if( $this->db->trans_status() === FALSE){$this->db->trans_rollback();}
			else{ $this->db->trans_commit();}
			header("Location:".base_url()."Product_Master/view_add_product");
		}
		
		
		public function _upload_product_image($product_id)
		{
			$path = 'images/product/';
			if (!file_exists($path.$product_id.'/x/')) {   mkdir($path.$product_id.'/x/', 0777, true);}
			
			$this->load->library('upload');
			$dataInfo = array();
			$files = $_FILES;
			$cpt = count($_FILES['userfile']['name']);
			for($i=0; $i<$cpt; $i++)
			{
				$_FILES['userfile']['name']= $files['userfile']['name'][$i];
				$_FILES['userfile']['type']= $files['userfile']['type'][$i];
				$_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
				$_FILES['userfile']['error']= $files['userfile']['error'][$i];
				$_FILES['userfile']['size']= $files['userfile']['size'][$i];    
				
				$config = [
				'upload_path'   => $path.$product_id.'/x/',
				'allowed_types' => 'gif|jpg|png|jpeg',
				'encrypt_name'	=> TRUE,
				'max_size'      => "5000",
				'max_width'     => "5000",
				'max_height'    => "5000",
				'overwrite'     => FALSE
				];
				
				$this->upload->initialize($config);
				$this->upload->do_upload();
				$dataInfo[] = $this->upload->data();				
				$this->Master_model->_create_thumbs($path, $product_id, $dataInfo[$i]['file_name']);				
				$img = [
				'pr_img_pr_vari_id' => $product_id,
				'pr_img_name' => $dataInfo[$i]['file_name']
				];
				insert('p09_product_img', $img);
			}
		}
		
		
		public function view_product_variant()
		{
			$data = [
			'form' 		=> "Add New Variants",
			'table' 	=> "Add Variants",
			'units' 	=> $this->db->where("unit_status",'1')->order_by("unit_name",'asc')->get('p01_unit')->result(),					
			'product' 	=> $this->db->where("pr_status",'1')->order_by("pr_name",'asc')->get('p07_product')->result(),					
			'variants' 	=> $this->db->where("vari_status",'1')->order_by("vari_name",'asc')->get('p02_variant')->result()
			];
 			$this->view('view_product_variant',$data);
		}
		
		public function view_add_product_variant()
		{
			$this->db->trans_begin();
			$txtifvariant 		= post('txtifvariant');
			$ddproduct 			= post('ddproduct');
			$ddvariant 			= post('ddvariant');
			$ddunit 			= post('ddunit');
 			$k = array();
			
 			if(!empty($ddunit)) {
				foreach($ddunit as $t) {
					$vari = [
					'pr_vari_vari_id'		=> $ddvariant,
					'pr_vari_show_price'	=> 0,
					'pr_vari_actual_price'	=> 0,
					'pr_vari_pr_id'			=> $ddproduct,
					'pr_vari_unit_value'	=> 0,
					'pr_vari_unit_id'		=> $t
					];
					insert("p08_product_variant", $vari);
					$last_id = $this->db->insert_id();
					array_push($k,$last_id);
					
				}
			}
			
			$variant_amt 		= post('variant_amt');
			$variant_show_amt 	= post('variant_show_amt');
			$variant_img 		= post('variant_img');
			$variant_unit		= post('variant_unit');
			
			$variant_images = array_combine($k,$variant_unit);
			if(!empty($variant_images))
			{
				$i = 0;
				$this->load->library('upload');
				$dataInfo = array();
				$files = $_FILES;
				$path = 'images/product/';
				foreach($variant_images as $key=>$val)
				{
					if (!file_exists($path.$key.'/x/')) {   mkdir($path.$key.'/x/', 0777, true);}
					
					$_FILES['userfile']['name']= $files['userfile']['name'][$i];
					$_FILES['userfile']['type']= $files['userfile']['type'][$i];
					$_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
					$_FILES['userfile']['error']= $files['userfile']['error'][$i];
					$_FILES['userfile']['size']= $files['userfile']['size'][$i];    
					
					$config = [
					'upload_path'   => $path.$key.'/x/',
					'allowed_types' => 'gif|jpg|png|jpeg',
					'encrypt_name'	=> TRUE,
					'max_size'      => "5000",
					'max_width'     => "5000",
					'max_height'    => "5000",
					'overwrite'     => FALSE
					];
					
					$this->upload->initialize($config);
					$this->upload->do_upload();
					$dataInfo[] = $this->upload->data();				
					$this->Master_model->_create_thumbs($path, $key, $dataInfo[$i]['file_name']);
					
					$img = [
					'pr_img_pr_vari_id' => $key,
					'pr_img_name' => $dataInfo[$i]['file_name']
					];
					insert('p09_product_img', $img);
					
					$i++;					
				}
			}
			
			$variant_unit = array_combine($k,$variant_unit);
			if(!empty($variant_unit)){
				foreach($variant_unit as $key=>$val){
					$vari_upt = [
					'pr_vari_unit_value'		=> $val
					];
					update("p08_product_variant", $vari_upt, ['pr_vari_id'=>$key]);
				}
			}
			
			$ddunit = array_combine($k,$ddunit);
			if(!empty($ddunit)){
				foreach($ddunit as $key=>$val){
					$vari_upt = [
					'pr_vari_unit_id'		=> $val
					];
					update("p08_product_variant", $vari_upt, ['pr_vari_id'=>$key]);
				}
			}
			
			$variant_amt = array_combine($k,$variant_amt);
			if(!empty($variant_amt)){
				foreach($variant_amt as $key=>$val){
					$vari_upt = [
					'pr_vari_actual_price'		=> $val
					];
					update("p08_product_variant", $vari_upt, ['pr_vari_id'=>$key]);
				}
			}
			
			$variant_show_amt = array_combine($k,$variant_show_amt);
			if(!empty($variant_show_amt)){
				foreach($variant_show_amt as $key=>$val){
					$vari_upt = [
					'pr_vari_show_price'		=> $val
					];
					update("p08_product_variant", $vari_upt, ['pr_vari_id'=>$key]);
				}
			}
			
			success("Product variant added");
			if( $this->db->trans_status() === FALSE){$this->db->trans_rollback();}
			else{ $this->db->trans_commit();}
			
			header("Location:".base_url()."Product_Master/view_product_variant");
		}
		
		/////////////////////////////////////////////////////////////////////////
		//////////     Start VARIANT Master    ///////
		//////////////////////////////////////////////////////////////////////
		
		public function view_product_addons()
		{
			$data = [
			'form' 	=> "Product Addon",
			'table' => "View all Addons",
			'addons' => $this->db->order_by("addon_name",'asc')->get('p14_addons')->result()
			];
 			$this->view('view_product_addons',$data);
		}
		
		public function add_product_addons()
		{
			$this->db->trans_begin();
			$path = 'images/addon/';
			$addon = [
			'addon_name'		=> post('txtaddonname'),
			'addon_image'		=> 'placeholder.png',
			'addon_amount'		=> post('txtamt'),
			'addon_max_qty'		=> post('txtmaxqty'),
			];
			insert("p14_addons", $addon);			
			$addon_id = $this->db->insert_id();
			$file = $this->Master_model->upload_image($path, $addon_id, 'userfile');
			if($file <> "")
			{
				update("p14_addons", ['addon_image' => $file], ['addon_id' => $addon_id]);
				success(post('txtaddonname'). " added as Addon.");
				} else {
				error('Please upload Image');
			}
			if( $this->db->trans_status() === FALSE){$this->db->trans_rollback();}
			else{ $this->db->trans_commit();}
			header("Location:".base_url()."Product_Master/view_product_addons");
		}
		
		public function change_addon_image()
		{
			$this->db->trans_begin();
			$path = 'images/addon/';			
			$addon_id = post('addon_id');
			$file = $this->Master_model->upload_image($path, $addon_id, 'userfile');
			if($file <> "")
			{
				update("p14_addons", ['addon_image' => $file], ['addon_id' => $addon_id]);
				success("Image Changed.");
				} else {
				error('Please upload Image');
			}
			if( $this->db->trans_status() === FALSE){$this->db->trans_rollback();}
			else{ $this->db->trans_commit();}
			header("Location:".base_url()."Product_Master/view_product_addons");
		}
		
		
		public function view_all_products()
		{
			$data = [
			'form' 		=> "All Products",
			'table' 	=> "View all Product",
			'products' 	=> $this->db->group_by("pr_id")->get('v05_product_detail')->result(),
			'units' 	=> $this->db->where("unit_status",'1')->order_by("unit_name",'asc')->get('p01_unit')->result()
			];
 			$this->view('view_all_products',$data);
		}
		 
		public function update_product_details()
		{
			$prod_id = get('productId');
			$vari_id = get('variantId');
			
			$data = [
			'form' 		=> "Update Product",
			'table' 	=> "Update Product",
			'product' 	=> $this->db->where("pr_id",$prod_id)->where("pr_vari_id",$vari_id)->group_by('pr_id')->get('v05_product_detail')->row(),
			'img' 		=> $this->db->where("pr_img_pr_vari_id",$vari_id)->get('p09_product_img')->result(),
			'video' 	=> $this->db->where("pr_v_pr_id",$prod_id)->get('p10_product_video')->result(),
			'prodMenu' 	=> get_product_used_menu($prod_id),			
			'prodGroup' => $this->db->where("pr_loc_pr_id", $prod_id)->get("p11_product_location")->result(),
			'prodType' 	=> $this->db->where('pr_type_pr_id', $prod_id)->get('p13_product_type')->result(),
			
			'group' 	=> $this->db->order_by("loc_gr_name","asc")->get("m09_location_group")->result(),
			'variants' 	=> $this->db->where("vari_status",'1')->order_by("vari_name",'asc')->get('p02_variant')->result(),
			'units' 	=> $this->db->where("unit_status",'1')->order_by("unit_name",'asc')->get('p01_unit')->result(),
			'menu' 		=> $this->db->where('front_menu_status', 1)->order_by('front_menu_orderby', 'asc')->get('m06_front_menu')->result(),
			'category' 	=> $this->db->where('pr_cat_id!=', 0)->where('pr_cat_status', 1)->order_by('pr_cat_name', 'asc')->get('p03_category')->result(),
			'type' 		=> $this->db->where('type_id!=', 0)->where('type_status', 1)->order_by('type_name', 'asc')->get('p04_type')->result(),
			'badges' 	=> $this->db->where('badges_id!=', 0)->where('badges_status', 1)->order_by('badges_name', 'asc')->get('m05_badges')->result(),
			'addons'	=> $this->db->query("SELECT addon_id,addon_name,CASE WHEN paddon.id IS NOT NULL THEN 'Selected' ELSE '' END AS is_selected FROM `p14_addons` LEFT JOIN (SELECT add_on_id,id FROM `product_addons` WHERE product_id=".$prod_id.") AS paddon ON addon_id=paddon.add_on_id  ")->result(),
			'deli_slot_goup'=>$this->db->query("SELECT m12_delivery_slot_group.*,CASE WHEN proDeliSlot.p14_id IS NOT NULL THEN 'Selected' ELSE '' END AS is_selected FROM `m12_delivery_slot_group` LEFT JOIN (SELECT p14_id,group_id FROM `p14_pro_deli_slot_groups` WHERE product_id=".$prod_id.") AS proDeliSlot ON m12_delivery_slot_group.group_id=proDeliSlot.group_id")->result(),
			]; 
 			$this->view('update_product_details',$data);
		} 
		
		public function update_product()
		{
			
			$product_id = post('txt_productId');
			$vari_id 	= post('txt_variantId');
			
			$this->db->trans_begin();
			$txtname 		= post('txtname');
			$txtdesc 		= post('txtdesc');
			$ddcat1 		= post('ddcat1');
			$ddcat2 		= post('ddcat2');
			$ddcat3 		= post('ddcat3');
			$userfile 		= post('userfile');
			$ddbadges 		= post('ddbadges');
			$txtprcode 		= post('txtprcode');
			
			$txtvideo 		= post('txtvideo');
			$txtamt 		= post('txtamt');
			$txtshowamt 	= post('txtshowamt');
			$txtunit 		= post('txtunit');
			$ddunit 		= post('ddunit');
			$txthsn 		= post('txthsn');
			$txthour 		= post('txthour');
			$txtmenu3 		= explode(',', post('txtmenu3'));
			
			$ddtype 		= post('ddtype');
			$ddlocgrgoup 	= post('ddlocgrgoup');
			$videos			= explode(',', post('txtvideo'));
			if($txtname <> "" && $txtdesc <> "" /*&& $ddcat1 <> "" && $ddcat1 <> 0 && $ddcat2 <> "" && $ddcat2 <> 0*/ )
			{
				$pr = [
				'pr_name'		 		=> $txtname,
				'pr_description' 		=> trim($txtdesc),
				'pr_badges' 			=> $ddbadges,
				'pr_code' 				=> $txtprcode,
				'pr_cat1'		 		=> $ddcat1,
				'pr_cat2'		 		=> $ddcat2,
				'pr_cat3'		 		=> $ddcat3,
				'pr_min_order_timing'	=> $txthour,
				'pr_hsn'		 		=> $txthsn,
				'pr_is_designer'		=> !empty(post("is_designer")) ? post("is_designer") : "NO"
				];
				update("p07_product", $pr, ['pr_id' => $product_id]);
				
				if($product_id <> "" && $product_id <> 0)
				{
					$vari = [
					'pr_vari_show_price'	=> $txtshowamt,
					'pr_vari_actual_price'	=> $txtamt,
					'pr_vari_unit_value'	=> $txtunit,
					'pr_vari_unit_id'		=> $ddunit
					];
					update("p08_product_variant", $vari, ['pr_vari_id' => $vari_id]);
					
					if($vari_id <> "" && $vari_id <> 0)
					{
						if(!empty($ddtype)) {
							delete("p13_product_type", ['pr_type_pr_id' => $product_id]);
							foreach($ddtype as $t) {
								$ty = [
								"pr_type_pr_id" => $product_id,
								"pr_type_type_id" => $t
								];
								insert("p13_product_type", $ty);
							}
						}
						
						if(!empty($videos) && $txtvideo <> "") {
							foreach($videos as $v) {
								$vi = [
								'pr_v_pr_id'	=> $product_id,
								'pr_v_url'		=> $v
								];
								insert("p10_product_video", $vi);
							}
						}
						
						if(!empty($ddlocgrgoup)) {
							delete("p11_product_location", ['pr_loc_pr_id' => $product_id]);
							foreach($ddlocgrgoup as $g) {
								$gr = [
								'pr_loc_pr_id'	=> $product_id,
								'pr_loc_gr_id'	=> $g
								];
								insert("p11_product_location", $gr);
							}
						}
						
						if(!empty(post("ddaddons"))) {
							delete("product_addons", ['product_id' => $product_id]);
							foreach(post("ddaddons") as $addon) {
								$gr = [
								'product_id'	=> $product_id,
								'add_on_id'		=> $addon
								];
								insert("product_addons", $gr);
							}
						}

						if(!empty(post("ddTimeSlotGroup"))) {
							delete("p14_pro_deli_slot_groups", ['product_id' => $product_id]);
							foreach(post("ddTimeSlotGroup") as $timeSlotGroup) {
								$gr = [
								'product_id'	=> $product_id,
								'group_id'		=> $timeSlotGroup
								];
								insert("p14_pro_deli_slot_groups", $gr);
							}
						}
						
						if(!empty($txtmenu3)) {
							foreach($txtmenu3 as $m) {
								$me = [
								'pr_sh_m_pr_id'		=> $product_id,
								'pr_sh_m_fr_menu_id'	=> $m,
								];
								insert("p12_product_show_menu", $me);
 							}
						}
						if(!empty($_FILES) && !empty($_FILES['userfile']['name'][0])) {
							$this->_upload_product_image($vari_id);
						}
						success("Product Updated");
					}
					else 
					{
						error("Something went wrong!");					
					}
				}
				else 
				{
					error("Something went wrong!");					
				}
			}
			else 
			{
				error("Please fill all the required fields");			
			}
			
			if( $this->db->trans_status() === FALSE){$this->db->trans_rollback();}
			else{ $this->db->trans_commit();}
			header("Location:".base_url()."Product_Master/view_all_products");
		}
		
		public function view_all_product_variants()
		{
			$product_id = get('productId');
			$data = [
			'form' 		=> "View Product Variants",
			'table' 	=> "Update Product Variants",
			'units' 	=> $this->db->where("unit_status",'1')->order_by("unit_name",'asc')->get('p01_unit')->result(),	
			'product' 	=> $this->db->where("pr_status",'1')->order_by("pr_name",'asc')->get('p07_product')->result()
			];
			if($product_id <> ""){
				$data['variants'] 	= $this->db->where("pr_vari_vari_id<>",0)->where("pr_vari_pr_id",$product_id)->order_by("pr_vari_unit_value",'asc')->get('v06_product_variant')->result();
			}
 			$this->view('view_all_product_variants',$data);
		}
		
		
		public function change_variant_image()
		{
			$this->db->trans_begin();
			$path = 'images/product/';			
			$vari_id = post('vari_id');
			$file = $this->Master_model->upload_image($path, $vari_id, 'userfile');
			if($file <> "")
			{
				$img_id		= post('img_id');
				$pr_vari_id	= post('vari_id');
				$img_name = $this->db->where('pr_img_id', $img_id)->get('p09_product_img')->row()->pr_img_name;
				remove_images('images/product/'.$pr_vari_id.'/', $img_name);						
				delete('p09_product_img',['pr_img_id' => $img_id]);
				insert("p09_product_img", ['pr_img_name' => $file,'pr_img_pr_vari_id' => $vari_id]);
				success("Image Changed.");
				} else {
				error('Please upload Image');
			}
			if( $this->db->trans_status() === FALSE){$this->db->trans_rollback();}
			else{ $this->db->trans_commit();}
			redirect($this->agent->referrer());
		}
		
		
	}
?>																				