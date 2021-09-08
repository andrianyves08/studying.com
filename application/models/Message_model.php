<?php
	class Message_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function get_message($message_ID){
		$this->db->select('message.*, users.first_name, users.last_name');
		$this->db->join('users', 'message.from_ID = users.id');
		$this->db->where('message.id', $message_ID);
		$query = $this->db->get('message');
		return $query->row_array();
	}

	public function get_messages($limit, $start, $user_ID, $to_ID){
		$this->db->select('message.*, message.id as message_ID, users.image, users.first_name, users.last_name, users.username');
		$this->db->join('users', 'message.from_ID = users.id');
		$where = "(from_ID = '$to_ID' AND to_ID = '$user_ID') OR (from_ID = '$user_ID' AND to_ID = '$to_ID')";
		$this->db->where($where);
		$this->db->order_by('message.timestamp', 'DESC');
		if(!empty($limit)){
			$this->db->limit($limit, $start);
		}
		$query = $this->db->get('message');
		return $query->result_array();
	}

	public function get_group_message($message_ID){
		$this->db->select('group_message.*, users.first_name, users.last_name, group_name.name as group_name');
		$this->db->join('users', 'group_message.sender_ID = users.id');
		$this->db->join('group_name', 'group_name.id = group_message.group_ID');
		$this->db->where('group_message.id', $message_ID);
		$query = $this->db->get('group_message');
		return $query->row_array();
	}

	public function get_group_messages($limit, $start, $user_ID, $group_ID){
		$this->db->select('users.username, users.image, users.first_name, users.last_name, group_message.sender_ID as from_ID, group_message.group_ID as to_ID, group_message.message, group_message.status, group_message.timestamp, group_message.id as message_ID, group_message.parent_message');
		$this->db->join('users', 'group_message.sender_ID = users.id');
		$where = "(group_ID = '$group_ID' AND sender_ID = '$user_ID') OR (group_ID = '$group_ID' AND sender_ID != '$user_ID')";
		$this->db->where($where);
		$this->db->order_by('group_message.timestamp', 'DESC');
		if(!empty($limit)){
			$this->db->limit($limit, $start);
		}

		$query = $this->db->get('group_message');
		return $query->result_array();
	}

	public function all_users(){
		$this->db->select('id, first_name, last_name, image');
		$this->db->where('status', '1');
		$this->db->order_by('first_name', 'ASC');
		$query = $this->db->get('users');

		return $query->result_array();
	}

	public function get_user_header($user_ID){
		$this->db->select('users.id as user_ID, users.first_name, users.last_name, users.username, users.level, users.image, users.login_status, users.last_login, max(message.timestamp) as timestamp');
		$this->db->join('users', 'message.to_ID = users.id or message.from_ID = users.id');
		$this->db->where('message.from_ID', $user_ID);
		$this->db->or_where('message.to_ID', $user_ID);
		$this->db->group_by("users.id");
		$this->db->order_by('message.timestamp', 'DESC');
		$query = $this->db->get('message');
		return $query->result_array();
	}

	public function get_user_group($user_ID){
		$this->db->select('group_name.*, max(group_message.timestamp) as timestamp');
		$this->db->join('group_member', 'group_member.group_ID = group_name.id', 'left');
		$this->db->join('group_message', 'group_message.group_ID = group_name.id', 'left');
		$this->db->where('group_member.user_ID', $user_ID); 
		$this->db->group_by("group_name.id");
		$this->db->order_by('group_message.timestamp', 'ASC');

		$query = $this->db->get('group_name');
		return $query->result_array();
	}

	public function get_group($group_ID = FALSE){
		if($group_ID === FALSE){
			$query = $this->db->get('group_name');;
			return $query->result_array();
		}

		$query = $this->db->get_where('group_name', array('id' => $group_ID));
		return $query->row_array();
	}

	public function get_members($group_id){
		$this->db->select('group_member.*, users.first_name, users.last_name, users.image, users.username');
		$this->db->join('users', 'group_member.user_ID = users.id');
		$this->db->where('group_member.group_ID', $group_id); 
		$this->db->order_by('users.first_name', 'ASC');

		$query = $this->db->get('group_member');
		return $query->result_array();
	}

	public function send_message($user_ID, $to_ID, $message, $message_ID){
		$this->db->trans_begin();
		$data = array(
			'to_ID' => $to_ID,
			'from_ID' => $user_ID,
			'message' => $message,
			'parent_message' => $message_ID,
			'status' => '0'
		);

		$this->db->set('exp', 'exp+1', FALSE);
		$this->db->where('id', $user_ID);
		$this->db->update('users');

		$this->db->insert('message', $data);
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function send_group_message($user_ID, $group_ID, $message, $message_ID, $tagged_users){
		$this->db->trans_begin();
		$this->load->model('user_model', 'users');
		$this->load->model('notification_model', 'notify');

		$this->db->set('exp', 'exp+1', FALSE);
		$this->db->where('id', $user_ID);
		$this->db->update('users');
		$data = array(
			'group_ID' => $group_ID,
			'sender_ID' => $user_ID,
			'parent_message' => $message_ID,
			'message' => $message,
			'status' => '0'
		);
		$this->db->insert('group_message', $data);
		$message_id = $this->db->insert_id();

		if(!empty($tagged_users)){
			$this->notify->tag_users(10, 3, $message_id, $tagged_users, $user_ID);
		}

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function message_seen($user_ID, $to_ID){
		$this->db->set('status', '1');
		$this->db->where('to_ID', $user_ID);
		$this->db->where('from_ID', $to_ID);
		$this->db->where('status', '0');

		$this->db->update('message');

		return true;
	}

	public function get_last_message($user_ID, $to_ID, $type){
		if($type == 1){
			$this->db->select('*');
			$this->db->where('to_ID', $user_ID);
			$this->db->where('from_ID', $to_ID);
			$this->db->order_by('timestamp', 'DESC');
			$this->db->limit(1);
			$query = $this->db->get('message');
		} else {
			$this->db->select('*');
			$this->db->where('sender_ID', $user_ID);
			$this->db->where('group_ID', $to_ID);
			$this->db->order_by('timestamp', 'DESC');
			$this->db->limit(1);
			$query = $this->db->get('group_message');
		}
		return $query->row_array();
	}

	public function message_not_seen($user_ID, $to_ID = FALSE){
		$this->db->select('*');
		$this->db->where('to_ID', $user_ID);
		$this->db->where('status', '0');
		$this->db->order_by('timestamp', 'DESC');
		if($to_ID === FALSE){
			$query = $this->db->get('message');
			return $query->result_array();
		}
		$this->db->where('from_ID', $to_ID);
		$query = $this->db->get('message');

		return $query->result_array();
	}

	public function delete_message($id){
		$this->db->set('status', '2');
		$this->db->where('id', $id);

		$this->db->update('message');
	}

	public function delete_group_message($id){
		$this->db->set('status', '2');
		$this->db->where('id', $id);

		$this->db->update('group_message');
	}

	public function delete_member($id){
		$this->db->delete('group_member', array('id' => $id));
	}

	public function member_status($status, $id){
		$this->db->set('status', $status);
		$this->db->where('id', $id);

		$this->db->update('group_member');
	}

	public function get_member_status($user_ID){
		$this->db->select('group_member.status as status');
		$this->db->join('users', 'group_member.user_ID = users.id');
		$this->db->where('group_member.user_ID', $user_ID); 
		$query = $this->db->get('group_member');
		return $query->row_array();
	}

	public function create_group($user_ID, $name, $members){
		$this->db->trans_begin();

		$data = array(
			'admin_ID' => $user_ID,
			'name' => $name
		);

		$this->db->insert('group_name', $data);
		$groupID = $this->db->insert_id();

		$data3 = array(
			'user_ID' => $user_ID,
			'group_ID' => $groupID
		);

		$this->db->insert('group_member', $data3);

		if(!empty($members)){
			$sql = $this->add_members($groupID, $members);
			if(!$sql){
				return false;
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

	public function add_members($groupID, $members){
		$this->db->trans_begin();

		$total_content = count($members);
		for($i=0; $i<$total_content; $i++) {
			if(trim($members[$i] != '')) {
		        $member = $members[$i];

		        $data2 = array(
					'user_ID' => $member,
					'group_ID' => $groupID
				);
		    	
				$this->db->insert('group_member', $data2);
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

	public function add_member($id, $group_ID){
		$data = array(
			'user_ID' => $id,
			'group_ID' => $group_ID
		);
		$this->db->insert('group_member', $data);
	}

	public function leave_group($group_ID, $user_ID){
		$this->db->delete('group_member', array('group_ID' => $group_ID, 'user_ID' => $user_ID,));
	}
}