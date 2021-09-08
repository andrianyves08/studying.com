<!-- Rate portal -->
<div data-backdrop="static" class="modal fade" id="rate_us" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Rate the new portal!</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo form_open_multipart('pages/send_rating'); ?>
        <p>Your feedback is a huge help for providing the most innovating educational experiences.</p>
        <p>Provide us Your solutions as well.</p>
        <span id="rateMe1" class="mb-4"></span>
        <input type="hidden" id="rating_page" name="rating_page" value="1">
        <input type="hidden" id="feedback_rating" name="feedback_rating">
        <div class="form-group">
          <textarea class="form-control rounded-0" name="feedback" id="feedback" rows="5" placeholder="Enter your feedback..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="ask_me_later">Logout</button>
        <button type="submit" class="btn btn-primary btn-sm">Send Feedback</button>
      <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/mdb.min.js"></script>
<!-- Initializations -->
<script type="text/javascript">
  new WOW().init();
</script>
<!-- Select2 -->
<script src="<?php echo base_url();?>assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.js"></script>
<!-- DataTables JS -->
<script src="<?php echo base_url('/assets/admin/js/addons/datatables.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/plugins/slick/slick.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/lazyframe.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/addons/rating.js"></script>

<script type="text/javascript">
lazyframe('.lazyframe', {
  apikey: 'AIzaSyB-iDku_44LtvJZ00FXc1G9UOjqDv3ttas'
});
</script>
<script type="text/javascript">
  error_sound = new Audio("<?php echo base_url();?>assets/img/software_remove.wav");
  success_sound = new Audio("<?php echo base_url();?>assets/img/software_back.wav");
  alert_sound = new Audio("<?php echo base_url();?>assets/img/software_start.wav");
  level_up = new Audio("<?php echo base_url();?>assets/img/lvlup.wav");
</script>

<script type="text/javascript">
$(document).ready(function() {
  $('.select2').select2();
  $('[data-toggle="tooltip"]').tooltip();
  $('table.display').DataTable();

  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });

  $('.button_press').on('click', function() {
    var id = $(this).data('id');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>pages/button_press",
      dataType : "JSON",
      data:{id:id},
      success: function(data){
      }
    });
  });

  //Seen Post
  $('#seen_notification').on('click',function(){
    $.ajax({
      url:"<?=base_url()?>notification/seen",
      method:"POST",
      dataType : 'json',
      success:function(data) { 
      $('#notification_bell').remove();    
      }
    })
  });

  $(document).on('click', '.notifier', function(){
    var href = $(this).data('url');
    window.location.href = href;
  });

  setInterval(function(){
    $.ajax({
      type  : 'post',
      url   : "<?=base_url()?>users/update_user_status",
      async : true,
      dataType : 'json',
      success : function(data){
      }
    });
  }, 60000);

  get_level();
  $('#rateMe1').mdbRate();
  $('#rateMe1').hover(function() {
    var count = $('#rateMe1 .amber-text').length;
    $('[name="feedback_rating"]').val(count);
  });
  $('#user_logout').on('click',function(){
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>pages/rating",
      dataType : "JSON",
      success: function(data){
        if(data && data !=""){
          window.location.href = "<?php echo base_url(); ?>logout";
        } else  {
          $('#rate_us').modal('show');         
        }
      }
    });
    return false;
  });
  $('#ask_me_later').on('click',function(){
    window.location.href = "<?php echo base_url(); ?>logout";
  });
});
</script>
<script type="text/javascript">
function get_level(){
  $.ajax({
    type  : 'POST',
    url   : "<?=base_url()?>users/get_level",
    dataType : 'json',
    success : function(data){
      $('#my_level').html(data);
    }
  });
}
</script>
<script type="text/javascript">
function nanogallery(id, images) {
  $("#nanogallery_"+id).nanogallery2({
    items: images,
    galleryMaxRows: 2,
    galleryDisplayMode: 'rows',
    thumbnailAlignment: 'center',
    thumbnailHeight: '300', thumbnailWidth: '300',
    thumbnailBorderHorizontal: 0, thumbnailBorderVertical: 0,
    thumbnailLabel: { display: false },
    position: 'onBottom',
    // LIGHTBOX
    viewerToolbar: { display: false },
    viewerTools:    {
      topLeft:   'label',
      topRight:  'rotateLeft, rotateRight, fullscreenButton, closeButton'
    },
    // GALLERY THEME
    galleryTheme : { 
      thumbnail: { background: '#111' },
    },
  });
}
</script>
<script type="text/javascript">
const preloader = document.querySelector('.preloader');
const fadeEffect = setInterval(() => {
  // if we don't set opacity 1 in CSS, then   //it will be equaled to "", that's why we   // check it
  if (!preloader.style.opacity) {
    preloader.style.opacity = 1;
  }
  if (preloader.style.opacity > 0) {
    preloader.style.opacity -= 0.1;
  } else {
    clearInterval(fadeEffect);
  }
   preloader.classList.add("loaded");
}, 5);
</script>
<script type="text/javascript">
$(function() {  
  <?php if($this->session->flashdata('success')): ?>
    <?php echo "toastr.success('".$this->session->flashdata('success')." ')"; ?>
  <?php endif; ?>
  <?php if($this->session->flashdata('error')): ?>
    <?php echo "toastr.error('".$this->session->flashdata('error')." ')"; ?>
  <?php endif; ?>  
});
</script>
<?php if($this->session->flashdata('multi')): ?>
  <?php echo $this->session->flashdata('multi'); ?>
<?php endif; ?>
<!-- Developed By: Andrian Yves Macalino, andrianyvesmacalino@gmail.com -->
  </body>
</html>