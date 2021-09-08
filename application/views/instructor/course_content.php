<style type="text/css">
.dropdown-menu {         
  max-height: 500px;
  overflow-y: auto;
}
</style>
<main class="pt-5 mx-lg-5">
  <div class="container-fluid mt-5">
    <div class="card mb-4 wow fadeIn">
      <div class="card-body d-sm-flex justify-content-between">
        <h4 class="mb-2 mb-sm-0 pt-1">
          <span><a href="<?php echo base_url();?>instructor">Home</a></span>
          <span>/</span>
          <span><a href="<?php echo base_url();?>instructor/course">Course</a></span>
          <span>/</span>
          <a class="dropdown-toggle mr-4 dropdown-menu-right" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo ucwords($module['title']);?></a>
          <div class="dropdown-menu">
            <?php foreach ($modules as $value) { ?>
              <?php if ($value['title'] == $module['title']) { ?>
                <a class="dropdown-item blue-text" href="<?php echo base_url(); ?>instructor/course/<?php echo $course['slug'];?>/<?php echo $value['slug']; ?>"><?php echo $value['title']; ?></a>
              <?php } else { ?>
                <a class="dropdown-item" href="<?php echo base_url(); ?>instructor/course/<?php echo $course['slug'];?>/<?php echo $value['slug']; ?>"><?php echo $value['title']; ?></a>
              <?php } ?>
            <?php } ?> 
          </div>
        </h4>
        <h4 class="mb-2 mb-sm-0 pt-1 float-right">
          <span><a href="<?php echo base_url();?>instructor/course/<?php echo $course['slug'];?>">Back</a></span>
        </h4>
      </div>
    </div>

    <div class="row mb-4 justify-content-center">
      <div class="col-md-6">
        <div class="input-group">
          <input type="hidden" class="form-control" id="module_ID" value="<?php echo $module['id'];?>">
          <input type="text" class="form-control" placeholder="Enter Section Title" aria-label="Section" aria-describedby="button-addon2" id="create_section_title">
          <div class="input-group-append">
            <button class="btn btn-md btn-success m-0 px-3 py-2 z-depth-0 waves-effect" id="create_section">Create Section</button>
          </div>
        </div>
      </div><!--Column-->
      <div class="col-md-4">
        <a href="<?php echo base_url();?>instructor/course/edit/<?php echo $course['slug'];?>/<?php echo $module['slug'];?>" class="btn btn-primary m-0 px-3 py-2 z-depth-0 waves-effect">Edit All Contents</a>
        <a href="<?php echo base_url();?>course/<?php echo $course['slug'];?>/<?php echo $module['slug'];?>" class="btn btn-info m-0 px-3 py-2 z-depth-0 waves-effect" target="_blank"><i class="fas fa-eye"></i> Preview</a>
      </div><!--Column-->
    </div><!--Row-->

    <div class="row">
      <div class="col-md-12 mb-4">
        <div class="accordion md-accordion accordion-blocks sections" id="section_accordion" role="tablist" aria-multiselectable="true">
          <?php foreach ($sections as $section){ ?>
            <div data-section-id="<?php echo $section['id']; ?>" class="card sortsection section_<?php echo $section['id']; ?>">
              <div class="card-header d-flex justify-content-between" role="tab" id="mainsection_<?php echo $section['id']; ?>">
                <a data-toggle="collapse" href="#section_<?php echo $section['id']; ?>" aria-expanded="true" aria-controls="section_<?php echo $section['id']; ?>">
                  <h3 class="mt-1 mb-0">
                    <span style="cursor: all-scroll;" id="section_title_<?php echo $section['id'];?>"><?php echo $section['title'];?></span>
                    <i class="fas fa-angle-down rotate-icon"></i>
                  </h3>
                </a>
                <div>
                  <?php if($section['status'] == 1){ ?>
                    <span class="section_status_<?php echo $section['id']; ?> badge badge-pill mr-2 badge-info">Active</span>
                  <?php } else { ?>
                    <span class="section_status_<?php echo $section['id']; ?> badge badge-pill mr-2 badge-warning">Hidden</span>
                  <?php } ?>
                  <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                    <a type="button" class="btn btn-primary btn-sm edit_section" data-id="<?php echo $section['id']; ?>"><i class="fas fa-pencil-alt"></i></a>
                    <a type="button" class="btn btn-danger btn-sm delete_section" data-id="<?php echo $section['id']; ?>"><i class="fas fa-trash-alt"></i></a>
                    <a type="button" class="btn btn-secondary btn-sm copy_section" data-id="<?php echo $section['id']; ?>"><i class="fas fa-copy"></i></a>
                    <a class="btn btn-info btn-sm" href="<?php echo base_url();?>instructor/course/<?php echo $course['slug'];?>/<?php echo $module['slug'];?>/<?php echo $section['slug'];?>"><i class="fas fa-edit ml-1"></i> Edit Contents</a>
                  </div>
                </div><!-- Section Group Buttons-->
              </div><!-- Card Header -->
              <div id="section_<?php echo $section['id']; ?>" class="collapse show" role="tabpanel" aria-labelledby="mainsection_<?php echo $section['id']; ?>">
                <div class="lessons_<?php echo $section['id']; ?> lessons">
                <?php foreach ($lessons as $lesson) {?>
                  <?php if ($section['id'] == $lesson['section_ID']) {?>
                    <div class="accordion md-accordion lesson_accordion pt-2 pl-4 ml-4" id="mainlesson_<?php echo $lesson['id']; ?>" role="tablist" aria-multiselectable="true" data-lesson-id="<?php echo $lesson['id']; ?>">
                      <div class="d-flex">
                        <a data-toggle="collapse" data-parent="#mainlesson_<?php echo $lesson['id']; ?>" href="#lesson_<?php echo $lesson['id']; ?>" aria-expanded="true" aria-controls="lesson_<?php echo $lesson['id']; ?>">
                          <h4><span style="cursor: all-scroll;" id="lesson_title_<?php echo $lesson['id']; ?>"><?php echo $lesson['title']; ?></span><i class="fas fa-angle-down rotate-icon ml-2"></i></h4>
                        </a>
                        <div class="ml-4">
                          <?php if($lesson['status'] == 1){ ?>
                            <span class="lesson_status_<?php echo $lesson['id']; ?> badge badge-pill mr-2 badge-info">Active</span>
                          <?php } else { ?>
                            <span class="lesson_status_<?php echo $lesson['id']; ?> badge badge-pill mr-2 badge-warning">Hidden</span>
                          <?php } ?>
                          <a class="edit_lesson" data-id="<?php echo $lesson['id']; ?>"><i class="fas fa-pencil-alt blue-text"></i></a><a class="delete_lesson" data-id="<?php echo $lesson['id']; ?>"><i class="fas fa-trash-alt red-text ml-1"></i></a><a class="copy_lesson" data-id="<?php echo $lesson['id']; ?>"><i class="fas fa-copy text-secondary ml-1"></i></a><a class="add_content green-text ml-1" data-lesson-id="<?php echo $lesson['id'];?>"><i class="fas fa-plus ml-1"></i> Add Content</a>
                        </div>
                      </div>
                      <div id="lesson_<?php echo $lesson['id']; ?>" class="collapse show contents_<?php echo $lesson['id']; ?> contents" role="tabpanel" aria-labelledby="mainsection_<?php echo $section['id']; ?>" data-parent="#mainlesson_<?php echo $lesson['id']; ?>">
                        <?php foreach ($contents as $content) {?>
                          <?php if ($lesson['id'] == $content['lesson_ID']) {?>
                          <div class="row ml-4 pl-4 content_<?php echo $content['id']; ?> content_accordion" data-content-id="<?php echo $content['id']; ?>">
                            <ul class="list-group align-middle" role="tablist">
                              <li style="cursor: all-scroll;"><h5 id="content_title_<?php echo $content['id']; ?>"><?php echo $content['title'];?></h5> </li>
                            </ul>
                            <div class="col-4 float-right">
                              <?php if($content['status'] == 1){ ?>
                                <span class="content_status_<?php echo $content['id']; ?> badge badge-pill mr-2 badge-info">Active</span>
                              <?php } else { ?>
                                <span class="content_status_<?php echo $content['id']; ?> badge badge-pill mr-2 badge-warning">Hidden</span>
                              <?php } ?>
                              <a class="edit_content" data-id="<?php echo $content['id']; ?>"><i class="fas fa-pencil-alt blue-text"></i></a><a class="delete_content" data-id="<?php echo $content['id']; ?>"><i class="fas fa-trash-alt red-text ml-1"></i></a><a class="copy_content" data-id="<?php echo $content['id']; ?>" data-section-id="<?php echo $section['id'];?>"><i class="fas fa-copy text-secondary ml-1"></i></a>
                            </div>
                          </div>
                          <?php } ?>
                        <?php } ?>
                      </div><!-- Lesson Body --> 
                    </div><!-- Lesson Accordion card -->  
                  <?php } ?>
                <?php } ?>
                </div><!-- Lesson -->  
                <div class="row m-3">
                  <div class="col-md-4">
                    <div class="input-group mb-3">
                      <input type="text" class="form-control create_lesson_input" placeholder="Lesson Title" aria-label="Lesson Title" aria-describedby="button-addon2" id="lesson_title_<?php echo $section['id'];?>" data-section-id="<?php echo $section['id'];?>">
                      <div class="input-group-append">
                        <button class="btn btn-md btn-success m-0 px-3 py-2 z-depth-0 waves-effect create_lesson create_lesson_<?php echo $section['id'];?>" data-section-id="<?php echo $section['id'];?>">Create New Lesson</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div><!-- Section Body -->  
            </div><!-- Section Accordion card -->
          <?php } ?>
        </div><!-- Section Accordion -->  
      </div><!--Grid column-->
    </div><!--Grid row-->
  </div><!--Container-->
