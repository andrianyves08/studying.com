<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('upload');
	}

	public function create_blog() {
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('meta_description', 'Meta description', 'required');
		$this->form_validation->set_rules('meta_keywords', 'Meta keywords', 'required');
		$this->form_validation->set_rules('content', 'Content', 'required');

        if ($this->form_validation->run() === FALSE) {
			$data = array(
				'error' => true,
				'message' => validation_errors()
			);
	    } else {
	    	if (is_null(json_decode($this->input->post('files')))) {
		    	$files = array($this->input->post('files'));
		    } else {
		    	$files = json_decode($this->input->post('files'));
		    }
	
			$create = $this->blog_model->create_blog($this->input->post('title'), $this->input->post('meta_description'), $this->input->post('banner'), $this->input->post('content'), $this->input->post('category'), $this->input->post('meta_keywords'), $files, $this->session->userdata('admin_id'));

			if($create){
				$data = array(
					'error' => false
				);
			} else {
				$data = array(
					'error' => true,
					'message' => 'Blog title already exist.'
				);
			}
	    }
	   echo json_encode($data);
	}

	function get_category() {
		$data = $this->blog_model->get_category();
	    echo json_encode($data);
	}

	function create_category() {
		$data = $this->blog_model->create_category($this->input->post('name'), $this->session->userdata('admin_id'));
	    echo json_encode($data);
	}

	function update_blog() {
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('meta_description', 'Meta description', 'required');
		$this->form_validation->set_rules('meta_keywords', 'Meta keywords', 'required');
		$this->form_validation->set_rules('content', 'Content', 'required');

        if ($this->form_validation->run() === FALSE) {
			$data = array(
				'error' => true,
				'message' => validation_errors()
			);
	    } else {
	    	if (is_null(json_decode($this->input->post('files')))) {
		    	$files = array($this->input->post('files'));
		    } else {
		    	$files = json_decode($this->input->post('files'));
		    }
	
			$create = $this->blog_model->update_blog($this->input->post('blog_ID'), $this->input->post('title'), $this->input->post('meta_description'), $this->input->post('banner'), $this->input->post('content'), $this->input->post('category'), $this->input->post('meta_keywords'), $files, $this->session->userdata('admin_id'));

			if($create){
				$data = array(
					'error' => false
				);
			} else {
				$data = array(
					'error' => true,
					'message' => 'Blog title already exist.'
				);
			}
	    }
	   echo json_encode($data);
	}

	function delete_blog() {
		$data = $this->blog_model->delete_blog($this->input->post('blog_ID'));
		echo json_encode($data);
	}

	function restore_blog() {
		$data = $this->blog_model->restore_blog($this->input->post('blog_ID'));
		echo json_encode($data);
	}
}