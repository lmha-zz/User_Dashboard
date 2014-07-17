<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

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

	public function new_user() {
		if(!$this->session->userdata('loggedIn') ) {
			$this->session->set_flashdata('login_errors', "<p class='error'>Please log in.</p>");
			redirect('/users/signin');
		} elseif($this->session->userdata('user_level') != 'admin') {
			$this->session->set_flashdata('login_errors', "<p class='error'>Only admins have access to the page you are trying to load.</p>");
			redirect('/users/signin');
		}
		$this->load->view('/users/new_user');
	}

	public function process_login() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
		if(!$this->form_validation->run()) {
			$this->session->set_flashdata('login_errors', validation_errors());
			redirect('/users/signin');	
		} else {
			$this->load->model('user');
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
		if($this->input->post('register')) {
			$failURL = '/users/register';
			if($this->session->userdata('user_level') == 'admin') {
				$winURL = '/dashboards/admin';
			} else {
				$winURL = '/dashboards';
			}
		} elseif($this->input->post('create_user')) {
			$failURL = '/users/new_user';
			$winURL = '/dashboards/admin';
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('first_name', 'First Name', 'required|alpha');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|alpha');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
		$this->form_validation->set_rules('password_confirmation', 'Confirmation Password', 'required|matches[password]');
		if(!$this->form_validation->run()) {
			$this->session->set_flashdata('register_errors', validation_errors());
			redirect($failURL);
		} else {
			$this->load->model('user');
			$totalUsers = $this->user->count_users();
			if(count($totalUsers) > 0) {
				$reg_status = $this->user->create_user($this->input->post(), 'normal');
			} else {
				$reg_status = $this->user->create_user($this->input->post(), 'admin');
			}
			if($reg_status) {
				$user = $this->user->read_user(null, $this->input->post('email'));
				if($this->input->post('register')) {
					$this->session->set_userdata('user_name', ucwords($user['first_name'].' '.$user['last_name']));
					$this->session->set_userdata('user_id', $user['id']);
					$this->session->set_userdata('loggedIn', true);
					$this->session->set_userdata('user_level', $user['user_level']);
					if($user['user_level'] == 'admin') {
						redirect('/dashboards/admin');
					} else {
						redirect("/dashboards");
					}
				} elseif($this->input->post('create_user')) {
					$this->session->set_flashdata('new_user', "<p class='success'>You have successfully created the new user, ".ucwords($user['first_name'].' '.$user['last_name'])."</p>");
					redirect($winURL);
				}
			} else {
				$this->session->set_flashdata('register_errors', "<p class='error'>An error occured while trying to register. Please try again in a couple of minutes.</p>");
				redirect($failURL);
			}
		}
	}

	public function process_message() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('message', 'Message', 'trim|required');
		if($this->form_validation->run()) {
			$this->load->model('message');
			$this->message->create_message($this->input->post(), $this->session->userdata('user_id'));
		} else {
			$this->session->set_flashdata('show_errors', validation_errors());
		}
		redirect("/users/show/{$this->input->post('user_id')}");
	}

	public function process_comment() {
		$this->load->model('comment');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('comment', 'Comment', 'trim|required');
		if($this->form_validation->run()) {
			$this->comment->create_comment($this->input->post(), $this->session->userdata('user_id'));
		} else {
			$this->session->set_flashdata('show_errors', validation_errors());
		}
		redirect("/users/show/{$this->input->post('user_id')}");
	}

	public function process_edit_user_info() {
		$this->load->model('user');
		$user_info = $this->user->read_user($this->input->post('user_id_editting'), null);
		$user_info['user_id_editting'] = $this->input->post('user_id_editting');
		$user_info['update_user'] = $this->input->post('update_user');
		$userInfoChanges = false;
		foreach($this->input->post() as $key => $value) {
			$this->load->library('form_validation');
			if($value != $user_info[$key]) {
				switch ($key) {
					case 'email':
						$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
						$userInfoChanges = true;
						break;
					case 'first_name':
					case 'last_name':
						$this->form_validation->set_rules($key, ucwords(str_replace("_", " ", $key)), 'required|alpha');
						$userInfoChanges = true;
						break;
				}
			}
		}
		if($this->session->userdata('user_level') == 'admin') {
			if(strtolower($this->input->post('user_level')) != $user_info['user_level']) {
				$this->form_validation->set_rules('user_level', 'User Level', 'required');
				$userInfoChanges = true;
				if(($this->session->userdata('user_id') == $this->input->post('user_id_editting')) && (strtolower($this->input->post('user_level')) == 'normal')) {
					$this->session->set_userdata('user_level', "normal");
				}
			}
		}
		if($userInfoChanges) {
			if($this->form_validation->run()) {
				$update_status = $this->user->update_user_info($this->input->post(), $this->input->post('user_level'));
				if($update_status) {
					$this->session->set_flashdata('edit_success', "<p class='success'>You have successfully updated the user information for ".ucwords($user_info['first_name'].' '.$user_info['last_name'])."</p>");
				} else {
					$this->session->set_flashdata('edit_errors', "<p class='error'>An error occured while trying to update user information. Try again.</p>");
				}
			} else {
				$this->session->set_flashdata('edit_errors', validation_errors());
			}
		} else {
			$update_status = $this->user->update_user_info($this->input->post(), $user_info['user_level']);
			if($update_status) {
				$this->session->set_flashdata('edit_success', "<p class='success'>You did not change anything ... but.... You have successfully updated the user information for ".ucwords($user_info['first_name'].' '.$user_info['last_name'])."</p>");
			} else {
				$this->session->set_flashdata('edit_errors', "<p class='error'>An error occured while trying to update user's information. Try again.</p>");
			}
		}
		redirect("/users/edit/{$this->input->post('user_id_editting')}");		
	}

	public function process_edit_user_pw() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
		$this->form_validation->set_rules('password_confirmation', 'Confirmation Password', 'required|matches[password]');
		if($this->form_validation->run()) {
			$this->load->model('user');
			$update_pw_status = $this->user->update_user_pw($this->input->post());
			if($update_pw_status) {
				$user_info = $this->user->read_user($this->input->post('user_id_editting'), null);
				$this->session->set_flashdata('edit_pw_success', "<p class='success'>Yay, successfully updated ".ucwords($user_info['first_name'].' '.$user_info['last_name'])."'s password!</p>");
			} else {
				$this->session->set_flashdata('edit_pw_errors', "<p class='error'>An error occured while trying to update password. Try again.</p>");
			}
		} else {
			$this->session->set_flashdata('edit_pw_errors', validation_errors());
		}
		redirect("/users/edit/{$this->input->post('user_id_editting')}");
	}

	public function process_user_description() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		if($this->form_validation->run()) {
			$this->load->model('user');
			$update_desc_status = $this->user->update_user_desc($this->input->post());
			if($update_desc_status) {
				$user_info = $this->user->read_user($this->input->post('user_id_editting'), null);
				$this->session->set_flashdata('edit_desc_success', "<p class='success'>Yay, successfully updated ".ucwords($user_info['first_name'].' '.$user_info['last_name'])."'s description!</p>");
			} else {
				$this->session->set_flashdata('edit_desc_errors', "<p class='error'>An error occured while trying to update description. Try again.</p>");
			}
		} else {
			$this->session->set_flashdata('edit_desc_errors', validation_errors());
		}
		redirect("/users/edit/{$this->input->post('user_id_editting')}");
	}

	public function show($user_id = null) {
		if(!$this->session->userdata('loggedIn')) {
			$this->session->set_flashdata('login_errors', "<p class='error'>Please log in to view user profiles.</p>");
			redirect('/users/signin');
		}
		$this->load->model('user');
		$this->load->model('comment');
		$this->load->model('message');
		$user_info = $this->user->read_user($user_id, null);
		$messages = $this->message->read_user_messages($user_id);
		$comments = array();
		foreach ($messages as $index => $message) {
			$comments["{$message['msgId']}"][] = $this->comment->read_comments($message['msgId']);
		}
		$viewData = array('user_info' => $user_info,
						  'user_msgs' => $messages,
						  'user_msg_comments' => $comments);
		$this->load->view('/users/show', $viewData);
	}

	public function edit($user_id = null) {
		if(!$this->session->userdata('loggedIn')) {
			$this->session->set_flashdata('login_errors', "<p class='error'>Please log in.</p>");
			redirect('/users/signin');
		}
		$this->load->model('user');
		if($user_id == null) {
			$user_info = $this->user->read_user($this->session->userdata('user_id'), null);
			$this->load->view('/users/edit', $user_info);
		} else {
			if($this->session->userdata('user_level') != 'admin') {
				redirect('/users/edit');
			} else {
				$user_info = $this->user->read_user(intval($user_id), null);
				$this->load->view('/users/edit', $user_info);
			}
		}
	}

	public function delete($user_id) {
		if(!$this->session->userdata('loggedIn') ) {
			$this->session->set_flashdata('login_errors', "<p class='error'>Please log in.</p>");
			redirect('/users/signin');
		} elseif($this->session->userdata('user_level') != 'admin') {
			$this->session->set_flashdata('login_errors', "<p class='error'>Only admins have the power to delete a user.</p>");
			redirect('/users/signin');
		}
		$this->load->model('user');
		if($this->session->userdata('user_id') == $user_id) {
			$delete_status = $this->user->delete_user($user_id);
			if($delete_status) {
				$this->session->unset_userdata('user_name');
				$this->session->unset_userdata('user_id');
				$this->session->unset_userdata('loggedIn');
				$this->session->unset_userdata('user_level');
				$this->session->set_flashdata('delete_user_success', "<p class='success'>You have successfully deleted your own account. Please register with us again to log in.</p>");
				redirect('/users/register');
			} else {
				$this->session->set_flashdata('delete_user_error', "<p class='error'>An error has occurred while trying to delete the user, .".$this->input->post('name').". Please try again.</p>");
				redirect('/dashboards/admin');
			}
		} else {
			$delete_status = $this->user->delete_user($user_id);
			if($delete_status) {
				$this->session->set_flashdata('delete_user_success', "<p class='success'>You have successfully deleted the user, ".$this->input->post('name')."</p>");
				redirect('/dashboards/admin');
			} else {
				$this->session->set_flashdata('delete_user_error', "<p class='error'>An error has occurred while trying to delete the user, .".$this->input->post('name').". Please try again.</p>");
				redirect('/dashboards/admin');
			}
		}
	}


	public function logoff() {
		$this->session->sess_destroy();
		redirect('/users');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */