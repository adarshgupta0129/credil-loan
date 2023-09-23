<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError; 
	
class Welcome extends CI_Controller {
		
		public function __construct() 
		{
			parent::__construct();
			$this->load->model('Master_model');
			//	print_r($this->session->all_userdata());;die;
		}
		
		public function view($page_name, $data=null)
		{
			if(session('profile_id') <> ''){$id = session('profile_id'); } else {$id = session('tmp_profile_id');}
			if($id <> '')
			{
				$data['cart'] = $this->db->where("cart_reg_id", $id)->group_by('cart_variant_id')->get("v10_cart")->result();
				//$data['cart_addon'] = $this->db->where("cart_reg_id", $id)->group_by('cart_variant_id')->get("v11_cart_addon")->result();
			}
			else
			{
				$data['cart'] = "";
			}
 			$data['session_id'] = (session('tmp_profile_id'))?session('tmp_profile_id'):session('profile_id');
			$data['menu'] = $this->db->where("front_menu_status",1)->where("front_menu_parent_id",0)->order_by("front_menu_orderby",'asc')->get('m06_front_menu')->result();
			$this->load->view("front/common/header",$data);
			$this->load->view("front/common/menu");
			$this->load->view("front/".$page_name);
			$this->load->view("front/common/footer");
		}
		
		public function index() 
		{
			$data = [
			'trending' 	=> $this->Master_model->allProducts(),
			'cat' 		=> q('SELECT * FROM `p03_category` WHERE `pr_cat_status` = 1 AND (`pr_cat_id` IN (1,5,13))')->result(),
			'images' 	=> q("select * from v17_images where img_valid_till >= curdate()")->result(),
			];
			
			$this->view('index',$data); 
		}	
		
		public function login()
		{
			$this->view('login');
		}
		public function customize()
		{
			$this->view('customize');
		}
		
		public function enquire_now()
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
				
