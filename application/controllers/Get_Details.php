<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Get_details extends CI_Controller
{

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
		$this->db->where('m00_id', $this->input->post('id'));
		$query['rec'] = $this->db->get('m00_setconfig')->result();
		$json = json_encode($query);
		echo $json;
	}

	/*----------------- UPDATE FROM ADMIN------------------*/

	public function update_value()
	{
		if (post('val') <> "" && session('profile_id') == 0) {
			if (post('proc') == 'bank') {		// of Unit Master
				$this->db->set("bank_name", post('val'))->where('bank_id', post('id'))->update("m01_bank");
			} elseif (post('proc') == 'setConfig') {		// of Set Configuration
				$this->db->set("m00_value", post('val'))->where('m00_id', post('id'))->update("m00_setconfig");
			} elseif (post('proc') == 'adminBankName') {		// of Admin Bank Name Master
				$this->db->set("ad_bank_bank_id", post('val'))->where('ad_bank_id', post('id'))->update("m09_admin_bank");
			} elseif (post('proc') == 'adminBankAc') {		// of Admin Bank AC Master
				$this->db->set("ad_bank_ac", post('val'))->where('ad_bank_id', post('id'))->update("m09_admin_bank");
			} elseif (post('proc') == 'adminBankIfsc') {		// of Admin Bank IFSC Master
				$this->db->set("ad_bank_ifsc", post('val'))->where('ad_bank_id', post('id'))->update("m09_admin_bank");
			} elseif (post('proc') == 'adminBankBranch') {		// of Admin Bank Branch Master
				$this->db->set("ad_bank_branch", post('val'))->where('ad_bank_id', post('id'))->update("m09_admin_bank");
			} elseif (post('proc') == 'adminBankAddress') {		// of Admin Bank Address Master
				$this->db->set("ad_bank_address", post('val'))->where('ad_bank_id', post('id'))->update("m09_admin_bank");
			} elseif (post('proc') == 'relation_name') {		// of Relation Name
				$this->db->set("relation_name", post('val'))->where('relation_id', post('id'))->update("m11_relations");
			} elseif (post('proc') == 'relation_gender') {		// of Relation Gender
				$this->db->set("relation_gender", post('val'))->where('relation_id', post('id'))->update("m11_relations");
			} elseif (post('proc') == 'proof_type') {		// of Proof Type
				$this->db->set("proof_type", post('val'))->where('proof_id', post('id'))->update("m08_proof_type");
			} elseif (post('proc') == 'proof_name') {		// of Proof Name
				$this->db->set("proof_name", post('val'))->where('proof_id', post('id'))->update("m08_proof_type");
			} elseif (post('proc') == 'kycAdminNote') {		// of Admin KYC Note
				$this->db->set("kyc_note", post('val'))->where('kyc_id', post('id'))->update("tr03_kyc");
			} elseif (post('proc') == 'loanTypeName') {		// of Loan Type Name
				$this->db->set("ln_type_name", post('val'))->where('ln_type_id', post('id'))->update("ln01_loan_type");
			} elseif (post('proc') == 'loanPlanType') {		// of Loan Plan Type Name
				$this->db->set("ln_plan_type_id", post('val'))->where('ln_plan_id', post('id'))->update("ln02_loan_plan");
			} elseif (post('proc') == 'loanPlanName') {		// of Loan Plan Name
				$this->db->set("ln_plan_name", post('val'))->where('ln_plan_id', post('id'))->update("ln02_loan_plan");
			} elseif (post('proc') == 'loanPlanMinAmt') {		// of Loan Plan Minimum Amt
				$this->db->set("ln_plan_min_amt", post('val'))->where('ln_plan_id', post('id'))->update("ln02_loan_plan");
			} elseif (post('proc') == 'loanPlanMaxAmt') {		// of Loan Plan Maximum Amt
				$this->db->set("ln_plan_max_amt", post('val'))->where('ln_plan_id', post('id'))->update("ln02_loan_plan");
			} elseif (post('proc') == 'loanPlanAnnualInterest') {		// of Loan Plan Annual Interest
				$this->db->set("ln_plan_annual_interest", post('val'))->where('ln_plan_id', post('id'))->update("ln02_loan_plan");
			} elseif (post('proc') == 'loanPlanFee') {		// of Loan Plan charges/Fee
				$this->db->set("ln_plan_proc_fee_percent", post('val'))->where('ln_plan_id', post('id'))->update("ln02_loan_plan");
			} elseif (post('proc') == 'loanMinMonth') {		// of Loan Plan Minimum Month
				$this->db->set("ln_plan_min_tanure", post('val'))->where('ln_plan_id', post('id'))->update("ln02_loan_plan");
			} elseif (post('proc') == 'loanMaxMonth') {		// of Loan Plan Maximum Month
				$this->db->set("ln_plan_max_tanure", post('val'))->where('ln_plan_id', post('id'))->update("ln02_loan_plan");
			}
		}
	}

	/*----------------- CHANGE STATUS FROM ADMIN------------------*/

	public function change_status()
	{
		if (post('status') == 0 || post('status') == 1 || post('status') == 2 || post('status') == 3 && session('profile_id') == 0) {
			if (post('proc') == 'bank') {       // of Bank Master
				$this->db->set("bank_status", post('status'))->where('bank_id', post('id'))->update("m01_bank");
				success("Bank status changed.");
			} elseif (post('proc') == 'adminBank') {       // of Admin Bank Master
				$this->db->set("ad_bank_status", post('status'))->where('ad_bank_id', post('id'))->update("m09_admin_bank");
				success("Admin Bank status changed.");
			} elseif (post('proc') == 'payment') {       // of  Payment Mode
				$this->db->set("pay_mode_status", post('status'))->where('pay_mode_id', post('id'))->update("m10_payment_mode");
				success("Payment Mode  status changed.");
			} elseif (post('proc') == 'relation') {       // of Relation
				$this->db->set("relation_status", post('status'))->where('relation_id', post('id'))->update("m11_relations");
				success("Relation  status changed.");
			} elseif (post('proc') == 'proof') {       // of Proof
				$this->db->set("proof_status", post('status'))->where('proof_id', post('id'))->update("m08_proof_type");
				success("Proof  status changed.");
			} elseif (post('proc') == 'loanType') {       // of Loan Type
				$this->db->set("ln_type_status", post('status'))->where('ln_type_id', post('id'))->update("ln01_loan_type");
				success("Loan Type  status changed.");
			} elseif (post('proc') == 'loanPlan') {       // of Loan Plan
				$this->db->set("ln_plan_status", post('status'))->where('ln_plan_id', post('id'))->update("ln02_loan_plan");
				success("Loan Plan status changed.");
			} elseif (post('proc') == 'branch') {       // of Branch Master
				$this->db->set("branch_status", post('status'))->where('branch_id', post('id'))->update("m03_branch");
				success("Branch status changed.");
			}
		}
	}

	/*----------------- CHANGE STATUS FROM BOTH SIDE------------------*/
	public function change_user_status()
	{
		if (post('status') == 0 || post('status') == 1 || post('status') == 2) {
			/*	if(post('proc') == 1){       // of Unit Master
					$this->db->set("unit_status", post('status'))->where('unit_id',post('id'))->update("p01_unit");
					success("Unit status changed.");
				} */
		}
	}


	/*----------------- UPDATE FROM BOTH SIDE------------------*/

	public function update_user_value()
	{
		if (post('val') <> "") {
			if (post('proc') == 1) {		// of User DOB
				$this->db->set("user_dob", post('val'))->where('user_reg_id', post('id'))->update("m03_user_detail");
			} elseif (post('proc') == 2) {		// of User Mobile
				$this->db->set("user_mobile_no", post('val'))->where('user_reg_id', post('id'))->update("m03_user_detail");
			} elseif (post('proc') == 3) {		// of User Email
				$this->db->set("user_email", post('val'))->where('user_reg_id', post('id'))->update("m03_user_detail");
			} elseif (post('proc') == 4) {		// of User State
				$this->db->set("user_state", post('val'))->where('user_reg_id', post('id'))->update("m03_user_detail");
			} elseif (post('proc') == 5) {		// of User City
				$this->db->set("user_city", post('val'))->where('user_reg_id', post('id'))->update("m03_user_detail");
			} elseif (post('proc') == 6) {		// of User Pincode
				$this->db->set("user_pincode", post('val'))->where('user_reg_id', post('id'))->update("m03_user_detail");
			} elseif (post('proc') == 7) {		// of User Address
				$this->db->set("user_address", post('val'))->where('user_reg_id', post('id'))->update("m03_user_detail");
			}
		}
	}

	/*----------------- Get Slot Timing ------------------*/

	public function get_slot_timing()
	{
		print_r($this->input->post());
		die;
		$this->db->where('m00_id', $this->input->post('id'));
		$query['rec'] = $this->db->get('m00_setconfig')->result();
		$json = json_encode($query);
		echo $json;
	}

	/*-------------------Remove Product Images------------------*/

	public function remove_product_image()
	{
		$img_id		= post('img_id');
		$pr_vari_id	= post('pr_vari_id');
		$img_name = $this->db->where('pr_img_id', $img_id)->get('p09_product_img')->row()->pr_img_name;
		remove_images('images/product/' . $pr_vari_id . '/', $img_name);
		delete('p09_product_img', ['pr_img_id' => $img_id]);
		echo json_encode('done');
	}

	/*-------------------Remove Product VIDEO------------------*/

	public function remove_product_video()
	{
		$vid_id		= post('vid_id');
		$pr_vari_id	= post('pr_vari_id');
		delete('p10_product_video', ['pr_v_id' => $vid_id]);
		echo json_encode('done');
	}

	/*-------------------Remove Product Assigned Menu ------------------*/

	public function remove_product_menu()
	{
		$vid_id		= post('vid_id');
		$menu_id	= post('menu_id');
		delete('p12_product_show_menu', ['pr_sh_m_id' => $menu_id]);
		echo json_encode('done');
	}

	/*-------------------Cart Update ------------------*/

	public function qty_update()
	{
		$id = "";
		$type = "";
		$id = $this->input->post('id');
		$type = $this->input->post('type');
		$qty = '';

		if ($type == 1) // Updated to Minus one
		{
			$this->db->query("UPDATE `tr44_cart_product` SET `tr44_qty` = tr44_qty-1 WHERE `tr44_id` = " . $id);
			$qty = $this->db->query("SELECT `tr44_qty` AS qty FROM `tr44_cart_product` WHERE `tr44_id` = " . $id)->row()->qty;
			if ($qty == 0) {
				$qty = $this->db->query("DELETE FROM `admin_uniqueforce`.`tr44_cart_product` WHERE `tr44_id` = " . $id);
			}
		}
		if ($type == 2) // Updated to Plus one
		{
			$this->db->query("UPDATE `tr44_cart_product` SET `tr44_qty` = tr44_qty+1 WHERE `tr44_id` = " . $id);
		}
		echo 'Quantity updated';
	}



















	//-------------------Get member name------------------

	public function get_member_name()
	{
		$id = "";
		$id = $this->input->post('txtintuserid');
		$query['name'] = get_intro_name($id);						// Get Details From Admin_Helper
		$json = json_encode($query);
		echo $json;;
	}

	public function get_city()
	{
		$this->db->where('loc_parent_id', $this->input->post('ddstate'));
		$this->db->where('loc_status', 1);
		$query['rec'] = $this->db->get('m02_location')->result();
		$json = json_encode($query);
		echo $json;
	}


	public function get_loan_plan($id)
	{
		$this->db->where('ln_plan_type_id', $id);
		$this->db->where('ln_plan_status', 1);
		$query['rec'] = $this->db->get('ln02_loan_plan')->result();
		$json = json_encode($query);
		echo $json;
	}

	public function check_loan_amt($id)
	{
		$data = $this->db->query("SELECT * FROM `ln02_loan_plan` WHERE ln_plan_id = $id;")->row();
		echo json_encode($data);
	}



	//Validate Mobile No
	public function validate_mobile()
	{
		$query_D = $this->db->query("SELECT COUNT(*) as count_mobile FROM `m03_user_detail` where `user_mobile_no`=" . $this->input->post('phone'));
		$rows = $query_D->row();
		$query['mob'] = $rows->count_mobile;
		$json = json_encode($query);
		echo $json;
	}
	public function verify_mobile_regis()
	{
		$mobile = $this->input->post('txtmobile');
		$this->session->set_userdata('verify_mobile', false);
		$is_exist = $this->db->query("SELECT COUNT(*) as coun FROM `m03_user_detail` WHERE `user_mobile_no` = '$mobile'")->row()->coun;

		if ($is_exist < 3) {
			//$otp = '4444';
			$otp = random_string('numeric', 4);
			$this->session->set_userdata('verify_mobile', false);

			$msg = "Your otp for mobile number verification is " . $otp . ". Team " . SITE_NAME;
			$this->crud_model->send_sms($mobile, $msg);

			$newdata = array(
				'otp'  => $otp,
				'otp_mobile' => $mobile
			);
			$this->session->set_userdata($newdata);
			echo 1;
		} else {
			echo 0;
		}
	}

	public function verify_otp_regis()
	{
		$mobile 	= $this->session->userdata('otp_mobile');
		$sess_otp 	=  $this->session->userdata('otp');
		$user_otp 	= $this->input->post('txtotp');

		if ($user_otp == $sess_otp) {
			$this->session->set_userdata('verify_mobile', true);
			echo 1;
		} else {
			$this->session->set_userdata('verify_mobile', false);
			echo 0;
		}
	}
}
