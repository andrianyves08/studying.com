<script type="text/javascript">
  function readURL(input, textarea) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#body_bottom_'+textarea).show();
        $('#preview_'+textarea).attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
      uploadImage(input.files[0], textarea);
    }
  }

  function uploadImage(image, textarea) {
    var data = new FormData();
    data.append("image", image);
    $.ajax({
      url: "<?php echo site_url('posts/upload_image')?>",
      cache: false,
      contentType: false,
      processData: false,
      data:data,
      type: "POST",
      success: function(url) {
        if(!url){
          $('#preview_'+textarea).removeAttr('src');
          toastr.error('Invalid image type');
        } else{
          $('#image_'+textarea).val(url);
        }
      },
      error: function(data) {
        console.log(data);
      }
    });
  }
   
$(function() {
  var imagesPreview = function(input, placeToInsertImagePreview) {
    if (input.files) {
      $('#body_bottom_0').show();
      var filesAmount = input.files.length;
      for (i = 0; i < filesAmount; i++) {
        var reader = new FileReader();
        reader.onload = function(event) {
          $($.parseHTML('<img>')).attr('src', event.target.result).attr('onerror', "this.onerror=null;this.src='<?php echo base_url();?>assets/img/posts/thumbs/play_button.jpg';").appendTo(placeToInsertImagePreview);
        }
        reader.readAsDataURL(input.files[i]);
        // uploadImage(input.files[i], 0);
      }
      $('#upload_image_modal').modal('hide');
    }
  };
  $('#post_image_0').on('change', function() {
    imagesPreview(this, 'div.preview_0');
  });
});
</script>
<script type="text/javascript">
$(document).ready(function(){
  create_ckeditor('posts');
  liked();
  liked_comments();
  $('.swipebox').swipebox();
  create_popover();

  <?php 
    $all_users = array();
    foreach ($users as $user) {
      if(!empty($user["first_name"]) || !empty($user["first_name"])){
        if($my_info['id'] != $user["id"] && $user["status"] == 1) {
          $all_users[] = array(
            'id' =>  $user["id"],
            'username' =>  $user["username"],
            'fullname' =>  ucwords($user["first_name"]).' '.ucwords($user["last_name"]),
            'avatar' => base_url().'assets/img/users/thumbs/'.$user['image'],
          );
        }
      }
    }
  ?>
  var users = <?php echo json_encode($all_users); ?>,
  tags = [];

  function createNewEditor(post_ID, textarea) {
    var element = document.createElement("textarea");
    $(element).addClass("textarea_"+textarea).attr('name', 'textarea_comments_'+textarea).appendTo('#textarea_comments_'+textarea);
    return create_ckeditor(element);
  }

  function create_ckeditor(element){
    CKEDITOR.config.disableNativeSpellChecker = false;
    CKEDITOR.replace(element, {
      forcePasteAsPlainText : true, 
      plugins: 'mentions,emoji,basicstyles,undo,link,wysiwygarea,toolbar, pastetext, scayt',
      height: 60,
      width: 500,
      width: '99%',
      toolbar: [{name: 'document', items: ['Undo', 'Redo']},{name: 'links', items: ['EmojiPanel', 'Link', 'Unlink', 'scayt']}],
      mentions: [{
          feed: dataFeed,
          itemTemplate: '<li data-id="{id}">' +
            '<img class="photo" src="{avatar}" style="width: 25px;" onerror="this.onerror=null;this.src=\'<?php echo base_url();?>assets/img/users/stock.jpg\';"/>' +
            '<span class="fullname"> {fullname}</span>' +
            '</li>',
          outputTemplate: '<a href="<?php echo base_url();?>{username}" data-user-id="{id}">@{fullname}</a><span>&nbsp;</span>',
          minChars: 0
        },
        {
          feed: tags,
          marker: '#',
          itemTemplate: '<li data-id="{id}"><strong>{fullname}</strong></li>',
          outputTemplate: '<a href="https://example.com/social?tag={fullname}">{fullname}</a>',
          minChars: 1
        }
      ]
    });
  }

  //Delete posts
  $(document).on("click", ".delete_post", function() { 
    var post_ID=$(this).data('post-id');
    alert_sound.play();
    if(confirm("Are you sure you want to delete this Posts?")){
      $('.post_popover').popover('hide');
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>posts/delete_post",
        dataType : "JSON",
        data : {post_ID:post_ID},
        success: function(data){
          toastr.error('Post deleted');
        }
      });
      $('.post_id_'+post_ID).empty();
    }
  });

  $(document).on('click', '.view_likers', function(){
    $('#view_likers').modal('show');
    var post_ID = $(this).data('post-id');
    $.ajax({
      url:"<?=base_url()?>posts/get_likers",
      method:"POST",
      async : true,
      dataType : 'json',
      data:{post_ID:post_ID},
      success:function(data) {
        var html = ''
        var i;
        for(i=0; i<data.length; i++){
          html += '<a class="mb-2" href="./'+data[i].username+'"><img class="mb-2 rounded-circle mr-2 card-img-100 chat-mes-id" src="<?php echo base_url();?>assets/img/users/thumbs/'+data[i].image+'" style="height: 30px; width: 30px" alt="Profile photo" onerror="this.onerror=null;this.src=\'<?php echo base_url();?>assets/img/users/stock.jpg\';">'+data[i].first_name+'</a><br>';
        }
        $('#likers_post').html(html);
      }
    })
  });

  //Like post
  $(document).on('click', '.liked', function(){
    var posts = $(this).data('post-id');
    var user_ID = $(this).data('user-id');
    var status = $(this).data('status');
    $.ajax({
      url:"<?=base_url()?>posts/liked",
      method:"POST",
      async : true,
      dataType : 'json',
      data:{posts:posts, user_ID:user_ID, status,status},
      success:function(data) {
        $('.liked_'+posts).removeClass('text-dark');
        if(!data.status){
          $('.liked_'+posts).removeClass('blue-text');
          $(".liked_"+posts).data("status", 0);
        } else {
          $('.liked_'+posts).addClass('blue-text');
          $(".liked_"+posts).data("status", 1);
        }      
      }
    })
  });

  //Like comment
  $(document).on('click', '.like_comment', function(){
    var comment_ID = $(this).data('comment-id');
    var user_ID = $(this).data('user-id');
    var post_ID = $(this).data('post-id');
    var status = $(this).data('status');
    $.ajax({
      url:"<?=base_url()?>posts/like_comment",
      method:"POST",
      async : true,
      dataType : 'json',
      data:{comment_ID:comment_ID, user_ID:user_ID, post_ID:post_ID, status:status},
      success:function(data) {
        if(!data.status){
          $('.like_comment_'+comment_ID).removeClass('blue-text');
          $('.like_comment_'+comment_ID).data("status", 0);
        } else {
          $('.like_comment_'+comment_ID).addClass('blue-text');
          $('.like_comment_'+comment_ID).data("status", 1);
        }      
      }
    })
  });

  function liked_comments() {
    $.ajax({
      type : "POST",
      url  : base_url +"posts/get_liked_comments",
      dataType : "JSON",
      success: function(data){
        for(i=0; i<data.length; i++){
          $('.like_comment_'+data[i].comment_ID).addClass('blue-text');
          $('.like_comment_'+data[i].comment_ID).data("status", 0);
        }
      }
    });
  }

  function liked() {
    $.ajax({
      type : "POST",
      url  : base_url +"posts/get_liked",
      dataType : "JSON",
      success: function(data){
        for(i=0; i<data.length; i++){
          $('.liked_'+data[i].post_ID).addClass('blue-text');
          $('.liked_'+data[i].post_ID).data("status", 0);
        }
      }
    });
  }

  var textarea = 2;
  $(document).on('click', '.view_comments', function(){
    var post_ID = $(this).data('post-id');
    var start = $(this).data('start');
    fetch_comments(post_ID, 5, start);
  });

  
    $(document).on('click', '.add_comment', function(){
      <?php if(!empty($my_purchases)){?>
        var post_ID = $(this).data('post-id');
        var user_ID = $(this).data('user-id');
        get_comments(post_ID, user_ID);
      <?php } else {?>
        toastr.error('Forbidden. You havent bought any courses.');
      <?php } ?>
    });


  function get_comments(post_ID, user_ID) {
    var comments = '<div class="form-group m-2 mb-0 textarea_comments"><label for="quickReplyFormComment">Your comment</label><input type="file" style="display:none;" name="post_image" id="post_image_'+textarea+'" onchange="readURL(this, '+textarea+');" accept="image/x-png,image/gif,image/jpeg"><input type="hidden" name="image_'+textarea+'" id="image_'+textarea+'"><button type="button" class="btn btn-link uploadTrigger m-0 ml-4 px-2 py-2" id="uploadTrigger_'+textarea+'" data-textarea-id="'+textarea+'"><i class="fas fa-photo-video mr-2 green-text"></i>Photo</button><div id="textarea_comments_'+textarea+'"></div><div id="body_bottom_'+textarea+'" class="image_textarea"><img class="ml-2 mt-2" id="preview_'+textarea+'"/></div><div class="text-center"><button class="btn btn-primary btn-sm submit_comment" type="submit" data-post-id="'+post_ID+'" data-user-id="'+user_ID+'" data-textarea-id="'+textarea+'" data-comment-id="0">Comment</button></div></div>';
    $('#comment_textarea_'+post_ID).html(comments);
      createNewEditor(post_ID, textarea);
    textarea++;
  }

  function fetch_comments(post_ID, limit, start){
    $.ajax({
      method  : 'post',
      url   : "<?=base_url()?>posts/get_comments",
      dataType : 'json',
      async : true,
      data:{post_ID:post_ID, start:start, limit:limit},
      success : function(data){
        var html = '';
        var i;
        for(i=0; i<data.length; i++){
          html += '<div class="media m-2 comments_post_id_'+data[i].post_ID+' comments comments_ID_'+data[i].comment_ID+'"><img class="rounded-circle card-img-100 d-flex mx-auto mb-3 ml-2 chat-mes-id" src="<?php echo base_url();?>assets/img/users/thumbs/'+data[i].image+'" alt="Profile Photo" onerror="this.onerror=null;this.src=\'<?php echo base_url();?>assets/img/users/stock.jpg\';"><div class="media-body text-left ml-2"><div class="bg-light rounded p-2"><h6 class="font-weight-bold m-0"><a class="text-dark profile_popover" href="<?php echo base_url(); ?>'+data[i].username+'" data-user-id="'+data[i].user_ID+'">'+data[i].first_name+' '+data[i].last_name+'</a>';
          if (data[i].user_ID == <?php echo $my_info['id']?>){
            html +=  '<a class="float-right red-text m-1"><i class="fas fa-times delete_comment fa-xs" data-comment-id="'+data[i].comment_ID+'" data-post-id="'+data[i].post_ID+'"></i></a>';
          }
          html += '</h6>'+data[i].comment;
          if (data[i].comment_image != "") {
            html += '<div class="mt-2 h-50"><div class="d-flex"><a rel="gallery_'+data[i].comment_ID+'" href="'+data[i].comment_image+'" class="swipebox"><img src="'+data[i].comment_image_thumbs+'" class="img-fluid img-thumbnail" style="width: 200px;"></a></div></div>';
          }
          html += '</div><div class="mb-2"><a class="ml-2 like_comment like_comment_'+data[i].comment_ID+'" data-comment-id="'+data[i].comment_ID+'" data-user-id="'+data[i].user_ID+'" data-post-id="'+data[i].post_ID+'">Like</a><a class="ml-2 add_reply" data-comment-id="'+data[i].comment_ID+'" data-post-id="'+data[i].post_ID+'" data-user-id="'+data[i].user_ID+'">Reply</a><span class="text-left ml-2" style="font-size: 12px;">'+data[i].timestamp+'</span>';
          if(data[i].total_comments > 0){
            html += '<span class="float-right blue-text"><i class="far fa-thumbs-up"></i>'+data[i].total_comments+'</span></div>';
          } else {
            html += '</div>';
          }
          if(data[i].total_replies > 0){
            html += '<a class="ml-4 view_replies" data-comment-id="'+data[i].comment_ID+'" data-post-id="'+data[i].post_ID+'" data-user-id="'+data[i].user_ID+'"><i class="fas fa-reply mr-2"></i>'+data[i].total_replies;
            if(data[i].total_replies > 1){
              html += ' replies</a>';
            } else {
              html += ' reply</a>';
            }
          }
          html += '<div id="add_reply_textarea_'+data[i].comment_ID+'"></div><div id="add_reply_'+data[i].comment_ID+'"></div></div></div>';
        }
        start = start + 5;
        $(".view_comments_"+post_ID).data("start", start);
        if(limit == 1){
          $(".comments_post_id_"+post_ID).first().html(html).show().fadeIn("slow");
        } else {
          $(".comments_post_id_"+post_ID+":last").after(html).show().fadeIn("slow");
        }
        
        if(!$.trim(data)) {
          $(".view_comments_"+post_ID).hide();
        }
        $("img").addClass("img-fluid");
        create_popover();
        liked_comments();
      }
   });
  }

    $(document).on('click', '.add_reply', function(){
      <?php if(!empty($my_purchases)){?>
        var comment_ID = $(this).data('comment-id');
        var post_ID = $(this).data('post-id');
        var user_ID = $(this).data('user-id');
        get_replies(post_ID, comment_ID, user_ID);
      <?php } else {?>
        toastr.error('Forbidden. You havent bought any courses.');
      <?php } ?>
    });
 

  $(document).on('click', '.view_replies', function(){
    var comment_ID = $(this).data('comment-id');
    var post_ID = $(this).data('post-id');
    var user_ID = $(this).data('user-id');
    $(this).hide();
    fetch_comments_reply(post_ID, comment_ID); 
    liked_comments();
  });

  $(document).on('click', '.uploadTrigger', function(){
    var textarea_ID = $(this).data('textarea-id');
    $("#post_image_"+textarea_ID).click();
  });

  $(document).on("click", ".submit_comment", function() { 
    var post_ID = $(this).data('post-id');
    var textarea_ID = $(this).data('textarea-id');
    var comment = CKEDITOR.instances['textarea_comments_'+textarea_ID].getData();
    var image = $('#image_'+textarea_ID).val();
    var user_ID = $(this).data('user-id');
    var comment_ID = $(this).data('comment-id');
    var post = $(this).data('post');
    if(comment != '' || image != ''){
      $.ajax({
        type : "POST",
        url  :  "<?=base_url()?>posts/add_comment",
        dataType : "JSON",
        data : {post_ID:post_ID, comment:comment, comment_ID:comment_ID, user_ID:user_ID, image:image},
        success: function(data){
          if(!data){
            toastr.error('This posts has been deleted.');
          }
          CKEDITOR.instances['textarea_comments_'+textarea_ID].setData('');
          $('#textarea_comments_'+textarea_ID).val('');
          $('#image_'+textarea_ID).val('');
          $('#preview_'+textarea_ID).removeAttr('src');
          $('#body_bottom_'+textarea_ID).hide();
          toastr.success('Gained 3 Exp!');
          get_level();
          $('#body_bottom_'+textarea_ID).hide();
          if(comment_ID != 0){
            fetch_comments_reply(post_ID, comment_ID);
          } else {
            fetch_comments(post_ID, 1, 0);
          }
        }
      });
    } else {
      toastr.error('Enter a comment or image');
    }
  });

  function get_replies(post_ID, comment_ID, user_ID) {
    var reply = '<div class="form-group mt-2"><label for="quickReplyFormComment">Your reply</label><input type="file" style="display:none;" name="post_image" id="post_image_'+textarea+'" onchange="readURL(this, '+textarea+');" accept="image/x-png,image/gif,image/jpeg"><input type="hidden" name="image_'+textarea+'" id="image_'+textarea+'"><button type="button" class="btn btn-link uploadTrigger ml-4 m-0 px-2 py-2" id="uploadTrigger_'+textarea+'" data-textarea-id="'+textarea+'"><i class="fas fa-photo-video mr-2 green-text"></i>Photo</button><div id="textarea_comments_'+textarea+'"></div><div id="body_bottom_'+textarea+'" class="image_textarea"><img class="ml-2 mt-2" id="preview_'+textarea+'"/></div><div class="text-center"><button class="btn btn-primary btn-sm submit_comment" type="submit" data-post-id="'+post_ID+'" data-comment-id="'+comment_ID+'" data-user-id="'+user_ID+'" data-textarea-id="'+textarea+'">Add Reply</button><br><a class="view_replies" data-comment-id="'+comment_ID+'" data-post-id="'+post_ID+'" data-user-id="'+user_ID+'">View replies</a></div></div>';
    
    $('#add_reply_textarea_'+comment_ID).html(reply);
    createNewEditor(post_ID, textarea);
    textarea++;
  }

  function fetch_comments_reply(post_ID, comment_ID){
    $.ajax({
      method  : 'post',
      url   : "<?=base_url()?>posts/get_replies",
      dataType : 'json',
      async : true,
      data:{post_ID:post_ID, comment_ID:comment_ID},
      success : function(data){
        var html = '';
        var i;
        for(i=0; i<data.length; i++){
          html += '<div class="media mt-2 comments_ID_'+data[i].comment_ID+'"><img class="rounded-circle card-img-64 d-flex mx-auto mb-2 chat-mes-id" alt="Profile Photo" src="<?php echo base_url();?>assets/img/users/thumbs/'+data[i].image+'" onerror="this.onerror=null;this.src=\'<?php echo base_url();?>assets/img/users/stock.jpg\';"><div class="media-body text-left ml-2"><div class="bg-light rounded p-2"><h6 class="font-weight-bold m-0"><a class="text-dark profile_popover" href="<?php echo base_url();?>'+data[i].username+'" data-user-id="'+data[i].user_ID+'">'+data[i].first_name+' '+data[i].last_name+'</a>';
          if (data[i].user_ID == <?php echo $my_info['id']; ?> || data[i].owner_post == <?php echo $my_info['id']; ?>){
            html += '<a class="float-right red-text m-1"><i class="fas fa-times delete_comment fa-xs" data-comment-id="'+data[i].comment_ID+'" data-post-id="'+data[i].post_ID+'"></i></a>';
          }
          html += '</h6>'+data[i].comment;
          if (data[i].comment_image != "") {
            html += '<div class="mt-2 h-50"><div class="d-flex"><a rel="gallery_'+data[i].comment_ID+'" href="'+data[i].comment_image+'" class="swipebox"><img src="'+data[i].comment_image_thumbs+'" class="img-fluid img-thumbnail" style="width: 200px;"></a></div></div>';
          }
          html += '</div><a class="ml-2 like_comment like_comment_'+data[i].comment_ID+'" data-comment-id="'+data[i].comment_ID+'" data-user-id="'+data[i].user_ID+'" data-post-id="'+data[i].post_ID+'">Like</a><span class="ml-2 text-left" style="font-size: 12px;">'+data[i].timestamp+'</span>';
          if(data[i].total_likes > 1){
            html += '<span class="float-right blue-text"><i class="far fa-thumbs-up"></i> '+data[i].total_likes+'</span>';
          }
          html += '</div></div>';
        }
        $('#add_reply_'+comment_ID).html(html);
        $("img").addClass("img-fluid");
          create_popover();
      }
    });
  }

  $(document).on("click", ".delete_comment", function() { 
    var comment_ID=$(this).data('comment-id');
    var post_ID=$(this).data('post-id');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>posts/delete_comment",
      dataType : "JSON",
      data : {comment_ID:comment_ID},
      success: function(data){
        toastr.error('Comment deleted');
        $('.comments_ID_'+comment_ID).remove();
      }
    });
  });

  var start = 5;
  <?php if($title != 'View post'){ ?>
  $(document).on("click", ".change_feed", function() { 
    var course_ID=$(this).data('course-id');
    var spinner = '<div class="spinner-border" role="status"> <span class="sr-only">Loading...</span></div>';
    $("#timeline").data("course-id", course_ID);
    $("#spinner").html(spinner);    
    start = 0;
    get_post(start, course_ID, 0);
    start = start + 5;
  });
  
  $(window).scroll(function(){  
    var position = $(window).scrollTop();
    var bottom = $(document).height() - $(window).height();
    var course_ID = $("#timeline").data('course-id');
    if(position == bottom){
      get_post(start, course_ID, 1);
      start = start + 5;
    }
  });
<?php } ?>
  function get_post(start, course_ID, feed){
    var user_ID = <?php echo !empty($user_info) ? $user_info['id'] : $my_info['id']; ?>;
    $.ajax({
        url: "<?=base_url()?>posts/load_more",
        type: 'post',
        dataType : "JSON",
        data: {start:start, course_ID:course_ID, user_ID:user_ID},
        beforeSend:function(){
          $("#spinner").prop('hidden', false);
        },
        success: function(data){
          var html = '';
          var i;
          for(i=0; i<data.length; i++){
            html += '<div class="card mb-4 posts post_id_'+data[i].post_ID+'"><div class="media mt-2"><img class="rounded-circle ml-2 card-img-100 d-flex z-depth-1 mr-2 chat-mes-id" src="'+data[i].image+'" style="height: 50px; width: 50px" alt="Profile photo" onerror="this.onerror=null;this.src=\'<?php echo base_url();?>assets/img/users/stock.jpg\';"><div class="media-body"><h5><a class="text-dark profile_popover" href="<?php echo base_url(); ?>'+data[i].username+'" data-user-id="'+data[i].user_ID+'">'+data[i].first_name+' '+data[i].last_name+'</a>';
            var title = data[i].title;
            for(var r =0; r<title.length; r++){
              html += '<span class="ml-1 mr-2"><small style="font-size: 14px; font-weight: 600;">#'+title[r].course_title+'</small></span>';
            }
            if (data[i].user_ID == <?php echo $my_info['id']; ?>){
              html += '<a class="float-right mr-2 post_popover" data-toggle="popover" alt="'+data[i].post_ID+'" data-post-id="'+data[i].post_ID+'" data-pin="'+data[i].pin+'"><i class="fas fa-ellipsis-v"></i></span></a>';
            }

            html += '</h5><a href="<?php echo base_url(); ?>'+data[i].username+'/posts/'+data[i].post_ID+'" class="text-muted text-dark"><small>'+data[i].timestamp+'</small></a></div></div><div class="card-body py-0 mt-2">'+data[i].post;
            
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
            html += '</div><div class="d-flex justify-content-between text-center border-top border-bottom w-100"><a class="p-3 ml-2 liked liked_'+data[i].post_ID+'" data-post-id="'+data[i].post_ID+'" data-user-id="'+data[i].user_ID+'" data-status="0"><i class="far fa-thumbs-up mr-2"></i> Like</a><a class="p-3 ml-2 add_comment" data-post-id="'+data[i].post_ID+'" data-user-id="'+data[i].user_ID+'"><i class="far fa-comment-alt mr-2"></i> Comment</a><p class="p-3 text-red text-muted" disabled><i class="fas fa-share mr-2"></i>Share</p></div><div id="comment_textarea_'+data[i].post_ID+'"></div><div class="comments_post_id_'+data[i].post_ID+'"></div>';
            fetch_comments(data[i].post_ID, 5, 0);
            html +='<a class="text-center view_comments_'+data[i].post_ID+' view_comments mb-2" data-post-id="'+data[i].post_ID+'" data-user-id="'+data[i].user_ID+'" data-start="2">';
            if (data[i].total_comments > 2){
              html += 'View more comments';
            }
            html += '</a></div>';
          }
          if(feed == 1){
            $(".posts:last").after(html).show().fadeIn("slow");
          } else {
            $("#timeline").html(html).show().fadeIn("slow");
          }

          if(!$.trim(data)) {
            $("#spinner").text("No more posts to show");
          }
          liked();
          $("img").addClass("img-fluid");
          create_popover();
        }
      });
  }

   function get_files(post_ID, user_ID) {
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>posts/get_files",
      dataType : "JSON",
      data : {post_ID:post_ID, user_ID:user_ID},
      success: function(data){
        $('#nanogallery_'+post_ID).html(data);
      }
    });
  }

  function dataFeed(opts, callback) {
    var matchProperty = 'fullname',
      data = users.filter(function(item) {
        return item[matchProperty].toLowerCase().indexOf(opts.query.toLowerCase()) > -1
      });
    data = data.sort(function(a, b) {
      return a[matchProperty].localeCompare(b[matchProperty], undefined, {
        sensitivity: 'accent'
      });
    });
    callback(data);
  }

  function create_popover(){
    $('.post_popover').popover({
      sanitize: false,
      placement : 'left',
      html : true,
      content: '<a class="m-2 edit_post" data-post-id="0"><i class="fas fa-edit"></i> Edit Post</a><br><a class="m-2 delete_post" data-post-id="0"><i class="fas fa-trash"></i> Delete Post</a><br><?php if($title == 'My profile'){?><a class="m-2 pin_post" data-post-id="0" data-pin="0"></a><?php } ?>',
    });
    $('.profile_popover').popover({
      sanitize: false,
      html : true,
      trigger: 'hover',
      content: '<div id="user_profile"></div>',
    });
    $('.profile_popover').on('show.bs.popover', function () {
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>users/get_users",
        dataType : "JSON",
        data : {user_ID:$(this).data('user-id')},
        success: function(data){
          html = '<div class="d-flex flex-row mb-2"><img src="<?php echo base_url(); ?>assets/img/users/thumbs/'+data.image+'" class="rounded-circle mr-2 chat-mes-id-2" alt="avatar" style="height: 50px;width: 50px;" onerror="this.onerror=null;this.src=\'<?php echo base_url();?>assets/img/users/stock.jpg\';"><div><h6><strong>'+data.full_name+'</strong></h6><i>Level '+data.level+'</i></div></div><div class="d-flex"><h6><strong>'+data.count_posts+'</strong> Posts</h6><h6 class="ml-2"><strong>'+data.count_following+'</strong> Following</h6><h6 class="ml-2"><strong>'+data.count_followers+'</strong> Followers</h6></a></div>';
          $("#user_profile").html(html);
        }
      });
    });
  }

  //Pin posts
  $(document).on("click", ".pin_post", function() { 
    var post_ID=$(this).data('post-id');
    var pin=$(this).data('pin');
    $('.post_popover').popover('hide');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>posts/pin_post",
      dataType : "JSON",
      data : {post_ID:post_ID, pin:pin},
      success: function(data){
        if(pin == 1){
          toastr.success('Post pinned');
        } else {
          toastr.success('Post unpinned');
        }
        location.reload();
      }
    });
  });

  $(document).on("click", ".edit_post", function() { 
    var post_ID=$(this).data('post-id');
    window.location.href = "<?php echo base_url(); ?><?php echo $my_info['username']; ?>/posts/edit/"+post_ID;
  });

  $(document).on("click", ".post_popover", function() { 
    var post_ID=$(this).data('post-id');
    var pin=$(this).data('pin');
    $(".edit_post").data("post-id", post_ID);
    $(".delete_post").data("post-id", post_ID);
    $(".pin_post").data("post-id", post_ID);
    <?php if($title == 'My profile'){?>
      if(pin == 1){
         var html = '<i class="fas fa-thumbtack"></i> Unpin POST';
        $(".pin_post").data("pin", 0);
      } else {
        var html = '<i class="fas fa-thumbtack"></i> Pin POST';
        $(".pin_post").data("pin", 1);
      }
      $(".pin_post").html(html);
    <?php } ?>
    
  });
});
</script>