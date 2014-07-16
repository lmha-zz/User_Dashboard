<?php

class Message extends CI_Model {

	public function create_message($post, $author_id){
		$query = "INSERT INTO messages (user_id, author_id, message, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())";
		$data = array('user_id' => $post['user_id'],
					  'author_id' => $author_id,
					  'message' => $post['message']);
		$this->db->query($query, $data);
	}

	public function read_user_messages($user_id) {
		$query = "SELECT *, messages.id AS msgId, messages.created_at AS created_at FROM messages
				  JOIN users ON messages.author_id = users.id
				  WHERE messages.user_id = {$user_id}
				  ORDER BY messages.created_at DESC";
		return $this->db->query($query)->result_array();
	}

}

?>