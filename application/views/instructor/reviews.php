<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>instructor">Home</a></span>
        <span>/</span>
        <span>Reviews</span>
      </h4>
    </div>
  </div>
  <!-- Heading -->

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="pills-instructor-tab" data-toggle="pill" href="#pills-instructor" role="tab"
                aria-controls="pills-instructor" aria-selected="false">Instructor Reviews</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="pills-course-tab" data-toggle="pill" href="#pills-course" role="tab"
                aria-controls="pills-course" aria-selected="false">Course Reviews</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="pills-content-tab" data-toggle="pill" href="#pills-content" role="tab"
                aria-controls="pills-content" aria-selected="false">Content Reviews</a>
            </li>
          </ul>
          <div class="tab-content pt-2 pl-1" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-instructor" role="tabpanel" aria-labelledby="pills-instructor-tab">
              <table class="table table-bordered display" cellspacing="0" width="100%">
                <thead>
                  <th>Rating</th>
                  <th>Commnet</th>
                  <th>Reviewer Name</th>
                  <th>Timestamp</th>
                </thead>
                <tbody>
                <?php foreach($instructors as $instructor){ ?> 
                  <?php if($instructor['instructor_ID'] == $user_ID){ ?>
                  <tr>
                    <td>
                    <?php 
                        $output = '';
                        if($instructor['rating'] == 0){
                          $output .='<i class="far fa-star amber-text"></i>';
                        } else {
                          $i = 0;
                          while($instructor['rating'] > $i){
                            $output .='<i class="fas fa-star amber-text"></i>';
                            $i++;
                          }
                        }
                        echo $output;
                      ?>
                    </td>
                    <td><?php echo ucfirst($instructor['comment']);?></td>
                    <td><?php echo ucwords($instructor['reviewer_first_name']);?> <?php echo ucwords($instructor['reviewer_last_name']);?></td>
                    <td><span hidden><?php echo date("Y-m-d", strtotime($instructor['timestamp']));?></span><?php echo date("F d, Y h:i A", strtotime($instructor['timestamp']));?></td>
                  </tr>
                  <?php }?>
                <?php }?>
                </tbody>
              </table>
            </div>
            <div class="tab-pane fade" id="pills-course" role="tabpanel" aria-labelledby="pills-course-tab">
              <table class="table table-bordered display" cellspacing="0" width="100%">
                <thead>
                  <th>Course Title</th>
                  <th>Rating</th>
                  <th>Commnet</th>
                  <th>Reviewer Name</th>
                  <th>Timestamp</th>
                </thead>
                <tbody>
                <?php foreach($courses as $course){ ?> 
                  <?php if($course['instructor_ID'] == $user_ID){ ?>
                    <tr>
                      <td><?php echo ucwords($course['title']);?></td>
                      <td>
                      <?php 
                          $output = '';
                          if($course['rating'] == 0){
                            $output .='<i class="far fa-star amber-text"></i>';
                          } else {
                            $i = 0;
                            while($course['rating'] > $i){
                              $output .='<i class="fas fa-star amber-text"></i>';
                              $i++;
                            }
                          }
                          echo $output;
                        ?>
                      </td>
                      <td><?php echo ucfirst($course['comment']);?></td>
                      <td><?php echo ucwords($course['reviewer_first_name']);?> <?php echo ucwords($course['reviewer_last_name']);?></td>
                      <td><span hidden><?php echo date("Y-m-d", strtotime($course['timestamp']));?></span><?php echo date("F d, Y h:i A", strtotime($course['timestamp']));?></td>
                    </tr>
                    <?php }?>
                <?php }?>
                </tbody>
              </table>
            </div>
            <div class="tab-pane fade" id="pills-content" role="tabpanel" aria-labelledby="pills-content-tab">
               <table class="table table-bordered display" cellspacing="0" width="100%">
                <thead>
                  <th>Course Title</th>
                  <th>Content Title</th>
                  <th>Rating</th>
                  <th>Commnet</th>
                  <th>Reviewer Name</th>
                  <th>Timestamp</th>
                </thead>
                <tbody>
                  <?php foreach($contents as $content){ ?> 
                    <?php if($content['instructor_ID'] == $user_ID){ ?>
                      <tr>
                        <td><?php echo ucwords($content['course_title']);?></td>
                        <td><?php echo ucwords($content['content_title']);?></td>
                        <td>
                          <?php
                            $output = '';
                            if($content['rating'] == 0){
                              $output .='<i class="far fa-star amber-text"></i>';
                            } else {
                              $i = 0;
                              while($content['rating'] > $i){
                                $output .='<i class="fas fa-star amber-text"></i>';
                                $i++;
                              }
                            }
                            echo $output;
                          ?>
                        </td>
                        <td><?php echo ucfirst($content['comment']);?></td>
                        <td><?php echo ucwords($content['reviewer_first_name']);?> <?php echo ucwords($content['reviewer_last_name']);?></td>
                        <td><span hidden><?php echo date("Y-m-d", strtotime($content['timestamp']));?></span><?php echo date("F d, Y h:i A", strtotime($content['timestamp']));?></td>
                      </tr>
                    <?php }?>
                  <?php }?>
                </tbody>
              </table>
            </div>
          </div>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Columm-->
  </div><!--Row-->
</div><!--Container-->
</main><!--Main laypassed out-->