<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>admin">Home</a></span>
        <span>/</span>
        <span><a href="<?php echo base_url();?>admin/course">Course</a></span>
        <span>/</span>
        <span><a href="<?php echo base_url();?>admin/course"><?php echo ucwords($course['title']);?></a></span>
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
        <div data-section-id="<?php echo $section["id"]; ?>" class="card sortsection">
          <div class="card-header" role="tab" id="mainsection<?php echo $section['id'];?>">
            <div class="float-right">
              <?php if($section['status'] == 1){ ?>
                <span class="badge badge-pill mr-2 badge-info">Active</span>
              <?php } else { ?>
                <span class="badge badge-pill mr-2 badge-warning">Hidden</span>
              <?php } ?>
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
                  <div class="accordion md-accordion sortlessons" id="mainlesson<?php echo $lesson['id'];?>" role="tablist" aria-multiselectable="true" style="padding-left: 15px;" data-lesson-id="<?php echo $lesson["id"]; ?>">
                    <div class="float-right">
                      <?php if($lesson['status'] == 1){ ?>
                        <span class="badge badge-pill mr-2 badge-info">Active</span>
                      <?php } else { ?>
                        <span class="badge badge-pill mr-2 badge-warning">Hidden</span>
                      <?php } ?>
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
                          <div class="row sortcontent" data-content-id="<?php echo $content["id"]; ?>">
                            <ul class="list-group align-middle" role="tablist" style="padding-left: 25px;">
                              <li style="cursor: all-scroll; padding: 0;margin: 0;" class="border-bottom sortcontentpart" ><h5><?php echo $content['title'];?></h5> </li>
                            </ul>
                            <div class="col-4 float-right">
                              <?php if($content['status'] == 1){ ?>
                                <span class="badge badge-pill mr-2 badge-info">Active</span>
                              <?php } else { ?>
                                <span class="badge badge-pill mr-2 badge-warning">Hidden</span>
                              <?php } ?>
                            </div>
                          </div>
                          <?php } ?>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              <?php } ?>
            </div>
          </div>
        </div><!-- Accordion card -->    
      <?php } ?>
      </div>
    </div><!--Grid column-->
  </div><!--Grid row-->
</div><!--Container-->
</main><!--Main laypassed out-->