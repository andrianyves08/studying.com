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
          <h4>Total Students: <strong><?php echo count($students); ?></strong></h4>
          <table class="table table-bordered display table-responsive-md" cellspacing="0" width="100%">
            <thead>
              <th>Title</th>
              <th>User Status</th>
              <th>Purchase Status</th>
              <th>Date Enrolled</th>
              <th></th>
            </thead>
            <tbody>
            <?php foreach ($students as $student){ ?>
              <tr>
                <td><?php echo ucwords($student['first_name']); ?> <?php echo ucwords($student['last_name']); ?></td>
                <td>
                  <?php if($student['user_status'] == '0'){?>
                    <span class="badge badge-pill badge-warning">Deactivated</span>
                  <?php } else { ?>
                    <span class="badge badge-pill badge-success">Active</span>
                  <?php } ?>
                </td>
                <td><?php echo ucwords($student['purchase_status_name']); ?></td>
                <td><?php echo date("F d, Y h:i A", strtotime($student['date_enrolled'])); ?></td>
                <td><a class="btn btn-sm btn-primary view_profile" data-user-id="<?php echo $student['user_ID']; ?>">View Profile</a></td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#enroll_student_modal">Enroll Student</button>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main><!--Main laypassed out-->
<!-- View Profile -->
<div data-backdrop="static" class="modal fade" id="view_profile_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-md modal-notify modal-info" role="document">
    <div class="modal-content">
      <div id="user_profile">
        
      </div>
      <button type="button" class="btn btn-danger btn-sm mt-4" data-dismiss="modal" style="width: 25%;">Close</button>
    </div>
  </div>
</div>
<!-- Change Status -->
<div data-backdrop="static" class="modal fade" id="enroll_student_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Enroll Student</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="form-group">
          <label for="formGroupExampleInput">* Select User</label>
          <select name="user_ID" id="user_ID" class="select2" style="width: 100%;" required>
            <option selected disabled>Select User</option>
            <?php foreach ($users as $row) { 
              if($row['status'] == '1'){
            ?>
              <option value='<?php echo $row['id']; ?>'><?php echo ucwords($row['first_name']); ?> <?php echo ucwords($row['last_name']); ?></option>
            <?php } } ?>
          </select>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-success waves-effect float-right" type="submit" id="submit_enrollment">Enroll Student</button>
      </div>
    </div>
  </div>
</div>
<!-- Change Status -->

<script type="text/javascript">
$(document).ready(function() {
  $(document).on("click", ".view_profile", function() {
    var user_ID=$(this).data('user-id');
    $('#view_profile_modal').modal('show');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>users/get_users",
      dataType : "JSON",
      data : {user_ID:user_ID},
      success: function(data){
        var html = '';
        html += '<div class="view overlay"><img class="card-img-top" src="<?php echo base_url(); ?>assets/img/users/thumbs/'+data.image+'" alt="Profile Photo" onerror="this.onerror=null;this.src=\'<?php echo base_url();?>assets/img/users/stock.jpg\';"><a href="#!"><div class="mask rgba-white-slight"></div></a></div><strong><h4 class="card-title ml-4">'+data.full_name+'</h4></strong><p class="card-text ml-4 font-italic">'+data.about_me+'</p><a class="ml-4 mr-3"><strong>'+data.count_posts+'</strong> Posts</a><a class="following mr-3"><strong>'+data.count_following+'</strong> Following</a><a class="followers"><strong>'+data.count_followers+'</strong> Followers</a>';
        $('#user_profile').html(html);
      }
    });
  });

  $('#submit_enrollment').on('click',function(){
    var user_ID = $('[name="user_ID"]').val();
    var course_ID = '<?php echo $course['course_ID']; ?>';
    var status = '1';
    var comment = 'Enrolled by the instructor';
    var admin_ID = 0;
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>purchase/add_purchase",
      dataType : "JSON",
      data : {user_ID:user_ID, course_ID:course_ID, status:status, comment:comment, admin_ID:admin_ID},
      success: function(data){
        if(data.error){
          toastr.error(data.message);
          error_sound.play();
        } else {
          toastr.success('Student has been enrolled!');
          $('#enroll_student_modal').modal('hide');
          $('[name="user_ID"]').val("");
          $('[name="course"]').val("");
          location.reload();
        }
      }
    });
  });
});
</script>