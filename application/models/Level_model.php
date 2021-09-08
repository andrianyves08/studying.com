<?php
	class Level_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }
   
   	public function get_level($level = FALSE){
		$this->db->join('level', 'level.id = level_exp.name');
		if($level === FALSE){
			$query = $this->db->get('level_exp');
			return $query->result_array();
		}
		$query = $this->db->get_where('level_exp', array('level' => $level));
		return $query->row_array();
	}
}