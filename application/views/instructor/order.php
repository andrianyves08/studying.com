<main class="pt-5 mx-lg-5">
  <div class="container-fluid mt-5">
    <div class="card mb-4 wow fadeIn">
      <div class="card-body d-sm-flex justify-content-between">
        <h4 class="mb-2 mb-sm-0 pt-1">
          <span><a href="<?php echo base_url();?>admin">Home</a></span>
          <span>/</span>
          <span>Order</span>
        </h4>
      </div>
    </div>
    <!-- Heading -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <table class="table table-bordered display table-responsive-md" cellspacing="0" width="100%">
              <thead>
                <th style="width: 20%;">Full Name</th>
                <th style="width: 25%;">Course</th>
                <th style="width: 15%;">Date Enrolled</th>
                <th style="width: 15%;">Status</th>
              </thead>
              <tbody>
              <?php foreach($orders as $row){ ?> 
                <tr>
                  <td><?php 
                    $current = strtotime(date("Y-m-d"));
                    $date    = strtotime($row['date_enrolled']);
                    $datediff = $date - $current;
                    $difference = floor($datediff/(60*60*24));
                    if($difference == 0){
                      echo '<span class="badge badge-danger">New</span> ';
                    }
                    echo ucwords($row['first_name']);?> <?php echo ucwords($row['last_name']);?>
                  </td>
                  <td><?php echo $row['title'];?></td>
                  <td><span hidden><?php echo date("Y-m-d", strtotime($row['date_enrolled']));?></span><?php echo date("F d, Y h:i A", strtotime($row['date_enrolled']));?></td>
                  <td>
                    <?php if($row['purchase_status'] == '1'){ ?>
                      <span class="badge badge-pill badge-success"><?php echo ucwords($row['purchase_status_name']);?></span>
                    <?php } else { ?>
                      <span class="badge badge-pill badge-info"><?php echo ucwords($row['purchase_status_name']);?></span>
                    <?php } ?>
                  </td>
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
        <div class="form-group">
          <label for="formGroupExampleInput">Course</label>
          <div class="input-group mb-4" style="width: 100%;">
            <select class="browser-default custom-select" name="course" required>
              <option selected disabled>Select Course</option>
              <?php foreach ($all_courses as $row) { ?>
                <option value="<?php echo $row['course_ID']; ?>"><?php echo ucwords($row['title']); ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-success waves-effect float-right" type="submit" id="submit_enrollment">Save Status</button>
      </div>
    </div>
  </div>
</div>
<!-- Change Status -->

<script type="text/javascript">
$(document).ready(function(){
  $('#submit_enrollment').on('click',function(){
    var user_ID = $('[name="user_ID"]').val();
    var course_ID = $('[name="course"]').val();
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
        }
      }
    });
  });
});
</script>