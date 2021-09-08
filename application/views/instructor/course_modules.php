<div class='preloader' id="preloader" style='display:none'>
  <h1 class="mr-4">Loading...</h1>
  <h2 class="mr-4">Changing status of its sections, lessons, and contents as well</h2>
  <img src='<?php echo base_url(); ?>assets/img/ajax-loader.gif'/>
</div>
<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>instructor">Home</a></span>
        <span>/</span>
        <span><a href="<?php echo base_url();?>instructor/course">Course</a></span>
        <span>/</span>
        <span><?php echo ucwords($course['title']);?></span>
      </h4>
      <h4 class="mb-2 mb-sm-0 pt-1 float-right">
        <span><a href="<?php echo base_url();?>instructor/course">Back</a></span>
      </h4>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h4 class="mb-2">
            <span>Modules</span>
            <a href="<?php echo base_url();?>course/<?php echo $course['slug'];?>" class="btn btn-info m-0 px-3 py-2 z-depth-0 waves-effect" target="_blank"><i class="fas fa-eye"></i> Preview</a>
          </h4>
          <table class="table table-bordered table-responsive-md" cellspacing="0" width="100%">
            <thead>
              <th style="width: 10%;">Sort Number</th>
              <th style="width: 30%;">Title</th>
              <th style="width: 10%;">Status</th>
              <th style="width: 20%;">Last Modified</th>
              <th style="width: 30%;"></th>
            </thead>
            <tbody id="modules">
            <?php $i=1; foreach ($modules as $module){ ?>
              <?php if($module['status'] == 0 || $module['status'] == 1){ ?>
                <tr class="modules_header module_<?php echo $module['id'];?>" data-id="<?php echo $module['id'];?>" data-order="<?php echo $i;?>">
                  <td style="cursor: all-scroll;" class="order"><?php echo $i;?></td>
                  <td class="module_title_<?php echo $module['id'];?>"><?php echo ucfirst($module['title']);?></td>
                  <td>
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input status_switch" id="status_switch_<?php echo $module['id'];?>" <?php echo ($module['status'] == '1') ? 'checked' : '' ?> data-id="<?php echo $module['id'];?>">
                      <label class="custom-control-label" for="status_switch_<?php echo $module['id'];?>">
                        <?php if($module['status'] == '0'){?>
                          <span class="badge badge-pill badge-warning status_switch_label_<?php echo $module['id'];?>">Hidden</span>
                        <?php } else { ?>
                          <span class="badge badge-pill badge-success status_switch_label_<?php echo $module['id'];?>">Active</span>
                        <?php } ?>
                      </label>
                    </div>
                  </td>
                  <td><span hidden><?php echo date("Y-m-d", strtotime($module['date_modified']));?></span><?php echo date("F d, Y h:i A", strtotime($module['date_modified']));?></td>
                  <td>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <a class="btn btn-sm btn-success" href='<?php echo base_url(); ?>instructor/course/<?php echo $course['slug'];?>/<?php echo $module['slug'];?>'>Edit</a>
                        <a class="btn btn-sm btn-primary edit_module" data-id="<?php echo $module['id']; ?>">Rename</a>
                        <a class="btn btn-sm btn-secondary copy_module" data-id="<?php echo $module['id']; ?>">Copy</a>
                        <a class="btn btn-sm btn-danger delete_module" data-id="<?php echo $module['id']; ?>">Delete</a>
                      </div>
                    </div>
                  </td>
                </tr>
              <?php $i++; } ?>
            <?php } ?>
            </tbody>
          </table>
          <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#createlesson">Create Module</a>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main><!--Main laypassed out-->

<!-- Create Module -->
<div class="modal fade" id="createlesson" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Create Module</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <?php echo form_open_multipart('courses/create_module'); ?>
        <div class="form-group">
          <label for="formGroupExampleInput">* Title</label>
          <input type="text" class="form-control" name="module_title" required>
          <input type="hidden" class="form-control" name="course_ID" value="<?php echo $course['course_ID'];?>">
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-success waves-effect"><i class="fa fa-check-square-o"></i>Save</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>

<!-- Module Edit -->
<div data-backdrop="static" class="modal fade" id="edit_module" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg modal-notify modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Edit Module</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>      
      <div class="modal-body">
        <div class="form-group">
          <label>* Module title</label>
          <input type="hidden" class="form-control" name="edit_module_ID" id="edit_module_ID">
          <input type="text" class="form-control" name="edit_module_title" id="edit_module_title" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm" type="submit" id="update_module">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Module Edit -->

