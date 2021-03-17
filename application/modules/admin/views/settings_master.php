<style type="text/css">
  .container{
  display: block;
  position: relative;
  /*margin: 40px auto;*/
  height: auto;
  width: 500px;
  /*padding: 20px;*/
}

h2 {
  color: #320dff;
}

.container ul{
  list-style: none;
  margin: 0;
  padding: 0;
  overflow: auto;
}

.container ul li{
  color: #AAAAAA;
  display: block;
  position: relative;
  float: left;
  width: 100%;
  /*height: 100px;*/
  border-bottom: 1px solid #333;
}

.container ul li input[type=checkbox]{
  position: absolute;
  visibility: hidden;
}

.container ul li label{
  display: block;
  position: relative;
  font-weight: 300;
  font-size: 1.35em;
  padding: 25px 25px 25px 80px;
  margin: 10px auto;
  height: 30px;
  z-index: 9;
  cursor: pointer;
  -webkit-transition: all 0.25s linear;
}

.container ul li:hover label{
  color: #320dff;
}

.container ul li .check{
  display: block;
  position: absolute;
  border: 5px solid #AAAAAA;
  border-radius: 100%;
  height: 25px;
  width: 25px;
  top: 30px;
  left: 20px;
  z-index: 5;
  transition: border .25s linear;
  -webkit-transition: border .25s linear;
}

.container ul li:hover .check {
  border: 5px solid #320dff;
}

.container ul li .check::before {
  display: block;
  position: absolute;
  content: '';
  border-radius: 100%;
  height: 15px;
  width: 15px;
  top: 5px;
  left: 5px;
  margin: auto;
  transition: background 0.25s linear;
  -webkit-transition: background 0.25s linear;
}

input[type=checkbox]:checked ~ .check {
  border: 5px solid #320dff;
}

input[type=checkbox]:checked ~ .check::before{
  background: #320dff;
}

input[type=checkbox]:checked ~ label{
  color: #320dff;
}


