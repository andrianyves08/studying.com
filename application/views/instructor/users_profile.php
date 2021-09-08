<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>admin">Home</a></span>
        <span>/</span>
        <span><a href="<?php echo base_url(); ?>admin/users">Users</a></span>
        <span>/</span>
        <span><?php echo ucwords($users['first_name']);?> <?php echo ucwords($users['last_name']);?></span>
      </h4>
    </div>
  </div>
  <!-- Heading -->
  <div class="row">
    <div class="col-md-4">
      <div class="card mb-4">
        <div class="view overlay">
          <img class="card-img-top chat-mes-id-3" src="<?php echo base_url();?>assets/img/users/<?php echo $users['image'];?>" alt="Profile Photo" onerror="this.onerror=null;this.src='<?php echo base_url();?>assets/img/users/stock.jpg';">
          <a href="#!">
            <div class="mask rgba-white-slight"></div>
          </a>
        </div>
        <div class="card-body">
          <h4 class="card-title">
            <?php if(!empty($users['first_name']) && !empty($users['first_name'])){?>
              <strong><?php echo ucwords($users['first_name']);?> <?php echo ucwords($users['last_name']);?></strong>
            <?php } else { ?>
              <strong class="red-text">User doesn't add any name!</strong>
            <?php } ?>
          </h4>
          <h5 class="blue-text"><strong><?php echo $users['email'];?></strong></h5>
          <div>
            <?php if($users['status'] == '1'){
              echo '<a class="deactivate_user user_status btn btn-danger btn-sm m-0 px-2 py-2" data-user-status="0">Deactivate User</a>';
            } else {
              echo '<a class="reactivate_user user_status btn btn-success btn-sm m-0 px-2 py-2" data-user-status="1">Reactivate User</a>';
            }
            ?>
            <button type="button" class="btn btn-primary btn-sm m-0 px-2 py-2" data-toggle="modal" data-target="#change_password">Change Password</button>
            <button type="button" class="btn btn-secondary btn-sm m-0 px-2 py-2" data-toggle="modal" data-target="#change_email_modal">Change Email</button>
            <button type="button" class="btn btn-success btn-sm m-0 px-2 py-2" data-toggle="modal" data-target="#enroll_student_modal">Enroll Student</button>
          </div>
        </div>
      </div>
    </div><!--Column -->

    <div class="col-md-8">
      <div class="card mb-4">
        <div class="card-header customcolorbg">
           <h4 class="text-white"><strong>Videos Watched </strong></h4>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-responsive-md display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th scope="col">Module Name</th>
                <th scope="col">Content Name</th>
                <th scope="col">Status</th>
                <th scope="col">Date Finished</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($videos as $video) {?>
              <tr>
                <td><?php echo ucwords($video['title']);?></td>
                <td><?php echo ucwords($video['content_title']);?></td>
                <td>
                  <?php if($video['status'] == 0){ ?>
                    <span class="badge badge-pill badge-info">On Going</span>
                  <?php } else { ?>
                    <span class="badge badge-pill badge-success">Finished Watching</span>
                  <?php } ?>
                </td>
                <td><?php echo date("F d, Y h:i A", strtotime($video['timestamp']));?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div><!--Card Body-->
      </div> <!--Card-->
    </div><!--Column Delete-->
  </div><!--Row-->

  <div class="row">
    <div class="col-md-12">
      <div class="card mb-4">
        <div class="card-header customcolorbg">
           <h4 class="text-white"><strong>Enrolled Courses </strong></h4>
        </div>
        <div class="card-body">
          <table class="table table-responsive-md" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th scope="col">Title</th>
                <th scope="col">Date Enrolled</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users_course as $module) {?>
                <tr>
                  <td><?php echo ucwords($module['title']);?></td>
                  <td><?php echo $module['date_enrolled'];?></td>
                  <td>
                    <?php if($module['purchase_status'] == 1){ ?>
                      <span class="badge badge-pill badge-success">Complete</span>
                    <?php } else { ?>
                      <span class="badge badge-pill badge-info"><?php echo ucwords($module['purchase_status_name']); ?></span>
                    <?php } ?>
                  </td>
                  <td><a class="btn btn-primary btn-sm change_status" data-purchase-id="<?php echo $module['purchase_ID']; ?>">Edit</a> <a class="btn btn-success btn-sm purchase_history" data-purchase-id="<?php echo $module['purchase_ID']; ?>">View Purchase History</a></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div><!--Card Body-->
      </div> <!--Card-->
      <div class="card mb-4">
        <div class="card-header customcolorbg">
           <h4 class="text-white"><strong>Created Courses </strong></h4>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-responsive-md display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Date Enrolled</th   >
              </tr>
            </thead>
            <tbody>
              <?php foreach ($courses as $course) {?>
                <tr>
                  <td><?php echo ucwords($course['title']);?></td>
                  <td><?php echo ucfirst($course['description']);?></td>
                  <td><?php echo $course['date_created'];?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div><!--Card Body-->
      </div> <!--Card-->
    </div><!--Column-->
  </div><!--Row--> 
</div><!--Container-->
</main><!--Main laypassed out-->
<!--Change Password -->
<div data-backdrop="static" class="modal fade" id="change_password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Change Password</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <?php echo form_open_multipart('users/change_password_by_admin'); ?>
        <div class="form-group">
          <label for="formGroupExampleInput">* New Password</label>
          <input type="password" name="new_password" class="form-control" required>
          <input type="hidden" class="form-control" name="user_ID" value="<?php echo $users['id'];?>">
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">* Confirm New Password</label>
          <input type="password" name="cnew_Password" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-success waves-effect float-right" type="submit">Save Changes</button>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
<!--Change Password -->

<!-- Change Profile -->
<div data-backdrop="static" class="modal fade" id="change_email_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Change Email</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
      <?php echo form_open_multipart('users/change_email'); ?>
        <div class="form-group">
          <label for="formGroupExampleInput">* Email</label>
          <input type="hidden" class="form-control" name="user_ID" value="<?php echo $users['id'];?>">
          <input type="email" class="form-control" name="email" value="<?php echo $users['email'];?>">
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-success waves-effect float-right" type="submit">Save Changes</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<!-- Change Profile -->

<!-- Change Status -->
<div data-backdrop="static" class="modal fade" id="purchase_status_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Edit Status</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <input type="hidden" class="form-control" name="purchase_ID">
        <div class="form-group">
          <label for="formGroupExampleInput">Purchase Status</label>
          <div class="input-group mb-4" style="width: 100%;">
            <select class="browser-default custom-select" name="purchase_status">
              <option selected disabled>Select Purchase Status</option>
              <?php foreach ($order_status as $row) { ?>
                <option value="<?php echo $row['id']; ?>"><?php echo ucwords($row['name']); ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="exampleFormControlTextarea2">Comment</label>
          <textarea class="form-control rounded-0" name="purchase_comment" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-success waves-effect float-right" type="submit" id="submit_purhase_status">Save Status</button>
      </div>
    </div>
  </div>
</div>
<!-- Change Status -->

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
        <input type="hidden" class="form-control" name="enroll_user_ID" value="<?php echo $users['id'];?>">
        <div class="form-group">
          <label for="formGroupExampleInput">Course</label>
          <div class="input-group mb-4" style="width: 100%;">
            <select class="browser-default custom-select" name="enroll_course">
              <option selected disabled>Select Course</option>
              <?php foreach ($all_courses as $row) { ?>
                <option value="<?php echo $row['course_ID']; ?>"><?php echo ucwords($row['title']); ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">Purchase Status</label>
          <div class="input-group mb-4" style="width: 100%;">
            <select class="browser-default custom-select" name="enroll_purchase_status">
              <option selected disabled>Select Purchase Status</option>
              <?php foreach ($order_status as $row) { ?>
                <option value="<?php echo $row['id']; ?>"><?php echo ucwords($row['name']); ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="exampleFormControlTextarea2">Note</label>
          <textarea class="form-control rounded-0" name="enroll_purchase_comment" rows="3"></textarea>
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

<!-- Purchase History -->
<div data-backdrop="static" class="modal fade" id="purchase_history_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Purchase history</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <table class="table">
          <thead>
            <tr>
              <th style="width: 20%; ">Status</th>
              <th style="width: 50%; ">Comment</th>
              <th style="width: 30%; ">Date</th>
            </tr>
          </thead>
          <tbody id="purchase_history">
          </tbody>
        </table>
      </div>
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</a>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  $(document).on("click", ".purchase_history", function() {
    var purchase_ID=$(this).data('purchase-id');
    $('#purchase_history_modal').modal('show');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>purchase/purchase_history",
      dataType : "JSON",
      data : {purchase_ID:purchase_ID},
      success: function(data){
        var html;
        for(var i=0; i<data.length; i++){
          html += '<tr><td>'+data[i].name+'</td><td>'+data[i].comment+'</td><td>'+data[i].date_created+'</td></tr>';
        }
        $('#purchase_history').html(html);
      }
    });
  });

  $('#submit_enrollment').on('click',function(){
    var user_ID = $('[name="enroll_user_ID"]').val();
    var course_ID = $('[name="enroll_course"]').val();
    var status = $('[name="enroll_purchase_status"]').val();
    var comment = $('[name="enroll_purchase_comment"]').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>purchase/add_purchase",
      dataType : "JSON",
      data : {user_ID:user_ID, course_ID:course_ID, status:status, comment:comment},
      success: function(data){
        toastr.success('Student has been enrolled!');
        $('#enroll_student_modal').modal('hide');
        $('[name="enroll_purchase_comment"]').val("");
      }
    });
  });

  $(document).on("click", ".change_status", function() {
    var purchase_ID=$(this).data('purchase-id');
    $('[name="purchase_ID"]').val(purchase_ID);
    $('#purchase_status_modal').modal('show');
  });

  $('#submit_purhase_status').on('click',function(){
    var id = $('[name="purchase_ID"]').val();
    var status = $('[name="purchase_status"]').val();
    var comment = $('[name="purchase_comment"]').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>purchase/change_status",
      dataType : "JSON",
      data : {id:id, status:status, comment:comment},
      success: function(data){
        toastr.success('Purchase Updated!');
        $('#purchase_status_modal').modal('hide');
        $('[name="purchase_ID"]').val("");
        $('[name="purchase_comment"]').val("");
      }
    });
  });

  $(document).on("click", ".deactivate_user", function() {
    var status = $(this).data('user-status');
    var id = <?php echo $users['id']; ?>;
    alert_sound.play();
    if(confirm("Are you sure you want to deactivate this user?")){
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>users/change_status",
        dataType : "JSON",
        data : {user_ID:id, status:status},
        success: function(data){
          toastr.success('User Deactivated!');
          $('.user_status').removeClass("btn-danger deactivate_user").addClass("badge-success reactivate_user").text('Reactivate User');
          $(".user_status").data("user-status", 1);
        }
      });
    }
  });

  $(document).on("click", ".reactivate_user", function() {
    var status = $(this).data('user-status');
    var id = <?php echo $users['id']; ?>;
    alert_sound.play();
    if(confirm("Are you sure you want to reactivate this user?")){
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>users/change_status",
        dataType : "JSON",
        data : {user_ID:id, status:status},
        success: function(data){
          toastr.success('User Deactivated!');
          $('.user_status').removeClass("btn-success reactivate_user").addClass("badge-danger deactivate_user").text('Deactivate User');
          $(".user_status").data("user-status", 0);
        }
      });
    }
  });
});
</script>
</body>
</html>