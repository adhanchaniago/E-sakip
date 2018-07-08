<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portal extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->data = array(
			'title' => "E-Sakip | Sistem Informasi"
		);

		$this->load->view('portal', $this->data);

	}

}

/* End of file Portal.php */
/* Location: ./application/controllers/Portal.php */