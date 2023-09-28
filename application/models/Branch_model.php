<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Branch_model extends CI_Model
	{
	
	
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

          //  echo $code_coun; die;

			$info = array(
				'branch_id'		=>	'',
				'branch_code'		=>	$bcode,
				'branch_name'				=>	post('txtname'),
				'contact_person'				=>	post('txtbhead'),
				'contact_no'			=>	post('txtmobile'),
				'branch_email'				=>	post('txtemail'),
				'state_id'				=>	post('branch_state'),
				'city_id'			=>	post('branch_city'),
				'branch_address'				=>	post('txtaddress'),
				'branch_password'				=>	post('txtpassword'),
				'proc'					=>	1
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
		
		
			
	}
?>