<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('upload');
	}

	public function logo() {
		$logo = $_FILES['logo']['name'];
    	$logo = "logo.".pathinfo($logo, PATHINFO_EXTENSION); 
		$config['file_name'] = $logo;
		$config['upload_path'] = './assets/img';
		$config['allowed_types'] = 'gif|jpg|png';
		$this->upload->initialize($config);
		$this->upload->overwrite = true;

		if(!$this->upload->do_upload('logo')){
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('error',$error['error']);
		} else {
			$data = array('upload_data' => $this->upload->data());
			$logo_img = $_FILES['logo']['name'];
			$this->setting_model->logo($logo);
			$this->session->set_flashdata('success', 'Your Logo has been updated');
		}
		redirect('admin/settings');
	}

	function login_video() {
		$video = $_FILES['login_video']['name'];
    	$login_video = "login_video.".pathinfo($video, PATHINFO_EXTENSION); 
		$config['file_name'] = $login_video;
		$config['upload_path'] = './assets/img/videos';
		$config['allowed_types'] = 'mkv|avi|mov|mp4';
		$config['max_size'] = '102400';
		$this->upload->initialize($config);
		$this->upload->overwrite = true;

		if(!$this->upload->do_upload('login_video')){
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('error',$error['error']);
		} else {
			$data = array('upload_data' => $this->upload->data());
			$this->setting_model->login_video($login_video);
			$this->session->set_flashdata('success', 'Your Video has been updated');
		}
		redirect('admin/settings');
	}

	function home_video() {
		$video = $_FILES['home_video']['name'];
    	$home_video = "home_video.".pathinfo($video, PATHINFO_EXTENSION); 
		$config['file_name'] = $home_video;
		$config['upload_path'] = './assets/img/videos';
		$config['allowed_types'] = 'mkv|avi|mov|mp4';
		$config['max_size'] = '102400';
		$this->upload->initialize($config);
		$this->upload->overwrite = true;

		if(!$this->upload->do_upload('home_video')){
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('error',$error['error']);
		} else {
			$data = array('upload_data' => $this->upload->data());
			$this->setting_model->home_video($home_video);
			$this->session->set_flashdata('success', 'Your Video has been updated');
		}
		redirect('admin/settings');
	}

	function music() {
		$name = $_FILES['music']['name'];
    	$music = "music.".pathinfo($name, PATHINFO_EXTENSION); 
		$config['file_name'] = $music;
		$config['upload_path'] = './assets/img';
		$config['allowed_types'] = 'mp3';
		$config['max_size'] = '102400';
		$this->upload->initialize($config);
		if(!$this->upload->do_upload('music')){
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('error',$error['error']);
		} else {
			$data = array('upload_data' => $this->upload->data());
			$this->setting_model->music($music);
			$this->session->set_flashdata('success', 'Your background music has been updated');
		}
		redirect('admin/settings');
	}

	function nav_text_color() {
		$this->setting_model->nav_text_color($this->input->post('nav_color',TRUE));
		$this->session->set_flashdata('success', 'Your color has been updated');
		redirect('admin/settings');
	}

	function update_page($id) {
		$this->setting_model->update_page($id, $this->input->post('content'));
		$this->session->set_flashdata('success', 'Page has been updated');
		redirect('admin/settings');
	}

	function edit_background_image() {
		$config['upload_path'] = './assets/img';
		$config['allowed_types'] = 'gif|jpg|png';
		$this->upload->initialize($config);
		if(!$this->upload->do_upload('background_image')){
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('error',$error['error']);
		} else {
			$data = array('upload_data' => $this->upload->data());
			$background_image = $_FILES['background_image']['name'];
			$this->setting_model->background_image($background_image);
			$this->session->set_flashdata('success', 'Your background image has been updated');
		}
		redirect('admin/settings');
	}
}