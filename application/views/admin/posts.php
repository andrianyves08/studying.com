<script type="text/javascript">
function nanogallery(id, images) {
  $("#nanogallery_"+id).nanogallery2({
    items: images,
    galleryMaxRows: 1,
    galleryDisplayMode: 'rows',
    thumbnailAlignment: 'center',
    thumbnailHeight: '100', thumbnailWidth: '100',
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
        <div class="card">
          <div class="card-body">
            <table class="table table-bordered display table-responsive-md" cellspacing="0" width="100%">
              <thead>
                <th style="width: 20%; ">Post</th>
                <th style="width: 15%; ">Posted On</th>
                <th style="width: 20%; ">Posted By</th>
                <th style="width: 10%; ">Status</th>
                <th style="width: 15%; ">Date Posted</th>
                <th style="width: 20%; "></th>
              </thead>
              <tbody>
                <?php 
                $CI =& get_instance();
                $CI->load->model('post_model');
                foreach($posts as $post){ 
                  $images = $CI->post_model->get_post_files($post['post_ID']);
                  $courses = $CI->post_model->get_post_to_course($post['post_ID']);
                ?> 
                <tr>
                  <td><?php echo ucfirst($post['post']);
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
                  </td>
                  <td>
                    <?php 
                      foreach ($courses as $course) {
                        echo '• ';
                        echo ($course['title'] == "") ? 'Global' : ucwords($course['title']).'<br>';
                      }
                    ?>
                  </td>
                  <td><?php echo ucwords($post['first_name']);?> <?php echo ucwords($post['last_name']);?></td>
                  <td>
                    <?php if ($post['post_status'] == '1') { ?>
                      <span class="post_status_<?php echo $post['post_ID'];?> badge badge-pill badge-success">Approved</span>
                    <?php } elseif ($post['post_status'] == '0') { ?>
                      <span class="post_status_<?php echo $post['post_ID'];?> badge badge-pill badge-danger">Denied</span>
                    <?php } else { ?>
                      <span class="post_status_<?php echo $post['post_ID'];?> badge badge-pill badge-default">On Review</span>
                    <?php } ?>
                  </td>
                   <td><span hidden><?php echo date("'Y-m-d", strtotime(changetimefromUTC($post['timestamp'], $timezone)));?></span>
                    <?php echo changetimefromUTC($post['timestamp'], $timezone);?></td>
                  <td>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <a href="<?php echo base_url().'admin/posts/'.$post['post_ID']; ?>" class="btn btn-sm btn-primary" target="_blank">view full post</a>
                        <?php if ($post['post_status'] == '1') { ?>
                          <a class="post_button_<?php echo $post['post_ID'];?> btn btn-sm btn-danger deny_post" data-post-id="<?php echo $post['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>">Deny Post</a>
                        <?php } elseif ($post['post_status'] == '0') { ?>
                          <a class="post_button_<?php echo $post['post_ID'];?> btn btn-sm btn-success approve_post" data-post-id="<?php echo $post['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>">Approve Post</a>
                        <?php } else { ?>
                          <a class="post_button_<?php echo $post['post_ID'];?> btn btn-sm btn-success approve_post" data-post-id="<?php echo $post['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>">Approve Post</a>
                          <a class="post_button_<?php echo $post['post_ID'];?> btn btn-sm btn-danger deny_post" data-post-id="<?php echo $post['post_ID'];?>" data-user-id="<?php echo $post['user_ID'];?>">Deny Post</a>
                         <?php } ?>
                      </div>
                    </div>
                  </td>
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div><!--Container-->
</main><!--Main laypassed out-->

<script type="text/javascript">
$(document).ready(function(){
  //Approve post
  $(document).on("click", ".approve_post", function() { 
    var post_ID=$(this).data('post-id');
    var user_ID=$(this).data('user-id');
    alert_sound.play();
    if(confirm("Are you sure you want to approve this post?")){
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>posts/approve_post",
        dataType : "JSON",
        data : {post_ID:post_ID, user_ID:user_ID},
        success: function(data){
          toastr.success('Post approved!');
          $('.post_status_'+post_ID).removeClass("badge-danger").addClass("badge-success").text('Approved');
          $('.post_button_'+post_ID).removeClass("btn-success approve_post").addClass("btn-danger deny_post").text('Deny Post');
        }
      });
    }
  });

  //Approve post
  $(document).on("click", ".deny_post", function() {
    var post_ID=$(this).data('post-id');
    var user_ID=$(this).data('user-id');
    alert_sound.play();
    if(confirm("Are you sure you want to deny this post?")){
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>posts/deny_post",
        dataType : "JSON",
        data : {post_ID:post_ID, user_ID:user_ID},
        success: function(data){
          toastr.success('Post denied!');
          $('.post_status_'+post_ID).removeClass("badge-success").addClass("badge-danger").text('Denied');
          $('.post_button_'+post_ID).removeClass("btn-danger deny_post").addClass("btn-success approve_post").text('Approve Post');
        }
      });
    }
  });
});
</script>