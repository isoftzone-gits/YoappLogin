<style>
      /* Set the size of the div element that contains the map */
      #map {
        height: 400px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
       }

       ol.progtrckr {
    margin: 0;
    padding: 0;
    list-style-type none;
}

ol.progtrckr li {
    display: inline-block;
    text-align: center;
    line-height: 3.5em;
}

ol.progtrckr[data-progtrckr-steps="2"] li { width: 49%; }
ol.progtrckr[data-progtrckr-steps="3"] li { width: 33%; }
ol.progtrckr[data-progtrckr-steps="4"] li { width: 24%; }
ol.progtrckr[data-progtrckr-steps="5"] li { width: 19%; }
ol.progtrckr[data-progtrckr-steps="6"] li { width: 16%; }
ol.progtrckr[data-progtrckr-steps="7"] li { width: 14%; }
ol.progtrckr[data-progtrckr-steps="8"] li { width: 12%; }
ol.progtrckr[data-progtrckr-steps="9"] li { width: 11%; }

ol.progtrckr li.progtrckr-done {
    color: black;
    border-bottom: 4px solid yellowgreen;
}
ol.progtrckr li.progtrckr-todo {
    color: silver; 
    border-bottom: 4px solid silver;
}

ol.progtrckr li:after {
    content: "\00a0\00a0";
}
ol.progtrckr li:before {
    position: relative;
    bottom: -2.5em;
    float: left;
    left: 50%;
    line-height: 1em;
}
ol.progtrckr li.progtrckr-done:before {
    content: "\2713";
    color: white;
    background-color: yellowgreen;
    height: 2.2em;
    width: 2.2em;
    line-height: 2.2em;
    border: none;
    border-radius: 2.2em;
}
ol.progtrckr li.progtrckr-todo:before {
    content: "\039F";
    color: silver;
    background-color: white;
    font-size: 2.2em;
    bottom: -1.2em;
}

.hsn {
    display: none !important;
}

.dropdown-select {
    background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0.25) 0%, rgba(255, 255, 255, 0) 100%);
    background-repeat: repeat-x;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#40FFFFFF', endColorstr='#00FFFFFF', GradientType=0);
    background-color: #fff;
    border-radius: 6px;
    border: solid 1px #eee;
    box-shadow: 0px 2px 5px 0px rgba(155, 155, 155, 0.5);
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    float: left;
    font-size: 14px;
    font-weight: normal;
    height: 42px;
    line-height: 40px;
    outline: none;
    padding-left: 18px;
    padding-right: 30px;
    position: relative;
    text-align: left !important;
    transition: all 0.2s ease-in-out;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    white-space: nowrap;
    width: auto;

}

.dropdown-select:focus {
    background-color: #fff;
}

.dropdown-select:hover {
    background-color: #fff;
}

.dropdown-select:active,
.dropdown-select.open {
    background-color: #fff !important;
    border-color: #bbb;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05) inset;
}

.dropdown-select:after {
    height: 0;
    width: 0;
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    border-top: 4px solid #777;
    -webkit-transform: origin(50% 20%);
    transform: origin(50% 20%);
    transition: all 0.125s ease-in-out;
    content: '';
    display: block;
    margin-top: -2px;
    pointer-events: none;
    position: absolute;
    right: 10px;
    top: 50%;
}

.dropdown-select.open:after {
    -webkit-transform: rotate(-180deg);
    transform: rotate(-180deg);
}

.dropdown-select.open .list {
    -webkit-transform: scale(1);
    transform: scale(1);
    opacity: 1;
    pointer-events: auto;
}

.dropdown-select.open .option {
    cursor: pointer;
}

.dropdown-select.wide {
    width: 100%;
}

.dropdown-select.wide .list {
    left: 0 !important;
    right: 0 !important;
}

