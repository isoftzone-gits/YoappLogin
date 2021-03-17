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

.container ul li input[type=radio]{
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

input[type=radio]:checked ~ .check {
  border: 5px solid #320dff;
}

input[type=radio]:checked ~ .check::before{
  background: #320dff;
}

input[type=radio]:checked ~ label{
  color: #320dff;
}
</style>
<div class="content-wrapper">
  <section class="content-header">
      <h1>
        Login Settings
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

                        <form class="form-group" method="post" action="<?php echo site_url('admin/login_settings'); ?>" enctype="multipart/form-data">
                          <div class="container">
  
                            <h2>Select Login Type</h2>
                            <ul class="ul">
                            <li>
                              <input type="radio" id="1-option" name="login_type" value="1" <?php if(!empty($login_settings[0]->login_type) && $login_settings[0]->login_type==1){
                                echo "checked";
                              } ?>>
                              <label for="1-option">Home Page</label>
                              
                              <div class="check"></div>
                            </li>
                            
                            <li>
                              <input type="radio" id="2-option" name="login_type" value="2" <?php if(!empty($login_settings[0]->login_type) && $login_settings[0]->login_type==2){
                                echo "checked";
                              } ?>>
                              <label for="2-option">Login With Skip</label>
                              
                              <div class="check"><div class="inside"></div></div>
                            </li>
                            
                            <li>
                              <input type="radio" id="3-option" name="login_type" value="3" <?php if(!empty($login_settings[0]->login_type) && $login_settings[0]->login_type==3){
                                echo "checked";
                              } ?>>
                              <label for="3-option">Login</label>
                              
                              <div class="check"><div class="inside"></div></div>
                            </li>
                            <li>
                              <input type="radio" id="4-option" name="login_type" value="4" <?php if(!empty($login_settings[0]->login_type) && $login_settings[0]->login_type==4){
                                echo "checked";
                              } ?>>
                              <label for="4-option">Login With Verify User Only</label>
                              
                              <div class="check"><div class="inside"></div></div>
                            </li>
                          </ul>
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
