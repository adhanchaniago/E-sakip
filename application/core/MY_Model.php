<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

}

class Sakip_model extends MY_Model
{
	public $user;

	public function __construct()
	{
		parent::__construct();

		$this->load->library(array('session'));
		
		$this->user = $this->session->userdata('ID');
	}
// ambil data users
	public function get_user($param = 0)
	{
		if($param == FALSE)
		{
			return $this->db->get('users')->result();
		} else {
			return $this->db->get_where('users', array('user_id' => $param))->row();
		}
	}
// ambil data role_id
	public function get_role($param = 0)
	{
		if($param == FALSE)
		{
			return $this->db->get('users_role')->result();
		} else {
			return $this->db->get_where('users_role', array('role_id' => $param))->row();
		}
	}


}

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */

