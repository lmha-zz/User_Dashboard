<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user');
		$this->load->model('message');
		$this->load->model('comment');
	}

	public function index()
	{
		$this->load->view('/users/index');
	}

	public function signin() {
		$this->load->view('/users/signin');
	}

	public function register() {
		$this->load->view('/users/register');
	}

	public function process_login() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
		if(!$this->form_validation->run()) {
			$this->session->set_flashdata('login_errors', validation_errors());
			redirect('/users/signin');	
		} else {
			$user = $this->user->read_user(null, $this->input->post('email'));
			if(count($user) != 0) {
				if(md5($this->input->post('password')) === $user['password']) {
					$this->session->set_userdata('user_name', ucwords($user['first_name'].' '.$user['last_name']));
					$this->session->set_userdata('user_id', $user['id']);
					$this->session->set_userdata('loggedIn', true);
					$this->session->set_userdata('user_level', $user['user_level']);
					if($user['user_level'] == 'admin') {
						redirect('/dashboards/admin');
					} else {
						redirect("/dashboards");
					}
				} else {
					$this->session->set_flashdata('login_errors', "<p class='error'>Password did not match user records.</p>");
					redirect("/users/signin");
				}
			} else {
				$this->session->set_flashdata('login_errors', "<p class='error'>A user registered with that email does not exist.</p>");
				redirect("/users/signin");
			}
		}
	}

	public function process_new_user() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('first_name', 'First Name', 'required|alpha');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|alpha');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
		$this->form_validation->set_rules('password_confirmation', 'Confirmation Password', 'required|matches[password]');
		if(!$this->form_validation->run()) {
			$this->session->set_flashdata('register_errors', validation_errors());
			redirect('/users/register');	
		} else {
			$reg_status = $this->user->create_user($this->input->post());
			if($reg_status) {
				$user = $this->user->read_user($this->input->post('email'));
				$this->session->set_userdata('user_name', ucwords($user['first_name'].' '.$user['last_name']));
				$this->session->set_userdata('user_id', $user['id']);
				$this->session->set_userdata('loggedIn', true);
				$this->session->set_userdata('user_level', $user['user_level']);
				if($user['user_level'] == 'admin') {
						redirect('/dashboards/admin');
					} else {
						redirect("/dashboards");
					}
			} else {
				$this->session->set_flashdata('register_errors', "<p class='error'>An error occured while trying to register. Please try again in a couple of minutes.</p>");
				redirect('/users/register');
			}
		}
	}

	public function process_message() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('message', 'Message', 'trim|required');
		if($this->form_validation->run()) {
			$this->message->create_message($this->input->post(), $this->session->userdata('user_id'));
		} else {
			$this->session->set_flashdata('show_errors', validation_errors());
		}
		redirect("/users/show/{$this->input->post('user_id')}");
	}

	public function process_comment() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('comment', 'Comment', 'trim|required');
		if($this->form_validation->run()) {
			$this->comment->create_comment($this->input->post(), $this->session->userdata('user_id'));
		} else {
			$this->session->set_flashdata('show_errors', validation_errors());
		}
		redirect("/users/show/{$this->input->post('user_id')}");
	}

	public function new_user() {
		$this->load->view('/users/new_user');
	}

	public function show($user_id) {

		$user_info = $this->user->read_user($user_id, null);
		$messages = $this->message->read_user_messages($user_id);
		$viewData = array('user_info' => $user_info,
						  'user_msgs' => $messages);
		$this->load->view('/users/show', $viewData);
	}

	// public function load_wall($user_id) {
	// 	$this->load->model('message');
	// 	$messages = $this->message->read_user_messages($user_id);
	// 	var_dump($messages);
	// }

	public function edit($user_id = null) {
		//load user profile page...
		if($user_id == null) {
			$user_info = $this->user->read_user($this->session->userdata('user_id'), null);
			$this->load->view('/users/edit', $user_info);
			//show users/edit/user_id to view profile
		} else {
			$user_info = $this->user->read_user(intval($this->session->userdata('user_id'), null));
			$this->load->view('/users/edit', $user_info);
		}
	}

	public function delete($user_id) {
		//if user_id == session_user , logout after complete delete
	}


	public function logoff() {
		$this->session->sess_destroy();
		redirect('/');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */