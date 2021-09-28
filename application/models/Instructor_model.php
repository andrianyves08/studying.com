<?php
	class Instructor_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function get_my_students($course_ID, $instructor_ID){
        $this->db->select('purchase_status.name as purchase_status_name, purchase.status as purchase_status, purchase.id as purchase_ID, purchase.date_enrolled, users.status as user_status, users.first_name, users.last_name, users.last_login, users.id as user_ID, course.title');
        $this->db->join('users', 'users.id = purchase.user_ID');
        $this->db->join('course', 'course.id = purchase.course_ID');
        $this->db->join('purchase_status', 'purchase_status.id = purchase.status');
        $this->db->order_by('purchase.date_enrolled', 'DESC');
        if($course_ID != NULL){
            $this->db->where('course.id', $course_ID);
        }

        $this->db->group_by('purchase.user_ID');
        $this->db->where('course.user_ID', $instructor_ID);
        $query = $this->db->get('purchase');
        return $query->result_array();
    }

    public function get_announcement($instructor_ID){
        $query = $this->db->get_where('instructor_detail', array('user_ID' => $instructor_ID));
        return $query->row_array();
    }

    public function get_schedule($instructor_ID){
        $query = $this->db->get_where('instructor_schedule', array('user_ID' => $instructor_ID));
        return $query->result_array();
    }

    public function create_schedule($day, $time, $timezone, $note, $user_ID){
        $this->db->trans_begin();

        $data = array(
            'user_ID' => $user_ID,
            'day' => $day,
            'time' => $time,
            'timezone' => $timezone,
            'note' => $note,
        );
        $this->db->insert('instructor_schedule', $data);

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function delete_schedule($id){
        return $this->db->delete('instructor_schedule', array('id' => $id));
    }

    public function update_announcement($user_ID, $announcement){
        $this->db->set('announcement', $announcement);
        $this->db->where('user_ID', $user_ID);
        return $this->db->update('instructor_detail');
    }
}