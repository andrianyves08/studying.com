<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-4 col-md-4 col-sm-12">
      <div class="card mb-4">
        <div class="view overlay">
          <img class="profile-image img-fluid" src="<?php echo base_url();?>assets/img/users/<?php echo $user_info['image'];?>" alt="Profile Photo" onerror="this.onerror=null;this.src='<?php echo base_url();?>assets/img/users/stock.jpg';">
          <a href="#!">
            <div class="mask rgba-white-slight"></div>
          </a>
        </div><!-- View -->
        <div class="card-body d-flex flex-row">
          <div>
            <?php
            $CI =& get_instance();
            $CI->load->model('user_model');
            $images = $CI->user_model->get_levels($user_info['level']); ?>
            <img src="<?php echo base_url();?>assets/img/<?php echo $images['image'];?>" alt="Profile Photo">
          </div>
          <div class="text-left">
            <div class="d-flex align-items-center">
              <h4><strong><?php if($user_info['role'] == '1'){ echo 'Instructor '; }?><?php echo ucwords($user_info['first_name']);?> <?php echo ucwords($user_info['last_name']);?></strong></h4>
            </div>
            <div class="d-flex">
              <h6><strong><?php echo $count_posts['total']; ?></strong> Posts</h6>
              <a class="following" data-user-id="<?php echo $user_info['id'];?>"><h6 class="ml-4"><strong><?php echo $count_following['total']; ?></strong> Following</h6></a>
              <a class="followers" data-user-id="<?php echo $user_info['id'];?>"><h6 class="ml-4"><strong><?php echo $count_followers['total']; ?></strong> Followers</h6></a>
            </div>
            <h5 class="font-italic"><?php echo ucwords($user_info['about_me']);?></h5>
            <?php if($is_following == TRUE){ ?> 
              <button type="button" class="btn btn-sm btn-outline-danger waves-effect" id="unfollow_user" data-user-id="<?php echo $user_info['id'];?>">Unfollow</button>
            <?php } else { ?>
              <button type="button" class="btn btn-sm btn-outline-primary waves-effect" id="follow_user" data-user-id="<?php echo $user_info['id'];?>">Follow</button>
            <?php } ?>
            <?php if(!empty($my_purchases)){ ?>
              <button class="btn btn-sm btn-primary m-0 px-3 py-2 z-depth-0 waves-effect" type="button" data-toggle="modal" data-target="#send_chat">Send a message</button>
            <?php } ?>
          </div>
        </div><!-- Card Body-->
      </div><!-- Card -->
      <?php if($user_info['role'] == '1'){ ?>
        <div class="card mb-4">
          <div class="card-header customcolorbg">
            <h5 class="text-white"><strong>Course Available</strong></h5>
          </div>
          <div class="card-body">
            <table class="table display table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th scope="col">Title</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($courses as $row){ ?>
                <tr>
                  <td><a href="<?php base_url(); ?>course/<?php echo $row['slug']; ?>" class="blue-text"><?php echo ucwords($row['title']);?></a></td>
                  <td><a class="btn btn-primary btn-sm" href="<?php echo base_url(); ?>course/checkout/<?php echo $row['slug']?>">Buy Course</a></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div><!--Card Body-->
        </div><!--Card-->
      <?php } ?>

      <div class="card mb-4">
        <div class="card-header customcolorbg">
          <h5 class="text-white"><strong>Course Enrolled</strong></h5>
        </div>
        <div class="card-body">
          <table class="table table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th scope="col">Title</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users_course as $row){ ?>
              <tr>
                <td><a href="<?php base_url(); ?>course/<?php echo $row['slug']; ?>" class="blue-text"><?php echo ucwords($row['title']);?></a></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column -->
    <div class="col-lg-6">
      <div id="timeline" data-course-id="-3">
        <?php 
        $CI =& get_instance();
        $CI->load->model('post_model');
        if($is_following == TRUE){
          foreach ($posts as $post) {
            $images = $CI->post_model->get_post_files($post['post_ID']);
            $comments = $CI->post_model->get_comments(2, 0, $post['post_ID']);
            $total_likes = $CI->post_model->total_likes($post['post_ID']);
            $total_comments = $CI->post_model->total_comments($post['post_ID']);
            $courses = $this->post_model->get_post_to_course($post['post_ID']);
        ?>
        <div class="card mb-4 posts post_id_<?php echo $post['post_ID']; ?>">
          <div class="media mt-2">
            <img onerror="this.onerror=null;this.src='<?php echo base_url();?>assets/img/users/stock.jpg';" class="rounded-circle ml-2 card-img-100 d-flex z-depth-1 mr-2 chat-mes-id" src="<?php echo base_url();?>assets/img/users/<?php echo $post['image'];?>" style="height: 50px; width: 50px" alt="Profile photo">
            <div class="media-body">
               <h5><a class="text-dark profile_popover" href="<?php echo base_url().''.$post['username']; ?>" data-user-id="<?php echo $post['user_ID'];?>"><?php echo ucwords($post['first_name']);?> <?php echo ucwords($post['last_name']);?></a>
                 <?php foreach ($courses as $course) { ?>
                  <span class="ml-1 mr-2"><small style="font-size: 14px; font-weight: 600;">#<?php echo ($course['title'] == "") ? 'Global' : ucfirst($course['title']) ?></small></span>
                <?php } ?>
                <?php if ($post['user_ID'] == $my_info['id']) {?>
                <a class="float-right mr-2 post_popover" data-toggle="popover" alt="<?php echo $post['post_ID'];?>" data-post-id="<?php echo $post['post_ID'];?>"><i class="fas fa-ellipsis-v"></i></span></a>
                <?php } ?></h5>
              <a href="<?php echo base_url().$post['username']; ?>/posts/<?php echo $post['post_ID'];?>" class="text-muted text-dark"><small><?php echo changetimefromUTC($post['timestamp'], $timezone);?></small></a>
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
              <a class="p-3 ml-2 liked liked_<?php echo $post['post_ID'];?>" data-post-id="<?php echo $post['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>" data-status="0"><i class="far fa-thumbs-up mr-2"></i> Like</a>
              <a class="p-3 ml-2 add_comment" data-post-id="<?php echo $post['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>"><i class="far fa-comment-alt mr-2"></i> Comment</a>
              <p class="p-3 text-red text-muted" disabled><i class="fas fa-share mr-2"></i>Share</p>
            </div>
            <div id="comment_textarea_<?php echo $post['post_ID'];?>"></div>
            <div class="comments_post_id_<?php echo $post['post_ID'];?>"></div>
              <?php 
                $i=0;
                foreach ($comments as $comment) { ?>
              <div class="media m-2 comments_post_id_<?php echo $post['post_ID']; ?> comments_ID_<?php echo $comment['comment_ID']; ?>">
                <img onerror="this.onerror=null;this.src='<?php echo base_url();?>assets/img/users/stock.jpg';" class="rounded-circle card-img-100 d-flex mx-auto mb-3 ml-2 chat-mes-id" src="<?php echo base_url();?>assets/img/users/thumbs/<?php echo $comment['image']; ?>" alt="Profile Photo">
                <div class="media-body text-left ml-2">
                  <div class="bg-light rounded p-2">
                  <h6 class="font-weight-bold m-0">
                    <a class="text-dark profile_popover" href="./<?php echo $comment['username']; ?>" data-user-id="<?php echo $comment['user_ID'];?>"><?php echo ucwords($comment['first_name']); ?> <?php echo ucwords($comment['last_name']); ?></a>
                    <?php if($comment['user_ID'] == $my_info['id']){ ?>
                    <a class="float-right red-text m-1"><i class="fas fa-times delete_comment fa-xs" data-comment-id="<?php echo $comment['comment_ID']; ?>" data-post-id="<?php echo $comment['post_ID'];?>"></i></a>
                    <?php } ?>
                  </h6>
                  <?php echo $comment['comment']; ?>
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
                  <a class="ml-2 view_replies" data-comment-id="<?php echo $comment['comment_ID']; ?>" data-post-id="<?php echo $comment['post_ID'];?>" data-user-id="<?php echo $comment['user_ID']; ?>">Reply</a>
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
                  <div id="add_reply_<?php echo $comment['comment_ID']; ?>"></div>
                </div>
              </div>
              <?php $i++;}
              ?>
          </div>
          <a class="text-center view_comments_<?php echo $post['post_ID'];?> view_comments mb-2" data-post-id="<?php echo $post['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>" data-start="<?php echo $i;?>"><?php if($i > 1){ echo 'View more comments'; } ?></a>
        </div><!--/.Card-->
          <?php } ?><!--/.For loop-->
        <?php } ?>
        </div>
        <div class="text-center" id="spinner" hidden>
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>

    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main>
