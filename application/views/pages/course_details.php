<?php 
  $CI =& get_instance();
  $CI->load->model('course_model');
  $CI->load->model('purchase_model');
  $CI->load->model('review_model');

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
?>
<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-4 col-md-4 col-sm-12">
      <div class="card mb-4">
        <div class="view overlay">
          <img class="card-img-top" src="<?php echo $course['image']; ?>" alt="Card image cap" onerror="this.onerror=null;this.src='<?php echo base_url();?>assets/img/logo-3.jpg';">
          <a href="#!">
            <div class="mask rgba-white-slight"></div>
          </a>
        </div><!-- View -->
        <div class="card-body d-flex flex-row">
          <div class="text-left">
            <div class="d-flex align-items-center">
              <h4><strong><?php echo ucwords($course['title']);?></strong></h4>
            </div>
            <h5 class="indigo-text"><strong>Created By <?php echo ucwords($instructor['first_name']);?> <?php echo ucwords($instructor['last_name']);?></strong></h5>
            <p class="card-text"><?php echo ucfirst($course['description']);?></p>
            <?php echo round($rating['avg'], 1); ?><?php echo renderStarRating($rating['avg']); ?>
            <p><?php echo count($course_reviews); ?> Reviews</p>
            <p><?php echo $users_course['total']; ?> students</p>
            <p>Last Updated: <?php echo date("F d, Y", strtotime($course['date_modified']));?></p>
            <a class="btn btn-primary btn-sm" href="<?php echo base_url(); ?>course/checkout/<?php echo $course['slug']?>">Buy Course</a>
            <a class="btn btn-secondary btn-sm" type="button" href="<?php echo base_url().'course/'.$course['slug']; ?>">Check Course</a>
            <?php 
              $check_purchased = $CI->purchase_model->users_course($my_info['id'], NULL, $course['slug']);
              $check_course_review = $CI->review_model->get_review(3, 0, 0, $course['course_ID'], $my_info['id']);
              $check_instructor_review = $CI->review_model->get_review(2, 0, 0, $course['user_ID'], $my_info['id']);
              if($check_purchased && !$check_course_review && $my_info['id'] != $course['user_ID']){ ?>
              <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#course_review_modal">Write a Review</a>
            <?php } ?>
          </div>
        </div><!-- Card Body-->
      </div><!-- Card -->

      <h4><strong>Course Reviews</strong></h4>
      <?php if(empty($course_reviews)){ echo 'No Reviews'; } ?>
      <div class="card mb-4">
        <div class="card-body" <?php if(empty($course_reviews)){ echo 'hidden'; } ?>>
          <?php $i=0; foreach ($course_reviews as $row){ ?>
          <div class="media mb-4 course_reviews">
            <img class="rounded-circle ml-2 card-img-100 d-flex z-depth-1 mr-2 chat-mes-id" src="<?php echo base_url();?>assets/img/users/<?php echo $row['image'];?>" style="height: 50px; width: 50px" alt="Profile photo" onerror="this.onerror=null;this.src='<?php echo base_url();?>assets/img/users/stock.jpg';">
            <div class="media-body">
              <h4><a class="text-dark" href="<?php echo base_url().$row['username']; ?>"><?php echo ucwords($row['first_name']);?> <?php echo ucwords($row['last_name']);?></a></h4>
              <?php echo renderStarRating($row['rating']); ?>
              <span class="ml-2 text-muted text-dark"><small><?php echo date("F d, Y", strtotime($row['timestamp']));?></small></span>
               <p class="bg-light rounded p-2">
                 <?php echo $row['comment']; ?>
               </p>
            </div>
          </div>
          <?php $i++; if($i == 3){ break; } } ?>
          <div class="text-center" <?php if(count($course_reviews) <= 3){ echo 'hidden';} ?>>
            <a class="blue-text view_more" data-id="0" id="course_reviews">View More</a>
          </div>
        </div>
      </div><!-- Card -->

      <h4><strong>Instructor Reviews</strong></h4>
      <?php if(empty($instructor_reviews)){ echo 'No Reviews'; } ?>
      <div class="card mb-4">
        <div class="card-body">
          <div class="d-flex flex-row mb-4">
            <img src="<?php echo base_url();?>assets/img/users/<?php echo $instructor['image'];?>" class="rounded-circle w-25 img-fluid z-depth-1 mr-2" alt="avatar">
            <div><a href="<?php echo base_url();?><?php echo $instructor['username']; ?>"><h5><strong><?php echo ucwords($instructor['first_name']);?> <?php echo ucwords($instructor['last_name']);?></a></strong></h5>
              <p><?php echo $count_followers['total']; ?> Followers</p>
              <p><?php echo count($instructor_reviews); ?> Reviews</p>
              <p><?php echo count($my_students); ?> Students</p>
              <p><?php echo count($my_courses); ?> Courses</p>
            </div>
          </div>
          <?php
            if($check_purchased && !$check_instructor_review && $my_info['id'] != $course['user_ID']){ ?>
            <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#instructor_review_modal">Write a Review</a>
          <?php } ?>
          <?php if(!empty($instructor_reviews)){
          $i=0; foreach ($instructor_reviews as $row){ ?>
          <div class="media mb-4 instructor_reviews">
            <img onerror="this.onerror=null;this.src='<?php echo base_url();?>assets/img/users/stock.jpg';" class="rounded-circle ml-2 card-img-100 d-flex z-depth-1 mr-2 chat-mes-id" src="<?php echo base_url();?>assets/img/users/<?php echo $row['image'];?>" style="height: 50px; width: 50px" alt="Profile photo">
            <div class="media-body">
              <h4><a class="text-dark" href="<?php echo base_url().$row['user_ID']; ?>"><?php echo ucwords($row['first_name']);?> <?php echo ucwords($row['last_name']);?></a></h4>
              <?php echo renderStarRating($row['rating']); ?>
              <span class="ml-2 text-muted text-dark"><small><?php echo $row['timestamp'];?></small></span>
              <p class="bg-light rounded p-2"><?php echo $row['comment']; ?></p>
            </div>
          </div>
          <?php $i++; if($i == 3){ break; } } } ?>
          <div class="text-center" <?php if(count($instructor_reviews) <= 3){ echo 'hidden'; } ?>>
            <a class="blue-text view_more" data-id="1" id="instructor_reviews">View More</a>
          </div>
        </div>
      </div><!-- Card -->
    </div><!--Column -->
    <div class="col-lg-6">
      <h4><strong>Course Content</strong></h4>
      <?php echo $total_modules['total_modules']; ?> Modules • <?php echo $total_sections['total_sections']; ?> Sections • <?php echo $total_lessons['total_lessons']; ?> Lessons • <?php echo $total_contents['total_contents']; ?> Contents • <?php echo gmdate('H', $duration['total']); ?>h <?php echo gmdate('i', $duration['total']); ?>m total length
      <?php foreach($modules as $module){ ?>
        <?php if($module['status'] == 1){ 
          $sections = $CI->course_model->get_sections($module['id']);
        ?>
      <div class="mt-2 accordion md-accordion accordion-2 mb-1" id="module_<?php echo $module['id']; ?>" role="tablist" aria-multiselectable="true">
        <div class="card">
          <div class="card-header customcolorbg z-depth-1 mb-1" role="tab">
            <a data-toggle="collapse" data-parent="#module_<?php echo $module['id']; ?>" href="#collapse_<?php echo $module['id']; ?>" aria-expanded="true" aria-controls="collapse_<?php echo $module['id']; ?>">
              <h5 class="mb-0 white-text text-uppercase font-thin">
                 <?php echo ucfirst($module['title']); ?><i class="ml-2 fas fa-angle-down rotate-icon"></i>
              </h5>
            </a>
          </div>
          <div id="collapse_<?php echo $module['id']; ?>" class="collapse" role="tabpanel" aria-labelledby="heading1" data-parent="#module_<?php echo $module['id']; ?>">
            <div class="card-body mb-1 white-text">
              <?php foreach ($sections as $section){ ?>
                <?php if($section['status'] == 1){ 
                  $lessons = $CI->course_model->get_lessons($section['id']); ?>
                <div class="accordion md-accordion accordion-2 mb-2" id="section_<?php echo $section['id']; ?>" role="tablist" aria-multiselectable="true">
                  <a data-toggle="collapse" data-parent="#section_<?php echo $section['id']; ?>" href="#collapse_section_<?php echo $section['id']; ?>" aria-expanded="true" aria-controls="collapse_section_<?php echo $section['id']; ?>">
                    <h5 class="mb-0 text-uppercase font-thin">
                       <?php echo ucfirst($section['title']); ?><i class="ml-2 fas fa-angle-down rotate-icon"></i>
                    </h5>
                  </a>
                  <div id="collapse_section_<?php echo $section['id']; ?>" class="collapse" role="tabpanel" aria-labelledby="heading1" data-parent="#section_<?php echo $section['id']; ?>">
                    <?php foreach ($lessons as $lesson){ ?>
                      <?php if($lesson['status'] == 1){ 
                        $contents = $CI->course_model->get_contents($lesson['id']); ?>
                        <div class="ml-4 accordion md-accordion accordion-2 mb-2" id="lesson_<?php echo $lesson['id']; ?>" role="tablist" aria-multiselectable="true">
                            <a data-toggle="collapse" data-parent="#lesson_<?php echo $lesson['id']; ?>" href="#collapse_lesson_<?php echo $lesson['id']; ?>" aria-expanded="true" aria-controls="collapse_lesson_<?php echo $lesson['id']; ?>">
                              <h5 class="mb-0 text-uppercase font-thin">
                                 <?php echo ucfirst($lesson['title']); ?><i class="ml-2 fas fa-angle-down rotate-icon"></i>
                              </h5>
                            </a>
                            <div id="collapse_lesson_<?php echo $lesson['id']; ?>" class="collapse" role="tabpanel" aria-labelledby="heading1"
                              data-parent="#lesson_<?php echo $lesson['id']; ?>">
                            <?php foreach ($contents as $content){ ?>
                              <?php if($content['status'] == 1){ ?>
                                <div class="row justify-content-between">
                                  <div class="col-6">
                                    <h6 class="ml-4 font-thin text-dark "><?php echo ucfirst($content['title']); ?></h6>
                                  </div>
                                  <div class="col-6">
                                    <span class="text-dark text-right duration_<?php echo $content['id']; ?>"></span>
                                  </div>
                                </div>
                              <?php } ?>
                            <?php } ?>
                            </div>
                        </div>
                      <?php } ?>
                    <?php } ?>
                  </div>
                </div>
                <?php } ?>
              <?php } ?>
            </div>
          </div>
        </div><!-- Accordion card -->
      </div>
      <?php } ?>
      <?php } ?>
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main>
<?php 
$check_purchased = $CI->purchase_model->users_course($my_info['id'], NULL, $course['slug']);
if($check_purchased){ ?>
<!-- Modal -->
<div class="modal fade" id="course_review_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Write Course Review</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5>Rating</h5>
        <span id="rating_course" class="mb-4"></span>
        <input type="hidden" id="course_rating" name="course_rating">
        <div class="form-group">
          <label>Comment</label>
          <textarea class="form-control rounded-0" id="course_comment" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="send_course_review">Send Review</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="instructor_review_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Write Instructor Review</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5>Rating</h5>
        <span id="rating_instructor" class="mb-4"></span>
        <input type="hidden" id="instructor_rating" name="instructor_rating">
        <div class="form-group">
        <label>Comment</label>
          <textarea class="form-control rounded-0" id="instructor_comment" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="send_instructor_review">Send Review</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
$(document).ready(function(){
  $('#rating_course').mdbRate();
  $('#rating_course').hover(function() {
    var count = $('#rating_course .amber-text').length;
    $('[name="course_rating"]').val(count);
  });

  $('#send_course_review').on('click',function(){
    var comment = $('#course_comment').val();
    var id = '<?php echo $course['course_ID']?>';
    var rating = $('#course_rating').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>review/submit_course_review",
      dataType : "JSON",
      data : {id:id, comment:comment, rating:rating},
      success: function(data){
        $('#course_review_modal').modal('hide');
        toastr.success('Review submitted!');
      }
    });
  });

  $('#rating_instructor').mdbRate();
  $('#rating_instructor').hover(function() {
    var count = $('#rating_instructor .amber-text').length;
    $('[name="instructor_rating"]').val(count);
  });

  $('#send_instructor_review').on('click',function(){
    var comment = $('#instructor_comment').val();
    var id = '<?php echo $instructor['id'];?>';
    var rating = $('#instructor_rating').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>review/submit_instructor_review",
      dataType : "JSON",
      data : {id:id, comment:comment, rating:rating},
      success: function(data){
        $('#instructor_review_modal').modal('hide');
        toastr.success('Review submitted!');
      }
    });
  });
});
</script>
<?php } ?>
<script type="text/javascript">
$(document).ready(function(){
  $.ajax({
    type : "POST",
    url  : base_url +"video/all_videos",
    dataType : "JSON",
    success: function(data){
      for(i=0; i<data.length; i++){
        $('.duration_'+data[i].content_ID).text(secondsTimeSpanToHMS(Math.round(data[i].duration)));
      }
    }
  });

  function secondsTimeSpanToHMS(s) {
    var h = Math.floor(s/3600); //Get whole hours
    s -= h*3600;
    var m = Math.floor(s/60); //Get remaining minutes
    s -= m*60;
    return h+":"+(m < 10 ? '0'+m : m)+":"+(s < 10 ? '0'+s : s); //zero padding on minutes and seconds
  }

  var start_0 = 3;
  var start_1 = 3;
  $(document).on("click", ".view_more", function() { 
    var type = $(this).data('id');
    var course_ID = '<?php echo $course['course_ID'];?>';
    var instructor_ID = '<?php echo $instructor['id'];?>';
    var spinner = '<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>';
    if(type == 0){
      var start = start_0;
      var spinner_html = $('#course_reviews').html(spinner);  
    } else {
      var start = start_1;
      var spinner_html = $('#instructor_reviews').html(spinner);  
    }
    $.ajax({
      url: "<?=base_url()?>review/get_reviews",
      type: 'post',
      dataType : "JSON",
      data: {start:start, course_ID:course_ID, type:type, instructor_ID:instructor_ID},
      beforeSend:function(){
        spinner_html;
      },
      success: function(data){
        var html = '';
        var i;
        for(i=0; i<data.length; i++){
          html += '<div class="media mb-4 ';
          if(type == 0){
            html += 'course_reviews';
          } else {
            html += 'instructor_reviews';
          }
          html += ' "><img class="rounded-circle ml-2 card-img-100 d-flex z-depth-1 mr-2 chat-mes-id" src="<?php echo base_url();?>assets/img/users/'+data[i].image+'" style="height: 50px; width: 50px" alt="Profile photo" onerror="this.onerror=null;this.src=\'<?php echo base_url();?>assets/img/user/stock.jpg\';"><div class="media-body"><h4><a class="text-dark" href="<?php echo base_url(); ?>'+data[i].username+'">'+data[i].full_name+'</a></h4>'+data[i].rating+'<span class="ml-2 text-muted text-dark"><small>'+data[i].timestamp+'</small></span><p class="bg-light rounded p-2">'+data[i].comment+'</p></div></div>';
        }

        if(type == 0){
          $('#course_reviews').text("View more");
          $(".course_reviews:last").after(html).show().fadeIn("slow");
          start_0 = start_0 + 3;
          if(!$.trim(data)) {
            $("#course_reviews").hide();
          }
        } else {
          $('#instructor_reviews').text("View more")
          $(".instructor_reviews:last").after(html).show().fadeIn("slow");
          start_1 = start_1 + 3;
          if(!$.trim(data)) {
            $("#instructor_reviews").hide();
          }
        }

      }
    });
  });
});
</script>