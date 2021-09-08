<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
	<div class="row justify-content-center">
		<div class="col-lg-8">
			<?php 
        $CI =& get_instance();
        $CI->load->model('post_model');
          $images = $CI->post_model->get_post_files($post['post_ID']);
          $comments = $CI->post_model->get_comments(0, 0, $post['post_ID']);
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
                  <?php if ($post['post_status'] != '1') { ?>
                      <span class="badge badge-pill badge-danger">Denied Post</span>
                  <?php } ?>
                <a class="float-right mr-2 post_popover" data-toggle="popover" alt="<?php echo $post['post_ID'];?>" data-post-id="<?php echo $post['post_ID'];?>"><i class="fas fa-ellipsis-v"></i></span></a>
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
                $filename = base_url().'assets/img/posts/thumbs/'.hash('md5', $post['user_ID']).'/'.$image['file'];
                $all_images[] = array(
                  'src' => base_url().'assets/img/posts/'.hash('md5', $post['user_ID']).'/'.$image['file'],
                  'srct' => is_file($filename) ? $filename : '',
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
                <img onerror="this.onerror=null;this.src='<?php echo base_url();?>assets/img/users/stock.jpg';" class="rounded-circle card-img-100 d-flex mx-auto mb-3 ml-2 chat-mes-id" src="<?php echo base_url();?>assets/img/users/<?php echo $comment['image']; ?>" alt="Profile Photo">
                <div class="media-body text-left ml-2">
                  <div class="bg-light rounded p-2">
                  <h6 class="font-weight-bold m-0">
                    <a class="text-dark profile_popover" href="<?php echo base_url();?><?php echo $comment['username']; ?>" data-user-id="<?php echo $comment['user_ID'];?>"><?php echo ucwords($comment['first_name']); ?> <?php echo ucwords($comment['last_name']); ?></a>
                    <?php if($comment['user_ID'] == $my_info['id']){ ?>
                    <a class="float-right red-text m-1"><i class="fas fa-times delete_comment fa-xs" data-comment-id="<?php echo $comment['comment_ID']; ?>" data-post-id="<?php echo $comment['post_ID'];?>"></i></a>
                    <?php } ?>
                  </h6>
                  <?php echo $comment['comment']; ?>
                  <?php if(!empty($comment['comment_image'])) { ?>
                    <div class="mt-2 h-50">
                      <div class="d-flex">
                        <a rel="gallery_<?php echo $comment['comment_ID']; ?>" href="<?php echo base_url();?>assets/img/posts/<?php echo hash('md5', $comment['user_ID']); ?>/<?php echo $comment['comment_image']; ?>" class="swipebox"><img src="<?php echo base_url();?>assets/img/posts/thumbs/<?php echo hash('md5', $comment['user_ID']); ?>/<?php echo $comment['comment_image']; ?>" class="img-fluid img-thumbnail" style="width: 200px;"></a>
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
        </div><!--/.Card-->
		</div>
	</div>
</div><!--Container-->
</main><!--Main layout-->
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