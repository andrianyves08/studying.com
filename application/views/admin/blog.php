<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>admin">Home</a></span>
        <span>/</span>
        <span>Blogs</span>
      </h4>
      <h4 class="mb-2 mb-sm-0 pt-1 float-right">
        <span><a href="<?php echo base_url();?>admin/blogs-archive">Archive</a></span>
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
              <th>Meta Description</th>
              <th>Meta Keywords</th>
              <th>Categories</th>
              <th>Date Uploaded</th>
              <th>Uploaded By</th>
              <th></th>
            </thead>
            <tbody>
              <?php 
                $CI =& get_instance();
                $CI->load->model('blog_model');
                foreach($blogs as $blog){ 
                  $categories = $CI->blog_model->get_blog_to_categories($blog['blog_ID']);
                ?> 
                <?php if($blog['blog_status'] == 1){ ?> 
                  <tr class="table_header_<?php echo $blog['blog_ID'];?>">
                    <td><?php echo $blog['blog_ID'];?></td>
                    <td><?php echo ucfirst($blog['title']);?></td>
                    <td><?php echo ucfirst($blog['meta_description']);?></td>
                    <td><?php echo ucwords($blog['meta_keywords']);?></td>
                    <td>
                      <?php foreach($categories as $category){ ?> 
                        <?php echo '• '.ucwords($category['name']) ;?><br>
                      <?php } ?>
                    </td>
                    <td><span hidden><?php echo date("Y-m-d", strtotime($blog['timestamp']));?></span><?php echo date("F d, Y h:i A", strtotime($blog['timestamp']));?></td>
                    <td><?php echo ucwords($blog['first_name']);?> <?php echo ucwords($blog['last_name']);?></td>
                    <td>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <a class="btn btn-sm btn-primary" href="<?php echo base_url('admin/blogs/edit'); ?>/<?php echo $blog['blog_ID'];?>"> Edit</a>
                          <a class="btn btn-sm btn-info delete_blog" data-id="<?php echo $blog['blog_ID']; ?>">Archive</a>
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
<script type="text/javascript">
$(document).ready(function() {
  $(document).on("click", ".delete_blog", function() { 
    var id=$(this).data('id');
    alert_sound.play();
    if(confirm("Are you sure you want to archive this Blog?")){
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>blog/delete_blog",
        dataType : "JSON",
        data : {blog_ID:id},
        success: function(data){
          toastr.success('Blog deleted!');
          $('.table_header_'+id).empty();
        }
      });
    }
  });
});
</script>