.dropdown-select .list {
    box-sizing: border-box;
    transition: all 0.15s cubic-bezier(0.25, 0, 0.25, 1.75), opacity 0.1s linear;
    -webkit-transform: scale(0.75);
    transform: scale(0.75);
    -webkit-transform-origin: 50% 0;
    transform-origin: 50% 0;
    box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.09);
    background-color: #fff;
    border-radius: 6px;
    margin-top: 4px;
    padding: 3px 0;
    opacity: 0;
    overflow: hidden;
    pointer-events: none;
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 999;
    max-height: 250px;
    overflow: auto;
    border: 1px solid #ddd;
}

.dropdown-select .list:hover .option:not(:hover) {
    background-color: transparent !important;
}
.dropdown-select .dd-search{
  overflow:hidden;
  display:flex;
  align-items:center;
  justify-content:center;
  margin:0.5rem;
}

.dropdown-select .dd-searchbox{
  width:90%;
  padding:0.5rem;
  border:1px solid #999;
  border-color:#999;
  border-radius:4px;
  outline:none;
}
.dropdown-select .dd-searchbox:focus{
  border-color:#12CBC4;
}

.dropdown-select .list ul {
    padding: 0;
}

.dropdown-select .option {
    cursor: default;
    font-weight: 400;
    line-height: 40px;
    outline: none;
    padding-left: 18px;
    padding-right: 29px;
    text-align: left;
    transition: all 0.2s;
    list-style: none;
}

.dropdown-select .option:hover,
.dropdown-select .option:focus {
    background-color: #f6f6f6 !important;
}

.dropdown-select .option.selected {
    font-weight: 600;
    color: #12cbc4;
}

.dropdown-select .option.selected:focus {
    background: #f6f6f6;
}

.dropdown-select a {
    color: #aaa;
    text-decoration: none;
    transition: all 0.2s ease-in-out;
}

.dropdown-select a:hover {
    color: #666;
}

    </style>


