<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboards extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user');
	}

	public function index()
	{
		$this->load->view('/dashboards/index', array('users' => $this->user->read_users()));
	}

	public function admin() {
		$this->load->view('/dashboards/admin', array('users' => $this->user->read_users()));
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */