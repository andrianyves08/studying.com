<?php
	class Qaa_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function get_qaas($id = FALSE){
    	$this->db->select('qaa_mastersheet.*, qaa_mastersheet.id as qaa_ID, users.first_name, users.last_name');
		$this->db->join('users', 'qaa_mastersheet.user_ID = users.id');
		$this->db->order_by('qaa_mastersheet.question', 'ASC');
		if($id === FALSE){
			$query = $this->db->get('qaa_mastersheet');
			return $query->result_array();
		}
		$query = $this->db->get_where('qaa_mastersheet', array('qaa_mastersheet.id' => $id));
		return $query->row_array();
	}

	public function get_qaas_category($qaa_ID){
    	$this->db->select('category.name, category.id');
		$this->db->join('qaa_mastersheet', 'qaa_mastersheet.id = qaa_to_category.qaa_ID');
		$this->db->join('category', 'qaa_to_category.category_ID = category.id');
		$this->db->where('qaa_to_category.qaa_ID', $qaa_ID);

		$query = $this->db->get('qaa_to_category');
		return $query->result_array();
	}

	public function get_qaas_by_category($category_ID){
    	$this->db->select('*');
		$this->db->join('qaa_to_category', 'qaa_mastersheet.id = qaa_to_category.qaa_ID');
		$this->db->where('qaa_to_category.category_ID', $category_ID);
		$this->db->order_by('qaa_mastersheet.question', 'ASC');

		$query = $this->db->get('qaa_mastersheet');
		return $query->result_array();
	}

	public function search_qaas($search, $limit, $start){
    	$this->db->select('*');
		$this->db->like('question', $search);
		if(!empty($limit)){
			$this->db->limit($limit, $start);
		}
    	$this->db->order_by('CHAR_LENGTH(question)', 'ASC');
    	
    	$query = $this->db->get('qaa_mastersheet');
		return $query->result_array();
    }

	public function create_qaa($category, $question, $answer, $user_ID){
		$this->db->trans_begin();
		$data = array(
			'question' => $question,
			'slug' => strtolower(url_title($question)),
			'answer' => $answer,
			'user_ID' => $user_ID
		);
		$this->db->insert('qaa_mastersheet', $data);
		$qaa_ID = $this->db->insert_id();
		$this->add_qaa_to_category($qaa_ID, $category);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function add_qaa_to_category($qaa_ID, $category_ID){
		$this->db->trans_begin();

		for($i=0; $i<count($category_ID); $i++) {
	        $id = $category_ID[$i];
	        $data = array(
	        	'qaa_ID' => $qaa_ID,
				'category_ID' => $id
			);
			$this->db->insert('qaa_to_category', $data);
		}
		
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function update_qaa($qaa_ID, $category, $question, $answer){
		$this->db->trans_begin();
		$this->db->delete('qaa_to_category', array('qaa_ID' => $qaa_ID));

		$data = array(
			'question' => $question,
			'slug' => strtolower(url_title($question)),
			'answer' => $answer
		);
		$this->db->where('id', $qaa_ID);
		$this->db->update('qaa_mastersheet', $data);
		
		$this->add_qaa_to_category($qaa_ID, $category);
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function delete_qaa($qaa_ID){
		$this->db->set('status', '0');
		$this->db->where('id', $qaa_ID);
		$this->db->update('qaa_mastersheet');
	}
}