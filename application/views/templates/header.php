<?php 
  function changetimefromUTC($time, $timezone) {
    $changetime = new DateTime($time, new DateTimeZone('UTC'));
    $changetime->setTimezone(new DateTimeZone($timezone));
    return $changetime->format('M j, Y h:i A');
  }

  function time_elapsed_string($time, $timezone, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($time, new DateTimeZone('UTC'));
    $now->setTimezone(new DateTimeZone($timezone));
    $ago->setTimezone(new DateTimeZone($timezone));
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array(
      'y' => 'year',
      'm' => 'month',
      'w' => 'week',
      'd' => 'day',
      'h' => 'hour',
      'i' => 'minute',
      's' => 'second',
    );

    foreach ($string as $k => &$v) {
      if ($diff->$k) {
        $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
      } else {
        unset($string[$k]);
      }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
  }

  function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?php echo $title; ?></title>
  <link rel="icon" href="<?php echo base_url();?>assets/img/overlays/logo-1.png">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="<?php echo base_url(); ?>assets/css/mdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="<?php echo base_url(); ?>assets/css/style.min.css" rel="stylesheet">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.css">
  <!-- JQuery -->
  <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-3.4.1.min.js"></script>
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/select2/css/select2.min.css">
  <!-- Lazyframe -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/lazyframe.css">
  <!-- Data Tables -->
  <link href="<?php echo base_url('/assets/admin/css/addons/datatables.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('/assets/admin/css/addons/datatables-select.min.css'); ?>" rel="stylesheet">
  <!-- SlickJS -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/slick/slick.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/slick/slick-theme.css">

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-B5WLJ52MBS"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-B5WLJ52MBS', {
      'cookie_prefix': 'MyCookie',
      'cookie_domain': 'app.studying.com',
      'cookie_expires': 28 * 24 * 60 * 60,
      'user_id': '<?php echo $my_info['id'];?>'  // 28 days, in seconds
    });
  </script>

  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/swipebox/src/css/swipebox.css">
  <script src="<?php echo base_url();?>assets/plugins/swipebox/src/js/jquery.swipebox.js"></script>
  
  <script src="https://vjs.zencdn.net/7.11.4/video.min.js"></script>
<!--   <link href="https://vjs.zencdn.net/7.11.4/video-js.css" rel="stylesheet" /> -->
  <link href="https://unpkg.com/video.js@7/dist/video-js.min.css" rel="stylesheet">

  <script src="<?php echo base_url();?>assets/plugins/nanogallery2/dist/jquery.nanogallery2.js"></script>
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/nanogallery2/dist/css/nanogallery2.min.css">

  <script src="<?php echo base_url();?>assets/plugins/ckeditor/ckeditor.js"></script>

  <link href="<?php echo base_url();?>assets/plugins/paginationjs/dist/pagination.css" rel="stylesheet" type="text/css">
  <script src="<?php echo base_url();?>assets/plugins/paginationjs/src/pagination.js"></script>

<style type="text/css">
video::-internal-media-controls-download-button { 
  display:none; 
} 
 
video::-webkit-media-controls-enclosure { 
  overflow:hidden; 
} 
 
video::-webkit-media-controls-panel { 
  width: calc(100% + 30px); /* Adjust as needed */ 
} 

* {
  margin: 0;
  padding: 0;
}
html{
  font-size: 1em !important;
  font-family: Roboto !important;
}

html, body {
  height: 100%;
  width: 100%;
  min-width: 100%;
}
main {
  min-height: 100%;
}

body { 
  background: url("<?php echo base_url();?>assets/img/<?php echo $settings['background_image']; ?>") no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
  z-index: -200;
}

/* Style the video: 100% width and height to cover the entire window */
#myVideo {
  object-fit: cover;
  object-position: center;
  position: fixed;
  height: 100%;
  width: 100%;
  z-index: -100;
}

