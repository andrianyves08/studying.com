<?php 
  $CI =& get_instance();
  $CI->load->model('qaa_model');
?>
<main class="pt-5 mx-lg-5">
  <div class="container-fluid mt-5">
    <div class="card mb-4 wow fadeIn">
      <div class="card-body d-sm-flex justify-content-between">
        <h4 class="mb-2 mb-sm-0 pt-1">
          <span><a href="<?php echo base_url();?>instructor">Home</a></span>
          <span>/</span>
          <span>Question and Answer Mastersheet</span>
        </h4>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <table class="table table-bordered display table-responsive-md" width="100%">
              <thead>
                <th>Category</th>
                <th>Question</th>
                <th>Answer</th>
                <th>Created By</th>
                <th>Last Updated</th>
                <th></th>
              </thead>
              <tbody>
                <?php foreach($qaas as $qaa){ ?> 
                  <?php if($qaa['user_ID'] == $user_ID && $qaa['status'] == 1){ 
                    $category = $CI->qaa_model->get_qaas_category($qaa['qaa_ID']); ?> 
                    <tr class="qaa_<?php echo $qaa['qaa_ID'];?>">
                      <td>
                        <?php foreach ($category as $row) {
                            echo ucfirst($row['name']).'<br>';
                          }
                        ?>
                      </td>
                      <td><?php echo ucfirst($qaa['question']);?></td>
                      <td><?php echo $qaa['answer'];?></td>
                      <td><?php echo ucwords($qaa['first_name']); ?> <?php echo ucwords($qaa['last_name']); ?></td>
                      <td><span hidden><?php echo date("Y-m-d", strtotime($qaa['timestamp']));?></span><?php echo date("F d, Y h:i A", strtotime($qaa['timestamp']));?></td>
                      <td>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <a class="btn btn-sm btn-primary" href="<?php echo base_url('instructor/question-and-answer-mastersheet'); ?>/<?php echo $qaa['qaa_ID'];?>">Edit</a>
                            <a class="btn btn-sm btn-danger delete_qaa" data-id="<?php echo $qaa['qaa_ID'];?>">Delete</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  <?php } ?>
                <?php } ?>
              </tbody>
            </table>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create_qaa_modal">Create Question</button>
          </div>
        </div>
      </div>
    </div>
  </div><!--Container-->
</main><!--Main laypassed out-->
<!-- Are you sure -->
<div class="modal fade" id="create_qaa_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p class="heading lead">Create QaA</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>
      <form class="needs-validation" novalidate>
        <div class="modal-body">
          <div class="form-group">
            <label for="formGroupExampleInput">Question</label>
            <input type="text" class="form-control" name="question" id="question" required>
            <div class="invalid-feedback">
              Required
            </div>
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Category</label>
            <div class="input-group mb-4" style="width: 100%;">
              <select class="browser-default custom-select select2" name="category[]" id="category" multiple="multiple" data-placeholder="Select a Category" style="width: 100%;">
                <?php foreach ($categories as $category) { ?>
                  <option class="sub_category_<?php echo $category['id']; ?>" value="<?php echo $category['id']; ?>"><?php echo ucwords($category['name']); ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="answer">Answer</label>
            <textarea class="textarea mb-4" name="answer" id="answer" required></textarea>
            <div class="invalid-feedback">
              Required
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-center">
          <a type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</a>
          <button class="btn btn-success waves-effect" id="create_qaa"><i class="fa fa-check-square-o"></i>Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
CKEDITOR.replace('answer' ,{
  filebrowserBrowseUrl : '<?php echo base_url('vendors/dialog.php?type=2&editor=ckeditor&fldr='); ?>',
  filebrowserUploadUrl : '<?php echo base_url('vendors/dialog.php?type=2&editor=ckeditor&fldr='); ?>',
  filebrowserImageBrowseUrl : '<?php echo base_url('vendors/dialog.php?type=1&editor=ckeditor&fldr='); ?>'
});
</script>
<script>
$(document).ready(function(){
  $("img").addClass("img-fluid").css({ 
    width: '200',
    height: 'auto'
  });

  $(document).on("click", ".delete_qaa", function() { 
    var id=$(this).data('id');
    alert_sound.play();
    if(confirm("Are you sure you want to delete this?")){
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>qaa/delete_qaa",
        dataType : "JSON",
        data : {id:id},
        success: function(data){
          toastr.error('Deleted!');
          $(".qaa_"+id).empty();
        }
      });
    }
  });

  $('#create_qaa').on('click',function(){
    var question = $('#question').val();
    var category = $('#category').val();
    var answer = CKEDITOR.instances['answer'].getData();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>qaa/create_qaa",
      dataType : "JSON",
      data : {question:question, category:category, answer:answer},
      success: function(data){
        if(data.error){
          toastr.error(data.message);
          error_sound.play();
        } else {
          toastr.success('qaa created!');
          location.reload();
        }
      }
    });
  });
});
</script>