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
<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <?php echo form_open_multipart('posts/edit_post'); ?>
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="media mt-2">
          <img onerror="this.onerror=null;this.src='<?php echo base_url();?>assets/img/users/stock.jpg';" class="rounded-circle ml-2 card-img-100 d-flex z-depth-1 mr-2 chat-mes-id" src="<?php echo base_url();?>assets/img/users/<?php echo $my_info['image'];?>" style="height: 50px; width: 50px" alt="Profile photo"/>
          <div class="media-body d-flex">
            <textarea type="textarea" class="textarea_post" name="posts" id="posts"><?php echo $post['post'];?></textarea>
          </div>
        </div>
        <div class="card-body py-0 mt-2">
          <div class="float-right border-top">
            <input type="hidden" name="post_ID" value="<?php echo $post['post_ID']; ?>">
            <input type="file" style="display:none;" id="post_file" multiple accept="video/mp4,video/x-m4v,video/*,image/x-png,image/gif,image/jpeg">
            <button type="button" class="btn btn-link uploadTrigger mr-2" data-textarea-id="0"><i class="fas fa-photo-video green-text mr-2"></i>Add Photo / Video</button>
            <select class="select2" name="course_ID[]" multiple="multiple" data-placeholder="Select where to posts" name="course_ID" style="width: 300px;" required>
              <option value="0" <?php if(in_array('0', $post_to_courses, true)){ echo 'selected'; }?>>Global</option>
              <?php foreach($my_purchases as $row){ ?> 
                <option value="<?php echo $row['course_ID'];?>" <?php if(in_array($row['course_ID'], $post_to_courses, true)){ echo 'selected'; }?> ><?php echo ucwords($row['title']);?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div><!-- Card -->
      <div class="new_images">
      </div>
      <?php $i=1; foreach($files as $file){ ?>
      <div class="card mb-4" id="image_<?php echo $i;?>">
        <div class="card-body py-0 mt-2">
          <a class="float-right red-text mr-1 delete_image" data-image-id="<?php echo $i; ?>"><i class="fas fa-times"></i> Delete</a>
          <input type="hidden" name="post_file[<?php echo $i; ?>][image]" value="<?php echo $file['file']; ?>">
          <?php 
            $mime = mime_content_type('./assets/img/posts/'.hash('md5', $file['user_ID']).'/'.$file['file']);
            if(strstr($mime, "video/")){
              echo '<div class="embed-responsive embed-responsive-16by9" style="width: 60%"><iframe class="embed-responsive-item" src="'.base_url().'assets/img/posts/'.hash('md5', $file['user_ID']).'/'.$file['file'].'" allowfullscreen></iframe></div>';
            } else if(strstr($mime, "image/")){
              echo '<img src="'.base_url().'assets/img/posts/'.hash('md5', $file['user_ID']).'/'.$file['file'].'" class="img-thumbnail" style="width: 60%">';
            }
          ?>
          <textarea type="textarea" class="textarea mt-2" name="post_file[<?php echo $i; ?>][description]" id="description_<?php echo $file['id'];?>" value="<?php echo $file['description'];?>" placeholder="Add description or caption" style="width: 100%;"><?php echo $file['description'];?></textarea>
        </div>
      </div>
      <?php $i++; } ?>
      <input type="hidden" id="last_id" value="<?php echo $i; ?>">
      <button class="btn btn-success float-right" type="submit" id="create_posts">Save</button>
  </div>
  </div>
  <?php echo form_close(); ?>
</div><!--Container-->
</main><!--Main layout-->
<script type="text/javascript">
$(document).ready(function(){
  $(document).on('click', '.uploadTrigger', function(){
    $("#post_file").click();
  });

  $("#post_file").change(function() {
    var filesAmount = this.files.length;
    for (i = 0; i < filesAmount; i++) {
      var reader = new FileReader();
      uploadImage(this.files[i]);
    }
  });

  //Like post
  $(document).on('click', '.delete_image', function(){
    var id = $(this).data('image-id');
    toastr.success('Image deleted!');
    $('#image_'+id).remove();
  });

  function uploadImage(image) {
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
        var id = $("#last_id").val();
        var html = '<div class="card mb-4" id="image_'+id+'" class="images"><div class="card-body py-0 mt-2"><a class="float-right red-text mr-1 delete_image" data-image-name="'+url+'" data-image-id="'+id+'"><i class="fas fa-times"></i> Delete</a><input type="text" name="post_file['+id+'][image]" value="'+url+'">';
        var validImageTypes = ["image/gif", "image/jpeg", "image/png"];
        if ($.inArray(url, validImageTypes) < 0) {
          html += '<img src="<?php echo base_url().'assets/img/posts/'.hash('md5', $my_info['id']).'/';?>'+url+'" class="img-thumbnail" style="width: 60%">';
           
        } else {
          html += '<div class="embed-responsive embed-responsive-16by9" style="width: 60%"><iframe class="embed-responsive-item" src="<?php echo base_url().'assets/img/posts/'.hash('md5', $my_info['id']).'/';?>'+url+'" allowfullscreen></iframe></div>';
        } 
        html += '<textarea class="textarea mt-2" placeholder="Add description or caption" name="post_file['+id+'][description]" style="width: 100%;"></textarea></div></div>';
       id = parseInt(id) + 1;
        $("#last_id").val(id);
        $(".new_images:last").append(html);
      },
      error: function(data) {
        console.log(data);
      }
    });
  }

  create_ckeditor('posts');

  <?php 
    $all_users = array();
    foreach ($users as $user) {
      if(!empty($user["first_name"]) || !empty($user["first_name"])){
        if($my_info['id'] != $user["id"] && $user["status"] == 1) {
          $all_users[] = array(
            'id' =>  $user["id"],
            'username' =>  $user["username"],
            'fullname' =>  ucwords($user["first_name"]).' '.ucwords($user["last_name"]),
            'avatar' => is_file('./assets/img/users/'.$user['image']) ? base_url().'assets/img/users/'.$user['image'] : base_url().'assets/img/users/stock.jpg',
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
    CKEDITOR.replace(element, {
      forcePasteAsPlainText : true, 
      plugins: 'mentions,emoji,basicstyles,undo,link,wysiwygarea,toolbar, pastetext',
      height: 60,
      width: 500,
      width: '99%',
      toolbar: [{name: 'document', items: ['Undo', 'Redo']},{name: 'links', items: ['EmojiPanel', 'Link', 'Unlink']}],
      mentions: [{
          feed: dataFeed,
          itemTemplate: '<li data-id="{id}">' +
            '<img class="photo" src="{avatar}" style="width: 25px;"/>' +
            '<span class="fullname"> {fullname}</span>' +
            '</li>',
          outputTemplate: '<a href="<?php echo base_url();?>{username}">@{fullname}</a><span>&nbsp;</span>',
          minChars: 0
        }
      ]
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

});
</script>