<main class="pt-5 mx-lg-5">
  <div class="container-fluid mt-5">
    <div class="card mb-4 wow fadeIn">
      <div class="card-body d-sm-flex justify-content-between">
        <h4 class="mb-2 mb-sm-0 pt-1">
          <span><a href="<?php echo base_url();?>admin">Home</a></span>
          <span>/</span>
          <span>Users</span>
        </h4>
      </div>
    </div>
    <!-- Heading -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Users</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Daily Logins Reward Tracker</a>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active p-1 mt-4" id="home" role="tabpanel" aria-labelledby="home-tab">
                <table class="table table-bordered display table-responsive-md" cellspacing="0" width="100%">
                  <thead>
                    <th>User ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Role</th>
                    <th>Last Login</th>
                    <th></th>
                  </thead>
                  <tbody>
                  <?php foreach($clients as $client){ ?> 
                    <tr>
                      <td><?php echo $client['id'];?></td>
                      <td><?php echo ucwords($client['first_name']);?> <?php echo ucwords($client['last_name']);?></td>
                      <td><?php echo $client['email'];?></td>
                      <td>
                        <?php if($client['status'] == '0'){?>
                          <span class="badge badge-pill badge-warning">Deactivated</span>
                        <?php } elseif($client['status'] == '1') { ?>
                          <span class="badge badge-pill badge-success">Active</span>
                        <?php } ?>
                      </td>
                      <td>
                        <?php if($client['role'] == '0'){?>
                          <span class="badge badge-pill badge-primary">Student</span>
                        <?php } else { ?>
                          <span class="badge badge-pill badge-secondary">Instructor</span>
                        <?php } ?>
                      </td>
                      <td><span hidden><?php echo date("Y-m-d", strtotime($client['last_login']));?></span><?php echo date("F d, Y h:i A", strtotime($client['last_login']));?></td>
                      <td><a class="btn btn-sm btn-success" href="<?php echo base_url('admin/users'); ?>/<?php echo $client['id'];?>"> View</a></td>
                    </tr>
                  <?php }?>
                  </tbody>
                </table>
              </div>
              <div class="tab-pane fade p-1 mt-4" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <table class="table table-bordered display table-responsive-md" cellspacing="0" width="100%">
                  <thead>
                    <th>User ID</th>
                    <th>Full Name</th>
                    <th>Number of Logins</th>
                    <th>Status</th>
                    <th>Last reward accepted</th>
                    <th>Date Started</th>
                    <th></th>
                  </thead>
                  <tbody>
                    <?php foreach($daily_logins as $row){ ?> 
                      <tr>
                        <td><?php echo $row['user_ID'];?></td>
                        <td><?php echo ucwords($row['first_name']);?> <?php echo ucwords($row['last_name']);?></td>
                        <td><?php echo $row['days'];?></td>
                        <td>
                          <?php if($row['days'] == '30'){?>
                            <span class="badge badge-pill badge-success">Completed</span>
                          <?php } elseif(strtotime($row['date_started']) < strtotime('-30 days')) { ?>
                            <span class="badge badge-pill badge-danger">Incomplete</span>
                          <?php } else { ?>
                            <span class="badge badge-pill badge-info">On-Going</span>
                          <?php } ?>
                        </td>
                        <td><span hidden><?php echo date("Y-m-d", strtotime($row['timestamp']));?></span><?php echo date("F d, Y h:i A", strtotime($row['timestamp']));?></td>
                        <td><span hidden><?php echo date("Y-m-d", strtotime($row['date_started']));?></span><?php echo date("F d, Y h:i A", strtotime($row['date_started']));?></td>
                        <td><a class="btn btn-sm btn-success" href="<?php echo base_url('admin/users'); ?>/<?php echo $row['user_ID'];?>"> View</a></td>
                      </tr>
                    <?php }?>
                  </tbody>
                </table>
              </div>
            </div>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createnews">Create User</button>
          </div><!--Card Body-->
        </div><!--Card-->
      </div><!--Column-->
    </div><!--Row-->
  </div><!--Container-->
</main><!--Main laypassed out-->
<!-- Are you sure -->
<div class="modal fade" id="createnews" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <?php echo form_open_multipart('users/create'); ?>
        <div class="form-group">
          <label for="formGroupExampleInput">* Email</label>
          <input type="email" class="form-control" name="email" required>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">* First Name</label>
          <input type="text" class="form-control" name="first_name" required>
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">* Last Name</label>
          <input type="text" class="form-control" name="last_name" required>
        </div>
        <div class="form-group">
        <label for="formGroupExampleInput">* Course</label>
          <select name="course[]" id="course" class="select2" multiple="multiple" data-placeholder="Select a State" style="width: 100%;" required>
            <?php foreach ($courses as $course) { ?>
             <option value="<?php echo $course['course_ID'];?>"><?php echo ucwords($course['title']);?></option>
            <?php }?>
          </select>
        </div> 
        <h6 class="red-text">NOTE: default password for new user is studying</h6>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Cancel</button>
        <button class="btn btn-outline-primary waves-effect" type="submit">Create User</button>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>