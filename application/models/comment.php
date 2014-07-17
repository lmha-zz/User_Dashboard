<?php

class Comment extends CI_Model {

	public function create_comment($post, $author_id){
		$query = "INSERT INTO comments (user_id, message_id, comment, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())";
		$data = array('user_id' => $author_id,
					  'message_id' => $post['msg_id'],
					  'comment' => $post['comment']);
		$this->db->query($query, $data);
	}

	public function read_comments($msg_id) {
		$query = "SELECT *, comments.created_at AS created_at FROM comments
				  JOIN users ON comments.user_id = users.id
				  WHERE message_id = {$msg_id}";
		return $this->db->query($query)->result_array();
	}

	public function delete_comments($user_id) {
		$query = "DELETE * FROM comments WHERE user_id = {$user_id}";
		$this->db->query($query);
	}

}

?>