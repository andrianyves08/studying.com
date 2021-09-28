<?php 
  $CI =& get_instance();
  $CI->load->model('course_model');
  $CI->load->model('review_model');
  function renderStarRating($rating,$maxRating=5) {
    $fullStar = "<i class='fas fa-star amber-text'></i>";
    $halfStar = "<i class='fas fa-star-half-alt amber-text'></i>";
    $emptyStar = "<i class='far fa-star amber-text'></i>";
    $rating = $rating <= $maxRating?$rating:$maxRating;

    $fullStarCount = (int)$rating;
    $halfStarCount = ceil($rating)-$fullStarCount;
    $emptyStarCount = $maxRating -$fullStarCount-$halfStarCount;

    $html = str_repeat($fullStar,$fullStarCount);
    $html .= str_repeat($halfStar,$halfStarCount);
    $html .= str_repeat($emptyStar,$emptyStarCount);
    $html = $html;
    return $html;
  }
?>
<script type="text/javascript">
CKEDITOR.config.readOnly = true;
CKEDITOR.config.removeButtons = 'Copy';
function create_ckeditor(element){
  CKEDITOR.replace(element, {
    toolbar: [],
    height: 500
  });
}
</script>
<main class="pt-5 mx-lg-5">
<!-- <main class="pt-5 mx-lg-5" oncontextmenu="return false;"> -->
<div class="container-fluid mt-5">
  <h3 class="mb-4 pt-4 text-center" id="main_header">
    <span class="dropdown">
      <a class="dropdown-toggle text-wrap blue-text" data-toggle="dropdown" id="course_drop" aria-haspopup="true" aria-expanded="false">
        <strong><?php echo ucwords($module['title']);?></strong>
      </a>
      <div class="dropdown-menu" id="course_dropdown" aria-labelledby="course_drop">
        <?php foreach ($modules as $value) { 
          if($value['status'] == '1'){
        ?>
          <?php if ($value['title'] == $module['title']) { ?>
            <a class="dropdown-item waves-effect waves-light blue-text" href="<?php echo base_url().'course/'.$course['slug'].'/'.$value['slug'];?>/"><?php echo $value['title']; ?></a>
          <?php } else { ?>
            <a class="dropdown-item waves-effect waves-light" href="<?php echo base_url().'course/'.$course['slug'].'/'.$value['slug'];?>"><?php echo $value['title']; ?></a>
          <?php } ?>
        <?php } } ?> 
      </div>
    </span>
    <span>/</span>
    <span class="dropdown">
      <a class="dropdown-toggle text-wrap blue-text" data-toggle="dropdown" id="section_drop" aria-haspopup="true" aria-expanded="false">
        <strong><?php echo ucwords($section['title']);?></strong>
      </a>
      <div class="dropdown-menu" aria-labelledby="section_drop">
        <?php foreach ($sections as $value) { 
          if($value['status'] == '1'){
        ?>
          <?php if ($value['title'] == $section['title']) { ?>
            <a class="dropdown-item waves-effect waves-light blue-text" href="<?php echo base_url().'course/'.$course['slug'].'/'.$module['slug'].'/'.$value['slug'];?>"><?php echo $value['title']; ?></a>
          <?php } else { ?>
            <a class="dropdown-item waves-effect waves-light" href="<?php echo base_url().'course/'.$course['slug'].'/'.$module['slug'].'/'.$value['slug'];?>"><?php echo $value['title']; ?></a>
          <?php } ?>
        <?php } } ?> 
      </div>
    </span>
    <span>/</span>
    <span><a class="blue-text" href="<?php echo base_url().'course/'.$course['slug'];?>">Back</a></span>
  </h3>
  <div class="row justify-content-center">
    <div class="col-md-8 mb-4">
      <?php $count=1; foreach ($lessons as $lesson){
        if ($lesson['status'] == '1') { ?>
        <?php $i = 1; foreach ($contents as $content){ ?>
          <?php if ($lesson['id'] == $content['lesson_ID'] && $content['status'] == '1'){ ?>
            <?php
              if (strpos($content['url'], 'vimeo') !== false) {
                $player = 'vimeo';
              } elseif(strpos($content['url'], 'youtube') !== false){
                $player = 'youtube';
              } else {
                $player = 'html';
              }
            ?>
            <div class="mb-4 content-pane content_id<?php echo $content['id'];?> current_row_<?php echo $count;?>" style="display:none;" <?php if($beginner == FALSE){ ?> data-src="<?php echo $content['url'];?>" data-video="<?php echo $player;?>" data-id="<?php echo $content['id'];?>" <?php } ?>>
              <p class="h5 mb-2 text-center"><?php echo ucfirst($lesson['title']);?></p>
                <?php if (!empty($content['url'])) {?>
                  <?php if ($player == 'vimeo') {?>
                    <div class="embed-responsive embed-responsive-16by9">
                      <div class="embed-responsive-item" id="video_id_<?php echo $content['id']; ?>"></div>
                    </div>
                  <?php } elseif ($player == 'youtube') { ?>
                    <div class="embed-responsive embed-responsive-16by9">
                      <iframe class="embed-responsive-item" id="video_id_<?php echo $content['id']; ?>" autoplay></iframe>
                    </div>
                  <?php } else { ?>
                    <div class="embed-responsive embed-responsive-16by9">
                    <video id="video_id_<?php echo $content['id']; ?>" class="video-js embed-responsive-item" oncontextmenu="return false;"></video>
                    </div>
                  <?php } ?>
                <?php } ?> 
              <p class="mb-4 font-italic text-center" style="font-size: 16px;"><?php echo $i.') '.ucfirst($content['title']);?></p>
              <div class="input-group justify-content-center mb-4">
                <div class="input-group-prepend">
                  <a class="btn btn-sm btn-indigo m-0 prev_content" data-current-row="<?php echo $count;?>"><i class="fas fa-angle-double-left"></i> Prev</a>
                  <a class="btn btn-sm btn-indigo m-0 next_content" data-current-row="<?php echo $count;?>">Next <i class="fas fa-angle-double-right"></i></a>
                </div>
              </div><!--Input Group-->
              <div class="contents">
              <?php if(!empty($content['content'])){ ?>
                <textarea class="textarea" name="edit_content_<?php echo $content['id']?>" id="edit_content_<?php echo $content['id']; ?>"></textarea>
                <?php 
                $data = json_encode($content['content'])?>
                <script type="text/javascript">
                  $(document).ready(function() {
                    create_ckeditor('edit_content_<?php echo $content['id']; ?>');
                    CKEDITOR.instances['edit_content_<?php echo $content['id']; ?>'].setData(<?php echo $data; ?>);
                  });
                </script>
              <?php } ?>
                <?php 
                if(!empty($content['file'])){
                  $files = explode(',', $content['file']);
                  foreach ($files as $key => $value) {
                    $path = explode("/", $value); // splitting the path
                    $last = end($path);
                    echo '<a href="'.$value.'" download="'.urldecode(basename($value)).'" class="btn btn-success btn-sm"><i class="fas fa-file-download"></i> Download '.urldecode(basename($value)).'</a>';
                  }
                }
              ?>
              </div>
              <?php if (!empty($content['url']) && $beginner == FALSE){ ?>
                <?php $rating = $CI->review_model->get_review(4, NULL, NULL, $content['id'], $my_info['id']);
                if(!$rating){ ?>
               <!--  <div class="mt-4 text-center" id="add_rating_<?php echo $content['id'];?>">
                  <h5>Rate the video</h5>
                  <span id="rateMe_<?php echo $content['id'];?>" class="mb-4"></span>
                  <input type="hidden" id="feedback_rating_<?php echo $content['id'];?>">
                  <div class="form-group">
                    <textarea class="form-control rounded-0" id="feedback_<?php echo $content['id'];?>" id="feedback" rows="2" placeholder="Write your review"></textarea>
                  </div>
                  <script type="text/javascript">
                  $(document).ready(function() {
                    $('#rateMe_<?php echo $content['id'];?>').mdbRate();
                    $('#rateMe_<?php echo $content['id'];?>').hover(function() {
                      var count = $('#rateMe_<?php echo $content['id'];?> .amber-text').length;
                      $('#feedback_rating_<?php echo $content['id'];?>').val(count);
                    });
                  });
                  </script>
                  <a class="btn btn-secondary btn-md view_content_review" data-id="<?php echo $content['id'];?>">View Reviews</a>
                  <button type="button" class="btn btn-primary btn-md submit_rating" data-id="<?php echo $content['id'];?>">Submit Review</button>
                </div> -->
              <?php } else { ?>
                <!--  <a class="btn btn-secondary btn-md view_content_review" data-id="<?php echo $content['id'];?>">View Reviews</a> -->
              <?php } }?>
              <?php if (!empty($content['url']) && $beginner == TRUE){ ?>
                <a class="btn btn-primary btn-md" href="<?php echo base_url(); ?>course/checkout/<?php echo $course['slug']?>">Buy Course</a>
                <!-- <a class="btn btn-secondary btn-md view_content_review" data-id="<?php echo $content['id'];?>">View Video Reviews</a> -->
              <?php } ?>

            </div><!--Card-->
          <?php $i++; $count++;} ?>
        <?php } ?>
      <?php } } ?>
      <div class="myList">
      <?php $count=1; foreach ($lessons as $lesson){
          if ($lesson['status'] == '1'){
        ?>
        <h4 class="indigo-text h-1">
          <strong><?php echo ucfirst($lesson['title']);?></strong>
        </h4>
        <div id="section<?php echo $lesson['id'];?>">
          <div id="lesson<?php echo $lesson['id'];?>" class="myList-3">
            <div class="row mb-1">
              <section class="center slider">
                <?php $c=1; foreach ($contents as $content) {?>
                  <?php if ($lesson['id'] == $content['lesson_ID'] && $content['status'] == '1') {
                    $avg = $CI->review_model->get_rating(4, $content['id']);
                    ?>
                    <?php
                      if (strpos($content['url'], 'vimeo') !== false) {
                        $player = 'vimeo';
                      } elseif(strpos($content['url'], 'youtube') !== false){
                        $player = 'youtube';
                      } else {
                        $player = 'html';
                      }
                    ?>
                  <div class="h-3">
                    <div>
                      <?php if (!empty($content['url'])) { ?>
                      <a class="content_nav blue-text card-title" data-current-row="<?php echo $count;?>">
                        <div class="text-center text_content text_content_<?php echo $count;?> text_content_id_<?php echo $content['id'];?>">
                          <div class="view">
                            <div class="embed-responsive embed-responsive-16by9" style="cursor: pointer;">
                              <?php if($beginner == FALSE){ ?>
                                <img class="lazyframe embed-responsive-item rounded" data-src="<?php echo $content['url']; ?>" <?php if($player != 'html'){ ?> data-vendor="<?php echo $player; ?>" <?php } ?> <?php if(!empty($content['thumbnail'])){ ?> data-thumbnail="<?php echo $content['thumbnail']; ?>" <?php } ?>></img> 
                              <?php } else { ?>
                                 <img class="lazyframe embed-responsive-item rounded" data-src="http://localhost/studying_v2.0/assets/img/MOVIE INTRO.mp4" data-thumbnail="<?php echo $course['image']; ?>"></img> 
                              <?php } ?>
                            </div>
                          </div>
                          <div class="content_progress progress md-progress ml-2 mr-2 progress_<?php echo $content['id'];?>" style="height: 4px;">
                          </div>
                          <p class="duration float-right mr-2 text-white p-0 duration_<?php echo $content['id'];?>" style="font-size: 12px;"></p>
                          <div class="flex-1">
                            <h6 class="m-2 text-left"><span class="green-text watched_<?php echo $content['id'];?> mr-1">
                            </span><strong><?php echo ucfirst($content['title']);?></strong></h6>     
                          </div>
                          <!-- <span id="content_rating_<?php echo $content['id'];?>">
                          <?php 
                          if(!empty($avg['avg'])){
                            echo renderStarRating($avg['avg']);
                          } ?>
                          </span> -->
                        </div>
                      </a>
                      <?php } else { ?>
                      <a style="cursor: pointer;" class="content_nav blue-text card-title" data-current-row="<?php echo $count;?>">
                        <div class="rounded card text-center text_content text_content_<?php echo $count;?> text_content_id_<?php echo $content['id'];?>">
                          <div class="card-body py-5 px-5 my-5">
                            <h6 class=""><?php echo ucfirst($content['title']);?></h6>
                          </div>
                        </div>
                      </a>
                      <?php } ?>
                    </div><!--slider-->
                  </div><!--h-3-->
                  <?php $c++; $count++;} ?>
                <?php } ?>
              </section>
            </div><!--Row-->
          </div><!--Lesson ID-->
        </div><!-- Section ID-->
      <?php } } ?>
      </div><!--My List-->
    </div><!--Column-->
  </div><!--Row-->
  <?php if ($beginner == TRUE){ ?>
  <div class="row justify-content-center">
    <div class="col-md-3 mb-4">
      <a class="btn btn-primary btn-md" href="<?php echo base_url(); ?>course/checkout/<?php echo $course['slug']?>">Buy Course</a>
      <a class="btn btn-secondary btn-md">View Course Reviews</a>
    </div>
  </div>
  <?php } ?>
