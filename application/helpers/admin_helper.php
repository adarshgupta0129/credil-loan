<?php 
	
	/* BASIC HELPERS */
	function get($name)
	{    
		$CI =& get_instance();
		return ($CI->input->get($name));
	}
	
	function post($name)
	{    
		$CI =& get_instance();
		return ($CI->input->post($name));
	}
	
	function p($d = null)
	{    
		$CI =& get_instance();
		echo "<pre>";
		if($d == null)
		print_r($CI->input->post()); 
		else
		print_r($d);
		die;		
	}
	
	function session($name)
	{    
		$CI =& get_instance();
		return ($CI->session->userdata($name));
	}
	
	function q($id)
	{ 
		$CI = & get_instance();
		return $CI->db->query($id);
	}
	
	function select($table, $where = null, $limit = null, $offset = null)
	{
		$CI = & get_instance();
		return $CI->db->get_where($table, $where, $limit, $offset)->result();
	}
	
	function select_order_by($table, $where = null, $orderBy, $limit = null, $offset = null)
	{
		$CI = & get_instance();
		return $CI->db->order_by($orderBy, 'ASC')->get_where($table, $where, $limit, $offset)->result();
	}
	
	function select_one($table, $where = null)
	{
		$CI = & get_instance();
		return $CI->db->get_where($table, $where)->row();
	}
	
	function select_col($columns, $table, $where = null)
	{
		$CI = & get_instance();
		return $CI->db->select($columns)->where($where)->get($table)->result();
	}
	function select_col_tes($columns, $table, $where = null)
	{
		$CI = & get_instance();
		return $CI->db->select($columns)->where($where)->get($table);
	}
	
	function select_col_one($columns, $table, $where = null)
	{
		$CI = & get_instance();
		return $CI->db->select($columns)->where($where)->get($table)->row();
	}
	
	function insert($table, $array)
	{
		$CI = & get_instance();
 		$insert_query = $CI->db->insert_string($table, $array);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
		return $CI->db->query($insert_query);
	}
	
	function update($table, $array, $where)
	{
		$CI = & get_instance();
		return $CI->db->where($where)->update($table, $array);
	}
	
	function delete($table, $where)
	{
		$CI = & get_instance();
		return $CI->db->where($where)->delete($table);
	}
	
	function l()
	{
		$CI = & get_instance();
		echo ($CI->db->last_query()); die;
	}
	
	function fetch_class()
	{
		$CI = & get_instance();
		return $CI->router->fetch_class();
	}
	
	function fetch_method()
	{
		$CI = & get_instance();
		return $CI->router->fetch_method();
	}
	
	function uri($uri)
	{
		$CI = & get_instance();
		return $CI->uri->segment($uri);
	}
	
	function error($msg)
	{
		$CI = & get_instance();
		return $CI->session->set_flashdata('error',$msg);
	}
	
	function success($msg)
	{
		$CI = & get_instance();
		return $CI->session->set_flashdata('success',$msg);
	}
	
	/*----------------Mobile Web Service For Success Response------------------*/
	
	function success_response($result)
	{
		header("Content-Type:application/json");
		$data = array(
		"status" 	=> 	'SUCCESS',
		"result" 	=> 	$result
		);
		echo json_encode($data, true);
		die;
	}
	
	/*----------------Mobile Web Service For Fail Response------------------*/
	
	function fail_response($result) 
	{
		header("Content-Type:application/json");
		$data = array(
		"status" 	=> 	'FAILED',
		"result" 	=> 	$result
		);
		echo json_encode($data, true);
		die;
	}  
	
	/* BASIC END */
	
	function front_menu_child($parent_id)
	{

		$CI = & get_instance();
		
		$allowed_menu_id = _allowed_menu();

		$CI->db->where(['front_menu_parent_id' => $parent_id, 'front_menu_status' => 1]);
				if(!empty($allowed_menu_id))
					$CI->db->where_in("front_menu_id",$allowed_menu_id);
		
		$query = $CI->db->order_by('front_menu_orderby','ASC')
				->get('m06_front_menu');
		
		if($query->num_rows() > 0)
		{	
			return $query->result();	
		}else{
			return [];
		}
	}
	
	function front_menu_child_admin($parent_id)
	{
		$CI = & get_instance();
		$query = $CI->db->order_by('front_menu_orderby','ASC')->get_where('m06_front_menu',array('front_menu_parent_id' => $parent_id));
		
		if($query->num_rows() > 0)
		{	
			return $query->result();	
		}
	}
	
	function front_menu_child_third($parent_id)
	{
		$CI = & get_instance();
		
		$allowed_menu_id = _allowed_menu();
		$CI->db->select("`front_menu_id`,`front_menu_name`,`badges_style`")
					->join("m05_badges","badges_id=front_menu_badges","left")
					->where("front_menu_status",1)
					->where("front_menu_parent_id",$parent_id);
				if(!empty($allowed_menu_id))
					$CI->db->where_in("front_menu_id",$allowed_menu_id);
		$query= $CI->db->order_by("front_menu_orderby")
					->get("m06_front_menu");
		
 		if($query->num_rows() > 0)
		{	
			return $query->result();	
		}
	}

	function _allowed_menu(){
		$CI = & get_instance();
		$pin = $CI->input->get("pincode");
		$allowed_group=[0];
		$allowed_menu_id=[];

		if($pin <> "" )
		{
			$pin_d = q("SELECT `loc_id`,`loc_parent_id` FROM `m02_location` WHERE `loc_name` = '$pin'");
			if($pin_d->num_rows() > 0)
			{
				$city = $pin_d->row()->loc_parent_id; // city 
				$pincode = $pin_d->row()->loc_id; // location id
				
				$isCity = q("SELECT * FROM `m10_loc_group_city` WHERE `loc_gr_c_gr_id` IN (SELECT `location_group_id` FROM `m06_front_menu_location_group`) AND `loc_gr_c_city_id` = $city and loc_gr_c_if_allow = 1")->result();
				
				if($CI->db->affected_rows() > 0){

					$isPincode = q("SELECT *  FROM `m10_loc_group_city` WHERE `loc_gr_c_gr_id` IN (SELECT `location_group_id` FROM `m06_front_menu_location_group`) AND `loc_gr_c_city_id` = ".$pincode." and loc_gr_c_if_allow = 0")->result();
					$allowed_group=array_map(function($v){return $v->loc_gr_c_gr_id;},$isCity);
					$disallowed_group_in_pincode=[0];

					if($CI->db->affected_rows() > 0){
						$disallowed_group_in_pincode=array_map(function($v){return $v->loc_gr_c_gr_id;},$isPincode);
					}
					$temp=$CI->db->where_in("location_group_id",$allowed_group)->where_not_in("location_group_id",$disallowed_group_in_pincode)->get("m06_front_menu_location_group")->result();
					if($CI->db->affected_rows() > 0)
						$allowed_menu_id=array_map(function($v){return $v->menu_id;},$temp);
					
				}
				
			}
			
		}

		return $allowed_menu_id;
	}
	
	function category_child($parent_id)
	{
		$CI = & get_instance(); 
		$query = $CI->db->get_where('p03_category',array('pr_cat_parent_id' => $parent_id, 'pr_cat_status' => 1));
		
		if($query->num_rows() > 0)
		{	
			return $query->result();	
		}
	}
	function category_child_admin($parent_id)
	{
		$CI = & get_instance(); 
		$query = $CI->db->get_where('p03_category',array('pr_cat_parent_id' => $parent_id));
		
		if($query->num_rows() > 0)
		{	
			return $query->result();	
		}
	}
	
	function location_child($parent_id)
	{
		$CI = & get_instance(); 
		$query = $CI->db->get_where('m02_location',array('loc_parent_id' => $parent_id, 'loc_status' => 1));
		
		if($query->num_rows() > 0)
		{	
			return $query->result();	
		}
	}
	
	function location_child_admin($parent_id)
	{
		$CI = & get_instance(); 
		$query = $CI->db->get_where('m02_location',array('loc_parent_id' => $parent_id));
		
		if($query->num_rows() > 0)
		{	
			return $query->result();	
		}
	}
	function weekdays($day)
	{	
		$days = [
		'Sunday',
		'Monday',
		'Tuesday',
		'Wednesday',
		'Thursday',
		'Friday',
		'Saturday'
		];
		if (in_array($day, $days)) {
			return true;
			} else {
			return false;
		}
	}
	
	/* Remove Images from all folders */
	
	function remove_images($path, $name){		
		unlink($path.'s/'.$name);
		unlink($path.'m/'.$name);
		unlink($path.'x/'.$name);
	}
	
	/* Get Enum Values */
	
	function getEnum($column, $table)
	{	$CI = & get_instance();
		$result = $CI->db->query("SHOW COLUMNS FROM $table WHERE FIELD = '$column'")->row();
		if ($result) 
		{
			$option_array = explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $result->Type));
		}
		return $option_array;
	}
	
	
	/*----------------Get Reg id From User Id------------------*/
	
	function get_uid($id)
	{
		$CI =& get_instance();
		$query=$CI->db->get_where('m03_user_detail',array('user_u_id'=>$id ));		
		$row = $query->row();
		if($query->num_rows()==1)
		{	
			return $row->user_reg_id;	
		}
		else
		{
			return "false";		// RETURN ARRAY WITH ERROR
		}
	}
		/*----------------Get Reg id From User Id------------------*/
	
		function ifKYC($id)
		{
			$CI =& get_instance();
			$query=$CI->db->get_where('tr03_kyc',array('kyc_user_id'=>$id ));		
			$row = $query->row();
			if($query->num_rows()==1)
			{	
				return $row->kyc_status;	
			}
			else
			{
				return "false";		// RETURN ARRAY WITH ERROR
			}
		}
	
	
	
	function convertNumberToWord($num = false)
	{
		$num = str_replace(array(',', ' '), '' , trim($num));
		if(! $num) {
			return false;
		}
		$num = (int) $num;
		$words = array();
		$list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
		'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
		);
		$list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
		$list3 = array('', 'thousand', 'million', 'billion'
		);
		$num_length = strlen($num);
		$levels = (int) (($num_length + 2) / 3);
		$max_length = $levels * 3;
		$num = substr('00' . $num, -$max_length);
		$num_levels = str_split($num, 3);
		for ($i = 0; $i < count($num_levels); $i++) {
			$levels--;
			$hundreds = (int) ($num_levels[$i] / 100);
			$hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ( $hundreds == 1 ? '' : 's' ) . ' ' : '');
			$tens = (int) ($num_levels[$i] % 100);
			$singles = '';
			if ( $tens < 20 ) {
				$tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
				} else {
				$tens = (int)($tens / 10);
				$tens = ' ' . $list2[$tens] . ' ';
				$singles = (int) ($num_levels[$i] % 10);
				$singles = ' ' . $list1[$singles] . ' ';
			}
			$words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
		} 
		$commas = count($words);
		if ($commas > 1) {
			$commas = $commas - 1;
		}
		$data= implode(' ', $words);
		return $data." ".'only';
	}
	
	function getIndianCurrency($number)
	{
		if($number < 999999999999999999){
			$decimal = round($number - ($no = floor($number)), 2) * 100;
			$hundred = null;
			$digits_length = strlen($no);
			$i = 0;
			$str = array();
			$words = array(0 => '', 1 => 'one', 2 => 'two',
			3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
			7 => 'seven', 8 => 'eight', 9 => 'nine',
			10 => 'ten', 11 => 'eleven', 12 => 'twelve',
			13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
			16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
			19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
			40 => 'forty', 50 => 'fifty', 60 => 'sixty',
			70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
			$digits = array('', 'hundred','thousand','lakh', 'crore','arab','kharab','neel','padma','shankh','gulshan');
			while( $i < $digits_length ) {
				$divider = ($i == 2) ? 10 : 100;
				$number = floor($no % $divider);
				$no = floor($no / $divider);
				$i += $divider == 10 ? 1 : 2;
				if ($number) {
					$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
					$hundred = ($counter == 1 && $str[0]) ? 'and ' : null;
					$str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
				} else $str[] = null;
			}
			$Rupees = implode('', array_reverse($str));
			if($decimal < 20  && $decimal > 10 ){
				$paise = ($decimal) ? "and " . ($words[($decimal)]) . ' paise' : '';
				}else if($decimal % 10 != 0){
				$paise = ($decimal) ? "and " . ($words[($decimal) - ($decimal % 10)] . " " . $words[$decimal % 10]) . ' paise' : '';
			}
			else{
				$paise = ($decimal) ? "and " . ($words[($decimal) - ($decimal % 10)])  .' paise' : '';
			}
			return ($Rupees ? $Rupees . 'rupees ' : '') . $paise ;
		}
		else{
			return 'Too much amount!';
		}
	}
	
	/*----------------Get Reg id From User Id------------------*/
	
	function get_user_id_by_reg_id($id)
	{
		$CI =& get_instance();
		$query=$CI->db->get_where('m03_user_detail',array('user_reg_id'=>$id ));
		$row = $query->row();
		if($query->num_rows()==1)
		{	
			return $row->or_m_user_id;	
		}
		else
		{
			return "false";		// RETURN ARRAY WITH ERROR
		}
	}
	
	/*----------------Get User details From reg------------------*/
	
	function get_details_by_reg_id($id)
	{
		$CI =& get_instance();
		$query=$CI->db->get_where('m03_user_detail',array('user_reg_id'=>$id ));
		$row = $query->row();
		if($query->num_rows()==1)
		{	
			return $row;	
		}
		else
		{
			return "false";		// RETURN ARRAY WITH ERROR
		}
	}
	
	function get_transid()
	{
		$CI =& get_instance();
		$bal = $CI->db->query("SELECT get_transaction_id() as bal")->row()->bal;
		return $bal;
	}
	
	function getColumns($column, $table)
	{
		$CI = & get_instance();
		$database = $CI->db->database;
		$result = $CI->db->query("SELECT COLUMN_NAME, COLUMN_COMMENT FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE TABLE_SCHEMA = '$database'
		AND `TABLE_NAME`='$table' AND COLUMN_NAME IN($column)")->result();
		return $result;
	}

	function get_bal($uid){
		$CI = & get_instance();
		return $CI->db->query("SELECT SUM(led_cr_amt) - SUM(led_dr_amt) AS bal FROM tr07_manage_ledger WHERE led_reg_id=".$uid)->row()->bal;
	}
	
?>					