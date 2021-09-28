<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instructor extends CI_Controller {
	function check_session(){
		$settings = $this->setting_model->get_settings();

		if($settings['system_status'] == 1){
			$data = $this->user_model->get_users($this->session->userdata('user_id'));
			if(!$this->session->userdata('user_logged_in') || $data['role'] == '0'){
				redirect('instructor/login');
			}
		} else {
			// Check if the admin account is also logged-in in order to use the system even if its undermaintenance.
			if(!$this->session->userdata('user_logged_in') && !$this->session->userdata('admin_logged_in')){
				redirect('maintenance');
			}
		}
	}

	public function index()	{
		$this->check_session();
		$page = 'home';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_ID'] = $this->session->userdata('user_id');
		$data['settings'] = $this->setting_model->get_settings();

		$this->load->view('templates/instructor/header', $data);
        $this->load->view('templates/instructor/nav', $data);
		$this->load->view('instructor/index', $data);
		$this->load->view('templates/instructor/footer');
        $this->load->view('templates/instructor/scripts');
	}

	public function announcements() {
		$this->check_session();
		$page = 'announcements';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_ID'] = $this->session->userdata('user_id');
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));
		$data['settings'] = $this->setting_model->get_settings();

		$data['details'] = $this->instructor_model->get_announcement($this->session->userdata('user_id'));
		$data['schedules'] = $this->instructor_model->get_schedule($this->session->userdata('user_id'));

		$this->load->view('templates/instructor/header', $data);
        $this->load->view('templates/instructor/nav', $data);
		$this->load->view('instructor/'.$page, $data);
        $this->load->view('templates/instructor/footer');
		$this->load->view('templates/instructor/scripts');
	}

	public function course() {
		$this->check_session();
		$page = 'course';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_ID'] = $this->session->userdata('user_id');
		$data['settings'] = $this->setting_model->get_settings();

		$data['courses'] = $this->course_model->get_course($this->session->userdata('user_id'), NULL, NULL, NULL);
		$data['categories'] = $this->course_model->get_category();

		$this->load->view('templates/instructor/header', $data);
        $this->load->view('templates/instructor/nav', $data);
		$this->load->view('instructor/'.$page, $data);
        $this->load->view('templates/instructor/footer');
		$this->load->view('templates/instructor/scripts');
	}

	public function course_archive() {
		$this->check_session();
		$page = 'course';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_ID'] = $this->session->userdata('user_id');
		$data['settings'] = $this->setting_model->get_settings();

		$data['courses'] = $this->course_model->get_course($this->session->userdata('user_id'), NULL, NULL, NULL);
		$data['categories'] = $this->course_model->get_category();

		$this->load->view('templates/instructor/header', $data);
        $this->load->view('templates/instructor/nav', $data);
		$this->load->view('instructor/course_archive', $data);
        $this->load->view('templates/instructor/footer');
		$this->load->view('templates/instructor/scripts');
	}

	public function course_modules($slug){
		$this->check_session();
		$page = 'course';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_ID'] = $this->session->userdata('user_id');
		$data['settings'] = $this->setting_model->get_settings();

		$data['course'] = $this->course_model->get_course($this->session->userdata('user_id'), NULL, NULL, NULL, $slug);
		$data['courses'] = $this->course_model->get_course($this->session->userdata('user_id'), NULL, NULL, NULL);
		$data['modules'] = $this->course_model->get_modules($data['course']['course_ID']);

		$this->load->view('templates/instructor/header', $data);
        $this->load->view('templates/instructor/nav', $data);
		$this->load->view('instructor/course_modules', $data);
		$this->load->view('templates/instructor/footer');
		$this->load->view('templates/instructor/scripts');
	}

	public function course_update($slug){
		$this->check_session();
		$page = 'course';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_ID'] = $this->session->userdata('user_id');
		$data['settings'] = $this->setting_model->get_settings();

		$data['course'] = $this->course_model->get_course($this->session->userdata('user_id'), NULL, NULL, NULL, $slug);
		$data['categories'] = $this->course_model->get_category();
		$data['course_to_categories'] = $this->course_model->get_course_to_category($data['course']['course_ID']);

		$this->load->view('templates/instructor/header', $data);
        $this->load->view('templates/instructor/nav', $data);
		$this->load->view('instructor/course_edit', $data);
		$this->load->view('templates/instructor/footer');

		$this->load->view('templates/instructor/scripts');
	}

	public function course_rating($course_slug){
		$this->check_session();
		$page = 'course';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_ID'] = $this->session->userdata('user_id');
		$data['settings'] = $this->setting_model->get_settings();

		$data['course'] = $this->course_model->get_course($this->session->userdata('user_id'), NULL, NULL, NULL, $course_slug);
		$data['ratings'] = $this->course_model->get_course_reviews(NULL, NULL, NULL, $data['course']['course_ID']);

		$this->load->view('templates/instructor/header', $data);
        $this->load->view('templates/instructor/nav', $data);
		$this->load->view('instructor/course_ratings', $data);
		$this->load->view('templates/instructor/footer');
		$this->load->view('templates/instructor/scripts');
	}

	public function course_students($course_slug){
		$this->check_session();
		$page = 'course';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_ID'] = $this->session->userdata('user_id');
		$data['settings'] = $this->setting_model->get_settings();

		$data['course'] = $this->course_model->get_course($this->session->userdata('user_id'), NULL, NULL, NULL, $course_slug);
		$data['students'] = $this->purchase_model->get_users_course($data['course']['course_ID'], $this->session->userdata('user_id'));
		$data['users'] = $this->user_model->get_users();

		$this->load->view('templates/instructor/header', $data);
        $this->load->view('templates/instructor/nav', $data);
		$this->load->view('instructor/course_students', $data);
		$this->load->view('templates/instructor/footer');
		$this->load->view('templates/instructor/scripts');
	}

	public function create_content($course_slug, $module_slug){
		$this->check_session();
		$page = 'course';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_ID'] = $this->session->userdata('user_id');
		$data['settings'] = $this->setting_model->get_settings();

		$data['course'] = $this->course_model->get_course($this->session->userdata('user_id'), NULL, NULL, NULL, $course_slug);
		$data['module'] = $this->course_model->get_module($module_slug, $data['course']['course_ID']);
		$data['modules'] = $this->course_model->get_modules($data['course']['course_ID']);
		$data['sections'] = $this->course_model->get_sections($data['module']['id']);
		$data['lessons'] = $this->course_model->get_lessons();
		$data['contents'] = $this->course_model->get_contents();

		$this->load->view('templates/instructor/header', $data);
        $this->load->view('templates/instructor/nav', $data);
		$this->load->view('instructor/course_content', $data);
		$this->load->view('templates/instructor/footer');
		$this->load->view('templates/instructor/scripts');
	}

	public function edit_content($course_slug, $module_slug, $section_slug){
		$this->check_session();
		$page = 'course';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_ID'] = $this->session->userdata('user_id');
		$data['settings'] = $this->setting_model->get_settings();

		$data['course'] = $this->course_model->get_course($this->session->userdata('user_id'), NULL, NULL, NULL, $course_slug);
		$data['module'] = $this->course_model->get_module($module_slug, $data['course']['course_ID']);
		$data['section'] = $this->course_model->get_section($section_slug, $data['module']['id']);
		$data['lessons'] = $this->course_model->get_lessons($data['section']['id']);
		$data['contents'] = $this->course_model->get_contents();

		$this->load->view('templates/instructor/header', $data);
        $this->load->view('templates/instructor/nav', $data);
		$this->load->view('instructor/course_content_edit', $data);
		$this->load->view('templates/instructor/footer');
		$this->load->view('templates/instructor/scripts');
	}

	public function edit_all_content($course_slug, $module_slug){
		$this->check_session();
		$page = 'course';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_ID'] = $this->session->userdata('user_id');
		$data['settings'] = $this->setting_model->get_settings();

		$data['course'] = $this->course_model->get_course($this->session->userdata('user_id'), NULL, NULL, NULL, $course_slug);
		$data['module'] = $this->course_model->get_module($module_slug, $data['course']['course_ID']);
		$data['sections'] = $this->course_model->get_sections($data['module']['id']);
		$data['lessons'] = $this->course_model->get_lessons();
		$data['contents'] = $this->course_model->get_contents();

		$this->load->view('templates/instructor/header', $data);
        $this->load->view('templates/instructor/nav', $data);
		$this->load->view('instructor/course_content_edit_all', $data);
		$this->load->view('templates/instructor/footer');
		$this->load->view('templates/instructor/scripts');
	}

	public function qaa()	{
		$this->check_session();
		$page = 'Question & Answer Mastersheet';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_ID'] = $this->session->userdata('user_id');
		$data['settings'] = $this->setting_model->get_settings();

		$data['qaas'] = $this->qaa_model->get_qaas();
		$data['categories'] = $this->course_model->get_category();

		$this->load->view('templates/instructor/header', $data);
        $this->load->view('templates/instructor/nav', $data);
		$this->load->view('instructor/qaa', $data);
		$this->load->view('templates/instructor/footer');
        $this->load->view('templates/instructor/scripts');
	}

	public function edit_qaa($id){
		$this->check_session();
		$page = 'Question & Answer Mastersheet';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_ID'] = $this->session->userdata('user_id');
		$data['settings'] = $this->setting_model->get_settings();
		$data['qaa'] = $this->qaa_model->get_qaas($id);

		if($data['qaa']['user_ID'] != $this->session->userdata('user_id')){
			$this->session->set_flashdata('error', 'You are not the creator!');
			redirect('instructor/question-and-answer-mastersheet');
		}

		$data['categories'] = $this->course_model->get_category();
		$data['qaa_categories'] = $this->qaa_model->get_qaas_category($id);

		$this->load->view('templates/instructor/header', $data);
        $this->load->view('templates/instructor/nav', $data);
		$this->load->view('instructor/qaa_edit', $data);
		$this->load->view('templates/instructor/footer');
		$this->load->view('templates/instructor/scripts');
	}

	public function media()	{
		$this->check_session();
		$page = 'media';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_ID'] = $this->session->userdata('user_id');
		$data['settings'] = $this->setting_model->get_settings();

		$this->load->view('templates/instructor/header', $data);
        $this->load->view('templates/instructor/nav', $data);
		$this->load->view('instructor/media', $data);
		$this->load->view('templates/instructor/footer');
        $this->load->view('templates/instructor/scripts');
	}

	public function order()	{
		$this->check_session();
		$page = 'Order';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_ID'] = $this->session->userdata('user_id');
		$data['settings'] = $this->setting_model->get_settings();

		$data['orders'] = $this->purchase_model->get_users_course(NULL, $this->session->userdata('user_id'));
		$data['all_courses'] = $this->course_model->get_course($this->session->userdata('user_id'), NULL, NULL, '1');
		$data['users'] = $this->user_model->get_users();
		$data['order_status'] = $this->purchase_model->get_purchase_status();


		$this->load->view('templates/instructor/header', $data);
        $this->load->view('templates/instructor/nav', $data);
		$this->load->view('instructor/order', $data);
		$this->load->view('templates/instructor/footer');
        $this->load->view('templates/instructor/scripts');
	}

	public function users()	{
		$this->check_session();
		$page = 'users';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_ID'] = $this->session->userdata('user_id');
		$data['settings'] = $this->setting_model->get_settings();
		$data['students'] = $this->instructor_model->get_my_students(NULL, $this->session->userdata('user_id'));

		$this->load->view('templates/instructor/header', $data);
        $this->load->view('templates/instructor/nav', $data);
		$this->load->view('instructor/'.$page, $data);
        $this->load->view('templates/instructor/footer');
        $this->load->view('templates/instructor/scripts');
	}

	public function posts()	{
		$this->check_session();
		$page = 'posts';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_ID'] = $this->session->userdata('user_id');
		$data['settings'] = $this->setting_model->get_settings();

		$data['posts'] = $this->post_model->get_posts(NULL, 0, FALSE);

		$this->load->view('templates/instructor/header', $data);
        $this->load->view('templates/instructor/nav', $data);
		$this->load->view('instructor/'.$page, $data);
        $this->load->view('templates/instructor/footer');
        $this->load->view('templates/instructor/scripts');
	}

	public function reviews()	{
		$this->check_session();
		$page = 'reviews';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_ID'] = $this->session->userdata('user_id');
		$data['settings'] = $this->setting_model->get_settings();

		$data['instructors'] = $this->review_model->get_reviews(2);
		$data['courses'] = $this->review_model->get_reviews(3);
		$data['contents'] = $this->review_model->get_reviews(4);

		$this->load->view('templates/instructor/header', $data);
        $this->load->view('templates/instructor/nav', $data);
		$this->load->view('instructor/'.$page, $data);
		$this->load->view('templates/instructor/footer');
        $this->load->view('templates/instructor/scripts');
	}

	public function settings(){
		$this->check_session();
		$page = 'settings';
		$data['title'] = ucfirst($page);
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_ID'] = $this->session->userdata('user_id');
		$data['settings'] = $this->setting_model->get_settings();
		$data['pages'] = $this->setting_model->get_pages();

		$this->load->view('templates/instructor/header', $data);
        $this->load->view('templates/instructor/nav', $data);
		$this->load->view('instructor/'.$page, $data);
		$this->load->view('templates/instructor/scripts');
        $this->load->view('templates/instructor/footer');
	}

	public function login(){
		$page = 'login';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->setting_model->get_settings();

		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');

        if($this->form_validation->run() === FALSE){
           	$this->load->view('templates/instructor/header', $data);
			$this->load->view('instructor/'.$page, $data);
			$this->load->view('templates/instructor/scripts');
        } else {
            $password = $this->input->post('password');
            $user = $this->user_model->get_users($this->input->post('email'));

            $user_id = $this->user_model->login($this->input->post('email'), $password);
            if($user_id['status'] == '2'){
            	$this->session->set_flashdata('error', 'Your account has been disabled!');
                redirect('instructor/login');
            }
            if($user_id){
            	if($user_id['role'] == 0){
            		$this->session->set_flashdata('error', 'You are not a intructor');
            		 redirect($_SERVER['HTTP_REFERER']);
            	} else {
            		$user_data = array(
	                    'user_id' => $user_id['id'],
	                    'email' => $user_id['email'],
	                    'first_name' => $user_id['first_name'],
	                    'last_name' => $user_id['last_name'],
	                    'user_logged_in' => true
	                );
	                $this->session->set_userdata($user_data);
                	setcookie('user_id', hash('md5', $user_id['id']), time() + (86400 * 30 * 30), "/");
	                $this->session->set_flashdata('success', 'You are now logged in');
	                redirect('instructor/index');
            	}
            } else {
                $this->session->set_flashdata('error', 'Invalid Email/Password');
                redirect($_SERVER['HTTP_REFERER']);
            }      
        }
	}

	public function register(){
		$page = 'register';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->setting_model->get_settings();

		if($data['settings']['system_status'] == 0){
			redirect('maintenance');
		}

		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('first_name', 'first_name', 'required');
        $this->form_validation->set_rules('last_name', 'last_name', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        $this->form_validation->set_rules('confirm_password', 'confirm password', 'required|matches[password]');

        if($this->form_validation->run() === FALSE){
        	$this->session->set_flashdata('multi',validation_errors());
	        $this->load->view('instructor/register', $data);
        } else {
            $user = $this->user_model->get_users($this->input->post('email'));
            if($user > 0){
     			$this->session->set_flashdata('error', 'Email already exist!');
     			redirect('register');
			} else {
				$create = $this->user_model->register($this->input->post('email'), $this->input->post('first_name'), $this->input->post('last_name'), $this->input->post('password'), $this->input->post('role'));
				$this->session->set_flashdata('success', 'Register successfully!');
				redirect('login');
			}
        }
	}

	public function logout(){
        $this->session->unset_userdata('user_logged_in');
        $this->session->unset_userdata($user_data);
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'You are now logged out');
        unset($_COOKIE['user_id']);
        setcookie('user_id', null, -1, '/'); 
        redirect('instructor/login');
	}

	function isTimeValid($time) {
	    return is_object(DateTime::createFromFormat('h:i:s a', $time));
	}

	function create_schedule() {
        $this->form_validation->set_rules('day', 'Day', 'required', array('required' => 'Day is required.'));
        $this->form_validation->set_rules('time', 'Time', 'required', array('required' => 'Time is required.'));
        $this->form_validation->set_rules('timezone', 'Timezone', 'required', array('required' => 'Timezone is required.'));

        if ($this->form_validation->run() === FALSE) {
        	$data = array(
				'error' => true,
				'message' => validation_errors()
			);
	    } else {
	    	$time = $this->isTimeValid($this->input->post('time'));

			if($time){
				$create = $this->instructor_model->create_schedule($this->input->post('day'), $this->input->post('time'), $this->input->post('timezone'), $this->input->post('note'), $this->session->userdata('user_id'));
				$data = array(
					'error' => false
				);
			} else {
				$data = array(
					'error' => true,
					'message' => 'Time is invalid!'
				);
			}
	    }
	   	echo json_encode($data);
	}

	function delete_schedule() {
		$data = $this->instructor_model->delete_schedule($this->input->post('id'));
		echo json_encode($data);
	}

	function update_announcement() {
		$this->instructor_model->update_announcement($this->session->userdata('user_id'), $this->input->post('announcement'));
		$this->session->set_flashdata('success', 'Announcement has been updated');
		redirect('instructor/announcements');
	}
	
}