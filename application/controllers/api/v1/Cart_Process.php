<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Cart_Process extends CI_Controller {
		
		function __construct()
		{
			parent::__construct();
			header("Content-Type:application/json");
			$this->_is_tokenexist_in();
		}
		
		/////////////////////////////////////////////////////////////////////////
		//////////     			Check Token Is valid		  	  ///////
		//////////////////////////////////////////////////////////////////////
		
		public function _is_tokenexist_in()
		{			 
			if($this->input->server('REQUEST_METHOD') !== "POST") 
			{ 
				fail_response('Request method is wrong.');
			}
		}
		
		public function checkPincode()
		{
			$prodId = post('txtProductId');
			$pin 	= post('txtPincode');
			$res = check_product_on_pincode($prodId, $pin);
			
			if($res == -1){
				fail_response("Pincode cann't be blank!");
			} else if($res == 0){
				fail_response('Delivery not available for this pincode!');
			} else if($res == 1){
				success_response('Pincode available for delivery.');
			}
		}
		
		public function getDeliverySlots()
		{
			$date = post('deliveryDate');
			$prod = post('productId');
			success_response(getSlots($date, $prod));
		}
		
		public function addToCart()
		{
			$id 			= post('txtProfileId');
			$prodstring 	= post('txtProdString');
			$type 			= post('txtType');
			$parentProd 	= post('txtParentProd');
			$slotId 		= post('slotId');
			$deliveryDate 	= post('deliveryDate');
			$pincode 		= post('pincode');
			
			$this->db->where('cart_reg_id', $id)->where('cart_type', $type)->delete('tr03_cart_product');
			
			$c  = explode(',',$prodstring);
			$no = count($c);
			$sto = 0;
			for ($i = 0; $i < $no; $i++)
			{
				$co1	= explode('-', $c[$i]);
				$vid	= $co1['0'];
				$qty	= $co1['1'];
				if($type == 'Product')
					$pid 	= $this->db->query("SELECT `pr_vari_pr_id` FROM `p08_product_variant` WHERE `pr_vari_id` = $vid")->row()->pr_vari_pr_id;
				else
					$pid = $vid;
				$data = array(
					'cart_reg_id' 				=> $id,
					'cart_product_id' 			=> $pid,
					'cart_addon_parent' 		=> $parentProd,
					'cart_variant_id' 			=> $vid,
					'cart_qty' 					=> $qty,
					'cart_delivery_slot' 		=> $slotId,
					'cart_delivery_date' 		=> $deliveryDate,
					'cart_pincode' 				=> $pincode,
					'cart_type' 				=> $type
				);
				insert('tr03_cart_product', $data);
			}
			success_response('Product added in cart');
		}
		
		public function myCart()
		{
			$array = array();
			$array1 = array(); $i = 1;
			$id = post('txtProfileId');
			$cart = $data['cart'] = $this->db->where('cart_reg_id',$id )->where('cart_type', 'Product')->get('v10_cart')->result();;
   			
			foreach($cart as $p)
			{
				$addon = cart_addon_product($p->cart_reg_id, $p->cart_id);
				if(!empty($addon))
				{
					foreach($addon as $c)
					{
						$da1['ADDON_ID']			= $c->cart_variant_id;
						$da1['ADDON_PROD_CART_ID'] 	= $c->cart_addon_parent;
						$da1['ADDON_NAME'] 			= $c->pr_name;
						$da1['ADDON_IMG'] 			= $c->pr_img_name;
						$da1['ADDON_AMT'] 			= $c->pr_vari_actual_price;
						
						$array1[] = $da1;
						unset($da1);
					}
				} else{
					$array1 = null;
				}
				
				$da['PROD_CART_ID']				= $p->cart_id;
				$da['PROD_ID']					= $p->cart_product_id;
				$da['PROD_VARIANT_ID']			= $p->cart_variant_id;
				$da['PROD_NAME'] 				= $p->pr_name;
				$da['PROD_IMG'] 				= $p->pr_img_name;
				$da['PROD_SHOW_AMT'] 			= $p->pr_vari_show_price;
				$da['PROD_AMT'] 				= $p->pr_vari_actual_price;
				$da['PROD_DELIVERY_SLOT'] 		= $p->delivery_timing;
				$da['PROD_DELIVERY_CHARGES'] 	= $p->deli_slot_charges;
				$da['PROD_DELIVERY_DATE'] 		= $p->cart_delivery_date;
				
				$da['ADDON'] 			= $array1;
				$array[]				= $da;
				
				unset($da);
			}
			
			success_response($array);
		}	
	
		
		
	}
	
?>			