</main><!--Main laypassed out-->

<!-- Are you sure -->
<div data-backdrop="static" class="modal fade" id="create_content_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
        <label>* Content Title</label>
        <input type="hidden" class="form-control" name="lesson_ID" id="lesson_ID">
        <input type="text" class="form-control mb-4" name="content_title" id="content_title">
        <div class="btn-group btn-group-sm mb-4" role="group" aria-label="Basic example">
          <a class="btn btn-primary btn-sm add_video_button" id="add_video">Add Video</a>
          <a class="btn btn-primary btn-sm add_article_button" id="add_article">Add Article/Details</a>
          <a class="btn btn-primary btn-sm add_file_button" id="add_file">Add Downloadable File</a>
        </div>
        <div class="form-group add_video" hidden>
          <label for="contentitle">Video URL (URLs from youtube and vimeo are allowed) <br><h6 class="red-text">NOTE: Select one file only.</h6></label>
          <div class="input-group mb-3">
            <input type="text" class="form-control" aria-describedby="button-addon2" name="content_url" id="content_url">
            <div class="input-group-append">
              <a href="javascript:open_popup('<?php echo base_url('vendors/dialog.php?type=3&popup=1&amp;field_id=content_url'); ?>')" class="btn btn-md btn-outline-primary m-0 px-3 py-2 z-depth-0 waves-effect">Browse Media</a>
            </div>
          </div>
          <label for="contentitle">Video Thumbnail (optional)<h6 class="red-text">NOTE: Select one file only.</h6></label>
          <div class="input-group mb-3">
            <input type="text" class="form-control" aria-describedby="button-addon2" name="content_thumbnail" id="content_thumbnail">
            <div class="input-group-append">
              <a href="javascript:open_popup('<?php echo base_url('vendors/dialog.php?type=1&popup=1&amp;field_id=content_thumbnail'); ?>')" class="btn btn-md btn-outline-primary m-0 px-3 py-2 z-depth-0 waves-effect">Browse Media</a>
            </div>
          </div>
        </div>
        <div class="form-group add_article" hidden>
          <label>Details or Article</label>
          <textarea type="textarea" class="content_written" name="content_written" id="content_written"></textarea>
        </div>
        <div class="form-group add_file" hidden>
          <label for="image">Downloadble File</label>
          <h6 class="red-text">NOTE: You can select multiple files</h6>
          <div class="input-group mb-3">
            <input type="text" class="form-control" aria-describedby="button-addon2" name="content_files" id="content_files">
            <div class="input-group-append">
              <a href="javascript:open_popup('<?php echo base_url('vendors/dialog.php?type=2&popup=1&amp;field_id=content_files'); ?>')" class="btn btn-md btn-outline-primary m-0 px-3 py-2 z-depth-0 waves-effect">Browse Media</a>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <a type="button" class="btn btn-danger waves-effect cancel_create_content" id="cancel_create_content">Cancel</a>
        <button class="btn btn-success waves-effect float-right" type="submit" id="create_content">Save Content</button>
      </div>
    </div><!--/.Content-->
  </div>
