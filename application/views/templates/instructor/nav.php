<?php 
  $CI =& get_instance();
  $CI->load->model('purchase_model');

  $new_request = $CI->purchase_model->get_users_course(NULL, $user_ID);
  $count=0;
  foreach($new_request as $row){
    if($row['purchase_status'] == '2'){
      $count++;
    }
  }
?>
<header>
  <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link waves-effect active">
              <?php echo ucfirst($first_name);?> <?php echo ucfirst($last_name);?>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <strong><?php echo ucfirst($title);?>
              </strong>
            </a>
            <div class="dropdown-menu dropdown-menu-left dropdown-default" aria-labelledby="navbarDropdownMenuLink">
              <a href="<?php echo base_url();?>instructor" class="dropdown-item waves-effect waves-light <?php if($title == 'Home'){ echo 'active';}?> waves-effect">Dashboard<i class="fas fa-chart-pie ml-3"></i></a>
              <a href="<?php echo base_url();?>instructor/order" class="dropdown-item waves-effect waves-light <?php if($title == 'Order'){ echo 'active';}?>">Orders<i class="fas fa-bars ml-3"></i></a>
              <a href="<?php echo base_url();?>instructor/users" class="dropdown-item waves-effect waves-light <?php if($title == 'Users'){ echo 'active';}?>">My Students<i class="fas fa-user ml-3"></i></a>
              <a href="<?php echo base_url();?>instructor/course" class="dropdown-item waves-effect waves-light <?php if($title == 'Course'){ echo 'active';}?>">Course<i class="fas fa-graduation-cap ml-3"></i></a>
              <a href="<?php echo base_url();?>instructor/media" class="dropdown-item waves-effect waves-light <?php if($title == 'Media'){ echo 'active';}?>">Media<i class="fas fa-photo-video ml-3"></i></a>
              <a href="<?php echo base_url();?>instructor/reviews" class="dropdown-item waves-effect waves-light <?php if($title == 'Reviews'){ echo 'active';}?>">Reviews<i class="fas fa-user-edit ml-3"></i></a>
              <a href="<?php echo base_url();?>instructor/question-and-answer-mastersheet" class="dropdown-item waves-effect waves-light <?php if($title == 'Question & Answer Mastersheet'){ echo 'active';}?>">Question & Answer Mastersheet<i class="fas fa-question ml-3"></i></a>
               <a href="<?php echo base_url();?>" class="dropdown-item waves-effect waves-light">Go to Portal<i class="fas fa-school ml-3"></i></a>
            </div>
          </li>
        </ul>
        <ul class="navbar-nav nav-flex-icons">
          <li class="nav-item">
            <a class="nav-link waves-effect" href="<?php echo base_url();?>instructor/logout">
              <i class="fas fa-sign-out-alt mr-2"></i>Sign Out
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Sidebar -->
  <div class="sidebar-fixed position-fixed">
    <a class="logo-wrapper waves-effect">
      Instructor
      <img src="<?php echo base_url();?>assets/img/<?php echo $settings['logo_img'];?>" class="img-fluid" alt="">
    </a>
    <div class="list-group list-group-flush">
      

      <a href="<?php echo base_url();?>instructor" class="list-group-item list-group-item-action <?php if($title == 'Home'){ echo 'active';}?> waves-effect"><i class="fas fa-chart-pie mr-2"></i>Dashboard</a>
      <a href="<?php echo base_url();?>instructor/order" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Order'){ echo 'active';}?>"><i class="fas fa-receipt mr-2"></i>Orders  <?php if($count > 0){ echo '<span class="badge badge-danger badge-pill">'.$count.'</span>'; } ?></a>
       <a href="<?php echo base_url();?>instructor/announcements" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Announcements'){ echo 'active';}?>"><i class="fas fa-newspaper mr-2"></i> Announcements & Schedules</a>
      <a href="<?php echo base_url();?>instructor/users" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Users'){ echo 'active';}?>"><i class="fas fa-user mr-2"></i>My Students</a>
      <a href="<?php echo base_url();?>instructor/course" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Course'){ echo 'active';}?>"><i class="fas fa-graduation-cap mr-2"></i>Course</a>
      <a href="<?php echo base_url();?>instructor/media" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Media'){ echo 'active';}?>"><i class="fas fa-photo-video mr-2"></i>Media</a>
      <a href="<?php echo base_url();?>instructor/reviews" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Reviews'){ echo 'active';}?>"><i class="fas fa-user-edit mr-2"></i>Reviews</a>
      <a href="<?php echo base_url();?>instructor/question-and-answer-mastersheet" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Question & Answer Mastersheet'){ echo 'active';}?>"><i class="fas fa-question mr-2"></i>Question & Answer Mastersheet</a> 
      <a href="<?php echo base_url();?>" class="list-group-item list-group-item-action waves-effect"><i class="fas fa-school mr-2"></i>Go to Portal</a> 
    </div>
  </div>
</header>