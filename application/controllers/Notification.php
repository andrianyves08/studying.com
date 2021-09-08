<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller {

	function get_notifications() {
		$sql = $this->notification_model->get_notifications($this->session->userdata('user_id'));

		$data = array();
		// approve post
		// commented
		// liked
		// replied
		// Support
		// Denied post
		// Tagge in a post
		foreach($sql as $row) {
			$post = '';
			$id = '';
			if($row['type'] == 1){
				$sql_2 = $this->post_model->get_post($row['id']);
				$id = $row['id'];
				if(!$sql_2){
					$post = 'Post has been deleted!';
				} else {
					$post = $sql_2['post'];
				}
			} elseif($row['type'] == 2){
				$sql_2 = $this->post_model->get_comment($row['id']);
				$id = $sql_2['post_ID'];
				if(!$sql_2){
					$post = 'Comment has been deleted!';
				} else {
					$post = str_replace(array('<p>', '</p>'), array('"', '"'), $sql_2['comment']);
				}
			} elseif($row['type'] == 3){
				$sql_2 = $this->message_model->get_group_message($row['id']);
				if(!$sql_2){
					$post = 'Message has been deleted!';
				} else {
					$post = $data['message'];
				}
			}
			
			if($row['notification_name_id'] == 1){
				$notification = 'Your post has been approved!';
			} elseif ($row['notification_name_id'] == 2) {
				$notification = 'Your post has been denied!';
			} elseif($row['notification_name_id'] == 3){
				$notification = ucwords($row['first_name']).' '.ucwords($row['last_name']).' liked your post.';
			} elseif($row['notification_name_id'] == 4) {
				$notification = ucwords($row['first_name']).' '.ucwords($row['last_name']).' tagged you n a post.';
			} elseif($row['notification_name_id'] == 5){
				$notification = ucwords($row['first_name']).' '.ucwords($row['last_name']).' commented on your post.';
			}  elseif($row['notification_name_id'] == 6) {
				$notification = ucwords($row['first_name']).' '.ucwords($row['last_name']).' mentions you in a comment';
			} elseif($row['notification_name_id'] == 7) {
				$notification = ucwords($row['first_name']).' '.ucwords($row['last_name']).' replied on your comment.';
			} elseif($row['notification_name_id'] == 8) {
				$notification = ucwords($row['first_name']).' '.ucwords($row['last_name']).' liked your comment';
			} elseif($row['notification_name_id'] == 9) {
				$notification = ucwords($row['first_name']).' '.ucwords($row['last_name']).' liked your reply';
			} elseif($row['notification_name_id'] == 10) {
				$notification = ucwords($row['first_name']).' '.ucwords($row['last_name']).' mentions you in a group chat';
			} elseif($row['notification_name_id'] == 11) {
				$notification = ucwords($row['first_name']).' '.ucwords($row['last_name']).' follows you';
			}

			$data[] = [
				'id' => $id,
				'notification_name' => $notification,
				'timestamp' => $this->time_elapsed_string($row['timestamp']),
				'user_ID' => $row['notifier'],
				'username' => $this->session->userdata('username'),
				'image' => $row['image'],
				'seen' => $row['status'],
				'post' => $post
			];			
		}
		return $data;
	}

	function seen() {
		$data = $this->notification_model->seen_notification($this->session->userdata('user_id'));
		echo json_encode($data);
	}

	function time_elapsed_string($time, $full = false) {
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
}