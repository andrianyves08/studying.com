<?php
	class Video_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }
   
   	function get_videos(){
    	$this->db->where('duration is NOT NULL', NULL, FALSE);
		$this->db->group_by('content_ID');
		$query = $this->db->get('videos');
		return $query->result_array();
	}

    public function get_user_videos($user_id){
    	$this->db->select('course_module.sort as row, course_module.title as title, course_content.title as content_title, videos.timestamp as timestamp, videos.status as status, course_content.id as content_ID, course_module.slug as module_slug, course_section.slug as section_slug, course.slug as course_slug');
	    $this->db->join('course_content', 'course_content.id = videos.content_ID');
	    $this->db->join('course_lesson', 'course_lesson.id = course_content.lesson_ID');
	    $this->db->join('course_section', 'course_section.id = course_lesson.section_ID');
	    $this->db->join('course_module', 'course_module.id = course_section.module_ID');
	    $this->db->join('course', 'course.id = course_module.course_ID');
	   
		$this->db->where('videos.user_ID', $user_id);
		$this->db->order_by('videos.timestamp', 'DESC');

		$query = $this->db->get('videos');
		return $query->result_array();
	}

	function last_watched($user_id){
		$this->db->select('course_module.title as title, course_module.slug as slug, course_content.id as content_ID, course_content.title as content_title, course_content.sort as content_row, course_content.url as content_url, course_section.slug as section_slug, course.slug as course_slug');
	    $this->db->join('course_content', 'course_content.id = videos.content_ID');
	    $this->db->join('course_lesson', 'course_lesson.id = course_content.lesson_ID');
	    $this->db->join('course_section', 'course_section.id = course_lesson.section_ID');
	    $this->db->join('course_module', 'course_module.id = course_section.module_ID');
	    $this->db->join('course', 'course.id = course_module.course_ID');
	    $this->db->join('purchase', 'course.id = purchase.course_ID');
		$this->db->where('videos.user_ID', $user_id);
		$this->db->order_by('videos.timestamp', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('videos');
		return $query->row_array();
	}

	function track_progress($duration, $progress, $user_ID, $content_ID, $src){
		$query = $this->db->where('content_ID', $content_ID)->where('user_ID', $user_ID)->where('status', '1')->from("videos")->count_all_results();
		if($query == 0){
			$data = array(
				'src'  => $src,
		        'progress'  => $progress,
		        'duration'  => $duration,
		        'content_ID'  => $content_ID,
		        'status'  => '0',
		        'user_ID'  => $user_ID
			);
			return $this->db->replace('videos', $data);
		} else {
			$data = array(
				'src'  => $src,
		        'progress'  => $progress,
		        'duration'  => $duration,
		        'content_ID'  => $content_ID,
		        'status'  => '1',
		        'user_ID'  => $user_ID
			);
			return $this->db->replace('videos', $data);
		}
	}

	function get_progress($user_ID, $content_ID = FALSE){
		if($content_ID === FALSE){
			$query = $this->db->get_where('videos', array('user_ID' => $user_ID));
			return $query->result_array();
		}
		$query = $this->db->get_where('videos', array('user_ID' => $user_ID, 'content_ID' => $content_ID));
		return $query->row_array();
	}

	function finished_watched($user_ID, $content, $duration){
		$query = $this->db->where('content_ID', $content)->where('user_ID', $user_ID)->where('status', '1')->from("videos")->count_all_results();

		if($query == 0){
			$this->load->model('user_model', 'users');
			$this->db->set('status', '1');
			$this->db->where('user_ID', $user_ID);
			$this->db->where('content_ID', $content);
			$this->db->update('videos');

			if($duration <= 300){
				$exp = 3;
			} elseif (301 <= $duration  && $duration <= 600) {
				$exp = 7;
			} elseif (601 <= $duration  && $duration <= 1200) {
				$exp = 12;
			} elseif (1201 <= $duration  && $duration <= 1800) {
				$exp = 18;
			} elseif (1801 <= $duration  && $duration <= 2400) {
				$exp = 25;
			} elseif (2401 <= $duration  && $duration <= 3000) {
				$exp = 33;
			} elseif (3001 <= $duration  && $duration <= 3600) {
				$exp = 42;
			} elseif ($duration > 3601) {
				$exp = 50;
			}
			$this->users->gain_exp($user_ID, $exp);

			return $exp;
		} else {
			return false;
		}
	}

	function users_videos_watched($module_ID, $section_ID, $user_id){
		$this->db->select('count(videos.user_ID) as total');
	    $this->db->join('course_content', 'course_content.id = videos.content_ID');
	    $this->db->join('course_lesson', 'course_lesson.id = course_content.lesson_ID');
	    $this->db->join('course_section', 'course_section.id = course_lesson.section_ID');
	    $this->db->join('course_module', 'course_module.id = course_section.module_ID');
		$this->db->where('videos.user_ID', $user_id);
		$this->db->where('videos.status', '1');
		if($module_ID != NULL){
    		$this->db->where('course_module.id', $module_ID);
    	}

    	if($section_ID != NULL){
    		$this->db->where('course_section.id', $section_ID);
    	}

		$query = $this->db->get('videos');
		return $query->row_array();
	}

	public function get_course_duration($course_ID = FALSE){
		$this->db->select('sum(videos.duration) AS total');
		$this->db->join('course_content', 'course_content.id = videos.content_ID', 'left');
		$this->db->join('course_lesson', 'course_lesson.id = course_content.lesson_ID', 'left');
		$this->db->join('course_section', 'course_section.id = course_lesson.section_ID', 'left');
		$this->db->join('course_module', 'course_module.id = course_section.module_ID', 'left');
		$this->db->join('course', 'course.id = course_module.course_ID', 'left');
    	if($course_ID === FALSE){
			$query = $this->db->get('videos');
			return $query->result_array();
		}
		$this->db->where('course.id', $course_ID);
		$query = $this->db->get('videos');

		return $query->row_array();
	}
}