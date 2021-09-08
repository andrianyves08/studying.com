<?php
	class Notification_model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    // Notification name
    // 1 approve post
    // 2 deny post
    // 3 liked your post
    // 4 tagged you in a post
    // 5 commented on your post
    // 6 mentions you in a comment
    // 7 replied to your comment
    // 8 liked your comment
    // 9 liked your reply
    // 10 mentions in a chat
    // 11 follows you
	public function get_notifications($user_ID){
		$this->db->select('notification_to_user.*, users.first_name, users.last_name, users.image, users.username');
    	$this->db->join('users', 'users.id = notification_to_user.notifier', 'left');
		$this->db->where('notification_to_user.notified', $user_ID);
		$this->db->order_by('notification_to_user.timestamp', 'DESC');
		$query = $this->db->get('notification_to_user');
		return $query->result_array();
	}

	public function create_notification($type, $notification_name_id, $id, $notified, $user_ID){
		$this->db->trans_begin();

        $data = array(
        	'type' => $type,
        	'notification_name_id' => $notification_name_id,
        	'id' => $id,
			'notified' => $notified,
			'notifier' => $user_ID,
		);
		$this->db->insert('notification_to_user', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function tag_users($notification_name, $type, $id, $tagged_users, $user_ID){
		$this->db->trans_begin();
		$this->load->model('user_model', 'users');

        $total = count($tagged_users);
		for($i=0; $i<$total; $i++) {
			if(trim($tagged_users[$i] != '')) {
		        $tagged_id = $tagged_users[$i];
		        $user = $this->users->get_users($tagged_id);

		        $data1 = array(
		        	'type' => $type,
		        	'notification_name_id' => $notification_name,
		        	'id' => $id,
					'notified' => $user['id'],
					'notifier' => $user_ID,
				);
				$this->db->insert('notification_to_user', $data1);
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

	public function seen_notification($user_ID){
		$this->db->trans_begin();

		$this->db->set('status', '1');
		$this->db->where('notified', $user_ID);
		$this->db->update('notification_to_user');

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function delete_notification($post_ID, $notification_name_id){
		$this->db->delete('notification_to_user', array('id' => $post_ID, 'notification_name_id' => $notification_name_id));
	}
}