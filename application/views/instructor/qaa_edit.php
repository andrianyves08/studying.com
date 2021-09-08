<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <a href="<?php echo base_url(); ?>instructor">Home</a>
        <span>/</span>
        <a href="<?php echo base_url(); ?>instructor/question-and-answer-mastersheet"><span> Back</span></a>
      </h4>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <form class="needs-validation" novalidate>
             <input type="hidden" class="form-control" name="qaa_ID" id="qaa_ID" value="<?php echo $qaa['qaa_ID']; ?>">
            <div class="form-group mb-4">
              <label for="formGroupExampleInput">Question</label>
              <input type="text" class="form-control" name="question" id="question" value="<?php echo ucwords($qaa['question']); ?>" required>
              <div class="invalid-feedback">
                Required
              </div>
            </div>
            <div class="form-group">
              <label for="formGroupExampleInput">Category</label>
              <div class="input-group mb-4" style="width: 100%;">
                <select class="browser-default custom-select select2" name="category[]" id="category" multiple="multiple" data-placeholder="Select a Category" style="width: 100%;" required>
                  <?php foreach($qaa_categories as $row){ ?> 
                    <option value="<?php echo $row['id']; ?>" selected><?php echo ucwords($row['name']); ?></option>
                  <?php } ?>
                  <?php foreach($categories as $category){
                    if (array_search($category['id'], array_column($qaa_categories, 'id')) === FALSE){ ?>
                      <option value="<?php echo $category['id']; ?>"><?php echo ucwords($category['name']); ?></option>
                    <?php } } ?>
                </select>
                <div class="invalid-feedback">
                  Required
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="answer">Answer</label>
              <textarea class="textarea mb-4" name="answer" id="answer" required><?php echo $qaa['answer']; ?></textarea>
              <div class="invalid-feedback">
                Required
              </div>
            </div>
            <button class="btn btn-primary waves-effect mt-4" id="update_qaa" type="submit">Save Changes</button>
          </form>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main>
<script>
CKEDITOR.replace('answer' ,{
  filebrowserBrowseUrl : '<?php echo base_url('vendors/dialog.php?type=2&editor=ckeditor&fldr='); ?>',
  filebrowserUploadUrl : '<?php echo base_url('vendors/dialog.php?type=2&editor=ckeditor&fldr='); ?>',
  filebrowserImageBrowseUrl : '<?php echo base_url('vendors/dialog.php?type=1&editor=ckeditor&fldr='); ?>'
});
</script>
<script>
$(document).ready(function(){
  $('#update_qaa').on('click',function(){
    var qaa_ID = $('#qaa_ID').val();
    var question = $('#question').val();
    var category = $('#category').val();
    var answer = CKEDITOR.instances['answer'].getData();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>qaa/update_qaa",
      dataType : "JSON",
      data : {qaa_ID:qaa_ID, question:question, category:category, answer:answer},
      success: function(data){
        if(data.error){
          toastr.error(data.message);
          error_sound.play();
        } else {
          toastr.success('qaa updated!');
         location.reload();
        }
      }
    });
  });
});
</script>