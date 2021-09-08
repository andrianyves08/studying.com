<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('upload');
	}

	function get_post() {
		$data = $this->post_model->get_post($this->input->post('post_ID'));
		echo json_encode($data);
	}

	function get_liked() {
		$data = $this->post_model->get_liked($this->session->userdata('user_id'));
		echo json_encode($data);
	}

	function get_likers() {
		$data = $this->post_model->get_likers($this->input->post('post_ID'));
		foreach($data as $key => $value) {
		  	$data[$key]['first_name'] = ucwords($data[$key]['first_name']).' '.ucwords($data[$key]['last_name']);
		}
		echo json_encode($data);
	}

	function get_liked_comments() {
		$data = $this->post_model->get_liked_comments($this->session->userdata('user_id'));
		echo json_encode($data);
	}

		//Upload image summernote
	function upload_image(){
		if(isset($_FILES["image"]["name"])){
			if (!file_exists('./assets/img/posts/'.hash('md5', $this->session->userdata('user_id')))) {
				mkdir('./assets/img/posts/'.hash('md5', $this->session->userdata('user_id')), 0777, true);
				mkdir('./assets/img/posts/thumbs/'.hash('md5', $this->session->userdata('user_id')), 0777, true);
				$fi = 0;
			} else {
				$files = scandir('./assets/img/posts/'.hash('md5', $this->session->userdata('user_id')));
				$fi = count($files)-2;
			}
			$fi = $fi + 1;

			$image_name = hash('md5', $this->session->userdata('user_id')).$fi.".".pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION); 
			$config['upload_path'] = './assets/img/posts/'.hash('md5', $this->session->userdata('user_id'));
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
	        $config['file_name'] = $image_name;

			$this->upload->initialize($config);
			if(!$this->upload->do_upload('image')){
			    $this->upload->display_errors();
				echo FALSE;
			}else{
				$data = $this->upload->data();
				$this->resizeImage($image_name);
				echo $image_name;
			}
		}
	}

 	public function resizeImage($image_name){
		//Compress photo
		$config_2['photo_library']='gd2';
		$config_2['source_image']='./assets/img/posts/'.hash('md5', $this->session->userdata('user_id'))."/".$image_name;
		$config_2['create_thumb']= FALSE;
		$config_2['maintain_ratio']= TRUE;
		$config_2['new_image']= './assets/img/posts/thumbs/'.hash('md5', $this->session->userdata('user_id'))."/".$image_name;
		$config_2['quality']= '40%';
		$config_2['width']= 400;
		$this->load->library('image_lib', $config_2);
		$this->image_lib->initialize($config_2);
		$this->image_lib->resize();
		$this->image_lib->clear();
   }

   	function pin_post() {
		$data = $this->post_model->pin_post($this->input->post('post_ID'), $this->input->post('pin'));
	    echo json_encode($data);
	}

	function edit_post() {
       	$tagged_users_id = $this->get_tagged_users($this->input->post('posts'), '<a href="'.base_url().'', '">@');
		$data = $this->post_model->edit_post($this->input->post('post_ID'), $this->input->post('posts'), $this->input->post('course_ID'), $this->input->post('post_file'), $tagged_users_id, $this->session->userdata('user_id'));

		if($data){
			$this->session->set_flashdata('success', 'Post updated successfully');
		} else {
			$this->session->set_flashdata('error', 'Something error occured. Try again later!');
		}
	    redirect(base_url());
	}

	function image_delete() {
		$this->load->helper("file");
        $image = './assets/img/posts/'.hash('md5', $this->session->userdata('user_id'))."/".$this->input->post('image_name');
        $thumbs = './assets/img/posts/thumbs/'.hash('md5', $this->session->userdata('user_id'))."/".$this->input->post('image_name');
        unlink($image);
        unlink($thumbs);
        echo json_encode(1);
	}

	function create() {
		if(!in_array("", $_FILES['post_image']['name'])) {
			$files = array();
            if (!file_exists('./assets/img/posts/'.hash('md5', $this->session->userdata('user_id')))) {
				mkdir('./assets/img/posts/'.hash('md5', $this->session->userdata('user_id')), 0777, true);
				mkdir('./assets/img/posts/thumbs/'.hash('md5', $this->session->userdata('user_id')), 0777, true);
				$fi = 0;
			} else {
				$files = scandir('./assets/img/posts/'.hash('md5', $this->session->userdata('user_id')));
				$fi = count($files)-2;
			}

            $files = $_FILES;
            $count = count($_FILES ['post_image']['name']);
            for ($i = 0; $i < $count; $i ++) {
                $_FILES['post_image']['name'] = $files['post_image']['name'][$i];
                $_FILES['post_image']['type'] = $files['post_image']['type'][$i];
                $_FILES['post_image']['tmp_name'] = $files['post_image']['tmp_name'][$i];
                $_FILES['post_image']['error'] = $files['post_image']['error'][$i];
                $_FILES['post_image']['size'] = $files['post_image']['size'][$i];

                $file_name = hash('md5', $this->session->userdata('user_id')).$fi.".".pathinfo($_FILES['post_image']['name'], PATHINFO_EXTENSION); 
	            $config['allowed_types'] = 'gif|jpg|png|mp4|mov|mkv|avi';
	            $config['upload_path'] = './assets/img/posts/'.hash('md5', $this->session->userdata('user_id'));
	            $config['file_name'] = $file_name;
	            $config['max_size'] = '1000000'; // max_size in kb

                $this->upload->initialize($config);

            	if($this->upload->do_upload('post_image')){
                    $data = $this->upload->data();
                    $mime = mime_content_type('./assets/img/posts/'.hash('md5', $this->session->userdata('user_id'))."/".$file_name);
                    if(strstr($mime, "image/")){ 
      					$this->resizeImage($file_name);
                    } 
                    $files[] = $file_name; 
	            } else {
	                $error = $this->upload->display_errors();
					$this->session->set_flashdata('error', $error);
	            }
                $fi++;
            }

        	if(!empty($files)){
        		$this->posts($files);
        	} else {
        		redirect($_SERVER['HTTP_REFERER']);
        	}
        } else {
        	$this->posts(NULL);
        }
		//print_r($_FILES['post_image']['name']);
	}

	public function convert($str, $target='_blank') {
        if ($target) {
	        $target = ' target="'.$target.'"';
	    } else {
	        $target = '';
	    }
	    // find and replace link
	    $str = preg_replace('@((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.~]*(\?\S+)?)?)*)@', '<a href="$1" '.$target.'>$1</a>', $str);
	    // add "http://" if not set
	    $str = preg_replace('/<a\s[^>]*href\s*=\s*"((?!https?:\/\/)[^"]*)"[^>]*>/i', '<a href="http://$1" '.$target.'>', $str);
	    return $str;
    }

	function posts($files) {
       	$tagged_users_id = $this->get_tagged_users($this->input->post('posts'), '<a href="'.base_url().'', '">@');
		
		if($files != NULL || $this->input->post('posts') != NULL){
			$posts = $this->convert($this->input->post('posts'));

			$data = $this->post_model->create_post($this->input->post('course_ID'), $files, $posts, $this->session->userdata('user_id'), $tagged_users_id);

			$status = $this->post_model->get_review_status();
			if($status['review_post_status'] == 0){
				$this->session->set_flashdata('success', 'Gained 3 exp!');
			} else {
				$this->session->set_flashdata('success', 'Your post will be reviewed!');
			}
		} else {
			$this->session->set_flashdata('error', 'Enter a posts!');
		}
		redirect($_SERVER['HTTP_REFERER']);
    }

	function edit() {
		$tagged_users_id = $this->get_tagged_users($this->input->post('edit_post_value'), '<a href="'.base_url().'', '">@');
		if($this->input->post('edit_post_value') != NULL){
			$status = $this->post_model->get_review_status();
			$data = $this->post_model->edit($this->input->post('post_ID'), $this->input->post('edit_post_value'), $this->session->userdata('user_id'), $tagged_users_id);
			if($status['review_post_status'] == 0){
				$this->session->set_flashdata('success', 'Post updated successfully!');
			} else {
				$this->session->set_flashdata('success', 'Your post will be reviewed!');
			}
		} else {
			$this->session->set_flashdata('error', 'Enter a posts!');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	function get_tagged_users($str, $startDelimiter, $endDelimiter){
		$contents = array();
		$startDelimiterLength = strlen($startDelimiter);
		$endDelimiterLength = strlen($endDelimiter);
		$startFrom = $contentStart = $contentEnd = 0;
		while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
		    $contentStart += $startDelimiterLength;
		    $contentEnd = strpos($str, $endDelimiter, $contentStart);
			    if (false === $contentEnd) {
			      break;
			    }
		    $contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
		    $startFrom = $contentEnd + $endDelimiterLength;
		}
		return $contents;
	}

	function liked() {
		if($this->input->post('status') == 1){
			$this->post_model->unlike_post($this->input->post('posts'), $this->session->userdata('user_id'));
			$data = array(
				'status' => false,
			);
		} else {
			$this->post_model->like_post($this->input->post('posts'), $this->input->post('user_ID'), $this->session->userdata('user_id'));
			$data = array(
				'status' => true,
			);
		}
		echo json_encode($data);
	}

	function like_comment() {
		if($this->input->post('status') == 1){
			$this->post_model->unlike_comment($this->input->post('comment_ID'), $this->session->userdata('user_id'));
			$data = array(
				'status' => false,
			);
		} else {
			$this->post_model->like_comment($this->input->post('comment_ID'), $this->input->post('user_ID'), $this->input->post('post_ID'), $this->session->userdata('user_id'));
			$data = array(
				'status' => true,
			);
		}
		echo json_encode($data);
	}

	function changetimefromUTC($time) {
		$data = $this->user_model->get_users($this->session->userdata('user_id'));

	    $changetime = new DateTime($time, new DateTimeZone('UTC'));
	    $changetime->setTimezone(new DateTimeZone($data['timezone']));
	    return $changetime->format('M j, Y h:i A');
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

	function isMobile() {
		return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
	}

	function load_more() {
		if($this->input->post('course_ID') > 0){
			$posts = $this->post_model->get_enrolled_post(5, $this->input->post('start'), $this->session->userdata('user_id'));
		} elseif($this->input->post('course_ID') == -2){
			$posts = $this->post_model->get_posts(NULL, 5, $this->input->post('start'), '1', NULL, $this->session->userdata('user_id'));
		} elseif($this->input->post('course_ID') == -3){
			$posts = $this->post_model->get_posts(NULL, 5, $this->input->post('start'), '1', NULL, $this->input->post('user_ID'));
		} elseif($this->input->post('course_ID') == 0){
			$global_post = $this->post_model->get_posts(0, 5, $this->input->post('start'), '1', NULL);
			$enrolled_posts = $this->post_model->get_enrolled_post(5, $this->input->post('start'), $this->session->userdata('user_id'));
			$posts = array_merge($global_post, $enrolled_posts);

			usort($posts, function($a, $b) {
			  return new DateTime($b['timestamp']) <=> new DateTime($a['timestamp']);
			});
		} else {
			$posts = $this->post_model->get_following_post(5, $this->input->post('start'), '1', $this->session->userdata('user_id'));
		}

		$data = array();
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
					'srct' => is_file($filename) ? $filename : './assets/img/posts/thumbs/play_button.jpg',
					'description' =>  $image['description']
				);
			}

			// Avoid duplicate nanogallery
			$numbers = rand(-100000,1000000).$row['post_ID'];

			$data[] = array(
				'title' => $all_courses,
				'numbers' => $numbers,
				'post_ID' => $row['post_ID'],
				'post_status' => $row['post_status'],
				'post' => $row['post'],
				'pin' => $row['pin'],
				'image' => base_url().'assets/img/users/thumbs/'.$row['image'],
				'all_images' =>  !empty($images) ? '<script>nanogallery('.$numbers.', '.json_encode($all_images).');</script>' : '',
				'user_ID' => $row['user_ID'],
				'username' => $row['username'],
				'first_name' => ucwords($row['first_name']),
				'last_name' => ucwords($row['last_name']),
				'total_likes' => $total_likes,
				'total_comments' => $total_comments,
				'timestamp' => $this->changetimefromUTC($row['timestamp']),
			);
		}
		echo json_encode($data);
	}

	function get_comments() {
		$comments = $this->post_model->get_comments($this->input->post('limit'), $this->input->post('start'), $this->input->post('post_ID'));
		$data = array();

		foreach($comments as $row){
			$data[] = array(
				'post_ID' => $row['post_ID'],
				'image' => $row['image'],
				'user_ID' => $row['user_ID'],
				'first_name' => ucwords($row['first_name']),
				'last_name' => ucwords($row['last_name']),
				'username' => $row['username'],
				'comment_ID' => $row['comment_ID'],
				'comment' => $row['comment'],
				'comment_image' => !empty($row['comment_image']) ? base_url().'assets/img/posts/'.hash('md5', $row['user_ID']).'/'.$row['comment_image'] : '',
				'comment_image_thumbs' => !empty($row['comment_image']) ? base_url().'assets/img/posts/thumbs/'.hash('md5', $row['user_ID']).'/'.$row['comment_image'] : '',
				'total_comments' => $this->post_model->get_total_likes_comments($row['comment_ID']),
				'total_replies' => $this->post_model->get_total_replies($row['comment_ID']),
				'timestamp' => $this->time_elapsed_string($row['timestamp']),
			);
		}
		echo json_encode($data);
	}

	function get_replies() {
		$replies = $this->post_model->get_replies($this->input->post('post_ID'), $this->input->post('comment_ID'));
		$data = array();

		foreach($replies as $row){
			$data[] = array(
				'post_ID' => $row['post_ID'],
				'image' => $row['image'],
				'user_ID' => $row['user_ID'],
				'owner_post' => $row['owner_post'],
				'first_name' => ucwords($row['first_name']),
				'last_name' => ucwords($row['last_name']),
				'username' => $row['username'],
				'comment_ID' => $row['comment_ID'],
				'comment' => $row['comment'],
				'comment_image' => !empty($row['comment_image']) ? base_url().'assets/img/posts/'.hash('md5', $row['user_ID']).'/'.$row['comment_image'] : '',
				'comment_image_thumbs' => !empty($row['comment_image']) ? base_url().'assets/img/posts/thumbs/'.hash('md5', $row['user_ID']).'/'.$row['comment_image'] : '',
				'total_likes' => $this->post_model->get_total_likes_comments($row['comment_ID']),
				'timestamp' => $this->time_elapsed_string($row['timestamp']),
			);
		}
		echo json_encode($data);
	}

	function add_comment() {
		$image = NULL;
		if(!empty($this->input->post('image'))){
			$image = $this->input->post('image');
		}
		$tagged_users_id = $this->get_tagged_users($this->input->post('comment'), '<a href="'.base_url().'', '">@');

		$data = $this->post_model->add_comments($image, $this->input->post('post_ID'), $this->input->post('comment'), $this->input->post('comment_ID'), $this->input->post('user_ID'), $this->session->userdata('user_id'), $tagged_users_id);
		echo json_encode($data);
	}

	function delete_post() {
		$data = $this->post_model->delete_post($this->input->post('post_ID'));
		echo json_encode($data);
	}

	function delete_comment() {
		$data = $this->post_model->delete_comment($this->input->post('comment_ID'));
		echo json_encode($data);
	}

	function approve_post() {
		$data = $this->post_model->approve_post($this->input->post('post_ID'), $this->input->post('user_ID'));
		echo json_encode($data);
	}

	function deny_post() {
		$data = $this->post_model->deny_post($this->input->post('post_ID'), $this->input->post('user_ID'));
		echo json_encode($data);
	}

	function get_on_review_posts() {
		$data = $this->post_model->get_on_review_posts();
		echo json_encode($data);
	}
}