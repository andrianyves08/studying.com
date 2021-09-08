<style type="text/css">
#message_content {
  display: none;
}
</style>
<main class="pt-5 mx-lg-5">
  <div class="container-fluid mt-5">
    <section>
      <div class="row justify-content-center mr-2 mb-4">
      <?php if(isMobile()) { ?>
        <div class="col-lg-12 mb-4" id="message_mask">
          <div id="message_menu">
            <div class="input-group mb-3">
              <input type="text" class="form-control form-control-sm" placeholder="Search Message" aria-describedby="button-addon4" id="search_user">
              <div class="input-group-append" id="button-addon4">
                <?php if(!empty($my_purchases)){ ?>
                  <button class="btn btn-sm btn-primary m-0 px-3 py-2 z-depth-0 waves-effect" type="button" data-toggle="modal" data-target="#send_chat">Create a message</button>
                  <button class="btn btn-sm btn-secondary m-0 px-3 py-2 z-depth-0 waves-effect" type="button"  data-toggle="modal" data-target="#create_group">Create a group</button>
                <?php } ?>
              </div>
            </div>
            <div class="card wide overflow-auto" id="message_header" style="height: 500px;">
            </div><!-- Card -->
          </div>
          <div id="message_content">
            <div class="card chat-room small-chat wide" id="message_body" style="height: 550px;">
            </div><!--Card-->
          </div>
        </div> <!--Column-->
      <?php } else { ?>
        <div class="col-lg-4 mb-4">
          <div class="input-group mb-3">
            <input type="text" class="form-control form-control-sm" placeholder="Search Message" aria-describedby="button-addon4" id="search_user">
            <div class="input-group-append" id="button-addon4">
              <?php if(!empty($my_purchases)){ ?>
                <button class="btn btn-sm btn-primary m-0 px-3 py-2 z-depth-0 waves-effect" type="button" data-toggle="modal" data-target="#send_chat">Create a message</button>
                <button class="btn btn-sm btn-secondary m-0 px-3 py-2 z-depth-0 waves-effect" type="button"  data-toggle="modal" data-target="#create_group">Create a group</button>
              <?php } ?>
            </div>
          </div>
          <div class="card wide overflow-auto" id="message_header" style="height: 80vh;">
          </div><!-- Card -->
        </div> <!--Column-->
        <div class="col-lg-8">
          <div class="card chat-room small-chat wide" id="message_body" style="height: 85vh;">
          </div><!--Card-->
        </div><!--Column-->
      <?php } ?>
      </div><!--Row-->
    </section>
  </div><!--Contaier-->
</main>
<!-- Create Chat -->
<div data-backdrop="static" class="modal fade" id="send_chat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Create Message</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="formGroupExampleInput">* Select Name</label>
          <select name="email" id="email" class="select2" style="width: 100%;">
            <?php foreach ($users as $row) { ?>
              <option value='<?php echo $row['id']; ?>'><?php echo ucwords($row['first_name']); ?> <?php echo ucwords($row['last_name']); ?></option>
            <?php } ?>
          </select>
        </div>
        <textarea class="textarea" name="chat_message" id="create_message" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
      </div><!--Modal Body-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-primary waves-effect float-right" type="submit" id="createamessage">Send Message</button>
      </div>
    </div><!--Content-->
  </div>
</div>
<!-- Create Group -->
<div data-backdrop="static" class="modal fade" id="create_group" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Create Group</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <?php echo form_open_multipart('messages/create_group'); ?>
      <div class="modal-body">
        <div class="form-group">
          <label for="formGroupExampleInput">* Enter Group Name</label>
          <input type="text" class="form-control" name="group_name" id="group_name">
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">* Members</label>
          <select name="members[]" id="members" class="select2" multiple="multiple" data-placeholder="Select members" style="width: 100%;">
          </select>
        </div>
      </div><!--Modal Body-->
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-primary waves-effect float-right" type="submit">Create Group</button>
      </div>
      <?php echo form_close(); ?>
    </div><!--Content-->
  </div>
</div>
<!-- View Members -->
<div data-backdrop="static" class="modal fade" id="view_members" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-md modal-notify modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Members</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group list-group-flush" id="list_members">
        </ul>
      </div><!--Modal Body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div><!--Content-->
  </div>
