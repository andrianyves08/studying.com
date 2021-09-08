<?php 
  $CI =& get_instance();
  $CI->load->model('qaa_model');
?>
<main class="pt-5 mx-lg-5">
  <div class="container-fluid mt-5">
    <div class="card mb-4 wow fadeIn">
      <div class="card-body d-sm-flex justify-content-between">
        <h4 class="mb-2 mb-sm-0 pt-1">
          <span><a href="<?php echo base_url();?>admin">Home</a></span>
          <span>/</span>
          <span>Question and Answer Mastersheet</span>
        </h4>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <table class="table table-bordered display" width="100%">
              <thead>
                <th style="width: 10%;">Category</th>
                <th style="width: 25%;">Question</th>
                <th style="width: 25%;">Answer</th>
                <th style="width: 10%;">Created By</th>
                <th style="width: 15%;">Last Updated</th>
     
              </thead>
              <tbody>
                <?php foreach($qaas as $qaa){ ?> 
                  <?php
                    $category = $CI->qaa_model->get_qaas_category($qaa['qaa_ID']); ?> 
                    <tr class="qaa_<?php echo $qaa['qaa_ID'];?>">
                      <td>
                        <?php foreach ($category as $row) {
                            echo ucfirst($row['name']).'<br>';
                          } ?>
                      </td>
                      <td><?php echo ucfirst($qaa['question']);?></td>
                      <td><?php echo $qaa['answer'];?></td>
                      <td><?php echo ucwords($qaa['first_name']); ?> <?php echo ucwords($qaa['last_name']); ?></td>
                      <td><span hidden><?php echo date("Y-m-d", strtotime($qaa['timestamp']));?></span><?php echo date("F d, Y h:i A", strtotime($qaa['timestamp']));?></td>
                      </td>
                    </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div><!--Container-->
</main><!--Main laypassed out-->
<script>
$(document).ready(function(){
  $("img").addClass("img-fluid").css({ 
    width: '200'
  });
});
</script>