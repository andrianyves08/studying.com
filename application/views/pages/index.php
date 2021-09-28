<style type="text/css">
.files input {
    outline: 2px dashed #92b0b3;
    outline-offset: -10px;
    -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
    transition: outline-offset .15s ease-in-out, background-color .15s linear;
    padding: 120px 0px 85px 35%;
    text-align: center !important;
    margin: 0;
    width: 100% !important;
}
.files input:focus{     outline: 2px dashed #92b0b3;  outline-offset: -10px;
    -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
    transition: outline-offset .15s ease-in-out, background-color .15s linear; border:1px solid #92b0b3;
 }
.files{ position:relative}
.files:after {  pointer-events: none;
    position: absolute;
    top: 60px;
    left: 0;
    width: 50px;
    right: 0;
    height: 56px;
    content: "";
    background-image: url(https://image.flaticon.com/icons/png/128/109/109612.png);
    display: block;
    margin: 0 auto;
    background-size: 100%;
    background-repeat: no-repeat;
}
.color input{ background-color:#f1f1f1;}
.files:before {
    position: absolute;
    bottom: 10px;
    left: 0;  pointer-events: none;
    width: 100%;
    right: 0;
    height: 57px;
    content: " or drag it here. ";
    display: block;
    margin: 0 auto;
    color: #2ea591;
    font-weight: 600;
    text-transform: capitalize;
    text-align: center;
}
</style>
<?php
    $CI =& get_instance();
    $CI->load->model('post_model');
    $CI->load->model('instructor_model');
    $CI->load->model('course_model');


?>
<main class="pt-5">
  <div class="container-fluid mt-5">
    <section class="text-center mb-4">
      <div class="row">
        <div class="col-md-12">
          <?php if(strtotime($my_info['date_created']) > strtotime('-3 days')){ ?>
            <h1>Welcome to </h1>
          <?php } ?>
          <picture>
            <img src="<?php echo base_url();?>assets/img/<?php echo $settings['logo_img'];?>" class="img-fluid mb-3" alt="" style="height: 70px;">
          </picture>
          <p class="h4 text-dark mb-4">Dedicated to creating the most innovating<br> educational experiences EVER.</p>
          <div class="mt-5 pt-5 form-inline md-form mr-auto justify-content-center ">
            <form action="<?=site_url('search');?>" method="get">
              <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="search">
              <button class="btn btn-primary btn-rounded btn-sm my-0" type="submit">Search</button>
            </form> 
             <a href="<?php echo base_url(); ?>browse" class="btn btn-secondary btn-rounded btn-sm my-0">Browse Course</a>
          </div>
        </div><!--Grid column-->
      </div><!--Grid row-->
    </section><!--Section-->
    <section class="mb-4 mt-4 pt-4">
      <div class="row justify-content-center">
        <div class="col-lg-4 mb-4 text-left">
          <button class="btn btn-success btn-md waves-effect waves-light mb-2" data-toggle="modal" data-target="#daily_login"> View Login Streak
            <i class="fa fa-fire ml-1"></i>
          </button>
            <?php if(!empty($last_watched['title'])){ ?>
              <h3 class="mb-3"><i class="fas fa-eye amber-text" aria-hidden="true"></i><strong>Last Video Watched</strong></h3>
              <h6><strong><?php echo ucwords($last_watched['title']);?></strong></h6>
              <p><?php echo ucwords($last_watched['content_title']);?></p>
              <div class="d-flex mt-2">
                <a href="<?php echo base_url(); ?>course/<?php echo $last_watched['course_slug'];?>/<?php echo $last_watched['slug'];?>/<?php echo $last_watched['section_slug'];?>#<?php echo $last_watched['content_ID'];?>" class="btn btn-primary btn-md waves-effect waves-light m-0 px-2 py-2 button_press" data-id="1"> Continue to last video
                <i class="far fa-image ml-1"></i>
                </a>
                <a href="<?php echo base_url().$my_info['username']; ?>" class="btn btn-info btn-md waves-effect waves-light m-0 px-2 py-2 button_press" data-id="2"> View history
                  <i class="far fa-image ml-1"></i>
                </a>
              </div>
           <?php } ?>
            <?php $unique_instructor = array(); foreach ($my_purchases as $my_purchase) {
              if (!in_array($my_purchase['instructor_ID'], $unique_instructor)) {
                $unique_instructor[] = $my_purchase['instructor_ID'];
                $announcement = $CI->instructor_model->get_announcement($my_purchase['instructor_ID']);
                $schedules = $CI->instructor_model->get_schedule($my_purchase['instructor_ID']);
            ?>
            <?php if(!empty($announcement['announcement']) && !empty($schedules)){ ?>
              <h3 class="mt-4 mb-3"><i class="fas fa-newspaper amber-text" aria-hidden="true"></i> <strong>Instructor <?php echo ucwords($my_purchase['first_name']); ?> <?php echo ucwords($my_purchase['last_name']); ?></strong></h3>
            <?php } ?>
            <?php if(!empty($announcement['announcement'])){ ?>
              <h4><strong>Announcements</strong></h4>
                <?php echo $announcement['announcement']; ?>
              <br>
            <?php } ?>
             <?php if(!empty($schedules)){ ?>
                <h4><strong>Mastermind Call Schedule</strong></h4>
            <?php } ?>
          
            <?php $i=0; foreach ($schedules as $schedule) {
              echo '<h5>';

              $day = $schedule['day'].' '.$schedule['time'];
              $datetime = new DateTime($day, new DateTimeZone($schedule['timezone']));
              $datetime->setTimeZone(new DateTimeZone($timezone));
              $triggerOn = $datetime->format('D h:i A');
              echo ' <span class="time_'.$i.'">'.$triggerOn.'</span> '.$schedule['note'].'<h5>';
             $i++; } ?>
            <?php } } ?>
            <div class="card mb-4 mt-4">
            <div class="card-header customcolorbg text-white h6">
              <i class="fas fa-crown amber-text" aria-hidden="true"></i> Rankings  
            </div>
            <div class="card-body">
              <?php foreach ($rankings as $ranking) { ?>
                <img src="<?php echo base_url();?>assets/img/<?php echo $ranking['image'];?>" class="rounded-circle float-left" height="25px" width="25px" alt="avatar">
                <h6 class="card-title text-left"><strong>Level <?php echo ucwords($ranking['level']);?></strong> <a href="<?php echo base_url().'profile/'.$ranking['id']; ?>"><?php echo ucwords($ranking['first_name']);?> <?php echo ucwords($ranking['last_name']);?></a></h6>
              <?php } ?>
              <a href="<?php base_url(); ?>rankings" class="btn btn-primary btn-md waves-effect waves-light">View All</a>
            </div>
          </div><!--/.Card-->
        </div><!--Grid column-->
        <div class="col-lg-6">
          <div class="mb-2">
            <a class="change_feed" data-course-id="0"><span class="badge badge-pill badge-primary">#Global</span></a>
            <a class="change_feed" data-course-id="-1"><span class="badge badge-pill badge-secondary">#Following</span></a>
            <a class="change_feed" data-course-id="1"><span class="badge badge-pill badge-info">#Enrolled Courses</span></a>
          </div>
          <?php if(!empty($my_purchases)){ ?>
            <?php echo form_open_multipart('posts/create'); ?>
              <div class="card mb-4">
                <div class="media mt-2">
                  <img onerror="this.onerror=null;this.src='<?php echo base_url();?>assets/img/users/stock.jpg';" class="rounded-circle ml-2 card-img-100 d-flex z-depth-1 mr-2 chat-mes-id" src="<?php echo base_url();?>assets/img/users/<?php echo $my_info['image'];?>" style="height: 50px; width: 50px" alt="Profile photo"/>
                  <div class="media-body d-flex">
                    <textarea type="textarea" class="textarea_post" name="posts" id="posts"></textarea>
                  </div>
                </div>
                <div id="body_bottom_0" class="ml-4 image_textarea">
                  <div class="preview_0"></div>
                </div>
                <div class="card-body py-0 mt-2">
                  <div class="float-right border-top">
                    <input type="hidden" name="image" id="image_0">
                    <input type="file" style="display:none;" name="post_image[]" id="post_image_0" multiple accept="video/mp4,video/x-m4v,video/*,image/x-png,image/gif,image/jpeg">
                    <button type="button" class="btn btn-link mr-2" data-toggle="modal" data-target="#upload_image_modal"><i class="fas fa-photo-video green-text mr-2"></i>Photo / Video</button>
                    <select class="select2" name="course_ID[]" multiple="multiple" data-placeholder="Select where to posts" name="course_ID" style="width: 300px;" required>
                      <option value="0">Global</option>
                      <?php foreach ($my_purchases as $row) { ?>
                      <option value="<?php echo $row['course_ID'];?>"><?php echo ucwords($row['title']);?></option>
                      <?php } ?>
                    </select>
                    <button class="btn btn-primary btn-sm" type="submit" id="create_posts">Posts</button>
                  </div>
                </div>
              </div><!-- Card -->
            <?php echo form_close(); ?>
          <?php } ?>
          <div id="timeline" data-course-id="0">
          <?php
          foreach ($posts as $post) {
            $images = $CI->post_model->get_post_files($post['post_ID']);
            $comments = $CI->post_model->get_comments(2, 0, $post['post_ID']);
            $total_likes = $CI->post_model->total_likes($post['post_ID']);
            $total_comments = $CI->post_model->total_comments($post['post_ID']);
            $course = $CI->course_model->get_course(NULL, NULL, 0, '1', $post['course_ID']);
          ?>
          <div class="card mb-4 posts post_id_<?php echo $post['post_ID']; ?>">
            <div class="media mt-2">
              <img onerror="this.onerror=null;this.src='<?php echo base_url();?>assets/img/users/stock.jpg';" class="rounded-circle ml-2 card-img-100 d-flex z-depth-1 mr-2 chat-mes-id" src="<?php echo base_url();?>assets/img/users/<?php echo $post['image'];?>" style="height: 50px; width: 50px" alt="Profile photo">
              <div class="media-body">
                 <h5><a class="text-dark profile_popover" href="<?php echo base_url().''.$post['username']; ?>" data-user-id="<?php echo $post['user_ID'];?>"><?php echo ucwords($post['first_name']);?> <?php echo ucwords($post['last_name']);?></a>
                  <?php 

                    if(empty($course)){
                      echo '<span class="mr-2"><small style="font-size: 14px; font-weight: 600;">#Global</small></span>';
                    } else {
                      echo '<span class="ml-1 mr-2"><small style="font-size: 14px; font-weight: 600;">#'.ucfirst($course['title']).'</small></span>';

                    }
                  ?>
                  <?php if ($post['user_ID'] == $my_info['id']) {?>
                  <a class="float-right mr-2 post_popover" data-toggle="popover" alt="<?php echo $post['post_ID'];?>" data-post-id="<?php echo $post['post_ID'];?>"><i class="fas fa-ellipsis-v"></i></span></a>
                  <?php } ?>
                </h5>
                <a href="<?php echo base_url().''.$post['username']; ?>/posts/<?php echo $post['post_ID'];?>" class="text-muted text-dark"><small><?php echo changetimefromUTC($post['timestamp'], $timezone);?></small></a>
              </div>
            </div>
            <div class="card-body py-0 mt-2">
             <?php echo ucfirst($post['post']);?>
              <?php
                if (!empty($images)) {
                  $all_images = array();
                  $total = count($images);
                  foreach ($images as $image) { 
                    $filename = './assets/img/posts/thumbs/'.hash('md5', $post['user_ID']).'/'.$image['file'];
                    $all_images[] = array(
                      'src' => './assets/img/posts/'.hash('md5', $post['user_ID']).'/'.$image['file'],
                      'srct' =>  is_file($filename) ? $filename : './assets/img/posts/thumbs/play_button.jpg',
                      'description' =>  $image['description']
                    );
                }
              ?>
                <div id="nanogallery_<?php echo $post['post_ID']; ?>" ></div>
                <script>
                  nanogallery(<?php echo $post['post_ID']; ?>, <?php echo json_encode($all_images); ?>);
                </script>
              <?php } ?>
              <div class="mt-4 mb-2">
                <?php if($total_likes > 0){ echo '<a class="view_likers" data-post-id="'.$post['post_ID'].'"><i class="far fa-thumbs-up text-primary mr-2"></i>'.$total_likes.'</a>'; } ?>
                <?php if($total_comments > 0){ echo '<span class="float-right text-center mb-2" data-post-id="'.$post['post_ID'].'" data-user-id="'.$post['user_ID'].'">'.$total_comments.'<i class="far fa-comment-alt text-primary ml-2"></i></span>'; } ?>
              </div>
              <div class="d-flex justify-content-between text-center border-top border-bottom w-100">
              <?php if(!empty($my_purchases)){ ?>
                <a class="p-3 ml-2 liked liked_<?php echo $post['post_ID'];?>" data-post-id="<?php echo $post['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>" data-status="0"><i class="far fa-thumbs-up mr-2"></i> Like</a>
              <?php } else { ?>
                <p class="p-3 text-red text-muted" disabled><i class="fas fa-thumbs-up mr-2"></i>Like</p>
              <?php } ?>
                <a class="p-3 ml-2 add_comment" data-post-id="<?php echo $post['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>"><i class="far fa-comment-alt mr-2"></i> Comment</a>
                <p class="p-3 text-red text-muted" disabled><i class="fas fa-share mr-2"></i>Share</p>
              </div>
              <div id="comment_textarea_<?php echo $post['post_ID'];?>"></div>
              <div class="comments_post_id_<?php echo $post['post_ID'];?>"></div>
              <?php $i=0; foreach ($comments as $comment) { ?>
                <div class="media m-2 comments_post_id_<?php echo $post['post_ID']; ?> comments_ID_<?php echo $comment['comment_ID']; ?>">
                  <img class="rounded-circle card-img-100 d-flex mx-auto mb-3 ml-2 chat-mes-id" src="./assets/img/users/<?php echo $comment['image']; ?>" alt="Profile Photo" onerror="this.onerror=null;this.src='<?php echo base_url();?>assets/img/users/stock.jpg';">
                  <div class="media-body text-left ml-2">
                    <div class="bg-light rounded p-2">
                    <h6 class="font-weight-bold m-0">
                      <a class="text-dark profile_popover" href="./<?php echo $comment['username']; ?>" data-user-id="<?php echo $comment['user_ID'];?>"><?php echo ucwords($comment['first_name']); ?> <?php echo ucwords($comment['last_name']); ?></a>
                      <?php if($comment['user_ID'] == $my_info['id']){ ?>
                      <a class="float-right red-text m-1"><i class="fas fa-times delete_comment fa-xs" data-comment-id="<?php echo $comment['comment_ID']; ?>" data-post-id="<?php echo $comment['post_ID'];?>"></i></a>
                      <?php } ?>
                    </h6>
                    <div class="text-break"><?php echo $comment['comment']; ?></div>
                    <?php if(!empty($comment['comment_image'])) { ?>
                      <div class="mt-2 h-50">
                        <div class="d-flex">
                          <a rel="gallery_<?php echo $comment['comment_ID']; ?>" href="./assets/img/posts/<?php echo hash('md5', $comment['user_ID']); ?>/<?php echo $comment['comment_image']; ?>" class="swipebox"><img src="./assets/img/posts/<?php echo hash('md5', $comment['user_ID']); ?>/<?php echo $comment['comment_image']; ?>" class="img-fluid img-thumbnail" style="width: 200px;"></a>
                        </div>
                      </div>
                    <?php } ?>
                  </div>
                  <div class="mb-2">
                    <a class="ml-2 like_comment like_comment_<?php echo $comment['comment_ID']; ?>" data-comment-id="<?php echo $comment['comment_ID']; ?>" data-user-id="<?php echo $comment['user_ID']; ?>" data-post-id="<?php echo $comment['post_ID'];?>" data-status="0">Like</a>
                    <a class="ml-2 add_reply" data-comment-id="<?php echo $comment['comment_ID']; ?>" data-post-id="<?php echo $comment['post_ID'];?>" data-user-id="<?php echo $comment['user_ID']; ?>">Reply</a>
                    <span class="text-left ml-2" style="font-size: 12px;"><?php echo time_elapsed_string($comment['timestamp'], $timezone);?></span>
                    <?php 
                      $sql= $CI->post_model->get_total_replies($comment['comment_ID']);
                      $sql2= $CI->post_model->get_total_likes_comments($comment['comment_ID']);
                      if($sql2 > 0){
                        echo '<span class="float-right blue-text"><i class="far fa-thumbs-up"></i> '.$sql2.'</span></div>';
                      } else {
                        echo '</div>';        
                      }
                      if($sql > 0){
                        if($sql > 1){
                          echo '<a class="ml-4 view_replies" data-comment-id="'.$comment['comment_ID'].'" data-post-id="'.$comment['post_ID'].'" data-user-id="'.$comment['user_ID'].'"><i class="fas fa-reply mr-2"></i> '.$sql.' replies</a>';
                        } else {
                          echo '<a class="ml-4 view_replies" data-comment-id="'.$comment['comment_ID'].'" data-post-id="'.$comment['post_ID'].'" data-user-id="'.$comment['user_ID'].'"><i class="fas fa-reply mr-2"></i> '.$sql.' reply</a>';
                        }
                      } 
                    ?>
                    <div id="add_reply_textarea_<?php echo $comment['comment_ID']; ?>"></div>
                    <div id="add_reply_<?php echo $comment['comment_ID']; ?>"></div>
                  </div>
                </div>
              <?php $i++;} ?>
            </div>
            <a class="text-center view_comments_<?php echo $post['post_ID'];?> view_comments mb-2" data-post-id="<?php echo $post['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>" data-start="<?php echo $i;?>"><?php if($total_comments > 2){ echo 'View more comments'; } ?></a>
          </div><!--/.Card-->
          <?php } ?>
          </div>
          <div class="text-center" id="spinner" hidden>
            <div class="spinner-border" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </div>
        </div><!--column-->
      </div><!--Grid row-->
    </section><!--Section-->
  </div><!--Container-->
</main><!--Main layout-->
<!-- Likers -->
<div class="modal fade" id="upload_image_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="form-group files">
          <label>Upload Your File </label>
          <input type="file" class="form-control" multiple="">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="view_likers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body" id="likers_post">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="daily_login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Login Streak Reward</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4 class="modal-title w-100">Your current login streak <i class="fas fa-fire amber-text"></i> : <?php echo $daily_logins['days']; ?></h4>
        <div class="row justify-content-center">
          <?php 
            $datetime = new DateTime();
            $date_today = $datetime->format("Y-m-d H:i:s");
          if(date("Y-m-d H:i:s", strtotime(changetimefromUTC($daily_logins['timestamp'], $timezone))) < $date_today){ ?>
          <a id="accept_reward" data-days="<?php echo $daily_logins['days']; ?>">
            <div class="card hoverable">
              <div class="card-body">
                <div class="d-flex">
                <p>10 exp</p>
                <p class="ml-4">Accept</p>
                </div>
              </div>
            </div>
          </a>
          <?php } else { ?>
            <div class="card success">
              <div class="card-body">
                <div class="d-flex">
                <p>10 exp</p>
                <p class="ml-4">Accepted</p>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  <?php if(date("Y-m-d H:i:s", strtotime(changetimefromUTC($daily_logins['timestamp'], $timezone))) < $date_today){ ?>
    $('#daily_login').modal('show');
  <?php } ?>
  $("#accept_reward").one('click', function (event) {  
    event.preventDefault();
    var days = $(this).data('days');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>users/accept_reward",
      dataType : "JSON",
      data:{days:days},
      success: function(data){
        toastr.success('Gain 10 exp!');
        $('#daily_login').modal('hide');
      }
    });
    $(this).prop('disabled', true);
  });

  // var offset = new Date().getTimezoneOffset(), o = Math.abs(offset);
  // var timezone = (offset < 0 ? "+" : "-") + ("00" + Math.floor(o / 60)).slice(-2) + ":" + ("00" + (o % 60)).slice(-2);

  // $("#timezone option[value='" + timezone + "']:first").attr("selected","selected");

// const str = new Date().toLocaleString('en-US', { timeZone: 'Asia/Jakarta' });
// console.log(str);

// const timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
// console.log(timeZone);

// var d = new Date().toLocaleString('en-US', { timeZone }), er = Math.abs(d);
// var dd = (d < 0 ? "+" : "-") + ("00" + Math.floor(er / 60)).slice(-2) + ":" + ("00" + (er % 60)).slice(-2);
// console.log(er);

//   $('#timezone').change(function(){ 
//     var new_timezone=$(this).val();

//     var inputs = $(".schedule");
//     for(var i = 0; i < inputs.length; i++){

//       var new_timezone = calculate($(inputs[i]).val(), new_timezone);
//       $('.time_'+i).text(parseFloat(new_timezone));
//     }

//   });

});
</script>