<?php
	class Course_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function search_course($search, $limit, $start){
    	$this->db->select('*, course.id as course_ID');
		$this->db->like('title', $search);
		$this->db->where('status', '1');
		$this->db->where('privacy', '0');
		if(!empty($limit)){
			$this->db->limit($limit, $start);
		}
		$this->db->order_by('CHAR_LENGTH(title)', 'ASC');
    	$query = $this->db->get('course');
		return $query->result_array();
    }

    public function search_module($search, $limit, $start){
    	$this->db->select('course.title as course_title, course.image, course.description, course_module.*, course_module.slug as module_slug, course.slug as course_slug');
    	$this->db->join('course', 'course.id = course_module.course_ID');
		$this->db->like('course_module.title', $search);
		$this->db->where('course_module.status', '1');
		$this->db->where('course.status', '1');
		$this->db->where('course.privacy', '0');
		if(!empty($limit)){
			$this->db->limit($limit, $start);
		}

		$this->db->order_by('CHAR_LENGTH(course_module.title)', 'ASC');
    	$query = $this->db->get('course_module');
		return $query->result_array();
    }

    public function search_section($search, $limit, $start){
    	$this->db->select('course.title as course_title, course.image, course.description, course_section.*, course_section.slug as section_slug, course_module.slug as module_slug, course.slug as course_slug');
    	$this->db->join('course_module', 'course_module.id = course_section.module_ID');
    	$this->db->join('course', 'course.id = course_module.course_ID');
		$this->db->like('course_section.title', $search);
		$this->db->where('course_section.status', '1');
		$this->db->where('course_module.status', '1');
		$this->db->where('course.status', '1');
		$this->db->where('course.privacy', '0');
		if(!empty($limit)){
			$this->db->limit($limit, $start);
		}
		$this->db->order_by('CHAR_LENGTH(course_section.title)', 'ASC');
    	$query = $this->db->get('course_section');
		return $query->result_array();
    }

    public function search_lesson($search, $limit, $start){
    	$this->db->select('course.title as course_title, course.image, course.description, course_lesson.*, course_lesson.slug as lesson_slug, course_section.slug as section_slug, course_module.slug as module_slug, course.slug as course_slug');
    	$this->db->join('course_section', 'course_section.id = course_lesson.section_ID');
    	$this->db->join('course_module', 'course_module.id = course_section.module_ID');
    	$this->db->join('course', 'course.id = course_module.course_ID');
		$this->db->like('course_lesson.title', $search);
		$this->db->where('course_lesson.status', '1');
		$this->db->where('course_section.status', '1');
		$this->db->where('course_module.status', '1');
		$this->db->where('course.status', '1');
		$this->db->where('course.privacy', '0');
		if(!empty($limit)){
			$this->db->limit($limit, $start);
		}
		$this->db->order_by('CHAR_LENGTH(course_lesson.title)', 'ASC');
    	$query = $this->db->get('course_lesson');
		return $query->result_array();
    }

    public function search_content($search, $limit, $start){
    	$this->db->select('course.title as course_title, course.image, course.description, course_content.*, course_content.slug as content_slug, course_lesson.slug as lesson_slug, course_section.slug as section_slug, course_module.slug as module_slug, course.slug as course_slug');
    	$this->db->join('course_lesson', 'course_lesson.id = course_content.lesson_ID');
    	$this->db->join('course_section', 'course_section.id = course_lesson.section_ID');
    	$this->db->join('course_module', 'course_module.id = course_section.module_ID');
    	$this->db->join('course', 'course.id = course_module.course_ID');
		$this->db->like('course_content.title', $search);
		$this->db->where('course_content.status', '1');
		$this->db->where('course_lesson.status', '1');
		$this->db->where('course_section.status', '1');
		$this->db->where('course_module.status', '1');
		$this->db->where('course.status', '1');
		$this->db->where('course.privacy', '0');
		if(!empty($limit)){
			$this->db->limit($limit, $start);
		}
		$this->db->order_by('CHAR_LENGTH(course_content.title)', 'ASC');
    	$query = $this->db->get('course_content');
		return $query->result_array();
    }

    public function sort_module($id, $sort){
		$this->db->trans_begin();
		$this->db->set('sort', $sort);
		$this->db->where('id', $id);
		$this->db->update('course_module');
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}		
	}

    public function sort_section($id, $sort){
		$this->db->trans_begin();
		$this->db->set('sort', $sort);
		$this->db->where('id', $id);
		$this->db->update('course_section');
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}		
	}

	public function sort_lesson($id, $sort){
		$this->db->trans_begin();
		$this->db->set('sort', $sort);
		$this->db->where('id', $id);
		$this->db->update('course_lesson');
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}		
	}

	public function sort_content($id, $sort){
		$this->db->trans_begin();
		$this->db->set('sort', $sort);
		$this->db->where('id', $id);
		$this->db->update('course_content');
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function get_files($content_ID){
		$this->db->select('file');
		$query = $this->db->get_where('course_content_file', array('content_ID' => $content_ID));

		return $query->result_array();
	}

	public function get_category($category_ID = FALSE){
		$this->db->where('type', '1');
		if($category_ID === FALSE){
			$query = $this->db->get('category');;
			return $query->result_array();
		}

		if(is_numeric($category_ID) == 1){
			$query = $this->db->get_where('category', array('id' => $category_ID));
		} else {
			$query = $this->db->get_where('category', array('slug' => $category_ID));
		}
		
		return $query->row_array();
	}

	public function get_course_to_category($course_ID = FALSE){
		$this->db->select('*');
		$this->db->join('category', 'category.id = course_to_category.category_ID', 'LEFT');
		if($course_ID !== FALSE){
			$this->db->where('course_to_category.course_ID', $course_ID);
		}
		$query = $this->db->get('course_to_category');
		return $query->result_array();
	}

	public function get_course($user_ID, $limit, $start, $status, $course_ID = FALSE){
		$this->db->select('course.*, course.id as course_ID, users.id, users.first_name, users.last_name');
		$this->db->join('users', 'users.id = course.user_ID');
		$this->db->order_by('course.title', 'ASC');
		if($status != NULL){
			$this->db->where('course.status', $status);
		}

		if($user_ID != NULL){
			$this->db->where('course.user_ID', $user_ID);
		}

		if(!empty($limit)){
			$this->db->limit($limit, $start);
		}
		
		if($course_ID === FALSE){
			$query = $this->db->get('course');;
			return $query->result_array();
		}
		if(is_numeric($course_ID) == 1){
			$this->db->where('course.id', $course_ID);
			$query = $this->db->get('course');
		} else {
			$this->db->where('course.slug', $course_ID);
			$query = $this->db->get('course');
		}
		return $query->row_array();
	}

	public function get_course_by_category($category_ID, $limit, $start){
		$this->db->select('*');
		$this->db->join('course_to_category', 'course_to_category.course_ID = course.id');
    	$this->db->where('course_to_category.category_ID', $category_ID);
    	$this->db->order_by('course.title', 'ASC');
    	$this->db->where('course.status', '1');
    	$this->db->where('course.privacy', '0');
    	if(!empty($limit)){
			$this->db->limit($limit, $start);
		}

		$query = $this->db->get('course');
		return $query->result_array();
	}

	public function get_modules($course_ID = FALSE){
		$this->db->order_by('sort', 'ASC');
		if($course_ID === FALSE){
			$query = $this->db->get('course_module');
			return $query->result_array();
		}
		$this->db->where('course_ID', $course_ID);
		$query = $this->db->get('course_module');
		return $query->result_array();
	}

	public function get_module($module_ID, $course_ID = FALSE){
		if(is_numeric($module_ID) == 1){
			$query = $this->db->get_where('course_module', array('id' => $module_ID));
		} else {;
			$this->db->where('course_ID', $course_ID);
			$this->db->where('slug', $module_ID);
			$query = $this->db->get('course_module');
		}

		return $query->row_array();
	}

	public function get_sections($module_ID = FALSE){
		$this->db->order_by('sort', 'ASC');
		if($module_ID === FALSE){
			$query = $this->db->get('course_section');
			return $query->result_array();
		}
		$this->db->where('module_ID', $module_ID);
		$query = $this->db->get('course_section');

		return $query->result_array();
	}

	public function get_section($section_ID, $module_ID = FALSE){
		if(is_numeric($section_ID) == 1){
			$query = $this->db->get_where('course_section', array('id' => $section_ID));
		} else {
			$this->db->where('module_ID', $module_ID);
			$this->db->where('slug', $section_ID);
			$query = $this->db->get('course_section');
		}
		return $query->row_array();
	}

	public function get_lessons($section_ID = FALSE){
		$this->db->order_by('sort', 'ASC');
		if($section_ID === FALSE){
			$query = $this->db->get('course_lesson');
			return $query->result_array();
		}
		$this->db->where('section_ID', $section_ID);
		$query = $this->db->get('course_lesson');

		return $query->result_array();
	}

	public function get_lesson($lesson_ID, $section_ID = FALSE){
		if(is_numeric($lesson_ID) == 1){
			$query = $this->db->get_where('course_lesson', array('id' => $lesson_ID));
		} else {
			$this->db->where('section_ID', $section_ID);
			$this->db->where('slug', $lesson_ID);
			$query = $this->db->get('course_lesson');
		}

		return $query->row_array();
	}

	public function get_contents($lesson_ID = FALSE){
		$this->db->order_by('sort', 'ASC');
		if($lesson_ID === FALSE){
			$query = $this->db->get('course_content');
			return $query->result_array();
		}
		$this->db->where('lesson_ID', $lesson_ID);
		$query = $this->db->get('course_content');

		return $query->result_array();
	}

	public function get_content($content_ID, $lesson_ID = FALSE){
		if(is_numeric($content_ID) == 1){
			$query = $this->db->get_where('course_content', array('id' => $content_ID));
		} else {
			$this->db->where('lesson_ID', $lesson_ID);
			$this->db->where('slug', $content_ID);
			$query = $this->db->get('course_content');
		}

		return $query->row_array();
	}

	public function get_all_content($section_ID){
		$this->db->select('course_content.*, course_lesson.title as lesson_title, course_section.title as section_title');
		$this->db->join('course_lesson', 'course_section.id = course_lesson.section_ID');
    	$this->db->join('course_content', 'course_lesson.id = course_content.lesson_ID');
    	$this->db->where('course_section.id', $section_ID);
		$query = $this->db->get('course_section');

		return $query->result_array();
	}

	function add_course_to_category($course_ID, $sub_category){
		$this->db->trans_begin();
		$total = count($sub_category);
		for($i=0; $i<$total; $i++) {
	        $category_ID = $sub_category[$i];
	        $data = array(
	        	'course_ID' => $course_ID,
				'category_ID' => $category_ID
			);
			$this->db->insert('course_to_category', $data);
		}

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function create_category($name, $type, $admin_ID){
		$this->db->trans_begin();

		$slug = url_title($name);
		$data = array(
			'name' => $name,
			'type' => $type,
			'slug' => strtolower($slug),
			'admin_ID' => $admin_ID,
		);
		$this->db->insert('category', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function update_category($id, $name, $admin_ID){
		$this->db->trans_begin();

		$slug = url_title($name);
		$data = array(
			'name' => $name,
			'slug' => strtolower($slug),
			'admin_ID' => $admin_ID,
		);
		$this->db->where('id', $id);
		$this->db->update('category', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function create_course($title, $description, $keywords, $price, $category, $image, $user_ID){
		$this->db->trans_begin();

		$slug = url_title($title);
		$data = array(
			'title' => $title,
			'slug' => strtolower($slug),
			'description' => $description,
			'image' => $image,
			'price' => $price,
			'meta_title' => ucwords($title),
			'meta_description' => ucfirst($description),
			'meta_keywords' => $keywords,
			'user_ID' => $user_ID
		);
		$this->db->set('date_created', 'NOW()', FALSE);
		$this->db->insert('course', $data);

		$course_ID = $this->db->insert_id();
		$this->add_course_to_category($course_ID, $category);

		$this->load->model('message_model', 'message');
		$this->message->create_group($user_ID, $title, NULL);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function update_course($course_ID, $title, $description, $keywords, $price, $category, $image, $user_ID){
		$this->db->trans_begin();	

		$slug = url_title($title);
		$data = array(
			'title' => $title,
			'slug' => strtolower($slug),
			'description' => $description,
			'price' => $price,
			'meta_title' => ucwords($title),
			'meta_description' => ucfirst($description),
			'meta_keywords' => $keywords,
			'user_ID' => $user_ID
		);
		if(!empty($image)){
			$this->db->set('image', $image);
		}
		$this->db->where('id', $course_ID);
		$this->db->update('course', $data);

		$this->db->delete('course_to_category', array('course_ID' => $course_ID));

		$this->add_course_to_category($course_ID, $category);
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function update_course_status($course_ID, $status){
		$this->db->trans_begin();	

		$this->db->set('status', $status);
		$this->db->where('id', $course_ID);
		$this->db->update('course');

		$this->course_status($course_ID, $status);
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function update_course_privacy($course_ID, $privacy){
		$this->db->trans_begin();	

		$this->db->set('privacy', $privacy);
		$this->db->where('id', $course_ID);
		$this->db->update('course');

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function create_module($course_ID, $module_title, $user_ID){
		$this->db->trans_begin();

		$query = $this->db->count_all('course_module');
		$last = $query + 1;
		$slug = url_title($module_title);
		$data = array(
			'course_ID' => $course_ID,
			'title' => $module_title,
			'slug' => strtolower($slug),
			'sort' => $last,
			'updated_by' => $user_ID
		);

		$this->db->insert('course_module', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function create_section($title, $module_ID, $user_ID){
		$this->db->trans_begin();
		$query = $this->db->count_all('course_section');
		$last = $query + 1;
		$slug = url_title($title);

		$data = array(
			'module_ID' => $module_ID,
			'title' => $title,
			'slug' => strtolower($slug),
			'sort' => $last,
			'updated_by' => $user_ID
		);
		$this->db->insert('course_section', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function update_module($module_ID, $module_title, $user_ID){
		$this->db->trans_begin();	

		$slug = url_title($module_title);
		$data = array(
			'title' => $module_title,
			'slug' => strtolower($slug),
			'updated_by' => $user_ID
		);
		$this->db->where('id', $module_ID);
		$this->db->update('course_module', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function update_section($section_ID, $section_title, $status, $user_ID){
		$this->db->trans_begin();

		$slug = url_title($section_title);
		$data = array(
			'title' => $section_title,
			'slug' => strtolower($slug),
			'status' => $status,
			'updated_by' => $user_ID
		);
		$this->db->where('id', $section_ID);
		$this->db->update('course_section', $data);
		$this->section_status($section_ID, $status);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function update_lesson($lesson_ID, $lesson_title, $status, $user_ID){
		$this->db->trans_begin();
		$slug = url_title($lesson_title);
		$data = array(
			'title' => $lesson_title,
			'slug' => strtolower($slug),
			'status' => $status,
			'updated_by' => $user_ID
		);
		$this->db->where('id', $lesson_ID);
		$this->db->update('course_lesson', $data);
		$this->lesson_status($lesson_ID, $status);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function create_lesson($section_ID, $lesson_title, $user_ID){
		$this->db->trans_begin();

		$slug = url_title($lesson_title);
		$query = $this->db->count_all('course_lesson');
		$last = $query + 1;
		$data = array(
			'section_ID' => $section_ID,
			'title' => $lesson_title,
			'slug' => strtolower($slug),
			'sort' => $last,
			'updated_by' => $user_ID
		);
		$this->db->insert('course_lesson', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function create_content($lesson_ID, $title, $content_url, $content, $files, $thumbnail, $user_ID){
		$this->db->trans_begin();
		$slug = url_title($title);
		$query = $this->db->count_all('course_content');
		$last = $query + 1;

		$data = array(
			'lesson_ID' => $lesson_ID,
			'title' => $title,
			'slug' => strtolower($slug),
			'url' => $content_url,
			'thumbnail' => $thumbnail,
			'content' => $content,
			'file' => $files,
			'sort' => $last,
			'updated_by' => $user_ID
		);
		$this->db->insert('course_content', $data);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function update_content($content_ID, $title, $url, $thumbnail, $content, $status, $files, $user_ID){
		$this->db->trans_begin();
		$slug = url_title($title);

		$data = array(
			'title' => $title,
			'slug' => strtolower($slug),
			'url' => $url,
			'thumbnail' => $thumbnail,
			'content' => $content,
			'status' => $status,
			'file' => $files,
			'updated_by' => $user_ID
		);
		$this->db->where('id', $content_ID);
		$this->db->update('course_content', $data);
		
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function count_module($course_ID){
		$this->db->select('count(course_module.id) as total_modules');
		$this->db->where('course_ID', $course_ID);
		$this->db->where('status', '1');

    	$query = $this->db->get('course_module');
    	return $query->row_array();
	}

	public function count_section($course_ID){
		$this->db->select('count(course_section.id) as total_sections');
    	$this->db->join('course_section', 'course_module.id = course_section.module_ID');
    	$this->db->where('course_module.status', '1');
    	$this->db->where('course_section.status', '1');
		$this->db->where('course_module.course_ID', $course_ID);

    	$query = $this->db->get('course_module');
    	return $query->row_array();
	}

	public function count_lesson($course_ID){
		$this->db->select('count(course_lesson.id) as total_lessons');
    	$this->db->join('course_section', 'course_module.id = course_section.module_ID');
    	$this->db->join('course_lesson', 'course_section.id = course_lesson.section_ID');
    	$this->db->where('course_module.status', '1');
    	$this->db->where('course_section.status', '1');
    	$this->db->where('course_lesson.status', '1');
		$this->db->where('course_module.course_ID', $course_ID);

    	$query = $this->db->get('course_module');
    	return $query->row_array();
	}

	public function count_content($course_ID){
		$this->db->select('count(course_module.id) as total_modules, count(course_content.id) as total_contents');
    	$this->db->join('course_section', 'course_module.id = course_section.module_ID');
    	$this->db->join('course_lesson', 'course_section.id = course_lesson.section_ID');
    	$this->db->join('course_content', 'course_lesson.id = course_content.lesson_ID');
		$this->db->where('course_module.course_ID', $course_ID);
		$this->db->where('course_module.status', '1');
    	$this->db->where('course_section.status', '1');
    	$this->db->where('course_lesson.status', '1');
    	$this->db->where('course_content.status', '1');

    	$query = $this->db->get('course_module');
    	return $query->row_array();
	}

	public function count_contents($module_ID, $section_ID){
		$this->db->select('count(course_content.id) as content');
		$this->db->join('course_lesson', 'course_lesson.id = course_content.lesson_ID');
    	$this->db->join('course_section', 'course_section.id = course_lesson.section_ID');
    	$this->db->join('course_module', 'course_module.id = course_section.module_ID');
		$this->db->where('course_module.status', '1');
    	$this->db->where('course_section.status', '1');
    	$this->db->where('course_lesson.status', '1');
    	$this->db->where('course_content.status', '1');
    	$this->db->where('course_content.url is NOT NULL', NULL, FALSE);
		if($module_ID != NULL){
    		$this->db->where('course_module.id', $module_ID);
    	}
    	if($section_ID != NULL){
    		$this->db->where('course_section.id', $section_ID);
    	}
    	$this->db->group_by('course_module.course_ID');
    	$query = $this->db->get('course_content');
    	return $query->row_array();
	}

	public function next_module($course_ID, $section_ID){
		$this->db->select('
    		course_section.slug as section_slug,
	    	course_module.slug as course_slug
    	');
    	$this->db->join('course_module', 'course_module.id = course_section.module_ID', 'left');
		$where2 = "course_section.sort > (SELECT sort FROM course_section WHERE id = '$section_ID')";
		$this->db->where($where2);
		$this->db->where('course_module.course_ID', $course_ID);
    	$this->db->order_by('course_section.sort', 'ASC');
    	$this->db->limit(1);
    	$query = $this->db->get('course_section');
    	$sql = $query->row();

    	if($sql == NULL){
	    	$this->db->select('
	    		course_section.slug as section_slug,
	    		course_module.slug as course_slug
	    	');
	    	$this->db->join('course_module', 'course_module.id = course_section.module_ID', 'left');
			$where = "course_module.sort = (SELECT sort+1 FROM course_module WHERE course_ID = '$course_ID')";
			$this->db->where($where);
	    	$this->db->order_by('course_section.sort', 'ASC');
	    	$this->db->limit(1);

    		$query2 = $this->db->get('course_section');
    		return $query2->row_array();
    	} else {
    		return $query->row_array();
    	}
	}

	public function course_status($course_ID, $status){
		$this->db->trans_begin();

		$this->db->set('status', $status);
		$this->db->where('id', $course_ID);
		$this->db->update('course');

		// $this->db->set('status', $status);
		// $this->db->where('course_ID', $course_ID);
		// $this->db->update('course_module');

		// foreach ($this->get_modules($course_ID) as $row){
		// 	$this->module_status($row['id'], $status);
		// }

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function module_status($module_ID, $status){
		$this->db->trans_begin();

		$this->db->set('status', $status);
		$this->db->where('id', $module_ID);
		$this->db->update('course_module');

		// $this->db->set('status', $status);
		// $this->db->where('module_ID', $module_ID);
		// $this->db->update('course_section');

		// foreach ($this->get_sections($module_ID) as $row){
		// 	$this->section_status($row['id'], $status);
		// }

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function section_status($section_ID, $status){
		$this->db->trans_begin();

		$this->db->set('status', $status);
		$this->db->where('id', $section_ID);
		$this->db->update('course_section');

		// $this->db->set('status', $status);
		// $this->db->where('section_ID', $section_ID);
		// $this->db->update('course_lesson');

		// foreach ($this->get_lessons($section_ID) as $row){
		// 	$this->lesson_status($row['id'], $status);
		// }

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function lesson_status($lesson_ID, $status){
		$this->db->trans_begin();

		$this->db->set('status', $status);
		$this->db->where('id', $lesson_ID);
		$this->db->update('course_lesson');

		// $this->db->set('status', $status);
		// $this->db->where('lesson_ID', $lesson_ID);
		// $this->db->update('course_content');

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function content_status($content_ID, $status){
		$this->db->trans_begin();

		$this->db->set('status', $status);
		$this->db->where('id', $content_ID);
		$this->db->update('course_content');
		
		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function get_users_course($course_ID = FALSE){
		$this->db->select('COUNT(id) as total');
    	if($course_ID === FALSE){
			$query = $this->db->get('purchase');
			return $query->result_array();
		}
		$this->db->where('course_ID', $course_ID);
		$query = $this->db->get('purchase');

		return $query->row_array();
	}

	public function copy_module($module_ID, $course_ID, $user_ID){
		$this->db->trans_begin();

		$sql = $this->get_module($module_ID);
		$this->create_module($course_ID, $sql['title'], $user_ID);

		$end = $this->get_modules($course_ID);
		$query = end($end);
		foreach ($this->get_sections($module_ID) as $row){
			$this->copy_section($row['id'], $query['id'], $user_ID);
		}

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function copy_section($section_ID, $module_ID, $user_ID){
		$this->db->trans_begin();

		$sql = $this->get_section($section_ID);
		$this->create_section($sql['title'], $module_ID, $user_ID);

		$end = $this->get_sections($module_ID);
		$query = end($end);

		foreach ($this->get_lessons($section_ID) as $row){
			$this->copy_lesson($row['id'], $query['id'], $user_ID);
		}

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function copy_lesson($lesson_ID, $section_ID, $user_ID){
		$this->db->trans_begin();

		$sql = $this->get_lesson($lesson_ID);
		$this->create_lesson($section_ID, $sql['title'], $user_ID);

		$end = $this->get_lessons($section_ID);
		$query = end($end);
		foreach ($this->get_contents($lesson_ID) as $row){
			$this->copy_content($row['id'], $query['id'], $user_ID);
		}

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function copy_content($content_ID, $lesson_ID, $user_ID){
		$this->db->trans_begin();

		$sql = $this->get_content($content_ID);

		$this->create_content($lesson_ID, $sql['title'], $sql['url'], $sql['content'], $sql['file'], $sql['thumbnail'], $user_ID);

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function delete_course($course_ID){
		$this->db->set('status', '3');
		$this->db->where('id', $course_ID);
		$this->db->update('course');

		foreach ($this->get_modules($course_ID) as $row){
			$this->delete_module($row['id']);
		}
	}

	public function delete_module($module_ID){
		$this->db->delete('course_module', array('id' => $module_ID));

		foreach ($this->get_sections($module_ID) as $row){
			$this->delete_section($row['id'], $module_ID);
		}
	}

	public function delete_section($section_ID, $module_ID){
		if($module_ID != NULL){
			$this->db->delete('course_section', array('module_ID' => $module_ID));
		}
		$this->db->delete('course_section', array('id' => $section_ID));

		foreach ($this->get_lessons($section_ID) as $row){
			$this->delete_lesson($row['id'], $section_ID);
		}
	}

	public function delete_lesson($lesson_ID, $section_ID){
		if($section_ID != NULL){
			$this->db->delete('course_lesson', array('section_ID' => $section_ID));
		}
		$this->db->delete('course_lesson', array('id' => $lesson_ID));
		foreach ($this->get_contents($lesson_ID) as $row){
			$this->delete_content($row['id']);
		}
	}

	public function delete_content($content_ID){
		$this->db->delete('course_content', array('id' => $content_ID));
		$this->db->delete('course_content_file', array('content_ID' => $content_ID));
		$this->db->delete('videos', array('content_ID' => $content_ID));
	}

	public function hide_all_module($module_ID, $status){
		$this->db->trans_begin();

		$this->db->set('status', $status);
		$this->db->where('id', $module_ID);
		$this->db->update('course_module');

		$this->db->set('status', $status);
		$this->db->where('module_ID', $module_ID);
		$this->db->update('course_section');

		foreach ($this->get_sections($module_ID) as $row){
			$this->hide_all_section($row['id'], $status);
		}

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function hide_all_section($section_ID, $status){
		$this->db->trans_begin();

		$this->db->set('status', $status);
		$this->db->where('id', $section_ID);
		$this->db->update('course_section');

		$this->db->set('status', $status);
		$this->db->where('section_ID', $section_ID);
		$this->db->update('course_lesson');

		foreach ($this->get_lessons($section_ID) as $row){
			$this->hide_all_lesson($row['id'], $status);
		}

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}

	public function hide_all_lesson($lesson_ID, $status){
		$this->db->trans_begin();

		$this->db->set('status', $status);
		$this->db->where('id', $lesson_ID);
		$this->db->update('course_lesson');

		$this->db->set('status', $status);
		$this->db->where('lesson_ID', $lesson_ID);
		$this->db->update('course_content');

		if ($this->db->trans_status() === FALSE){
		    $this->db->trans_rollback();
		    return false;
		} else {
		    $this->db->trans_commit();
		    return true;
		}
	}
}