/* The container */
.container-checkbox {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 22px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser's default checkbox */
.container-checkbox input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

/* Create a custom checkbox */
.container-checkbox .checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container-checkbox:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container-checkbox input:checked ~ .checkmark {
    background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.container-checkbox .checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the checkmark when checked */
.container-checkbox input:checked ~ .checkmark:after {
    display: block;
}

/* Style the checkmark/indicator */
.container-checkbox .checkmark:after {
    left: 9px;
    top: 5px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}


/* The container */
.container-radio {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 22px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser's default radio button */
.container-radio input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

/* Create a custom radio button */
.container-radio .checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #eee;
    border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.container-radio:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container-radio input:checked ~ .checkmark {
    background-color: #2196F3;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.container-radio .checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the indicator (dot/circle) when checked */
.container-radio input:checked ~ .checkmark:after {
    display: block;
}

/* Style the indicator (dot/circle) */
.container-radio .checkmark:after {
  top: 9px;
  left: 9px;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: white;
}
</style>
<div class="content-wrapper">
  <section class="content-header">
      <h1>
         Settings
      </h1>
    </section>

<section class="content"> 
    <div class="row">
        <div class="col-lg-12">
            <?php if ($info_message = $this->session->flashdata('info_message')): ?>
            <div id="form-messages" class="alert alert-success" role="alert">
                <?php echo $info_message; ?>
            </div>
            <?php endif ?>
            <div class="panel panel-default">
              
                <div class="panel panel-default">
                   
                    <div class="panel-body" style="align-content: center;">

                        <form class="form-group" method="post" action="<?php echo site_url('admin/settings_masters'); ?>" enctype="multipart/form-data">
                          <div class="">
                          <?php 
                            $cash_on_delivery       = '';
                            $self_pickup            = '';
                            $home_delivery          = '';
                            $cash_on_delivery_name  = '';
                            $self_pickup_name       = '';
                            $home_delivery_name     = '';
                            $product_view           = '';
                            $wallet_with_discount   = '';
                            if(!empty($settings_masters)){
                              foreach ($settings_masters as $key => $value) {
                                if($value->name=='cash_on_delivery'){
                                  $cash_on_delivery      = $value->value;
                                  $cash_on_delivery_name = $value->user_defined_name;
                                }elseif ($value->name=='self_pickup') {
                                  $self_pickup      = $value->value;
                                  $self_pickup_name = $value->user_defined_name;
                                }elseif ($value->name=='home_delivery') {
                                  $home_delivery    = $value->value;
                                  $home_delivery_name = $value->user_defined_name;
                                }elseif ($value->name=='product_view') {
                                  $product_view      = $value->value;
                                }elseif ($value->name=='wallet_with_discount') {
                                  $wallet_with_discount  = $value->value;
                                }
                              }
                            }
                          ?>
                            <h2>Enable/Disable Settings</h2>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="col-md-6">
                                  <label class="container-checkbox">Cash On Delivery
                                   <input type="hidden" name="default_Value" value="1">
                                    <input type="checkbox" id="1-option" name="cash_on_delivery" value="1" <?php if(!empty($cash_on_delivery) &&  $cash_on_delivery==1){ echo 'checked';} ?>>  <span class="checkmark"></span>
                                  </label>
                                  <input type="text" name="cash_on_delivery_name" class="form-control" value="<?php if(!empty($cash_on_delivery_name) ){ echo $cash_on_delivery_name;} ?>" placeholder="Name to display in App">
                                  <br/>

                                  <label class="container-checkbox">Home Delivery
                                    <input type="checkbox" id="3-option" name="home_delivery" value="1" <?php if(!empty($home_delivery) &&  $home_delivery==1){ echo 'checked';}  ?>>
                                    <span class="checkmark"></span>
                                  </label>
                                  <input type="text" name="home_delivery_name" class="form-control" value="<?php if(!empty($home_delivery_name) ){ echo $home_delivery_name;} ?>" placeholder="Name to display in App">
                                  <br/>

                                   <label class="container-checkbox">Wallet With Discount
                                    <input type="checkbox" id="3-option" name="wallet_with_discount" value="1" <?php if(!empty($wallet_with_discount) &&  $wallet_with_discount==1){ echo 'checked';}  ?>>
                                    <span class="checkmark"></span>
                                  </label>
                                </div>

                                <div class="col-md-6">
                                    <label class="container-checkbox">Self Pickup
                                    <input type="checkbox" id="2-option" name="self_pickup" value="1" <?php if(!empty($self_pickup) &&  $self_pickup==1){ echo 'checked';}  ?>>
                                    <span class="checkmark"></span>
                                  </label>
                                  <input type="text" name="self_pickup_name" class="form-control" value="<?php if(!empty($self_pickup_name) ){ echo $self_pickup_name;} ?>" placeholder="Name to display in App"><br/>

                                  <label class="container-checkbox">Product View</label>
                                  <div class="col-md-2">
                                    <label class="container-checkbox">List
                                      <input type="radio" id="3-option" name="product_view" value="list" <?php if(!empty($product_view) &&  $product_view=='list'){ echo 'checked';}  ?>>
                                      <span class="checkmark"></span>
                                    </label>
                                  </div>
                                  <div class="col-md-2">
                                    <label class="container-checkbox">Grid
                                      <input type="radio" id="3-option" name="product_view" value="grid" <?php if(!empty($product_view) &&  $product_view=='grid'){ echo 'checked';}  ?>>
                                      <span class="checkmark"></span>
                                    </label>
                                  </div>

                                </div>
                              </div>
                            </div>
                            
                           

                           
                          </div>
                          <div class="row">
                            <div class="col-lg-12 col-lg-offset-3">
                              
                            </div>
                          </div>

                          <span class="red"><?php echo form_error('login_type'); ?></span>
                          <div class="clearfix"></div>
                          <br/><br/>
                          <div class="form-group col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary mb-2" name="save" value="UPLOAD">Save</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.panel -->
        </div>
     </div>
    <!-- /.row -->
</section>
</div>
