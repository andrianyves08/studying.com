<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('upload');
	}

	function accept_reward(){
		$this->user_model->accept_reward($this->session->userdata('user_id'), 10);
		$data = array(
			'exp' => 10
		);
		echo json_encode($data);
	}

	function approve_as_instructor() {
		$data = $this->user_model->approve_as_instructor($this->input->post('id'), $this->input->post('user_ID'));
		echo json_encode($data);
	}

	function deny_as_instructor() {
		$data = $this->user_model->deny_as_instructor($this->input->post('id'), $this->input->post('user_ID'));
		echo json_encode($data);
	}

	function request_as_instructor() {
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('description', 'Course Description', 'required');

	    if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('multi',validation_errors());
	    } else {
	    	if(!empty($this->input->post('user_ID'))){
	    		$user = $this->input->post('user_ID');
	    	} else {
	    		$user = $this->session->userdata('user_id');
	    	}

	    	if(!empty($this->input->post('status'))){
	    		$status = $this->input->post('status');
	    	} else {
	    		$status = '0';
	    	}

	    	if($this->input->post('status') == '1'){
	    		$this->user_model->approve_as_instructor($this->input->post('user_ID'));
	    	} 

			$create = $this->user_model->request_as_instructor($this->input->post('description'), $this->input->post('experience'), $user, $status);
			if($create){
				$this->session->set_flashdata('success', 'Form submitted');
			}
	    }
	    redirect($_SERVER['HTTP_REFERER']);
	}

	function change_status() {
		$data = $this->user_model->change_status($this->input->post('user_ID'), $this->input->post('status'));
		echo json_encode($data);
	}

	function change_email() {
		$data = $this->user_model->change_email($this->input->post('user_ID'), $this->input->post('email'));
		if(!$data){
			$this->session->set_flashdata('error', 'Email address already exist!');
		} else {
			$this->session->set_flashdata('success', 'Email address updated successfully!');
		}
	    redirect($_SERVER['HTTP_REFERER']);
	}

	function change_password_by_admin(){
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('new_password', 'new password', 'required');
        $this->form_validation->set_rules('cnew_Password', 'confirm password', 'required|matches[new_password]');

	    if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('multi',validation_errors());
	    } else {
			$create = $this->user_model->change_password($this->input->post('user_ID'), $this->input->post('new_password'));
			if($create){
				$this->session->set_flashdata('success', 'Update successfully');
			}
	    }
	    redirect($_SERVER['HTTP_REFERER']);
	}

	function change_password(){
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('new_password', 'new password', 'required');
        $this->form_validation->set_rules('cnew_Password', 'confirm password', 'required|matches[new_password]');

	    if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('multi',validation_errors());
	    } else {
	    	$current_password = $this->input->post('current_password', TRUE);
			$new_password = $this->input->post('new_password', TRUE);
			$cnew_Password = $this->input->post('cnew_Password', TRUE);
			$user = $this->user_model->get_users($this->session->userdata('user_id'));
			if(!password_verify($current_password, $user['password'])){
				$this->session->set_flashdata('error', 'Invalid current password');
			} else {
				$create = $this->user_model->change_password($this->session->userdata('user_id'), $new_password);
				if($create){
					$this->session->set_flashdata('success', 'Update successfully');
				}
			}
	    }
	    redirect($_SERVER['HTTP_REFERER']);
	}

	function update_photo(){
		if(isset($_FILES["profile_photo"]["name"])){
    		$profile_photo = hash('md5', $this->session->userdata('email')).".".pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION); 

    		$config['file_name'] = $profile_photo;
			$config['upload_path'] = './assets/img/users/';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size']      = 4096;
			$this->upload->initialize($config);
			unlink('./assets/img/users/'.$this->input->post('old_photo'));
			unlink('./assets/img/users/thumbs/'.$this->input->post('old_photo')); 
			if(!$this->upload->do_upload('profile_photo')){
				$this->session->set_flashdata('error',$this->upload->display_errors());
			} else {
				$data = array('upload_data' => $this->upload->data());
				//Compress photo
				$config['photo_library'] = 'gd2';
				$config['source_image'] = './assets/img/users/'.$profile_photo;
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				$config['new_image'] = './assets/img/users/thumbs/'.$profile_photo;
				$config['quality']= '80%';
				$config['width']= 250;
				$this->load->library('image_lib', $config);
				$this->image_lib->initialize($config);
				$this->image_lib->resize();

				$create = $this->user_model->update_photo($profile_photo, $this->session->userdata('user_id'));
				if($create){
					$this->session->set_flashdata('success', 'Photo updated successfully');
				}
			}
		}
	   redirect($_SERVER['HTTP_REFERER']);
	}

	function update_profile(){
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
		$this->form_validation->set_rules('first_name', 'Firt name', 'required');
		$this->form_validation->set_rules('last_name', 'Last name', 'required');
		$this->form_validation->set_rules('username', 'username', 'alpha_dash');

	    if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('multi',validation_errors());
			redirect(base_url().$this->input->post('current_username'));
	    } else {
			$bio = '';
			if(!empty($this->input->post('bio'))){
				$about_me = $this->input->post('bio');
			}

			$create = $this->user_model->update_profile($this->input->post('username'), $this->input->post('first_name'), $this->input->post('last_name'), $about_me, $this->session->userdata('user_id'));
			if($create){
				$this->session->set_flashdata('success', 'Update successfully');
				redirect(base_url().$this->input->post('username'));
			} else {
				$this->session->set_flashdata('error', 'Username already exist!');
	    		redirect($_SERVER['HTTP_REFERER']);
			}
	    }
	}


	function get_level() {
		$data = $this->user_model->get_users($this->session->userdata('user_id'));
		$next_level = $this->user_model->next_level($data['level']);
		if(!$next_level){
			$next_exp =	$data['exp'];
		} else {
			$next_exp =	$next_level['next_exp'];
		}
		$level = $next_exp - $data['level'];
		$mycurrent = $data['exp'] - $data['level'];
		$percentage = ($mycurrent / $level) * 100;
		$output = '';

		$output .= '
		<div class="form-inline">
			<a class="nav-link waves-effect blue-text">
		        <strong>Level '.$data['level'].' </strong>
		    </a>
		    <div class="progress" style="width: 100px; height: 15px;">
		    	<div class="progress-bar" role="progressbar" style="width: '.$percentage.'%;" aria-valuemin="0" aria-valuemax="'.$level.'">'.$data['exp'].' exp
		    	</div>
		  	</div>
		</div>
		';
		echo json_encode($output);
	}

	function next(){
		$data = $this->course_model->next_module($this->input->post('course_ID'), $this->input->post('section_ID'));
		echo json_encode($data);
	}

	function follow(){
		$data = $this->user_model->follow($this->input->post('user_ID'), $this->session->userdata('user_id'));
		echo json_encode($data);
	}

	function unfollow(){
		$data = $this->user_model->unfollow($this->input->post('user_ID'), $this->session->userdata('user_id'));
		echo json_encode($data);
	}

	function get_following(){
		$data = $this->user_model->get_following($this->input->post('user_ID'));
		$output = '';
		foreach($data as $row){
			$output .= '<li class="list-group-item"><a href="'.base_url().$row['username'].'"><img class="rounded-circle mr-2 card-img-100 chat-mes-id" src="'.base_url().'assets/img/users/thumbs/'.$row['image'].'" style="height: 30px; width: 30px" alt="Profile photo" onerror="this.onerror=null;this.src=\''.base_url().'assets/img/users/stock.jpg\';">'.ucwords($row['first_name']).' '.ucwords($row['last_name']).'</a></li>';
		}
		$output .= '';
		echo json_encode($output);
	}
	
	function get_followers(){
		$data = $this->user_model->get_followers($this->input->post('user_ID'));
		$output = '';
		foreach($data as $row){
			$output .= '<li class="list-group-item"><a href="'.base_url().$row['username'].'"><img class="rounded-circle mr-2 card-img-100 chat-mes-id" src="'.base_url().'assets/img/users/thumbs/'.$row['image'].'" style="height: 30px; width: 30px" alt="Profile photo" onerror="this.onerror=null;this.src=\''.base_url().'assets/img/users/stock.jpg\';"> '.ucwords($row['first_name']).' '.ucwords($row['last_name']).'</a></li>';
		}
		$output .= '';
		echo json_encode($output);
	}

	function update_user_status(){
		$data = $this->user_model->update_user_status($this->session->userdata('user_id'));
		echo json_encode($data);
	}

	function get_users(){
		$user = $this->user_model->get_users($this->input->post('user_ID'));
		$count_posts = $this->user_model->count_posts($this->input->post('user_ID'));
		$count_followers = $this->user_model->count_followers($this->input->post('user_ID'));
		$count_following = $this->user_model->count_following($this->input->post('user_ID'));
		$rank = $this->user_model->get_users($this->input->post('user_ID'));
		
		$data = array(
			'full_name' => ucwords($user['first_name']).' '.ucwords($user['last_name']),
			'image' => $user['image'],
			'level' => $user['level'],
			'count_posts' => $count_posts['total'],
			'count_followers' => $count_followers['total'],
			'count_following' => $count_following['total'],
			'about_me' => $user['about_me'],
		);
		echo json_encode($data);
	}

	function add_course() {
		$data = $this->users_course_model->add_course($this->input->post('id'), $this->input->post('course_ID'));
		echo json_encode($data);
	}

	function remove_student() {
		$data = $this->users_course_model->remove_student($this->input->post('user_course_ID'));
		echo json_encode($data);
	}

	function create() {
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('first_name', 'First name', 'required');
        $this->form_validation->set_rules('last_name', 'last name', 'required');

	    if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('multi',validation_errors());
	        redirect('admin/users');
	    } else {
			$create = $this->user_model->create_user($this->input->post('email'), $this->input->post('first_name'), $this->input->post('last_name'));
			if($create){
				$this->load->library('active_campaign');
        		$ac = $this->active_campaign->load();

        		$contact = array(
		            "email"              => $this->input->post('email'),
		            "first_name"         => $this->input->post('first_name'),
		            "last_name"          => $this->input->post('last_name'),
		            "tags"              => 'Studying.com User',
		            "p[3]"      => '3',
		        );

          		$ac->api("contact/sync", $contact);
				$this->session->set_flashdata('success', 'User Created Successfully');
			} else {
				$this->session->set_flashdata('error', 'Email already exist');
			}
			redirect('admin/users');
	    }
	}
}