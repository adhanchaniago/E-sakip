<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	
}


class Sakip extends MY_Controller
{
	public $data = array();

	public $role_name;

	public $IdAccount;

	public $user_id;

	public function __construct()
	{
		parent::__construct();

		$this->IdAccount = $this->session->userdata('ID');

		$this->load->model('maccount', 'account');

		$this->breadcrumbs->unshift(0, 'Home', 'main');

		if($this->session->has_userdata('authentifaction')==FALSE) 
		{
			$this->db->update('users', array('login_status' => 0), array('user_id' => $this->IdAccount));
			
			redirect(site_url('login?from_url='.current_url()));
		}

		$this->user_id = $this->session->userdata('account')->role_id;

		$this->load->js('https://js.pusher.com/2.2/pusher.min.js');
		$this->load->js(base_url("public/dist/js/push.min.js?v1.0.1"));
	}

	
}



/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */