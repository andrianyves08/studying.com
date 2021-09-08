<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video extends CI_Controller {

	function track_progress(){
		$create = $this->video_model->track_progress($this->input->post('duration'), $this->input->post('progress'), $this->session->userdata('user_id'), $this->input->post('content'), $this->input->post('src'));
		echo json_encode($create);
	}

	function finished_watched(){
		$create = $this->video_model->finished_watched($this->session->userdata('user_id'), $this->input->post('content'), $this->input->post('duration'));
		if($create != FALSE){
			$data = array(
				'status' => true,
				'exp' => $create
			);
		} else {
			$data = array(
				'status' => false
			);
		}
		echo json_encode($data);
	}

	function get_progress(){
		$create = $this->video_model->get_progress($this->session->userdata('user_id'), $this->input->post('content_ID'));
		if(!empty($create)){
			$data = array(
				'error' => false,
				'status' => $create['status'],
				'progress' => $create['progress'],
			);
		} else {
			$data = array(
				'error' => true,
			);
		}
		echo json_encode($data);
	}

	function last_watched(){
		$create = $this->video_model->last_watched($this->session->userdata('user_id'));
		echo json_encode($create);
	}

	function all_videos(){
		$data = $this->video_model->get_videos();
		echo json_encode($data);
	}

	function get_all_progress(){
		$create = $this->video_model->get_progress($this->session->userdata('user_id'));
		echo json_encode($create);
	}

	function get_course_progress() {
		$user_progress = $this->video_model->users_videos_watched(NULL, NULL, $this->session->userdata('user_id'));
		$data = $this->course_model->count_contents(NULL, NULL);
		$percentage = ($user_progress['total'] / $data['content']) * 100;
		$data = array(
			'percentage_width' => $percentage,
			'percentage' => round($percentage),
			'total' => $user_progress['total']
		);
		echo json_encode($data);
	}

	function get_module_progress() {
		$total = array();
		$users_module = $this->purchase_model->users_module($this->input->post('course_slug'), $this->session->userdata('user_id'));
		
		foreach ($users_module as $row) {
			$sql = $this->video_model->users_videos_watched($row['module_ID'], NULL, $this->session->userdata('user_id'));
			$sql2 = $this->course_model->count_contents($row['module_ID'], NULL);
			if(empty($sql2['content'])){
				$percentage = 0;
			} else {
				$percentage = ($sql['total'] / $sql2['content']) * 100;
			}
			
			$total[] = [
				'module_ID' => $row['module_ID'],
				'percentage_width' => $percentage,
				'percentage' => round($percentage),
				'total' => $sql['total']
			];
		}
		echo json_encode($total);
	}

	function get_section_progress() {
		$total = array();
		$user_purchase = $this->purchase_model->users_section($this->input->post('course_slug'), $this->session->userdata('user_id'));
		foreach ($user_purchase as $row) {
			$sql = $this->video_model->users_videos_watched($row['module_ID'], $row['section_ID'], $this->session->userdata('user_id'));
			$sql2 = $this->course_model->count_contents($row['module_ID'], $row['section_ID']);
			if($sql['total'] != 0){
				$percentage = ($sql['total'] / $sql2['content']) * 100;
				$total[] = [
					'section_ID' => $row['section_ID'],
					'percentage_width' => $percentage,
					'percentage' => round($percentage),
					'total' => $sql['total']
				];
			}
		}
		echo json_encode($total);
	}
}