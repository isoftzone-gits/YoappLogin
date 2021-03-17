<style>

#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
/* .modal {
  display: none; 
  position: fixed; 
  z-index: 1; 
  padding-top: 100px; 
  left: 0;
  top: 0;
  width: 100%; 
  height: 100%; 
  overflow: auto; 
  background-color: rgb(0,0,0); 
  background-color: rgba(0,0,0,0.9); 
} */


.modal-backdrop{
  z-index: 0 !important;
}

.croppie-container .cr-viewport{
  
    width: 100% !important;
}
/* Modal Content (image) */
.modal-content-1 {
  margin: auto;
  display: block;
  width: 20%;
  max-width: 700px;
}
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

#upload-demo{
    width: 250px;
    height: 250px;
  padding-bottom:25px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close-1 {
  position: absolute;
  top: 15px;
  right: 500px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close-1:hover,
.close-1:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}


  .box {
   padding: 0.5em;
    width: 100%;
    margin:0.5em;    
}

.box-2 {
    padding: 0.5em;
    width: calc(100%/2 - 1em);
}

.modal-body img {
  max-width: 100%;
}
</style>


<!-- <div id="page-wrapper"> -->
<div class="content-wrapper">
  <section class="content-header">
      <h1>
        Banners
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
                <div class="panel-heading"> <a class="btn btn-primary" href="#"><i class="fa fa-th-list"><span class="text-align">Banners</span></i></a> </div>
                <div class="panel panel-default">
                   
                    <div class="panel-body" style="align-content: center;">

                        <form class="form-inline" method="post" action="<?php echo site_url('admin/banners'); ?>" enctype="multipart/form-data" onSubmit="return validate();">
                          <div class="form-group mb-2">
                          <input type="file" required="required" accept="image/x-png,image/jpeg" class="item-img file center-block" id="image" name="image">
                          </div>
                          <span class="red"><?php echo form_error('image'); ?></span>
                          <input type="hidden" name="cropped_image" id="cropped_image">
                          <button type="submit" class="btn btn-success mb-2 save" name="uploadFile" value="UPLOAD">Save</button>

                          <div class="box-body">
                            <div class="row">
                              <div class="form-group">
                                  <label>Note: </label>
                                      <span class="text-success" style="font-weight: bold;">
                                          Standard image size must be <span class="text-danger">600 x 300</span> pixels.
                                      </span>
                              </div>
                            </div>
                          </div>
                        </form>
                        <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
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

                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered display nowrap" cellspacing="0" width="100%" id="banners">
                            <thead>
                                <tr class="bg-primary">
                                    <th>Sr.no</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                   </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $count=1;
                                if(isset($banners)){
                                foreach ($banners as  $value) { ?>
                                <tr class="odd gradeX" id="tr_<?php echo $count;?>">
                                    <td>
                                        <?php echo $count; ?>
                                    </td>
                                   
                                    <td>
                                        <?php if(!empty($value->image)){ ?>
                                      <div class="img-thumbnail">
                                        <img src="<?php echo  base_url('asset/uploads/').$value->image; ?>" class="card-img-top" width="250" height="91" onclick="image_Click(this)" style="border-radius: 5px;">
                                        <?php } ?>
                                      </div>
                                    </td>                 
                                   
                                    <td class="center">
                                    
                                       <a title="Delete" href="javascript:void(0)" onclick="delete_category('<?php echo $value->id;?>','<?php echo $count;?>')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                         </td>
                                   </tr>
                                <?php $count++; } }?> </tbody>
                        </table>
                        
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <div id="myModal" class="modal">
                          <span class="close-1">&times;</span>
                          <img class="modal-content-1" id="img01">
                          <div id="caption"></div>
                        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</section>
</div>

<script type="text/javascript">

    $('#banners').DataTable({
        responsive: true,
        'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [-1] /* 1st one, start by the right */
        }]
    });

function delete_category(id,tr_id) {
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
            url: "<?php echo site_url('admin/delete')?>",
            data: {
                id: id,
                table:'banners'
            },
            type: "POST"
        }).done(function(data) {
            swal("Deleted!", "Record was successfully deleted!", "success");
            $('#tr_' + tr_id).remove();
        }).error(function(data) {
            swal("Oops", "We couldn't connect to the server!", "error");
        });
    });
}

var modal = document.getElementById("myModal");

var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");


function image_Click(el){
    modal.style.display = "block";
    modalImg.src = el.src;
    captionText.innerHTML = el.alt;
}

var span = document.getElementsByClassName("close-1")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}

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
        // console.log(reader);
        // alert(reader);
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
   // alert(tempFilename);
    $('#cancelCropBtn').data('id', imageId);
    readFile(this);
});
$('#cropImageBtn').on('click', function(ev) {
    $uploadCrop.croppie('result', {
    
      //  type: 'base64',
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
  $(".red").html("");
 // $(".demoInputBox").css("border-color","#F0F0F0");
  var file_size = $('#image')[0].files[0].size;
  if(file_size>300000) {
    $(".red").html("File size is greater than 300kb");
  //  $(".demoInputBox").css("border-color","#FF0000");
    return false;
  } 
  return true;
}


 
</script>