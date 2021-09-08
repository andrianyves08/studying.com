<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <section class="card" style="background-image: url(<?php echo base_url();?>assets/img/<?php echo $settings['background_image'];?>);background-attachment: fixed; background-position: center; background-repeat: no-repeat; background-size: cover; height: 300px;">
    <div class="card-body text-white text-center py-5 px-5 my-5">
      <h1 class="mb-4"><strong>Question and Answer Mastersheet</strong></h1>
      <p><strong>Every Dropshipping Questions</strong></p>
    </div>
  </section>
  <hr class="my-5">
  <section style="visibility: visible; animation-name: fadeIn;">
    <div class="row justify-content-center">
      <div class="col-md-7">
       
        <ul class="nav nav-pills mb-3 w-100" id="pills-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link" id="pills-all-tab" data-toggle="pill" href="#pills-all" role="tab" aria-controls="pills-all" aria-selected="false">All</a>
          </li>
          <?php foreach($categories as $category){ ?>
            <li class="nav-item">
              <a class="nav-link" id="pills-<?php echo $category['id']; ?>-tab" data-toggle="pill" href="#pills-<?php echo $category['id']; ?>" role="tab" aria-controls="pills-<?php echo $category['id']; ?>" aria-selected="false"><?php echo ucfirst($category['name']); ?></a>
            </li>
          <?php } ?>
        </ul>
        <div class="tab-content pt-2 pl-1" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
             <input class="form-control mb-4" id="listSearch" type="text" placeholder="Search" aria-label="Search">
            <div class="myList">
              <div class="mb-4 h-1">
                <div class="accordion md-accordion accordion-blocks" id="accordion" role="tablist" aria-multiselectable="true">
                <?php foreach ($qaas as $qaa) { ?>
                  <div class="card h-1 mb-2">
                    <div class="card-header white mb-1" role="tab" id="heading1">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $qaa['id'];?>" aria-expanded="true" aria-controls="collapse<?php echo $qaa['id'];?>">
                        <h5 class="mb-0 font-thin h-1 text-dark">
                        <?php echo ucfirst($qaa['question']); ?> <i class="fas fa-angle-down rotate-icon"></i>
                        </h5>
                      </a>
                    </div><!--Card Header-->
                    <div id="collapse<?php echo $qaa['id'];?>" class="collapse" role="tabpanel" aria-labelledby="heading1"
                    data-parent="#accordion">
                      <div class="card-body">
                        <?php echo $qaa['answer']; ?>
                      </div>
                    </div><!--Accordion Panel-->
                  </div><!--Card-->
                <?php } ?>
                </div><!--Accordion wrapper-->
              </div><!--H-1-->
            </div><!--My List-->
          </div>
          <?php 
            $CI =& get_instance();
            $CI->load->model('qaa_model');
            foreach($categories as $category){ 
              $qaas_by_category = $CI->qaa_model->get_qaas_by_category($category['id']);
            ?>
            <div class="tab-pane fade" id="pills-<?php echo $category['id']; ?>" role="tabpanel" aria-labelledby="pills-<?php echo $category['id']; ?>-tab">
              <?php foreach ($qaas_by_category as $row) { ?>
                <div class="card h-1 mb-2">
                  <div class="card-header white mb-1" role="tab" id="heading1">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $row['id'];?>" aria-expanded="true" aria-controls="collapse<?php echo $row['id'];?>">
                      <h5 class="mb-0 font-thin h-1 text-dark">
                      <?php echo ucfirst($row['question']); ?> <i class="fas fa-angle-down rotate-icon"></i>
                      </h5>
                    </a>
                  </div><!--Card Header-->
                  <div id="collapse<?php echo $row['id'];?>" class="collapse" role="tabpanel" aria-labelledby="heading1"
                  data-parent="#accordion">
                    <div class="card-body">
                      <?php echo $row['answer']; ?>
                    </div>
                  </div><!--Accordion Panel-->
                </div><!--Card-->
              <?php } ?>
            </div>
          <?php } ?>
        </div>
      </div><!--Grid column-->
    </div><!--Grid row-->
  </section><!--Section: Jumbotron-->
</div><!--Container-->
</main><!--Main layout-->
<script type="text/javascript">
$(document).ready(function(){
  $("#listSearch").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".myList .h-1").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
 }); 
</script>