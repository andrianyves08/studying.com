<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>instructor">Home</a></span>
        <span>/</span>
        <span>Students</span>
      </h4>
    </div>
  </div>
  <!-- Heading -->
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h4>Total Students: <strong><?php echo count($students); ?></strong></h4>
          <table class="table table-bordered display table-responsive-md" cellspacing="0" width="100%">
            <thead>
              <th>Full Name</th>
              <th>Course Enrolled</th>
              <th>Status</th>
              <th>Last Login</th>
            </thead>
            <tbody>
            <?php 
              $CI =& get_instance();
              $CI->load->model('purchase_model');
              foreach($students as $student){ 
                $courses = $CI->purchase_model->users_course($student['user_ID'], NULL);
              ?> 
              <tr>
                <td><?php echo ucwords($student['first_name']);?> <?php echo ucwords($student['last_name']);?></td>
                <td>
                  <?php foreach($courses as $course){ 
                    echo '● '.ucwords($course['title']).'<br>';
                  } ?>
                </td>
                <td>
                  <?php if($student['user_status'] == '0'){?>
                    <span class="badge badge-pill badge-danger">Deactivated</span>
                  <?php } elseif($student['user_status'] == '1') { ?>
                    <span class="badge badge-pill badge-success">Active</span>
                  <?php } ?>
                </td>
                <td><span hidden><?php echo date("Y-m-d", strtotime($student['last_login']));?></span><?php echo date("F d, Y h:i A", strtotime($student['last_login']));?></td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main><!--Main laypassed out-->