.navbar{
  background: #fff;
  z-index: 10 !important;
  <?php if($title == 'Home'){?>
    border: none !important;
    box-shadow: none !important;
  <?php } ?>
}
<?php if($title == 'Home'){?>
.navbar:not(.top-nav-collapse) {
  background: transparent;
}
<?php } ?>
.video-overlay {
  position: fixed;
  height: 100%;
  width: 100%;
  background: #fff;
  z-index: -99;
  opacity: .70;
}

#player{
  position:fixed;
  bottom:15px;
  right:15px;
  z-index: 9999;
}

#volume {
  width: 50px;
}

.customsidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.customsidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

#main {
  transition: margin-left .5s;
  padding: 16px;
}

@media screen and (max-height: 450px) {
  .customsidenav {padding-top: 15px;}
  .customsidenav a {font-size: 18px;}
}

.chat-mes-id {
  object-fit: cover;
  object-position: center;
  height: 50px;
  width: 50px;
}

.chat-mes-id-2 {
  object-fit: cover;
  object-position: center;
  height: 100%;
  width: 100%;
}

.banner {
  object-fit: cover;
  object-position: center;
  height: 250px;
  width: 100%;
}

.profile-image {
  object-fit: cover;
  object-position: center;
  width: 100%;
}

.customcolorbg{
  background-color: #459AD4;
}

::-webkit-scrollbar {
  width: 10px;
}

::-webkit-scrollbar-track {
  -webkit-box-shadow: inset 0 0 6px rgba(200,200,200,1);
  border-radius: 10px;
}

::-webkit-scrollbar-thumb {
  border-radius: 10px;
  background-color:#459AD4;
  -webkit-box-shadow: inset 0 0 6px rgba(90,90,90,0.7);
}

.customerheader{
  margin-top: 30px;
  position: absolute;
}

.active-purple input.form-control[type=text] {
  border-bottom: 1px solid #ce93d8;
  box-shadow: 0 1px 0 0 #ce93d8;
}

.slider {
  width: 90%;
  margin: 10px auto;
   <?php if($title == 'Modules'){ ?>
    height: 700px;
  <?php } ?>
}

.slick-slide {
  margin: 0px 20px;
  <?php if($title == 'Modules'){ ?>
    height: 700px;
    overflow-y: auto;
  <?php } ?>
  outline: none;
}

.slick-slide img {
  width: 100%;
/*   height: 500px;
   overflow-y: auto;*/
}

.slick-prev:before,
.slick-next:before {
  color: black;
  background-color: transparent;
}

.slick-current {
  opacity: 1;
}

.flex-1 {
  flex: 1;
}

.custom_slider{
  float: left !important;
}

.border {
  <?php if($title == 'Section'){ echo 'border-width:3px !important;'; }?>
  border-radius: 16px !important;
}

.preloader {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  width: 100%;
  background: #fff;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 9999;
  opacity: 1;
  transform: opacity 1s linear;
}

.preloader.loaded{
  opacity: 0;
  pointer-events: none;
}

.hoverable_2:hover .sections{
  text-decoration: underline;
  background-color: #4E54C6;
}

.sections{
  border-radius: 15px !important;
}

<?php if($title == 'Modules'){?>
.card{
   border-radius: 15px !important;
}
<?php } ?>

.dropdown-toggle_2:after {
  display: none;
}

#dropdown_category {         
  max-height: 500px;
  overflow-y: auto;
}

/*.courses{
  min-height: 100px;
}*/
.click_card{
  outline: none;
}

.rounded{
  border-radius: 15px !important;
}

.lazyframe{
  z-index: -10 !important;
}

.content_progress {
  margin-top: -4px;
  z-index: 999999;
}

.duration{
  margin-top: -30px !important;
  z-index: 999999;
  background-color: #000;
  border-radius: 5px !important;
  padding: 2px !important;
}

p {
  padding: 0 !important;
  margin: 0 !important;
}

.media-body h5 {
    font-weight: 500;
    margin-bottom: 0;
}

.image_textarea{
  display: none;
}

.image_textarea img{
  margin: 10px;
  height: 95px;
  width: 95px;
}

.image_comments{
  height: 150px;
  width: 150px;
  cursor: pointer;
}

