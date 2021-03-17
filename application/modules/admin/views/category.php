<style type="text/css">
    .box {
   padding: 0.5em;
    width: 100%;
    margin:0.5em;    
}

.box-2 {
    padding: 0.5em;
    width: calc(100%/2 - 1em);
}

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
            Category
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
                <div class="panel-heading"> <a class="btn btn-primary" href="<?php echo site_url('admin/category_list')?>"><i class="fa fa-th-list"><span class="text-align">Category List</span></i></a> </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <form role="form" method="post" action="<?php if(!empty($category[0])){ echo site_url('admin/category/'.$category[0]->id);}else{echo site_url('admin/category');} ?>" class="registration_form1" id="category_form" enctype="multipart/form-data" onSubmit="return validate();">

                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-md-2">Category Name * </label>
                                        <div class="col-md-6">
                                            <input type="text" name="category_name" id="category_name" class="form-control" value="<?php if(!empty($category[0]->category_name)){echo $category[0]->category_name;}else{ echo set_value('category_name');}?>" maxlength="30">
                                            <span class="red" id="category_name_error"><?php echo form_error('category_name'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-md-2">Category Description*</label>
                                        <div class="col-md-6">
                                            <textarea name="category_description" id="category_description" class="form-control"><?php if(!empty($category[0]->category_description)){echo $category[0]->category_description;}else{ echo set_value('category_description');}?>
                                            </textarea>
                                            
                                            <span class="red" id="category_description_error"><?php echo form_error('category_description'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-md-2">Category Sequence</label>
                                        <div class="col-md-6">
                                            <input type="text" name="sequence" id="sequence" class="form-control" value="<?php if(!empty($category[0]->sequence)){echo $category[0]->sequence;}else{ echo  !empty($sequence)?($sequence[0]->sequence)+1:1; }?>">
                                            
                                            <span class="red" id="sequence_error"><?php echo form_error('sequence'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-md-2">Category Image *</label>
                                        <div class="col-md-6">
                                            <input type="file" name="category_image" id="category_image" accept="image/x-png,image/jpeg" class="item-img file center-block"> 
                                            
                                            <span class="red" id="category_image_error"><?php echo form_error('category_image'); ?></span>
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
                                 <input type="hidden" name="cropped_image" id="cropped_image">


                                <div class="col-md-12" align="center">
                                    <button type="submit" value="Save" id="submit" class="btn btn-success save">Save</button>
                                    <input type="reset" class="btn btn-default" value="Reset"> </div>
                            </form>
                            <img src="<?php if(!empty($category[0]->category_image)){
                                echo base_url('asset/uploads/').$category[0]->category_image;
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

function validate() {
   // $('#category_name_error,category_description_error').text('');
   var category_name  = $('#category_name').val();
   if(category_name==''){
    $('#category_name_error').text('Category Name is Required');
    return false;
   }

   var category_description  = $. trim($('#category_description').val());
   if(category_description==''){
    $('#category_description_error').text('Category Description is Required');
    return false;
   }
}
// End upload preview image
        // vars
    // let result = document.querySelector('.result'),
    // img_result = document.querySelector('.img-result'),
    // img_w = document.querySelector('.img-w'),
    // img_h = document.querySelector('.img-h'),
    // options = document.querySelector('.options'),
    // save = document.querySelector('.save'),
    // cropped = document.querySelector('.cropped'),
    // dwn = document.querySelector('.download'),
    // upload = document.querySelector('#category_image'),
    // cropper = '';

    // // on change show image with crop options
    // upload.addEventListener('change', (e) => {
    //   if (e.target.files.length) {
    //         // start file reader
    //     size = e.target.files[0].size;
    //     if(size >300000){
    //         $('#category_image_error').text('Image Size must be less then 300kb');
    //         return false;
    //     }else{
    //          $('#category_image_error').text('');
    //     }
    //     const reader = new FileReader();
    //     reader.onload = (e)=> {
    //       if(e.target.result){
    //                 // create new image
    //                 let img = document.createElement('img');
    //                 img.id = 'image';
    //                 img.src = e.target.result
    //                 // clean result before
    //                 result.innerHTML = '';
    //                 // append new image
    //                 result.appendChild(img);
    //                 // show save btn and options
    //                 save.classList.remove('hide');
    //                 options.classList.remove('hide');

    //                 // init cropper
    //                 cropper = new Cropper(img, {
    //                 viewMode: 1,
    //                 aspectRatio: 1/1,
    //                 minContainerWidth: 50,
    //                 minContainerHeight: 50,
    //                 minCropBoxWidth: 50,
    //                 minCropBoxHeight: 50,
    //                 movable: false,
    //                 cropBoxResizable:false,
    //                 scalable : false,
    //                 background : false,
    //                 ready: function () {
    //                     console.log('ready');
    //                     console.log(cropper.ready);
    //                 }
    //             });

    //       }
    //     };

    //     reader.readAsDataURL(e.target.files[0]);
    //   }
    // });

    // // save on click
    // save.addEventListener('click',(e)=>{
    //  // e.preventDefault();
    //   // get result to data uri
    //   let imgSrc = cropper.getCroppedCanvas({
    //         width: img_w.value // input value
    //     }).toDataURL();
    //   // remove hide class of img
    //   cropped.classList.remove('hide');
    //     img_result.classList.remove('hide');
    //     // show image cropped
    //   cropped.src = imgSrc;
    //   $('#cropped_image').val(imgSrc);

    //   $( "#category_form" ).submit();
    // });
</script>