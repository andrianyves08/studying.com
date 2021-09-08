<!-- Bootstrap tooltips -->
<script type="text/javascript" src="<?php echo base_url('/assets/admin/js/popper.min.js'); ?>"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="<?php echo base_url('/assets/admin/js/bootstrap.min.js'); ?>"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="<?php echo base_url('/assets/admin/js/mdb.min.js'); ?>"></script>
<!-- Initializations -->
<script type="text/javascript">
  new WOW().init();
</script>
<!-- DataTables JS -->
<script src="<?php echo base_url('/assets/admin/js/addons/datatables.min.js'); ?>" type="text/javascript"></script>
<!-- DataTables Select JS -->
<script src="<?php echo base_url('/assets/admin/js/addons/datatables-select.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('/assets/admin/plugins/rowreorder/js/dataTables.rowReorder.min.js'); ?>" type="text/javascript"></script>
<!-- Select2 -->
<script src="<?php echo base_url('/assets/plugins/select2/js/select2.full.min.js'); ?>"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script>
$(function () {
  $('.select2').select2()
})
</script>
<script type="text/javascript">
$(document).ready(function() {
  $('table.display').DataTable( {
    "order": [],
  });
});
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

</script>
<script src="<?php echo base_url('/assets/plugins/chart.js/Chart.min.js'); ?>"></script>
<?php if($this->session->flashdata('multi')): ?>
  <?php echo $this->session->flashdata('multi'); ?>
<?php endif; ?>
<script type="text/javascript">
  error_sound = new Audio("<?php echo base_url();?>assets/img/software_remove.wav");
  success_sound = new Audio("<?php echo base_url();?>assets/img/software_back.wav");
  alert_sound = new Audio("<?php echo base_url();?>assets/img/software_start.wav");
</script>
<script type="text/javascript">
function open_popup(url){
  var w = 880;
  var h = 570;
  var l = Math.floor((screen.width - w) / 2);
  var t = Math.floor((screen.height - h) / 2);
  var win = window.open(url, 'ResponsiveFilemanager', "scrollbars=1,width=" + w + ",height=" + h + ",top=" + t + ",left=" + l);
}
</script>
<script type="text/javascript">
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        } else {
          event.preventDefault();
          return true;
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>
<!-- Developed By: Andrian Yves Macalino, andrianyvesmacalino@gmail.com -->
  </body>
</html>