<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>instructor">Home</a></span>
        <span>/</span>
        <span>Settings</span>
      </h4>
    </div>
  </div>
  <!-- Heading -->
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <?php echo form_open_multipart('instructor/change_password'); ?>
            <div class="form-group">
              <label for="formGroupExampleInput">* Current Password</label>
              <input type="password" name="current_password" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="formGroupExampleInput">* New Password</label>
              <input type="password" name="new_password" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="formGroupExampleInput">* Confirm New Password</label>
              <input type="password" name="confirm_new_password" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Cancel</button>
            <button class="btn btn-outline-primary waves-effect" type="submit">Save Changes</button>
          <?php echo form_close(); ?>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Colmun-->
  </div><!--Row-->
</div><!--Container-->
</main>