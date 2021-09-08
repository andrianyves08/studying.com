<div class="container">
<section class="p-3 my-md-3">
  <div class="row">
    <div class="col-md-5 mx-auto wow fadeInUp">
      <div class="card">
        <div class="card-body">
        <?php echo form_open('instructor/login'); ?> 
          <img alt="Logo" src="<?php echo base_url(); ?>assets/img/logo.png" class="img-fluid wow rotateIn slow mb-4">
          <h3 class="font-weight-bold pb-2 text-center dark-grey-text"><strong>Instructor</strong></h3>
          <input type="text" id="email" name="email" placeholder="Email" class="form-control mb-4">
          <input type="password" id="password" name="password" class="form-control mb-4" placeholder="Password">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="show_password">
            <label class="custom-control-label" for="show_password">Show Password</label>
          </div>
          <div class="text-center">
            <button type="submit" name="login" class="btn btn-primary btn-rounded my-4 waves-effect">Login</button>
          </div>
          <?php echo form_close(); ?>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</section>
<?php echo validation_errors(); ?>
</div><!--Container-->
<script type='text/javascript'>
$(document).ready(function(){
  $('#show_password').click(function(){
    $(this).is(':checked') ? $('#password').attr('type', 'text') : $('#password').attr('type', 'password');
  });
});
</script>