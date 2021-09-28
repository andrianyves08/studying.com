<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-4">
      <div class="card mb-4">
        <div class="view overlay">
            <img class="profile-image img-fluid" src="<?php echo base_url();?>assets/img/users/<?php echo $my_info['image'];?>" alt="Profile Photo" onerror="this.onerror=null;this.src='<?php echo base_url();?>assets/img/users/stock.jpg';">
            <a href="#!">
              <div class="mask rgba-white-slight"></div>
            </a>
        </div><!-- View -->
        <div class="row justify-content-center m-2">
          <div class="col-4">
            <?php
            $CI =& get_instance();
            $CI->load->model('user_model');
            $images = $CI->user_model->get_levels($my_info['level']); ?>
            <img src="<?php echo base_url();?>assets/img/<?php echo $images['image'];?>" alt="Profile Photo">
          </div>
          <div class="col-8">
            <h4><strong><?php if($my_info['role'] == '1'){ echo 'Instructor '; }?><?php echo ucwords($my_info['first_name']);?> <?php echo ucwords($my_info['last_name']);?></strong></h4>
            <a class="mr-3"><strong><?php echo $count_posts['total']; ?></strong> Posts</a>
            <a class="following mr-3" data-user-id="<?php echo $my_info['id'];?>"><strong><?php echo $count_following['total']; ?></strong> Following</a>
            <a class="followers" data-user-id="<?php echo $my_info['id'];?>"><strong><?php echo $count_followers['total']; ?></strong> Followers</a>
            <h5 class="font-italic"><?php echo ucwords($my_info['about_me']);?></h5>
            <h5 class="blue-text mb-4"><strong><?php echo $my_info['email'];?></strong></h5>
          </div>
          <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#change_password"><i class="fas fa-lock"></i> Change Password</button>
            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit_profile_modal"><i class="fas fa-user"></i> Change Profile</button>
            <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#edit_photo_modal"><i class="fas fa-image"></i> Change Profile Photo</button>
          </div>
        </div><!-- Card Body-->
      </div><!-- Card -->

      <?php if($my_info['role'] == '1'){ ?>
      <div class="card mb-4">
        <div class="card-header customcolorbg">
          <h5 class="text-white"><strong>My Course</strong></h5>
        </div>
        <div class="card-body">
          <table class="table table-bordered display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th scope="col">Title</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($courses as $row){ ?>
              <tr>
                <td><a href="<?php base_url(); ?>course/<?php echo $row['slug']; ?>" class="blue-text"><?php echo ucwords($row['title']);?></a></td>
                <td>
                  <?php if($row['status'] == '0'){?>
                    <span class="badge badge-pill badge-warning status_switch_label_<?php echo $row['course_ID'];?>">Hidden</span>
                  <?php } else { ?>
                    <span class="badge badge-pill badge-success status_switch_label_<?php echo $row['course_ID'];?>">Active</span>
                  <?php } ?>
                </td>
                <td><a class="btn btn-primary btn-sm" href="<?php base_url(); ?>instructor/course/<?php echo $row['slug']; ?>">Edit Course</a></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
          <a class="btn btn-success btn-sm float-right" href="<?php base_url(); ?>instructor/course">Upload Course</a>
        </div><!--Card Body-->
      </div><!--Card-->
      <?php } ?>

      <div class="card mb-4">
        <div class="card-header customcolorbg">
          <h5 class="text-white"><strong>My Purchases</strong></h5>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-responsive" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th scope="col">Title</th>
                <th scope="col">Status</th>
                <th scope="col">Date Enrolled</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users_course as $row){ ?>
              <tr>
                <td><a href="<?php base_url(); ?>course/<?php echo $row['slug']; ?>" class="blue-text"><?php echo ucwords($row['title']);?></a></td>
                <td><?php echo ucwords($row['purchase_status_name']);?></td>
                <td><?php echo date("F d, Y", strtotime($row['date_enrolled']));?></td>
                <td><a class="btn btn-primary btn-sm purchase_history" data-purchase-id="<?php echo $row['purchase_ID']; ?>">View Purchase History</a></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div><!--Card Body-->
      </div><!--Card-->
      <div class="card mb-4">
        <div class="card-header customcolorbg">
          <h5 class="text-white"><strong>Watch History</strong></h5>
        </div>
        <div class="card-body">
          <table class="table table-bordered display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th scope="col">Video Name</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($histories as $history){ ?>
                <tr>
                  <td><a href="<?php base_url();?>course/<?php echo $history['course_slug'];?>/<?php echo $history['module_slug'];?>/<?php echo $history['section_slug'];?>#<?php echo $history['content_ID'];?>" class="blue-text"><?php echo ucwords($history['content_title']);?></a></td>
                  <td>
                    <?php if($history['status'] == 0){?>
                    <span class="badge badge-pill badge-info">On Going</span>
                    <?php } else { ?>
                    <span class="badge badge-pill badge-success">Finished</span>
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column -->
    <div class="col-lg-6">
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
                <button type="button" class="btn btn-link uploadTrigger mr-2" data-textarea-id="0"><i class="fas fa-photo-video green-text mr-2"></i>Photo / Video</button>
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
        <div id="timeline" data-course-id="-2">
        <?php 
        $CI =& get_instance();
        $CI->load->model('post_model');
        foreach ($posts as $post) {
          $images = $CI->post_model->get_post_files($post['post_ID']);
          $comments = $CI->post_model->get_comments(2, 0, $post['post_ID']);
          $total_likes = $CI->post_model->total_likes($post['post_ID']);
          $total_comments = $CI->post_model->total_comments($post['post_ID']);
          $courses = $this->post_model->get_post_to_course($post['post_ID']);
        ?>
        <?php if ($post['pin'] == 1) {?>
          <span class="text-right"><i class="fas fa-thumbtack"></i> PINNED POST </span>
        <?php } ?>
        <div class="card mb-4 posts post_id_<?php echo $post['post_ID']; ?>">
          <div class="media mt-2">
            <img onerror="this.onerror=null;this.src='<?php echo base_url();?>assets/img/users/stock.jpg';" class="rounded-circle ml-2 card-img-100 d-flex z-depth-1 mr-2 chat-mes-id" src="<?php echo base_url();?>assets/img/users/thumbs/<?php echo $post['image'];?>" style="height: 50px; width: 50px" alt="Profile photo">
            <div class="media-body">
               <h5><a class="text-dark profile_popover" href="<?php echo base_url().''.$post['username']; ?>" data-user-id="<?php echo $post['user_ID'];?>"><?php echo ucwords($post['first_name']);?> <?php echo ucwords($post['last_name']);?></a>
                <?php foreach ($courses as $course) { ?>
                  <span class="ml-1 mr-2"><small style="font-size: 14px; font-weight: 600;">#<?php echo ($course['title'] == "") ? 'Global' : ucfirst($course['title']) ?></small></span>
                <?php } ?>
                <?php if ($post['user_ID'] == $my_info['id']) {?>
                <a class="float-right mr-2 post_popover" data-toggle="popover" alt="<?php echo $post['post_ID'];?>" data-post-id="<?php echo $post['post_ID'];?>" data-pin="<?php echo $post['pin'];?>"><i class="fas fa-ellipsis-v"></i></span></a>
                <?php } ?></h5>
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
                <img class="rounded-circle card-img-100 d-flex mx-auto mb-3 ml-2 chat-mes-id" src="./assets/img/users/<?php echo $comment['image']; ?>" alt="Profile Photo" onerror="this.onerror=null;this.src='<?php echo base_url();?>assets/img/users/stock.jpg';">
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
<!-- Change Password-->
<div data-backdrop="static" class="modal fade" id="change_password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Change Password</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo form_open('users/change_password'); ?>
        <div class="form-group">
          <label for="formGroupExampleInput">Current Password</label>
          <input type="password" class="form-control" name="current_password">
        </div>
        <div class="form-row mb-4">
          <div class="col">
            <label for="formGroupExampleInput">New Password</label>
            <input type="password" class="form-control" name="new_password">
          </div>
          <div class="col">
            <label for="formGroupExampleInput">Confirm New Password</label>
            <input type="password" class="form-control" name="cnew_Password">
          </div>
        </div>
      </div><!--Body-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-success waves-effect float-right" type="submit">Save Changes</button>
      </div><!--Footer-->
      <?php echo form_close(); ?>
    </div><!--Content-->
  </div>
</div>
<!-- Change Password-->

<!-- Edit Profile -->
<div data-backdrop="static" class="modal fade" id="edit_profile_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Edit Profile</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart('users/update_profile'); ?>
        <div class="form-group">
          <label for="formGroupExampleInput">Username</label>
          <input type="hidden" class="form-control" name="current_username" value="<?php echo $my_info['username'];?>">
          <input type="text" class="form-control" name="username" value="<?php echo $my_info['username'];?>">
        </div>
        <div class="form-row mb-4">
          <div class="col">
            <label for="formGroupExampleInput">First Name</label>
            <input type="text" class="form-control" name="first_name" value="<?php echo ucwords($my_info['first_name']);?>">
          </div>
          <div class="col">
            <label for="formGroupExampleInput">Last Name</label>
            <input type="text" class="form-control" name="last_name" value="<?php echo ucwords($my_info['last_name']);?>">
          </div>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">About Me</label>
          <input type="text" class="form-control" name="bio" value="<?php echo ucwords($my_info['about_me']);?>">
        </div>
      </div><!--Body-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-success waves-effect float-right" type="submit">Save Changes</button>
      </div><!--Footer-->
      <?php echo form_close(); ?>
    </div><!--Content-->
  </div>
</div>
<!-- Edit Profile -->

<!-- Edit image -->
<div data-backdrop="static" class="modal fade" id="edit_photo_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Upload Profile Photo</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart('users/update_photo'); ?>
        <div class="input-group">
          <div class="custom-file">
            <input type="hidden" name="old_photo" value="<?php echo $my_info['image'];?>">
            <input type="file" class="custom-file-input" id="profile_photo" name="profile_photo" aria-describedby="inputGroupFileAddon01" accept="image/x-png,image/gif,image/jpeg">
            <label class="custom-file-label text-left" for="logo"><?php echo $my_info['image'];?></label>
          </div>
        </div>
        <br>
      </div><!--Body-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-success waves-effect float-right" type="submit">Save Changes</button>
      </div><!--Footer-->
      <?php echo form_close(); ?>
    </div><!--Content-->
  </div>
</div>

<!-- Delete Posts -->
<div data-backdrop="static" class="modal fade" id="delete_post" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Delete Post</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this post?</p>
        <input type="hidden" class="form-control" name="post_ID">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm confirm_delete_post">Confirm</button>
      </div>
    </div>
  </div>
</div>

<!-- Purchase History -->
<div data-backdrop="static" class="modal fade" id="purchase_history_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Purchase history</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <table class="table">
          <thead>
            <tr>
              <th style="width: 20%;">Status</th>
              <th style="width: 50%;">Comment</th>
              <th style="width: 30%;">Date</th>
            </tr>
          </thead>
          <tbody id="purchase_history">
          </tbody>
        </table>
      </div>
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</a>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  $(document).on("click", ".purchase_history", function() {
    var purchase_ID=$(this).data('purchase-id');
    $('#purchase_history_modal').modal('show');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>purchase/purchase_history",
      dataType : "JSON",
      data : {purchase_ID:purchase_ID},
      success: function(data){
        var html;
        for(var i=0; i<data.length; i++){
          html += '<tr><td>'+data[i].name+'</td><td>'+data[i].comment+'</td><td>'+data[i].date_created+'</td></tr>';
        }
        $('#purchase_history').html(html);
      }
    });
  });

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