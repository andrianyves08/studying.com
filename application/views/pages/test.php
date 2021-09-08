<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">
  <section class="card wow fadeIn" style="background-image: url(<?php echo base_url();?>assets/img/<?php echo $settings['background_image'];?>);background-attachment: fixed; background-position: center; background-repeat: no-repeat; background-size: cover; height: 300px;">
    <div class="card-body text-white text-center py-5 px-5 my-5">
      <h1 class="mb-4">
        <strong>test</strong>
      </h1>
    </div>
  </section>
  <hr class="my-5">
  <section class="wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="news-data">
        <?php
          //$response = $ac->api("automation/contact/list?automation=3&offset=0&limit=50");

          foreach ($users as $row) {
            $contact = array(
              "email"              => $row['email'],
              "first_name"         => $row['first_name'],
              "last_name"          => $row['last_name'],
              "tags"              => 'Studying.com User',
              "p[3]"      => '3',
            );

            $response = $ac->api("contact/sync", $contact);
            echo "<pre>";
            print_r($contact);
            echo "</pre>";
          }
         
        ?>
      
        </div><!--/Small news-->You are receiving these emails because you are subscribed to our updates.
      </div><!--Column-->
    </div><!--Row-->
  </section>
</div><!--Container-->
</main><!--Main layout-->
<!-- <script type="text/javascript">
$(document).ready(function(){

// 5a3e43825f1fa3b08ff813b32bd3951ab84bea23f3ea95c02abec05319a10b6beebd8aa4
var id = '1'
  $.ajax({
      url: "https://andyqmai.api-us1.com/api/3/contacts/"+id,
      type: 'post',
      dataType : "JSON",
      success: function(data){
        console.log(data);
            alert(data);
      }
    });
});
</script> -->