<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>instructor">Home</a></span>
        <span>/</span>
        <span><a href="<?php echo base_url();?>instructor/course">Course</a></span>
        <span>/</span>
        <span><a href="<?php echo base_url();?>instructor/course/<?php echo ucwords($course['slug']);?>"><?php echo ucwords($course['title']);?></a></span>
        <span>/</span>
        <span><a href="<?php echo base_url();?>instructor/course/<?php echo ucwords($course['slug']);?>"><?php echo ucwords($module['title']);?></a></span>
        <span>/</span>
        <span><?php echo ucwords($section['title']);?></span>
      </h4>
      <h4 class="mb-2 mb-sm-0 pt-1 float-right">
        <span><a href="<?php echo base_url();?>instructor/course/<?php echo ucwords($course['slug']);?>">Back</a></span>
      </h4>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <?php echo form_open_multipart('courses/update_all_content'); ?>
            <?php $i=0; foreach ($lessons as $lesson) {?>
              <h2><?php echo $lesson['title']; ?></h2>
              <?php foreach ($contents as $content) {?>
                <?php if ($lesson['id'] == $content['lesson_ID']) {?>
                  <div class="mb-3 pb-3">
                    <div class="form-group">
                      <label>Title</label>
                      <input type="hidden" class="form-control mb-4" name="content[<?php echo $i; ?>][content_ID]" value="<?php echo $content['id']; ?>">
                      <input type="text" class="form-control mb-4" name="content[<?php echo $i; ?>][title]" id="content_title_<?php echo $content['id']; ?>" value="<?php echo $content['title']; ?>">
                    </div>
                    <label for="edit_content_status">Status</label>
                    <div class="custom-control custom-switch mb-4">
                      <input type="checkbox" class="custom-control-input customSwitches" id="status_<?php echo $content['id']; ?>" name="content[<?php echo $i; ?>][status]" data-id="<?php echo $content['id']; ?>" value="<?php if($content['status'] == 0){ echo '0'; } elseif($content['status'] == 1) { echo '1'; } ?>" <?php if($content['status'] == 1){ echo 'checked'; } ?>>
                      <label class="custom-control-label switch_label status_<?php echo $content['id']; ?>" for="status_<?php echo $content['id']; ?>"><?php if($content['status'] == 0){ echo 'Hidden'; } elseif($content['status'] == 1) { echo 'Active'; } ?>
                      </label>
                    </div>
                    <div class="btn-group btn-group-sm mb-4" role="group" aria-label="Basic example">
                      <?php if(empty($content['url'])){?>
                        <a class="btn btn-primary btn-sm video" data-id="<?php echo $content['id']; ?>">Add Video</a>
                      <?php } else { ?>
                        <a class="btn btn-danger btn-sm video" data-id="<?php echo $content['id']; ?>">Remove Video</a>
                      <?php } ?>
                      <?php if(empty($content['content'])){?>
                        <a class="btn btn-primary btn-sm article" data-id="<?php echo $content['id']; ?>">Add Article/Details</a>
                      <?php } else { ?>
                        <a class="btn btn-danger btn-sm article" data-id="<?php echo $content['id']; ?>">Remove Article/Details</a>
                      <?php } ?>
                      <?php if(empty($content['file'])){?>
                        <a class="btn btn-primary btn-sm file" data-id="<?php echo $content['id']; ?>">Add Downloadable File</a>
                      <?php } else { ?>
                        <a class="btn btn-danger btn-sm file" data-id="<?php echo $content['id']; ?>">Remove Downloadable File</a>
                      <?php } ?>
                    </div>
                    <div class="form-group video_<?php echo $content['id']; ?>" <?php if(empty($content['url'])){ echo 'hidden'; } ?>>
                      <label for="contentitle">Video URL (URLs from youtube and vimeo are allowed) <br><h6 class="red-text">NOTE: Select one file only.</h6></label>
                      <div class="input-group mb-3">
                        <input type="text" class="form-control" aria-describedby="button-addon2" name="content[<?php echo $i; ?>][url]" id="content_url_<?php echo $content['id']; ?>" value="<?php echo $content['url']; ?>">
                        <div class="input-group-append">
                          <a href="javascript:open_popup('<?php echo base_url('vendors/dialog.php?type=3&popup=1&amp;field_id=content_url_'.$content['id'].''); ?>')" class="btn btn-md btn-outline-primary m-0 px-3 py-2 z-depth-0 waves-effect">Browse Media</a>
                        </div>
                      </div>
                      <label for="contentitle">Video Thumbnail (optional)<h6 class="red-text">NOTE: Select one file only.</h6></label>
                      <div class="input-group mb-3">
                        <input type="text" class="form-control" aria-describedby="button-addon2" name="content[<?php echo $i; ?>][thumbnail]" id="content_thumbnail_<?php echo $content['id']; ?>" value="<?php echo $content['thumbnail']; ?>">
                        <div class="input-group-append">
                          <a href="javascript:open_popup('<?php echo base_url('vendors/dialog.php?type=1&popup=1&amp;field_id=content_thumbnail_'.$content['id'].''); ?>')" class="btn btn-md btn-outline-primary m-0 px-3 py-2 z-depth-0 waves-effect">Browse Media</a>
                        </div>
                      </div>
                    </div>
                    <div class="form-group article_<?php echo $content['id']; ?>" <?php if(empty($content['content'])){ echo 'hidden'; } ?>>
                      <label>Details or Article</label>
                      <textarea type="textarea" class="content_written" name="content[<?php echo $i; ?>][content]" id="content_written_<?php echo $content['id']; ?>" value="<?php echo $content['content']; ?>"><?php echo $content['content']; ?></textarea>
                      <script>
                      CKEDITOR.replace('content_written_<?php echo $content['id']; ?>' ,{
                        filebrowserBrowseUrl : '<?php echo base_url('vendors/dialog.php?type=2&editor=ckeditor&fldr='); ?>',
                        filebrowserUploadUrl : '<?php echo base_url('vendors/dialog.php?type=2&editor=ckeditor&fldr='); ?>',
                        filebrowserImageBrowseUrl : '<?php echo base_url('vendors/dialog.php?type=1&editor=ckeditor&fldr='); ?>'
                      });
                      </script>
                    </div>
                    <div class="form-group file_<?php echo $content['id']; ?>" <?php if(empty($content['file'])){ echo 'hidden'; } ?>>
                      <label for="image">Downloadble File</label>
                      <h6 class="red-text">NOTE: You can select multiple files</h6>
                      <div class="input-group mb-3">
                        <input type="text" class="form-control" aria-describedby="button-addon2" name="content[<?php echo $i; ?>][file]" id="content_file_<?php echo $content['id']; ?>" value="<?php echo $content['file']; ?>">
                        <div class="input-group-append">
                          <a href="javascript:open_popup('<?php echo base_url('vendors/dialog.php?type=2&popup=1&amp;field_id=content_file_'.$content['id'].''); ?>')" class="btn btn-md btn-outline-primary m-0 px-3 py-2 z-depth-0 waves-effect">Browse Media</a>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php $i++;} ?>
              <?php } ?>
            <?php } ?>
          <button type="submit" class="btn btn-success">Save Changes</button>
          <?php echo form_close(); ?>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->