<!-- <div id="page-wrapper"> -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Order Details
        </h1>
    </section>

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
                <div class="panel-heading"> <a class="btn btn-primary" href="<?php echo site_url('admin/orders')?>"><i class="fa fa-th-list"><span class="text-align">Orders List</span></i></a> </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <ol class="progtrckr" data-progtrckr-steps="5">
                                <li class="progtrckr-done">placed</li><!--
                             --><li class="<?php if($orders[0]->status=='progress'  || $orders[0]->status=='dispatched' ||$orders[0]->status=='delivered'){ ?>progtrckr-done<?php }else{  ?>progtrckr-todo <?php } ?>">progress</li><!--
                             --><li class="<?php if($orders[0]->status=='dispatched' ||$orders[0]->status=='delivered'){ ?>progtrckr-done<?php }else{  ?>progtrckr-todo <?php } ?>">Dispatched</li><!--
                             --><li class="<?php if($orders[0]->status=='delivered'){ ?>progtrckr-done<?php }else{  ?>progtrckr-todo <?php } ?>">Delivered</li>
                            </ol>
                        </div>
                        
                        <div class="clearfix"></div>
                        <div class="col-lg-12 col-md-12" style="margin-top: 20px;">
                                
                                <div class="form-group">
                                    <label class="col-md-3  ">Order Date </label>
                                    <div class="col-lg-6">
                                        <span><?php echo $orders[0]->created_at; ?></span>
                                    </div>
                                </div>
                                <div class="clearfix"></div>

                                <div class="form-group">
                                    <label class="col-md-3  ">Customer Name </label>
                                    <div class="col-lg-6">
                                        <span><?php echo $orders[0]->username; ?></span>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label class="col-md-3">Customer Address</label>
                                    <div class="col-lg-6">
                                        <?php if($orders[0]->delivery_type=='Self Pickup'){ 
                                            echo 'Self Pickup';
                                        }else{
                                            ?>
                                         <span><b>Area - </b> <?php echo $orders[0]->place_name."<br/>"; ?> </span>
                                         <span><?php echo $orders[0]->address ?></span>
                                        
                                        <br/>
                                        <span><b>CITY -</b></span>
                                        
                                        <span><?php echo $user_address[0]->city; ?></span>
                                        <br/>
                                        <span><b>STATE -</b></span>
                                        
                                        <span><?php echo $user_address[0]->state; ?></span>
                                        <br/>
                                        <span><b>COUNTRY -</b></span>
                                        
                                        <span><?php echo $user_address[0]->country; ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group table-responsive">
                                <table class="table table-bordered display nowrap" cellspacing="0" width="100%" id="appointment">
                                <thead>
                                    <tr class="bg-primary">
                                        <td>Product Name</td>
                                        <td>Product Attribute</td>
                                        <td>Product Price</td>
                                        <td>Quantity</td>
                                        <td>Naration</td>
                                        <td>Extra</td>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $total = 0; ?>
                                <?php foreach ($order_items as $key => $value) { ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $value->product_name; ?></td>
                                        <td><?php echo $value->product_attribute; ?></td>
                                        <td><?php echo $value->product_price; ?></td>
                                        <td><?php echo $value->qtyTotal;
                                        $total  +=  $value->totalAmt;
                                         ?></td>
                                        <td><?php echo $value->naration; ?></td>
                                        <td><?php if(!empty($value->extra_img)){ ?>
                                            <a href="<?php echo  base_url('asset/uploads/').$value->extra_img; ?>" download="download"><i class="fa fa-download"></i></a>

                                            <?php } ?></td>
                                    </tr>
                                    
                                <?php } ?>
                                     <tr class="odd gradeX">
                                        <td colspan="2"><span style="align-items: center;"><b>Total Amount</b></span></td>
                                        <td colspan="4"><span style="align-items: center;"><b><?php echo $total; ?></b></span></td>
                                    </tr>
                                    <tr class="odd gradeX">
                                        <td colspan="2"><span style="align-items: center;"><b>Shipping Amount</b></span></td>
                                        <td colspan="4"><span style="align-items: center;"><b><?php echo $orders[0]->shipping_rate?$orders[0]->shipping_rate :0; ?></b></span></td>
                                    </tr>
                                    <tr class="odd gradeX">
                                        <td colspan="2"><span style="align-items: center;"><b>Discount Amount</b></span></td>
                                        <td colspan="4"><span style="align-items: center;"><b><?php echo $orders[0]->discount_amount ?$orders[0]->discount_amount :0; ?></b></span></td>
                                    </tr>
                              </tbody>
                                </table>

                        </div>
                        <?php if($orders[0]->status !='dispatched' && $orders[0]->status!='delivered' ){ ?>
                        <div id="addMoreProduct">
                        	<button class="btn btn-primary" id="addProduct">AddMoreProduct</button>
                            <form method="post" action="<?php echo site_url('admin/addMoreProduct'); ?>">
                        	<table class="table table-bordered display nowrap" cellspacing="0" width="100%" id="appointment">
                                <thead>
                                    <tr class="bg-primary">
                                        <td>Product Name</td>
                                        <td>Product Attribute</td>
                                        <td>Product Price</td>
                                        <td>Sell Price</td>
                                        <td>Quantity</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody class="addMoreProduct">
                                </tbody>
                            </table>
                            <input type="hidden" name="order_id" value="<?php echo $orders[0]->id; ?>">
                            <input type="submit" name="submit" value="submit">
                            </form>
                            <br/><br/>
                        </div>
                    <?php } ?>

                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label class="col-md-3">Change Status</label>
                                    <div class="col-md-6">
                                        <input type="hidden" id="order_id" value="<?php echo $orders[0]->id; ?>">

                                        <input type="hidden" id="user_id" value="<?php echo $orders[0]->user_id; ?>">
                                        <select class="form-group wide" onchange="change_status()" id="order_status">
                                            <option value="placed" <?php if($orders[0]->status=='placed'){ echo 'selected';} ?>>placed</option>
                                            <option value="progress" <?php if($orders[0]->status=='progress'){ echo 'selected';} ?>>Progress</option>
                                            <option value="dispatched" <?php if($orders[0]->status=='dispatched'){ echo 'selected';} ?>>Dispatched</option>
                                            <option value="delivered" <?php if($orders[0]->status=='delivered'){ echo 'selected';} ?>>delivered</option>
                                            <option value="cancel" <?php if($orders[0]->status=='cancel'){ echo 'selected';} ?>>Cancel</option>
                                        </select>
                                    </div>
                                </div>
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

  var lat  = '<?php echo $orders[0]->lat; ?>';
  var long  = '<?php echo $orders[0]->lng; ?>';

  var uluru = {lat: parseFloat(lat), lng: parseFloat(long)};
  console.log(uluru);
  // The map, centered at Uluru
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 13, center: uluru});
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({position: uluru, map: map});
}

	var option = '';
    $(document).ready(function() {
        $('select').niceSelect();
    	getAllProduct();
    	
    });
    
    function getAllProduct(){
    	$.ajax({
            url: "<?php echo site_url('admin/getAllProduct') ?>",
            type: 'get',
            success: function(result) {
            	data = JSON.parse(result);

                option = '<option value="">--Select Product--</option>';
                if(data != null){
                    for (var i = 0; i < data.length; i++) {
                       option += '<option value="' + data[i].id + '">' + data[i].product_name + '</option>';
                   }
               }
            }
        });
    }
    function change_status(){
        var order_id  = $('#order_id').val();
        var status  = $('#order_status').val();
        var user_id  = $('#user_id').val();
        $.ajax({
            url: "<?php echo site_url('admin/change_order_status') ?>",
            type: 'POST',
            data: {
                order_id: order_id,
                status:status,
                user_id :user_id
            },
            success: function(data) {
                window.location.href='<?php echo site_url('admin/orders') ?>';
            }
        });
    }

 	var counter  = 0;
    $("#addProduct").click(function() {
        $(".addMoreProduct").append('<tr><td><select name="product['+counter+'][product_id]" onchange="getProductAttribute(this,'+counter+')" style="display:none" id="custom_drop_'+counter+'">'+option+'</select></td><td><select name="product['+counter+'][attribute_id]" class="form-group" onchange="getPrice(this,'+counter+')" id="product_attribute_'+counter+'"></select></td><td><input type="text" name="product['+counter+'][product_price]" id="productPrice_'+counter+'"></td><td><input type="text" name="product['+counter+'][sell_price]" id="sellPrice_'+counter+'"></td><td><input name="product['+counter+'][Quantity] type="text" value="1"></td><td><i class="fa fa-minus-circle remove" aria-hidden="true" id="removeButton" style="font-size:25px;margin-left: 15px;"></i></td></tr>');
        create_custom_dropdowns(counter);
       
        counter++;

        

    });

    function getPrice(el,id){
        var sellprice  = $(el).find(':selected').data("sell_price");
        var productprice  = $(el).find(':selected').data("product_price");
        $('#sellPrice_'+id+'').val(sellprice);
        $('#productPrice_'+id+'').val(productprice);
       // alert(price);
    }
    var Attribute  = '';
    function getProductAttribute(el,id){
        var product_id  = $(el).val();
        $.ajax({
            url: "<?php echo site_url('admin/getProductAttribute') ?>",
            type: 'POST',
            data :{product_id:product_id},
            success: function(result) {
                data = JSON.parse(result);

                
                if(data != null){
                    for (var i = 0; i < data.length; i++) {
                       Attribute += '<option data-product_price="'+data[i].product_price+'" data-sell_price="'+data[i].sell_price+'" value="' + data[i].id + '">' + data[i].product_attributes + '</option>';
                       if(i==0){
                        $('#sellPrice_'+id+'').val(data[i].sell_price)
                        $('#productPrice_'+id+'').val(data[i].product_price)
                       }
                   }
                   $('#product_attribute_'+id+'').html(Attribute);
                    Attribute   = '';                   
                   //$('.select').niceSelect();
               }
            }
        });

    }
    $("body").on("click", ".remove", function() {
        $(this).closest("tr").remove();
    });


     function create_custom_dropdowns(id) {
    $('#custom_drop_'+id+'').each(function (i, select) {
        if (!$(this).next().hasClass('dropdown-select')) {
            $(this).after('<div class="dropdown-select wide ' + ($(this).attr('class') || '') + '" tabindex="0"><span class="current"></span><div class="list"><ul></ul></div></div>');
            var dropdown = $(this).next();
            var options = $(select).find('option');
            var selected = $(this).find('option:selected');
            dropdown.find('.current').html(selected.data('display-text') || selected.text());
            options.each(function (j, o) {
                var display = $(o).data('display-text') || '';
                dropdown.find('ul').append('<li class="option ' + ($(o).is(':selected') ? 'selected' : '') + '" data-value="' + $(o).val() + '" data-display-text="' + display + '">' + $(o).text() + '</li>');
            });
        }
    });

    $('.dropdown-select ul').before('<div class="dd-search"><input id="txtSearchValue" autocomplete="off" onkeyup="filter()" class="dd-searchbox" type="text"></div>');
}