</div>

<!-- Section Edit -->
<div data-backdrop="static" class="modal fade" id="edit_section_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary btn-sm" id="update_section">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Section Edit -->

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
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary btn-sm" id="update_lesson">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Lesson Edit -->

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
        <div class="form-group">
          <label>* Content Title</label>
          <input type="hidden" class="form-control" name="edit_content_ID" id="edit_content_ID">
          <input type="text" class="form-control mb-4" name="edit_content_title" id="edit_content_title">
          <label for="edit_content_status">* Status</label>
          <div class="custom-control custom-switch mb-4">
            <input type="checkbox" class="custom-control-input customSwitches" id="edit_content_status" name="edit_content_status">
            <label class="custom-control-label switch_label" for="edit_content_status"></label>
          </div>
          <div class="btn-group btn-group-sm mb-4" role="group" aria-label="Basic example">
            <a class="btn btn-primary btn-sm add_video_button">Add Video</a>
            <a class="btn btn-primary btn-sm add_article_button">Add Article/Details</a>
            <a class="btn btn-primary btn-sm add_file_button">Add Downloadable File</a>
          </div>
          <div class="form-group add_video" hidden>
            <label for="contentitle">Video URL <h6 class="red-text">NOTE: URLs from youtube and vimeo are allowed</h6></label>
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="edit_content_url" id="edit_content_url" aria-describedby="button-addon2">
              <div class="input-group-append">
                <a href="javascript:open_popup('<?php echo base_url('vendors/dialog.php?type=3&popup=1&amp;field_id=edit_content_url'); ?>')" class="btn btn-md btn-outline-primary m-0 px-3 py-2 z-depth-0 waves-effect">Browse Media</a>
              </div>
            </div>
            <label for="contentitle">Video Thumbnail (optional) <br><h6 class="red-text">NOTE: Select one file only.</h6></label>
            <div class="input-group mb-3">
              <input type="text" class="form-control" aria-describedby="button-addon2" name="edit_content_thumbnail" id="edit_content_thumbnail">
              <div class="input-group-append">
                <a href="javascript:open_popup('<?php echo base_url('vendors/dialog.php?type=1&popup=1&amp;field_id=edit_content_thumbnail'); ?>')" class="btn btn-md btn-outline-primary m-0 px-3 py-2 z-depth-0 waves-effect">Browse Media</a>
              </div>
            </div>
          </div>
          <div class="form-group add_article" hidden>
            <label>Details or Article</label>
            <textarea class="textarea" name="edit_content" id="edit_content"></textarea>
          </div>
          <div class="form-group add_file" hidden>
            <label for="image">Add Downloadble Contents</label>
            <h6 class="red-text">NOTE: You can select multiple files except folders</h6>
            <div class="input-group mb-3">
              <input type="text" class="form-control" aria-describedby="button-addon2" name="edit_content_files" id="edit_content_files">
              <div class="input-group-append">
                <a href="javascript:open_popup('<?php echo base_url('vendors/dialog.php?type=2&popup=1&amp;field_id=edit_content_files'); ?>')" class="btn btn-md btn-outline-primary m-0 px-3 py-2 z-depth-0 waves-effect">Browse Media</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary btn-sm" id="update_content">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Content Edit -->

