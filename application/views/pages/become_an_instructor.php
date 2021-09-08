<main class="pt-5 mx-lg-5">
  <div class="container-fluid mt-5">
    <section class="card wow fadeIn" style="background-image: url(<?php echo base_url();?>assets/img/bg4.jpg);background-attachment: fixed; background-position: center; background-repeat: no-repeat; background-size: cover; height: 300px;">
      <div class="card-body text-white text-center py-5 px-5 my-5">
        <h1 class="mb-4">
          <strong>Become an Instructor</strong>
        </h1>
      </div>
    </section>
    <hr class="my-5">
    <section class="wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
      <div class="row justify-content-center">
        <div class="col-lg-8">
        <?php if(empty($role_status) && $my_info['role'] != '1'){ ?>
          <?php echo form_open_multipart('users/request_as_instructor'); ?>
            <div class="news-data">
              <div class="form-group">
                <label>Detailed Course Description</label>
                <textarea class="form-control rounded-0" name="description" id="description" rows="10" placeholder="Describe your course" required></textarea>
              </div>
              <div class="form-group">
                <label>Experience (Optional)</label>
                <textarea class="form-control rounded-0" name="experience" id="experience" rows="10" placeholder="Describe your experience as an instructor"></textarea>
              </div>
              <button class="btn btn-primary waves-effect " type="submit">Submit Form</button>
            </div><!--News-->
          <?php echo form_close(); ?>
        <?php } else { ?>
          <div class="jumbotron card card-image">
            <div class="text-center py-5 px-4">
              <div>
                <h2 class="card-title h1-responsive pt-3 font-bold"><strong>Thank you for registration!</strong></h2>
                  <?php if($role_status['status'] == '2'){ ?>
                    <p>Sorry your application has been denied</p>
                  <?php } else { ?>
                    <p>Kindly wait for approval</p>
                  <?php } ?>
              </div>
            </div>
          </div>
        <?php } ?>
        </div><!--Column-->
      </div><!--Row-->
    </section>
  </div>
</main>