<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <!--Card content-->
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>admin">Home</a></span>
        <span>/</span>
        <span><a href="<?php echo base_url(); ?>resources">Blog</a></span>
        <span>/</span>
        <span><?php echo ucwords($blog['title']); ?></span>
      </h4>
    </div>
  </div>
    <!-- Heading -->
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <form class="needs-validation" novalidate>
            <input type="hidden" class="form-control" name="blog_ID" id="blog_ID" value="<?php echo $blog['blog_ID']; ?>">
            <div class="form-group">
              <label for="formGroupExampleInput">Title</label>
              <input type="text" class="form-control" name="title" id="title" value="<?php echo ucfirst($blog['title']); ?>" required>
              <div class="invalid-feedback">
                Required
              </div>
            </div>
            <div class="form-group">
              <label for="formGroupExampleInput">Meta Description</label>
              <input type="text" class="form-control" name="meta_description" id="meta_description" value="<?php echo ucfirst($blog['meta_description']); ?>" required>
            </div>
            <div class="form-group">
              <label for="formGroupExampleInput">Meta Keywords</label>
               <h6 class="red-text">NOTE: Comma separated</h6>
              <input type="text" class="form-control" name="meta_keywords" id="meta_keywords" value="<?php echo ucwords($blog['meta_keywords']); ?>" required>
            </div>
            <div class="form-group">
              <label for="banner">Banner (optional)<h6 class="red-text">NOTE: Select one file only.</h6></label>
              <div class="input-group mb-3">
                <input type="text" class="form-control" aria-describedby="button-addon2" name="banner" id="banner" value="<?php echo $blog['banner'];?>">
                <div class="input-group-append">
                  <a href="javascript:open_popup('<?php echo base_url('vendors/dialog.php?type=1&popup=1&amp;field_id=banner'); ?>')" class="btn btn-md btn-outline-primary m-0 px-3 py-2 z-depth-0 waves-effect">Browse Media</a>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="category">Select Category</label>
              <div class="input-group mb-4">
                <select class="browser-default custom-select select2" name="category" id="category" multiple="multiple" data-placeholder="Select a Category" required>
                  <?php foreach($blog_categories as $row){ ?> 
                    <option value="<?php echo $row['id']; ?>" selected><?php echo ucwords($row['name']); ?></option>
                  <?php } ?>
                  <?php foreach($categories as $category){
                    if (array_search($category['id'], array_column($blog_categories, 'id')) === FALSE){ ?>
                      <option value="<?php echo $category['id']; ?>"><?php echo ucwords($category['name']); ?></option>
                  <?php } } ?>
                </select>
                <div class="input-group-append">
                  <a class="btn btn-md btn-outline-secondary m-0 px-3 py-2 z-depth-0 waves-effect" type="button" data-toggle="modal" data-target="#create_category">Create New Category</a>
                </div>
              </div>
              <div class="invalid-feedback">
                Required
              </div>
            </div>
            <div class="form-group">
              <label for="files">Downloadble File</label>
              <div class="input-group mb-3">
                <input type="text" class="form-control" aria-describedby="button-addon2" name="files" id="files" value="<?php foreach($files as $file){ ?><?php echo $file['file']; ?>, <?php } ?>">
                <div class="input-group-append">
                  <a href="javascript:open_popup('<?php echo base_url('vendors/dialog.php?type=2&popup=1&amp;field_id=files'); ?>')" class="btn btn-md btn-outline-primary m-0 px-3 py-2 z-depth-0 waves-effect">Browse Media</a>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="content">Content</label>
              <textarea name="content" id="content" rows="10" cols="80" required><?php echo $blog['content']; ?></textarea>
              <div class="invalid-feedback">
                Required
              </div>
            </div>
            <button class="btn btn-primary waves-effect" id="update_blog">Save Changes</button>
          </form>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main><!--Main laypassed out-->
<!-- Add Members -->
<div data-backdrop="static" class="modal fade" id="create_category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-notify modal-success" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Create New Category</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
        <label for="formGroupExampleInput">* Name</label>
        <input type="text" class="form-control" name="new_category" id="new_category">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button class="btn btn-primary waves-effect btn-sm float-right" type="submit" id="add_category">Create</button>
      </div>
    </div>
  </div>
</div>
<script>
CKEDITOR.replace('content', {
  filebrowserBrowseUrl : '<?php echo base_url('vendors/dialog.php?type=2&editor=ckeditor&fldr='); ?>',
  filebrowserUploadUrl : '<?php echo base_url('vendors/dialog.php?type=2&editor=ckeditor&fldr='); ?>',
  filebrowserImageBrowseUrl : '<?php echo base_url('vendors/dialog.php?type=1&editor=ckeditor&fldr='); ?>'
});
</script>
<script>
$(document).ready(function(){
  function get_category(){
    $.ajax({ 
      type  : 'ajax',
      url   : "<?=base_url()?>blog/get_category",
      async : true,
      dataType : 'json',
      success : function(data){
        var html = '';
        var i;
        for(i=0; i<data.length; i++){
          html += '<option value='+data[i].id+'>'+data[i].name+'</option>';
        }
        $('#select_category').html(html);
      }
    });
  }

  $('#add_category').on('click',function(){
    var category = $('#new_category').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>blog/create_category",
      dataType : "JSON",
      data : {name:category},
      success: function(data){
        if(data.error){
          toastr.error(data.message);
        } else {
          toastr.success('Category created');
          $('#create_category').modal('hide');
        }
        get_category();
      }
    });
  });

  $('#update_blog').on('click',function(){
    var blog_ID = $('#blog_ID').val();
    var title = $('#title').val();
    var meta_description = $('#meta_description').val();
    var meta_keywords = $('#meta_keywords').val();
    var banner = $('#banner').val();
    var category = $('#category').val();
    var content = CKEDITOR.instances['content'].getData();
    var files = $('#files').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>blog/update_blog",
      dataType : "JSON",
      data : {blog_ID:blog_ID, title:title, meta_description:meta_description, meta_keywords:meta_keywords, banner:banner, category:category, content:content, files:files},
      success: function(data){
        if(data.error){
          toastr.error(data.message);
          error_sound.play();
        } else {
          toastr.success('Blog updated!');
        }
      }
    });
  });
});
</script>