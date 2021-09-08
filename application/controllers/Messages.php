<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messages extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('upload');
	}

	function change_timezone($time) {
		$data = $this->user_model->get_users($this->session->userdata('user_id'));

		$changetime = new DateTime($time, new DateTimeZone('UTC'));
	    $changetime->setTimezone(new DateTimeZone($data['timezone']));
	    return $changetime->format('M j, Y h:i A');
	}

	function changetimefromUTC($time, $full = FALSE) {
		$data = $this->user_model->get_users($this->session->userdata('user_id'));

		$now = new DateTime;
	    $ago = new DateTime($time, new DateTimeZone('UTC'));
	    $now->setTimezone(new DateTimeZone($data['timezone']));
	    $ago->setTimezone(new DateTimeZone($data['timezone']));

	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'year',
	        'm' => 'month',
	        'w' => 'week',
	        'd' => 'day',
	        'h' => 'hour',
	        'i' => 'minute',
	        's' => 'second',
	    );
	    foreach ($string as $k => &$v) {
	      if ($diff->$k) {
	        $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	      } else {
	        unset($string[$k]);
	      }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . ' ago' : 'just now';
	}

	public function convert($str, $target='_blank') {
        if ($target) {
	        $target = ' target="'.$target.'"';
	    } else {
	        $target = '';
	    }
	    // find and replace link
	    $str = preg_replace('@((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.~]*(\?\S+)?)?)*)@', '<a href="$1" '.$target.'>$1</a>', $str);
	    // add "http://" if not set
	    $str = preg_replace('/<a\s[^>]*href\s*=\s*"((?!https?:\/\/)[^"]*)"[^>]*>/i', '<a href="http://$1" '.$target.'>', $str);
	    return $str;
    }

    function get_tagged_users($str, $startDelimiter, $endDelimiter){
		$contents = array();
		$startDelimiterLength = strlen($startDelimiter);
		$endDelimiterLength = strlen($endDelimiter);
		$startFrom = $contentStart = $contentEnd = 0;
		while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
		    $contentStart += $startDelimiterLength;
		    $contentEnd = strpos($str, $endDelimiter, $contentStart);
			    if (false === $contentEnd) {
			      break;
			    }
		    $contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
		    $startFrom = $contentEnd + $endDelimiterLength;
		}

		return $contents;
	}

	function get_users_status() {
		$data = $this->message_model->get_user_header($this->session->userdata('user_id'));
		$total = array();

		foreach ($data as $row) {
			$messages = $this->message_model->message_not_seen($this->session->userdata('user_id'), $row['user_ID']);
			$total[] = [
				'user_ID' => $row['user_ID'],
				'count' => count($messages),
				'snippet' => !empty($messages) ?substr(strip_tags($messages[0]['message']),0,50)."..." : false,
				'status' => $this->change_timezone($row['last_login']),
				'last_login' => $this->changetimefromUTC($row['last_login'])
			];
		}
		echo json_encode($total);
	}

	function get_message_header() {
		$header_users = $this->message_model->get_user_header($this->session->userdata('user_id'));
		$header_group = $this->message_model->get_user_group($this->session->userdata('user_id'));
		$i=1;
		
		$message_header = array();
		foreach ($header_users as $row) {
			if($row['user_ID'] != $this->session->userdata('user_id')){
				$image_level = $this->level_model->get_level($row['level']);
				$message_header[] = array(
					'id' => $i,
					'data_id' => $row['user_ID'],
					'name' => ucwords($row['first_name']).' '.ucwords($row['last_name']),
					'first_name' => ucwords($row['first_name']),
					'last_name' => ucwords($row['last_name']),
					'username' => $row['username'],
					'image' => base_url().'assets/img/users/'.$row['image'],
					'timestamp' => $this->changetimefromUTC($row['timestamp']),
					'level' => $row['level'],
					'level_image' => $image_level['image'],
					'type' => '1',
				);
			}
			$i++;
		}

		foreach ($header_group as $row) {
			$message_header[] = array(
				'id' => $i,
				'data_id' => $row['id'],
				'name' => ucwords($row['name']),
				'image' => base_url().'assets/img/logo-1.png',
				'timestamp' => $this->changetimefromUTC($row['timestamp']),
				'username' => FALSE,
				'type' => '2',
			);
			$i++;
		}

		usort($message_header, function ($item1, $item2) {
			$t1 = strtotime($item1['timestamp']);
		    $t2 = strtotime($item2['timestamp']);
		    return $t2 - $t1;
	    });

		echo json_encode($message_header);
	}

	function get_messages() {
		if($this->input->post('type') == 1){
			$seen = $this->message_model->message_seen($this->session->userdata('user_id'), $this->input->post('id'));
			$message = $this->message_model->get_messages(10, $this->input->post('start'), $this->session->userdata('user_id'), $this->input->post('id'));
		} else {
			$message = $this->message_model->get_group_messages(10, $this->input->post('start'), $this->session->userdata('user_id'), $this->input->post('id'));
		}
		$max = count($message);
		$i = 1;
		$message_content = array();
		foreach(array_reverse($message) as $row){
			if($this->input->post('type') == 1){
				$reply = $this->message_model->get_message($row['parent_message']);
			} else {
				$reply = $this->message_model->get_group_message($row['parent_message']);
			}
			$message_content[] = array(
				'message_ID' => $row['message_ID'],
				'from_ID' => $row['from_ID'],
				'to_ID' => $row['to_ID'],
				'message' => $row['message'],
				'message_status' => $row['status'],
				'timestamp' => $this->changetimefromUTC($row['timestamp']),
				'name' => ucwords($row['first_name']).' '.ucwords($row['last_name']),
				'username' => $row['username'],
				'image' => base_url().'assets/img/users/'.$row['image'],
				'parent_message' => $row['parent_message'],
				'max' => count($message),
				'i' => $i,
				'parent_message_content' => !empty($reply) ? $reply['message'] : '',
				'parent_message_sender' => !empty($reply) ? ucwords($reply["first_name"]).' '.ucwords($reply["last_name"]) : '',
				'parent_message_timestamp' => !empty($reply) ? $this->changetimefromUTC($reply['timestamp']) : '',
			);
			$i++;
		}
		echo json_encode($message_content);
	}

	function send_message() {
		$message = $this->convert($this->input->post('message'));
		if($this->input->post('type') == 1){
			$data = $this->message_model->send_message($this->session->userdata('user_id'), $this->input->post('to_ID'), $message, $this->input->post('message_ID'));
		} else {
			$tagged_users_id = $this->get_tagged_users($this->input->post('message'), '<a href="'.base_url().'', '">@');
			$data = $this->message_model->send_group_message($this->session->userdata('user_id'), $this->input->post('to_ID'), $message, $this->input->post('message_ID'), $tagged_users_id);
		}
		
		echo json_encode($data);
	}

	function create_message() {
		$toID = $this->user_model->get_users($this->input->post('user_ID'));
		if(!$toID){
			$data = array(
				'error' => true,
				'message' => 'User does not exist.'
			);
		} else {
			$message = $this->convert($this->input->post('chat_message'));
			$data = $this->message_model->send_message($this->session->userdata('user_id'), $toID['id'], $message, 0);
		}
		echo json_encode($data);
	}

	function delete_message() {
		if($this->input->post('type') == 1){
			$data = $this->message_model->delete_message($this->input->post('message_ID'));
		} else {
			$data = $this->message_model->delete_group_message($this->input->post('message_ID'));
		}
		echo json_encode($data);
	}

	function create_group() {
		$create = $this->message_model->create_group($this->session->userdata('user_id'), $this->input->post('group_name'), $this->input->post('members'));
		if($create){
			$this->session->set_flashdata('success', 'Group Created Successfully');
		} else {
			$this->session->set_flashdata('error', 'Group name already exist.');
		}
		redirect('messages');
	}

	function get_group_members() {
		$members = $this->message_model->get_members($this->input->post('group_ID'));
		$group_owner = $this->message_model->get_group($this->input->post('group_ID'));

		$data = array();
		foreach ($members as $row) {
			$data[] = array(
				'id' => $row['id'],
				'owner' => $group_owner['admin_ID'],
				'username' => $row['username'],
				'fullname' => ucwords($row['first_name']).' '.ucwords($row['last_name']),
				'avatar' => base_url().'assets/img/users/'.$row['image'],
				'status' => $row['status']
			);
		}
		echo json_encode($data);
	}

	function add_member() {
		$new = $this->user_model->get_users($this->input->post('username'));
		$data = $this->message_model->add_member($new['id'], $this->input->post('group_id'));
		echo json_encode($data);;
	}

	function remove_member() {
		$data = $this->message_model->delete_member($this->input->post('member_ID'));
		echo json_encode($data);;
	}

	function mute_member() {
		$data = $this->message_model->member_status($this->input->post('status'), $this->input->post('member_ID'));
		echo json_encode($this->input->post('status'));
	}

	function leave_group() {
		$data = $this->message_model->leave_group($this->input->post('group_ID'), $this->session->userdata('user_id'));
		echo json_encode($data);
	}

}