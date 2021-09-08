<?php 
$CI =& get_instance();
$CI->load->model('blog_model');
?>
<main class="pt-5 mx-lg-5">
<div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-lg-12 myList mt-4">
        <h4>About <?php echo $total_results; ?> results</h4>
        <ul class="nav nav-pills mb-3 w-100" id="pills-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link" id="pills-all-tab" data-toggle="pill" href="#pills-all" role="tab" aria-controls="pills-all" aria-selected="false">All</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pills-courses-tab" data-toggle="pill" href="#pills-courses" role="tab" aria-controls="pills-courses" aria-selected="false">Courses</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pills-modules-tab" data-toggle="pill" href="#pills-modules" role="tab" aria-controls="pills-modules" aria-selected="false">Modules</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pills-sections-tab" data-toggle="pill" href="#pills-sections" role="tab" aria-controls="pills-sections" aria-selected="false">Sections</a>
          </li>
           <li class="nav-item">
            <a class="nav-link" id="pills-lessons-tab" data-toggle="pill" href="#pills-lessons" role="tab" aria-controls="pills-lessons" aria-selected="false">Lessons</a>
          </li>
           <li class="nav-item">
            <a class="nav-link" id="pills-contents-tab" data-toggle="pill" href="#pills-contents" role="tab" aria-controls="pills-contents" aria-selected="false">Videos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pills-qaas-tab" data-toggle="pill" href="#pills-qaas" role="tab" aria-controls="pills-qaas" aria-selected="false">Question and Answer Mastersheet</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pills-blogs-tab" data-toggle="pill" href="#pills-blogs" role="tab" aria-controls="pills-blogs" aria-selected="false">Blogs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pills-posts-tab" data-toggle="pill" href="#pills-posts" role="tab" aria-controls="pills-posts" aria-selected="false">Posts</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pills-users-tab" data-toggle="pill" href="#pills-users" role="tab" aria-controls="pills-users" aria-selected="false">Users</a>
          </li>
        </ul>
        <div class="tab-content pt-2 pl-1" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
            <div class="mb-5" id="pills-all-pagination"></div>
          </div>
          <div class="tab-pane fade" id="pills-courses" role="tabpanel" aria-labelledby="pills-courses-tab">
            <div class="mb-5" id="pills-courses-pagination"></div>
          </div>
          <div class="tab-pane fade" id="pills-modules" role="tabpanel" aria-labelledby="pills-modules-tab">
            <div class="mb-5" id="pills-modules-pagination"></div>
          </div>
          <div class="tab-pane fade" id="pills-sections" role="tabpanel" aria-labelledby="pills-sections-tab">
            <div class="mb-5" id="pills-sections-pagination"></div>
          </div>
          <div class="tab-pane fade" id="pills-lessons" role="tabpanel" aria-labelledby="pills-lessons-tab">
            <div class="mb-5" id="pills-lessons-pagination"></div>
          </div>
          <div class="tab-pane fade" id="pills-contents" role="tabpanel" aria-labelledby="pills-contents-tab">
            <div class="mb-5" id="pills-contents-pagination"></div>
          </div>
          <div class="tab-pane fade" id="pills-qaas" role="tabpanel" aria-labelledby="pills-qaas-tab">
            <div class="mb-5" id="pills-qaas-pagination"></div>
          </div>
          <div class="tab-pane fade" id="pills-blogs" role="tabpanel" aria-labelledby="pills-blogs-tab">
            <div class="mb-5" id="pills-blogs-pagination"></div>
          </div>
          <div class="tab-pane fade" id="pills-posts" role="tabpanel" aria-labelledby="pills-posts-tab">
            <div class="mb-5" id="pills-posts-pagination"></div>
          </div>
          <div class="tab-pane fade" id="pills-users" role="tabpanel" aria-labelledby="pills-users-tab">
            <div class="mb-5" id="pills-users-pagination"></div>
          </div>
        </div>
      </div><!--Column-->
    </div><!--Row-->
