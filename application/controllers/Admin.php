<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	function check_session(){
		if(!$this->session->userdata('admin_logged_in')){
			redirect('admin/login');
		}

	}

	public function index()	{
		$this->check_session();
		$page = 'home';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];

		$data['settings'] = $this->setting_model->get_settings();

		//$data['datas'] = $this->admin_model->summary();
		// $data['programs'] = $this->admin_model->enrolled_programs();
		// $data['yearly_sales'] = json_encode(array_values($data['datas']['yearly_sales']));
		// $data['year'] = json_encode(array_values($data['datas']['year']));
		// $data['monthly_sales'] = json_encode(array_values($data['datas']['monthly_sales']));
		// $data['month'] = json_encode(array_values($data['datas']['month']));
		
		$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/index', $data);
		$this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
	}

	public function admins() {
		$this->check_session();
		$page = 'admins';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
		$data['settings'] = $this->setting_model->get_settings();

		if($data['admin_status'] != 2){
			$this->session->set_flashdata('error', 'You are not allowed here!');
			redirect('admin');
		}
		$data['admins'] = $this->admin_model->get_admins();
		
		$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/'.$page, $data);
		$this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
	}

	public function blog()	{
		$this->check_session();
		$page = 'blogs';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
		$data['settings'] = $this->setting_model->get_settings();
		$data['blogs'] = $this->blog_model->get_blogs();
		
		$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/blog', $data);
		$this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
	}

	public function blog_archive()	{
		$this->check_session();
		$page = 'blogs';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
		$data['settings'] = $this->setting_model->get_settings();
		
		$data['blogs'] = $this->blog_model->get_blogs();
		
		$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/blog_archive', $data);
		$this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
	}

	public function create_blog(){
		$this->check_session();
		$page = 'blogs';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
		$data['settings'] = $this->setting_model->get_settings();
		$data['categories'] = $this->blog_model->get_category();
		
		$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/blog_create', $data);
		$this->load->view('templates/admin/footer');
		$this->load->view('templates/admin/scripts');
	}

	public function edit_blog($id){
		$this->check_session();
		$page = 'blogs';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
		$data['settings'] = $this->setting_model->get_settings();
		$data['blog'] = $this->blog_model->get_blogs($id);
		$data['blog_categories'] = $this->blog_model->get_blog_to_categories($id);
		$data['categories'] = $this->blog_model->get_category();
		$data['files'] = $this->blog_model->get_files($id);
		
		$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/blog_edit', $data);
		$this->load->view('templates/admin/footer');
		$this->load->view('templates/admin/scripts');
	}

	public function category(){
		$this->check_session();
		$page = 'category';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
		$data['settings'] = $this->setting_model->get_settings();
		$data['categories'] = $this->blog_model->get_category();
		
		$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/category', $data);
		$this->load->view('templates/admin/footer');
		$this->load->view('templates/admin/scripts');
	}

	public function course() {
		$this->check_session();
		$page = 'course';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
		$data['settings'] = $this->setting_model->get_settings();
		$data['courses'] = $this->course_model->get_course(NULL, NULL, NULL, NULL);
		$data['categories'] = $this->course_model->get_category();
		
		$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/'.$page, $data);
        $this->load->view('templates/admin/footer');
		$this->load->view('templates/admin/scripts');
	}

	public function course_archive() {
		$this->check_session();
		$page = 'course';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
		$data['settings'] = $this->setting_model->get_settings();
		$data['courses'] = $this->course_model->get_course(NULL, NULL, NULL, NULL);
		$data['categories'] = $this->course_model->get_category();
		
		$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/course_archive', $data);
        $this->load->view('templates/admin/footer');
		$this->load->view('templates/admin/scripts');
	}

	public function course_modules($slug){
		$this->check_session();
		$page = 'course';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
		$data['settings'] = $this->setting_model->get_settings();
		$data['course'] = $this->course_model->get_course(NULL, NULL, NULL, NULL, $slug);
		$data['modules'] = $this->course_model->get_modules($data['course']['course_ID']);
				
				$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/course-modules', $data);
		$this->load->view('templates/admin/footer');
		$this->load->view('templates/admin/scripts');
	}

	public function create_content($course_slug, $module_slug){
		$this->check_session();
		$page = 'course';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
		$data['settings'] = $this->setting_model->get_settings();
		$data['course'] = $this->course_model->get_course(NULL, NULL, NULL, NULL, $course_slug);
		$data['module'] = $this->course_model->get_module($module_slug, $data['course']['course_ID']);
		$data['sections'] = $this->course_model->get_sections($data['module']['id']);
		$data['lessons'] = $this->course_model->get_lessons();
		$data['contents'] = $this->course_model->get_contents();
		
		$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/course-create-content', $data);
		$this->load->view('templates/admin/footer');
		$this->load->view('templates/admin/scripts');
	}

	public function instructor(){
		$this->check_session();
		$page = 'Instructors';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
		$data['settings'] = $this->setting_model->get_settings();

		$data['instructors'] = $this->user_model->get_request_as_instructor(NULL);
		
		$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/instructors', $data);
		$this->load->view('templates/admin/footer');
		$this->load->view('templates/admin/scripts');
	}

	public function media()	{
		$this->check_session();
		$page = 'media';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
		$data['settings'] = $this->setting_model->get_settings();
		
		$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/media', $data);
		$this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
	}

	public function order()	{
		$this->check_session();
		$page = 'Order';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
		$data['settings'] = $this->setting_model->get_settings();

		$data['orders'] = $this->purchase_model->get_users_course(NULL);
		
		$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/order', $data);
		$this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
	}

	public function rated_product() {
        $this->check_session();
        $page = 'rated products';
        $data['title'] = ucwords($page);
        $admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
        $data['settings'] = $this->setting_model->get_settings();
        $data['products'] = $this->rated_product_model->get_all_products(NULL, 0, FALSE);
		
		$data['timezone'] = $this->session->userdata('timezone');
        $this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
        $this->load->view('admin/rated-products', $data);
        $this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
    }

    public function update_rated_product($id) {
        $this->check_session();
        $page = 'rated products';
        $data['title'] = ucwords($page);
        $admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
        $data['settings'] = $this->setting_model->get_settings();

        $data['product'] = $this->rated_product_model->get_all_products(NULL, 0, $id);
        $data['images'] = $this->rated_product_model->get_images($id);
		
		$data['timezone'] = $this->session->userdata('timezone');
        $this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
        $this->load->view('admin/rated-products-edit', $data);
        $this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
    }

	public function reviews()	{
		$this->check_session();
		$page = 'reviews';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
		$data['settings'] = $this->setting_model->get_settings();
		if($data['admin_status'] != 2){
			$this->session->set_flashdata('error', 'You are not allowed here!');
			redirect('admin');
		}
		$data['softwares'] = $this->review_model->get_reviews(1);
		$data['instructors'] = $this->review_model->get_reviews(2);
		$data['courses'] = $this->review_model->get_reviews(3);
		$data['contents'] = $this->review_model->get_reviews(4);
		
		$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/review', $data);
		$this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
	}

	public function post($post_id){
		$this->check_session();
		$page = 'posts';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
		$data['settings'] = $this->setting_model->get_settings();
		$data['post'] = $this->post_model->get_post($post_id);
		
		$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/post_view', $data);
        $this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
	}

	public function posts()	{
		$this->check_session();
		$page = 'posts';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
		$data['settings'] = $this->setting_model->get_settings();
		$data['posts'] = $this->post_model->get_posts(NULL, 0, 0, NULL, NULL);
				
				$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/'.$page, $data);
        $this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
	}

	public function settings(){
		$this->check_session();
		
		$page = 'settings';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
		$data['settings'] = $this->setting_model->get_settings();
		$data['pages'] = $this->setting_model->get_pages();
		
		$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/'.$page, $data);
		$this->load->view('templates/admin/scripts');
        $this->load->view('templates/admin/footer');
	}

	public function update_settings($id){
		$this->check_session();

		$page = 'settings';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
		$data['settings'] = $this->setting_model->get_settings();
		$data['pages'] = $this->setting_model->get_pages($id);
		
		$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/settings-edit', $data);
		$this->load->view('templates/admin/scripts');
        $this->load->view('templates/admin/footer');
	}
	public function support()	{
		$this->check_session();
		$page = 'support';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
		$data['settings'] = $this->setting_model->get_settings();
		if($data['admin_status'] != 2){
			$this->session->set_flashdata('error', 'You are not allowed here!');
			redirect('admin');
		}
		$data['messages'] = $this->support_model->get_messages();
		
		$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/'.$page, $data);
		$this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
	}

	public function studying_review()	{
		$this->check_session();
		$page = 'Studying';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
		$data['settings'] = $this->setting_model->get_settings();
		$data['reviews'] = $this->studying_review_model->get_reviews();
		
		$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/studying_review', $data);
		$this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
	}

	public function edit_studying_review($id){
		$this->check_session();
		$page = 'Studying';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
		$data['settings'] = $this->setting_model->get_settings();
		$data['reviews'] = $this->studying_review_model->get_reviews($id);
		
		$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/studying_review_edit', $data);
		$this->load->view('templates/admin/footer');
		$this->load->view('templates/admin/scripts');
	}

	public function qaa()	{
		$this->check_session();
		$page = 'Question & Answer Mastersheet';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
		$data['settings'] = $this->setting_model->get_settings();
		$data['qaas'] = $this->qaa_model->get_qaas();
		$data['categories'] = $this->course_model->get_category();
		
		$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/qaa', $data);
		$this->load->view('templates/admin/footer');
		$this->load->view('templates/admin/scripts');
	}

	public function users()	{
		$this->check_session();
		$page = 'users';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
		$data['settings'] = $this->setting_model->get_settings();
		$data['clients'] = $this->user_model->get_users();
		$data['courses'] = $this->course_model->get_course(NULL, NULL, NULL, '1');
		$data['daily_logins'] = $this->user_model->daily_logins();
		
		$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/'.$page, $data);
        $this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
	}

	public function user_profile($id){
		$this->check_session();

		$page = 'users';
		$data['title'] = ucfirst($page);
		$admin =  $this->admin_model->get_admins($this->session->userdata('admin_id'));
		$data['first_name'] = $admin['first_name'];
		$data['last_name'] = $admin['last_name'];
		$data['admin_id'] = $this->session->userdata('admin_id');
		$data['admin_status'] = $admin['position'];
		$data['settings'] = $this->setting_model->get_settings();
		$data['all_courses'] = $this->course_model->get_course(NULL, NULL, NULL, '1');
		$data['users'] = $this->user_model->get_users($id);
		$data['videos'] = $this->video_model->get_user_videos($id);
		$data['users_course'] = $this->purchase_model->users_course($id, NULL);
		$data['courses'] = $this->course_model->get_course($id, NULL, NULL, NULL);
		$data['order_status'] = $this->purchase_model->get_purchase_status();
		
		$data['timezone'] = $this->session->userdata('timezone');
		$this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/nav', $data);
		$this->load->view('admin/users_profile', $data);
        $this->load->view('templates/admin/footer');
        $this->load->view('templates/admin/scripts');
	}

	public function login(){
		$page = 'login';
		$data['title'] = ucfirst($page);
		$data['settings'] = $this->setting_model->get_settings();

		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');

        if($this->form_validation->run() === FALSE){
           	$this->load->view('templates/admin/header', $data);
			$this->load->view('admin/'.$page, $data);
			$this->load->view('templates/admin/scripts');
        } else {
            $admin_id = $this->admin_model->login($this->input->post('email'), $this->input->post('password'));
            if($admin_id['status'] == '0'){
            	$this->session->set_flashdata('error', 'Your account has been disabled!');
                redirect('admin/login');
            }

            if($admin_id){
                $admin_data = array(
                    'admin_id' => $admin_id['id'],
                    'email' => $admin_id['email'],
                    'admin_logged_in' => true
                );
                setcookie('admin_logged_in', 1, time() + (86400 * 30 * 30), "/");
                $this->session->set_userdata($admin_data);
                $this->session->set_flashdata('success', 'You are now logged in');
                redirect('admin/index');
            } else {
                $this->session->set_flashdata('error', 'Invalid Email/Password');
                redirect('admin/login');
            }       
        }
	}

	public function logout(){
        $this->session->unset_userdata('admin_logged_in');
        $this->session->unset_userdata('admin_id');
        $this->session->unset_userdata($admin_data);
        unset($_COOKIE['admin_logged_in']);
        setcookie('admin_logged_in', null, -1, '/'); 
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'You are now logged out');
        redirect('admin/login');
	}

	function create_admin() {
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('new_password', 'Password', 'required');
        $this->form_validation->set_rules('cnew_Password', 'confirm password', 'required|matches[new_password]');
        $this->form_validation->set_rules('first_name', 'First name', 'required');
        $this->form_validation->set_rules('last_name', 'last name', 'required');
        $this->form_validation->set_rules('position', 'Position', 'required');

	    if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('multi',validation_errors());
	        redirect('admin/admins');
	    } else {
			$create = $this->admin_model->create_admin($this->input->post('email',TRUE), $this->input->post('new_password',TRUE), $this->input->post('first_name',TRUE), $this->input->post('last_name',TRUE), $this->input->post('position',TRUE));
			if($create){
				$this->session->set_flashdata('success', 'Admin Created Successfully');
			} else {
				$this->session->set_flashdata('error', 'Email already exist');
			}
			redirect('admin/admins');
	    }
	}

	function update_admin() {
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('first_name', 'First name', 'required');
        $this->form_validation->set_rules('last_name', 'last name', 'required');
        $this->form_validation->set_rules('position', 'Position', 'required');

	    if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('multi',validation_errors());
	        redirect('admin/admins');
	    } else {
			if(empty($this->input->post('status', TRUE))){
				$status = '0';
			} else {
				$status = $this->input->post('status', TRUE);
			}
			$create = $this->admin_model->update_admin($this->input->post('admin_ID',TRUE), $this->input->post('email'), $this->input->post('first_name',TRUE), $this->input->post('last_name',TRUE), $status, $this->input->post('position',TRUE));
			if($create){
				$this->session->set_flashdata('success', 'Admin updated Successfully');
			} else {
				$this->session->set_flashdata('error', 'Email already exist');
			}
			redirect('admin/admins');
	    }
	}

	function change_password() {
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('current_password', 'Current Password', 'required');
        $this->form_validation->set_rules('new_password', 'new password', 'required');
        $this->form_validation->set_rules('confirm_new_password', 'confirm password', 'required|matches[new_password]', array('matches' => 'Password not match'));
	    if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('multi',validation_errors());
	        redirect('admin/settings');
	    } else {
			$current_password = $this->input->post('current_password');
			$new_password = $this->input->post('new_password');
			$confirm_new_password = $this->input->post('confirm_new_password');
			$user = $this->admin_model->get_admins($this->session->userdata('email'));

			if(!password_verify($current_password, $user['password'])){
				$this->session->set_flashdata('error', 'Invalid current password');
			} else {
				$create = $this->admin_model->change_password($new_password, $this->session->userdata('email'));
				if($create){
					$this->session->set_flashdata('success', 'Password changed Successfully');
				}
			}
			redirect('admin/settings');
	    }
	}

	function new_messages() {
		$data = $this->support_model->new_messages();
		echo json_encode($data);
	}

	function seen() {
		$data = $this->support_model->seen();
		echo json_encode($data);
	}

	function change_review_post_status(){
	   	$data = $this->setting_model->change_review_post_status($this->input->post('review_status'));
		redirect('admin/settings');
	}

	function change_system_status(){
	   	$data = $this->setting_model->change_system_status($this->input->post('system_status'));
		redirect('admin/settings');
	}

	function timezone()	{
		$this->session->set_userdata('timezone', $this->input->post('timezone'));
		echo json_encode($data);
	}
}