<main class="pt-5 mx-lg-5">
  <div class="container-fluid mt-5">
    <div class="card mb-4 wow fadeIn">
      <div class="card-body d-sm-flex justify-content-between">
        <h4 class="mb-2 mb-sm-0 pt-1">
          <span><a href="<?php echo base_url();?>admin">Home</a></span>
          <span>/</span>
          <span>Order</span>
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
                <th style="width: 15%;">ID</th>
                <th style="width: 20%;">Full Name</th>
                <th style="width: 25%;">Course</th>
                <th style="width: 20%;">Date Enrolled</th>
                <th style="width: 20%;"></th>
              </thead>
              <tbody>
              <?php foreach($orders as $row){ ?> 
                <tr>
                  <td><?php 
                    $current = strtotime(date("Y-m-d"));
                    $date    = strtotime($row['date_enrolled']);
                    $datediff = $date - $current;
                    $difference = floor($datediff/(60*60*24));
                    if($difference == 0){
                      echo '<span class="badge badge-danger">New</span> ';
                    }
                    echo $row['purchase_ID'];?>
                  </td>

                  <td><?php echo ucwords($row['first_name']);?> <?php echo ucwords($row['last_name']);?></td>
                  <td><?php echo $row['title'];?></td>
                  <td><span hidden><?php echo date("'Y-m-d", strtotime(changetimefromUTC($row['date_enrolled'], $timezone)));?></span>
                    <?php echo changetimefromUTC($row['date_enrolled'], $timezone);?></td>
                  <td><a class="btn btn-sm btn-primary" href="<?php echo base_url(); ?>admin/users/<?php echo $row['user_ID'];?>"> View User Profile</a></td>
                </tr>
              <?php }?>
              </tbody>
            </table>
          </div><!--Card Body-->
        </div><!--Card-->
      </div><!--Column-->
    </div><!--Row-->
  </div><!--Container-->
</main><!--Main laypassed out-->