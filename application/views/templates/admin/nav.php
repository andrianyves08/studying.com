<?php 
  $CI =& get_instance();
  $CI->load->model('user_model');

  $new_request = $CI->user_model->get_request_as_instructor('0');
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
              <a href="<?php echo base_url();?>admin" class="dropdown-item waves-effect waves-light <?php if($title == 'Home'){ echo 'active';}?> waves-effect"><i class="fas fa-chart-pie mr-2"></i>Dashboard</a>
              <a href="<?php echo base_url();?>admin/support" class="dropdown-item waves-effect waves-light <?php if($title == 'Support'){ echo 'active';}?>"><i class="fas fa-comment mr-2"></i>Messages <span id="new_messages"></span></a>
              <?php

              // 1 = admin
              // 2 = superadmin
              // 3 = blogger
              if($admin_status == '2'){?>
                <a href="<?php echo base_url();?>admin/order" class="dropdown-item waves-effect waves-light <?php if($title == 'Order'){ echo 'active';}?>"><i class="fas fa-bars mr-2"></i>Orders</a>
                <a href="<?php echo base_url();?>admin/category" class="dropdown-item waves-effect waves-light <?php if($title == 'Category'){ echo 'active';}?>"><i class="fas fa-bars mr-2"></i>Category</a>
                <a href="<?php echo base_url();?>admin/course" class="dropdown-item waves-effect waves-light <?php if($title == 'Course'){ echo 'active';}?>"><i class="fas fa-graduation-cap mr-2"></i>Course</a>
                <a href="<?php echo base_url();?>admin/admins" class="dropdown-item waves-effect waves-light <?php if($title == 'Admins'){ echo 'active';}?>"><i class="fas fa-user-cog mr-2"></i>Admins</a>
                <a href="<?php echo base_url();?>admin/admins" class="dropdown-item waves-effect waves-light <?php if($title == 'Instructors'){ echo 'active';}?>"><i class="fas fa-chalkboard-teacher mr-2"></i>Instructors  <?php if(count($new_request) > 0){ echo '<span class="badge badge-danger badge-pill">'.count($new_request).'</span>'; } ?></a>
              <?php } ?>
              <a href="<?php echo base_url();?>admin/users" class="dropdown-item waves-effect waves-light <?php if($title == 'Users'){ echo 'active';}?>"><i class="fas fa-user mr-3"></i>All Users</a>
              <a href="<?php echo base_url();?>admin/media" class="dropdown-item waves-effect waves-light <?php if($title == 'Media'){ echo 'active';}?>"><i class="fas fa-photo-video mr-2"></i>Media</a>
              <a href="<?php echo base_url();?>admin/posts" class="dropdown-item waves-effect waves-light <?php if($title == 'Posts'){ echo 'active';}?>"><i class="fas fa-newspaper mr-2"></i>Posts <span id="review_post"></span></a>
              <a href="<?php echo base_url();?>admin/blogs" class="dropdown-item waves-effect waves-light <?php if($title == 'Blogs'){ echo 'active';}?>"><i class="fas fa-blog mr-2"></i>Blogs</a>
              <a href="<?php echo base_url();?>admin/reviews" class="dropdown-item waves-effect waves-light <?php if($title == 'Reviews'){ echo 'active';}?>"><i class="fas fa-star mr-2"></i>Reviews</a>
              <a href="<?php echo base_url();?>admin/studying-review" class="dropdown-item waves-effect waves-light <?php if($title == 'Studying'){ echo 'active';}?>"><i class="fas fa-user-edit mr-2"></i>Studying Reviews</a>
              <a href="<?php echo base_url();?>admin/question-and-answer-mastersheet" class="dropdown-item waves-effect waves-light <?php if($title == 'Question & Answer Mastersheet'){ echo 'active';}?>"><i class="fas fa-question mr-2"></i>Question & Answer Mastershee</a>
              <a href="<?php echo base_url();?>admin/rated-products" class="dropdown-item waves-effect waves-light <?php if($title == 'Rated Products'){ echo 'active';}?>"><i class="fas fa-search-dollar mr-2"></i>Rated Products</span></a>
              <a href="<?php echo base_url();?>admin/settings" class="dropdown-item waves-effect waves-light <?php if($title == 'Settings'){ echo 'active';}?>"><i class="fas fa-cog mr-2"></i>Settings</a>
            </div>
          </li>
        </ul>
        <ul class="navbar-nav nav-flex-icons">
          <li class="nav-item">
            <a class="nav-link waves-effect" href="<?php echo base_url();?>admin/logout">
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
      <img src="<?php echo base_url();?>assets/img/<?php echo $settings['logo_img'];?>" class="img-fluid" alt="">
    </a>
    <div class="list-group list-group-flush">
      <a href="<?php echo base_url();?>admin" class="list-group-item list-group-item-action <?php if($title == 'Home'){ echo 'active';}?> waves-effect"><i class="fas fa-chart-pie mr-2"></i>Dashboard</a>
      <?php
      // 1 = admin
      // 2 = superadmin
      // 3 = blogger
      if($admin_status == '2'){ ?>
        <a href="<?php echo base_url();?>admin/order" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Order'){ echo 'active';}?>"><i class="fas fa-receipt mr-2"></i>Orders</a>
        <a href="<?php echo base_url();?>admin/category" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Category'){ echo 'active';}?>"><i class="fas fa-bars mr-2"></i>Category</a>
        <a href="<?php echo base_url();?>admin/course" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Course'){ echo 'active';}?>"><i class="fas fa-graduation-cap mr-2"></i>Course</a>
        <a href="<?php echo base_url();?>admin/admins" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Admins'){ echo 'active';}?>"><i class="fas fa-user-cog mr-2"></i>Admins</a>
        <a href="<?php echo base_url();?>admin/instructors" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Instructors'){ echo 'active';}?>"><i class="fas fa-chalkboard-teacher mr-2"></i>Instructors <?php if(count($new_request) > 0){ echo '<span class="badge badge-danger badge-pill">'.count($new_request).'</span>'; } ?></a>
      <?php } ?>
      <a href="<?php echo base_url();?>admin/users" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Users'){ echo 'active';}?>"><i class="fas fa-user mr-2"></i>All Users</a>
      <a href="<?php echo base_url();?>admin/support" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Support'){ echo 'active';}?>"><i class="fas fa-comment mr-2"></i>Messages <span id="new_messages"></span></a>
      <a href="<?php echo base_url();?>admin/media" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Media'){ echo 'active';}?>"><i class="fas fa-photo-video mr-2"></i>Media</a>
      <a href="<?php echo base_url(); ?>admin/posts" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Posts'){ echo 'active';}?>"><i class="fas fa-newspaper mr-2"></i>Posts <span id="review_post"></span></a>
      <a href="<?php echo base_url(); ?>admin/blogs" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Blogs'){ echo 'active';}?>"><i class="fas fa-blog mr-2"></i>Blogs</a>
      <a href="<?php echo base_url(); ?>admin/reviews" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Reviews'){ echo 'active';}?>"><i class="fas fa-star mr-2"></i>Reviews</a>
      <a href="<?php echo base_url(); ?>admin/studying-review" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Studying'){ echo 'active';}?>"><i class="fas fa-smile mr-2"></i>Studying Reviews</a>
      <a href="<?php echo base_url(); ?>admin/question-and-answer-mastersheet" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Question & Answer Mastersheet'){ echo 'active'; } ?>"><i class="fas fa-question mr-2"></i> Question & Answer Mastersheet</a>
      <a href="<?php echo base_url(); ?>admin/rated-products" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Rated Products'){ echo 'active';} ?>"><i class="fas fa-search-dollar mr-2"></i>Rated Products</span></a>
      <a href="<?php echo base_url(); ?>admin/settings" class="list-group-item list-group-item-action waves-effect <?php if($title == 'Settings'){ echo 'active';}?>"><i class="fas fa-cog mr-2"></i>Settings</a>
    </div>
  </div>
</header>