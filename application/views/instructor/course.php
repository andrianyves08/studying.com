<?php 
  $CI =& get_instance();
  $CI->load->model('review_model');
  function renderStarRating($rating, $maxRating=5) {
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
<div class='preloader' id="preloader" style='display:none'>
  <h1 class="mr-4">Loading...</h1>
  <h2 class="mr-4">Changing status of its modules, sections, lessons, and contents as well</h2>
  <img src='<?php echo base_url(); ?>assets/img/ajax-loader.gif'/>
</div>
<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>instructor">Home</a></span>
        <span>/</span>
        <span>Course</span>
      </h4>
      <h4 class="mb-2 mb-sm-0 pt-1 float-right">
        <span><a href="<?php echo base_url();?>instructor/course-archive">Archive</a></span>
      </h4>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <table class="table table-bordered display table-responsive-md" cellspacing="0" width="100%">
            <thead>
              <th style="width: 40%;">Title</th>
              <th style="width: 10%;">Ratings</th>
              <th style="width: 10%;">Status</th>
              <th style="width: 10%;">Privacy</th>
              <th style="width: 10%;">Last Modified</th>
              <th style="width: 30%;"></th>
            </thead>
            <tbody>
            <?php foreach ($courses as $course){ ?>
              <?php if($course['status'] == '0' || $course['status'] == '1'){ ?>
                <tr class="course_<?php echo $course['course_ID']; ?>">
                  <td><?php echo ucfirst($course['title']); ?></td>
                  <td><?php 
                    $rating = $CI->review_model->get_rating(3, $course['course_ID']);
                    echo renderStarRating($rating['avg']);
                  ?></td>
                  <td>
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input status_switch" id="status_switch_<?php echo $course['course_ID'];?>" <?php echo ($course['status'] == '1') ? 'checked' : '' ?> data-id="<?php echo $course['course_ID'];?>">
                      <label class="custom-control-label" for="status_switch_<?php echo $course['course_ID'];?>">
                        <?php if($course['status'] == '0'){?>
                          <span class="badge badge-pill badge-warning status_switch_label_<?php echo $course['course_ID'];?>">Hidden</span>
                        <?php } else { ?>
                          <span class="badge badge-pill badge-success status_switch_label_<?php echo $course['course_ID'];?>">Active</span>
                        <?php } ?>
                      </label>
                    </div>
                  </td>
                  <td>
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input privacy_switch" id="privacy_switch_<?php echo $course['course_ID'];?>" <?php echo ($course['privacy'] == '1') ? 'checked' : '' ?> data-id="<?php echo $course['course_ID'];?>">
                      <label class="custom-control-label" for="privacy_switch_<?php echo $course['course_ID'];?>">
                        <?php if($course['privacy'] == '0'){?>
                          <i class="fas fa-lock-open privacy_switch_label_<?php echo $course['course_ID'];?>"> Public</i>
                        <?php } else { ?>
                          <i class="fas fa-lock privacy_switch_label_<?php echo $course['course_ID'];?>"> Private</i>
                        <?php } ?>
                      </label>
                    </div>
                  </td>
                  <td><span hidden><?php echo date("Y-m-d", strtotime($course['date_modified']));?></span><?php echo date("F d, Y h:i A", strtotime($course['date_modified']));?></td>
                  <td>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <a class="btn btn-sm btn-success" href='<?php echo base_url(); ?>instructor/course/<?php echo $course['slug'];?>'>Edit Contents</a>
                        <a class="btn btn-sm btn-secondary" href='<?php echo base_url(); ?>instructor/course-students/<?php echo $course['slug'];?>'>View Enrollees</a>
                        <a class="btn btn-sm btn-primary" href='<?php echo base_url(); ?>instructor/edit/course/<?php echo $course['slug'];?>'>Rename</a>
                        <a class="btn btn-sm btn-info delete_course" data-id="<?php echo $course['course_ID']; ?>">Archive</a>
                      </div>
                    </div>
                  </td>
                </tr>
              <?php } ?>
            <?php } ?>
            </tbody>
          </table>
          <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#createlesson">Create Course</a>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main><!--Main laypassed out-->
<!-- Are you sure -->
<div class="modal fade" id="createlesson" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Create Course</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <form class="needs-validation" novalidate>
        <div class="modal-body">
          <div class="form-group">
            <label for="formGroupExampleInput">Title</label>
            <input type="text" class="form-control" name="title" id="title" required>
            <div class="invalid-feedback">
              Required
            </div>
          </div>
          <div class="form-group">
            <label for="exampleFormControlTextarea2">Description</label>
            <textarea class="form-control rounded-0" name="description" id="description" rows="3" required></textarea>
            <div class="invalid-feedback">
              Required
            </div>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Meta Keywords</label>
            <input type="text" class="form-control" name="keywords" id="keywords" required>
            <div class="invalid-feedback">
              Required
            </div>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Price</label>
            <input type="number" class="form-control" name="price" id="price" min="0" step="0.01" max="1000000" required>
            <div class="invalid-feedback">
              Required
            </div>
          </div>
          <label for="formGroupExampleInput">Category</label>
          <div class="input-group mb-4" style="width: 100%;">
            <select class="browser-default custom-select select2" name="category[]" id="category" multiple="multiple" data-placeholder="Select a Category" style="width: 100%;">
              <?php foreach ($categories as $category) { ?>
                <option class="sub_category_<?php echo $category['id']; ?>" value="<?php echo $category['id']; ?>"><?php echo ucwords($category['name']); ?></option>
              <?php } ?>
            </select>
          </div>
          <label for="image">Image/Banner (Optional)</label>
          <div class="input-group mb-3">
            <input type="text" class="form-control" aria-describedby="button-addon2" name="image" id="image">
            <div class="input-group-append">
              <a href="javascript:open_popup('<?php echo base_url('vendors/dialog.php?type=2&popup=1&amp;field_id=image'); ?>')" class="btn btn-md btn-outline-primary m-0 px-3 py-2 z-depth-0 waves-effect">Browse Media</a>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-center">
          <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
          <button class="btn btn-success waves-effect" id="create_course"><i class="fa fa-check-square-o"></i>Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete Course -->
<div data-backdrop="static" class="modal fade" id="delete_course_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Delete Course</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this Course?
           All of its contents will also be delete.</p>
        <input type="hidden" class="form-control" name="course_ID" id="course_ID" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="delete_course">Confirm</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
  $(".status_switch").click(function() {
    var id=$(this).data('id');
    if(confirm("Are you sure you want to change status of this Course?")){
      if($(this).is(":checked")){
        $('.status_switch_label_'+id).removeClass("badge-warning").addClass("badge-success").text('Active');
        $(this).val(1);
        change_status(id, '1');
      } else {
        $('.status_switch_label_'+id).removeClass("badge-success").addClass("badge-warning").text('Hidden');
        $(this).val(0);
        change_status(id, '0');
      }
    }
  });

  function change_status(course_ID, status){
    $('#preloader').show();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/update_course_status",
      dataType : "JSON",
      data : {course_ID:course_ID, status:status},
      success: function(data){
        $('#preloader').hide();
        return true;
      }
    });
  }

  $(document).on("click", ".delete_course", function() { 
    var id=$(this).data('id');
    alert_sound.play();
    if(confirm("Are you sure you want to archive this Course?")){
      change_status(id, '2');
      $(".course_"+id).empty();
      toastr.error('Course Deleted!');
    }
  });

  $('#create_course').on('click',function(){
    var title = $('#title').val();
    var description = $('#description').val();
    var keywords = $('#keywords').val();
    var image = $('#image').val();
    var price = $('#price').val();
    var category = $('#category').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/create_course",
      dataType : "JSON",
      data : {title:title, description:description, keywords:keywords, image:image, price:price, category:category},
      success: function(data){
        if(data.error){
          toastr.error(data.message);
          error_sound.play();
        } else {
          toastr.success('Course created!');
          location.reload();
        }
      }
    });
  });


  $(".privacy_switch").click(function() {
    var id=$(this).data('id');
    if(confirm("Are you sure you want to change privacy of this Course?")){
      if($(this).is(":checked")){
        $('.privacy_switch_label_'+id).removeClass("fa-lock-open").addClass("fa-lock").text(' Private');
        $(this).val(1);
        change_privacy(id, '1');
      } else {
        $('.privacy_switch_label_'+id).removeClass("fa-lock").addClass("fa-lock-open").text(' Public');
        $(this).val(0);
        change_privacy(id, '0');
      }
    }
  });

  function change_privacy(course_ID, privacy){
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/update_course_privacy",
      dataType : "JSON",
      data : {course_ID:course_ID, privacy:privacy},
      success: function(data){
      }
    });
  }

});
</script>