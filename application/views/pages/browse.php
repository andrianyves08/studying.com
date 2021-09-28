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

  $array = array();
  foreach ($my_purchases as $my_purchase) {
    $array[] = $my_purchase['course_ID'];
  }
?>
<style type="text/css">
  .flex-1 {
flex: 1;
}
</style>
<main class="pt-5 mx-lg-5">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <nav class="navbar navbar-expand-lg navbar-dark mt-3 mb-4">
          <a class="nav-link navbar-brand dropdown-toggle waves-effect waves-light blue-text" id="caregory_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><strong>Category</strong>
          </a>
          <div class="dropdown-menu dropdown-menu-left dropdown-default" aria-labelledby="caregory_dropdown" style="width: 300px;">
            <a class="mr-3 change_category dropdown-item waves-effect waves-light" data-category-id="0">
             <strong>All</strong>
            </a>
            <?php foreach($categories as $category){ ?>
            <a class="mr-3 change_category dropdown-item waves-effect waves-light" data-category-id="<?php echo $category['id']; ?>">
              <strong><?php echo ucfirst($category['name']); ?></strong>
            </a>
            <?php } ?>
          </div>
          <div class="input-group ml-2 mt-1">
            <input class="form-control form-control-sm" type="text" placeholder="Search" aria-label="Search" id="course_search">
            <div class="input-group-prepend">
              <button class="btn btn-light btn-sm m-0 px-3 py-2 z-depth-0" id="search"><i class="fas fa-search"></i></button>
            </div>
          </div>
        </nav>
        <div id="category" data-category-id="0">
          <div class="row" id="timeline">
            <?php foreach ($courses as $course){
              if($course['privacy'] == '0'){
              $rating = $CI->review_model->get_rating(3, $course['course_ID']); ?>
              <div class="col-lg-3 col-sm-6 d-flex align-items-stretch courses">
                <div class="card text-center mb-4">
                  <img class="card-img-top chat-mes-id-3" src="<?php echo $course['image']; ?>" alt="Card image cap" onerror="this.onerror=null;this.src='<?php echo base_url();?>assets/img/logo-3.jpg';">
                  <div class="card-body">
                    <a href="<?php base_url(); ?>course/detail/<?php echo $course['slug']; ?>" class="mb-1 font-weight-bold black-text"><?php echo ucfirst($course['title']); ?>
                    </a>
                    <br>
                    <?php 
                      if (in_array($course['course_ID'], $array)) {
                        echo "<span class='badge badge-pill badge-success'>Bought</span>";
                      }
                    ?>
                    <?php echo renderStarRating($rating['avg']); ?>
                  </div>
                </div>
              </div>
            <?php } } ?>
          </div>
        </div>
        <div class="text-center" id="spinner" hidden>
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
      </div><!--Grid column-->
    </div><!--Grid row-->
  </div><!--Container-->
</main>
<script type="text/javascript">
$(document).ready(function(){
  var start = 10;
  $(document).on("click", "#search", function() { 
    var title = $('#course_search').val();  
    $("#category").data("category-id", -1);
    start = 0;
    get_courses(start, -1, 0, title);
    start = start + 10;
    $('#course_search').val('');  
  });

  $(document).on("click", ".change_category", function() { 
    var category_ID=$(this).data('category-id');
    var spinner = '<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>';
    $("#spinner").html(spinner);    
    $("#category").data("category-id", category_ID);
    start = 0;
    get_courses(start, category_ID, 0, 0);
    start = start + 10;
  });
  
  $(window).scroll(function(){  
    var position = $(window).scrollTop();
    var bottom = $(document).height() - $(window).height();
    var category_ID = $("#category").data('category-id');
    if(position == bottom){
      get_courses(start, category_ID, 1, 0);
      start = start + 10;
    }
  });

  function get_courses(start, category_ID, feed, title){
    $.ajax({
      url: "<?=base_url()?>courses/view_more",
      type: 'post',
      dataType : "JSON",
      data: {start:start, category_ID:category_ID, title:title},
      beforeSend:function(){
        $("#spinner").prop('hidden', false);
      },
      success: function(data){
        var html = '';
        var i;
        for(i=0; i<data.length; i++){
          html += '<div class="col-lg-3 col-md-3 col-sm-6 d-flex align-items-stretch courses"><div class="card text-center mb-4"><img class="card-img-top chat-mes-id-3" src="'+data[i].image+'" alt="Card image cap" onerror="this.onerror=null;this.src=\'<?php echo base_url();?>assets/img/logo-3.jpg\';">';
          html += '<div class="card-body"><a href="<?php echo base_url(); ?>course/detail/'+data[i].slug+'" class="mb-1 font-weight-bold black-text">'+data[i].title+'</a><br>'+data[i].rating+'</div></div></a></div>';
        }
        if(feed == 1){
          $(".courses:last").after(html).show().fadeIn("slow");
        } else {
          $("#timeline").html(html).show().fadeIn("slow");
        }
        if(!$.trim(data) || data.length < 10) {
          $("#spinner").hide();
        }
      }
    });
  }
});
</script>