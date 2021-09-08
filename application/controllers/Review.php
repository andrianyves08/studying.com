<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review extends CI_Controller {

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

	function get_content_review(){
		$data = $this->review_model->get_review(4, NULL, NULL, $this->input->post('content_ID'));
		$output = '';
		foreach($data as $row){
			$output .= '<div class="media mb-2">
	            <img class="rounded-circle ml-2 card-img-100 d-flex z-depth-1 mr-2 chat-mes-id" src="'.base_url().'assets/img/users/'.$row['image'].'" style="height: 50px; width: 50px" alt="Profile photo">
	            <div class="media-body">
	               <h6><a class="text-dark" href="'.base_url().'user-profile/'.$row['user_ID'].'">'.ucwords($row['first_name']).' '.ucwords($row['last_name']).'</a> '.$this->renderStarRating($row['rating']).'</h6>
	               <p class="bg-light rounded p-2">
	                 '.$row['comment'].'
	                 <br> 
	                 <span class="mt-2 ml-2 text-muted text-dark float-right"><small>'.date("F d, Y h:i A", strtotime($row['timestamp'])).'</small></span>
	               </p>
	            </div>
	          ';
			$output .= '</div>';
		}
		echo json_encode($output);
	}

	function get_reviews() {
		if($this->input->post('type') == 0){
			$reviews = $this->review_model->get_review(3, 3, $this->input->post('start'), $this->input->post('course_ID'));
		} else {
			$reviews = $this->review_model->get_review(2, 3, $this->input->post('start'), $this->input->post('instructor_ID'));
		}

		$data = array();
		foreach($reviews as $row){
			$data[] = array(
				'full_name' => ucwords($row['first_name']).' '. ucwords($row['last_name']),
				'username' => $row['username'],
				'image' => $row['image'],
				'comment' => $row['comment'],
				'rating' => $this->renderStarRating($row['rating']),
				'timestamp' => date("F d, Y h:i A", strtotime($row['timestamp']))
			);
		}
		echo json_encode($data);
	}

	function submit_course_review(){
		$data = $this->review_model->create_review($this->input->post('id'), '3', $this->input->post('rating'), $this->input->post('comment'), $this->session->userdata('user_id'));
		echo json_encode($data);
	}


	function submit_instructor_review(){
		$data = $this->review_model->create_review($this->input->post('id'), '2', $this->input->post('rating'), $this->input->post('comment'), $this->session->userdata('user_id'));
		echo json_encode($data);
	}

	function submit_content_review(){
		$data = $this->review_model->create_review($this->input->post('content_ID'), '4', $this->input->post('rating'), $this->input->post('comment'), $this->session->userdata('user_id'));
		echo json_encode($data);
	}
}