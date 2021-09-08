<?php
	class Purchase_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }
   
   	public function get_users_course($course_ID, $instructor_ID = FALSE){
    	$this->db->select('purchase_status.name as purchase_status_name, purchase.status as purchase_status, purchase.id as purchase_ID, purchase.date_enrolled, users.status as user_status, users.first_name, users.last_name, users.last_login, users.id as user_ID, course.title');
    	$this->db->join('users', 'users.id = purchase.user_ID');
    	$this->db->join('course', 'course.id = purchase.course_ID');
    	$this->db->join('purchase_status', 'purchase_status.id = purchase.status');
    	$this->db->order_by('purchase.date_enrolled', 'DESC');
    	if($course_ID != NULL){
			$this->db->where('course.id', $course_ID);
		}
    	
    	if($instructor_ID === FALSE){
    		$query = $this->db->get('purchase');
			return $query->result_array();
    	}
    	
    	$this->db->where('course.user_ID', $instructor_ID);
		$query = $this->db->get('purchase');
		return $query->result_array();
	}

	public function add_purchase($user_ID, $course_ID, $status, $comment, $admin_ID, $order_ID){
		$this->db->trans_begin();

	    $data = array(
			'user_ID' => $user_ID,
			'course_ID' => $course_ID,
			'order_ID' => $order_ID,
			'status' => $status
		);

		$this->db->set('date_enrolled', 'NOW()', FALSE);
		$this->db->insert('purchase', $data);
		
		$id = $this->db->insert_id();

		$this->create_purchase_history($id, $status, $comment, $admin_ID);
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function change_status($id, $status, $comment, $admin_ID){
		$this->db->trans_begin();	

		$this->db->set('status', $status);
		$this->db->where('id', $id);
		$this->db->update('purchase');
		$this->create_purchase_history($id, $status, $comment, $admin_ID);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function get_purchase_history($purchase_ID){
		$this->db->select('purchase_history.*, purchase_status.name');
		$this->db->join('purchase_status', 'purchase_status.id = purchase_history.status');
		$this->db->order_by('purchase_history.date_created', 'ASC');
    	$this->db->where('purchase_history.purchase_ID', $purchase_ID);
		$query = $this->db->get('purchase_history');
		return $query->result_array();
	}

	public function create_purchase_history($id, $status, $comment, $admin_ID){
		$this->db->trans_begin();

		$data = array(
			'purchase_ID' => $id,
			'status' => $status,
			'comment' => $comment,
			'admin_ID' => $admin_ID
		);
		$this->db->set('date_created', 'NOW()', FALSE);
		$this->db->insert('purchase_history', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function get_purchase_status($id = FALSE){
		$this->db->order_by('name', 'ASC');
    	if($id === FALSE){
    		$query = $this->db->get('purchase_status');
			return $query->result_array();
    	}
    	
    	$this->db->where('id', $id);
		$query = $this->db->get('purchase_status');
		return $query->row_array();
	}

	public function users_course($user_ID, $status, $course_slug = FALSE){
		$this->db->select('*, purchase_status.name as purchase_status_name, purchase.id as purchase_ID, purchase.status as purchase_status, course.user_ID as instructor_ID, users.first_name, users.last_name');
		$this->db->join('course', 'course.id = purchase.course_ID');
		$this->db->join('users', 'users.id = course.user_ID');
		$this->db->join('purchase_status', 'purchase_status.id = purchase.status');
		$this->db->where('purchase.user_ID', $user_ID);
		if($status != NULL){
    		$this->db->where('course.status', $status);
    	}
		$this->db->order_by('course.title', 'ASC');
		
		if($course_slug === FALSE){
    		$query = $this->db->get('purchase');
			return $query->result_array();
    	}
		
    	$this->db->where('course.slug', $course_slug);
		$query = $this->db->get('purchase');
		return $query->row_array();
	}

	public function users_module($course_slug, $user_ID){
		$this->db->select('course_module.title as title, course_module.slug as module_slug, course_module.id as module_ID, course_module.sort as sort');
		$this->db->join('course', 'course.id = purchase.course_ID');
		$this->db->join('course_module', 'purchase.course_ID = course_module.course_ID');
		$this->db->where('course.slug', $course_slug);
		$this->db->where('purchase.user_ID', $user_ID);
		$this->db->where('course_module.status', '1');
		$this->db->where('course.status', '1');
		$this->db->order_by('course_module.sort', 'ASC');
		$this->db->group_by('course_module.id');
		$query = $this->db->get('purchase');
		return $query->result_array();
	}

	public function users_section($course_slug, $user_ID){
		$this->db->select('course_section.title as section_title, 
			course_module.slug as module_slug, 
			course_module.id as module_ID, 
			course_section.slug as section_slug, 
			course_module.sort as sort,
			course_module.slug as slug,
			course_section.slug as section_slug,
			course_section.id as section_ID
		');
		$this->db->join('course', 'course.id = purchase.course_ID');
		$this->db->join('course_module', 'purchase.course_ID = course_module.course_ID');
		$this->db->join('course_section', 'course_module.id = course_section.module_ID');
		$this->db->where('course.slug', $course_slug);
		$this->db->where('purchase.user_ID', $user_ID);
		$this->db->where('course_module.status', '1');
		$this->db->where('course_section.status', '1');
		$this->db->where('course.status', '1');
		$this->db->order_by('course_section.sort', 'ASC');
		$this->db->group_by('course_section.id');
		$query = $this->db->get('purchase');
		return $query->result_array();
	}
}