<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Courses extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('upload');
	}

	function get_course(){
		$data = $this->course_model->get_course(NULL, NULL, NULL, $this->input->post('course_ID'));
		echo json_encode($data);
	}

	function get_courses(){
		$data = $this->course_model->get_course($this->session->userdata('user_id'), NULL, NULL, NULL);
		echo json_encode($data);
	}

	function get_module(){
		$data = $this->course_model->get_module($this->input->post('module_ID'));
		echo json_encode($data);
	}

	function get_modules(){
		$data = $this->course_model->get_modules($this->input->post('course_ID'));
		echo json_encode($data);
	}

	function get_sections(){
		$data = $this->course_model->get_sections($this->input->post('module_ID'));
		echo json_encode($data);
	}

	function get_section(){
		$data = $this->course_model->get_section($this->input->post('section_ID'));
		echo json_encode($data);
	}
	
	function get_lessons(){
		$data = $this->course_model->get_lessons($this->input->post('section_ID'));
		echo json_encode($data);
	}

	function get_lesson(){
		$data = $this->course_model->get_lesson($this->input->post('lesson_ID'));
		echo json_encode($data);
	}

	function get_content(){
		$data = $this->course_model->get_content($this->input->post('content_ID'));
		echo json_encode($data);
	}

	function get_categories(){
		$data = $this->course_model->get_category();
		echo json_encode($data);
	}

	function get_files(){
		$data = $this->course_model->get_files($this->input->post('content_ID'));
		$arrayName = array();
		foreach ($data as $row) {
			$arrayName[] = $row['file'];
		}
		echo json_encode(implode(",",$arrayName));
	}

	function sort_module(){
		for($count = 0;  $count < count($this->input->post('module_order')); $count++){
			$sort = $count+1;
			$id = $this->input->post('module_order')[$count];
			$create = $this->course_model->sort_module($id, $sort);
		}
		echo json_encode($create);
	}

	function sort_section(){
		$id = $this->input->post('sec_order_id');
		for($count = 0;  $count < count($id); $count++){
			$row = $count+1;
			$name = $this->input->post('sec_order_id')[$count];
			$create = $this->course_model->sort_section($name, $row);
		}
		echo json_encode($create);
	}

	function sort_lesson(){
		$id = $this->input->post('les_order_id');
		for($count = 0;  $count < count($id); $count++){
			$row = $count+1;
			$name = $this->input->post('les_order_id')[$count];
			$create = $this->course_model->sort_lesson($name, $row);
		}
		echo json_encode($create);
	}

	function sort_content(){
		$id = $this->input->post('con_order_id');
		for($count = 0;  $count < count($id); $count++){
			$row = $count+1;
			$name = $this->input->post('con_order_id')[$count];
			$create = $this->course_model->sort_content($name, $row);
		}
		echo json_encode($create);
	}

	function create_category() {
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('name', 'Name', 'required', array('required' => 'Name is required.'));
        $this->form_validation->set_rules('type', 'Type', 'required', array('required' => 'Type is required.'));

        if ($this->form_validation->run() === FALSE) {
        	$this->session->set_flashdata('multi',validation_errors());
	    } else {
			$data = $this->course_model->create_category($this->input->post('name'), $this->input->post('type'), $this->session->userdata('admin_id'));
			if($data){
				$this->session->set_flashdata('success', 'Category created Successfully');
			} else {
				$this->session->set_flashdata('error', 'Category name already exist.');
			}
	    }
	    redirect($_SERVER['HTTP_REFERER']);
	}

	function update_category() {
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('edit_name', 'Name', 'required', array('required' => 'Name is required.'));

        if ($this->form_validation->run() === FALSE) {
        	$this->session->set_flashdata('multi',validation_errors());
	    } else {
			$data = $this->course_model->update_category($this->input->post('category_ID'), $this->input->post('edit_name'), $this->session->userdata('admin_id'));

			if($data){
				$this->session->set_flashdata('success', 'Category created Successfully');
			} else {
				$this->session->set_flashdata('error', 'Category name already exist.');
			}
	    }
	    redirect($_SERVER['HTTP_REFERER']);
	}

	function create_course() {
        $this->form_validation->set_rules('title', 'Title', 'required', array('required' => 'Title is required.'));
        $this->form_validation->set_rules('description', 'Description', 'required', array('required' => 'Description is required.'));
        $this->form_validation->set_rules('keywords', 'Keywords', 'required', array('required' => 'Keywords is required.'));
        $this->form_validation->set_rules('price', 'Price', 'numeric');
        $this->form_validation->set_rules('category[]', 'Category', 'required', array('required' => 'Category is required.'));

        if ($this->form_validation->run() === FALSE) {
        	$data = array(
				'error' => true,
				'message' => validation_errors()
			);
	    } else {
	    	$price  = empty($this->input->post('price')) ? NULL : $this->input->post('price');

			$create = $this->course_model->create_course($this->input->post('title'), $this->input->post('description'), $this->input->post('keywords'), $price, $this->input->post('category'), $this->input->post('image'), $this->session->userdata('user_id'));

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

	function create_module() {
		$this->form_validation->set_error_delimiters('<script type="text/javascript">$(function(){toastr.error("', '")});</script>');
        $this->form_validation->set_rules('module_title', 'Module title', 'required', array('required' => 'Module title is required.'));

        if ($this->form_validation->run() === FALSE) {
        	$this->session->set_flashdata('multi', validation_errors());
	    } else {
			$data = $this->course_model->create_module($this->input->post('course_ID'), $this->input->post('module_title'), $this->session->userdata('user_id'));
			if($data){
				$this->session->set_flashdata('success', 'Module Created Successfully');
			} else {
				$this->session->set_flashdata('error', 'Module title already exist.');
			}
	    }
	    redirect($_SERVER['HTTP_REFERER']);
	}

	function create_section() {
		$this->form_validation->set_rules('title', 'Section title', 'required', array('required' => 'Section title is required.'));

	    if ($this->form_validation->run() === FALSE) {
			$data = array(
				'error' => true,
				'message' => validation_errors()
			);
	        echo json_encode($data);
	    } else {
			$data = $this->course_model->create_section($this->input->post('title'), $this->input->post('module_ID'), $this->session->userdata('user_id'));
			$section = $this->course_model->get_section(url_title($this->input->post('title')), $this->input->post('module_ID'));
			if($data){
				$output = array(
					'error' => false,
					'section_ID' => $section['id']
				);
			} else {
				$output = array(
					'error' => true,
					'message' => 'Module title already exist.'
				);
			}
			echo json_encode($output);
	    }
	}

	function create_lesson() {
	    $this->form_validation->set_rules('title', 'Lesson title', 'required');
	    if ($this->form_validation->run() === FALSE) {
			$output = array(
				'error' => true,
				'message' => validation_errors()
			);
		} else {
			$data = $this->course_model->create_lesson($this->input->post('section_ID'), $this->input->post('title'), $this->session->userdata('user_id'));
			$lesson = $this->course_model->get_lesson(url_title($this->input->post('title')), $this->input->post('section_ID'));
			if($data){
				$output = array(
					'error' => false,
					'lesson_ID' => $lesson['id']
				);
			} else {
				$output = array(
					'error' => true,
					'message' => 'Lesson title already exist.'
				);
			}
		}
		echo json_encode($output);
	}

	function convertYoutube($string) {
	    return preg_replace(
	        "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
	        "https://www.youtube.com/embed/$2",
	        $string
	    );
	}

	function create_content() {
	    $this->form_validation->set_rules('title', 'Content title', 'required');

      	if ($this->form_validation->run() === FALSE) {
			$data = array(
				'error' => true,
				'message' => validation_errors()
			);
	    } else {
		    if (is_null(json_decode($this->input->post('files')))) {
		    	$files = implode(",", array($this->input->post('files')));
		    } else {
		    	$files = implode(",", json_decode($this->input->post('files')));
		    }

		    $url = $this->convertYoutube($this->input->post('url'));
    		$create = $this->course_model->create_content($this->input->post('lesson_ID'), $this->input->post('title'), $url, $this->input->post('content'), $files, $this->input->post('thumbnail'), $this->session->userdata('user_id'));

	        $content = $this->course_model->get_content(url_title($this->input->post('title')), $this->input->post('lesson_ID'));
			if($create){
				$data = array(
					'error' => false,
					'content_ID' => $content['id']
				);
			} else {
				$data = array(
					'error' => true,
					'message' => 'Content title already exist.'
				);
			}
	    }
	    echo json_encode($data);
	}

	function update_course() {
      	$this->form_validation->set_rules('title', 'Title', 'required', array('required' => 'Title is required.'));
        $this->form_validation->set_rules('description', 'Description', 'required', array('required' => 'Description is required.'));
        $this->form_validation->set_rules('keywords', 'Keywords', 'required', array('required' => 'Keywords is required.'));
        $this->form_validation->set_rules('price', 'Price', 'numeric');
        $this->form_validation->set_rules('category[]', 'Category', 'required', array('required' => 'Category is required.'));
        if ($this->form_validation->run() === FALSE) {
        	$data = array(
				'error' => true,
				'message' => validation_errors()
			);
	    } else {
	    	$price  = empty($this->input->post('price')) ? NULL : $this->input->post('price');

			$create = $this->course_model->update_course($this->input->post('course_ID'), $this->input->post('title'), $this->input->post('description'), $this->input->post('keywords'), $price, $this->input->post('category'), $this->input->post('image'), $this->session->userdata('user_id'));

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

	function update_course_status() {
		$data = $this->course_model->update_course_status($this->input->post('course_ID'), $this->input->post('status'));
	  	echo json_encode($data);
	}

	function update_course_privacy() {
		$data = $this->course_model->update_course_privacy($this->input->post('course_ID'), $this->input->post('privacy'));
	  	echo json_encode($data);
	}


	function update_module_status() {
		$data = $this->course_model->module_status($this->input->post('module_ID'), $this->input->post('status'));
	  	echo json_encode($data);
	}

	function hide_all_module() {
		$data = $this->course_model->hide_all_module($this->input->post('module_ID'), $this->input->post('status'));
	  	echo json_encode($data);
	}

	function update_module() {
        $this->form_validation->set_rules('module_title', 'Module title', 'required');
        if ($this->form_validation->run() === FALSE) {
			$data = array(
				'error' => true,
				'message' => validation_errors()
			);
	    } else {
			$create = $this->course_model->update_module($this->input->post('module_ID'), $this->input->post('module_title'), $this->session->userdata('user_id'));
			if(!$create){
				$data = array(
					'error' => true,
					'message' => 'Module title already exist.'
				);
			} else {
				$data = array(
					'success' => true
				);
			}
	    }
	    echo json_encode($data);
	}

	function update_section() {
        $this->form_validation->set_rules('section_title', 'Section title', 'required');
        if ($this->form_validation->run() === FALSE) {
			$data = array(
				'error' => true,
				'message' => validation_errors()
			);
	    } else {
			$create = $this->course_model->update_section($this->input->post('section_ID'), $this->input->post('section_title'), $this->input->post('section_status'), $this->session->userdata('user_id'));
			if(!$create){
				$data = array(
					'error' => true,
					'message' => 'Section title already exist.'
				);
			} else {
				$data = array(
					'error' => false
				);
			}
	    }
	    echo json_encode($data);
	}

	function update_lesson() {
		$this->form_validation->set_rules('lesson_title', 'Lesson title', 'required');
        if ($this->form_validation->run() === FALSE) {
			$data = array(
				'error' => true,
				'message' => validation_errors()
			);
	    } else {
			$create = $this->course_model->update_lesson($this->input->post('lesson_ID'), $this->input->post('lesson_title'), $this->input->post('status'), $this->session->userdata('user_id'));
			if(!$create){
				$data = array(
					'error' => true,
					'message' => 'Lesson title already exist.'
				);
			} else {
				$data = array(
					'error' => false
				);
			}
	    }
	    echo json_encode($data);
	}

	function update_content() {
		$this->form_validation->set_rules('title', 'Content title', 'required');

        if ($this->form_validation->run() === FALSE) {
			$data = array(
				'error' => true,
				'message' => validation_errors()
			);
	    } else {
		    if (is_null(json_decode($this->input->post('files')))) {
		    	$files = implode(",", array($this->input->post('files')));
		    } else {
		    	$files = implode(",", json_decode($this->input->post('files')));
		    }

		    $url = $this->convertYoutube($this->input->post('url'));
			$create = $this->course_model->update_content($this->input->post('content_ID'), $this->input->post('title'), $url, $this->input->post('thumbnail'), $this->input->post('content'), $this->input->post('status'), $files, $this->session->userdata('user_id'));
			if(!$create){
				$data = array(
					'error' => true,
					'message' => 'Content title already exist.'
				);
			} else {
				$data = array(
					'error' => false,
				);
			}
	    
	    }
	    echo json_encode($data);
	}

	function update_all_content() {
		$obj = $this->input->post('content');
		foreach ($obj as $key => $value) {
			$this->course_model->update_content($obj[$key]['content_ID'], $obj[$key]['title'], $obj[$key]['url'], $obj[$key]['thumbnail'], $obj[$key]['content'], $obj[$key]['status'], $obj[$key]['file'], $this->session->userdata('user_id'));
		}
		$this->session->set_flashdata('success', 'Module Created Successfully');
		redirect($_SERVER['HTTP_REFERER']);
	}

	function delete_course() {
		$data = $this->course_model->delete_course($this->input->post('course_ID'));
		echo json_encode($data);
	}

	function delete_module() {
		$data = $this->course_model->delete_module($this->input->post('module_ID'));
		echo json_encode($data, NULL);
	}

	function delete_section() {
		$data = $this->course_model->delete_section($this->input->post('section_ID'), NULL);
		echo json_encode($data);
	}

	function delete_lesson() {
		$data = $this->course_model->delete_lesson($this->input->post('lesson_ID'), NULL);
		echo json_encode($data);
	}

	function delete_content() {
		$data = $this->course_model->delete_content($this->input->post('content_ID'));
		echo json_encode($data);
	}

	function view_more() {
		if($this->input->post('category_ID') == 0){
			$courses = $this->course_model->get_course(NULL, 10, $this->input->post('start'), '1');
		} elseif($this->input->post('category_ID') == -1) {
			$courses = $this->course_model->search_course($this->input->post('title'), 10, $this->input->post('start'));
		} else {
			$courses = $this->course_model->get_course_by_category($this->input->post('category_ID'), 10, $this->input->post('start'));
		}

		$data = array();
		foreach($courses as $row){
			if($row['status'] == 1 && $row['privacy'] == 0){
	            $rating = $this->review_model->get_rating(3, $row['course_ID']);
				$data[] = array(
					'slug' => $row['slug'],
					'title' => ucwords($row['title']),
					'image' => $row['image'],
					'rating' => $this->renderStarRating($rating['avg'])
				);
			}
		}
		echo json_encode($data);
	}

	function renderStarRating($rating,$maxRating=5) {
		$fullStar = "<i class='fas fa-star amber-text'></i>";
		$halfStar = "<i class='fas fa-star-half-alt amber-text'></i>";
		$emptyStar = "<i class='far fa-star amber-text'></i>";
		$rating = $rating <= $maxRating?$rating:$maxRating;

		$fullStarCount = (int)$rating;
		$halfStarCount = ceil($rating)-$fullStarCount;
		$emptyStarCount = $maxRating -$fullStarCount-$halfStarCount;

		$html = str_repeat($fullStar,$fullStarCount);
		$html .= str_repeat($halfStar,$halfStarCount);
		$html .= str_repeat($emptyStar,$emptyStarCount);
		$html = $html;
		return $html;
	}

	function copy_module() {
		$data = $this->course_model->copy_module($this->input->post('module_ID'), $this->input->post('course_ID'), $this->session->userdata('user_id'));
		echo json_encode($data);
	}

	function copy_section() {
		$data = $this->course_model->copy_section($this->input->post('section_ID'), $this->input->post('module_ID'), $this->session->userdata('user_id'));
		echo json_encode($data);
	}

	function copy_lesson() {
		$create = $this->course_model->copy_lesson($this->input->post('lesson_ID'), $this->input->post('section_ID'), $this->session->userdata('user_id'));
		if(!$create){
			$data = array(
				'error' => true,
				'message' => 'Lesson title already exist.'
			);
		} else {
			$lesson = $this->course_model->get_lesson(url_title($this->input->post('lesson_title')), $this->input->post('section_ID'));
			$contents = $this->course_model->get_contents($lesson['id']);
			$data = array(
				'error' => false,
				'contents' => $contents,
				'title' => $lesson['title'],
				'lesson_ID' => $lesson['id'],
				'section_ID' => $lesson['section_ID']
			);
		}
		echo json_encode($data);
	}

	function copy_content() {
		$create = $this->course_model->copy_content($this->input->post('content_ID'), $this->input->post('lesson_ID'), $this->session->userdata('user_id'));
		if(!$create){
			$data = array(
				'error' => true,
				'message' => 'Content title already exist.'
			);
		} else {
			$content = $this->course_model->get_content(url_title($this->input->post('content_title')), $this->input->post('lesson_ID'));
			$data = array(
				'error' => false,
				'content_ID' => $content['id'],
				'lesson_ID' => $content['lesson_ID'],
				'title' => $content['title']
			);
		}
		echo json_encode($data);
	}


}