<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>admin">Home</a></span>
        <span>/</span>
        <span><a href="<?php echo base_url();?>admin/blogs">Blogs</a></span>
      </h4>
    </div>
  </div>
  <!-- Heading -->
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <table class="table table-bordered display table-responsive-md" cellspacing="0" width="100%">
            <thead>
              <th>ID</th>
              <th>Title</th>
              <th>Date Uploaded</th>
              <th>Uploaded By</th>
              <th></th>
            </thead>
            <tbody>
              <?php foreach($blogs as $blog){ ?> 
                <?php if($blog['blog_status'] == 0){ ?> 
                  <tr class="table_header_<?php echo $blog['blog_ID'];?>">
                    <td><?php echo $blog['blog_ID'];?></td>
                    <td><?php echo ucfirst($blog['title']);?></td>
                    <td><?php echo $blog['timestamp'];?></td>
                    <td><?php echo ucwords($blog['first_name']);?> <?php echo ucwords($blog['last_name']);?></td>
                    <td>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <a class="btn btn-sm btn-primary" href="<?php echo base_url('admin/blogs/edit'); ?>/<?php echo $blog['blog_ID'];?>"> Edit</a>
                          <a class="btn btn-sm btn-success restore_blog" data-id="<?php echo $blog['blog_ID']; ?>">Restore</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php }?>
              <?php }?>
            </tbody>
          </table>
          <a class="btn btn-primary" href="<?php echo base_url(); ?>admin/blogs/create">Create Blog</a>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main><!--Main laypassed out-->
<!-- restore Module -->
<div data-backdrop="static" class="modal fade" id="restore_blog_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-success" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Restore Module</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to restore this Blog?</p>
        <input type="hidden" class="form-control" name="blog_ID" id="blog_ID" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="restore_blog">Confirm</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
  $(document).on("click", ".restore_blog", function() { 
    var id=$(this).data('id');
    $('#restore_blog_modal').modal('show');
    $('[name="blog_ID"]').val(id);
  });
  $("#restore_blog").click(function(){
    var blog_ID = $('#blog_ID').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>blog/restore_blog",
      dataType : "JSON",
      data : {blog_ID:blog_ID},
      success: function(data){
        $('#restore_blog_modal').modal('hide');
        toastr.success('Blog restored!');
        $('.table_header_'+blog_ID).empty();
      }
    });
  });
});
</script>