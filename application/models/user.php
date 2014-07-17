<?php

class User extends CI_Model {

	public function create_user($post, $user_level) {
		$query = "INSERT INTO users (first_name, last_name, email, password, user_level, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
		$data = array('first_name' => $post['first_name'],
					  'last_name' => $post['last_name'],
					  'email' => $post['email'],
					  'password' => md5($post['password']),
					  'user_level' => $user_level);
		return $this->db->query($query, $data);
	}

	public function count_users() {
		$query = "SELECT id FROM users";
		return $this->db->query($query)->result_array();
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

	public function update_user_info($post, $user_lvl) {
		$query = "UPDATE users SET email = ?, first_name = ?, last_name = ?, user_level = ?, updated_at = NOW() WHERE users.id = {$post['user_id_editting']}";
		$data = array('email' => $post['email'],
					  'first_name' => $post['first_name'],
					  'last_name' => $post['last_name'],
					  'user_level' => strtolower($user_lvl));
		return $this->db->query($query, $data);
	}

	public function update_user_pw($post) {
		$query = "UPDATE users SET password = ?, updated_at = NOW() WHERE users.id = {$post['user_id_editting']}";
		return $this->db->query($query, array(md5($post['password'])));
	}

	public function update_user_desc($post) {
		$query = "UPDATE users SET description = ?, updated_at = NOW() WHERE users.id = {$post['user_id_editting']}";
		return $this->db->query($query, array($post['description']));
	}

	public function delete_user($user_id) {
		$query = "DELETE FROM users WHERE id = {$user_id}";
		return $this->db->query($query);
	}

}


?>