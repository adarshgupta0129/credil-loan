<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Subadmin_model extends CI_Model
	{
		
		//////////////////////////////////////////////////////////////////
		//////////     Insert New Menu     ///////
		//////////////////////////////////////////////////////////////
		
		public function insert_menu_entry()
		{
			$info = array(
				'menu_name'			=>	post('menu_name'),
				'menu_orderby'		=>	post('menu_orderby'),
				'menu_parent_id'	=>	post('menu_parent_id'),
				'menu_status'		=>	1,
				'menu_url'			=>	post('menu_url'),
				'menu_fa_icon'		=>	post('menu_fa_icon')
			);
			//print_r($info);die;
			$this->db->insert("tr36_menu", $info);
			return "Menu added successfully";
		}
	
		//////////////////////////////////////////////////////////////////
		//////////     Insert New Sub admin     ///////
		//////////////////////////////////////////////////////////////
		
		public function insert_sub_admin()
		{
			$info = array(
				'txtassociate_name'		=>	post('txtassociate_name'),
				'txtdob'				=>	post('txtdob'),
				'txtgender'				=>	post('txtgender'),
				'txtaddress'			=>	post('txtaddress'),
				'txtstate'				=>	post('ddstate'),
				'ddcity'				=>	post('ddcity'),
				'txtpincode'			=>	post('txtpincode'),
				'txtphone'				=>	post('txtmobile'),
				'txtemail'				=>	post('txtemail'),
				'txtpassword'			=>	post('txtpassword'),
				'reg_id'				=>	0,
				'proc'					=>	1
			);
			
			$query 		= " CALL sp_sub_admin(?" . str_repeat(",?", count($info)-1) . ",@msg) ";
			$this->db->query($query, $info);
			$login_id 	= $this->db->query("SELECT @msg as message")->row()->message;
			
			$data['pass'] = post('txtpassword');
			$data['login'] = $login_id;
			
			return $data;
		}
	
		//////////////////////////////////////////////////////////////////
		//////////     Update New Sub admin     ///////
		//////////////////////////////////////////////////////////////
		
		public function update_subadmin($id)
		{
			$info = array(
				'txtassociate_name'		=>	post('txtassociate_name'),
				'txtdob'				=>	post('txtdob'),
				'txtgender'				=>	post('txtgender'),
				'txtaddress'			=>	post('txtaddress'),
				'txtstate'				=>	post('txtstate'),
				'ddcity'				=>	post('ddcity'),
				'txtpincode'			=>	post('txtpincode'),
				'txtphone'				=>	post('txtphone'),
				'txtemails'				=>	post('txtemails'),
				'txtpassword'			=>	post('txtpassword'),
				'reg_id'				=>	$id,
				'proc'					=>	2
			);
 			$query = " CALL sp_sub_admin(?" . str_repeat(",?", count($info)-1) . ",@msg) ";
			$this->db->query($query, $info);
			$data['login_id'] = $this->db->query("SELECT @msg as message")->row()->message;
			
			return $data;
		}
		
		public function view_assign_submenu()
		{
			return $this->db->query('SELECT 
			`tbl1`.`menu_name` AS mainmenu,
			`tr36_menu`.`menu_id` ,
			`tr36_menu`.`menu_status` ,
			`tr36_menu`.`menu_name` AS submenu,
			`tr36_menu`.`menu_id` AS menu_id
			FROM `tr36_menu` 
			LEFT JOIN `tr36_menu` AS tbl1 
			ON `tr36_menu`.`menu_parent_id`=`tbl1`.`menu_id` 
			WHERE tr36_menu.`menu_parent_id` != 0 AND `tr36_menu`.`menu_status` = 1 ORDER BY menu_id');
		}
		
		public function insert_assign_menu()
		{
			$assign_menu = explode(',',post('txtquid'));
			for($i = 0; $i<count($assign_menu)-1; $i++)
			{
				$this->db->query("INSERT IGNORE INTO `tr37_assign_menu` (
				`as_sub_admin`,
				`as_menu`,
				`as_date`,
				`as_parent_id`
				)
				VALUES
				(
				".post('txtsname').",
				".$assign_menu[$i].",
				'".YmdHis."',
				(select menu_parent_id from tr36_menu where menu_id = ".$assign_menu[$i].")
				);");
			}
			return 0;
		}
			
	}
?>