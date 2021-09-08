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
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h4 class="mb-2">
            <span>Modules</span>
          </h4>
          <table class="table table-bordered table-responsive-md" cellspacing="0" width="100%">
            <thead>
            <th>ID</th>
            <th>Sort Number</th>
            <th>Title</th>
            <th>Status</th>
            <th>Date Modified</th>
            <th></th>
            </thead>
            <tbody>
            <?php foreach ($modules as $module){ ?>
              <tr>
                <td><?php echo ucfirst($module['id']);?></td>
                <td><?php echo $module['sort'];?></td>
                <td><?php echo ucfirst($module['title']);?></td>
                <td class="text-center">
                <?php if($module['status'] == 0){?>
                  <span class="badge badge-pill badge-danger">Inactive</span>
                <?php } else { ?>
                  <span class="badge badge-pill badge-success">Active</span>
                <?php } ?>
                </td>
                <td><?php echo date("F d, Y h:i A", strtotime($module['date_modified']));?></td>
                <td>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <a class="btn btn-sm btn-success" href='<?php echo base_url(); ?>admin/course/<?php echo $course['slug'];?>/<?php echo $module['slug'];?>'>View</a>
                    </div>
                  </div>
                </td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main><!--Main laypassed out-->