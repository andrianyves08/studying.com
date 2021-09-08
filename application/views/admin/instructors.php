<main class="pt-5 mx-lg-5">
  <div class="container-fluid mt-5">
    <div class="card mb-4 wow fadeIn">
      <div class="card-body d-sm-flex justify-content-between">
        <h4 class="mb-2 mb-sm-0 pt-1">
          <span><a href="<?php echo base_url();?>admin">Home</a></span>
          <span>/</span>
          <span>Instructors</span>
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
                <th>Full Name</th>
                <th>Course Description</th>
                <th>Experience</th>
                <th>Status</th>
                <th>Date Submitted</th>
                <th></th>
              </thead>
              <tbody>
              <?php foreach($instructors as $row){ ?> 
                <tr>
                  <td><?php echo ucwords($row['first_name']);?> <?php echo ucwords($row['last_name']);?></td>
                  <td><?php echo ucfirst($row['course_description']);?></td>
                  <td><?php echo ucfirst($row['experience']);?></td>
                  <td>
                    <?php if($row['status'] == '1'){?>
                      <span class="badge badge-pill badge-success">Approved</span>
                    <?php } elseif($row['status'] == '2') { ?>
                      <span class="badge badge-pill badge-danger">Denied</span>
                    <?php } ?>
                  </td>
                  <td><?php echo date("F d, Y h:i A", strtotime($row['date_created']));?></td>
                  <td>
                    <?php if($row['status'] == '0'){?>
                      <a class="btn btn-sm btn-success approve" data-id="<?php echo $row['id'];?>" data-name="<?php echo ucwords($row['first_name']);?> <?php echo ucwords($row['last_name']);?>" data-user-id="<?php echo $row['user_ID'];?>">Approve</a><a class="btn btn-sm btn-danger deny" data-id="<?php echo $row['id'];?>" data-name="<?php echo ucwords($row['first_name']);?> <?php echo ucwords($row['last_name']);?>" data-user-id="<?php echo $row['user_ID'];?>">Deny</a>
                    <?php } ?>
                  </td>
                </tr>
              <?php }?>
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
  $(document).on("click", ".approve", function() { 
    var name=$(this).data('name');
    var user_ID=$(this).data('user-id');
    alert_sound.play();
    if(confirm("Are you sure you want to approve "+name+" an Instructor?")){
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>users/approve_as_instructor",
        dataType : "JSON",
        data : {user_ID:user_ID},
        success: function(data){
          location.reload();
        }
      });
    }
  });

  $(document).on("click", ".deny", function() { 
    var name=$(this).data('name');
    var user_ID=$(this).data('user-id');
    alert_sound.play();
    if(confirm("Are you sure you want to deny "+name+" an Instructor?")){
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>users/deny_as_instructor",
        dataType : "JSON",
        data : {user_ID:user_ID},
        success: function(data){
          location.reload();
        }
      });
    }
  });
});
</script>