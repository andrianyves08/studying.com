<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('upload');
	}

	function change_status() {
		$data = $this->purchase_model->change_status($this->input->post('id'), $this->input->post('status'), $this->input->post('comment'), $this->input->post('comment'), $this->session->userdata('admin_id'));
		echo json_encode($data);
	}

	function add_purchase() {
		$this->form_validation->set_rules('user_ID', 'User', 'required');
		$this->form_validation->set_rules('course_ID', 'Course', 'required');

        if ($this->form_validation->run() === FALSE) {
			$data = array(
				'error' => true,
				'message' => validation_errors()
			);
	    } else {
			$create = $this->purchase_model->add_purchase($this->input->post('user_ID'), $this->input->post('course_ID'), $this->input->post('status'), $this->input->post('comment'), $this->input->post('admin_ID'), NULL);	
			if(!$create){
				$data = array(
					'error' => true,
					'message' => 'Purchase already exist.'
				);
			} else {
				$data = array(
					'success' => true
				);
			}
	    }
		echo json_encode($data);
	}

	function purchase_history() {
		$data = $this->purchase_model->get_purchase_history($this->input->post('purchase_ID'));	
		echo json_encode($data);
	}

	function purhase() {
		$data = $this->purchase_model->add_purchase($this->session->userdata('user_id'), $this->input->post('id'), '1', 'Checkout', 0, $this->input->post('order'));	
		echo json_encode($data);
	}

	function enroll() {
		$data = $this->purchase_model->add_purchase($this->session->userdata('user_id'), $this->input->post('id'), '1', 'Enrolling', 0, NULL);	
		echo json_encode($data);
	}

	function update_purchase() {
		if($this->input->post('status') == '1'){
			$comment = 'Purchase has been approve by the instructor';
			$notification_name_id = 14;
		} else {
			$comment = 'Purchase has been denied by the instructor';
			$notification_name_id = 15;
		}

		$data = $this->purchase_model->change_status($this->input->post('id'), $this->input->post('status'), $comment, 0);

		$this->notification_model->create_notification(5, $notification_name_id, $this->input->post('id'), $this->input->post('user_ID'), 0);
		echo json_encode($data);
	}
}