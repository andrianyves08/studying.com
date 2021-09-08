<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>instructor">Home</a></span>
        <span>/</span>
        <span><a href="<?php echo base_url();?>instructor/course">Course</a></span>
      </h4>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <table class="table table-bordered display table-responsive-md" cellspacing="0" width="100%">
            <thead>
              <th>Title</th>
              <th>Last Modified</th>
              <th></th>
            </thead>
            <tbody>
            <?php foreach ($courses as $course){ ?>
              <?php if ($course['status'] == '2'){ ?>
                <tr class="course_<?php echo $course['course_ID']; ?>">
                  <td><?php echo ucfirst($course['title']); ?></td>
                  <td><?php echo date("F d, Y h:i A", strtotime($course['date_modified'])); ?></td>
                  <td>
                    <a class="btn btn-sm btn-primary view_details" data-id="<?php echo $course['course_ID']; ?>">View Details</a>
                    <a class="btn btn-sm btn-success restore_course" data-id="<?php echo $course['course_ID']; ?>">Restore</a>
                    <a class="btn btn-sm btn-danger delete_course" data-id="<?php echo $course['course_ID']; ?>">Totally Delete</a>
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
  $(document).on("click", ".restore_course", function() { 
    var course_ID=$(this).data('id');
    var status = '1';
    alert_sound.play();
    if(confirm("Are you sure you want to restore this Course?")){
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>courses/update_course_status",
        dataType : "JSON",
        data : {course_ID:course_ID, status:status},
        success: function(data){
          toastr.success('Course restored');
          $(".course_"+course_ID).empty();
        }
      });
    }
  });

  $(document).on("click", ".delete_course", function() { 
    var course_ID=$(this).data('id');
    alert_sound.play();
    if(confirm("Are you sure you want to delete this Course? All of its contents will also be deleted")){
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>courses/delete_course",
        dataType : "JSON",
        data : {course_ID:course_ID},
        success: function(data){
          toastr.error('Course Deleted!');
          $(".course_"+course_ID).empty();
        }
      });
    }
  });
});
</script>