<!-- Copy Section -->
<div data-backdrop="static" class="modal fade" id="copy_section_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-notify modal-secondary" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Copy Section To</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" class="form-control" name="copy_section_ID" id="copy_section_ID">
        <div class="form-group">
          <select class="browser-default custom-select select_course" name="copy_course"></select>
        </div>
        <div class="form-group">
          <select class="browser-default custom-select select_module" name="copy_section_to" id="copy_section_to">
            <option selected disabled>Select Module</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
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
        <div class="btn-group btn-group-sm justify-content-center mb-4" role="group" aria-label="Basic example">
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
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success btn-sm" id="copy_lesson">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Copy Lesson -->

<!-- Copy Content -->
<div data-backdrop="static" class="modal fade" id="copy_content_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-notify modal-secondary" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Copy Content To</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="btn-group btn-group-sm justify-content-center" role="group" aria-label="Basic example">
          <a class="btn btn-primary btn-sm copy_another_course">Copy to another course</a>
          <a class="btn btn-primary btn-sm copy_another_module">Copy to another Module</a>
        </div>
        <input type="hidden" class="form-control" name="copy_content_ID" id="copy_content_ID">
        <div class="form-group">
          <select class="browser-default custom-select select_course" name="copy_course" hidden></select>
        </div>
        <div class="form-group">
          <select class="browser-default custom-select select_module" name="copy_module" hidden>
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
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary btn-sm" id="copy_content">Copy</button>
      </div>
    </div>
  </div>