				$data= array(
				'tr38_name'=>$this->input->post('txtname'),
				'tr38_phone'=>$this->input->post('txtmobile'),
				'tr38_image'=>$file,
				'tr38_reference_link'=>$this->input->post('txtrefer_link'),
				'tr38_date'=>YmdHis,
				'tr38_status'=>1
				);
				$this->db->insert('tr38_customize',$data);				
				$this->session->set_flashdata('warning','Customize Image Successfull');			
				header("Location:".base_url()."welcome/customize");
			}
			else
			{
				$this->session->set_flashdata('info','Banner Image Not Upload');	
				header("Location:".base_url()."master/view_banner");
			}
		}
		
		public function register()
		{
			$this->view('register');
		}
		
		public function register_candidate()
		{	
			//check otp
			$this->db->where("mobile",$this->input->post("txtmobile"))->where("otp",$this->input->post("txtotp"))->get("mobile_verify")->result();
			if($this->db->affected_rows() == 0){
				echo "OTP_NOT_MATCH";
				return;
			}


			$this->load->model('Member_model');
			$res = $this->Member_model->signup();
			echo $res;
			return;
		}

		function register_otp_send(){
			$mobile=$this->input->post("mobile");
			if(!empty($mobile)){
				$this->db->where("mobile",$mobile)->get("mobile_verify")->result();
				$otp=rand(1111,9999);
				if($this->db->affected_rows() > 0){
					$this->db->set(['otp'=>$otp])->where("mobile",$mobile)->update("mobile_verify");
					echo json_encode(['status'=>"1"]);
				}else{
					$this->db->insert("mobile_verify",[
						"mobile"=>$mobile,
						"otp"=>$otp,
						"date"=>date("Y-m-d H:i:s"),
					]);
					echo json_encode(['status'=>"1"]);
				}
				send_sms($mobile,otp_registration($otp,''));
			}else{
				echo json_encode(['status'=>"0"]);
			}
		}

		function forgot_password(){
			$mobile=$this->input->post("mobile");
			$d=$this->db->select('user_name,login_pwd')->join("m03_user_detail","user_mobile_no=login_u_id")->where('login_u_id',$mobile)->get('tr01_login')->result();
			if($this->db->affected_rows() > 0){
				success("SMS sent to registered mobile number");
				send_sms($mobile,forgotPassword($d[0]->user_name,$d[0]->login_pwd));
			}else{
				error("User not found");
			}
			redirect("welcome/login");
		}
		
		public function all_products($id = null)
		{
			$data['menu'] = "";
			$this->view('all_products',$data);
		}
		
		public function all_products_query()
		{
			$data['rec'] = $this->Master_model->allProducts();			
			return $this->load->view('front/product/product_grid',$data);
		} 
		
		public function product()
		{
			$rec = $this->Master_model->product();
			$rec['location'] = $this->db->select('loc_name')->from('m02_location')->where('loc_status', 1)->where('loc_parent_id!=', -1)->where('loc_name > ', 0)->order_by('loc_name','asc')->get()->result();
			$rec['flavours'] =  $this->db->where("m13_status",1)->get("m13_flavors")->result();
   			$this->view('product', $rec);
		}
		
		public function product_single()
		{
			$rec = $this->Master_model->product();
			return $this->load->view('front/product/product_single',$rec);
		}
		
		public function getSlots()
		{
			$date = post('deliveryDate');	
			$productId = post('productId');	
			echo json_encode(getSlots($date, $productId));
		}
		
		
		public function cart()
		{
		 	if($this->session->userdata('user_id')=="")
			{
				$this->session->set_userdata('add_to_cart','cart');
				header("Location:".base_url()."welcome/login");
			}
			else
			{
				$data = "";
			 	$this->view('cart',$data);   
			}
		}
		
		public function add_to_cart()
		{
 			$queryString 	= $this->input->server('QUERY_STRING');
			$productId 		= get('productId');
			$variantId 		= get('variantId');
			$pincode 		= get('pincode');
			$slotId 		= get('slotId');
			$deliveryDate 	= get('deliveryDate');
			$id 			= session('profile_id');
			$tid 			= session('tmp_profile_id'); 
			$ptypeId		= get('ptype');
			$type_extra_charge = egg_less_charge($productId,$ptypeId)["fee"];
			
			if($id == "" && $tid == ""){
				$tid = q("SELECT IF(IFNULL(MAX(`cart_reg_id`),0)<100000,IFNULL(MAX(`cart_reg_id`),0)+1000000, IFNULL(MAX(`cart_reg_id`),0)+1) AS id FROM `tr03_cart_product`")->row()->id;
				$this->session->set_userdata('tmp_profile_id', $tid);
				$id = session('tmp_profile_id'); 
				} else {
				$id = session('tmp_profile_id'); 
			}
			if($productId <> "" && $variantId <> "" && $deliveryDate <> "" && $slotId <> 0)
			{
				if($pincode <> '')
				{
					if(session('usertype') <> 2 && session('usertype') <> '')
					{
						error('you are not a user');
						header("Location:".$this->agent->referrer());
					}
					else
					{ 
						$name = q("SELECT `pr_name` FROM `p07_product` WHERE `pr_id` = ".$productId)->row()->pr_name;
						$coun = q("SELECT COUNT(*) as coun FROM `tr03_cart_product` WHERE `cart_reg_id` = ".$id." AND `cart_product_id` = ".$productId." AND `cart_variant_id` = ".$variantId)->row()->coun;
						
						if($coun == 0)
						{				
							$isInLoc = check_product_on_pincode($productId, $pincode);
							if($isInLoc == 1)
							{
								$data = array(
								"cart_reg_id"			=> $id,
								"cart_product_id"		=> $productId,
								"cart_variant_id"		=> $variantId,
								"cart_qty"				=> 1,
								"cart_delivery_slot"	=> $slotId,
								"cart_delivery_date"	=> $deliveryDate,
								"cart_pincode"			=> $pincode,
								"cart_type"				=> 1,
								"cart_type_id"			=> $ptypeId,
								"cart_type_charge"		=> $type_extra_charge
								);
								insert('tr03_cart_product', $data);	
													
								success($name.' added successfully in cart.');
							}
							else 
							{
								error($name.' not available for this pincode.');
							}
						}
						else 
						{
							error($name.' already present in cart.');
						}
					}
				}
				else 
				{
					error("Please provide us a pincode");
				}
			}
			else 
			{
				header("Location:".base_url());
			}
			header("Location:".$this->agent->referrer());
		}
		
		public function product_single_calender()
		{
			$rec = "";
			return $this->load->view('front/product/product_single_calender',$rec);
		}
		
		
		public function addon()
		{
			$data["already_added"]=$this->db->select('cart_product_id,cart_qty,addon_amount')
									->join("p14_addons","addon_id=cart_product_id")
									->where(["cart_type"=>"Addon","cart_reg_id"=>$this->session->userdata("tmp_profile_id")])
									->get('tr03_cart_product')->result_array();	
			
			
			$admin_added_addon=array_map(function($v){return $v->add_on_id;},$this->db->select("add_on_id")->where("product_id",$this->input->get("productId"))->get("product_addons")->result());
			$data['recommended']=$this->db
									->where('addon_status',1)
									->where_in("addon_id",count($admin_added_addon) > 0 ? $admin_added_addon : [0])
									->where("addon_max_qty >",0)->get("p14_addons")->result();
			
			$data['addon'] = $this->db
								->where('addon_status',1)
								->where('addon_max_qty>', 0)
								->where_not_in("addon_id",count($admin_added_addon) > 0 ? $admin_added_addon : [0])
								->get('p14_addons')->result();

			$this->view('addon',$data);
		}
		
		public function addAddons()
		{
			if(get('cartId') <> "" && get('cartId') <> "0" && post('tAmt') <> "" && (session('tmp_profile_id') <> "" || session('profile_id') <> "" ))
			{
				$id 	= (session('tmp_profile_id'))?session('tmp_profile_id'):session('profile_id');
				$cartId	= get('cartId');
				$str	= post('txtquid');
				if($str <> "")
				{
					$c  = explode(',', $str);
					$no = count($c);
					for ($i = 0; $i < $no - 1; $i++)
					{
						$co 		= explode(',', $str);
						$co1 		= explode('-', $co[$i]);
						$pid 		= $co1['0'];
						$quantity 	= $co1['1'];				
						
						$data = array(
						"cart_reg_id"		=> $id,
						"cart_addon_parent"	=> $cartId,
						"cart_product_id"	=> $pid,
						"cart_variant_id"	=> $pid,
						"cart_qty"			=> $quantity, 
						"cart_type"			=> 2
						);
						insert('tr03_cart_product', $data);
						success('Add-ons added successfully in cart.');
					}
				} 
			}
			redirect($this->agent->referrer(), 'refresh');
		}

		//remove addon from addon add page ajax request
		function remove_addon(){
			$parent=$this->input->post("parent");
			$product=$this->input->post("product");
			$this->db->where(["cart_addon_parent"=>$parent,"cart_product_id"=>$product])->delete("tr03_cart_product");
			echo "Addon remove Successfully";

		}
		
		public function checkout()
		{
			// send_sms("8318546673","Your order 54874874 has been picked by our delivery agent test user Please be available. Thank You! EASYCELEBRATIONS");
			//  exit;
			// $this->load->helper('text');
			
			$data = [
			'loc' 		=> $this->db->where('loc_parent_id',1)->get('m02_location')->result(),
			'address' 	=> $this->db->where('user_addr_status',1)->where('user_reg_id', session('tmp_profile_id'))->get('m04_user_address')->result(),
			'cart' 		=> $this->db->where("cart_reg_id", session('tmp_profile_id'))->group_by('cart_variant_id')->get("v10_cart")->result(),
			'coupons' 	=> validateCoupon(session('tmp_profile_id')),
			'flavours' =>  $this->db->where("m13_status",1)->get("m13_flavors")->result()
			];
			
			$this->view('checkout',$data);
		}
		
		public function placeOrder()
		{
			$this->load->model('Member_model');
			if(post('txtPaymentMode') == "ONLINE"){

				//calculate payable amount *******************************
				$payable_amt=0;
				$product=$this->db->query("SELECT cart_type_id,deli_slot_charges,cart_product_id,cart_id,(pr_vari_actual_price*cart_qty) AS price FROM `v10_cart` WHERE `cart_reg_id` = '".session('profile_id')."' GROUP BY `cart_variant_id`")->result();
				foreach($product as $p){
					$payable_amt += $p->price;
					$payable_amt += $p->deli_slot_charges;
					$payable_amt += $this->db->query("SELECT SUM((pr_vari_actual_price*cart_qty)) AS price FROM v11_cart_addon WHERE cart_addon_parent= ".$p->cart_id." AND cart_reg_id =". session('profile_id'))->row()->price;
					$type_extra_charge = $p->cart_type_id == 2 ? egg_less_charge($p->cart_product_id)["fee"] : "0";
					$payable_amt +=$type_extra_charge;
				}
				$payable_amt=$payable_amt-checkout_wallet_off(session('profile_id'));
				if(!empty(post('couponId')) && post('couponId') <> 0){	
					$temp = q("select coupon_amount from tr08_coupons where coupon_id = ".post('couponId')." and coupon_status = 1")->result();
						if($this->db->affected_rows() > 0)
							$payable_amt = $payable_amt - $temp[0]->coupon_amount;
				}
				//calculate payable amount *******************************
				
				$this->db->insert("tr06_order_temp",[
						"profile_id"=>session('profile_id'),
						"txtAddressId"=>post('txtAddressId'),
						"txtInstruction"=>post('txtInstruction'),
						"txtPaymentMode"=>post('txtPaymentMode'),
						"couponId"=>post('couponId'),
						"payable_amt"=>$payable_amt
					]);
				
				$this->init_online_payment($payable_amt,$this->db->insert_id());
			}else{
				$res = $this->Member_model->placeOrder(
							session('profile_id'), 
							1,
							post('txtAddressId'),
							post('txtInstruction'),
							post('txtPaymentMode'),
							post('couponId')
						);

				if($res['msg'] == 1){
					success('Order Placed successfully');
					
				} else {
					error($res['res']);
				}
				echo $res['msg'];
			}
			
		} 

		function init_online_payment($payable_amt,$order_temp_ref){
			require(APPPATH.'/libraries/razorpay-php/Razorpay.php');
			$api = new Api(RAZOR_KEY_ID, RAZOR_KEY_SECRET);
			$orderData = [
				'receipt'         => $order_temp_ref,
				'amount'          => $payable_amt*100, //
				'currency'        => 'INR',
				'payment_capture' => 1
			];
			
			$razorpayOrder = $api->order->create($orderData);
			$razorpayOrderId = $razorpayOrder['id'];
			$displayAmount = $amount = $orderData['amount'];
			$user=$this->db->select("user_name,user_email,user_mobile_no")->where("user_reg_id",session('profile_id'))->get("m03_user_detail")->row();

			$checkout = 'automatic';
			$data = [
				"key"               	=> RAZOR_KEY_ID,
				"amount"            	=> $amount,
				"name"              	=> $user->user_name,
				"description"       	=> "For Order ref".$order_temp_ref,
				"prefill"           	=> ["email"=>$user->user_email,"contact" => $user->user_mobile_no],	
				"notes"             	=> [],
				"order_id"          	=> $razorpayOrderId,
				];
			$this->db->where("id",$order_temp_ref)->update("tr06_order_temp",["pay_data"=>json_encode($data),"hash"=>md5($order_temp_ref)]);
			echo md5($order_temp_ref);
		}

		function online_payment($order_ref){
			$data=$this->db->where("hash",$order_ref)->where("order_status",0)->get("tr06_order_temp")->row();
			if(empty($data))
				redirect("/");
			$data=json_decode($data->pay_data);
			$res["data"]=$data;
			$res["hash"]=$order_ref;
			$this->load->view("front/razorpay",$res);
		}

		function checkout_success($order_ref){
			$data=$this->db->where("hash",$order_ref)->where("order_status",0)->get("tr06_order_temp")->row();
			if(empty($data))
				redirect("/");
			
			$status=$this->_verify_rozer_payment(json_decode($data->pay_data)->order_id);
			if ($status['success'] === true){
				$this->load->model('Member_model');
				$this->db->where("hash",$order_ref)->update("tr06_order_temp",[
								"pay_success"=>json_encode([
									"razorpay_payment_id"=>empty($this->input->post("razorpay_payment_id")) ? json_decode($data->pay_data)->order_id  : $this->input->post("razorpay_payment_id"),
									"razorpay_order_id"=>$this->input->post("razorpay_order_id"),
									"razorpay_signature"=>$this->input->post("razorpay_signature"),
								]),"order_status"=>"1"]);

				$this->Member_model->placeOrder(
					$data->profile_id, 
					1,
					$data->txtAddressId,
					$data->txtInstruction,
					$data->txtPaymentMode,
					$data->couponId
				);
			}
			redirect("Userprofile/viewOrders");
		}


		function _verify_rozer_payment($order_id){ 
			
			require(APPPATH.'/libraries/razorpay-php/Razorpay.php');
			$success = true;
			$error = "Payment Failed";
			
			$api = new Api(RAZOR_KEY_ID, RAZOR_KEY_SECRET);
			try
			{
				$attributes = array(
				'razorpay_order_id' 	=> empty($_POST['razorpay_order_id']) ? $order_id : $_POST['razorpay_order_id'],
				'razorpay_payment_id' 	=> $_POST['razorpay_payment_id'],
				'razorpay_signature' 	=> $_POST['razorpay_signature']
				);
				$api->utility->verifyPaymentSignature($attributes);
			}
			catch(SignatureVerificationError $e)
			{
				$success = false;
				$error = 'Razorpay Error : ' . $e->getMessage();
			}
			
			return ['success'=>$success,"attributes"=>$attributes];
		}
		
				
		
		public function insert_address(){
			$data = $this->Master_model->validate_form_address(session('profile_id'));
			$result = $this->db->insert('m04_user_address',$data);
			if($result){
				echo json_encode(['success'=>true,'message'=>'Your Address Successfully Added!']);
				die;
			}
			else{
				echo json_encode(['success'=>false,'message'=>'Address Not Added! Try again!']);
				die;
			}
		}
		
		public function remove_product (){
			$id=$this->input->post('id');
			if(empty($id)){
				error('Something went wrong');
				echo 0;
			}

			$this->db->where('cart_id',$id)->delete('tr03_cart_product');
			$this->db->where('cart_addon_parent',$id)->delete('tr03_cart_product');
			success('Item removed');
			echo 1;
			
		}
		
		function fetch_city()
		{
		    $stateid=$this->input->post('stateid');
			$this->db->where('loc_parent_id', $stateid);
			$this->db->order_by('loc_name', 'ASC');
			$query = $this->db->get('m02_location');
			$output = '<option value="">Choose...</option>';
			foreach($query->result() as $row)
			{
				$output .= '<option value="'.$row->loc_id.'">'.$row->loc_name.'</option>';
			}
			echo $output;
		}
		
		function mainSearchResult(){
			$res=[];$i=0;
			$search=$this->input->get("like");
			/*------category push -------*/
			$menu=$this->db->select('m.front_menu_id,m.front_menu_name,m.front_menu_img,cat1.front_menu_name as parent')
			->join("m06_front_menu as cat1","cat1.front_menu_parent_id=m.front_menu_id","left")
			->like('m.front_menu_name',$search, 'after')->limit(5)
			->get('m06_front_menu as m')->result();
			
			if(count($menu) > 0){
				foreach($menu as $k=>$v){
					$imgLink=empty($v->front_menu_img) ? "notfound.jpg" : 'images/menu/'.$v->front_menu_id.'/m/'.$v->front_menu_img;
					$parent=!empty($v->parent) ? "<span class='text-info'> in ".$v->parent."</span>" : "";
					$res[$i]['label']="<a href='".base_url('welcome/all_products?page=1&source=searching&menuId='.$v->front_menu_id)."'><p class='m-0'><img width='25' height='25' src='".base_url($imgLink)."' alt='Logo' />&nbsp;&nbsp;".$v->front_menu_name.$parent."</p></a>";
					$res[$i]['print']="CATEGORY";
					$res[$i]['focus']=$v->front_menu_name;
					$i++;
				}
			}
			
			/*------product push -------*/
			$data=$this->db
			->select('pr_id,pr_name,pr_vari_id,pr_img_name')
			->group_by('pr_vari_id',1)
			->like('pr_name',$search)
			->limit(300)->get('v05_product_detail')->result_array();
			
			if(count($data) > 0){
				$res[$i]['label']="<p class='m-1 bg-info text-white text-center'>PRODUCTS</p>";
				$res[$i]['focus']="";
				$res[$i]['print']="";
				$i++;
				
				$match=array_filter($data,function($v) use ($search){
					if(preg_match('/\b'.$search.'\b/i',$v['pr_name']))
					return $v;
				});
				if(count($match) < 30){
					$match=array_merge($match,array_filter(array_filter($data,function($v) use($match){if(!in_array($v['pr_name'],array_column($match,"pr_name"))){return $v;}}),function($v) use ($search){
					if(preg_match('/\b'.$search.'/i',$v['pr_name']))return $v;}));
				}
				
				$match=array_slice($match, 0, 50, true);
				
				foreach($match as $k=>$v){
					$res[$i]['label']="<a href='".base_url('welcome/product/'.url_title($v['pr_name'],'dash').'?productId='.$v['pr_id']."&variantId=".$v['pr_vari_id'])."'><p><img width='25' height='25' src='".base_url('images/product/'.$v['pr_vari_id'].'/m/'.$v['pr_img_name'])."' alt='Logo' />&nbsp;&nbsp;".$v['pr_name']."</p></a>";
					$res[$i]['print']="PRODUCT";
					$res[$i]['name']=$v['pr_name'];
					$res[$i]['focus']=$v['pr_name'];
					$i++;
				}
			}
			
			echo json_encode($res);
		}
		
		// save the instruction from  add to cart page 
		function save_instructions(){
			$file_name=!empty($_FILES["image"]) ? $_FILES["image"]['name'] : "";
			$design_image="";
			if($file_name != '')
			{
				$this->load->library('upload');	
				$config = [
					'upload_path'   => "./images/instruction/",
					'allowed_types' => 'gif|jpg|png|jpeg',
					'encrypt_name'	=> TRUE,
					'max_size'      => "5000",
					'max_width'     => "5000",
					'max_height'    => "5000",
					'overwrite'     => FALSE
					];
				
				$this->upload->initialize($config);
				$this->upload->do_upload("image");
				$finfo=$this->upload->data();
				$design_image=$finfo['file_name'];
			}

			$update=["cart_message"=>$this->input->post('order_message')];
			if(!empty($design_image))
				$update=$update+['cart_custom_img'=>$design_image];
				
			$this->db->where("cart_reg_id",$this->session->userdata("tmp_profile_id"))->where("cart_product_id",$this->input->post("product"))
					->update("tr03_cart_product",$update);
			echo "Instruction Added Successfully";
			return;
		}

		//ajax call form add to cart page
		function get_saved_instruction(){
			$data=$this->db->select("cart_custom_img,cart_message,cart_flavour")
					->where("cart_reg_id",$this->session->userdata("tmp_profile_id"))
					->where("cart_type","Product")
					->where("cart_product_id",$this->input->post("product"))
					->get("tr03_cart_product")->row();
			
			$this->output
				->set_status_header(200)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($data))
				->_display();
			exit;
		}

		//ajax call form add to cart page
		function update_flavour(){
			$this->db->where("cart_reg_id",$this->session->userdata("tmp_profile_id"))->where("cart_product_id",$this->input->post("product"))
					->update("tr03_cart_product",["cart_flavour"=>$this->input->post("flavour")]);
			echo "Added Successfully";
			return;
		}
		
	}
	
?>				