</div><!--Container-->
</main><!--Main laypassed out-->

<script type="text/javascript">
  $(document).ready(function(){
    $(".customSwitches").click(function() {
      var content_ID = $(this).data('id');
      if($("#status_"+content_ID).is(":checked")){
        $('.status_'+content_ID).text('Active');
        $(this).val(1);
      } else {
        $('.status_'+content_ID).text('Hidden');
        $(this).val(0);
      }
    });

  var x = true;
  $(document).on('click','.video',function() {
    var content_ID = $(this).data('id');
    if(x){
      $('.video_'+content_ID).prop("hidden", false);
      $('#content_url_'+content_ID).prop("disabled", false);
      $('#content_thumbnail_'+content_ID).prop("disabled", false);
      $(this).removeClass("btn-primary").addClass("btn-danger").text('Remove Video');
      x = false;
    } else {
      $('.video_'+content_ID).prop("hidden", true);
      $('#content_url_'+content_ID).prop("disabled", true);
      $('#content_thumbnail_'+content_ID).prop("disabled", true);
      $(this).removeClass("btn-danger").addClass("btn-primary").text('Add Video');
      x = true;
    }
  });

  var y = true;
  $(document).on('click','.article',function() {
    var content_ID = $(this).data('id');
    if(y){
      $('.article_'+content_ID).prop("hidden", false);
      $('#content_written_'+content_ID).prop("disabled", false);
      $(this).removeClass("btn-primary").addClass("btn-danger").text('Remove Article/Details');
      y = false;
    } else {
      $('.article_'+content_ID).prop("hidden", true);
      $('#content_written_'+content_ID).prop("disabled", true);
      $(this).removeClass("btn-danger").addClass("btn-primary").text('Add Article/Details');
      y = true;
    }
  });

  var z = true;
  $(document).on('click','.file',function() {
    var content_ID = $(this).data('id');
    if(z){
      $('.file_'+content_ID).prop("hidden", false);
      $('#content_file_'+content_ID).prop("disabled", false);
      $(this).removeClass("btn-primary").addClass("btn-danger").text('Remove Downloadable File');
      z = false;
    } else {
      $('.file_'+content_ID).prop("hidden", true);
      $('#content_file_'+content_ID).prop("disabled", true);
      $(this).removeClass("btn-danger").addClass("btn-primary").text('Add Downloadable File');
      z = true;
    }
  });
});
</script> 