</div><!--Container-->
</main><!--Main layout-->
<div data-backdrop="static" class="modal fade" id="content_review_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-notify modal-secondary" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Reviews</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="content_reviews" style="height: 50vh;overflow-y: auto;">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Copy Content -->

<script src="<?php echo base_url();?>assets/plugins/player/player.js"></script>
<script type="text/javascript">
$(document).ready(function() {

  $(".contents img").addClass("img-fluid");
  var slug = '<?php echo $course['slug']; ?>';
  var course_slug = '<?php echo $module['slug']; ?>';
  var section_slug = '<?php echo $section['slug']; ?>';
  watched();

  //Get Section to update
  $(document).on('click','.view_content_review',function(e) {
    var content_ID=$(this).data('id');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>review/get_content_review",
      dataType : "JSON",
      data : {content_ID:content_ID},
      success: function(data){
        $('#content_review_modal').modal('show');
         $('#content_reviews').html(data);
      }
    });
  });

  $(document).on('click', '.submit_rating', function(){
    var content_ID = $(this).data('id');
    var rating = $('#feedback_rating_'+content_ID).val();
    var comment = $('#feedback_'+content_ID).val();
    if(rating != ''){
      $.ajax({
        url:"<?=base_url()?>review/submit_content_review",
        method:"POST",
        async : true,
        dataType : 'json',
        data:{content_ID:content_ID, rating:rating, comment:comment},
        success:function(data) {
          toastr.success('Review submitted');
          $('#add_rating_'+content_ID).remove();
        }
      })
    } else {
     toastr.error('Add rating');
    }
  });

  if(window.location.hash != ''){ 
    var hash = document.URL.substr(document.URL.indexOf('#')+1);
    $('.content_id'+hash).show(); 
    $('.text_content_id_'+hash).addClass('border border-primary rounded-lg'); 
    if($('.content_id'+hash).data('src')){
      var src = $('.content_id'+hash).data('src');
      var content = $('.content_id'+hash).data('id');
      var video = $('.content_id'+hash).data('video');
      createvideo(video, src, content);
    } 
    if(hash.substring(0,6) == 'lesson'){
      var lesson = hash.substring(7);
      $('html, body').animate({
        scrollTop: $('#lesson'+lesson).offset().top
      }, 'slow');
    }
  }

