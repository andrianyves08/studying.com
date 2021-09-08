<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qaa extends CI_Controller {

	function create_qaa() {
        $this->form_validation->set_rules('question', 'Question', 'required');
        $this->form_validation->set_rules('answer', 'Answer', 'required');
        $this->form_validation->set_rules('category[]', 'Category', 'required');

	    if ($this->form_validation->run() === FALSE) {
			$data = array(
				'error' => true,
				'message' => validation_errors()
			);
	    } else {
			$create = $this->qaa_model->create_qaa($this->input->post('category'), $this->input->post('question'), $this->input->post('answer'), $this->session->userdata('user_id'));
			if($create){
				$data = array(
					'error' => false
				);
			} else {
				$data = array(
					'error' => true,
					'message' => 'Course title already exist.'
				);
			}
	    }
	    echo json_encode($data);
	}

	function update_qaa() {
        $this->form_validation->set_rules('question', 'Question', 'required');
        $this->form_validation->set_rules('answer', 'Answer', 'required');
        $this->form_validation->set_rules('category[]', 'Category', 'required');

	    if ($this->form_validation->run() === FALSE) {
			$data = array(
				'error' => true,
				'message' => validation_errors()
			);
	    } else {
			$create = $this->qaa_model->update_qaa($this->input->post('qaa_ID'), $this->input->post('category'), $this->input->post('question'), $this->input->post('answer'));
			if($create){
				$data = array(
					'error' => false
				);
			} else {
				$data = array(
					'error' => true,
					'message' => 'Course title already exist.'
				);
			}
	    }
	   echo json_encode($data);
	}

	function delete_qaa() {
		$data = $this->qaa_model->delete_qaa($this->input->post('id'));
		echo json_encode($data);
	}
}