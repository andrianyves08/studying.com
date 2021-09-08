<?php
	class User_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }
   
   	// to show db error
   	// return $this->db->error();

    function button_press($id, $user_ID){
		$data = array(
			'button_ID' => $id,
			'user_ID' => $user_ID,
		);
		return $this->db->insert('button_press', $data);
	}

    function register($email, $username, $first_name, $last_name, $password, $role, $timezone){
		$this->db->trans_begin();

		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		$data = array(
			'username' => $username,
			'email' => strtolower($email),
			'password' => $hashed_password,
			'first_name' => $first_name,
			'last_name' => $last_name,
			'image' => 'stock.png',
			'level' => 1,
			'exp' => 0,
			'role' => $role,
			'timezone' => $timezone
		);
		$this->db->set('date_created', 'NOW()', FALSE);
		$this->db->insert('users', $data);
		$last_id = $this->db->insert_id();
		$data2 = array(
			'user_ID' => $last_id,
			'group_ID' => '1',
			'status' => '0'
		);
		$this->db->insert('group_member', $data2);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

   	function create_user($email, $first_name, $last_name){
		$this->db->trans_begin();
		$username = str_replace(' ', '', $first_name).str_replace(' ', '', $last_name).date("h-i-s");

		$hashed_password = password_hash('studying', PASSWORD_DEFAULT);
		$data = array(
			'username' => $username,
			'email' => strtolower($email),
			'password' => $hashed_password,
			'first_name' => $first_name,
			'last_name' => $last_name,
			'image' => 'stock.png',
			'level' => 1,
			'exp' => 0,
			'date_created' => date('Y-m-d H:i:s'),
			'role' => '0'
		);
		$this->db->insert('users', $data);
		$last_id = $this->db->insert_id();
		$data2 = array(
			'user_ID' => $last_id,
			'group_ID' => '1',
			'status' => '1'
		);
		$this->db->insert('group_member', $data2);

		$numberteam = count($this->input->post('course'));
	    for($i=0; $i<$numberteam; $i++) {
	    	if(trim($this->input->post('course')[$i] != '')) {
		        $program = $this->input->post('course')[$i];
		    	$data1 = array(
					'user_ID' => $last_id,
					'course_ID' => $program,
					'status' => '1'
				);
				$this->db->set('date_enrolled', 'NOW()', FALSE);
				$this->db->insert('purchase', $data1);
	      	}
	    }

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

    function approve_as_instructor($user_ID){
		$this->db->trans_begin();
		$this->load->model('notification_model', 'notify');

		$this->notify->create_notification(5, 12, 0, $user_ID, 0);

		$this->db->set('status', '1');
		$this->db->where('user_ID', $user_ID);
		$this->db->update('instructor_detail');

		$this->db->set('role', '1');
		$this->db->where('id', $user_ID);
		$this->db->update('users');

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	function deny_as_instructor($user_ID){
		$this->db->trans_begin();
		$this->load->model('notification_model', 'notify');

		$this->notify->create_notification(5, 13, 0, $user_ID, 0);

		$this->db->set('status', '2');
		$this->db->where('user_ID', $user_ID);
		$this->db->update('instructor_detail');
		
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	function request_as_instructor($description, $experience, $user_ID, $status){
		$this->db->trans_begin();

		$data = array(
			'user_ID' => $user_ID,
			'course_description' => $description,
			'experience' => $experience,
			'status' => $status
		);
		$this->db->set('date_created', 'NOW()', FALSE);
		$this->db->replace('instructor_detail', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	function get_request_as_instructor($status, $user_ID = FALSE){
		$this->db->select('instructor_detail.*, users.first_name, users.last_name, users.role');
		$this->db->join('users', 'users.id = instructor_detail.user_ID');
		$this->db->order_by('instructor_detail.date_created', 'ASC');

		if($status != NULL){
			$this->db->where('instructor_detail.status', $status);
		}
		
		if($user_ID === FALSE){
			$query = $this->db->get('instructor_detail');
			return $query->result_array();
		}
		
		$query = $this->db->get_where('instructor_detail', array('user_ID' => $user_ID));
		return $query->row_array();
	}

    function verify($email, $verification_code){
		$this->db->where('email', strtolower($email));
		$this->db->order_by('timestamp', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('users_verify_email');

		$result = $query->row_array();
		if(!empty($result) && password_verify($verification_code, $result['verification_code'])){
			return true;
		} else {
			return false;
		}
	}

	function create_verification($email, $verification_code){
		$hashed_verifcation = password_hash($verification_code, PASSWORD_DEFAULT);
    	$data = array(
			'email' => strtolower($email),
			'verification_code' => $hashed_verifcation
		);
		$this->db->insert('users_verify_email', $data);
	}

	public function login($email, $password){
		$this->db->where('email', strtolower($email));
		$query = $this->db->get('users');
		$result = $query->row_array();
		if(!empty($result) && password_verify($password, $result['password'])){
			$this->db->set('last_login', 'NOW()', FALSE);
			$this->db->set('login_status', '1');
			$this->db->where('email', strtolower($email));
			$this->db->update('users');
			return $query->row_array();
		} else {
			return false;
		}
	}

	public function get_rankings(){
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('level');
		return $query->result_array();
	}

	public function get_levels($level = FALSE){
		$this->db->join('level', 'level.id = level_exp.name');
		if($level === FALSE){
			$query = $this->db->get('level_exp');
			return $query->result_array();
		}
		$query = $this->db->get_where('level_exp', array('level' => $level));
		return $query->row_array();
	}

	public function logout($email){
		$this->db->set('login_status', '0');
		$this->db->where('email', strtolower($email));
		$this->db->update('users');
	}

	public function get_users($email = FALSE){
		$this->db->order_by('first_name', 'ASC');
		if($email === FALSE){
			$query = $this->db->get('users');
			return $query->result_array();
		}
		if(is_numeric($email)){
			$query = $this->db->get_where('users', array('id' => $email));
		} else {
			$query = $this->db->get_where('users', array('username' => $email));
		}
		return $query->row_array();
	}

	public function search_user($value, $limit, $start){
		$this->db->select('first_name, last_name, username, image, level, date_created');
		$where = "CONCAT(first_name,' ', last_name) LIKE '%$value%'";
		$this->db->where($where);
		if(!empty($limit)){
			$this->db->limit($limit, $start);
		}
		$this->db->order_by('first_name', 'ASC');
    	$query = $this->db->get('users');
		return $query->result_array();
	}

	function next_level($level){
		$nextlevel = $level+'1';
		$this->db->select('*, level_exp.exp as next_exp');
		$this->db->join('level', 'level.id = level_exp.name');
		$this->db->where('level_exp.level', $nextlevel);
		$query = $this->db->get('level_exp');
		return $query->row_array();
	}

	function rankings($limit = FALSE){
		$this->db->select('users.id, users.exp, users.first_name, users.last_name, users.level, level.name, level.image');
		$this->db->join('level_exp', 'users.level = level_exp.level');
		$this->db->join('level', 'level.id = level_exp.name');
		$this->db->where('users.status', '1');
		$this->db->order_by('users.level', 'DESC');
		if($limit != NULL){
			$this->db->limit(10);
		}

		$query = $this->db->get('users');
		return $query->result_array();
	}

	function change_email($user_ID, $new_email){
		$this->db->trans_begin();

		$this->db->set('email', strtolower($new_email));
		$this->db->where('id', $user_ID);
		$this->db->update('users');

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	function change_password($user_ID, $new_password){
	//	$this->db->trans_begin();

		$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
		$this->db->set('password', $hashed_password);
		$this->db->where('id', $user_ID);
		$this->db->update('users');

		// if ($this->db->trans_status() === FALSE){
		//     $this->db->trans_rollback();
		//     return false;
		// } else{
		//     $this->db->trans_commit();
		//     return true;
		// }

		return $this->db->error(); 
	}

	function update_profile($username, $first_name, $last_name, $about_me, $user_ID){
		$this->db->trans_begin();

		$data = array(
			'username' => $username,
			'first_name' => $first_name,
			'last_name' => $last_name,
			'about_me' => $about_me
		);

		$this->db->where('id', $user_ID);
		$this->db->update('users', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	function update_photo($image, $user_ID){
		$this->db->trans_begin();	

		$this->db->set('image', $image);
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


	function change_status($user_ID, $status){
		$this->db->trans_begin();

		$this->db->set('status', $status);
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

	function level_up($user_id, $exp){
		$this->db->trans_begin();
		$this->db->select('*');
		$this->db->where('exp <=', $exp);
		$this->db->order_by('exp', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('level_exp');
		$row2 = $query->row_array();
		$this->db->set('level', $row2['level']);
		$this->db->where('id', $user_id);
		$this->db->update('users');

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	function gain_exp($user_ID, $exp){
		$this->db->trans_begin();

		$this->db->set('exp', 'exp+'.$exp.'', FALSE);
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

    function accept_reward($user_ID, $exp){
		$this->db->trans_begin();
		$this->db->set('timestamp', 'NOW()', FALSE);
		$this->db->set('streak', 'streak+1', FALSE);
		$this->db->set('days', 'days+1', FALSE);
		$this->db->where('user_ID', $user_ID);
		$this->db->update('users_daily_login');

		$this->gain_exp($user_ID, $exp);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

    function daily_logins($user_ID = FALSE){
    	if($user_ID === FALSE){
    		$this->db->select('users_daily_login.*, users.first_name, users.last_name');
			$this->db->join('users', 'users.id = users_daily_login.user_ID');
			$query = $this->db->get('users_daily_login');
			return $query->result_array();
		}
		$this->db->where('user_ID', $user_ID);
		$query = $this->db->get('users_daily_login');
		return $query->row_array();
	}

	function start_daily_login_reward($user_ID){
		$timestamp = strtotime('today 9pm');
		$time = date("Y-m-d H:i:s", $timestamp);
		$data = array(
			'user_ID' => $user_ID,
	        'days' => '0'
		);
		$this->db->set('timestamp', 'NOW() - INTERVAL 1 DAY', FALSE);
        $this->db->set('date_started', $time);
		$this->db->insert('users_daily_login', $data);
	}

	function follow($following, $follower){
		$this->db->trans_begin();
		$this->load->model('notification_model', 'notify');

    	$data = array(
    		'following' => $following,
			'follower' => $follower
		);

		$this->db->insert('users_follow', $data);
		$users_follow_ID = $this->db->insert_id();

		$this->notify->create_notification(4, 11, $users_follow_ID, $following, $follower);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else{
		    $this->db->trans_commit();
		    return true;
		}
	}

	function unfollow($following, $follower){
		$this->db->delete('users_follow', array('following' => $following, 'follower' => $follower));
		$this->db->delete('notification_to_user',  array(
        	'type' => 4,
        	'notification_name_id' => 11,
			'notified' => $following,
			'notifier' => $follower,
		));
	}

	function is_following($following, $follower){
		$this->db->select('*');
		$query = $this->db->get_where('users_follow', array('following' => $following, 'follower' => $follower));

		if ($query->num_rows()) {
	        return true;
	    } else {
	        return false;
	    }
	}

	function count_posts($user_ID){
		$this->db->select('count(*) as total');
		$query = $this->db->get_where('post', array('user_ID' => $user_ID, 'status' => '1'));

		return $query->row_array();
	}

	function count_followers($user_ID){
		$this->db->select('count(*) as total');
		$query = $this->db->get_where('users_follow', array('following' => $user_ID));

		return $query->row_array();
	}

	function count_following($user_ID){
		$this->db->select('count(*) as total');
		$query = $this->db->get_where('users_follow', array('follower' => $user_ID));

		return $query->row_array();
	}

	function get_followers($user_ID){
		$this->db->select('users.first_name, users.last_name, users.image, users.username');
		$this->db->join('users', 'users.id = users_follow.follower');
		$query = $this->db->get_where('users_follow', array('following' => $user_ID));

		return $query->result_array();
	}

	function get_following($user_ID){
		$this->db->select('users.first_name, users.last_name, users.image, users.username');
		$this->db->join('users', 'users.id = users_follow.following');
		$query = $this->db->get_where('users_follow', array('follower' => $user_ID));

		return $query->result_array();
	}

	function insert_timezone($timezone, $user_ID){
		$this->db->trans_begin();

		$this->db->set('timezone', $timezone);
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

	function update_user_status($user_ID){
    	$this->db->set('last_login', 'NOW()', FALSE);
		$this->db->where('id', $user_ID);
		return $this->db->update('users');
	}

	function reset_login_streak($user_ID){
		$this->db->set('timestamp', 'NOW() - INTERVAL 1 DAY', FALSE);
        $this->db->set('days', 0);
		$this->db->where('user_ID', $user_ID);
		return $this->db->update('users_daily_login');
	}
}