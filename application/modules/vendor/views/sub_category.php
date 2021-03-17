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
</style>
<!-- <div id="page-wrapper"> -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Sub Category
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
                <div class="panel-heading"> <a class="btn btn-primary" href="<?php echo site_url('vendor/sub_cat_list')?>"><i class="fa fa-th-list"><span class="text-align">Sub Category List</span></i></a> </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <form role="form" method="post" action="<?php if(!empty($sub_category[0])){ echo site_url('vendor/sub_category/'.$sub_category[0]->id);}else{echo site_url('vendor/sub_category');} ?>" class="registration_form1" enctype="multipart/form-data" onSubmit="return validate();">

                            <div class="box-body">    
                                <div class="form-group">
                                    <label class="col-md-2">Category * </label>
                                    <div class="col-md-6">
                                        <select class="niceSelect wide" id="category_id" name="category_id">
                                            <option value="">Select Category</option>
                                            <?php foreach ($category_list as $key => $value) { ?>
                                                <option value="<?php echo $value->id; ?>" 
                                                    <?php if(!empty($sub_category[0]) &&  $value->id==$sub_category[0]->category_id){ echo 'selected';} ?>><?php echo $value->category_name; ?></option>    
                                            <?php } ?>
                                            
                                        </select>
                                        <span class="red" id="category_id_error"><?php echo form_error('category_id'); ?></span>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">Sub Category Name * </label>
                                    <div class="col-md-6">
                                        <input type="text" name="sub_cat_name" id="sub_cat_name" class="form-control" value="<?php if(!empty($sub_category[0]->sub_cat_name)){echo $sub_category[0]->sub_cat_name;}else{ echo set_value('sub_cat_name');}?>" maxlength="30">
                                        <span class="red" id="sub_cat_name_error"><?php echo form_error('sub_cat_name'); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">Sub Category Description *</label>
                                    <div class="col-md-6">
                                        <textarea name="sub_cat_desc" id="sub_cat_desc" class="form-control"><?php if(!empty($sub_category[0]->sub_cat_desc)){echo $sub_category[0]->sub_cat_desc;}else{ echo set_value('sub_cat_desc');}?>
                                        </textarea>
                                        <span class="red" id="sub_cat_desc_error"><?php echo form_error('sub_cat_desc'); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">Sequence</label>
                                    <div class="col-md-6">
                                        <input type="text" name="sequence" id="sequence" class="form-control" value="<?php if(!empty($sub_category[0]->sequence)){echo $sub_category[0]->sequence;}else{ echo  !empty($sequence)?$sequence[0]->sequence+1:1; }?>" >
                                        <span class="red" id="sequence_error"><?php echo form_error('sequence'); ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="box-body">  
                                <div class="form-group">
                                    <label class="col-md-2">Sub Category Image*</label>
                                    <div class="col-md-6">
                                        <input type="file" name="sub_cat_image" id="sub_cat_image" accept="image/x-png,image/jpeg" class="item-img file center-block">
                                         <input type="hidden" name="cropped_image" id="cropped_image">
                                        <span class="red" id="sub_cat_image_error"><?php echo form_error('sub_cat_image'); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-2">Note: </label>
                                    <div class="col-md-6">
                                        <span class="text-success" style="font-weight: bold;">
                                            Standard image size must be <span class="text-danger">512 x 512</span> pixels.
                                        </span>
                                    </div>
                                </div>
                            </div>
                                
                                
                                <div class="col-md-12" align="center">
                                    <button type="submit" value="Save" id="submit" class="btn btn-success">Save</button>
                                    <input type="reset" class="btn btn-default" value="Reset"> 
                                </div>
                            </form>
                            
                            <img src="<?php if(!empty($sub_category[0]->sub_cat_image)){
                                echo base_url('asset/uploads/').$sub_category[0]->sub_cat_image;
                            } ?>" class="gambar img-responsive img-thumbnail" id="item-img-output" />

                          
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

    

     function validate() {
       $('.red').text('');
       var category_id  = $('#category_id').val();
       if(category_id==''){
         $('#category_id_error').text('Category Required');
         return false;
       }

       var sub_cat_name  = $('#sub_cat_name').val();
       if(sub_cat_name==''){
        $('#sub_cat_name_error').text('Sub Category Name is Required');
        return false;
       }

       var sub_cat_desc  = $. trim($('#sub_cat_desc').val());
       if(sub_cat_desc==''){
        $('#sub_cat_desc_error').text('Description is Required');
        return false;
       }

     //  $("#sub_cat_image_error").html("");
     // // $(".demoInputBox").css("border-color","#F0F0F0");
     //  var file_size = $('#sub_cat_image')[0].files[0].size;
     //  if(file_size>300000) {
     //    $("#sub_cat_image_error").html("File size is greater than 300kb");
     //  //  $(".demoInputBox").css("border-color","#FF0000");
     //    return false;
     //  } 
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
        width: 150,
        height: 150,
    },
    enforceBoundary: false,
    enableExif: true
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
            width: 150,
            height: 150
        }
    }).then(function(resp) {
        $('#item-img-output').attr('src', resp);
        $('#cropImagePop').modal('hide');
        $('#cropped_image').val(resp);

    });
});
$('#category_id').on('change',function(){
    var id =$(this).val();
    $.ajax({
            url: "<?php echo site_url('vendor/get_sequence')?>",
            data: {
                id: id,
                column:'category_id',
                table:'sub_category'
            },
            type: "POST",
            success:function(result){
                $('#sequence').val(result);
            }
    });
});


</script>