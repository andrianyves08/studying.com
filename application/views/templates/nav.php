<style type="text/css">
  
.dropdown-submenu {
    position: relative;
}

.dropdown-submenu>.dropdown-menu {
    top: 0;
    left: 50%;
    margin-top: -6px;
    margin-left: -1px;
    -webkit-border-radius: 0 6px 6px 6px;
    -moz-border-radius: 0 6px 6px;
    border-radius: 0 6px 6px 6px;
}

.dropdown-submenu:hover>.dropdown-menu {
  display: block;
}

.dropdown-submenu.pull-left {
  float: none;
}

.dropdown-submenu.pull-left>.dropdown-menu {
  right: -100%;
  margin-left: 10px;
  -webkit-border-radius: 6px 0 6px 6px;
  -moz-border-radius: 6px 0 6px 6px;
  border-radius: 6px 0 6px 6px;
}
</style>
<header>
  <nav class="navbar fixed-top navbar-expand-lg navbar-dark scrolling-navbar wow fadeIn">
    <picture>
      <a class="navbar-brand waves-effect" href="<?php echo base_url(); ?>">
        <source media="(min-width: 456px)" srcset="<?php echo base_url();?>assets/img/logo-1.png">
        <source media="(min-width: 256px)" srcset="<?php echo base_url();?>assets/img/logo-1.png">
        <img src="<?php echo base_url();?>assets/img/logo-1.png" class="img-fluid" alt="" style="height: 40px;">
      </a>
    </picture>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fas fa-bars blue-text"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item" id="my_level">
        </li> 
        <?php if($title != 'Home'){ ?>
          <form action="<?=site_url('search');?>" method="get">
            <div class="input-group ml-2 mt-1">
              <input class="form-control form-control-sm" type="text" placeholder="Search" aria-label="Search" name="search">
              <div class="input-group-prepend">
                <button class="btn btn-light btn-sm m-0 px-3 py-2 z-depth-0" type="submit"><i class="fas fa-search"></i></button>
              </div>
            </div>
          </form>
        <?php } ?>
      </ul>
      <picture>
        <img onerror="this.onerror=null;this.src='<?php echo base_url();?>assets/img/users/stock.jpg';" src="<?php echo base_url();?>assets/img/users/<?php echo $my_info['image'];?>" class="img-fluid rounded-circle" alt="" style="height: 40px;">
      </picture>
      <ul class="navbar-nav nav-flex-icons">
        <li class="nav-item">
          <a href="<?php echo base_url(); ?><?php echo $my_info['username']; ?>" class="nav-link waves-effect blue-text">
            <strong><?php echo ucfirst($my_info['first_name']); ?> <?php echo ucfirst($my_info['last_name']); ?></strong>
          </a>
        </li>
        <li class="nav-item dropdown">
           <a class="nav-link dropdown-toggle blue-text" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <strong><i class="fas fa-th"></i></strong>
          </a>
          <div class="dropdown-menu <?php if(!isMobile()) { ?>dropdown-menu-right<?php }?> dropdown-default" aria-labelledby="navbarDropdownMenuLink" id="my_purchases">
            <?php foreach ($my_purchases as $my_purchase) { ?>
              <a class="dropdown-item button_press" href="<?php echo base_url();?>course/<?php echo $my_purchase['slug'];?>" data-id="3"><?php echo $my_purchase['title'];?></a>
            <?php } ?>
          </div>
        </li>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>messages" class="nav-link waves-effect blue-text">
           <strong><i class="fas fa-comment"></i></strong>
            <?php if(count($unseen_chat) > 0){ echo '<span class="badge badge-danger badge-pill">'.count($unseen_chat).'</span>'; } ?>
          </a>
        </li>
        <li class="nav-item avatar dropdown mr-0">
          <div class="dropdown-menu dropdown-menu-lg-right dropdown-secondary notifications" id="notifications" aria-labelledby="seen_notification">
            <?php $i=0; 
            foreach($notifications as $row){ 
              if($row['type'] == 1 || $row['type'] == 2){
                $url = base_url().$row['user_ID'].'/posts/'.$row['id'];
              } elseif($row['type'] == 4) {
                $url = base_url().$row['user_ID'];
              } elseif($row['type'] == 3){
                $url = base_url().'messages';
              } else {
                $url = '';
              }
            ?>
            <div data-url="<?php echo $url; ?>" class="notifier dropdown-item">
               <div class="d-flex">
              <?php if($row['type'] != 5){?>
                <img class="rounded-circle mr-2 card-img-100 chat-mes-id" src="<?php echo base_url();?>assets/img/users/thumbs/<?php echo $row['image'];?>" style="height: 50px; width: 50px" alt="Profile photo" onerror="this.onerror=null;this.src='<?php echo base_url();?>assets/img/users/stock.jpg';">
              <?php } ?>
                <div>
                  <?php echo $row['notification_name'];?><br>
                  <div style="width: 300px;">
                    <?php if(!empty($row['post'])){ echo substr(ucfirst(strip_tags($row['post'])), 0, 40).'...';}?>
                  </div>
                  <span style="font-size: 12px;"><?php echo $row['timestamp'];?></span>
                </div>
              </div>
              
          </div>
            <?php if($row['seen'] == 0){ $i++; } } ?>              
          </div>
          <a class="nav-link dropdown-toggle dropdown-toggle_2 blue-text" id="seen_notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell"></i>
            <?php if($i != 0){ ?>
              <span class="badge badge-danger badge-pill" id="notification_bell"><?php echo $i;?></span>
            <?php } ?>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle waves-effect waves-light blue-text my_info" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><strong></strong>
          </a>
          <ul class="dropdown-menu dropdown-menu-right dropdown-default multi-level" role="menu" aria-labelledby="dropdownMenu" <?php if(!isMobile()) { ?>style="width: 300px;" <?php }?>>
            <a class="dropdown-item waves-effect waves-light" href="<?php echo base_url(); ?><?php echo $my_info['username']; ?>"><picture>
              <img onerror="this.onerror=null;this.src='<?php echo base_url();?>assets/img/users/stock.jpg';" src="<?php echo base_url();?>assets/img/users/<?php echo $my_info['image'];?>" class="img-fluid rounded-circle" alt="" style="height: 30px;"></picture> My Profile</a>
            <?php if($my_info['role'] != '1'){ ?>
              <a class="dropdown-item waves-effect waves-light" href="<?php echo base_url(); ?>become-an-instructor"> Become an Instructor</a>
            <?php } else { ?>
              <a class="dropdown-item waves-effect waves-light" href="<?php echo base_url(); ?>instructor">Instructor Dashboard</a>
            <?php } ?>
           
            <?php if(isMobile()) { ?>
            <a class="dropdown-item waves-effect waves-light" href="<?php echo base_url(); ?>tools">Dropshipping Calculators</a>
            <a class="dropdown-item waves-effect waves-light" href="<?php echo base_url(); ?>dropshipping-dictionary">Dropshipping Dictionary</a>
            <a class="dropdown-item waves-effect waves-light" href="<?php echo base_url(); ?>dropshipping-mastersheet">Dropshipping Mastersheet</a>
            <?php } else { ?>
            <li class="dropdown-submenu">
              <a class="dropdown-item waves-effect waves-light" tabindex="-1">Dropshipping Tools <i class="fas fa-caret-right"></i></a>
              <ul class="dropdown-menu">
                <li class="dropdown-item waves-effect waves-light"><a href="<?php echo base_url(); ?>tools">Calculators</a></li>
                <li class="dropdown-item waves-effect waves-light"><a href="<?php echo base_url(); ?>dropshipping-dictionary">Dictionary</a></li>
                <li class="dropdown-item waves-effect waves-light"><a href="<?php echo base_url(); ?>dropshipping-mastersheet">Question & Answer Mastersheet</a></li>
              </ul>
            </li>
            <?php } ?>
            <a href="<?php echo base_url(); ?>logout" class="dropdown-item waves-effect waves-light" id="user_logout"> Log Out <i class="fas fa-sign-out-alt"></i></a>
            <hr>
            <div class="ml-2">
              <a target="_blank" href="https://www.facebook.com/studyingofficial" class="waves-effect waves-light" id="user_logout">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a target="_blank" href="https://www.instagram.com/studyingofficial">
                <i class="fab fa-instagram"></i>
              </a>
              <a target="_blank" href="https://www.youtube.com/c/AndyMaiYT/videos">
                <i class="fab fa-youtube"></i>
              </a>
            </div>
            <div class="ml-2">
              <a class="waves-effect waves-light" style="font-size: 13px;padding: 0;margin: 0;" href="<?php echo base_url(); ?>about-us">About Us •</a>
              <a class="waves-effect waves-light" style="font-size: 13px;padding: 0;margin: 0;" href="<?php echo base_url(); ?>privacy-policy">Privacy Policy •</a>
              <a class="waves-effect waves-light" style="font-size: 13px;padding: 0;margin: 0;" href="<?php echo base_url(); ?>terms-and-conditions">Terms & Conditions •</a>
              <a class="waves-effect waves-light" style="font-size: 13px;padding: 0;margin: 0;" href="<?php echo base_url(); ?>question-and-answer-mastersheet">FAQs •</a>
              <a class="waves-effect waves-light" style="font-size: 13px;padding: 0;margin: 0;" href="<?php echo base_url(); ?>support">Report Bug / Support •</a>
              <a class="waves-effect waves-light" target="_blank" style="font-size: 13px;padding: 0;margin: 0;" href="https://studying.com">Studying.com © 2021</a>
            </div>

          </ul>
          
        </li>
      </ul>
    </div>
  </nav>
</header>