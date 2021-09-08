<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>admin">Home</a></span>
        <span>/</span>
        <span>Category</span>
      </h4>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">

          <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Course</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Blogs</a>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active p-1 mt-4" id="home" role="tabpanel" aria-labelledby="home-tab">
                <table class="table table-bordered display table-responsive-md" cellspacing="0" width="100%">
                  <thead>
                    <th>Name</th>
                    <th>Date Modified</th>
                    <th></th>
                  </thead>
                  <tbody>
                  <?php foreach ($categories as $category) {
                    if($category['type'] == 1){ ?>
                    <tr>
                      <td><?php echo ucwords($category['name']); ?></td>
                      <td><?php echo date("F d, Y h:i A", strtotime($category['timestamp']));?></td>
                      <td>
                        <a class="btn btn-sm btn-primary update_category" data-id="<?php echo $category['id']; ?>" data-name="<?php echo $category['name']; ?>">Edit</a>
                      </td>
                    </tr>
                  <?php } } ?>
                  </tbody>
                </table>
              </div>
              <div class="tab-pane fade p-1 mt-4" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                 <table class="table table-bordered display table-responsive-md" cellspacing="0" width="100%">
                  <thead>
                    <th>Name</th>
                    <th>Date Modified</th>
                    <th></th>
                  </thead>
                  <tbody>
                  <?php foreach ($categories as $category) {
                    if($category['type'] == 2){ ?>
                    <tr>
                      <td><?php echo ucwords($category['name']); ?></td>
                      <td><?php echo date("F d, Y h:i A", strtotime($category['timestamp']));?></td>
                      <td>
                        <a class="btn btn-sm btn-primary update_category" data-id="<?php echo $category['id']; ?>" data-name="<?php echo $category['name']; ?>">Edit</a>
                      </td>
                    </tr>
                  <?php } } ?>
                  </tbody>
                </table>
              </div>
            </div>


          
          <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#create_category">Create Category</a>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main><!--Main laypassed out-->
<!-- Are you sure -->
<div class="modal fade" id="create_category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Create Category</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart('courses/create_category'); ?>
          <div class="form-group">
            <label for="formGroupExampleInput">* Name</label>
            <input type="text" class="form-control" name="name" required>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">* Type</label>
            <select class="browser-default custom-select" name="type" required>
              <option value="1">Course</option>
              <option value="2">Blog</option>
            </select>
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

<div class="modal fade" id="update_category_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Update Category</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;
        </span>
        </button>
      </div>
      <?php echo form_open_multipart('courses/update_category'); ?>
      <div class="modal-body mx-3">
        <div class="form-group">
          <label for="formGroupExampleInput">* Name</label>
          <input type="hidden" class="form-control" name="category_ID">
          <input type="text" class="form-control" name="edit_name">
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Cancel</button>
        <button class="btn btn-outline-primary waves-effect">Update</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div><!--Modal-->

<script type="text/javascript">
$(document).ready(function() {
  $(document).on("click", ".update_category", function() { 
    var id=$(this).data('id');
    var name=$(this).data('name');
    $('[name="category_ID"]').val(id);
    $('[name="edit_name"]').val(name);
    $('#update_category_modal').modal('show');
  });
});
</script>