</div>
<!-- Add Members -->
<div data-backdrop="static" class="modal fade" id="add_members" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-md modal-notify modal-success" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Members</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
        <label for="formGroupExampleInput">* Enter Username</label>
          <input type="hidden" class="form-control" name="group" id="group">
          <input type="email" class="form-control" name="username" id="username">
        </div>
      </div><!--Modal Body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button class="btn btn-primary waves-effect btn-sm float-right" type="submit" id="add_member">Add Member</button>
      </div>
    </div><!--Content-->
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  $("#search_user").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#message_header .start_chat").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

  var on_interval = true;
  get_message_header();
  get_user_status();
 
  setInterval(function(){
    if(on_interval) {
      update_chat_history_data();
    }
    get_user_status();
  }, 5000);

  function get_user_status(){
    $.ajax({
      type  : 'post',
      url   : "<?=base_url()?>messages/get_users_status",
      async : true,
      dataType : 'json',
      success : function(data){
        var html = '';
        var i;
        for(i=0; i<data.length; i++){
          var date = new Date(data[i].status);
          var now = new Date();
          var FIVE_MIN=1*60*1000;

          // if one minute ago
          if((now - new Date(date)) > FIVE_MIN) {
            $('.last_login_'+data[i].user_ID).html(data[i].last_login);
          } else {
            $('.last_login_'+data[i].user_ID).html('<i class="fas fa-circle text-success"></i>');
          }
          if(data[i].count != 0){
            $('.new_messages_'+data[i].user_ID).show();
            $('.snippet_'+data[i].user_ID).html(data[i].snippet);
            $('.new_messages_'+data[i].user_ID).html(data[i].count);
          } else {
            $('.new_messages_'+data[i].user_ID).hide();
          }
        }
      }
    });
  }

  function get_message_header(){
    $.ajax({
      type  : 'post',
      url   : "<?=base_url()?>messages/get_message_header",
      dataType : 'json',
      success : function(data){
        var html = '';
        var i;
        for(i=0; i<data.length; i++){
          html += '<a class="start_chat header_'+data[i].data_id+'" data-header-id="'+data[i].id+'" data-id="'+data[i].data_id+'" data-name="'+data[i].name+'" data-type="'+data[i].type+'"  data-username="'+data[i].username+'"><div class="card-body d-flex flex-row message_header';
        if(i == 0){
          html += ' bg-light';
        }
        html += '" id="message_header_'+data[i].id+'"><img src="'+data[i].image+'" class="rounded-circle mr-2 chat-mes-id-2" alt="avatar" style="height: 50px;width: 50px;" onerror="this.onerror=null;this.src=\'<?php echo base_url();?>assets/img/users/stock.jpg\';"><div><h6 class="user_names">'+data[i].name+'<span class="badge badge-danger badge-pill ml-2 new_messages_'+data[i].data_id+'"></span></h6>';
        if("level" in data[i]){
        html += '<img src="<?php echo base_url(); ?>assets/img/'+data[i].level_image+'" class="rounded-circle" height="25px" width="25px" alt="avatar">Level '+data[i].level+'<span class="ml-2 text-muted last_login_'+data[i].data_id+'" style="font-size: 12px;"></span><br><span class="text-muted snippet_'+data[i].data_id+'"></span>';
        }
          html += '</div></div></a>';
        }
        $('#message_header').html(html);
      }
    });
  }

  $(document).on('click', '.start_chat', function(){
    var header = $(this).data('header-id');
    var data_ID = $(this).data('id');
    var name = $(this).data('name');
    var username = $(this).data('username');
    // type = 1 = user else group.
    var type = $(this).data('type');
    make_message_dialog_box(data_ID, name, type, username);
    $('#message_header_'+header).addClass("bg-light");
    $('.message_header').not("#message_header_"+header).removeClass("bg-light"); 
    on_interval = true;

    $('#message_menu').hide();
    $('#message_content').animate({ width: 'show' });

    $('#scroll_to_bottom').stop().animate({
      scrollTop: $('main')[0].scrollHeight
    }, 500);

  });


  $(document).on('click', '.conversation_toogle', function(){
    $('#message_content').hide();
    $('#message_menu').animate({ width: 'show' });
  });


  function make_message_dialog_box(data_ID, name, type, username) {
    start = 0;
    var message_content = '<div class="card-header d-flex justify-content-between p-2 fixed"><?php if(isMobile()) { ?><a class="conversation_toogle m-0 p-0"><i class="fas fa-arrow-left"></i></a><?php } ?>';
    if(username){
      message_content += '<a class="mb-0" href="<?php echo base_url(); ?>'+username+'"><strong>'+name+'</strong></a>';
    } else {
      message_content += '<p class="mb-0"><strong>'+name+'</strong></p>';
    }
    
    if(type == 2){
      <?php if(!empty($my_purchases)){?>
        message_content += '<div class="icons grey-text"><a class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-info-circle"></i></a><div class="dropdown-menu dropdown-menu-right dropdown-default"><a class="dropdown-item add_new_member" data-id="'+data_ID+'">Add Member <i class="fas fa-user-plus mr-2"></i></a><a class="dropdown-item view_members" data-id="'+data_ID+'">View Members <i class="fas fa-users mr-2"></i></a><a class="dropdown-item leave_group red-text" data-group-id="'+data_ID+'">Leave Group <i class="fas fa-sign-out-alt"></i></a></div></div>';
      <?php } ?>
    }
    message_content += '</div><div class="my-custom-scrollbar overflow-auto p-3" id="scroll_to_bottom"><a><p class="text-center blue-text font-italic view_more" data-to-id="'+data_ID+'" data-type="'+type+'" hidden>View More</p></a><div data-type="'+type+'" data-to-id="'+data_ID+'" class="message_content" id="message_content_'+data_ID+'">';
    get_message_content(data_ID, type, start);
    message_content += '</div></div><div class="card-footer text-muted pt-1 pb-2 px-3" style="margin-top: auto;"><div class="d-flex justify-content-center"><div class="replying"></div><a class="clear_replay font-weight-bold red-text ml-5" style="display: none;">X</a></div><textarea type="textarea" class="textarea_post" name="messages" id="messages"></textarea><button class="btn btn-primary btn-sm send_message float-right" data-to-id="'+data_ID+'" data-message-id="0" data-type="'+type+'">Send</button></div>';
    $('#message_body').html(message_content);
    if(type == 1){
      create_editor();
    } else {
      create_editor_group(data_ID);
    }
  }

  function get_message_content(data_ID, type, start){
    $.ajax({
      method  : 'post',
      url   : "<?=base_url()?>messages/get_messages",
      dataType : 'json',
      async : true,
      data:{id:data_ID, start:start, type:type},
      success : function(data){
        if(data.length >= 9){
          $('.view_more').prop( "hidden", false ); 
        }
        var html = message_content(data, type);
        $('#message_content_'+data_ID).html(html);
      }
    });
  }

  function message_content(data, type){
    var html = '';
    var i;
    for(i=0; i<data.length; i++){
      if($('.message_box_'+data[i].message_ID).length === 0){
        if(data[i].from_ID == <?php echo $my_info['id']; ?>){
          html += '<div class="d-flex justify-content-end align-items-center messsage_box_'+data[i].message_ID+'">'
          if(data[i].message_status == '2'){
            html += '<div class="card bg-white rounded-pill w-50 text-right z-depth-0 mb-1"><div class="card-body"><p class="card-text dark-text font-italic">This message has been removed.</p></div></div>';
          } else {
            html += '<div class="card rounded z-depth-0 mb-1" style="max-width: 60%; background: #CBDAEF;"><div class="card-body p-2">';
            if(data[i].parent_message != 0){
              html += '<div class="text-muted ml-3" style="font-size: 16px;">'+data[i].parent_message_content+'</div><p class="text-muted text-left ml-3" style="font-size: 12px;">You replied to '+data[i].parent_message_sender+' '+data[i].parent_message_timestamp+'</p><hr class="mt-1 mb-3">';
            }
            html += '<p class="dark-text" style="font-size: 16px;">'+data[i].message+'</p></div><p class="text-muted p-2 text-right" style="font-size: 12px;">'+data[i].timestamp+'<a class="delete_message" data-message-id="'+data[i].message_ID+'" data-type="'+type+'"><span class="red-text p-2">&times;</span></a></p></div>';
          }
          html += '</div>';
          if(data[i].message_status == '1' && data[i].max == data[i].i){
            html += '<p class="text-muted font-italic text-right pr-3" style="font-size: 12px;">Seen</p>';
          }
        } else {
          html += '<div class="d-flex justify-content-start mb-1 align-items-center messsage_box_'+data[i].message_ID+'">';
          html += '<div class="profile-photo message-photo"><a href="<?php echo base_url(); ?>'+data[i].username+'"><img src="'+data[i].image+'" alt="avatar" class="rounded-circle avatar mr-2 ml-0 chat-mes-id-2" style="height: 50px;width: 50px" onerror="this.onerror=null;this.src=\'<?php echo base_url();?>assets/img/users/stock.jpg\';"></a><span class="state"></span></div>';
          if(data[i].message_status == '2'){
            html += ' <div class="card bg-white rounded-pill z-depth-0 mb-1 message-text w-50"><div class="card-body"><p class="card-text text-black font-italic">This message has been removed.</p></div></div></div>';
          } else {
            html += '<div class="card border border-light bg-white rounded z-depth-0 mb-1 message-text" style="max-width: 60%"><div class="card-body p-2">';
            if(data[i].parent_message != 0){
              html += '<div class="text-muted ml-3" style="font-size: 16px;">'+data[i].parent_message_content+'</div><p class="text-muted text-left ml-3" style="font-size: 12px;">You replied to '+data[i].parent_message_sender+' '+data[i].parent_message_timestamp+'</p><hr class="mt-1 mb-3">';
            }
            html += '<p class="card-text black-text" style="font-size: 12px;">'+data[i].name+'</p><div class="black-text message_'+data[i].message_ID+'" style="font-size: 16px;">'+data[i].message+'</div></div><p class="card-text text-muted p-1 ml-2 text-left" style="font-size: 12px;">'+data[i].timestamp+'</p></div><a class="replay ml-2" data-message-id="'+data[i].message_ID+'" data-type="'+type+'"><i class="fas fa-reply"></i></a></div>';
          }
        }
      } else {
        return false;
      }
    }
    return html;
  }

  $(document).on('click', '.replay', function(){
    var message_ID = $(this).data('message-id');
    var messages = $(".message_"+message_ID).text();
    $(".replying").text(messages);
    $(".send_message").data("message-id", message_ID);
    $(".clear_replay").show();
  });

  $(document).on('click', '.clear_replay', function(){
    $(".replying").text('');
    $(".clear_replay").hide();
  });

  var start = 10;
  $(document).on('click', '.view_more', function(){
    var to_ID = $(this).data('to-id');
    var type = $(this).data('type');
    if(start == 0){
      start = 10;
    }
    $.ajax({
      method  : 'post',
      url   : "<?=base_url()?>messages/get_messages",
      dataType : 'json',
      async : true,
      data:{id:to_ID, start:start, type:type},
      beforeSend:function(){
        $(".view_more").text("Loading...");
      },
      success: function(data){
        var html = message_content(data);
        $('#message_content_'+to_ID).prepend(html);
        start = start + 10;
        $(".view_more").text("View More");
        if(!$.trim(data)) {
          $(".view_more").hide();
        }
        on_interval = false;
      }
    });
  });

  //Create Message
  $('#createamessage').on('click',function(){
    var email=$('#email').val();
    var mes=$('#create_message').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>messages/create_message",
      dataType : "JSON",
      data : {user_ID:email , chat_message:mes},
      success: function(data){
        if(data.error){
          toastr.error(data.message);
        } else {
          toastr.success('Message Sent.');
          $('[name="email"]').val("");
          $('#create_message').val("");
          $('#send_chat').modal('hide');
          get_message_header();
        }
      }
    });
    return false;
  });

  $(document).on('click', '.send_message', function(){
    var to_ID = $(this).data('to-id');
    var message_ID = $(this).data('message-id');
    var type = $(this).data('type');
    var message = CKEDITOR.instances['messages'].getData();
    <?php if(!empty($my_purchases)){?>
      if(message != ''){
        $.ajax({
          url:"<?=base_url()?>messages/send_message",
          method:"POST",
          async : true,
          dataType : 'json',
          data:{to_ID:to_ID, message:message, message_ID:message_ID, type:type},
          success:function(data) {
            level_up.play();
            toastr.success(' 1 Exp Gained!');
            get_message_content(to_ID, type, start);
            get_message_header();
            CKEDITOR.instances['messages'].setData('');
            $(".replying").text('');
            $(".clear_replay").hide();
            $(".send_message").data("message-id", 0);
          }
        })
      } else {
        error_sound.play();
        toastr.error('Enter a message');
      }
    <?php } else { ?>
      toastr.error('Forbidden. You haven\nt bought any courses!'); 

    <?php } ?>
  });

  function update_chat_history_data(){
    var data_ID = $('.message_content').data('to-id');
    var type = $('.message_content').data('type');
    get_message_content(data_ID, type, 0);
  }

  $(document).on('click', '.delete_message', function(){
    var message_ID = $(this).data('message-id');
    var type = $(this).data('type');
    if(confirm("Are you sure you want to remove this message?")){
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>messages/delete_message",
        dataType : "JSON",
        async : true,
        data : {message_ID:message_ID, type:type},
        success: function(data){
          toastr.success('Message Deleted');
          update_chat_history_data();
        }
      });
    }
  });

  //View members
  $(document).on('click', '.view_members', function(e) {
    var id=$(this).data('id');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>messages/get_group_members",
      dataType : "JSON",
      data : {group_ID:id},
      success: function(data){
        var html = '';
        var i;
        for(i=0; i<data.length; i++){
          html += '<li class="list-group-item"><a href="<?php echo base_url(); ?>'+data[i].username+'">'+data[i].fullname+'</a>';
          if(data[i].owner == <?php echo $my_info['id']; ?>){
            html +=  '<a class="mute_member float-right" data-status="'+data[i].status+'" data-member-id="'+data[i].id+'">';
            if(data[i].status == 1){
              html +=  '<i class="fas fa-microphone blue-text"></i>';
            } else{
              html +=  '<i class="fas fa-microphone-slash red-text"></i>';
            }
            html +=  '</a>';
            html +=  '<a class="float-right delete_member" data-member-id="'+data[i].id+'"><i class="fas fa-trash red-text mr-2"></i></a>';
          }
          html += '</li>';
        }

        $('#view_members').modal('show');
        $('#list_members').html(html);
      }
    });
    return false;
  });

  //Add Members 
  $(document).on("click", ".add_new_member", function() { 
    var id=$(this).data('id');
    $('#add_members').modal('show');
    $('[name="group"]').val(id);
  });

  //Add member
  $('#add_member').on('click',function(){
    var username = $('#username').val();
    var group = $('[name="group"]').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>messages/add_member",
      dataType : "JSON",
      data : {username:username, group_id:group},
      success: function(data){
        toastr.success('Member Added');
        $('#add_members').modal('hide');
      }
    });
    return false;
  });

  function create_editor() {
    CKEDITOR.config.disableNativeSpellChecker = false;
    CKEDITOR.replace('messages', {
      forcePasteAsPlainText : true,       
      plugins: 'mentions,emoji,basicstyles,undo,link,wysiwygarea,toolbar, pastetext',
      height: 60,
      width: 500,
      width: '99%',
      toolbar: [{name: 'document', items: ['Undo', 'Redo']},{name: 'links', items: ['EmojiPanel', 'Link', 'Unlink']}]
    });
  }

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

  var users;
  tags = [];
  function create_editor_group(id) {
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>messages/get_group_members",
      dataType : "JSON",
      data : {group_ID:id},
      success: function(data){
        users = data;
      }
    });
    
    CKEDITOR.config.disableNativeSpellChecker = false;
    CKEDITOR.replace('messages', {
      forcePasteAsPlainText : true,       
      plugins: 'mentions,emoji,basicstyles,undo,link,wysiwygarea,toolbar, pastetext',
      height: 60,
      width: 500,
      width: '99%',
      toolbar: [{name: 'document', items: ['Undo', 'Redo']},{name: 'links', items: ['EmojiPanel', 'Link', 'Unlink']}],
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

   //mute member
  $(document).on('click', '.mute_member', function(){
    var member_ID = $(this).data('member-id');
    var status = $(this).data('status');
    if(status == 1){
      var message = "Are you sure you want to mute this member?";
      new_status = '0';
    } else {
      var message = "Are you sure you want to unmute this member?";
      new_status = '1';
    }
    alert_sound.play();
    if(confirm(message)){
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>messages/mute_member",
        dataType : "JSON",
        data : {status:new_status, member_ID:member_ID},
        success: function(data){
          if(status == 1){
            toastr.success('Member Muted');
          } else {
            toastr.success('Member Unmuted');
          }
          $('#view_members').modal('hide');
        }
      });
      return false;
    }
  });

  // Delete member
  $(document).on('click', '.delete_member', function(){
    var member_ID = $(this).data('member-id');
    alert_sound.play();
    if(confirm('Are you sure you want to remove this member?')){
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>messages/remove_member",
        dataType : "JSON",
        data : {member_ID:member_ID},
        success: function(data){
          toastr.success('Member Has been remove');
          $('#view_members').modal('hide');
        }
      });
    }
  });

  $(document).on('click', '.leave_group', function(){
    var group_ID = $(this).data('group-id');
    alert_sound.play();
    if(confirm('Are you sure you want to leave this group?')){
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>messages/leave_group",
        dataType : "JSON",
        data : {group_ID:group_ID},
        success: function(data){
          toastr.success('You left the group!');
          $(".start_chat").remove();
        }
      });
    }
  });
});
</script>