<!-- Create Chat -->
<div data-backdrop="static" class="modal fade" id="send_chat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Create Message</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="user_ID" value="<?php echo $user_info['id'];?>"></input>
        <textarea class="textarea" name="chat_message" placeholder="Write message to <?php echo ucwords($user_info['first_name']);?> <?php echo ucwords($user_info['last_name']);?>" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
      </div><!--Modal Body-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-primary waves-effect float-right" type="submit" id="createamessage">Send</button>
      </div>
    </div><!--Content-->
  </div>
</div>

<!-- Likers -->
<div class="modal fade" id="view_likers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
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

<!--Following -->
<div data-backdrop="static" class="modal fade" id="following" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Following</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group list-group-flush" id="list_following">
        </ul>
      </div><!--Modal Body-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</a>
      </div>
    </div><!--Content-->
  </div>
</div>
<!--Followers -->
<div data-backdrop="static" class="modal fade" id="followers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Followers</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group list-group-flush" id="list_followers">
        </ul>
      </div><!--Modal Body-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</a>
      </div>
    </div><!--Content-->
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  $("#unfollow_user").one('click', function (event) {  
    event.preventDefault();
    var user_ID = $(this).data('user-id');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>users/unfollow",
      dataType : "JSON",
      data:{user_ID:user_ID},
      success: function(data){
        location.reload();
      }
    });
    $(this).prop('disabled', true);
  });

  $("#follow_user").one('click', function (event) {  
    event.preventDefault();
    var user_ID = $(this).data('user-id');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>users/follow",
      dataType : "JSON",
      data:{user_ID:user_ID},
      success: function(data){
        location.reload();
      }
    });
    $(this).prop('disabled', true);
  });
  
  //Create Message
  $('#createamessage').on('click',function(){
    var user_ID=$('[name="user_ID"]').val();
    var message=$('[name="chat_message"').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>messages/create_message",
      dataType : "JSON",
      data : {user_ID:user_ID , chat_message:message},
      success: function(data){
        if(data.error){
            toastr.error(data.message);
        } else {
          toastr.success('Message Sent.');
          window.location.replace("<?php echo base_url().'messages'?>");
        }
      }
    });
    return false;
  });

  $(document).on('click', '.followers', function(){
    $('#followers').modal('show');
    var user_ID = $(this).data('user-id');
    $.ajax({
      url:"<?=base_url()?>users/get_followers",
      method:"POST",
      async : true,
      dataType : 'json',
      data:{user_ID:user_ID},
      success:function(data) {
        $('#list_followers').html(data);
      }
    })
  });

  $(document).on('click', '.following', function(){
    $('#following').modal('show');
    var user_ID = $(this).data('user-id');
    $.ajax({
      url:"<?=base_url()?>users/get_following",
      method:"POST",
      async : true,
      dataType : 'json',
      data:{user_ID:user_ID},
      success:function(data) {
        $('#list_following').html(data);
      }
    })
  });
});
</script>