// Event listeners

// Open/close
$(document).on('click', '.dropdown-select', function (event) {
    if($(event.target).hasClass('dd-searchbox')){
        return;
    }
    $('.dropdown-select').not($(this)).removeClass('open');
    $(this).toggleClass('open');
    if ($(this).hasClass('open')) {
        $(this).find('.option').attr('tabindex', 0);
        $(this).find('.selected').focus();
    } else {
        $(this).find('.option').removeAttr('tabindex');
        $(this).focus();
    }
});

// Close when clicking outside
$(document).on('click', function (event) {
    if ($(event.target).closest('.dropdown-select').length === 0) {
        $('.dropdown-select').removeClass('open');
        $('.dropdown-select .option').removeAttr('tabindex');
    }
    event.stopPropagation();
});

function filter(){
    var valThis = $('#txtSearchValue').val();
    $('.dropdown-select ul > li').each(function(){
     var text = $(this).text();
        (text.toLowerCase().indexOf(valThis.toLowerCase()) > -1) ? $(this).show() : $(this).hide();         
   });
};
// Search

// Option click
$(document).on('click', '.dropdown-select .option', function (event) {
    $(this).closest('.list').find('.selected').removeClass('selected');
    $(this).addClass('selected');
    var text = $(this).data('display-text') || $(this).text();
    $(this).closest('.dropdown-select').find('.current').text(text);
    $(this).closest('.dropdown-select').prev('select').val($(this).data('value')).trigger('change');
    // var hsn_per  =   $(this).closest('.dropdown-select').prev('select').data("hsn_per");
    // console.log(hsn_per);
});

// Keyboard events
$(document).on('keydown', '.dropdown-select', function (event) {
    var focused_option = $($(this).find('.list .option:focus')[0] || $(this).find('.list .option.selected')[0]);
    // Space or Enter
    //if (event.keyCode == 32 || event.keyCode == 13) {
    if (event.keyCode == 13) {
        if ($(this).hasClass('open')) {
            focused_option.trigger('click');
        } else {
            $(this).trigger('click');
        }
        return false;
        // Down
    } else if (event.keyCode == 40) {
        if (!$(this).hasClass('open')) {
            $(this).trigger('click');
        } else {
            focused_option.next().focus();
        }
        return false;
        // Up
    } else if (event.keyCode == 38) {
        if (!$(this).hasClass('open')) {
            $(this).trigger('click');
        } else {
            var focused_option = $($(this).find('.list .option:focus')[0] || $(this).find('.list .option.selected')[0]);
            focused_option.prev().focus();
        }
        return false;
        // Esc
    } else if (event.keyCode == 27) {
        if ($(this).hasClass('open')) {
            $(this).trigger('click');
        }
        return false;
    }
});

</script>