<!-- Copy Modules -->
<div data-backdrop="static" class="modal fade" id="copy_module_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-secondary" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Copy Modules To</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="hidden" class="form-control" name="copy_module_ID" id="copy_module_ID">
          <select class="browser-default custom-select select_course" name="copy_to_course" id="copy_to_course"required>
            <option selected disabled>Choose Course</option>
            <?php foreach($courses as $row){ ?>
              <option value="<?php echo $row['course_ID']; ?>"><?php echo ucwords($row['title']); ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm" id="copy_module">Copy</button>
      </div>
    </div>
  </div>
</div>
<!-- Copy Modules -->
<script type="text/javascript">
$(document).ready(function() {
  $("#modules").sortable({
    placeholder : "ui-state-highlight",
    update  : function(event, ui){
      var module_order = new Array();
      $('#modules .modules_header').each(function(){
        module_order.push($(this).data("id"));
      });
      $.ajax({
        url:"<?=base_url()?>courses/sort_module",
        method:"POST",
        data:{module_order:module_order},
        success:function(data){
        }
      });
    }
  });
});
</script>
<script type="text/javascript">
$(document).ready(function() {
  $(".status_switch").click(function() {
    var id=$(this).data('id');
    if(confirm("Are you sure you want to change status of this Module?")){
      if($(this).is(":checked")){
        $('.status_switch_label_'+id).removeClass("badge-warning").addClass("badge-success").text('Active');
        $(this).val(1);
        change_status(id, '1');
      } else {
        $('.status_switch_label_'+id).removeClass("badge-success").addClass("badge-warning").text('Hidden');
        $(this).val(0);
        change_status(id, '0');
      }
    }
  });

  function change_status(module_ID, status){
    $('#preloader').show();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/update_module_status",
      dataType : "JSON",
      data : {module_ID:module_ID, status:status},
      success: function(data){
        $('#preloader').hide();
        return true;
      }
    });
  }

  $(document).on("click", ".delete_module", function() { 
    var id=$(this).data('id');
    alert_sound.play();
    if(confirm("Are you sure you want to delete this content?")){
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>courses/delete_module",
        dataType : "JSON",
        data : {module_ID:id},
        success: function(data){
          $('#delete_module_modal').modal('hide');
          toastr.error('Section Deleted');
          $(".module_"+id).empty();
        }
      });
    }
  });

  $(document).on("click", ".edit_module", function() { 
    var module_ID=$(this).data('id');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/get_module",
      dataType : "JSON",
      data : {module_ID:module_ID},
      success: function(data){
        $('#edit_module').modal('show');
        $('[name="edit_module_title"]').val(data.title);
        $('[name="edit_module_ID"]').val(module_ID);
        $('[name="module_status"]').val(data.status);
        $('.switch_label').text('Hidden');
        if(data.status == 1){
          $('#module_status').attr("checked", "checked");
          $('.switch_label').text('Active');
        }
      }
    });
  });

  //update module
  $('#update_module').on('click',function(){
    var title = $('#edit_module_title').val();
    var id = $('#edit_module_ID').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/update_module",
      dataType : "JSON",
      data : {module_ID:id , module_title:title},
      success: function(data){
        if(data.error){
          toastr.error(data.message);
          error_sound.play();
        } else {
          toastr.success('Module title updated.');
          $('[name="edit_module_title"]').val("");
          $('[name="edit_module_ID"]').val("");
          $('[name="module_status"]').val("");
          $('[name="module_status"]').val("");
          $('.module_title_'+id).text(title);
          $('#edit_module').modal('hide');
        }
      }
    });
  });

  $(document).on("click", ".copy_module", function() { 
    var id=$(this).data('id');
    $('#copy_module_modal').modal('show');
    $('[name="copy_module_ID"]').val(id);
  });

  //update module
  $('#copy_module').on('click',function(){
    var course_ID = $('#copy_to_course').val();
    var module_ID = $('#copy_module_ID').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/copy_module",
      dataType : "JSON",
      data : {module_ID:module_ID, course_ID:course_ID},
      success: function(data){
        if(data == false){
          toastr.error('Module title already exist!');
        } else {
          toastr.success('Module copied successfully!');
        }
        $('#copy_module_modal').modal('hide');
      }
    });
  });
});
</script>