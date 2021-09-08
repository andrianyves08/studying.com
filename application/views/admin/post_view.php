<script type="text/javascript">
function nanogallery(id, images) {
  $("#nanogallery_"+id).nanogallery2({
    items: images,
    galleryMaxRows: 2,
    galleryDisplayMode: 'rows',
    thumbnailAlignment: 'center',
    thumbnailHeight: '300', thumbnailWidth: '300',
    thumbnailBorderHorizontal: 0, thumbnailBorderVertical: 0,
    thumbnailLabel: { display: false },
    position: 'onBottom',
    // LIGHTBOX
    viewerToolbar: { display: false },
    viewerTools:    {
      topLeft:   'label',
      topRight:  'rotateLeft, rotateRight, fullscreenButton, closeButton'
    },
    // GALLERY THEME
    galleryTheme : { 
      thumbnail: { background: '#111' },
    },
  });
}
</script>
<main class="pt-5 mx-lg-5">
  <div class="container-fluid mt-5">
    <div class="card mb-4 wow fadeIn">
      <div class="card-body d-sm-flex justify-content-between">
        <h4 class="mb-2 mb-sm-0 pt-1">
          <span><a href="<?php echo base_url();?>admin">Home</a></span>
          <span>/</span>
          <span>Post Review</span>
        </h4>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <?php 
          $CI =& get_instance();
          $CI->load->model('post_model');
          $images = $CI->post_model->get_post_files($post['post_ID']);
          $comments = $CI->post_model->get_comments(0, 0, $post['post_ID']);
          $total_likes = $CI->post_model->total_likes($post['post_ID']);
          $total_comments = $CI->post_model->total_comments($post['post_ID']);
          $courses = $CI->post_model->get_post_to_course($post['post_ID']);
        ?>
        <div class="card mb-4 posts post_id_<?php echo $post['post_ID']; ?>">
          <div class="media mt-2">
            <img onerror="this.onerror=null;this.src='<?php echo base_url();?>assets/img/users/stock.jpg';" class="rounded-circle ml-2 card-img-100 d-flex z-depth-1 mr-2 chat-mes-id" src="<?php echo base_url();?>assets/img/users/<?php echo $post['image'];?>" style="height: 50px; width: 50px" alt="Profile photo">
            <div class="media-body">
               <h5><a class="text-dark profile_popover" href="<?php echo base_url().''.$post['username']; ?>" data-user-id="<?php echo $post['user_ID'];?>"><?php echo ucwords($post['first_name']);?> <?php echo ucwords($post['last_name']);?></a>
                 <?php foreach ($courses as $course) { ?>
                  <span class="ml-1 mr-2"><small style="font-size: 14px; font-weight: 600;">#<?php echo ($course['title'] == "") ? 'Global' : ucfirst($course['title']) ?></small></span>
                <?php } ?>
                </h5>
              <span style="font-size: 12px;"><?php echo date("F d, Y h:i A", strtotime($post['timestamp']));?></span>
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
            <hr>
            <div id="comment_textarea_<?php echo $post['post_ID'];?>"></div>
            <div class="comments_post_id_<?php echo $post['post_ID'];?>"></div>
              <?php foreach ($comments as $comment) {
                    $replies = $this->post_model->get_replies($post['post_ID'], $comment['comment_ID']);
               ?>
              <div class="media m-2 comments_post_id_<?php echo $post['post_ID']; ?> comments_ID_<?php echo $comment['comment_ID']; ?>">
                <img onerror="this.onerror=null;this.src='<?php echo base_url();?>assets/img/users/stock.jpg';" class="rounded-circle d-flex mx-auto mb-3 ml-2 chat-mes-id" src="<?php echo base_url();?>assets/img/users/<?php echo $comment['image']; ?>" alt="Profile Photo" style="height: 50px; width: 50px">
                <div class="media-body text-left ml-2">
                  <div class="bg-light rounded p-2">
                  <h6 class="font-weight-bold m-0">
                    <a class="text-dark profile_popover" href="<?php echo base_url();?><?php echo $comment['username']; ?>" data-user-id="<?php echo $comment['user_ID'];?>"><?php echo ucwords($comment['first_name']); ?> <?php echo ucwords($comment['last_name']); ?></a>
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
                  <span class="text-left ml-2" style="font-size: 12px;"><?php echo date("F d, Y h:i A", strtotime($comment['timestamp']));?></span>
                  <?php 
                    $sql= $CI->post_model->get_total_replies($comment['comment_ID']);
                    $sql2= $CI->post_model->get_total_likes_comments($comment['comment_ID']);
                    if($sql2 > 0){
                      echo '<span class="float-right blue-text"><i class="far fa-thumbs-up"></i>'.$sql2.'</span></div>';
                    } else {
                      echo '</div>';        
                    }
                  ?>
                  <div id="add_reply_<?php echo $comment['comment_ID']; ?>">
                    <?php foreach ($replies as $reply) { ?>
                    <div class="media m-2">
                      <img onerror="this.onerror=null;this.src='<?php echo base_url();?>assets/img/users/stock.jpg';" class="rounded-circle d-flex mx-auto mb-3 ml-2 chat-mes-id" src="<?php echo base_url();?>assets/img/users/<?php echo $reply['image']; ?>" alt="Profile Photo" style="height: 50px; width: 50px">
                      <div class="media-body text-left ml-2">
                        <div class="bg-light rounded p-2">
                        <h6 class="font-weight-bold m-0">
                          <a class="text-dark profile_popover" href="<?php echo base_url();?><?php echo $reply['username']; ?>" data-user-id="<?php echo $reply['user_ID'];?>"><?php echo ucwords($reply['first_name']); ?> <?php echo ucwords($reply['last_name']); ?></a>
                        </h6>
                        <?php echo $reply['comment']; ?>
                        <?php if(!empty($reply['comment_image'])) { ?>
                          <div class="mt-2 h-50">
                            <div class="d-flex">
                              <a rel="gallery_<?php echo $reply['comment_ID']; ?>" href="<?php echo base_url();?>assets/img/posts/<?php echo hash('md5', $reply['user_ID']); ?>/<?php echo $reply['comment_image']; ?>" class="swipebox"><img src="<?php echo base_url();?>assets/img/posts/thumbs/<?php echo hash('md5', $reply['user_ID']); ?>/<?php echo $reply['comment_image']; ?>" class="img-fluid img-thumbnail" style="width: 200px;"></a>
                            </div>
                          </div>
                        <?php } ?>
                        </div>
                        <div class="mb-2">
                        <span class="text-left ml-2" style="font-size: 12px;"><?php echo date("F d, Y h:i A", strtotime($reply['timestamp']));?></span>
                        <?php 
                          $sql3= $this->post_model->get_total_likes_comments($reply['comment_ID']);
                          if($sql3 > 0){
                            echo '<span class="float-right blue-text"><i class="far fa-thumbs-up"></i> '.$sql2.'</span></div>';
                          } else {
                            echo '</div>';        
                          }
                        ?>
                      </div>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <?php } ?>
          </div>
        </div><!--/.Card-->
      </div>
    </div>
  </div><!--Container-->
</main><!--Main laypassed out-->
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