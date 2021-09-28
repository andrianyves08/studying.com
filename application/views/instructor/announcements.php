<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <div class="card mb-4 wow fadeIn">
    <div class="card-body d-sm-flex justify-content-between">
      <h4 class="mb-2 mb-sm-0 pt-1">
        <span><a href="<?php echo base_url();?>instructor">Home</a></span>
        <span>/</span>
        <span>Announcements</span>
      </h4>
    </div>
  </div>
  <!-- Heading -->
  <div class="row">
    <div class="col-md-12">
      <div class="card mb-4">
        <div class="card-body">
          <?php echo form_open('instructor/update_announcement'); ?> 
            <textarea class="textarea mb-4 pb-4 announcement" name="announcement" id="announcement" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $details['announcement'];?></textarea>
            <button class="btn btn-outline-primary waves-effect " type="submit">Save Changes</button>
          <?php echo form_close(); ?>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h3>Mastermind Call Schedule</h3>
         <table class="table table-sm" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th scope="col">Day</th>
              <th scope="col">Time</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($schedules as $row){ ?>
            <tr class="id_<?php echo $row['id']; ?>">
              <td><?php 
              switch ($row['day']) {
                case '2021-09-20':
                  echo 'Monday';
                  break;
                case '2021-09-21':
                  echo 'Tuesday';
                  break;
                case '2021-09-22':
                  echo 'Wednesday';
                  break;
                case '2021-09-23':
                  echo 'Thursday';
                  break;
                case '2021-09-24':
                  echo 'Friday';
                  break;
                case '2021-09-25':
                  echo 'Saturday';
                  break;
                default:
                  echo 'Sunday';
              }
              ?></td>
              <td><?php echo $row['time'];?></td>
              <td>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <a class="btn btn-sm btn-danger delete_schedule" data-id="<?php echo $row['id']; ?>">Delete</a>
                  </div>
                </div>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#add_schedule_modal">Add more Schedule</a>
        </div><!--Card Body-->
      </div><!--Card-->
    </div><!--Column-->
  </div><!--Row-->
</div><!--Container-->
</main>

<div data-backdrop="static" class="modal fade" id="add_schedule_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg modal-notify" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="myModalLabel">Add Schedule</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>      
      <div class="modal-body">
        <div class="form-group">
          <label>Day</label>
          <select class="browser-default custom-select" id="day">
            <option selected disabled>Select Day</option>
            <option value="2021-09-20">Monday</option>
            <option value="2021-09-21">Tuesday</option>
            <option value="2021-09-22">Wednesday</option>
            <option value="2021-09-23">Thursday</option>
            <option value="2021-09-24">Friday</option>
            <option value="2021-09-25">Saturday</option>
            <option value="2021-09-26">Sunday</option>
          </select>
        </div>
        <div class="form-group">
          <label>Time</label>
          <input type="text" class="form-control" id="time" name="time" />
        </div>
        <div class="form-group">
          <label>Note</label>
          <input type="text" class="form-control" id="note" name="note" />
        </div>
        <input type="hidden" class="form-control" name="timezone" id="timezone" value="<?php echo $my_info['timezone']; ?>"/>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm" type="submit" id="create_schedule">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script>
CKEDITOR.config.disableNativeSpellChecker = false;
CKEDITOR.replace('announcement' ,{
  toolbar: [{name: 'document', items: ['Undo', 'Redo']},{name: 'links', items: ['EmojiPanel', 'Link', 'Unlink']}],
});
</script>
<script type="text/javascript">
$(document).ready(function() {
   $('#time').timepicker({
      timeFormat: 'h:mm:ss p',
      interval: 60,
      minTime: '10',
      maxTime: '6:00pm',
      defaultTime: '11',
      startTime: '10:00',
      dynamic: false,
      dropdown: false,
      scrollbar: true
  });

  $('#create_schedule').on('click',function(){
    var day = $('#day').val();
    var time = $('#time').val();
    var timezone = $('#timezone').val();
    var note = $('#note').val();
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>instructor/create_schedule",
      dataType : "JSON",
      data : {day:day, time:time, timezone:timezone, note:note},
      success: function(data){
        if(data.error){
          toastr.error(data.message);
          error_sound.play();
        } else {
          toastr.success('Schedule added!');
          location.reload();
        }
      }
    });
  });

  $(document).on("click", ".delete_schedule", function() { 
    var id=$(this).data('id');
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>instructor/delete_schedule",
      dataType : "JSON",
      data : {id:id},
      success: function(data){
        toastr.success('Schedule deleted!');
        $(".id_"+id).remove();
      }
    });
  });

});
</script>