<script src="https://www.paypal.com/sdk/js?client-id=AeBE-KxTCLc2Fk_W932IJ8TCxeBgYgo8v-_V2MNVBzDHNRdwz6L0VM_nqJ6aRBcRIbV2Ku3mFkIiGNB-">
</script>
<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <section class="wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
    <div class="row justify-content-center">
      <div class="col-lg-4">
        <div class="card mb-5 pb-5">
          <div class="view overlay">
            <img class="card-img-top" alt="<?php echo $course['slug']; ?> image" src="<?php echo $course['image']; ?>" onerror="this.onerror=null;this.src='<?php echo base_url();?>assets/img/logo-3.jpg';">
            <a href="#!">
              <div class="mask rgba-white-slight"></div>
            </a>
          </div>
          <div class="card-body">
            <h2 class="h2-responsive text-center text-md-left product-name font-weight-bold dark-grey-text mb-1 ml-xl-0 ml-4">
              <strong><?php echo ucwords($course['title']); ?></strong>
            </h2>
            <p class="card-text mb-2"><?php echo ucfirst($course['description']); ?></p>
            <h3 class="h3-responsive text-center text-md-left ml-xl-0 ml-4">
              <span class="red-text font-weight-bold">
                <strong>$<?php echo $course['price']; ?></strong>
              </span>
            </h3>
            <?php if($course['price'] == 0){ ?>
              <button type="button" class="btn btn-secondary" id="free_course">Enroll Now</button>
            <?php } else { ?>
              <div id="paypal-button-container"></div>
            <?php } ?>
          </div>
        </div>
        <!-- Card -->
      </div><!--Column-->
    </div><!--Row-->
  </section>
</div><!--Container-->
</main><!--Main layout-->
<script>
paypal.Buttons({
  createOrder: function(data, actions) {
    return actions.order.create({
      purchase_units: [{
        amount: {
          value: '<?php echo $course['price']; ?>'
        }
      }]
    });
  },
  onApprove: function (data, actions) {
    return actions.order.capture().then(function (details) {
      $.ajax({
        type : "POST",
        url  : "<?=base_url()?>purchase/purhase",
        dataType : "JSON",
        data : {order:details.id, id:<?php echo $course['course_ID']; ?>},
        success: function(data){
          window.location.replace("<?php echo base_url(); ?>course/checkout/success");
        }
      });
    })
  }
}).render('#paypal-button-container'); // Display payment options on your web page
</script>
<?php if($course['price'] == 0){ ?>
<script type='text/javascript'>
$(document).ready(function(){
  $('#free_course').on('click',function(){
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>purchase/enroll",
      dataType : "JSON",
      data : {id:<?php echo $course['course_ID']; ?>},
      success: function(data){
        window.location.replace("<?php echo base_url(); ?>course/checkout/success");
      }
    });
  });
});
</script>
<?php } ?>