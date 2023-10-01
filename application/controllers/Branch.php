<?php 
class Branch extends CI_Controller 
{
	
	public function __construct() 
	{
		parent::__construct();
		$this->_is_logged_in();
		$this->data['page'] = "Branch";
		$this->load->model('Branch_model');
	}
	
	public function index()
	{
		$data['form_name'] = "Dashboard";		
		$this->view('branch_dashboard', $data);
	}
	
	
	public function _is_logged_in()
	{
		if (session('user_id') == "" || session('usertype') == "3"  || session('usertype') == "4") {
			redirect('auth/logout');
		}
	}
	
	public function view($page_name = null, $data = null)
	{
		$this->load->view('common/header', $this->data);
		if (session('usertype') == "4") {
			$this->data['menu'] = $this->db->query("SELECT * FROM `tr36_menu` WHERE `menu_id` IN (SELECT as_parent_id FROM `view_all_assigned_menu` WHERE `as_sub_admin` = " . session('profile_id') . " and menu_status = 1 GROUP BY as_parent_id) ORDER BY `menu_id`");
			$this->load->view('common/subadmin_menu', $this->data);
		} else {
			$this->load->view('common/menu', $this->data);
		}
		$this->load->view('Branch/' . $page_name, $data);
		$this->load->view('common/footer');
	}
	
}
?>