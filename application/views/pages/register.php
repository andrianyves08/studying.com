<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Register</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="<?php echo base_url();?>assets/css/mdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="<?php echo base_url();?>assets/css/style.min.css" rel="stylesheet">
  <link rel="icon" href="<?php echo base_url();?>assets/img/overlays/logo-1.png">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.css">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>  

</head>
<style type="text/css">
* {
  margin: 0;
  padding: 0;
}

html, body {
  height: 100%;
  width: 100%;
  min-width: 100%;
}

body {
  background: url("<?php echo base_url();?>assets/img/<?php if($title == 'Course'){ echo 'bg1.jpg'; } elseif ($title == 'Messages') { echo 'bg2.jpg'; } elseif ($title != 'Index') { echo 'bg4.jpg'; } else { echo 'NULL'; } ?>") no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
  z-index: -200;
}

p, h1, h2, h3, h4, h5, h6, label, td, dt, dd, li, span, tr{
  user-select: none; /* supported by Chrome and Opera */
  -webkit-user-select: none; /* Safari */
  -khtml-user-select: none; /* Konqueror HTML */
  -moz-user-select: none; /* Firefox */
  -ms-user-select: none; /* Internet Explorer/Edge */
}

.video-overlay {
  position: fixed;
  height: 100%;
  width: 100%;
  background: #fff;
  z-index: -99;
  opacity: .85;
}
</style>
<body>
  <div class="video-overlay"></div>
  <div class="container">
    <section>
      <div class="row">
        <div class="col-md-6 mx-auto pt-4 mt-4">
          <div class="card">
            <div class="card-body">
              <form action="<?php echo base_url(); ?>register" method="POST" class="needs-validation" id="register" novalidate>
                <img alt="Logo" src="<?php echo base_url(); ?>assets/img/logo.png" class="img-fluid wow bounceInUp slow mb-4">
                <h2 class="mb-3 text-center">Register</h2>
                <div class="form-row mb-4">
                  <input type="hidden" class="form-control" name="role" value="0">
                  <div class="col">
                    <label for="formGroupExampleInput">First Name</label>
                    <input type="text" class="form-control" name="first_name" required>
                    <div class="invalid-feedback">
                      Required
                    </div>
                  </div>
                  <div class="col">
                    <label for="formGroupExampleInput">Last Name</label>
                    <input type="text" class="form-control" name="last_name" required>
                    <div class="invalid-feedback">
                      Required
                    </div>
                  </div>
                </div>
                <div class="form-row mb-4">
                    <label for="formGroupExampleInput">Email</label>
                  <input type="email" id="email" name="email" class="form-control" required>
                  <div class="invalid-feedback">
                    Required
                  </div>
                </div>
                <div class="form-row mb-4">
                    <label for="formGroupExampleInput">Username (Optional)</label>
                  <input type="text" id="username" name="username" class="form-control">
                </div>
                <div class="form-row mb-4">
                    <label for="formGroupExampleInput">Password</label>
                  <input type="password" id="password" name="password" class="form-control" required>
                  <div class="invalid-feedback">
                    Required
                  </div>
                </div>
                <div class="form-row mb-4">
                    <label for="formGroupExampleInput">Confirm Password</label>
                  <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                  <div class="invalid-feedback">
                    Required
                  </div>
                </div>
                <input type="hidden" id="timezone" name="timezone">
                <div class="text-center mb-2 mt-4">
                  <button type="submit" class="btn btn-primary btn-rounded waves-effect" name="login">Register</button>
                </div>
                <p style="font-size: 12px; width: 100%" class="grey-text text-center mt-0 pt-0">By clicking this button, you agree to our <strong><a class="grey-text" href="https://www.studying.com/terms-and-conditions" target="_blank"><u>Terms</u></a></strong> and <strong><a class="grey-text" href="https://www.studying.com/privacy-policy" target="_blank"><u>Privacy Policy</u></a></strong></p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-3.4.1.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="<?php echo base_url();?>assets/js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="<?php echo base_url();?>assets/js/mdb.min.js"></script>
  <!-- Initializations -->
  <script type="text/javascript">
  // Animations initialization
  new WOW().init();
  </script>
  <script src="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.js"></script>
  <script type="text/javascript">
  $(function() {  
    <?php if($this->session->flashdata('success')): ?>
      <?php echo "toastr.success('".$this->session->flashdata('success')." ')"; ?>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
      <?php echo "toastr.error('".$this->session->flashdata('error')." ')"; ?>
    <?php endif; ?>  
  });
  </script>
  <?php if($this->session->flashdata('multi')): ?>
    <?php echo $this->session->flashdata('multi'); ?>
  <?php endif; ?>

  <script type="text/javascript">
    var offset = new Date().getTimezoneOffset(), o = Math.abs(offset);
    var timezone = (offset < 0 ? "+" : "-") + ("00" + Math.floor(o / 60)).slice(-2) + ":" + ("00" + (o % 60)).slice(-2);
    $('#timezone').val(timezone);
  </script>
  <script type="text/javascript">
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
    </script>
</body>
</html>