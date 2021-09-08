<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>admin">Home</a></span>
        <span>/</span>
        <span>Course</span>
      </h4>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <table class="table table-bordered display table-responsive-md" cellspacing="0" width="100%">
            <thead>
              <th>Course ID</th>
              <th>Title</th>
              <th>Last Modified</th>
              <th></th>
            </thead>
            <tbody>
            <?php foreach ($courses as $course){ ?>
              <?php if ($course['status'] == 2){ ?>
                <tr>
                  <td><?php echo $course['course_ID']; ?></td>
                  <td><?php echo ucfirst($course['title']); ?></td>
                  <td><?php echo date("F d, Y h:i A", strtotime($course['date_modified'])); ?></td>
                  <td>
                    <a class="btn btn-sm btn-success edit_course" data-id="<?php echo $course['course_ID']; ?>">Restore</a>
                  </td>
                </tr>
              <?php } ?>
            <?php } ?>
            </tbody>
          </table>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main><!--Main laypassed out-->
<!-- Module Edit -->
<div data-backdrop="static" class="modal fade" id="edit_course" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg modal-notify modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Edit Module</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>      
      <div class="modal-body">
        <input type="hidden" class="form-control" name="course_ID" id="course_ID">
        <label for="course_status">* Status</label>
        <div class="custom-control custom-switch mb-4">
          <input type="checkbox" class="custom-control-input customSwitches" id="course_status" name="course_status">
          <label class="custom-control-label switch_label" for="course_status"></label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm" type="submit" id="update_module">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Module Edit -->
<script type="text/javascript">
$(document).ready(function() {
  $(".customSwitches").click(function() {
    if($(".customSwitches").is(":checked")){
      $('.switch_label').text('Active');
      $(this).val(1);
    } else {
      $('.switch_label').text('Inactive');
      $(this).val(0);
    }
  });
});
</script>
<script type="text/javascript">
$(document).ready(function() {
  $(document).on("click", ".edit_course", function() { 
    var course_ID=$(this).data('id');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/get_course",
      dataType : "JSON",
      data : {course_ID:course_ID},
      success: function(data){
        $('#edit_course').modal('show');
        $('[name="course_ID"]').val(course_ID);
        $('[name="course_status"]').val(data.status);
        $('.switch_label').text('Hidden');
        if(data.status == 1){
          $('#course_status').attr("checked", "checked");
          $('.switch_label').text('Active');
        }
      }
    });
    return false;
  });

  //update module
  $('#update_module').on('click',function(){
    var id = $('#course_ID').val();
    var status = $('#course_status').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/update_course_status",
      dataType : "JSON",
      data : {course_ID:id, course_status:status},
      success: function(data){
        if(data.error){
          toastr.error(data.message);
        } else {
          toastr.success('Course status updated.');
          $('[name="course_ID"]').val("");
          $('[name="course_status"]').val("");
          $('#edit_course').modal('hide');
          location.reload();
        }
      }
    });
    return false;
  });
});
</script>