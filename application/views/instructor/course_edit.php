<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>instructor">Home</a></span>
        <span>/</span>
        <span><a href="<?php echo base_url();?>instructor/course">Course</a></span>
        <span>/</span>
        <span><?php echo ucwords($course['title']);?></span>
      </h4>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <form class="needs-validation" novalidate>
            <input type="hidden" class="form-control" name="course_ID" id="course_ID" value="<?php echo $course['course_ID']; ?>">
            <div class="form-group">
              <label for="formGroupExampleInput">Title</label>
              <input type="text" class="form-control" name="title" id="title" value="<?php echo ucwords($course['title']); ?>" required>
              <div class="invalid-feedback">
                Required
              </div>
            </div>
            <div class="form-group">
              <label for="exampleFormControlTextarea2">Description</label>
              <textarea class="form-control rounded-0" name="description" id="description" rows="3" value="<?php echo ucfirst($course['description']); ?>" required><?php echo ucfirst($course['description']); ?></textarea>
              <div class="invalid-feedback">
                Required
              </div>
            </div>
            <div class="form-group">
              <label for="formGroupExampleInput">Meta Keywords</label>
              <input type="text" class="form-control" name="keywords" id="keywords" value="<?php echo $course['meta_keywords']; ?>" required>
              <div class="invalid-feedback">
                Required
              </div>
            </div>
            <div class="form-group">
              <label for="formGroupExampleInput">Price</label>
              <input type="number" class="form-control" name="price" id="price" min="0" step="0.01" max="10000" value="<?php echo $course['price']; ?>">
            </div>
            <label for="formGroupExampleInput">Category</label>
            <div class="input-group mb-4" style="width: 100%;">
              <select class="browser-default custom-select select2" name="category[]" id="category" multiple="multiple" data-placeholder="Select a Category" style="width: 100%;" required>
                <?php foreach($course_to_categories as $category){ ?> 
                  <option value="<?php echo $category['id']; ?>" <?php if($category['course_ID'] == $course['course_ID']){ echo 'selected'; }?>><?php echo ucwords($category['name']); ?></option>
                <?php } ?>
              </select>
              <div class="invalid-feedback">
                Required
              </div>
            </div>
            <label for="image">Image/Banner (Optional)</label>
            <div class="input-group mb-3">
              <input type="text" class="form-control" aria-describedby="button-addon2" name="image" id="image" value="<?php echo $course['image']; ?>">
              <div class="input-group-append">
                <a href="javascript:open_popup('<?php echo base_url('vendors/dialog.php?type=2&popup=1&amp;field_id=image'); ?>')" class="btn btn-md btn-outline-primary m-0 px-3 py-2 z-depth-0 waves-effect">Browse Media</a>
              </div>
            </div>
            <button class="btn btn-outline-primary waves-effect" id="update_course">Save Changes</button>
          </form>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main><!--Main laypassed out-->
<script>
$(document).ready(function(){
  $.ajax({
    url : "<?=base_url()?>courses/get_categories",
    method : "POST",
    async : true,
    dataType : 'json',
    success: function(data){
      var i;
      for(i=0; i<data.length; i++){
        if($('#category option[value='+data[i].id+']').length == 0){
          $('#category').append('<option value="'+data[i].id+'">'+data[i].name+'</option>');
        }
      }
    }
  });
  return false;
});
</script>
<script type="text/javascript">
$(document).ready(function() {
  $('#update_course').on('click',function(){
    var course_ID = $('#course_ID').val();
    var title = $('#title').val();
    var description = $('#description').val();
    var keywords = $('#keywords').val();
    var image = $('#image').val();
    var price = $('#price').val();
    var category = $('#category').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/update_course",
      dataType : "JSON",
      data : {course_ID:course_ID, title:title, description:description, keywords:keywords, image:image, price:price, category:category},
      success: function(data){
        if(data.error){
          toastr.error(data.message);
          error_sound.play();
        } else {
          toastr.success('Course updated!');
          window.location.href = "<?php echo base_url(); ?>instructor/course";
        }
      }
    });
  });
});
</script>