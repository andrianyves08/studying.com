<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Studying extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('upload');
	}

	function create() {
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('rating', 'rating', 'required');
        $this->form_validation->set_rules('url', 'url', 'required');
        $this->form_validation->set_rules('title', 'title', 'required');

        if ($this->form_validation->run() === FALSE) {
        	$this->session->set_flashdata('multi',validation_errors());
	    } else {
			$data = $this->studying_review_model->create_review($this->input->post('title'), $this->input->post('name'), $this->input->post('description'), $this->input->post('testimonial'), $this->input->post('rating'), $this->input->post('niche'), $this->input->post('location'), $this->input->post('url'), $this->input->post('date'), $this->session->userdata('admin_id'));

			if($data){
				$this->session->set_flashdata('success', 'Review created Successfully');
			} else {
				$this->session->set_flashdata('error', 'Review video URL already exist.');
			}
	    }
	    redirect($_SERVER['HTTP_REFERER']);
	}

	function update() {
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('rating', 'rating', 'required');
        $this->form_validation->set_rules('url', 'url', 'required');
        $this->form_validation->set_rules('title', 'title', 'required');

        if ($this->form_validation->run() === FALSE) {
        	$this->session->set_flashdata('multi',validation_errors());
	    } else {
			$data = $this->studying_review_model->update_review($this->input->post('review_ID'), $this->input->post('title'), $this->input->post('name'), $this->input->post('description'), $this->input->post('testimonial'), $this->input->post('rating'), $this->input->post('niche'), $this->input->post('location'), $this->input->post('url'), $this->input->post('date'), $this->session->userdata('admin_id'));

			if($data){
				$this->session->set_flashdata('success', 'Review updated Successfully');
			} else {
				$this->session->set_flashdata('error', 'Review video URL already exist.');
			}
	    }
		redirect('admin/studying-review/'.$this->input->post('review_ID'));
	}

	function delete_review() {
		$data = $this->studying_review_model->delete_review($this->input->post('id'));
		echo json_encode($data);
	}

	//Upload image summernote
	function upload_image(){
		if(isset($_FILES["image"]["name"])){
			$config['upload_path'] = './assets/img/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('image')){
				$this->upload->display_errors();
				return FALSE;
			}else{
				$data = $this->upload->data();
		        //Compress Image
		        $config['image_library']='gd2';
		        $config['source_image']='./assets/img/'.$data['file_name'];
		        $config['create_thumb']= FALSE;
	            $config['maintain_ratio']= TRUE;
	            $config['new_image']= './assets/img/'.$data['file_name'];
	            $this->load->library('image_lib', $config);
	            $this->image_lib->resize();
				echo base_url().'assets/img/'.$data['file_name'];
			}
		}
	}
}