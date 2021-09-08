<?php
	class Post_model extends CI_Model {
    public function __construct(){
        $this->load->database();
		$this->load->model('notification_model', 'notify');
    }

    public function search_post($search, $limit, $start){
		$this->db->select('users.username, users.first_name, users.last_name, users.image, post.id as post_ID, post.status as post_status, post.*');
		$this->db->join('users', 'users.id = post.user_ID');
		$this->db->like('post.post', $search);
    	$this->db->order_by('post.timestamp', 'DESC');
		$this->db->where('post.status', '1');
		if(!empty($limit)){
			$this->db->limit($limit, $start);
		}
		$query = $this->db->get('post');

		return $query->result_array();
	}

    public function get_review_status(){
		$this->db->select('review_post_status');
		$query = $this->db->get_where('settings', array('id' => '1'));
		return $query->row_array();
	}

	public function get_enrolled_post($limit, $start, $id){
    	$this->db->select('users.username, users.first_name, users.last_name, users.image, post.id as post_ID, post.user_ID, post.status as post_status, post.timestamp, post.post, post_to_course.course_ID, post.privacy, post.pin');
    	$this->db->join('users', 'users.id = post.user_ID');
    	$this->db->join('post_to_course', 'post_to_course.post_ID = post.id');
		$this->db->join('purchase', 'purchase.course_ID = post_to_course.course_ID');
		$this->db->where('post_to_course.course_ID !=', 0);
		$this->db->where('purchase.user_ID',$id);
    
    	$this->db->order_by('post.timestamp', 'DESC');
    	if(!empty($limit)){
			$this->db->limit($limit, $start);
		}

		$this->db->group_by('post.post');
		$query = $this->db->get('post');
		return $query->result_array();
	}
	
	public function get_post($id = FALSE){
		$this->db->select('users.username, users.first_name, users.last_name, users.image, post.id as post_ID, post.status as post_status, post.*');
    	$this->db->join('users', 'users.id = post.user_ID');
    	$this->db->join('post_to_course', 'post_to_course.post_ID = post.id');
		if($id === FALSE){
			$query = $this->db->get('post');
			return $query->result_array();
		}
		$query = $this->db->get_where('post', array('post.id' => $id));
		return $query->row_array();
	}

	public function get_following_post($limit, $start, $status, $user_ID){
    	$this->db->select('users.username, users.first_name, users.last_name, users.image, post.id as post_ID, post.user_ID, post.status as post_status, post.timestamp, post.post, post.privacy, post.pin');
    	$this->db->join('users', 'users.id = post.user_ID');
    	$this->db->join('users_follow', 'post.user_ID = users_follow.following');
    	$this->db->join('post_to_course', 'post_to_course.post_ID = post.id');
    	$this->db->where('users_follow.follower', $user_ID);
    	if(!is_null($status)){
    		$this->db->where('post.status', $status);
    	}

    	$this->db->order_by('post.timestamp', 'DESC');
    	if(!empty($limit)){
			$this->db->limit($limit, $start);
		}
		$this->db->group_by('post.post');
		$query = $this->db->get('post');
		return $query->result_array();
	}

    public function get_posts($course_ID, $limit, $start, $status, $pin, $id = FALSE){
    	$this->db->select('users.username, users.first_name, users.last_name, users.image, post.id as post_ID, post.user_ID, post.status as post_status, post.timestamp, post.post, post_to_course.course_ID, post.privacy, post.pin');
    	$this->db->join('users', 'users.id = post.user_ID');
    	$this->db->join('post_to_course', 'post_to_course.post_ID = post.id');
    	if(!is_null($status)){
    		$this->db->where('post.status', $status);
    	}

    	if(!is_null($course_ID)){
    		$this->db->where('post_to_course.course_ID', $course_ID);
		}

		if(!is_null($pin)){
    		$this->db->order_by('post.pin', 'DESC');
		}
    	
    	$this->db->order_by('post.timestamp', 'DESC');
    	if(!empty($limit)){
			$this->db->limit($limit, $start);
		}
		if($id === FALSE){
			$query = $this->db->get('post');
			return $query->result_array();
		}
		$this->db->group_by('post.post');
		$query = $this->db->get_where('post', array('post.user_ID' => $id));
		return $query->result_array();
	}

	public function get_post_to_course($id){
		$this->db->select('course.title, course.id as course_ID');
    	$this->db->join('course', 'course.id = post_to_course.course_ID', 'left');
		$query = $this->db->get_where('post_to_course', array('post_to_course.post_ID' => $id));
		return $query->result_array();
	}

	public function get_post_files($id){
		$this->db->select('post_file.*, post.user_ID');
    	$this->db->join('post', 'post.id = post_file.post_ID');
		$query = $this->db->get_where('post_file', array('post_ID' => $id));
		return $query->result_array();
	}

	public function get_comment($comment_ID = FALSE){
    	if($comment_ID === FALSE){
			$query = $this->db->get('post_comment');
			return $query->result_array();
		}
		$this->db->where('id', $comment_ID);
		$query = $this->db->get('post_comment');
		return $query->row_array();
	}

	public function get_comments($limit, $start, $post_ID = FALSE){
		$this->db->select('post_comment.*, post_comment.user_ID as user_ID, post_comment.id as comment_ID, users.last_name, users.username, users.first_name, users.image, post_comment.id as comment_ID, , post_comment.image as comment_image, post.user_ID as owner_post');
    	$this->db->join('users', 'users.id = post_comment.user_ID', 'left');
    	$this->db->join('post', 'post.id = post_comment.post_ID', 'left');
    	$this->db->where('post_comment.parent_comment', 0);
    	if(!empty($limit)){
			$this->db->limit($limit, $start);
		}
		$this->db->order_by('post_comment.timestamp', 'DESC');
    	if($post_ID === FALSE){
			$query = $this->db->get('post_comment');
			return $query->result_array();
		}
		$this->db->where('post_comment.post_ID', $post_ID);
		$query = $this->db->get('post_comment');
		return $query->result_array();
	}

	public function get_replies($post_ID, $comment_ID){
		$this->db->select('post_comment.*, post_comment.id as comment_ID, users.last_name, users.username, users.first_name, users.image, post.user_ID as owner_post, post_comment.image as comment_image');
    	$this->db->join('users', 'users.id = post_comment.user_ID', 'left');
    	$this->db->join('post', 'post.id = post_comment.post_ID', 'left');
		$this->db->where('post_comment.post_ID', $post_ID);
		$this->db->where('post_comment.parent_comment', $comment_ID);
		$this->db->order_by('post_comment.timestamp', 'DESC');
		$query = $this->db->get('post_comment');
		return $query->result_array();
	}

	public function create_post($course_ID, $files, $posts, $user_ID, $tagged_users){
		$this->db->trans_begin();
		$sql = $this->get_review_status();

		if($sql['review_post_status'] == 0){
			$status = '1';
		} else {
			$status = '0';
		}

		$data = array(
			'user_ID' => $user_ID,
			'post' => $posts,
			'status' => $status
		);
		
		$this->db->set('timestamp', 'NOW()', FALSE);
		$this->db->insert('post', $data);
		$post_id = $this->db->insert_id();

		if(!empty($tagged_users)){
			$this->notify->tag_users(4, 1, $post_id, $tagged_users, $user_ID);
		}

		$total = count($files);
		for($i=0; $i<$total; $i++) {
			if(trim($files[$i] != '')) {
				$file_name = $files[$i];
		        $data3 = array(
		        	'post_ID' => $post_id,
		        	'file' => $file_name
				);
				$this->db->insert('post_file', $data3);
			}
		}

		if(!empty($course_ID)){
			for($i=0; $i<count($course_ID); $i++) {
				if(trim($course_ID[$i] != '')) {
					$course = $course_ID[$i];
			        $data4 = array(
			        	'post_ID' => $post_id,
			        	'course_ID' => $course
					);
					$this->db->insert('post_to_course', $data4);
				}
			}
		}
		
		$this->db->set('exp', 'exp+3', FALSE);
		$this->db->where('id', $user_ID);
		$this->db->update('users');

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function edit_post($post_ID, $posts, $course_ID, $files, $tagged_users, $user_ID){
		$this->db->trans_begin();
		$this->db->delete('notification_to_user', array('id' => $post_ID, 'notification_name_id' => 4));
		$this->db->delete('post_to_course', array('post_ID' => $post_ID));
		$this->db->delete('post_file', array('post_ID' => $post_ID));
		
		$data = array(
			'post' => $posts,
		);
		$this->db->where('id', $post_ID);
		$this->db->update('post', $data);

		if(!empty($tagged_users)){
			$this->notify->tag_users(4, 1, $post_ID, $tagged_users, $user_ID);
		}

		foreach ($files as $key => $value) {
			$data3 = array(
	        	'post_ID' => $post_ID,
	        	'file' =>  $files[$key]['image'],
	        	'description' =>  $files[$key]['description']
			);
			$this->db->replace('post_file', $data3);
		}

		if(!empty($course_ID)){
			for($i=0; $i<count($course_ID); $i++) {
				if(trim($course_ID[$i] != '')) {
					$course = $course_ID[$i];
			        $data4 = array(
			        	'post_ID' => $post_ID,
			        	'course_ID' => $course
					);
					$this->db->insert('post_to_course', $data4);
				}
			}
		}

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function add_comments($image, $post_ID, $comment, $parent_comment, $owner_ID, $user_ID, $tagged_users){
		$this->db->trans_begin();
		

		$query = $this->db->get_where('post', array('id'=>$post_ID));
		
		if($query->num_rows() == 0){
			return false;
		} else {
			$data = array(
				'post_ID' => $post_ID,
				'parent_comment' => $parent_comment,
				'comment' => $comment,
				'image' => $image,
				'user_ID' => $user_ID
			);
		
			$this->db->set('timestamp', 'NOW()', FALSE);
			$this->db->insert('post_comment', $data);
			$comment_ID = $this->db->insert_id();

			if($owner_ID != $user_ID){
				if($parent_comment == 0){
					$this->notify->create_notification(2, 5, $comment_ID, $owner_ID, $user_ID);
				} else {
					$this->notify->create_notification(2, 7, $comment_ID, $owner_ID, $user_ID);
				}
			}
			$this->db->set('exp', 'exp+3', FALSE);
			$this->db->where('id', $user_ID);
			$this->db->update('users');
			if(!empty($tagged_users)){
				$this->notify->tag_users(6, 2, $comment_ID, $tagged_users, $user_ID);
			}
		}

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function get_liked($user_ID){
		$this->db->where('user_ID', $user_ID);
		$query = $this->db->get('post_react');
		return $query->result_array();
	}

	public function total_likes($post_ID){
		$this->db->where('post_ID', $post_ID);
		return $this->db->count_all_results('post_react');
	}

	public function total_comments($post_ID){
		$this->db->where('post_ID', $post_ID);
		return $this->db->count_all_results('post_comment');
	}

	public function get_total_likes_comments($comment_ID){
		$this->db->where('comment_ID', $comment_ID);
		return $this->db->count_all_results('post_comment_react');
	}

	public function get_total_replies($comment_ID){
		$this->db->where('parent_comment', $comment_ID);
		return $this->db->count_all_results('post_comment');
	}

	public function get_liked_comments($user_ID){
		$this->db->where('user_ID', $user_ID);
		$query = $this->db->get('post_comment_react');
		return $query->result_array();
	}

	public function like_post($post_ID, $owner_ID, $user_ID){
		$this->db->trans_begin();
		
		$data = array(
			'post_ID' => $post_ID,
			'user_ID' => $user_ID,
		);
		$this->db->insert('post_react', $data);

		if($owner_ID != $user_ID){
			$this->notify->create_notification(1, 3, $post_ID, $owner_ID, $user_ID);
		}
		
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function like_comment($comment_ID, $owner_ID, $post_ID, $user_ID){
		$this->db->trans_begin();
		$data = array(
			'comment_ID' => $comment_ID,
			'user_ID' => $user_ID,
		);
		$this->db->insert('post_comment_react', $data);
		
		if($user_ID != $owner_ID){
			$this->notify->create_notification(2, 8, $comment_ID, $owner_ID, $user_ID);
		}
		
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function unlike_post($post_ID, $user_ID){
		$this->db->delete('notification_to_user', array('notification_name_id' => 3, 'id' => $post_ID, 'notifier' => $user_ID));
		$this->db->delete('post_react', array('post_ID' => $post_ID, 'user_ID' => $user_ID));
	}

	public function pin_post($post_ID, $pin){
		$this->db->trans_begin();

		$this->db->set('pin', $pin);
		$this->db->where('id', $post_ID);
		$this->db->update('post');

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function unpin_post($post_ID){
		$this->db->trans_begin();

		$this->db->set('pin', '0');
		$this->db->where('id', $post_ID);
		$this->db->update('post');

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function unlike_comment($comment_ID, $user_ID){
		$this->db->delete('post_comment_react', array('comment_ID' => $comment_ID, 'user_ID' => $user_ID));
		$this->db->delete('notification_to_user', array('notification_name_id' => 8, 'type' => 1, 'notifier' => $user_ID));
	}

	public function delete_post($post_ID){
		$this->db->delete('post', array('id' => $post_ID));
	}

	public function delete_comment($comment_ID){
		$this->db->delete('post_comment', array('id' => $comment_ID));
		$this->db->delete('post_comment', array('parent_comment' => $comment_ID));
	}

	public function get_on_review_posts(){
		$this->db->where('status', '0');
		return $this->db->count_all_results('post');
	}

	public function total_posts(){
		return $this->db->count_all('post');
	}

	public function get_likers($post_ID){
		$this->db->select('users.username, users.first_name, users.last_name, users.image, users.id as user_ID');
		$this->db->join('users', 'users.id = post_react.user_ID');
    	$this->db->order_by('users.first_name', 'ASC');
		$query = $this->db->get_where('post_react', array('post_ID' => $post_ID));

		return $query->result_array();
	}

	public function approve_post($post_ID, $user_ID){
		$this->db->trans_begin();

		$this->db->set('status', '1');
		$this->db->where('id', $post_ID);
		$this->db->update('post');

		$this->notify->create_notification(1, 1, $post_ID, $user_ID, 0);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function deny_post($post_ID, $user_ID){
		$this->db->trans_begin();

		$this->db->set('status', '0');
		$this->db->where('id', $post_ID);
		$this->db->update('post');

		$this->notify->create_notification(1, 2, $post_ID, $user_ID, 0);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}
	
}