</div><!--Container-->
</main>
<script type="text/javascript">
$(document).ready(function(){
  <?php 
    usort($all, function ($item1, $item2) {
      return strlen($item1['result']) <=> strlen($item2['result']);
    });
  ?> 

  function all(data) {
    var html = '';
    for(i=0; i<data.length; i++){
        html += '<div class="card mb-2"><div class="card-body"><span class="mr-2" style="font-size: 14px;">'+data[i].type+'</span><h2><a href="'+data[i].url+'">'+data[i].result+'<a></h2></div></div>';
      }
    return html;
  }

  function course(data) {
    var html = '<ul>';
    for(i=0; i<data.length; i++){
      html += '<div class="card mb-4"><div class="card-body row"><div class="col-lg-5"><img src="'+data[i].image+'" class="img-fluid banner" alt="Banner" onerror="this.onerror=null;this.src=\'<?php echo base_url();?>assets/img/blogs/132536887_174792661036749_5376550604737863392_o.jpg\';"></div><div class="col-lg-7"0>';
      if("course_title" in data[i]){
        html += '<span style="font-size: 14px;">'+data[i].course_title+'</span>';
      }
      if("content_slug" in data[i]){
        html += '<a href="<?php echo base_url();?>course/'+data[i].course_slug+'/'+data[i].module_slug+'/'+data[i].section_slug+'#'+data[i].id+'">';
      } else if("lesson_slug" in data[i]){
        html += '<a href="<?php echo base_url();?>course/'+data[i].course_slug+'/'+data[i].module_slug+'/'+data[i].section_slug+'#lesson-'+data[i].id+'">';
      } else if("section_slug" in data[i]){
        html += '<a href="<?php echo base_url();?>course/'+data[i].course_slug+'/'+data[i].module_slug+'/'+data[i].section_slug+'">';
      } else if("module_slug" in data[i]){
        html += '<a href="<?php echo base_url();?>course/'+data[i].course_slug+'/'+data[i].module_slug+'">';
      } else {
        html += '<a href="<?php echo base_url();?>course/'+data[i].slug+'">';
      }
      html += '<h2>'+data[i].title+'</h2></a>'+data[i].description+'</div></div></div>';
    }
    return html;
  }

  $('#pills-all').pagination({
    dataSource: <?php echo json_encode($all); ?>,
    callback: function(data, pagination) {
      var html = all(data);
      $('#pills-all-pagination').html(html);
    }
  });

  $('#pills-courses').pagination({
    dataSource: <?php echo json_encode($courses); ?>,
    callback: function(data, pagination) {
      var html = course(data);
      $('#pills-courses-pagination').html(html);
    }
  });

  $('#pills-modules').pagination({
    dataSource: <?php echo json_encode($modules); ?>,
    callback: function(data, pagination) {
      var html = course(data);
      $('#pills-modules-pagination').html(html);
    }
  });

  $('#pills-sections').pagination({
    dataSource: <?php echo json_encode($sections); ?>,
    callback: function(data, pagination) {
      var html = course(data);
      $('#pills-sections-pagination').html(html);
    }
  });

  $('#pills-lessons').pagination({
    dataSource: <?php echo json_encode($lessons); ?>,
    callback: function(data, pagination) {
      var html = course(data);
      $('#pills-lessons-pagination').html(html);
    }
  });

  $('#pills-contents').pagination({
    dataSource: <?php echo json_encode($contents); ?>,
    callback: function(data, pagination) {
      var html = course(data);
      $('#pills-contents-pagination').html(html);
    }
  });

  $('#pills-contents').pagination({
    dataSource: <?php echo json_encode($contents); ?>,
    callback: function(data, pagination) {
      var html = course(data);
      $('#pills-contents-pagination').html(html);
    }
  });

  $('#pills-posts').pagination({
    dataSource: <?php echo json_encode($posts); ?>,
    callback: function(data, pagination) {
      var html = '';
      for(i=0; i<data.length; i++){
        html += '<div class="card mb-4 posts post_id_'+data[i].post_ID+'"><div class="media mt-2"><img class="rounded-circle ml-2 card-img-100 d-flex z-depth-1 mr-2 chat-mes-id" src="'+data[i].image+'" style="height: 50px; width: 50px" alt="Profile photo" onerror="this.onerror=null;this.src=\'<?php echo base_url();?>assets/img/users/stock.jpg\';"><div class="media-body"><h5><a class="text-dark profile_popover" href="<?php echo base_url(); ?>'+data[i].username+'" data-user-id="'+data[i].user_ID+'">'+data[i].first_name+' '+data[i].last_name+'</a>';
        var title = data[i].title;
        for(var r =0; r<title.length; r++){
          html += '<span class="ml-1 mr-2"><small style="font-size: 14px; font-weight: 600;">#'+title[r].course_title+'</small></span>';
        }

        html += '</h5><a href="<?php echo base_url(); ?>'+data[i].username+'/posts/'+data[i].post_ID+'" class="text-muted text-dark"><small>'+data[i].timestamp+'</small></a></div></div><div class="card-body py-0 mt-2 m-2">'+data[i].post;
        
        if(data[i].all_images != ""){
          html += '<div id="nanogallery_'+data[i].numbers+'"></div>';
          html += data[i].all_images;
        }
        
        if (data[i].total_likes > 0){
          html += '<a class="view_likers" data-post-id="'+data[i].post_ID+'"><i class="far fa-thumbs-up text-primary mr-2"></i>'+data[i].total_likes+'</a>';
        }
        if (data[i].total_comments > 0){
          html += '<span class="float-right text-center mb-2" data-post-id="'+data[i].post_ID+'" data-user-id="'+data[i].user_ID+'">'+data[i].total_comments+'<i class="far fa-comment-alt text-primary ml-2"></i></span>';
        }
        html += '</div>';

        html +='</div>';
      }
      $('#pills-posts-pagination').html(html);
    }
  });

  $('#pills-blogs').pagination({
    dataSource: <?php echo json_encode($blogs); ?>,
    callback: function(data, pagination) {
      var html = '';
      for(i=0; i<data.length; i++){
        html += '<div class="card mb-4"><div class="card-body row"><div class="col-lg-5"><img src="'+data[i].banner+'" class="img-fluid banner" alt="Banner" onerror="this.onerror=null;this.src=\'<?php echo base_url();?>assets/img/blogs/132536887_174792661036749_5376550604737863392_o.jpg\';"></div><div class="col-lg-7"><a href="<?php echo 'https://www.studying.com/'; ?>'+data[i].slug+'" target="_blank"><h2 class="dark-text">'+data[i].title+'</h2>'+data[i].description+'<p class="mt-auto">'+data[i].timestamp+'</p></a></div></div></div>';
      }
      $('#pills-blogs-pagination').html(html);
    }
  });

  $('#pills-qaas').pagination({
    dataSource: <?php echo json_encode($qaas); ?>,
    callback: function(data, pagination) {
      var html = '<div class="accordion md-accordion accordion-blocks" id="accordion" role="tablist" aria-multiselectable="true">';
      for(i=0; i<data.length; i++){
        html += '<div class="card h-1 mb-2"><div class="card-header white mb-1" role="tab" id="heading1"><a data-toggle="collapse" data-parent="#accordion" href="#collapse'+data[i].id+'" aria-expanded="true" aria-controls="collapse'+data[i].id+'"><h5 class="mb-0 font-thin h-1 text-dark">'+data[i].question+'<i class="fas fa-angle-down rotate-icon"></i></h5></a></div><div id="collapse'+data[i].id+'" class="collapse" role="tabpanel" aria-labelledby="heading1" data-parent="#accordion"><div class="card-body">'+data[i].answer+'</div></div></div>';
      }
       html += '</div>';
      $('#pills-qaas-pagination').html(html);
    }
  });

  $('#pills-users').pagination({
    dataSource: <?php echo json_encode($users); ?>,
    callback: function(data, pagination) {
      var html = '';
      for(i=0; i<data.length; i++){
        html += '<a href="<?php echo base_url();?>'+data[i].username+'" class="dark-text"><div class="card mb-4 w-25"><div class="card-body"><div class="d-flex flex-row mb-2"><img src="<?php echo base_url(); ?>assets/img/users/thumbs/'+data[i].image+'" class="rounded-circle mr-2 chat-mes-id-2" alt="avatar" style="height: 50px;width: 50px;" onerror="this.onerror=null;this.src=\'<?php echo base_url();?>assets/img/users/stock.jpg\';"><div><h6><strong>'+data[i].first_name+' '+data[i].last_name+'</strong></h6><i>Level '+data[i].level+'</i></div></div></div></div></a>';
      }
      $('#pills-users-pagination').html(html);
    }
  });
});
</script>