.checkboxButton[type="checkbox"] {
  display: none;
}
.checkboxButton[type="checkbox"]:not(:disabled) ~ .checkbox_label {
  cursor: pointer;
}
.checkboxButton[type="checkbox"]:disabled ~ .checkbox_label {
  color: #00C851
  border-color: #00C851
  box-shadow: none;
}

.checkbox_label {
  display: block;
  background: white;
  position: relative;
}

.checkboxButton[type="checkbox"]:checked + .checkbox_label {
  border: 2px solid #1dc973;
}

.notifications{
  max-height: 300px;
  overflow-x: hidden;
  overflow-y: auto;
}

#custom_textarea {
  -moz-appearance: textfield-multiline;
  -webkit-appearance: textarea;
  border: 1px solid gray;
  font: medium -moz-fixed;
  font: -webkit-small-control;
  overflow: auto;
  padding: 10px;
  width: 400px;
  background: #fff !important;
  border-radius: 100px !important;
  outline: none;
  font-size: 16px;
}

.click_emoji{
  font-size: 18px;
}

body.modal-open {
  overflow: hidden;
}

p{
  padding: 0 !important;
  margin: 0 !important;
}
</style>
<body>
<div class="preloader">
  <picture>
    <a>
      <img src="<?php echo base_url();?>assets/img/logo-1.png" class="img-fluid wow slideOutUp" alt="" style="height: 300px;">
    </a>
  </picture>
</div>
<script type="text/javascript">
$(document).ready(function() {
  var offset = new Date().getTimezoneOffset(), o = Math.abs(offset);
  var timezone = (offset < 0 ? "+" : "-") + ("00" + Math.floor(o / 60)).slice(-2) + ":" + ("00" + (o % 60)).slice(-2);
  $.ajax({
    type: "post",
    url:"<?=base_url()?>pages/timezone",
    data:{timezone:timezone},
    success: function(){
    }
  });
});
</script>
<script type = "text/javascript">
  var base_url = '<?php echo base_url() ?>';
</script>
<div class="video-overlay"></div>
<?php if($title == 'Home'){ ?>
<audio autoplay loop <?php if(!empty($music)){ echo 'muted';} ?> class="active" id="audioDemo"><source src="<?php echo base_url();?>assets/img/<?php echo $settings['music'];?>" type="audio/mp3"></audio>
<a class="fas <?php if(!empty($music)){ echo 'fa-volume-off';} else { echo 'fa-volume-up';}?> fa-lg" id="player"></a>

<script type="text/javascript">
  var x = <?php if(!empty($music)){ echo 'true';} else { echo 'false';} ?>;
  $("#player").click(function() {
    if(x){
      $("#audioDemo").trigger('play');
      $("#audioDemo").prop('muted', false);
      $(this).removeClass("fa-volume-off").addClass("fa-volume-up");
      paused(0);
      x = false;
    } else {
      $("#audioDemo").trigger('pause');
      $(this).removeClass("fa-volume-up").addClass("fa-volume-off");
      paused(1);
      x = true;
    }
  });
  function paused(number){
    $.ajax({
      type  : 'POST',
      url   : '<?php echo site_url('pages/music')?>',
      dataType : 'json',
      data : {id:number},
      success : function(data){
      }
    });
  }
</script>
<?php } ?>
<script type="text/javascript">
function nanogallery(id, images) {
  $("#nanogallery_"+id).nanogallery2({
    items: images,
    galleryMaxRows: 2,
    galleryDisplayMode: 'rows',
    thumbnailAlignment: 'center',
    thumbnailHeight: '300', thumbnailWidth: '300',
    thumbnailBorderHorizontal: 0, thumbnailBorderVertical: 0,
    thumbnailLabel: { display: false },
    position: 'onBottom',
    // LIGHTBOX
    viewerToolbar: { display: false },
    viewerTools:    {
      topLeft:   'label',
      topRight:  'rotateLeft, rotateRight, fullscreenButton, closeButton'
    },
    // GALLERY THEME
    galleryTheme : { 
      thumbnail: { background: '#111' },
    },
  });
}
</script>