<?php if($beginner == FALSE){ ?>
  function createvideo(video_type, src, content, next_row){
    if(video_type == 'vimeo'){
      var options = {
        url: src,
        width: 640,
        height: 480,
        autoplay: true,
      };
      var player = new Vimeo.Player('video_id_'+content, options);
      let playing = true;

      get_progress(function(output){
        player.setCurrentTime(Math.round(output));
      });

      player.ready().then(function() {
      }).catch(function(error) {
        switch (error.name) {
          case 'TypeError':
            toastr.error('The id was not a number.');
            break;
          case 'PasswordError':
            toastr.error('The video is password-protected');
            break;
          case 'PrivacyError':
            toastr.error('The video is password-protected');
            break;
          default:
            toastr.error('Some error occurred. Please refresh page or contact Support.');
            break;
        }
      });

      player.on('play', function(){
        player.off('play');
        player.on('timeupdate', progress);
        player.on('ended', finished);
      });

      function progress(data) {
        var duration = data.duration;
        var progress = data.seconds;
        onPlayProgress(progress, duration);
      }

      // Disallow skipping/forwarding
      function simulationTime(simulationTime) {
        player.on('seeked', function(e) {
          if (e.seconds > simulationTime) {
              player.setCurrentTime(simulationTime).then(function(seconds) {
               }).catch(function(error) {
                switch (error.name) {
                  case 'RangeError':
                    break;
                  default:
                    break;
                }
              });
          } else {
            simulationTime = data.seconds;
          }
        });
        window.setInterval(function() {
          if (playing) {
            simulationTime++;
          }
        }, 1000);
      }

    } else if (video_type == 'html') {
      var player = videojs('video_id_'+content, {
        controls: true,
        width: 640,
        height: 480,
        autoplay: true,
        playbackRates: [0.5, 1, 1.5, 2]
      });
      player.src({type: 'video/mp4', src: src});

      get_progress(function(output){
        player.currentTime(Math.round(output));
      });

      player.on('play', function(){
        player.off('play');
        player.on('ended', finished);
      });

      player.on('timeupdate', function () {
        var progress = player.currentTime();
        var duration = player.duration();
        onPlayProgress(progress, duration);
      });

      // Disallow skipping/forwarding
      function simulationTime(currentTime) {
        player.on("seeking", function(e) {
          if (player.currentTime() > currentTime) {
            player.currentTime(currentTime);
          } else {
            player.currentTime();
          }
        });
          window.setInterval(function() {
          if (!player.paused()) {
            currentTime++;
          }
        }, 1000);
      }
    } else {
      $('#video_id_'+content).attr('src', src);
    }

    function onPlayProgress(progress, duration) {
      $.ajax({
        type : "POST",
        url  : base_url +"video/track_progress",
        dataType : "JSON",
        data : {duration:duration, progress:progress, src:src, content:content},
        success: function(data){
        }
      });
    }

    function get_progress(handle_data) {
      $.ajax({
        type : "POST",
        url  : base_url +"video/get_progress",
        dataType : "JSON",
        data : {content_ID:content, src:src},
        success: function(data){
          if(!data.error){
            handle_data(data.progress);
            if(data.status == 0){
              simulationTime(data.progress);
            }
          } else {
            handle_data(0);
            simulationTime(0);
          }
        }
      });
    }

    function finished() {
      $.ajax({
        type : "POST",
        url  : base_url +"video/finished_watched",
        dataType : "JSON",
        data : {content:content},
        success: function(data){
          if(data.status == true){
            toastr.info('Next video will play in 2 seconds.');
            setTimeout(function() {
              toastr.info('Next video will play in 1 second.');
            }, 2000);
            toastr.success(data.exp+' Exp Gained!');
            level_up.play();
            var html = '';
            html += '<i class="fas fa-check-circle"></i>';
            $('.watched_'+content).html(html);
            setTimeout(function() {
              get_video(next_row);
              goto(next_row);
            }, 2000);
          } 
        }
      });
    }

    // Pause video when browser leave
    document.addEventListener("visibilitychange", function() {
      if (document.hidden){
        player.pause();
      }
    });
  }
  <?php } else { ?>
  function createvideo(src, content, next_row){
    alert_sound.play();
    alert('Your account is restricted. Please contact support@studying.com');
  }
  <?php } ?>
  function watched() {
    $.ajax({
      type : "POST",
      url  : base_url +"video/get_all_progress",
      dataType : "JSON",
      success: function(data){
        for(i=0; i<data.length; i++){
          var html2 = '';
          if(data[i].status == 1){
            var percentage = 100;
            var html = '';
            html += '<i class="fas fa-check-circle"></i>';
            $('.watched_'+data[i].content_ID).html(html);
          } else {
            var percentage = Math.round(((data[i].progress / data[i].duration) * 100)); 
          }
          html2 += '<div class="progress-bar bg-success" role="progressbar" style="width: '+percentage+'%; height: 20px" aria-valuenow="'+data[i].progress+'" aria-valuemin="0" aria-valuemax="'+data[i].duration+'"></div>';
          $('.progress_'+data[i].content_ID).html(html2);
        }
      }
    });
    $.ajax({
      type : "POST",
      url  : base_url +"video/all_videos",
      dataType : "JSON",
      success: function(data){
        for(i=0; i<data.length; i++){
          $('.duration_'+data[i].content_ID).text(secondsTimeSpanToHMS(Math.round(data[i].duration)));
        }
      }
    });
  }

  function secondsTimeSpanToHMS(s) {
    var h = Math.floor(s/3600);
    s -= h*3600;
    var m = Math.floor(s/60);
    s -= m*60;
    return h+":"+(m < 10 ? '0'+m : m)+":"+(s < 10 ? '0'+s : s);
  }

  $('.content_nav').on('click', function() {
    var current_row = $(this).data('current-row');
    var video = $(this).data('video');
    var src = $(this).data('src');
    var next_row = current_row+1;
    var content = $(this).data('id');
    goto(current_row);
  }); 

  $('.next_content').on('click', function() {
    var current_row = $(this).data('current-row');
    var next_row = current_row+1;
    goto(next_row);
  }); 

  $('.prev_content').on('click', function() {
    var current_row = $(this).data('current-row');
    var prev_row = current_row-1;
    goto(prev_row);
  }); 

  function goto(current){
    $('.text_content_'+current).addClass('border border-primary rounded-lg');
    $('.text_content').not(".text_content_"+current).removeClass('border border-primary rounded-lg'); 
    $('.current_row_'+current).show(); 
    $('.content-pane').not(".current_row_"+current).hide(); 
    if(!$('.current_row_'+current).length){
      next_module();
    }
    $('html, body').animate({
      scrollTop: $('#main_header').offset().top
    }, 1000);
    var video = $('.current_row_'+current).data('video'); 
    get_video(current);
  }

  function get_video(video_row){
    var src = $('.current_row_'+video_row).data('src');
    var content = $('.current_row_'+video_row).data('id');
    var video = $('.current_row_'+video_row).data('video');
    createvideo(video, src, content, video_row);
  }

  function next_module(){
    var course_ID = '<?php echo $course['course_ID']; ?>';
    var section_ID = '<?php echo $section['id']; ?>';
    $.ajax({
      type : "POST",
      url  : base_url +"users/next",
      dataType : "JSON",
      data : {course_ID:course_ID, section_ID:section_ID},
      success: function(data){
        window.location.replace("<?php echo base_url(); ?>course/"+slug+"/"+data.course_slug+"/"+data.section_slug+"");
      }
    });
  }
});
</script>
<script type="text/javascript">
$(document).ready(function(){
  $('.center').slick({
    infinite: false,
    slidesToShow: 3,
    slidesToScroll: 3,
    responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
        infinite: false,
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    }
  ]
  });
});
</script>