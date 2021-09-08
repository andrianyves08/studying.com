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
                case 1:
                  echo 'Monday';
                  break;
                case 2:
                  echo 'Tuesday';
                  break;
                case 3:
                  echo 'Wednesday';
                  break;
                case 4:
                  echo 'Thursday';
                  break;
                case 5:
                  echo 'Friday';
                  break;
                case 6:
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
            <option value="1">Monday</option>
            <option value="2">Tuesday</option>
            <option value="3">Wednesday</option>
            <option value="4">Thursday</option>
            <option value="5">Friday</option>
            <option value="6">Saturday</option>
            <option value="7">Sunday</option>
          </select>
        </div>
        <div class="form-group">
          <label>Time</label>
          <input type="text" class="form-control" id="time" name="time" />
        </div>
        <div class="form-group">
          <label>Timezone</label>
          <select name="timezone" id="timezone" class="form-control">
            <option value="-12:00">(GMT -12:00) Eniwetok, Kwajalein</option>
            <option value="-11:00">(GMT -11:00) Midway Island, Samoa</option>
            <option value="-10:00">(GMT -10:00) Hawaii</option>
            <option value="-09:50">(GMT -9:30) Taiohae</option>
            <option value="-09:00">(GMT -9:00) Alaska</option>
            <option value="-08:00">(GMT -8:00) Pacific Time (US &amp; Canada)</option>
            <option value="-07:00">(GMT -7:00) Mountain Time (US &amp; Canada)</option>
            <option value="-06:00">(GMT -6:00) Central Time (US &amp; Canada), Mexico City</option>
            <option value="-05:00">(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
            <option value="-04:50">(GMT -4:30) Caracas</option>
            <option value="-04:00">(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
            <option value="-03:50">(GMT -3:30) Newfoundland</option>
            <option value="-03:00">(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
            <option value="-02:00">(GMT -2:00) Mid-Atlantic</option>
            <option value="-01:00">(GMT -1:00) Azores, Cape Verde Islands</option>
            <option value="+00:00" selected="selected">(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
            <option value="+01:00">(GMT +1:00) Brussels, Copenhagen, Madrid, Paris</option>
            <option value="+02:00">(GMT +2:00) Kaliningrad, South Africa</option>
            <option value="+03:00">(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
            <option value="+03:50">(GMT +3:30) Tehran</option>
            <option value="+04:00">(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
            <option value="+04:50">(GMT +4:30) Kabul</option>
            <option value="+05:00">(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
            <option value="+05:50">(GMT +5:30) Bombay, Calcutta, Madras, New Delhi</option>
            <option value="+05:75">(GMT +5:45) Kathmandu, Pokhara</option>
            <option value="+06:00">(GMT +6:00) Almaty, Dhaka, Colombo</option>
            <option value="+06:50">(GMT +6:30) Yangon, Mandalay</option>
            <option value="+07:00">(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
            <option value="+08:00">(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
            <option value="+08:75">(GMT +8:45) Eucla</option>
            <option value="+09:00">(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
            <option value="+09:50">(GMT +9:30) Adelaide, Darwin</option>
            <option value="+10:00">(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
            <option value="+10:50">(GMT +10:30) Lord Howe Island</option>
            <option value="+11:00">(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
            <option value="+11:50">(GMT +11:30) Norfolk Island</option>
            <option value="+12:00">(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
            <option value="+12:75">(GMT +12:45) Chatham Islands</option>
            <option value="+13:00">(GMT +13:00) Apia, Nukualofa</option>
            <option value="+14:00">(GMT +14:00) Line Islands, Tokelau</option>
          </select>
        </div>
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
      timeFormat: 'h:mm p',
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
    $.ajax({
      type : "POST",
      url  : "<?=base_url()?>instructor/create_schedule",
      dataType : "JSON",
      data : {day:day, time:time, timezone:timezone},
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