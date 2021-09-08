<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>instructor">Home</a></span>
        <span>/</span>
        <span><a href="<?php echo base_url();?>instructor/course">Course</a></span>
        <span>/</span>
        <span><a href="<?php echo base_url();?>instructor/course/<?php echo ucwords($course['slug']);?>"><?php echo ucwords($course['title']);?></a></span>
        <span>/</span>
        <span><?php echo ucwords($module['title']);?></span>
      </h4>
    </div>
  </div>
  <!-- Heading -->
  <div class="row">
    <div class="col-md-12 mb-4">
      <div class="accordion md-accordion accordion-blocks" id="accordionEx78" role="tablist" aria-multiselectable="true">
        <?php foreach ($sections as $section) {?>
        <div data-section-id="<?php echo $section['id']; ?>" class="card sortsection">
          <div class="card-header" role="tab" id="mainsection<?php echo $section['id'];?>">
            <div class="float-right">
              <?php if($section['status'] == 1){ ?>
                <span class="badge badge-pill mr-2 badge-info">Active</span>
              <?php } else { ?>
                <span class="badge badge-pill mr-2 badge-warning">Hidden</span>
              <?php } ?>
              <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                <a type="button" class="btn btn-primary btn-sm edit_section" data-id="<?php echo $section['id'];?>"><i class="fas fa-pencil-alt"></i></a>
                <button type="button" class="btn btn-danger btn-sm delete_section" data-id="<?php echo $section['id'];?>"><i class="fas fa-trash-alt"></i></button>
                <a type="button" class="btn btn-secondary btn-sm copy_section" data-id="<?php echo $section['id'];?>"><i class="fas fa-copy"></i></a>
              </div>
            </div>
            <a data-toggle="collapse" data-parent="#accordionEx78" href="#section<?php echo $section['id'];?>" aria-expanded="true"
              aria-controls="section<?php echo $section['id'];?>">
              <h3 class="mt-1 mb-0">
                <span style="cursor: all-scroll;"><?php echo $section['title'];?></span>
                <i class="fas fa-angle-down rotate-icon"></i>
              </h3>
            </a>
          </div><!-- Card Header -->
          <div id="section<?php echo $section['id'];?>" class="collapse show" role="tabpanel" aria-labelledby="mainsection<?php echo $section['id'];?>"
            data-parent="#accordionEx78">
            <div class="card-body sortablelessons">
              <?php foreach ($lessons as $lesson) {?>
                <?php if ($section['id'] == $lesson['section_ID']) {?>
                  <div class="accordion md-accordion sortlessons" id="mainlesson<?php echo $lesson['id'];?>" role="tablist" aria-multiselectable="true" style="padding-left: 15px;" data-lesson-id="<?php echo $lesson['id']; ?>">
                    <div class="float-right">
                      <?php if($lesson['status'] == 1){ ?>
                        <span class="badge badge-pill mr-2 badge-info">Active</span>
                      <?php } else { ?>
                        <span class="badge badge-pill mr-2 badge-warning">Hidden</span>
                      <?php } ?>
                      <a class="add_content" data-lesson-id="<?php echo $lesson['id'];?>"><i class="fas fa-plus green-text"></i></a>
                      <a class="edit_lesson" data-id="<?php echo $lesson['id'];?>"><i class="fas fa-pencil-alt blue-text"></i></a>
                      <a class="delete_lesson" data-id="<?php echo $lesson['id'];?>"><i class="fas fa-trash-alt red-text"></i></a>
                      <a class="copy_lesson" data-id="<?php echo $lesson['id'];?>"><i class="fas fa-copy text-secondary"></i></a>
                    </div>
                    <a data-toggle="collapse" data-parent="#mainlesson<?php echo $lesson['id'];?>" href="#lesson<?php echo $lesson['id'];?>" aria-expanded="true"
                      aria-controls="lesson<?php echo $lesson['id'];?>">
                      <h4 class="mt-1 mb-0">
                        <span style="cursor: all-scroll;"><?php echo $lesson['title'];?></span>
                         <i class="fas fa-angle-down rotate-icon"></i>
                      </h4>
                    </a>
                    <div id="lesson<?php echo $lesson['id'];?>" class="collapse show" role="tabpanel" aria-labelledby="mainsection<?php echo $section['id'];?>" data-parent="#mainlesson<?php echo $lesson['id'];?>">              
                      <div class="sortablecontent" style="padding-left: 25px;">
                        <?php foreach ($contents as $content) {?>
                          <?php if ($lesson['id'] == $content['lesson_ID']) {?>
                          <div class="row sortcontent" data-content-id="<?php echo $content['id']; ?>">
                            <ul class="list-group align-middle" role="tablist" style="padding-left: 25px;">
                              <li style="cursor: all-scroll; padding: 0;margin: 0;" class="border-bottom sortcontentpart" ><h5><?php echo $content['title'];?></h5> </li>
                            </ul>
                            <div class="col-4 float-right">
                              <?php if($content['status'] == 1){ ?>
                                <span class="badge badge-pill mr-2 badge-info">Active</span>
                              <?php } else { ?>
                                <span class="badge badge-pill mr-2 badge-warning">Hidden</span>
                              <?php } ?>
                              <a class="edit_content" data-id="<?php echo $content['id'];?>"><i class="fas fa-pencil-alt blue-text"></i></a>
                              <a class="delete_content" data-id="<?php echo $content['id'];?>"><i class="fas fa-trash-alt red-text"></i></a>
                              <a class="copy_content" data-id="<?php echo $content['id'];?>" data-section-id="<?php echo $section['id'];?>"><i class="fas fa-copy text-secondary"></i></a>
                            </div>
                          </div>
                          <?php } ?>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              <?php } ?>
              <?php echo form_open_multipart('courses/create_lesson'); ?>
              <div class="row pt-3">
                <div class="col-md-6">
                  <div class="input-group mb-3">
                    <input type="hidden" class="form-control" name="section_ID" value="<?php echo $section['id'];?>">
                    <input type="text" class="form-control" placeholder="Lesson Name" aria-label="Lesson Name" aria-describedby="button-addon2" name="lesson_title">
                    <div class="input-group-append">
                      <button class="btn btn-md btn-success m-0 px-3 py-2 z-depth-0 waves-effect">Add</button>
                    </div>
                  </div>
                </div>
              </div>
              <?php echo form_close(); ?>
            </div>
          </div>
        </div><!-- Accordion card -->    
      <?php } ?>
      </div>
    </div><!--Grid column-->
  </div><!--Grid row-->

  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <?php echo form_open_multipart('courses/create_section'); ?>
          <div class="input-group">
            <input type="hidden" class="form-control" name="module_ID" value="<?php echo $module['id'];?>">
            <input type="text" class="form-control" placeholder="Section" aria-label="Section"
              aria-describedby="button-addon2" name="section_title" id="section_title">
            <div class="input-group-append">
              <button class="btn btn-md btn-success m-0 px-3 py-2 z-depth-0 waves-effect" id="submit_section">Add</button>
            </div>
          </div>
          <?php echo form_close(); ?>
        </div><!--Card-body-->
      </div><!--Card-->
    </div><!--Column-->
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <a type="button" class="btn btn-primary m-0 px-3 py-2 z-depth-0 waves-effect" data-toggle="modal" data-target="#create_lessons">Create Content Shortcut</a>
        </div><!--Card-body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main><!--Main laypassed out-->
<!-- Are you sure -->
<div data-backdrop="static" class="modal fade" id="create_lessons" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-success modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Create Content</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart('courses/create_content'); ?>
        <input type="hidden" class="form-control" name="module_ID" value="<?php echo $module['id'];?>">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
                <select class="browser-default custom-select select_section" name="select_section" id="select_section" required>
                </select>
            </div>
            <div class="form-group">
              <select class="browser-default custom-select select_lesson" name="select_lesson" id="select_lesson" required>
                <option selected disabled>Select Lesson</option>
              </select>
            </div> 
          </div><!--Col-->
        </div><!--Row-->
        <div class="row">
          <div class="col-md-12">
            <div id="dynamic_content">
            </div>
            <button class="btn btn-default waves-effect" id="add_another_content" type="button">Add Another Content</button>
          </div><!--Col-->
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-success waves-effect float-right" type="submit">Save Content</button>
      </div>
      <?php echo form_close(); ?>
    </div><!--/.Content-->
  </div>
</div>
<!-- Section Edit -->
<div data-backdrop="static" class="modal fade" id="sectionedit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Edit Section Name</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="formGroupExampleInput">* Section Name</label>
          <input type="hidden" class="form-control" name="edit_section_ID">
          <input type="text" class="form-control mb-4" name="edit_section_title">
          <label for="section_status">* Status</label>
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input customSwitches" name="section_status" id="section_status">
            <label class="custom-control-label switch_label" for="section_status"></label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm" id="update_section">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Section Edit -->

<!-- Section Delete -->
<div data-backdrop="static" class="modal fade" id="delete_section_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Delete Section</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this section?
           lesson and content of this section will also be delete.</p>
        <input type="hidden" class="form-control" name="delete_section_ID" id="delete_section_ID" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="delete_section">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- Section Delete -->

<!-- Lesson Edit -->
<div data-backdrop="static" class="modal fade" id="edit_lesson_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Update Lesson</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>      
      <div class="modal-body">
        <div class="form-group">
          <label for="formGroupExampleInput">* Lesson Name</label>
          <input type="hidden" class="form-control" name="edit_lesson_ID" id="edit_lesson_ID">
          <input type="text" class="form-control" name="edit_lesson_title" id="edit_lesson_title">
        </div>
        <label for="lesson_status">* Status</label>
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input customSwitches" id="lesson_status" name="lesson_status">
          <label class="custom-control-label switch_label" for="lesson_status"></label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm" id="update_lesson">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Lesson Edit -->

<!-- Lesson Delete -->
<div data-backdrop="static" class="modal fade" id="delete_lesson_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Delete Lesson</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this lesson along with its content?</p>
        <input type="hidden" class="form-control" name="delete_lesson_ID" id="delete_lesson_ID">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="delete_lesson">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- Lesson Delete -->

<!-- Add Content -->
<div data-backdrop="static" class="modal fade" id="add_content_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-notify modal-success modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Create Content</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <?php echo form_open_multipart('courses/create_content'); ?>
        <input type="hidden" class="form-control" name="select_lesson" id="selected_lesson">
        <div id="dynamic_content_2">
        </div>
        <button class="btn btn-default waves-effect" id="add_another_content_2" type="button">Add Another Content</button>
      </div>
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
        <button class="btn btn-success waves-effect float-right" type="submit">Save Content</button>
      </div>
      <?php echo form_close(); ?>
    </div><
  </div>
</div>
<!-- Add Content -->

<!-- Content Edit -->
<div data-backdrop="static" class="modal fade" id="edit_content_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-notify modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Edit Module</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>      
      <div class="modal-body">
      <?php echo form_open_multipart('courses/update_content'); ?>
        <div class="form-group">
          <label>* Content Title</label>
          <input type="hidden" class="form-control" name="edit_content_ID" id="edit_content_ID">
          <input type="text" class="form-control mb-4" name="edit_content_title" id="edit_content_title">
          <label for="content_status">* Status</label>
          <div class="custom-control custom-switch mb-4">
            <input type="checkbox" class="custom-control-input customSwitches" id="content_status" name="content_status">
            <label class="custom-control-label switch_label" for="content_status"></label>
          </div>
          <div class="form-group">
            <label for="contentitle">Video URL <h6 class="red-text">NOTE: URLs from youtube and vimeo are allowed</h6></label>
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="edit_content_url" id="edit_content_url"
                aria-describedby="button-addon2">
              <div class="input-group-append">
                <button class="btn btn-md btn-outline-primary m-0 px-3 py-2 z-depth-0 waves-effect" type="button" data-toggle="modal" data-target="#file_manager">Browse Media</button>
              </div>
            </div>
          <label>Written content</label>
          <textarea class="textarea summernote4" name="edit_content" id="edit_content" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" data-summernote-id="4"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm" type="submit">Save changes</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<!-- Content Edit -->

<!-- Content Delete -->
<div data-backdrop="static" class="modal fade" id="contentdelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Delete Content</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete content?</p>
        <input type="hidden" class="form-control" name="delete_content_ID" id="delete_content_ID">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-target="#contentdelete" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="delete_content">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- Content Delete -->

<!-- Copy Section -->
<div data-backdrop="static" class="modal fade" id="copy_section_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-secondary" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Copy Section To</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <input type="hidden" class="form-control" name="copy_section_ID" id="copy_section_ID">
            <div class="form-group">
              <select class="browser-default custom-select select_course" name="copy_course"></select>
            </div>
            <div class="form-group">
              <select class="browser-default custom-select select_module" name="copy_section_to" id="copy_section_to">
                <option selected disabled>Select Module</option>
              </select>
            </div>
          </div><!--Col-->
        </div><!--Row-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="copy_section">Copy</button>
      </div>
    </div>
  </div>
</div>
<!-- Copy Section -->

<!-- Copy Lesson -->
<div data-backdrop="static" class="modal fade" id="copy_lesson_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-notify modal-secondary" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Copy Lesson To</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="btn-group btn-group-sm justify-content-center" role="group" aria-label="Basic example">
          <a class="btn btn-primary btn-sm copy_another_course">Copy to another course</a>
          <a class="btn btn-primary btn-sm copy_another_module">Copy to another Module</a>
        </div>
        <input type="hidden" class="form-control" name="copy_lesson_ID" id="copy_lesson_ID">
        <div class="form-group">
          <select class="browser-default custom-select select_course" name="copy_course" hidden></select>
        </div>
        <div class="form-group">
          <select class="browser-default custom-select select_module" name="copy_module" hidden>
            <option selected disabled>Select Module</option>
          </select>
        </div>
        <div class="form-group">
          <select class="browser-default custom-select select_section" name="copy_section" id="copy_lesson_to">
             <option selected disabled>Select Section</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success btn-sm" id="copy_lesson">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Copy Lesson -->

<!-- Copy Content -->
<div data-backdrop="static" class="modal fade" id="copy_content_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-secondary" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Copy Content To</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <input type="hidden" class="form-control" name="copy_content_ID" id="copy_content_ID">
            <div class="form-group">
              <select class="browser-default custom-select select_course" name="copy_course"></select>
            </div>
            <div class="form-group">
              <select class="browser-default custom-select select_module" name="copy_module">
                <option selected disabled>Select Module</option>
              </select>
            </div>
            <div class="form-group">
              <select class="browser-default custom-select select_section" name="copy_section">
                 <option selected disabled>Select Section</option>
              </select>
            </div>
            <div class="form-group">
              <select class="browser-default custom-select select_lesson" name="copy_content_to" id="copy_content_to">
                <option selected disabled>Select Lesson</option>
              </select>
            </div> 
          </div><!--Col-->
        </div><!--Row-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="copy_content">Copy</button>
      </div>
    </div>
  </div>
</div>
<!-- Copy Content -->

<!-- Central Modal Small -->
<div class="modal fade" id="file_manager" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-fluid" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Media</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <iframe width="100%" height="550" frameborder="0" src="<?php echo base_url('vendors/dialog.php?type=3&field_id=edit_content_url'); ?>"></iframe>
      </div>
    </div>
  </div>
</div>
<!-- Central Modal Small -->
<script type="text/javascript">
$(document).ready(function() {
  $(".customSwitches").click(function() {
    if($(".customSwitches").is(":checked")){
      $('.switch_label').text('Active');
      $(this).val(1);
    } else {
      $('.switch_label').text('Hidden');
      $(this).val(0);
    }
  });
});
</script>
<script>
$(document).ready(function(){
  var r=0;
  $('#add_another_content_2').click(function(){
    r++;
    $('#dynamic_content_2').append('<div id="row_2'+r+'"><br><div class="form-group"><label for="content_title">* Title</label><input type="text" class="form-control" name="content_title[]""></div><div class="form-group"><label for="content_title">URL <h6 class="red-text">NOTE: Vimeo URL should start with https://vimeo... or //player...</h6></label><input type="text" class="form-control" name="content_url[]"></div><label>Content</label><textarea class="multipletextarea_2 multiple_2_'+r+'" name="content[]" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" data-multiple-2-summernote="'+r+'"></textarea><a type="button" name="remove" data-id="'+r+'" class="btn_remove btn btn-sm btn-danger float-right">DELETE</a></div>');
    $(document).ready(function(){
      $('.multipletextarea_2').each(function(){
        var summernoteID = $(this).data('multiple-2-summernote');
        $(this).summernote({
          disableDragAndDrop: true,
          height: "200px",
          callbacks: {
            onImageUpload: function(image) {
              uploadImage2(image[0], summernoteID);
            }
          },
          addclass: {
            debug: true,
            classTags: [{title:"Button","value":"btn btn-success"},{title:"Button","value":"btn btn-danger"}]
          },
          toolbar: [
            ['style', ['style', 'addclass']],
            ['font', ['bold', 'underline', 'clear', 'fontsize']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture']],
            ['view', ['fullscreen', 'codeview', 'help']],
          ],
        });
      });
    });

    function uploadImage2(image, summernoteID) {
      var data = new FormData();
      data.append("image", image);
      $.ajax({
        url: "<?=base_url()?>courses/upload_image",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        type: "POST",
        success: function(url) {
          $('.multiple_2_'+summernoteID).summernote('insertImage', url);
        },
        error: function(data) {
          console.log(data);
        }
      });
    }
  });
  $(document).on('click', '.btn_remove', function(){
    var button_id = $(this).data("id"); 
    $('#row_2'+button_id+'').remove();
    r--;
  });
});
</script>
<script>
$(document).ready(function(){
  var i=0;
  $('#add_another_content').click(function(){
    i++;
    $('#dynamic_content').append('<div id="row'+i+'"><br><div class="form-group"><label for="content_title">* Content Title</label><input type="text" class="form-control" name="content_title[]"></div><div class="form-group"><label for="content_title">URL <h6 class="red-text">NOTE: Vimeo URL should start with https://vimeo... or //player...</h6></label><input type="text" class="form-control" name="content_url[]"></div><label>Content</label><textarea class="multipletextarea multiple_'+i+'" name="content[]" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" data-multiple-summernote="'+i+'"></textarea><a type="button" name="remove" data-id="'+i+'" class="btn_remove btn btn-sm btn-danger float-right">DELETE</a></div>');
      $('.multipletextarea').each(function(){
        var summernoteID = $(this).data('multiple-summernote');
        $(this).summernote({
          disableDragAndDrop: true,
          
          height: "200px",
          callbacks: {
            onImageUpload: function(image) {
              uploadImage2(image[0], summernoteID);
            }
          },
          addclass: {
            debug: true,
            classTags: [{title:"Button","value":"btn btn-success"},{title:"Button","value":"btn btn-danger"}]
          },
          toolbar: [
            ['style', ['style', 'addclass']],
            ['font', ['bold', 'underline', 'clear', 'fontsize']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture']],
            ['view', ['fullscreen', 'codeview', 'help']],
          ],
        });
      });

    function uploadImage2(image, summernoteID) {
      var data = new FormData();
      data.append("image", image);
      $.ajax({
        url: "<?=base_url()?>courses/upload_image",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        type: "POST",
        success: function(url) {
          $('.multiple_'+summernoteID).summernote('insertImage', url);
        },
        error: function(data) {
          console.log(data);
        }
      });
    }
  });

  $(document).on('click', '.btn_remove', function(){
    var button_id = $(this).data("id"); 
    $('#row'+button_id+'').remove();
    i--;
  });

  $(document).ready(function(){
    $('.textarea').each(function(){
      var summernoteID = $(this).data('summernote-id');
      $(this).summernote({
        disableDragAndDrop: true,
        height: "300px",
        callbacks: {
          onImageUpload: function(image) {
           uploadImage(image[0], summernoteID);
          }
        },
        addclass: {
        debug: true,
        classTags: [{title:"Button","value":"btn btn-success"},{title:"Button","value":"btn btn-danger"}]
      },
      toolbar: [
        ['style', ['style', 'addclass']],
        ['font', ['bold', 'underline', 'clear', 'fontsize']],
        ['fontname', ['fontname']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture']],
        ['view', ['fullscreen', 'codeview', 'help']],
      ],
      });
    });
  });
  function uploadImage(image, summernoteID) {
    var data = new FormData();
    data.append("image", image);
    $.ajax({
      url: "<?=base_url()?>courses/upload_image",
      cache: false,
      contentType: false,
      processData: false,
      data: data,
      type: "POST",
      success: function(url) {
        $('.summernote'+summernoteID).summernote('insertImage', url);
      },
      error: function(data) {
        console.log(data);
      }
    });
  }
});
</script>
<script type="text/javascript">
$(document).ready(function() {
  $( "#accordionEx78" ).sortable({
  placeholder : "ui-state-highlight",
    update  : function(event, ui){
      var sec_order_id = new Array();
      $('#accordionEx78 .sortsection').each(function(){
        sec_order_id.push($(this).data("section-id"));
      });
      $.ajax({
        url:"<?=base_url()?>courses/sort_section",
        method:"POST",
        data:{sec_order_id:sec_order_id},
        success:function(data){
        }
      });
    }
  });
});
</script>
<script type="text/javascript">
$(document).ready(function() {
  $( ".sortablelessons" ).sortable({
    placeholder : "ui-state-highlight",
    update  : function(event, ui){
      var les_order_id = new Array();
      $('.sortablelessons .sortlessons').each(function(){
        les_order_id.push($(this).data("lesson-id"));
      });
      $.ajax({
        url:"<?=base_url()?>courses/sort_lesson",
        method:"POST",
        data:{les_order_id:les_order_id},
        success:function(data){
          if(data){
            $(".alert-danger").hide();
            $(".alert-success ").show();
          } else {
            $(".alert-success").hide();
            $(".alert-danger").show();
          }
        }
      });
    }
  });
});
</script>
<script type="text/javascript">
$(document).ready(function() {
  $( ".sortablecontent" ).sortable({
    placeholder : "ui-state-highlight",
    update  : function(event, ui){
      var con_order_id = new Array();
      $('.sortablecontent .sortcontent').each(function(){
        con_order_id.push($(this).data("content-id"));
      });
      $.ajax({
        url:"<?=base_url()?>courses/sort_content",
        method:"POST",
        data:{con_order_id:con_order_id},
        success:function(data) {
        }
      });
    }
  });
});
</script>
<script type="text/javascript">
$(document).ready(function(){
  var course_slug = '<?php echo $course['slug'];?>';
  var module_ID = '<?php echo $module['id'];?>';

  get_course();
  get_modules(module_ID);

  function get_course(){
    $.ajax({
      type  : 'POST',
      url   : "<?=base_url()?>courses/get_courses",
      dataType : 'json',
      success : function(data){
        var html = '';
        var i;
        html += '<option disabled selected>Choose Course</option>';
        for(i=0; i<data.length; i++){
          html += '<option value='+data[i].course_ID+'>'+data[i].title+'</option>';
        }
        $('.select_course').html(html);
      }
    });
  }

  function get_modules(course_ID){
    $.ajax({
      type  : 'POST',
      url   : "<?=base_url()?>courses/get_modules",
      dataType : 'json',
      data : {course_ID:course_ID},
      success : function(data){
        var html = '';
        var i;
        html += '<option disabled selected>Choose Module</option>';
        for(i=0; i<data.length; i++){
          html += '<option value='+data[i].id+'>'+data[i].title+'</option>';
        }
        $('.select_module').html(html);
      }
    });
  }

  function get_sections(module_ID){
    $.ajax({
      url : "<?=base_url()?>courses/get_sections",
      method : "POST",
      data : {module_ID:module_ID},
      async : true,
      dataType : 'json',
      success: function(data){
        var html = '';
        var i;
        html += '<option disabled selected>Choose Section</option>';
        for(i=0; i<data.length; i++){
          html += '<option value='+data[i].id+'>'+data[i].title+'</option>';
        }
        $('.select_section').html(html);
      }
    });
  }

  function get_lessons(section_ID){
    $.ajax({
      url : "<?=base_url()?>courses/get_lessons",
      method : "POST",
      data : {section_ID:section_ID},
      async : true,
      dataType : 'json',
      success: function(data){
        var html = '';
        var i;
        html += '<option disabled selected>Choose Lesson</option>';
        for(i=0; i<data.length; i++){
          html += '<option value='+data[i].id+'>'+data[i].title+'</option>';
        }
        $('.select_lesson').html(html);
      }
    });
  }

  $('.select_course').change(function(){ 
    var course_ID=$(this).val();
    get_modules(course_ID);
  }); 

  $('.select_module').change(function(){ 
    var module_ID=$(this).val();
    get_sections(module_ID);
  }); 

  // Section select 
  $('.select_section').change(function(){ 
    var section_ID=$(this).val();
    get_lessons(section_ID);
  }); 

  //Get Section to delete
  $(document).on("click", ".delete_section", function() { 
    var id=$(this).data('id');
    $('#delete_section_modal').modal('show');
    $('[name="delete_section_ID"]').val(id);
  });

  $("#delete_section").click(function(){
    var section_ID = $('#delete_section_ID').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/delete_section",
      dataType : "JSON",
      data : {section_ID:section_ID},
      success: function(data){
        $('#delete_section_modal').modal('hide');
        toastr.error('Section Deleted');
        location.reload();
      }
    });
    return false;
  });

  //Get Lesson to delete
  $(document).on("click", ".delete_lesson", function() { 
    var id=$(this).data('id');
    $('#delete_lesson_modal').modal('show');
    $('[name="delete_lesson_ID"]').val(id);
   });

  //delete lesson
  $('#delete_lesson').on('click',function(){
    var lesson_ID = $('#delete_lesson_ID').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/delete_lesson",
      dataType : "JSON",
      data : {lesson_ID:lesson_ID},
      success: function(data){
        toastr.error('Lesson Deleted');
        location.reload();
      }
    });
    return false;
  });

  //Get Content to delete
  $(document).on("click", ".delete_content", function() { 
    var id=$(this).data('id');
    $('#contentdelete').modal('show');
    $('[name="delete_content_ID"]').val(id);
  });

  $("#delete_content").click(function(){
    var content_ID = $('#delete_content_ID').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/delete_content",
      dataType : "JSON",
      data : {content_ID:content_ID},
      success: function(data){
        toastr.error('Content Deleted');
        location.reload();
      }
    });
    return false;
  });

  //Get Section to update
  $(document).on('click','.edit_section',function(e) {
    var section_ID=$(this).data('id');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/get_section",
      dataType : "JSON",
      data : {section_ID:section_ID},
      success: function(data){
        $('#sectionedit').modal('show');
        $('[name="edit_section_title"]').val(data.title);
        $('[name="edit_section_ID"]').val(section_ID);
        $('#section_status').val(data.status);
        $('.switch_label').text('Hidden');
        if(data.status == 1){
          $('#section_status').attr("checked", "checked");
          $('.switch_label').text('Active');
        }
      }
    });
    return false;
  });

  //Update Section
  $('#update_section').on('click',function(){
    var title=$('[name="edit_section_title"]').val();
    var id=$('[name="edit_section_ID"]').val();
    var status=$('#section_status').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/update_section",
      dataType : "JSON",
      data : {section_ID:id, section_title:title, section_status:status},
      success: function(data){
      if(data.error){
          toastr.error(data.message);
        } else {
          toastr.success('Section title updated.');
          $('[name="edit_section_title"]').val("");
          $('[name="edit_section_ID"]').val("");
          $('[id="section_status"]').val("");
          $('#sectionedit').modal('hide');
          location.reload();
        }
      }
    });
    return false;
  });

  //Get Lesson to update
  $(document).on('click','.edit_lesson',function() {
    var lesson_ID = $(this).data('id');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/get_lesson",
      dataType : "JSON",
      data : {lesson_ID:lesson_ID},
      success: function(data){
        $('#edit_lesson_modal').modal('show');
        $('[name="edit_lesson_title"]').val(data.title);
        $('[name="edit_lesson_ID"]').val(lesson_ID);
        $('[name="lesson_status"]').val(data.status);
        $('.switch_label').text('Hidden');
        if(data.status == 1){
          $('#lesson_status').attr("checked", "checked");
          $('.switch_label').text('Active');
        }
      }
    });
    return false;
  });

  //update lesson
  $('#update_lesson').on('click',function(){
    var title = $('#edit_lesson_title').val();
    var id = $('#edit_lesson_ID').val();
    var status = $('#lesson_status').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/update_lesson",
      dataType : "JSON",
      data : {lesson_ID:id , lesson_title:title, status:status},
      success: function(data){
        if(data.error){
          toastr.error(data.message);
        } else {
          toastr.success('Lesson title updated.');
          $('[name="edit_lesson_title"]').val("");
          $('[name="edit_lesson_ID"]').val("");
          $('[name="lesson_status"]').val("");
          $('#edit_lesson_modal').modal('hide');
          location.reload();
        }
      }
    });
    return false;
  });

  //Get lesson for adding content
  $(document).on('click','.add_content',function() {
    var id = $(this).data('lesson-id');
    $('#add_content_modal').modal('show');
    $('#selected_lesson').val(id);
  });

  //Get content to update
  $(document).on('click','.edit_content',function() {
    var content_ID=$(this).data('id');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/get_content",
      dataType : "JSON",
      data : {content_ID:content_ID},
      success: function(data){
        $('#edit_content_modal').modal('show');
        $('[name="edit_content_title"]').val(data.title);
        $('[name="edit_content_url"]').val(data.url);
        $('#edit_content').summernote('code', data.content);
        $('[name="edit_content_ID"]').val(content_ID);
        $('[name="content_status"]').val(data.status);
        $('.switch_label').text('Hidden');
        if(data.status == 1){
          $('#content_status').attr("checked", "checked");
          $('.switch_label').text('Active');
        }
      }
    });
    return false;
  });

  //Get lesson for adding content
  $(document).on('click','.copy_content',function() {
    $('#copy_content_modal').modal('show');
  });

  //Copy Section
  $(document).on('click','.copy_section',function() {
    $('#copy_section_modal').modal('show');
    var section_ID=$(this).data('id');
    var course_ID = '<?php echo $course['course_ID'];?>';
    get_modules(course_ID);
    $('.select_course option[value="'+course_ID+'"]').prop('selected', true);
    $('[name="copy_section_ID"]').val(section_ID);
    $('[name="copy_section_to"]').val();
  });

  $('#copy_section').on('click',function(){
    var module_ID = $('#copy_section_to').val();
    var section_ID = $('#copy_section_ID').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/copy_section",
      dataType : "JSON",
      data : {module_ID:module_ID, section_ID:section_ID},
      success: function(data){
        if(data == false){
          toastr.error('Section title already exist!');
        } else {
          toastr.success('Section copied successfully!');
        }
        $('#copy_section_modal').modal('hide');
      }
    });
  });

  //Copy Lesson
  $(document).on('click','.copy_lesson',function() {
    $('#copy_lesson_modal').modal('show');
    var lesson_ID=$(this).data('id');
    var module_ID = '<?php echo $module['id'];?>';
    var course_ID = '<?php echo $course['course_ID'];?>';
    get_modules(course_ID);
    get_sections(module_ID);
    $('[name="copy_lesson_ID"]').val(lesson_ID);
    $('[name="copy_lesson_to"]').val();
  });

  $('#copy_lesson').on('click',function(){
    var section_ID = $('#copy_lesson_to').val();
    var lesson_ID = $('#copy_lesson_ID').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/copy_lesson",
      dataType : "JSON",
      data : {section_ID:section_ID, lesson_ID:lesson_ID},
      success: function(data){
        if(data == false){
          toastr.error('Lesson title already exist!');
        } else {
          toastr.success('Lesson copied successfully!');
          $('.select_module').attr('hidden');
          $('.select_course').attr('hidden');
        }
        $('#copy_lesson_modal').modal('hide');
      }
    });
  });

  //Copy content
  $(document).on('click','.copy_content',function() {
    $('#copy_content_modal').modal('show');
    var content_ID=$(this).data('id');
    var section_ID=$(this).data('section-id');
    var module_ID = '<?php echo $module['id'];?>';
    get_sections(module_ID);
    get_lessons(section_ID);
    $('[name="copy_content_ID"]').val(content_ID);
    $('[name="copy_content_to"]').val();
  });

  $('#copy_content').on('click',function(){
    var lesson_ID = $('#copy_content_to').val();
    var content_ID = $('#copy_content_ID').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/copy_content",
      dataType : "JSON",
      data : {lesson_ID:lesson_ID, content_ID:content_ID},
      success: function(data){
        if(data == false){
          toastr.error('Content title already exist!');
        } else {
          toastr.success('Content copied successfully!');
        }
        $('#copy_content_modal').modal('hide');
      }
    });
  });

  //Copy copy
  $(document).on('click','.copy_another_module',function() {
    $('.select_module').removeAttr('hidden');
  });

  $(document).on('click','.copy_another_course',function() {
    $('.select_course').removeAttr('hidden');
  });

});
</script>