</div>
<!-- Copy Content -->
<script type="text/javascript">
$(document).ready(function() {
  $("#section_accordion").sortable({
  placeholder : "ui-state-highlight",
    update  : function(event, ui){
      var sec_order_id = new Array();
      $('#section_accordion .sortsection').each(function(){
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
  $(".lessons").sortable({
    placeholder : "ui-state-highlight",
    update  : function(event, ui){
      var les_order_id = new Array();
      $('.lessons .lesson_accordion').each(function(){
        les_order_id.push($(this).data("lesson-id"));
      });
      $.ajax({
        url:"<?=base_url()?>courses/sort_lesson",
        method:"POST",
        data:{les_order_id:les_order_id},
        success:function(data){
        }
      });
    }
  });
});
</script>
<script type="text/javascript">
$(document).ready(function() {
  $(".contents").sortable({
    placeholder : "ui-state-highlight",
    update  : function(event, ui){
      var con_order_id = new Array();
      $('.contents .content_accordion').each(function(){
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
<script>
CKEDITOR.replace('content_written' ,{
  filebrowserBrowseUrl : '<?php echo base_url('vendors/dialog.php?type=2&editor=ckeditor&fldr='); ?>',
  filebrowserUploadUrl : '<?php echo base_url('vendors/dialog.php?type=2&editor=ckeditor&fldr='); ?>',
  filebrowserImageBrowseUrl : '<?php echo base_url('vendors/dialog.php?type=1&editor=ckeditor&fldr='); ?>'
});
</script>
<script>
CKEDITOR.replace('edit_content' ,{
  filebrowserBrowseUrl : '<?php echo base_url('vendors/dialog.php?type=2&editor=ckeditor&fldr='); ?>',
  filebrowserUploadUrl : '<?php echo base_url('vendors/dialog.php?type=2&editor=ckeditor&fldr='); ?>',
  filebrowserImageBrowseUrl : '<?php echo base_url('vendors/dialog.php?type=1&editor=ckeditor&fldr='); ?>'
});
</script>
<script type="text/javascript">
$(document).ready(function() {
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

  $(".customSwitches").click(function() {
    if($(".customSwitches").is(":checked")){
      $('.switch_label').text('Active');
      $(this).val(1);
    } else {
      $('.switch_label').text('Hidden');
      $(this).val(0);
    }
  });

  $('#create_section').on('click',function(){
    var module_ID = $('#module_ID').val();
    var title = $('#create_section_title').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/create_section",
      dataType : "JSON",
      data : {module_ID:module_ID, title:title},
      success: function(data){
        if(data.error){
          toastr.error(data.message);
          error_sound.play();
        } else {
          toastr.success('Section created!');
          var html = '<div data-section-id="'+data.section_ID+'" class="card sortsection section_'+data.section_ID+'">';
          html += '<div class="card-header d-flex justify-content-between" role="tab" id="mainsection_'+data.section_ID+'"><a data-toggle="collapse" data-parent="#section_accordion" href="#section_'+data.section_ID+'" aria-expanded="true" aria-controls="section_'+data.section_ID+'"><h3 class="mt-1 mb-0"><span style="cursor: all-scroll;" id="section_title_'+data.section_ID+'">'+title+'</span> <i class="fas fa-angle-down rotate-icon"></i></h3></a><div><span class="section_status_'+data.section_ID+' badge badge-pill mr-2 badge-info">Active</span><div class="btn-group btn-group-sm" role="group" aria-label="Basic example"><a type="button" class="btn btn-primary btn-sm edit_section" data-id="'+data.section_ID+'"><i class="fas fa-pencil-alt"></i></a><button type="button" class="btn btn-danger btn-sm delete_section" data-id="'+data.section_ID+'"><i class="fas fa-trash-alt"></i></button><a type="button" class="btn btn-secondary btn-sm copy_section" data-id="'+data.section_ID+'"><i class="fas fa-copy"></i></a></div></div></div><div id="section_'+data.section_ID+'" class="collapse show" role="tabpanel" aria-labelledby="mainsection_'+data.section_ID+'" data-parent="#section_accordion"><div class="lessons_'+data.section_ID+'"></div><div class="row m-3"><div class="col-md-4"><div class="input-group mb-3"><input type="text" class="form-control" placeholder="Lesson Title" aria-label="Lesson Title" aria-describedby="button-addon2" id="lesson_title_'+data.section_ID+'"><div class="input-group-append"><button class="btn btn-md btn-success m-0 px-3 py-2 z-depth-0 waves-effect create_lesson" data-section-id="'+data.section_ID+'">Create New Lesson</button></div></div></div></div></div></div>';
          $(".sections:last").append(html);
          $("html, body").animate({ scrollTop: $(document).height() }, 1000);
        }
        $('#create_section_title').val('');
      }
    });
  });

  $(".create_lesson_input").keydown(function(e) {
    var section_ID = $(this).data('section-id');
    var title = $('#lesson_title_'+section_ID).val();
    if (e.which == 9 || e.which == 13) {
      var index = $(".create_lesson_input").index(this);
      $(".create_lesson_input").eq(index + 1).focus();
      e.preventDefault();
      submit_lesson(section_ID, title);
    }
  });

  $(document).on("click", ".create_lesson", function() { 
    var section_ID = $(this).data('section-id');
    var title = $('#lesson_title_'+section_ID).val();
    submit_lesson(section_ID, title);
  });

  function submit_lesson(section_ID, title){
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/create_lesson",
      dataType : "JSON",
      data : {section_ID:section_ID, title:title},
      success: function(data){
        if(data.error){
          toastr.error(data.message);
          error_sound.play();
        } else {
          toastr.success('Lesson created!');
          create_lesson(data.lesson_ID, section_ID, title);
        }
        $('#lesson_title_'+section_ID).val('');
      }
    });
  }

  function create_lesson(lesson_ID, section_ID, title){
    var html = '<div class="accordion md-accordion lesson_accordion pt-2 pl-4 ml-4" id="mainlesson_'+lesson_ID+'" role="tablist" aria-multiselectable="true" data-lesson-id="'+lesson_ID+'"><div class="d-flex"><a data-toggle="collapse" data-parent="#mainlesson_'+lesson_ID+'" href="#lesson_'+lesson_ID+'" aria-expanded="true" aria-controls="lesson_'+lesson_ID+'"><h4><span style="cursor: all-scroll;" id="lesson_title_'+lesson_ID+'">'+title+'</span><i class="fas fa-angle-down rotate-icon ml-2"></i></h4></a><div class="ml-4"><span class="lesson_status_'+lesson_ID+' badge badge-pill mr-2 badge-info">Active</span><a class="edit_lesson" data-id="'+lesson_ID+'"><i class="fas fa-pencil-alt blue-text"></i></a><a class="delete_lesson" data-id="'+lesson_ID+'"><i class="fas fa-trash-alt red-text ml-1"></i></a><a class="copy_lesson" data-id="'+lesson_ID+'"><i class="fas fa-copy text-secondary ml-1"></i></a><a class="add_content green-text ml-1" data-lesson-id="'+lesson_ID+'"><i class="fas fa-plus ml-1"></i> Add Content</a></div></div><div id="lesson_'+lesson_ID+'" class="collapse show contents_'+lesson_ID+'" role="tabpanel" aria-labelledby="mainsection_'+section_ID+'" data-parent="#mainlesson_'+lesson_ID+'"></div></div>';
    $(".lessons_"+section_ID).last().append(html);
  }

  $(document).on('click','.add_content',function() {
    var id = $(this).data('lesson-id');
    $('#create_content_modal').modal('show');
    $('#lesson_ID').val(id);
  });

  $('#create_content').on('click',function(){
    var lesson_ID = $('#lesson_ID').val();
    var title = $('#content_title').val();
    var url = $('#content_url').val();
    var files = $('#content_files').val();
    var content = CKEDITOR.instances['content_written'].getData();
    var thumbnail = $('#content_thumbnail').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/create_content",
      dataType : "JSON",
      data : {lesson_ID:lesson_ID, title:title, url:url, content:content, files:files, thumbnail:thumbnail},
      success: function(data){
        if(data.error){
          toastr.error(data.message);
          error_sound.play();
        } else {
          toastr.success('Content created!');
          $('#create_content_modal').modal('hide');
          create_content(data.content_ID, lesson_ID, title);
          $('#lesson_ID').val('');
          $('#content_title').val('');
          $('#content_url').val('');
          $('#content_files').val('');
          $('#content_written').val('');
          $('#content_thumbnail').val('');
          $('.add_video').prop( "hidden", true );
          $('.add_article').prop( "hidden", true );
          $('.add_file').prop( "hidden", true );
          CKEDITOR.instances['content_written'].setData('');
        }
      }
    });
  });

  function create_content(content_ID, lesson_ID, title){
    var html = '<div class="row ml-4 pl-4 content_'+content_ID+' content_accordion" data-content-id="'+content_ID+'">';
    html += '<ul class="list-group align-middle" role="tablist"><li style="cursor: all-scroll;"><h5 id="content_title_'+content_ID+'">'+title+'</h5></li></ul><div class="col-4 float-right"><span class="content_status_'+content_ID+' badge badge-pill mr-2 badge-info">Active</span><a class="edit_content" data-id="'+content_ID+'"><i class="fas fa-pencil-alt blue-text"></i></a><a class="delete_content" data-id="'+content_ID+'"><i class="fas fa-trash-alt red-text ml-1"></i></a><a class="copy_content" data-id="'+content_ID+'"><i class="fas fa-copy text-secondary ml-1"></i></a></div></div>';
    $(".contents_"+lesson_ID).last().append(html);
  }
  
  //Get Section to update
  $(document).on('click','.edit_section',function(e) {
    var section_ID=$(this).data('id');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/get_section",
      dataType : "JSON",
      data : {section_ID:section_ID},
      success: function(data){
        $('#edit_section_modal').modal('show');
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
  });

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
          error_sound.play();
        } else {
          toastr.success('Section updated!');
          $('[name="edit_section_title"]').val("");
          $('[name="edit_section_ID"]').val("");
          $('[id="section_status"]').val("");
          if(status == 1){
            $('.section_status_'+id).removeClass("badge-warning").addClass("badge-info").text('Active');
          } else {
            $('.section_status_'+id).removeClass("badge-info").addClass("badge-warning").text('Hidden');
          }
          $('#edit_section_modal').modal('hide');
          $('#section_title_'+id).text(title);
        }
      }
    });
  });

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
  });

  $('#update_lesson').on('click',function(){
    var title = $('#edit_lesson_title').val();
    var id = $('#edit_lesson_ID').val();
    var status = $('#lesson_status').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/update_lesson",
      dataType : "JSON",
      data : {lesson_ID:id, lesson_title:title, status:status},
      success: function(data){
        if(data.error){
          toastr.error(data.message);
          error_sound.play();
        } else {
          toastr.success('Lesson title updated.');
          $('[name="edit_lesson_title"]').val("");
          $('[name="edit_lesson_ID"]').val("");
          $('[name="lesson_status"]').val("");
          if(status == 1){
            $('.lesson_status_'+id).removeClass("badge-warning").addClass("badge-info").text('Active');
          } else {
            $('.lesson_status_'+id).removeClass("badge-info").addClass("badge-warning").text('Hidden');
          }
          $('#edit_lesson_modal').modal('hide');
          $('#lesson_title_'+id).text(title);
        }
      }
    });
  });

  $(document).on('click','.edit_content',function() {
    var content_ID=$(this).data('id');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>courses/get_content",
      dataType : "JSON",
      data : {content_ID:content_ID},
      success: function(data){
        $('#edit_content_modal').modal('show');
        var html = '';
        if(data.url == ""){
          $('.add_video').prop("hidden", true);
          $(".add_video_button").removeClass("btn-danger").addClass("btn-primary").text('Add Video');
        } else {
          $('.add_video').prop("hidden", false);
          $(".add_video_button").removeClass("btn-primary").addClass("btn-danger").text('Remove Video');
        }

        if(data.content == ""){
          $('.add_article').prop("hidden", true);
          $(".add_article_button").removeClass("btn-danger").addClass("btn-primary").text('Add Article/Details');
        } else {
          $('.add_article').prop("hidden", false);
          $(".add_article_button").removeClass("btn-primary").addClass("btn-danger").text('Remove Article/Details');
        }

        if(data.file == ""){
          $('.add_file').prop("hidden", true);
          $(".add_file_button").removeClass("btn-danger").addClass("btn-primary").text('Add Downloadable File');
        } else {
          $('.add_file').prop("hidden", false);
          $(".add_file_button").removeClass("btn-primary").addClass("btn-danger").text('Remove Downloadable File');
        }

        $('[name="edit_content_ID"]').val(content_ID);
        $('[name="edit_content_title"]').val(data.title);
        $('[name="edit_content_url"]').val(data.url);
        $('[name="edit_content_thumbnail"]').val(data.thumbnail);
        CKEDITOR.instances['edit_content'].setData(data.content);
        $('[name="edit_content_status"]').val(data.status);
        $('[name="edit_content_files"]').val(data.file);
        $('.switch_label').text('Hidden');
        if(data.status == 1){
          $('#edit_content_status').attr("checked", "checked");
          $('.switch_label').text('Active');
        }
      }
    });
  });

  $('#update_content').on('click',function(){
      var id = $('#edit_content_ID').val();
      var title = $('#edit_content_title').val();
      var url = $('#edit_content_url').val();
      var content = CKEDITOR.instances['edit_content'].getData();
      var thumbnail = $('#edit_content_thumbnail').val();
      var files = $('#edit_content_files').val();
      var status = $('#edit_content_status').val();
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>courses/update_content",
        dataType : "JSON",
        data : {content_ID:id, title:title, url:url, content:content, files:files, thumbnail:thumbnail, status:status},
        success: function(data){
          if(data.error){
            toastr.error(data.message);
            error_sound.play();
          } else {
            toastr.success('Content updated!');
            $('[name="edit_content_ID"]').val("");
            $('[name="edit_content_title"]').val("");
            CKEDITOR.instances['edit_content'].setData(data.content);
            $('[name="edit_content_thumbnail"]').val("");
            $('[name="edit_content_files"]').val("");
            $('[name="edit_content_url"]').val("");
            $('#edit_content_modal').modal('hide');
            $('[name="edit_content_status"]').val(data.status);
            if(status == 1){
              $('.content_status_'+id).removeClass("badge-warning").addClass("badge-info").text('Active');
            } else {
              $('.content_status_'+id).removeClass("badge-info").addClass("badge-warning").text('Hidden');
            }
            $('#content_title_'+id).text(title);
          }
        }
      });
  });

  $(document).on("click", ".delete_section", function() { 
    var id=$(this).data('id');
    alert_sound.play();
    if(confirm("Are you sure you want to delete this section along with its lessons and contents?")){
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>courses/delete_section",
        dataType : "JSON",
        data : {section_ID:id},
        success: function(data){
          toastr.error('Section Deleted!');
          $(".section_"+id).empty();
        }
      });
    }
  });

  $(document).on("click", ".delete_lesson", function() { 
    var id=$(this).data('id');
    alert_sound.play();
    if(confirm("Are you sure you want to delete this lesson along with its contents?")){
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>courses/delete_lesson",
        dataType : "JSON",
        data : {lesson_ID:id},
        success: function(data){
          toastr.error('Lesson Deleted!');
          $("#mainlesson_"+id).empty();
        }
      });
    }
  });

  $(document).on("click", ".delete_content", function() { 
    var id=$(this).data('id');
    alert_sound.play();
    if(confirm("Are you sure you want to delete this content?")){
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>courses/delete_content",
        dataType : "JSON",
        data : {content_ID:id},
        success: function(data){
          toastr.error('Content Deleted!');
          $(".content_"+id).empty();
        }
      });
    }
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
        if(data.error){
          toastr.error('Section title already exist!');
          error_sound.play();
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
    $('.select_module').prop("hidden", true); 
    $('.select_course').prop("hidden", true); 
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
        if(data.error){
          toastr.error('Lesson title already exist!');
          error_sound.play();
        } else {
          toastr.success('Lesson copied successfully!');
          $('.select_module').attr('hidden');
          $('.select_course').attr('hidden');
          create_lesson(data.lesson_ID, data.section_ID, data.title);
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
    $('.select_module').prop( "hidden", true ); 
    $('.select_course').prop( "hidden", true ); 
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
        if(data.error){
          toastr.error('Content title already exist!');
          error_sound.play();
        } else {
          toastr.success('Content copied successfully!');
          create_content(data.content_ID, data.lesson_ID, data.title);
        }
        $('#copy_content_modal').modal('hide');
      }
    });
  });

  $(document).on('click','.copy_another_module',function() {
    $('.select_module').removeAttr('hidden');
  });

  $(document).on('click','.copy_another_course',function() {
    $('.select_course').removeAttr('hidden');
  });

  var x = true;
  $(document).on('click','.add_video_button', function() {
    if(x){
      $('.add_video').removeAttr('hidden');
      $(this).removeClass("btn-primary").addClass("btn-danger").text('Remove Video');
      x = false;
    } else {
      $('.add_video').prop( "hidden", true );
      $(this).removeClass("btn-danger").addClass("btn-primary").text('Add Video');
      $('[name="edit_content_thumbnail"]').val("");
      $('[name="edit_content_url"]').val("");
      $('#content_thumbnail').val('');
      $('#content_url').val('');
      x = true;
    }
  });

  var y = true;
  $(document).on('click', '.add_article_button', function() {
    if(y){
      $('.add_article').removeAttr('hidden');
      $(this).removeClass("btn-primary").addClass("btn-danger").text('Remove Article/Details');
      y = false;
    } else {
      $('.add_article').prop( "hidden", true );
      $(this).removeClass("btn-danger").addClass("btn-primary").text('Add Article/Details');
      CKEDITOR.instances['edit_content'].setData("");
      CKEDITOR.instances['content_written'].setData("");
      y = true;
    }
  });

  var z = true;
  $(document).on('click', '.add_file_button', function() {
    if(z){
      $('.add_file').removeAttr('hidden');
      $(this).removeClass("btn-primary").addClass("btn-danger").text('Remove Downloadble File');
      z = false;
    } else {
      $('.add_file').prop( "hidden", true );
      $(this).removeClass("btn-danger").addClass("btn-primary").text('Add Downloadble File');
      $('[name="edit_content_files"]').val("");
      $('#content_files').val('');
      z = true;
    }
  });

  $(document).on('click', '.cancel_create_content', function() {
    $('#create_content_modal').modal('hide');
    $('.add_video').prop("hidden", true);
    $('.add_article').prop("hidden", true);
    $('.add_file').prop("hidden", true);
    $('.add_video_button').removeClass("btn-danger").addClass("btn-primary").text('Add Article/Details');
    $('.add_article_button').removeClass("btn-danger").addClass("btn-primary").text('Add Video');
    $('.add_file_button').removeClass("btn-danger").addClass("btn-primary").text('Add Downloadble File');
  });

  $('#create_content_modal').on('shown.bs.modal', function() {
    $(document).off('focusin.modal');
  });

  $('#edit_content_modal').on('shown.bs.modal', function() {
    $(document).off('focusin.modal');
  });

});
</script>