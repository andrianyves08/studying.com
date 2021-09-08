<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="row mt-3 pt-3">
    <section class="center slider py-2">
      <?php foreach ($modules as $module) {?>
        <?php if ($module['status'] == '1') {?>
        <div>
          <div class="courses mb-2" data-id="<?php echo $module['id']; ?>" data-slug="<?php echo $module['slug']; ?>" <?php if( strlen($module['title']) > 34){ echo 'data-toggle="tooltip"';}?> title="<?php echo ucwords($module['title']); ?>"><h2 class="mb-3 text-center text-dark text-truncate"><?php echo ucwords($module['title']); ?></h2></div>
          <div id="course_progress<?php echo $module['id']; ?>">
          </div>
          <?php foreach ($sections as $section) {?>
            <?php if ($section['module_ID'] == $module['id'] && $section['status'] == '1') {?>
              <a href="<?php base_url(); ?><?php echo $slug;?>/<?php echo $module['slug'];?>/<?php echo $section['slug'];?>" class="click_card">
                <div class="border card mb-2 hoverable_2 mr-3" <?php if(strlen($section['title']) > 44){ echo 'data-toggle="tooltip"';}?> data-placement="top" title="<?php echo ucwords($section['title']); ?>">
                  <div class="card-header customcolorbg sections text-white m-0" data-id="<?php echo $section['id']; ?>" data-slug="<?php echo $module['slug']; ?>" data-section-slug="<?php echo $section['slug']; ?>"><h5 class="text-truncate"><span id="section_<?php echo $section['id']; ?>" class="float-left mr-2"></span><?php echo ucwords($section['title']) ?></h5></div>
                </div>
              </a>
            <?php } ?>
          <?php } ?>
        </div>
        <?php } ?>
      <?php } ?>
    </section>
    </div>
  </div><!--Row-->
</div><!--Container-->
</main>
<script type="text/javascript">
$(document).ready(function(){
  var course_slug = '<?php echo $slug; ?>';
  last_watched(course_slug);
  function last_watched(course_slug){
    $.ajax({
      type  : 'POST',
      url   : "<?=base_url()?>video/get_module_progress",
      dataType : 'json',
      data : {course_slug:course_slug},
      success : function(data){
        for(i=0; i<data.length; i++){
          var html = '';
          html += '<div class="form-inline mb-2"><strong class="text-dark mr-2">Module Progress </strong><div class="progress" style="width: 100px; height: 20px;"><div class="progress-bar bg-success text-dark" role="progressbar" style="width: '+data[i].percentage_width+'%;" aria-valuemin="0" aria-valuemax="'+data[i].total+'">'+data[i].percentage+' % </div></div></div>';
          $('#course_progress'+data[i].module_ID).html(html);
        }
      }
    });
    $.ajax({
      type  : 'POST',
      url   : "<?=base_url()?>video/get_section_progress",
      dataType : 'json',
      data : {course_slug:course_slug},
      success : function(data){
        for(i=0; i<data.length; i++){
          var html = '';
          if(data[i].percentage == 100){
            html += '<i class="fas fa-star amber-text mr-1"></i>';
            $('#section_'+data[i].section_ID).html(html);
          }
        }
      }
    });
  }
});
</script>
<script type="text/javascript">
$(document).ready(function(){
  $('.center').slick({
    infinite: false,
    dots: true,
    slidesToShow: 3,
    slidesToScroll: 3,
    accessibility: true,
    adaptiveHeight: true,
    responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
        infinite: false,
        dots: true,
        adaptiveHeight: true,
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
         adaptiveHeight: true
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        adaptiveHeight: true
      }
    }
  ]
  });
  if(window.location.hash != ''){ 
    var hash = document.URL.substr(document.URL.indexOf('#')+1);
    $('.center').slick('slickGoTo', hash - 2);
  }
});
</script>