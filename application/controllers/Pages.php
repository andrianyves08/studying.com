<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('upload');
	}


	private function check_login(){
		$settings = $this->setting_model->get_settings();
		if($settings['system_status'] == 1){
			if(!$this->session->userdata('user_logged_in')){
				redirect('login');
			}
		} else {
			// Check if the admin account is also logfget_request_as_instructorged-in in order to use the system even if its undermaintenance.
			if(!$this->session->userdata('user_logged_in') && !$this->session->userdata('admin_logged_in')){
				redirect('maintenance');
			}
		}
	}

	// public function test(){
	// 	$this->check_login();

	// 	$data['notifications'] = $this->get_notifications();
	// 	$data['settings'] = $this->setting_model->get_settings();
	// 	$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));
	// 	$data['my_purchases'] = $this->purchase_model->users_course($this->session->userdata('user_id'), '1');
	// 	$data['unseen_chat'] = $this->message_model->message_not_seen($this->session->userdata('user_id'));

	// 	if(empty($data['my_info']['timezone'])){
	// 		$data['timezone'] = 'UTC';
	// 	} else {
	// 		$data['timezone'] = $data['my_info']['timezone'];
	// 	}

	// 	$this->load->library('active_campaign');
 //        $ac = $this->active_campaign->load();


	// 	$data['users'] = $this->user_model->get_users();

	// 	$data['ac'] = $ac;

	// 	$data['title'] = 'Test';
	// 	$this->load->view('templates/header', $data);
 //        $this->load->view('templates/nav', $data);
	// 	$this->load->view('pages/test', $data);
	// 	$this->load->view('templates/scripts');
	// }

	public function index(){
		$this->check_login();

		$data['notifications'] = $this->get_notifications();
		$data['settings'] = $this->setting_model->get_settings();
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));
		$data['my_purchases'] = $this->purchase_model->users_course($this->session->userdata('user_id'), '1');
		$data['unseen_chat'] = $this->message_model->message_not_seen($this->session->userdata('user_id'));

		if(empty($data['my_info']['timezone'])){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $data['my_info']['timezone'];
		}
		
		$data['last_watched'] = $this->video_model->last_watched($this->session->userdata('user_id'));
		$data['rankings'] = $this->user_model->rankings(10); 

		$global_post = $this->post_model->get_posts(0, 5, NULL, '1', NULL);
		$enrolled_posts = $this->post_model->get_enrolled_post(5, NULL, $this->session->userdata('user_id'));
		$combine = array_merge($global_post, $enrolled_posts);

		usort($combine, function($a, $b) {
		  return new DateTime($b['timestamp']) <=> new DateTime($a['timestamp']);
		});

		$data['posts'] = $combine;

		// $data['pages'] = $this->setting_model->get_pages('home');
		$data['daily_logins'] = $this->user_model->daily_logins($this->session->userdata('user_id'));
		$data['users'] = $this->user_model->get_users();
		$data['music'] = $this->session->userdata('music_status');

		if((date('j') - date('j', strtotime($data['daily_logins']['timestamp']))) > 1 ){
			$this->user_model->reset_login_streak($this->session->userdata('user_id'));
		}
		
		$data['title'] = 'Home';
		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/index', $data);
		$this->load->view('templates/post_scripts');
		$this->load->view('templates/scripts');
	}

	public function browse($category = FALSE){
		$this->check_login();

		$data['notifications'] = $this->get_notifications();
		$data['settings'] = $this->setting_model->get_settings();
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));
		$data['my_purchases'] = $this->purchase_model->users_course($this->session->userdata('user_id'), '1');
		$data['unseen_chat'] = $this->message_model->message_not_seen($this->session->userdata('user_id'));

		if(empty($data['my_info']['timezone'])){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $data['my_info']['timezone'];
		}

		$data['last_watched'] = $this->video_model->last_watched($this->session->userdata('user_id'));
		$data['courses'] = $this->course_model->get_course(NULL, 10, 0, '1');
		$data['browse_category'] = $this->course_model->get_category($category);
		$data['categories'] = $this->course_model->get_category();

		$data['title'] = 'Modules';
		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/browse', $data);
		$this->load->view('templates/scripts');
	}

	public function course_checkout($course_slug){
		$this->check_login();

		$data['notifications'] = $this->get_notifications();
		$data['settings'] = $this->setting_model->get_settings();
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));
		$data['my_purchases'] = $this->purchase_model->users_course($this->session->userdata('user_id'), '1');
		$data['unseen_chat'] = $this->message_model->message_not_seen($this->session->userdata('user_id'));

		if(empty($data['my_info']['timezone'])){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $data['my_info']['timezone'];
		}

		$data['course'] = $this->course_model->get_course(NULL, NULL, NULL, NULL, $course_slug);
		$data['title'] = ucfirst($data['course']['title']);
		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/course_checkout', $data);
		$this->load->view('templates/scripts');
	}

	public function course_success(){
		$this->check_login();
		
		$data['notifications'] = $this->get_notifications();
		$data['settings'] = $this->setting_model->get_settings();
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));
		$data['my_purchases'] = $this->purchase_model->users_course($this->session->userdata('user_id'), '1');
		$data['unseen_chat'] = $this->message_model->message_not_seen($this->session->userdata('user_id'));

		if(empty($data['my_info']['timezone'])){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $data['my_info']['timezone'];
		}

		usort($data['my_purchases'], function($a, $b) {
		  return new DateTime($a['date_enrolled']) <=> new DateTime($b['date_enrolled']);
		});

		$data['new_course'] = array_values(array_slice($data['my_purchases'], -1))[0]; 

		$data['title'] = 'Purchase Success';
		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav', $data);
		$this->load->view('pages/course_checkout_success', $data);
		$this->load->view('templates/scripts');
	}

	public function course_detail($course_slug){
		$this->check_login();

		$data['notifications'] = $this->get_notifications();
		$data['settings'] = $this->setting_model->get_settings();
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));
		$data['my_purchases'] = $this->purchase_model->users_course($this->session->userdata('user_id'), '1');
		$data['unseen_chat'] = $this->message_model->message_not_seen($this->session->userdata('user_id'));

		if(empty($data['my_info']['timezone'])){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $data['my_info']['timezone'];
		}

		$data['next_level'] = $this->user_model->next_level($data['my_info']['level']);
		$data['all_users']  = $this->message_model->all_users();
		$data['course'] = $this->course_model->get_course(NULL, NULL, NULL, NULL, $course_slug);
		$data['modules'] = $this->course_model->get_modules($data['course']['course_ID']);
		$data['instructor'] = $this->user_model->get_users($data['course']['user_ID']);
		$data['duration'] = $this->video_model->get_course_duration($data['course']['course_ID']);
		$data['rating'] = $this->review_model->get_rating(3, $data['course']['course_ID']);
		$data['course_reviews'] = $this->review_model->get_review(3, 0, 0, $data['course']['course_ID']);
		$data['instructor_reviews'] = $this->review_model->get_review(2, 0, 0, $data['course']['user_ID']);
		$data['users_course'] = $this->course_model->get_users_course($data['course']['course_ID']);

		$data['count_posts'] = $this->user_model->count_posts($data['course']['user_ID']);
		$data['count_followers'] = $this->user_model->count_followers($data['course']['user_ID']);

		$data['total_modules'] = $this->course_model->count_module($data['course']['course_ID']);
		$data['total_sections'] = $this->course_model->count_section($data['course']['course_ID']);
		$data['total_lessons'] = $this->course_model->count_lesson($data['course']['course_ID']);
		$data['total_contents'] = $this->course_model->count_content($data['course']['course_ID']);
		$data['my_students'] = $this->purchase_model->get_users_course($data['course']['course_ID']);
		$data['my_courses'] = $this->course_model->get_course($data['course']['user_ID'], NULL, NULL, NULL);

		$data['title'] = ucfirst($data['course']['title']);
		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/course_details', $data);
		$this->load->view('templates/scripts');
	}

	public function course_module($course_slug){
		$this->check_login();
		
		$data['notifications'] = $this->get_notifications();
		$data['settings'] = $this->setting_model->get_settings();
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));
		$data['my_purchases'] = $this->purchase_model->users_course($this->session->userdata('user_id'), '1');
		$data['unseen_chat'] = $this->message_model->message_not_seen($this->session->userdata('user_id'));

		if(empty($data['my_info']['timezone'])){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $data['my_info']['timezone'];
		}

		$data['slug'] = $course_slug;
		$data['course'] = $this->course_model->get_course(NULL, NULL, NULL, NULL, $course_slug);

		$isBought = $this->purchase_model->users_course($this->session->userdata('user_id'), '1', $course_slug);

		if($data['course']['privacy'] == '1' && empty($isBought)){
			$this->session->set_flashdata('error', 'Private!');
			redirect(base_url());
		}

		$data['modules'] = $this->course_model->get_modules($data['course']['course_ID']);
		$data['sections'] = $this->course_model->get_sections();

		$data['title'] = ucfirst($data['course']['title']);
		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/course_modules', $data);
		$this->load->view('templates/scripts');
	}

	public function course_section($course_slug, $module_slug, $section_slug = FALSE){
		$this->check_login();
		
		$data['notifications'] = $this->get_notifications();
		$data['settings'] = $this->setting_model->get_settings();
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));
		$data['my_purchases'] = $this->purchase_model->users_course($this->session->userdata('user_id'), '1');
		$data['unseen_chat'] = $this->message_model->message_not_seen($this->session->userdata('user_id'));

		$purchases = $this->purchase_model->users_course($this->session->userdata('user_id'), '1', $course_slug);
		if(empty($data['my_info']['timezone'])){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $data['my_info']['timezone'];
		}

		$data['course'] = $this->course_model->get_course(NULL, NULL, NULL, NULL, $course_slug);
		$data['module'] = $this->course_model->get_module($module_slug, $data['course']['course_ID']);
		$data['modules'] = $this->course_model->get_modules($data['course']['course_ID']);

		if($section_slug === FALSE) {
			$data['sections'] = $this->course_model->get_sections($data['module']['id']);
			$data['section'] = $this->course_model->get_section($data['sections'][0]['slug'], $data['module']['id']);
		} else {
			$data['section'] = $this->course_model->get_section($section_slug, $data['module']['id']);
			$data['sections'] = $this->course_model->get_sections($data['module']['id']);
		}

		if($data['module']['status'] != '1'){
			$this->session->set_flashdata('error', 'Module is hidden!');
			redirect(base_url().'course/'.$course_slug);
		}	

		$data['lessons'] = $this->course_model->get_lessons($data['section']['id']);
		$data['contents'] = $this->course_model->get_contents();

		if(!$purchases){
			$this->session->set_flashdata('error', 'You did not buy this course!');
 			$data['beginner'] = TRUE;
		} elseif($purchases['purchase_status'] == '1') {
			$data['beginner'] = FALSE;
		} else {
			$this->session->set_flashdata('error', 'Your purchase is still '.$purchases['purchase_status_name']);
 			$data['beginner'] = TRUE;
		}

		$data['title'] = ucfirst($data['module']['title']);
		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav', $data);
		$this->load->view('pages/course_section', $data);
		$this->load->view('templates/scripts');
	}

	public function customer_support(){
		$page = 'help';
		$data['title'] = ucfirst($page);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/scripts');
	}

	public function qaa(){
		$this->check_login();

		$data['notifications'] = $this->get_notifications();
		$data['settings'] = $this->setting_model->get_settings();
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));
		$data['my_purchases'] = $this->purchase_model->users_course($this->session->userdata('user_id'), '1');
		$data['unseen_chat'] = $this->message_model->message_not_seen($this->session->userdata('user_id'));

		if(empty($data['my_info']['timezone'])){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $data['my_info']['timezone'];
		}

		$data['qaas'] = $this->qaa_model->get_qaas();
		$data['categories'] = $this->course_model->get_category();

		$data['title'] = 'Questions and Answers';
		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/qaa', $data);
		$this->load->view('templates/scripts');
	}

	public function maintenance(){
		$settings = $this->setting_model->get_settings();
		if($settings['system_status'] == 1){
			redirect(base_url());
		}

		$data['title'] = 'Maintenance';
		$this->load->view('pages/maintenance', $data);
		$this->load->view('templates/scripts');
	}

	public function messages(){
		$this->check_login();

		$data['notifications'] = $this->get_notifications();
		$data['settings'] = $this->setting_model->get_settings();
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));
		$data['my_purchases'] = $this->purchase_model->users_course($this->session->userdata('user_id'), '1');
		$data['unseen_chat'] = $this->message_model->message_not_seen($this->session->userdata('user_id'));

		if(empty($data['my_info']['timezone'])){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $data['my_info']['timezone'];
		}

		$data['users']  = $this->user_model->get_users();
		$data['title'] = 'Messages';
		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/messages', $data);
		$this->load->view('templates/scripts');
	}

	public function page($page){
		$this->check_login();

		$data['notifications'] = $this->get_notifications();
		$data['settings'] = $this->setting_model->get_settings();
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));
		$data['my_purchases'] = $this->purchase_model->users_course($this->session->userdata('user_id'), '1');
		$data['unseen_chat'] = $this->message_model->message_not_seen($this->session->userdata('user_id'));

		if(empty($data['my_info']['timezone'])){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $data['my_info']['timezone'];
		}

		$data['pages'] = $this->setting_model->get_pages($page);

		if($data['pages']){
			$data['title'] = ucwords($data['pages']['name']);
			$this->load->view('templates/header', $data);
	        $this->load->view('templates/nav', $data);
			$this->load->view('pages/page', $data);
			$this->load->view('templates/scripts');
		} elseif ($data['my_info']['username'] == $page) {
			$data['histories'] = $this->video_model->get_user_videos($this->session->userdata('user_id'));
			$data['posts'] = $this->post_model->get_posts(NULL, 5, 0, '1', 1, $this->session->userdata('user_id'));
			$data['count_posts'] = $this->user_model->count_posts($this->session->userdata('user_id'));
			$data['count_followers'] = $this->user_model->count_followers($this->session->userdata('user_id'));
			$data['count_following'] = $this->user_model->count_following($this->session->userdata('user_id'));
			$data['users'] = $this->user_model->get_users();
			$data['users_course'] = $this->purchase_model->users_course($this->session->userdata('user_id'), '1');
			$data['title'] = 'My profile';
			$data['courses'] = $this->course_model->get_course($this->session->userdata('user_id'), NULL, NULL, NULL);

			$this->load->view('templates/header', $data);
	        $this->load->view('templates/nav', $data);
			$this->load->view('pages/profile', $data);
			$this->load->view('templates/post_scripts');
			$this->load->view('templates/scripts');
		} else {
			$data['user_info'] = $this->user_model->get_users($page);
			$data['posts'] = $this->post_model->get_posts(NULL, 5, 0, '1', 1, $data['user_info']['id']);
			$data['count_posts'] = $this->user_model->count_posts($data['user_info']['id']);
			$data['count_followers'] = $this->user_model->count_followers($data['user_info']['id']);
			$data['count_following'] = $this->user_model->count_following($data['user_info']['id']);
			$data['is_following'] = $this->user_model->is_following($data['user_info']['id'], $this->session->userdata('user_id'));
			$data['users'] = $this->user_model->get_users();
			$data['users_course'] = $this->purchase_model->users_course($data['user_info']['id'], NULL);
			$data['courses'] = $this->course_model->get_course($data['user_info']['id'], NULL, NULL, '1');

			if(empty($data['my_info']['timezone'])){
				$data['timezone'] = 'UTC';
			} else {
				$data['timezone'] = $data['my_info']['timezone'];
			}

			$data['title'] = ucwords($data['user_info']['first_name'].' '.$data['user_info']['last_name']);
			$this->load->view('templates/header', $data);
	        $this->load->view('templates/nav', $data);
			$this->load->view('pages/profile_view', $data);
			$this->load->view('templates/post_scripts');
			$this->load->view('templates/scripts');
		}
	}

	public function post($username, $post_id){
		$this->check_login();

		$data['notifications'] = $this->get_notifications();
		$data['settings'] = $this->setting_model->get_settings();
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));
		$data['my_purchases'] = $this->purchase_model->users_course($this->session->userdata('user_id'), '1');
		$data['unseen_chat'] = $this->message_model->message_not_seen($this->session->userdata('user_id'));

		if(empty($data['my_info']['timezone'])){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $data['my_info']['timezone'];
		}

		$data['users'] = $this->user_model->get_users();
		$data['post'] = $this->post_model->get_post($post_id);

		if(!$data['post']){
			$this->session->set_flashdata('error', 'Posts has been deleted!');
			redirect('');
		}

		if($data['post']['status'] != '1' && $this->session->userdata('user_id') != $data['post']['user_ID']){
			$this->session->set_flashdata('error', 'This post has been Denied to view in public!');
			redirect('');
		}

		$data['title'] = 'View post';
		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/profile_post', $data);
		$this->load->view('templates/post_scripts');
		$this->load->view('templates/scripts');
	}

	public function post_edit($username, $post_id){
		$this->check_login();

		$data['notifications'] = $this->get_notifications();
		$data['settings'] = $this->setting_model->get_settings();
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));
		$data['my_purchases'] = $this->purchase_model->users_course($this->session->userdata('user_id'), '1');
		$data['unseen_chat'] = $this->message_model->message_not_seen($this->session->userdata('user_id'));

		if(empty($data['my_info']['timezone'])){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $data['my_info']['timezone'];
		}

		$data['users'] = $this->user_model->get_users();
		$data['post'] = $this->post_model->get_post($post_id);
		$data['files'] = $this->post_model->get_post_files($post_id);

		if($data['post']['user_ID'] != $this->session->userdata('user_id')){
			$this->session->set_flashdata('error', 'You are not the owner of the post');
			redirect('');
		}

		$courses = $this->post_model->get_post_to_course($post_id);
		$all_courses = array();
		foreach ($courses as $course) {
			$all_courses[] = ($course['course_ID'] == "") ? '0' : $course['course_ID'];
		}

		$data['post_to_courses'] = $all_courses;
		$data['title'] = 'Edit post';
		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/profile_post_edit', $data);
		$this->load->view('templates/scripts');
	}

	public function rankings(){
		$this->check_login();

		$data['notifications'] = $this->get_notifications();
		$data['settings'] = $this->setting_model->get_settings();
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));
		$data['my_purchases'] = $this->purchase_model->users_course($this->session->userdata('user_id'), '1');
		$data['unseen_chat'] = $this->message_model->message_not_seen($this->session->userdata('user_id'));

		if(empty($data['my_info']['timezone'])){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $data['my_info']['timezone'];
		}

		$data['ranks'] = $this->user_model->get_rankings();
		$data['levels'] = $this->user_model->get_levels();
		$data['rankings'] = $this->user_model->rankings();

		$data['title'] = 'Rankings';
		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/rankings', $data);
		$this->load->view('templates/scripts');
	}

	public function support(){
		$this->check_login();

		$data['notifications'] = $this->get_notifications();
		$data['settings'] = $this->setting_model->get_settings();
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));
		$data['my_purchases'] = $this->purchase_model->users_course($this->session->userdata('user_id'), '1');
		$data['unseen_chat'] = $this->message_model->message_not_seen($this->session->userdata('user_id'));

		if(empty($data['my_info']['timezone'])){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $data['my_info']['timezone'];
		}

		$data['title'] = 'Support';
		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/support', $data);
		$this->load->view('templates/scripts');
	}

	public function search(){
		$this->check_login();

		$data['notifications'] = $this->get_notifications();
		$data['settings'] = $this->setting_model->get_settings();
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));
		$data['my_purchases'] = $this->purchase_model->users_course($this->session->userdata('user_id'), '1');
		$data['unseen_chat'] = $this->message_model->message_not_seen($this->session->userdata('user_id'));

		if(empty($data['my_info']['timezone'])){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $data['my_info']['timezone'];
		}

		$data['courses'] = $this->course_model->search_course($this->input->get('search'), 0, 0);
		$data['modules'] = $this->course_model->search_module($this->input->get('search'), 0, 0);
		$data['sections'] = $this->course_model->search_section($this->input->get('search'), 0, 0);
		$data['lessons'] = $this->course_model->search_lesson($this->input->get('search'), 0, 0);
		$data['contents'] = $this->course_model->search_content($this->input->get('search'), 0, 0);
		$data['qaas'] = $this->qaa_model->search_qaas($this->input->get('search'), 0, 0);
		$blogs = $this->blog_model->search_blog($this->input->get('search'), 0, 0);
		$data['users'] = $this->user_model->search_user($this->input->get('search'), 0, 0);
		$posts = $this->post_model->search_post($this->input->get('search'), 0, 0); 
		$data['total_results'] = count($data['courses']) + count($data['modules']) + count($data['sections']) + count($data['lessons']) + count($data['contents']) + count($data['qaas']) + count($blogs) + count($data['users']) + count($posts);

		$all = array();
		foreach ($data['courses'] as $row) {
			$all[] = array(
				'result' => ucwords($row['title']),
				'url' => base_url().'course/detail/'.$row['slug'],
				'timestamp' => $this->time_elapsed_string($row['date_created']),
				'type' => 'course',
			);
		}

		foreach ($data['modules'] as $row) {
			$all[] = array(
				'result' => ucfirst($row['title']),
				'url' =>  base_url().'course/'.$row['course_slug'].'/'.$row['module_slug'],
				'timestamp' =>  $this->time_elapsed_string($row['date_modified']),
				'type' => 'module',
			);
		}

		foreach ($data['sections'] as $row) {
			$all[] = array(
				'result' => ucfirst($row['title']),
				'url' => base_url().'course/'.$row['course_slug'].'/'.$row['module_slug'].'/'.$row['section_slug'],
				'timestamp' =>  $this->time_elapsed_string($row['date_modified']),
				'type' => 'section',
			);
		}

		foreach ($data['lessons'] as $row) {
			$all[] = array(
				'result' => ucfirst($row['title']),
				'url' => base_url().'course/'.$row['course_slug'].'/'.$row['module_slug'].'/'.$row['section_slug'].'#lesson-'.$row['id'],
				'timestamp' =>  $this->time_elapsed_string($row['date_modified']),
				'type' => 'lesson',
			);
		}

		foreach ($data['contents'] as $row) {
			$all[] = array(
				'result' => ucfirst($row['title']),
				'url' => base_url().'course/'.$row['course_slug'].'/'.$row['module_slug'].'/'.$row['section_slug'].'#'.$row['id'],
				'timestamp' =>  $this->time_elapsed_string($row['date_modified']),
				'type' => 'content',
			);
		}

		foreach ($data['qaas'] as $row) {
			$all[] = array(
				'result' => ucfirst($row['question']),
				'url' => NULL,
				'timestamp' =>  $this->time_elapsed_string($row['timestamp']),
				'type' => 'question & answer',
			);
		}

		foreach ($data['users'] as $row) {
			$all[] = array(
				'result' => ucwords($row['first_name']).' '.ucwords($row['last_name']),
				'url' =>  base_url().''.$row['username'],
				'timestamp' =>  $this->time_elapsed_string($row['date_created']),
				'type' => 'user',
			);
		}

		$post = array();
	    foreach($posts as $row){
			$total_likes = $this->post_model->total_likes($row['post_ID']);
			$total_comments = $this->post_model->total_comments($row['post_ID']);
			$images = $this->post_model->get_post_files($row['post_ID']);
			$courses = $this->post_model->get_post_to_course($row['post_ID']);
			$all_images = array();
			$all_courses = array();

			foreach ($courses as $course) {
				$all_courses[] = array(
					'course_title' =>  ($course['title'] == "") ? 'Global' : ucfirst($course['title']),
				);
			}

			foreach ($images as $image) { 
				$filename = './assets/img/posts/thumbs/'.hash('md5', $image['user_ID']).'/'.$image['file'];
				$all_images[] = array(
					'src' => './assets/img/posts/'.hash('md5', $image['user_ID']).'/'.$image['file'],
					'srct' => is_file($filename) ? $filename :  './assets/img/posts/thumbs/play_button.jpg',
					'description' =>  $image['description']
				);
			}

			// Avoid duplicate nanogallery
			$numbers = rand(-100000,1000000).$row['post_ID'];

			$post[] = array(
				'title' => $all_courses,
				'numbers' => $numbers,
				'post_ID' => $row['post_ID'],
				'post_status' => $row['post_status'],
				'post' => $row['post'],
				'image' => base_url().'assets/img/users/thumbs/'.$row['image'],
				'all_images' =>  !empty($images) ? '<script>nanogallery('.$numbers.', '.json_encode($all_images).');</script>' : '',
				'user_ID' => $row['user_ID'],
				'username' => $row['username'],
				'first_name' => ucwords($row['first_name']),
				'last_name' => ucwords($row['last_name']),
				'total_likes' => $total_likes,
				'total_comments' => $total_comments,
				'timestamp' => $row['timestamp'],
			);

			$all[] = array(
				'result' => ucfirst($row['post']),
				'url' => base_url().$row['username'].'/posts/'.$row['post_ID'],
				'timestamp' =>  $this->time_elapsed_string($row['timestamp']),
				'type' => 'post',
			);
	    }

	    $blog = array();
	    foreach($blogs as $row){
			$categories = $this->blog_model->get_blog_to_categories($row['id']);
			$blog_categories = array();
			foreach ($categories as $blog_category) {
				$blog_categories[] = array(
					'category' =>  ucwords($blog_category['name']),
				);
			}

			$blog[] = array(
				'categories' => $blog_categories,
				'title' => ucwords($row['title']),
				'slug' => $row['slug'],
				'description' => substr(ucfirst(strip_tags($row['content'])), 0, 300),
				'banner' => $row['banner'],
				'timestamp' =>  date("F d, Y", strtotime($row['timestamp'])),
			);

			$all[] = array(
				'result' => ucfirst($row['title']),
				'url' => 'https://www.studying.com/'.$row['slug'],
				'timestamp' =>  $this->time_elapsed_string($row['timestamp']),
				'type' => 'blog',
			);
	    }
			
		$data['blogs'] = $blog;
		$data['posts'] = $post;
		$data['all'] = $all;
		$data['title'] = 'Search';
		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/search', $data);
		$this->load->view('templates/scripts');
	}

	
	public function tools(){
		$this->check_login();

		$data['notifications'] = $this->get_notifications();
		$data['settings'] = $this->setting_model->get_settings();
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));
		$data['my_purchases'] = $this->purchase_model->users_course($this->session->userdata('user_id'), '1');
		$data['unseen_chat'] = $this->message_model->message_not_seen($this->session->userdata('user_id'));

		if(empty($data['my_info']['timezone'])){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $data['my_info']['timezone'];
		}

		$data['products'] = $this->rated_product_model->search_products(NULL, 12, $this->input->post('tools'));
		$data['images'] = $this->rated_product_model->get_images();
		$data['product_name'] = $this->input->post('tools');

		$data['title'] = 'Dropshipping tools';
		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/tools', $data);
		$this->load->view('templates/scripts');
	}

	public function login(){
		$page = 'login';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->setting_model->get_settings();

		$settings = $this->setting_model->get_settings();
		if($settings['system_status'] == 0){
			redirect('maintenance');
		}

		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');

        if($this->form_validation->run() === FALSE){
	        $this->load->view('pages/'.$page, $data);
        } else {
            $user_id = $this->user_model->login($this->input->post('email'), $this->input->post('password'));
            if($user_id['status'] == '0'){
            	$this->session->set_flashdata('error', 'Your account has been disabled!');
                redirect('login');
            }
            if($user_id){
            	$this->load->helper('cookie');
                $user_data = array(
                    'user_id' => $user_id['id'],
                    'email' => $user_id['email'],
                    'first_name' => $user_id['first_name'],
                    'last_name' => $user_id['last_name'],
                    'user_logged_in' => true
                );
                $this->session->set_userdata($user_data);
                setcookie('user_id', hash('md5', $user_id['id']), time() + (86400 * 30 * 30), "/");

                $this->user_model->start_daily_login_reward($user_id['id']);

                $this->session->set_flashdata('success', 'You are now logged in');
                redirect(base_url());
            } else {
                $this->session->set_flashdata('error', 'Invalid Email/Password');
                redirect('login');
            }       
        }
	}

	public function become_an_instructor(){
		$this->check_login();
		
		$data['notifications'] = $this->get_notifications();
		$data['settings'] = $this->setting_model->get_settings();
		$data['my_info'] = $this->user_model->get_users($this->session->userdata('user_id'));
		$data['my_purchases'] = $this->purchase_model->users_course($this->session->userdata('user_id'), '1');
		$data['unseen_chat'] = $this->message_model->message_not_seen($this->session->userdata('user_id'));
		$data['role_status'] = $this->user_model->get_request_as_instructor(NULL, $this->session->userdata('user_id'));

		if($data['settings']['system_status'] == 0){
			redirect('maintenance');
		}
		
		if(empty($data['my_info']['timezone'])){
			$data['timezone'] = 'UTC';
		} else {
			$data['timezone'] = $data['my_info']['timezone'];
		}

		$data['title'] = 'Become an Instructor';
		$this->load->view('templates/header', $data);
        $this->load->view('templates/nav', $data);
		$this->load->view('pages/become_an_instructor', $data);
		$this->load->view('templates/scripts');
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
        $this->form_validation->set_rules('username', 'username', 'alpha_dash');
        $this->form_validation->set_rules('password', 'password', 'required');
        $this->form_validation->set_rules('confirm_password', 'confirm password', 'required|matches[password]');

        if($this->form_validation->run() === FALSE){
        	$this->session->set_flashdata('multi',validation_errors());
	        $this->load->view('pages/'.$page, $data);
        } else {
            $user = $this->user_model->get_users($this->input->post('email'));
            if($user > 0){
     			$this->session->set_flashdata('error', 'Email already exist!');
     			redirect('register');
			} else {
				if(empty($this->input->post('username'))){
					$username = str_replace(' ', '', $this->input->post('first_name')).str_replace(' ', '', $this->input->post('last_name')).date("h-i-s");
				} else {
					$username = $this->input->post('username');
				}
				$new_user = array(
					'username' => $username,
                    'email' => $this->input->post('email'),
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'password' => $this->input->post('password'),
                    'role' => $this->input->post('role'),
                    'timezone' => $this->input->post('timezone'),
                    'page' => '0'
                );
                $this->session->set_userdata($new_user);
				$this->send_verification();
			}
        }
	}

	public function verify_email(){
		$data['title'] = ucwords('Email verification.');
		$data['email'] = $this->session->userdata('email');
		$data['page'] = $this->session->userdata('page');
        $this->load->view('pages/verify_email', $data);
	}

	public function forgot_password(){
		$data['title'] = ucwords('Update Profile');
        $this->load->view('pages/forgot-password', $data);
	}

	function verify(){
		$create = $this->user_model->verify($this->session->userdata('email'), $this->input->post('verify'));
		if($create){
			if($this->session->userdata('page') == 0){
				$this->user_model->register($this->session->userdata('email'), $this->session->userdata('username'), $this->session->userdata('first_name'), $this->session->userdata('last_name'), $this->session->userdata('password'), $this->session->userdata('role'), $this->session->userdata('timezone'));

				$this->load->library('active_campaign');
        		$ac = $this->active_campaign->load();

        		$contact = array(
		            "email"              => $this->session->userdata('email'),
		            "first_name"         => $this->session->userdata('first_name'),
		            "last_name"          => $this->session->userdata('last_name'),
		            "tags"              => 'Studying.com User',
		            "p[3]"      => '3',
		          );

          		$response = $ac->api("contact/sync", $contact);

				$this->session->set_flashdata('success', 'Register successfully!');
			} else {
				$this->user_model->change_password($this->input->post('email'), 'studying');
				$this->session->set_flashdata('success', 'Your password has been reset to studying.');
			}
			redirect('login');
		} else {
			$this->session->set_flashdata('error', 'Wrong verification code.');
			redirect('verify');
		}
    }

	function send_verification(){
        $verification_code = '0123456789';
        $verification_code = str_shuffle($verification_code);
        $verification_code = substr($verification_code, 0, 5);

        $this->load->library('phpmailer_lib');
        if(empty($this->session->userdata('email'))){
        	$new_user = array(
                'email' => $this->input->post('email'),
                'page' => '1'
            );
		    $this->session->set_userdata($new_user);
        	$email = $this->input->post('email');
        } else {
        	$email = $this->session->userdata('email');
        }
        // PHPMailer object
        $mail = $this->phpmailer_lib->load();
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com'; // Which SMTP server to use.
        $mail->Port = 587; // Which port to use, 587 is the default port for TLS security.
        $mail->SMTPAuth = true; // Whether you need to login. This is almost always required.
        $mail->Username = 'support@studying.com';
        $mail->Password = '4;XT01Bem';
        $mail->setFrom('support@studying.com', 'Studying Support');
        $mail->addAddress($email); 
        if($this->session->userdata('page') == 0){
            $mail->Subject = "Email Verification";
            $mail->Body = " Your Verification Code:

            $verification_code

            ";
        } else {
            $mail->Subject = "Reset Password";
            $mail->Body = " Your Verification Code:

            $verification_code

            NOTE: Once you verified your email, Your password will reset to studying.";
        }

        if($mail->send()){
            $create = $this->user_model->create_verification($email, $verification_code);
            $this->session->set_flashdata('success', 'Verification code sent to your email!');
            redirect('verify');
        } else {
            $this->session->set_flashdata('error', 'Error occured! Please truy again later.');
       }
    }

    function send_message(){
        $this->load->library('phpmailer_lib');
        // PHPMailer object
        $mail = $this->phpmailer_lib->load();
        $email = $this->input->post('email');
        $message = $this->input->post('message');
        $fullname = $this->input->post('full_name');
        
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com'; // Which SMTP server to use.
        $mail->Port = 587; // Which port to use, 587 is the default port for TLS security.
        $mail->SMTPAuth = true; // Whether you need to login. This is almost always required.
        $mail->Username = 'support@studying.com';
        $mail->Password = '4;XT01Bem';
        $mail->setFrom('support@studying.com', 'Studying Support');
        $mail->addReplyTo($email, $fullname);
        $mail->addAddress('consulting@andymai.org'); 
        $mail->Subject = "Customer Support";
        $mail->Body = "$message

        Do not replay here.
        This message is sent by $email. Using the support page.
        Please replay to: $email";

        if($mail->send()){
            $this->session->set_flashdata('success', 'Message Sent!');
        } else {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
       }
    }

	function rating(){
		$data = $this->review_model->get_review('1', NULL, NULL, 0, $this->session->userdata('user_id'));
        echo json_encode($data);
	}

	function send_rating(){
		$create = $this->review_model->create_review(0, 1, $this->input->post('feedback_rating'), $this->input->post('feedback'), $this->session->userdata('user_id'));
		$this->session->set_flashdata('success', 'Thank You for your feedback. :)');
		$this->logout();
	}

	function music(){
		if($this->input->post('id') == 1){
			$this->session->set_userdata('music_status', '1');
		} else {
			$this->session->unset_userdata('music_status');
		}
		echo json_encode($this->input->post('id'));
	}

	public function logout(){
		$this->user_model->logout($this->session->userdata('email'));
        $this->session->unset_userdata('user_logged_in');
        $this->session->unset_userdata($user_data);
        $this->session->sess_destroy();
        unset($_COOKIE['user_id']); 
        setcookie('user_id', null, -1, '/'); 
        $this->session->set_flashdata('success', 'You are now logged out');
        redirect('login');
	}

	function timezone()	{
		$data = $this->user_model->insert_timezone($this->input->post('timezone'), $this->session->userdata('user_id'));
		$this->session->set_userdata('timezone', $this->input->post('timezone'));
		echo json_encode($data);
	}

	function button_press()	{
		$data = $this->user_model->button_press($this->input->post('id'), $this->session->userdata('user_id'));
		echo json_encode($data);
	}

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
				if(!$sql_2){
					$post = 'Post has been deleted!';
				} else {
					$id = $row['id'];
					$post = $sql_2['post'];
				}
			} elseif($row['type'] == 2){
				$sql_2 = $this->post_model->get_comment($row['id']);
				if(!$sql_2){
					$post = 'Comment has been deleted!';
				} else {
					$id = $sql_2['post_ID'];
					$post = str_replace(array('<p>', '</p>'), array('"', '"'), $sql_2['comment']);
				}
			} elseif($row['type'] == 3){
				$sql_2 = $this->message_model->get_group_message($row['id']);
				if(!$sql_2){
					$post = 'Message has been deleted!';
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
				$notification = ucwords($row['first_name']).' '.ucwords($row['last_name']).' mentions you in a group chat '.ucwords($sql_2['group_name']);
			} elseif($row['notification_name_id'] == 11) {
				$notification = ucwords($row['first_name']).' '.ucwords($row['last_name']).' follows you';
			} elseif($row['notification_name_id'] == 12) {
				$notification = 'Congratulations! You have been approve as an Instructor.';
			} elseif($row['notification_name_id'] == 13) {
				$notification = 'Sorry! Your application as an Instructor has been denied.';
			} elseif($row['notification_name_id'] == 14) {
				$notification = 'Your purchase has been approved.';
			} elseif($row['notification_name_id'] == 15) {
				$notification = 'Your purchase has been denied.';
			}

			$data[] = [
				'id' => $id,
				'notification_name' => $notification,
				'timestamp' => $this->time_elapsed_string($row['timestamp']),
				'user_ID' => $row['username'],
				'username' => $this->session->userdata('username'),
				'image' => $row['image'],
				'seen' => $row['status'],
				'type' => $row['type'],
				'post' => $post
			];			
		}
		return $data;
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