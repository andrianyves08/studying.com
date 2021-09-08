<?php
	class Review_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

	public function get_reviews($type){
    	if($type == 1){
    		$this->db->select('review.*, reviewer.first_name as reviewer_first_name, reviewer.last_name as reviewer_last_name');
    	} elseif($type == 2){
    		$this->db->select('review.*, reviewer.first_name as reviewer_first_name, reviewer.last_name as reviewer_last_name, users.first_name, users.last_name, users.id as instructor_ID');
    		$this->db->join('users', 'users.id = review.id');
    	} elseif($type == 3){
    		$this->db->select('review.*, reviewer.first_name as reviewer_first_name, reviewer.last_name as reviewer_last_name, course.user_ID as instructor_ID, course.title, users.first_name, users.last_name');
    		$this->db->join('course', 'course.id = review.id');
    		$this->db->join('users', 'users.id = course.user_ID');
    	} else {
    		$this->db->select('review.*, reviewer.first_name as reviewer_first_name, reviewer.last_name as reviewer_last_name, course.user_ID as instructor_ID, course.title as course_title, course_content.title as content_title, users.first_name, users.last_name');
    		$this->db->join('course_content', 'course_content.id = review.id');
			$this->db->join('course_lesson', 'course_lesson.id = course_content.lesson_ID');
			$this->db->join('course_section', 'course_section.id = course_lesson.section_ID');
			$this->db->join('course_module', 'course_module.id = course_section.module_ID');
			$this->db->join('course', 'course.id = course_module.course_ID');
    		$this->db->join('users', 'users.id = course.user_ID');
    	}
    	$this->db->join('users as reviewer', 'reviewer.id = review.user_ID');
		$this->db->where('review.type', $type);
		$this->db->order_by('review.timestamp', 'ASC');

		$query = $this->db->get('review');
		return $query->result_array();
	}

	public function get_review($type, $limit, $start, $id, $user_ID = FALSE){
		$this->db->select('review.*, users.first_name, users.last_name, users.image, users.username');
		$this->db->join('users', 'users.id = review.user_ID', 'left');
		$this->db->where('review.type', $type);
		$this->db->where('review.id', $id);
		$this->db->order_by('review.timestamp', 'DESC');
		if(!empty($limit)){
			$this->db->limit($limit, $start);
		}

		if($user_ID === FALSE){
    		$query = $this->db->get('review');
			return $query->result_array();
		}

		$this->db->where('review.user_ID', $user_ID);
		$query = $this->db->get('review');
		return $query->row_array();
	}

	public function get_rating($type, $id){
		$this->db->select('(sum(rating) / COUNT(id)) AS avg');
		$this->db->where('type', $type);
		$this->db->where('id', $id);
		$query = $this->db->get('review');
		return $query->row_array();
	}

	public function create_review($id, $type, $rating, $comment, $user_ID){
		$this->db->trans_begin();
		$data = array(
			'id' => $id,
			'type' => $type,
			'rating' => $rating,
			'comment' => $comment,
			'user_ID' => $user_ID,
		);
		$this->db->insert('review', $data);
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function update_review($review_ID, $id, $type, $rating, $comment, $user_ID){
		$this->db->trans_begin();
		
		$data = array(
			'id' => $id,
			'type' => $type,
			'rating' => $rating,
			'comment' => $comment,
			'user_ID' => $user_ID,
		);

		$this->db->where('review_ID', $review_ID);
		$this->db->update('review', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function delete_review($id){
		$this->db->delete('review', array('review_ID' => $id));
	}
}