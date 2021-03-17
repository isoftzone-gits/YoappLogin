<style type="text/css">
label.cabinet{
    display: block;
    cursor: pointer;
}

label.cabinet input.file{
    position: relative;
    height: 100%;
    width: auto;
    opacity: 0;
    -moz-opacity: 0;
  filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
  margin-top:-30px;
}

#upload-demo{
    width: 250px;
    height: 250px;
  padding-bottom:25px;
}
figure figcaption {
    position: absolute;
    bottom: 0;
    color: #fff;
    width: 100%;
    padding-left: 9px;
    padding-bottom: 5px;
    text-shadow: 0 0 10px #000;
}
.croppie-container .cr-boundary{
    border: 1px solid !important;
}
.checkbox{
    width: 30px;
    height: 30px;
}
</style>
<!-- <div id="page-wrapper"> -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Product
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
                <div class="panel-heading"> <a class="btn btn-primary" href="<?php echo site_url('vendor/product_list')?>"><i class="fa fa-th-list"><span class="text-align">Product List</span></i></a> </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <form role="form" method="post" action="<?php if(!empty($product[0])){ echo site_url('vendor/product/'.$product[0]->id);}else{echo site_url('vendor/product');} ?>" class="registration_form1" enctype="multipart/form-data" onSubmit="return validate();">

                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">Category * </label>
                                    <div class="col-md-6">
                                        <select class="niceSelect wide" id="category_id" name="category_id" onchange="get_sub_menu(this.value)">
                                            <option value="">Select Category</option>
                                            <?php foreach ($category_list as $key => $value) { ?>
                                                <option value="<?php echo $value->id; ?>" 
                                                    <?php if(!empty($product) && $value->id==$product[0]->category_id){ echo 'selected';} ?>><?php echo $value->category_name; ?></option>    
                                            <?php } ?>
                                        </select>
                                        <span class="red" id="category_id_error"><?php echo form_error('category_id'); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">Sub Category * </label>
                                    <div class="col-md-6">
                                        <select class="niceSelect wide" id="sub_cat_id" name="sub_cat_id">
                                            <option value="">Select Sub Category</option>
                                            <?php if(!empty($sub_category)){ 
                                                foreach ($sub_category as $key => $value) {
                                            ?>

                                            <option value="<?php echo $value->id; ?>" 
                                                <?php if(!empty($product) && $product[0]->sub_cat_id == $value->id){ echo 'selected';} ?>><?php echo $value->sub_cat_name; ?></option>

                                           <?php } } ?>
                                        </select>
                                        <span class="red" id="sub_cat_id_error"><?php echo form_error('sub_cat_id'); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">Product Name * </label>
                                    <div class="col-md-6">
                                        <input type="text" name="product_name" id="product_name" class="form-control" value="<?php if(!empty($product[0]->product_name)){echo $product[0]->product_name;}else{ echo set_value('product_name');}?>" maxlength="30">
                                        <span class="red" id="product_name_error"><?php echo form_error('product_name'); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">Product Description *</label>
                                    <div class="col-md-6">
                                        <textarea name="product_description" id="product_description" class="form-control"><?php if(!empty($product[0]->product_description)){echo $product[0]->product_description;}else{ echo set_value('product_description');}?></textarea>
                                        
                                        <span class="red" id="product_description_error"><?php echo form_error('product_description'); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">Sequence </label>
                                    <div class="col-md-6">
                                        <input type="text" name="sequence" id="sequence" class="form-control" value="<?php if(!empty($product[0]->sequence)){echo $product[0]->sequence;}else{ echo  !empty($sequence)?$sequence[0]->sequence+1:1; }?>">
                                        <span class="red" id="sequence_error"><?php echo form_error('sequence'); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">Stock </label>
                                    <div class="col-md-6">
                                        
                                        <input type="checkbox" class="checkbox"  name="stock" id="stock"  value="1"
                                        <?php if(!empty($product[0])){ 
                                           if($product[0]->stock==1){?> 
                                                checked="checked" 
                                        <?php } } else{ ?> checked="checked" <?php } ?>>
                                        <span class="red" id="stock_error"><?php echo form_error('stock'); ?></span>
                                    </div>
                                </div>
                            </div>


                                <?php if(isset($p_attr)){ 
                                    $i=1; ?>
                                    <div class="box-body">
                                    <?php 
                                    foreach ($p_attr as $key => $value) {
                                    
                                    ?>

                                    <div <?php if($i==count($p_attr)){?> id="app"
                                    <?php }?>>
                                    <label class="col-md-2">
                                        <?php if($i==1){?>Attributes
                                        <?php }?>
                                    </label>
                                     <?php if($i>1){ ?>
                                        <div class="selected">
                                        <?php  } ?>
                                        <div class="col-lg-3" style="margin-bottom: 5px;">
                                              <input type="text" id="attribute" name="attribute[]" value="<?php echo $p_attr[$key]->product_attributes; ?>" class="form-control " autocomplete="off" placeholder="XL,XXL,KG,GRAM" >
                                        </div>
                                        <div class="col-lg-2" style="margin-bottom: 5px;">
                                            <input type="number" id="price" name="price[]" class="form-control" value="<?php echo $p_attr[$key]->product_price; ?>" autocomplete="off"  placeholder="PRICE" ></div>

                                        <div class="col-lg-2">
                                            <input type="number" id="sell_price" name="sell_price[]" class="form-control" value="<?php echo $p_attr[$key]->sell_price; ?>" autocomplete="off"  placeholder="PRICE" ></div>

                                        
                                        <?php if($i>1){?>
                                        <i class="fa fa-minus-circle remove" aria-hidden="true" id="removeButton" style="font-size:25px; padding-left: 15px;"></i>
                                        <?php }else{?>
                                        <div class="col-lg-2 mt-5"> <i class="fa fa-plus-circle" aria-hidden="true" id="add" style="font-size: 25px;"></i> </div>
                                        <?php }?>
                                        <?php if($i>1){?>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="clearfix"></div>
                                <?php   $i++; }?>
                                </div>

                                <?php }else{?>

                                    <div class="box-body">    
                                        <div id="app"> 
                                        <label class="col-md-2">Attributes * </label>
                                            <div class="col-lg-3" style="margin-bottom: 5px;">
                                                 <input type="text" id="attribute" name="attribute[]" class="form-control " autocomplete="off" placeholder="XL,XXL,KG,GRAM" required="required">
                                                <span class="red"><?php echo form_error('attribute[]'); ?></span>
                                            </div>

                                            <div class="col-lg-2" style="margin-bottom: 5px;">
                                                <input type="number" id="price" name="price[]" class="form-control" autocomplete="off"  placeholder="MRP" required="required">
                                            </div>

                                            <div class="col-lg-2">
                                                <input type="number" id="sell_price" name="sell_price[]" class="form-control" autocomplete="off"  placeholder="SELL PRICE" required="required">
                                            </div>
                                            
                                            <div class="col-lg-2"><i class="fa fa-plus-circle" aria-hidden="true" id="add" style="font-size: 25px;"></i>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            
                            <div class="box-body clearfix">   
                                <div id="product_append">

                                    <div class="form-group">
                                        <label class="col-md-2">Product Image *</label>
                                        <div class="col-md-6">
                                            <div id="images_array"></div>
                                            <input type="file" name="product_image[]" id="product_image" class="item-img file center-block">
                                            
                                            <span class="red" id="product_image_error"><?php echo form_error('product_image'); ?></span>
                                        </div>
                                    </div>
                                   <!--  <div class="col-lg-2"><i class="fa fa-plus-circle" aria-hidden="true" id="padd" style="font-size: 25px;"></i>
                                    </div> -->
                                </div> 
                            </div>
                                
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">Note: </label>
                                    <div class="col-md-6">
                                        <span class="text-success" style="font-weight: bold;">
                                            You can upload multiple images by selecting images one by one
                                        </span>
                                    </div>
                                </div>
                            </div>
                                
                                <div class="col-md-12" align="center">
                                    <button type="submit" value="Save" id="submit" class="btn btn-success">Save</button>
                                    <input type="reset" class="btn btn-default" value="Reset">
                                </div>
                                
                            </form>
                            <!-- <img src="" class="gambar img-responsive img-thumbnail" id="item-img-output" /> -->

                            <div id="image_preview"></div>                          
                            <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title" id="myModalLabel">
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div id="upload-demo" class="center-block"></div>
                                </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <?php if(!empty($product[0]->product_image)) {
                               // echo $product[0]->product_image;
                                $images  = @unserialize($product[0]->product_image); 
                                $images  = !empty($images)?$images:[];
                                $product_id = !empty($product[0]->id)?$product[0]->id :0;
                            ?>
                            <div class="box-body">
                                <div class="form-group">
                                    <?php foreach ($images as $key => $value) { ?>
                                    <div class="col-md-2" style="margin-top: 20px;">
                                        <div class="thumbnail">
                                            <img src="<?php echo base_url('asset/uploads/').$value; ?>" width="200" height="200">
                                                <div class="delete">
                                                    <button class="btn btn-danger delete-radius" onclick="delete_product_image('<?php echo $value;  ?>','<?php echo $product_id; ?>')"><i class="fa fa-times" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php  } ?>
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
<script type="text/javascript">
    $(document).ready(function() {
        $('select').niceSelect();
    });


    $('#category_id').on('change',function(){
        var id =$(this).val();
        $.ajax({
                url: "<?php echo site_url('vendor/get_sequence')?>",
                data: {
                    id: id,
                    column:'category_id',
                    table:'product'
                },
                type: "POST",
                success:function(result){
                    $('#sequence').val(result);
                }
        });
    });

    $('#sub_cat_id').on('change',function(){
        var id          = $(this).val();
        var category_id = $('#category_id').val();

        $.ajax({
                url: "<?php echo site_url('vendor/get_sequence_by_subCategory')?>",
                data: {
                    id: id,
                    category_id : category_id,
                },
                type: "POST",
                success:function(result){
                    $('#sequence').val(result);
                }
        });
    });

    $("#add").click(function() {
            var counter = 2;
            $("#app").append('<div class="clearfix"></div><div class="form-group" id="box' + counter + '"><label class="col-md-2"></label><div class="col-lg-3" style="margin-bottom: 5px;"><input type="text" id="attribute" name="attribute[]" class="form-control " autocomplete="off" placeholder="XL,XXL,KG,GRAM" required="required"></div><div class="col-lg-2" style="margin-bottom: 5px;"><input type="number" id="price" name="price[]" class="form-control" autocomplete="off"  placeholder="MRP" required="required"></div><div class="col-lg-2"><input type="number" id="sell_price" name="sell_price[]" class="form-control" autocomplete="off"  placeholder="SELL PRICE" required="required"></div><i class="fa fa-minus-circle remove" aria-hidden="true" id="removeButton" style="font-size:25px;margin-left: 15px;"></i></div>');

           
            counter++;
        });

     $("#padd").click(function() {
            var counter = 2;
            $("#product_append").append('<div class="clearfix"></div><div class="form-group" id="product' + counter + '"><label class="col-md-2"></label><div class="col-md-6"><input type="file" name="product_image[]" id="product_image" class="item-img file center-block"></div><i class="fa fa-minus-circle remove" aria-hidden="true" id="removeButton" style="font-size:25px;margin-left: 15px;"></i></div>');

           
            counter++;
        });

    $("body").on("click", ".remove", function() {
            $(this).closest("div").remove();
        });
    function get_sub_menu(str) {
        $.ajax({
            type: "GET",
            url: "<?php echo site_url('vendor/get_record')?>",
            data: {
                id: str,
                table: 'sub_category',
                field: 'category_id',
                select: 'id,sub_cat_name',
            },
            success: function(result) {
                data = JSON.parse(result);

                var option = '<option value="">--Select Sub Category--</option>';
                if(data != null){
                    for (var i = 0; i < data.length; i++) {
                       option += '<option value="' + data[i].id + '">' + data[i].sub_cat_name + '</option>';
                   }
               }

                $('#sub_cat_id').html(option);
                $('#sub_cat_id').niceSelect('update');
            }
        });
    }

    function delete_product_image(image_name,product_id){
         swal({
        title: "Are you sure?",
        text: "you want to delete?",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: false,
        confirmButtonText: "Yes, Delete it!",
        confirmButtonColor: "#ec6c62"
        }, function() {
            $.ajax({
                url: "<?php echo site_url('vendor/delete_product_image')?>",
                data: {
                    id: product_id,
                    image_name:image_name
                },
                type: "POST"
            }).done(function(data) {
                //swal("Deleted!", "Image was successfully deleted!", "success");
                window.location.reload();
            }).error(function(data) {
                swal("Oops", "We couldn't connect to the server!", "error");
            });
        });
    }


         function validate() {

            $('.red').text('');
               var category_id  = $('#category_id').val();
               if(category_id==''){
                 $('#category_id_error').text('Category Required');
                 return false;
               }

               // var sub_cat_id  = $('#sub_cat_id').val();
               // if(sub_cat_id==''){
               //   $('#sub_cat_id_error').text('Sub Category Required');
               //   return false;
               // }

               var product_name  = $('#product_name').val();
               if(product_name==''){
                 $('#product_name_error').text('Product Name Required');
                 return false;
               }

               // var product_description  = $. trim($('#product_description').val());
               // if(product_description==''){
               //   $('#product_description_error').text('Product Description Required');
               //   return false;
               // }

               

        //   $("#product_image_error").html("");

        //   console.log($('#product_image')[0].files.length);
        //  // $(".demoInputBox").css("border-color","#F0F0F0");
        //   for (var i = 0; i < $('#product_image')[0].files.length; i++) {
            
        //   var file_size = $('#product_image')[0].files[i].size;
         
        //   if(file_size>300000) {
        //     $("#product_image_error").html("File size is greater than 300kb");
        //   //  $(".demoInputBox").css("border-color","#FF0000");

        //     return false;
        //   } 
         
        // }
        //  return true;
        }
    

    var $uploadCrop,
    tempFilename,
    rawImg,
    imageId;

function readFile(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.upload-demo').addClass('ready');
            $('#cropImagePop').modal('show');
            rawImg = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        swal("Sorry - you're browser doesn't support the FileReader API");
    }
}

$uploadCrop = $('#upload-demo').croppie({
    viewport: {
        width: 200,
        height: 200,
    },
    
    enforceBoundary: false,
    enableExif: true,
   // enableZoom : true   
});
$('#cropImagePop').on('shown.bs.modal', function() {
    // alert('Shown pop');
    $uploadCrop.croppie('bind', {
        url: rawImg
    }).then(function() {
        console.log('jQuery bind complete');
    });
});

$('.item-img').on('change', function() {
    imageId = $(this).data('id');
    tempFilename = $(this).val();
    $('#cancelCropBtn').data('id', imageId);
    readFile(this);
});
$('#cropImageBtn').on('click', function(ev) {
    $uploadCrop.croppie('result', {
        type: 'base64',
        format: 'jpeg',
         backgroundColor:'white',
        size: {
            width: 512,
            height: 512
        }
    }).then(function(resp) {
        
       // var new_array  = [resp];
        $('#image_preview').append('<img src="'+resp+'" class="gambar img-responsive img-thumbnail" id="item-img-output" style="width:150px;height:150px;" />');
       // $('#item-img-output').attr('src', resp);
        $('#cropImagePop').modal('hide');
       //  var values = $("input[name='cropped_image[]']")
       //        .map(function(){return $(this).val();}).get();

       //  console.log('old_images',values);
       //  console.log('new_array',new_array);
       //  if(values!=''){``
       //      var final_array  = values.concat(new_array);
       //  }else{
       //      final_array     = new_array;
       //  }
       // console.log(final_array);
       // $("input:hidden[name='cropped_image[]']").val(final_array); 

        $('#images_array').append('<input type="hidden" name="cropped_image[]" value="'+resp+'">');

    });
});
</script>