<style>
      /* Set the size of the div element that contains the map */
      #map {
        height: 400px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
       }
</style>


<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Pickup Location
      </h1>
    </section>
    <!-- /.row -->

<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <?php if(!empty($msg)){?>
            <div class="alert alert-success">
                <?php echo $msg;?> </div>
            <?php }?>
            <?php if ($info_message = $this->session->flashdata('info_message')): ?>
            <div id="form-messages" class="alert alert-success" role="alert">
                <?php echo $info_message; ?> </div>
            <?php endif ?>
            <div class="panel panel-default">
                <div class="panel-heading"> <a class="btn btn-primary" href="#"><i class="fa fa-th-list"><span class="text-align">Pickup Location</span></i></a> </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <form role="form" method="post" action="<?php echo site_url('admin/pickup_location'); ?>" class="registration_form1" enctype="multipart/form-data">

                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-md-2">Latitude</label>
                                        <div class="col-md-6">
                                            <input type="text" name="lat" id="lat" class="form-control" value="<?php if(!empty($pickup_location[0]->lat)){echo $pickup_location[0]->lat;}else{ echo set_value('lat');}?>" maxlength="30" placeholder="Enter Latitude">
                                            <span class="red"><?php echo form_error('lat'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-md-2">Longitude</label>
                                        <div class="col-md-6">
                                            <input type="text" name="long" id="long" class="form-control" value="<?php if(!empty($pickup_location[0]->long)){echo $pickup_location[0]->long;}else{ echo set_value('long');}?>" maxlength="30" placeholder="Enter Longitude">
                                            <span class="red"><?php echo form_error('long'); ?></span></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12" align="center" style="margin-bottom: 20px;">
                                    <button type="submit" value="Save" id="submit" class="btn btn-success">Save</button>
                                    <input type="reset" class="btn btn-default" value="Reset"> 
                                </div>
                            </form>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-lg-12 col-md-12">
                            <div id="map"></div>
                        </div>

                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- row -->
</section>
</div>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyJKXE5ViV8h0J_-kvuYfbiJFCLEKd05w&callback=initMaps"></script>
<script type="text/javascript">
// Initialize and add the map
function initMaps() {
  // The location of Uluru

  var lat  = '<?php echo $pickup_location[0]->lat; ?>';
  var long  = '<?php echo $pickup_location[0]->long; ?>';
  var uluru = {lat: parseFloat(lat), lng: parseFloat(long)};
  console.log(uluru);
  // The map, centered at Uluru
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 13, center: uluru});
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({position: uluru, map: map});
}

</script>