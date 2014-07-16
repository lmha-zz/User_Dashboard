<?php

class User extends CI_Model {

	public function create_user($post) {
		$query = "INSERT INTO users (first_name, last_name, email, password, user_level, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
		$data = array('first_name' => $post['first_name'],
					  'last_name' => $post['last_name'],
					  'email' => $post['email'],
					  'password' => md5($post['password']),
					  'user_level' => 'normal');
		return $this->db->query($query, $data);
	}

	public function read_users() {
		$query = "SELECT * FROM users";
		return $this->db->query($query)->result_array();
	}

	public function read_user($user_id = null, $email = null) {
		if($user_id == null) {
			$query = "SELECT * FROM users WHERE email = '{$email}'";
		}
		if ($email == null) {
			$query = "SELECT * FROM users WHERE id = {$user_id}";
		}
		return $this->db->query($query)->row_array();
	}


}


?>