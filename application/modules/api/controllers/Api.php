<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');



// This can be removed if you use __autoload() in config.php OR use Modular Extensions

require APPPATH . '/libraries/REST_Controller.php';

class Api extends REST_Controller
{
    
    function __construct(){
      parent::__construct();
      $this->load->helper(array('smtpMail'));
    }


    

    /*verify login*/
    public function verify_login_post(){
        $pdata         = file_get_contents("php://input");
        $data          = json_decode($pdata,true);
        $site_url      = base_url();
        $email         = $data['email'];
        $password      = $data['password'];
        $device_token  = $data['device_token'];

        $where           = array(
               
               'user_role' => 2,
               'phone_no'  => $email,
               'password' =>md5($password)
            );
        $data = $this->model->getAllwhere('users', $where,'unique_id,id,username as name,email,CONCAT("'.base_url().'","asset/uploads/",profile_pic)AS image,is_active,is_verified,phone_no,user_role');
        if(empty($data)){
           $where           = array(
               
              'user_role' => 2,
              'email'  => $email,
              'password' =>md5($password)
            );
          $data = $this->model->getAllwhere('users', $where,'unique_id,id,username as name,email,CONCAT("'.base_url().'","asset/uploads/",profile_pic)AS image,is_active,is_verified,phone_no,user_role');
        }

        
       
        
        if(!empty($data))
        {
          //$this->session->sess_destroy();
          if($data[0]->is_active==0){
            $this->send_otp($data[0]->phone_no,$data[0]->id,'');
          }
          $this->session->set_userdata('id',$data[0]->id);
          $where = array('id' => $data[0]->id);
          $token = array('device_token' => $device_token);

          $this->model->updateFields('users', $token, $where);
          $resp = array('rccode' => 1, 'message' => ' Login SUCCESS', 'user' => $data[0],'is_active'=> $data[0]->is_active,'is_verified'=>$data[0]->is_verified,'user_role'=>$data[0]->user_role,);   
        }else{
          $resp = array('rccode' => 2, 'message' => 'Invalid Email Or Password');
        }
          $this->response($resp);
    }
    

 /*vendor login*/
 public function vendor_login_post(){
  error_reporting(0);
  $pdata         = file_get_contents("php://input");
  $data          = json_decode($pdata,true);
  $site_url      = base_url();
  $email         = $data['email'];
  $password      = $data['password'];
  $device_token  = $data['device_token'];

  $where           = array(
         
         'user_role' => 3,
         'phone_no'  => $email,
         'password' =>md5($password),
         //'is_active'=>1
      );
  $data = $this->model->getAllwhere('company_master', $where,'unique_id,id,username as name,email,CONCAT("'.base_url().'","asset/uploads/",profile_pic)AS image,is_active,is_verified,phone_no,user_role,app_folder,created_at,expire_days,check_expiry');
  if(empty($data)){
     $where           = array(
         
        'user_role' => 3,
        'email'  => $email,
        'password' =>md5($password),
        //'is_active'=>1
      );
    $data = $this->model->getAllwhere('company_master', $where,'unique_id,id,username as name,email,CONCAT("'.base_url().'","asset/uploads/",profile_pic)AS image,is_active,is_verified,phone_no,user_role,app_folder');
  }

  foreach($data as $val)
  {
    $expire = $val->expire_days;
    $check_expiry = $val->check_expiry;
  //   if($expire!=0 && $expire!=NULL)
  // {
  //     $date1 = date_create(date('Y-m-d'));
  // }

    $createDate = new DateTime($val->created_at);
    $strip = $createDate->format('Y-m-d');
    $date1 = strtotime($strip);
  }
  if(empty($date1))
  {
      $date1 = date_create(date('Y-m-d'));
  }
   $date2 =  strtotime(date('Y-m-d'));
   $diff = abs($date2 - $date1);
  
   $years = floor($diff / (365*60*60*24)); 
   $months = floor(($diff - $years * 365*60*60*24) 
                               / (30*60*60*24));  
                               

   $days = floor(($diff - $years * 365*60*60*24 -  $months*30*60*60*24)/ (60*60*24));        
  // print_r($days);
  //if($expire!=0 && $expire!=NULL)
  if($check_expiry == 1){
  if($days >= $expire)  
  {
    $resp = array('rccode' => 2, 'message' => 'Your Trail Expired');
    $this->response($resp);
  }

  else{
  
  if(!empty($data))
  {
    //$this->session->sess_destroy();
    if($data[0]->is_active==0){
      $this->send_otp($data[0]->phone_no,$data[0]->id,'');
    }
    $this->session->set_userdata('id',$data[0]->id);
    $where = array('id' => $data[0]->id);
    $token = array('device_token' => $device_token);
  
    $this->model->updateFields('company_master', $token, $where);

    $app_folder = $this->model->getAllwhere('company_master',$where,'app_folder'); // Dayanmic base url.
       $value = 'null';
    foreach($app_folder as $value){
     // print_r(  $app_folder);
     $value = $value->app_folder;
    }

  
  if(empty($value))
    {
      $resp = array('rccode' => 2, 'message' => 'Vendor is not verified');
    }
    else{
      $resp = array('rccode' => 1, 'message' => ' Login SUCCESS', 'vendor' => $data[0],'is_active'=> $data[0]->is_active,'is_verified'=>$data[0]->is_verified,'user_role'=>$data[0]->user_role,);   
    }
  
  }else{
    $resp = array('rccode' => 2, 'message' => 'Invalid Email Or Password');
  }
   $this->response($resp);
}
  }else{
    if(!empty($data))
    {
      //$this->session->sess_destroy();
      if($data[0]->is_active==0){
        $this->send_otp($data[0]->phone_no,$data[0]->id,'');
      }
      $this->session->set_userdata('id',$data[0]->id);
      $where = array('id' => $data[0]->id);
      $token = array('device_token' => $device_token);
    
      $this->model->updateFields('company_master', $token, $where);
  
      $app_folder = $this->model->getAllwhere('company_master',$where,'app_folder'); // Dayanmic base url.
         $value = 'null';
      foreach($app_folder as $value){
       // print_r(  $app_folder);
       $value = $value->app_folder;
      }
  
    
    if(empty($value))
      {
        $resp = array('rccode' => 2, 'message' => 'Vendor is not verified');
      }
      else{
        $resp = array('rccode' => 1, 'message' => ' Login SUCCESS', 'vendor' => $data[0],'is_active'=> $data[0]->is_active,'is_verified'=>$data[0]->is_verified,'user_role'=>$data[0]->user_role,);   
      }
    
    }else{
      $resp = array('rccode' => 2, 'message' => 'Invalid Email Or Password');
    }
     $this->response($resp);
  }
 }




     /*Check User isLogin*/
    public function isLogin_get(){
      if($this->session->userdata('id')!=null){
        $site_url=base_url();
        $where           = array(
               //"username = ".$username." or email=".$username,
               'id'        =>$this->session->userdata('id'),
               'is_active' => 1
                );
        $data = $this->model->getAllwhere('users', $where,'id,first_name,last_name,email,CONCAT("'.base_url().'","asset/uploads/",profile_pic)AS image');
        $resp = array('rccode'  => 1, 'message' => 'SUCCESS', 'response' => array('user' => $data ));   
      }else{
        $resp = array('code' => 'ERROR', 'message' => 'Failure', 'response' => array('message' => 'please Login to continue'));
      }
       $this->response($resp);
    }

    /*register User*/
    public function register_post(){
        $pdata = file_get_contents("php://input");
        $data  = json_decode($pdata,true);
       
        $site_url=base_url();
        $required_parameter = array('name','email','password','phone_no');
        $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }

        $username    = $data['name'];
        $phone_no    = $data['phone_no'];
        $email       = $data['email'];
        $password    = $data['password'];
        $address     = $data['address'];
        $lat         = $data['lat'];
        $long        = $data['long'];
        $referal_id  = !empty($data['referralCode']) ?$data['referralCode'] : '';
        $where1             = array(
               'email'      => $email,
               'user_role'      => 2
                );
        $check_email = $this->model->getAllwhere('users', $where1);
        if(!empty($check_email)){
               $resp = array('rccode' => 2, 'message' => 'Email Already Registrered Please Change Your Email');
               $this->response($resp); 
               return false;
        }
        $where2             = array(
               'phone_no'      => $phone_no,
                'user_role'      => 2
               //'is_active'  => 0
                );
        $check_name = $this->model->getAllwhere('users', $where2);
       // echo $this->db->last_query();die;
        if(!empty($check_name)){
               $resp = array('rccode' => 2, 'message' => 'Phone No Already Registrered Please Change Your Phone No');
               $this->response($resp); 
               return false;
        }

        define('UPLOAD_DIR', 'asset/uploads/');

        $img     = isset($data['image']) ? $data['image'] : '';    
      
        if(!empty($img)){
        $image_parts = explode(";base64,", $img);
        $data1    = base64_decode($image_parts[1]);
        $file    =  UPLOAD_DIR . uniqid() . '.png';
        $success = file_put_contents($file, $data1);
       
        $image = substr($file,14);
        }
        $data = array(
            'phone_no'       => $phone_no,
            'username'       => $username,
            'email'          => $email,
            'address'        => $address,
            'lat'            => $lat,
            'long'           => $long,
            'password'       => MD5($password),
            'is_active'      => 0,
            'user_role'      => 2,
            'created_at'     => date('Y-m-d H:i:s')
                );

        if(!empty($image)){
          $data['profile_pic']  = $image;
        }

        $id = $this->model->insertData('users', $data);
      
        $where           = array(
               'id'        =>$id,
               'is_active' => 0
                );
        $result = $this->model->getAllwhere('users', $where,'id,username as name,CONCAT("'.base_url().'","asset/uploads/",profile_pic)AS image');
        
        if(!empty($result)){



          $this->send_otp($phone_no,$id,$email);
          $current_date = date('Y-m-d');

            $where = array(
              'valid_from <='=> $current_date,
              'valid_to >='  => $current_date,
              'wallet_type'  => 'registration' 
            );
            $get_reg_amt = $this->model->getAllwhere('wallet_details',$where,'','id','DESC','1');

            
            if(!empty($get_reg_amt)){
              $unixtime = strtotime("+".$get_reg_amt[0]->valid_upto." days");
              $date     = date("Y-m-d",$unixtime);
              $wallet_data = array(
              'user_id'       => $id,
              'wallet_type'   => 'registration',
              'wallet_amount' => $get_reg_amt[0]->amount,
              'expire_date'   => $date,
              'created_at'    => date('Y-m-d H:i:s')
            );
            $this->model->insertData('wallet_masters',$wallet_data);  
            }

            if(!empty($referal_id)){
              $referal_user_id = $this->model->getAllwhere('users',array('unique_id'=> $referal_id));
              if(!empty($referal_user_id)){
                $unique_user_id = $referal_user_id[0]->id;

                $ref_where = array(
                  'valid_from <='=> $current_date,
                  'valid_to >='  => $current_date,
                  'wallet_type'  => 'referal'
                );
               $get_ref_amt = $this->model->getAllwhere('wallet_details',$ref_where,'','id','DESC','1');
                 

                 if(!empty($get_ref_amt)){
                  $unixtime = strtotime("+".$get_ref_amt[0]->valid_upto." days");
                  $date     = date("Y-m-d",$unixtime);
                    $wallet_data = array(
                    'user_id'       => $unique_user_id,
                    'wallet_type'   => 'referal',
                    'wallet_amount' => $get_ref_amt[0]->amount,
                    'referal_id'    => $id,
                    'expire_date'   => $date,
                    'created_at'    => date('Y-m-d H:i:s') 
                  );
                  $this->model->insertData('wallet_masters',$wallet_data);  
                }

              }
            }
            $update_data = array(
              'unique_id' => "YoApp_".$id
            );

            $result = $this->model->updateFields('users', $update_data, array('id'=>$id));
            
            $resp = array('rccode' => 1, 'message' => 'Registrered Successfully','user_id'=> $id);   
        }else{
            $resp = array('rccode' => 2, 'message' => 'Not Registrered');
        }
            $this->response($resp);
    } 


/*register Vendor*/
      public function vendor_post(){

     
        $pdata = file_get_contents("php://input");
        $data  = json_decode($pdata,true);
      
        $site_url=base_url();
        $required_parameter = array('name','email','password','phone_no');
        $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
            $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
            @$this->response($resp);
        }
        $company_name = $data['company_name'];
       
        $username    = $data['name'];
        $phone_no    = $data['phone_no'];
        $email       = $data['email'];
        $password    = $data['password'];
        $address     = $data['address'];
        $lat         = $data['lat'];
        $long        = $data['long'];
        $referal_id  = !empty($data['referralCode']) ?$data['referralCode'] : '';
        $where1             = array(
              'email'      => $email,
              'user_role'      => 3
                );
        $check_email = $this->model->getAllwhere('company_master', $where1);
      
        if(!empty($check_email)){
              $resp = array('rccode' => 2, 'message' => 'Email Already Registrered Please Change Your Email');
              $this->response($resp); 
              return false;
        }
        $where2             = array(
              'phone_no'      => $phone_no,
              'user_role'      => 3
              //'is_active'  => 0
                );
        $check_name = $this->model->getAllwhere('company_master', $where2);
      // echo $this->db->last_query();die;
        if(!empty($check_name)){
              $resp = array('rccode' => 2, 'message' => 'Phone No Already Registrered Please Change Your Phone No');
              $this->response($resp); 
              return false;
        }

        define('UPLOAD_DIR', 'asset/uploads/');

        $img     = isset($data['image']) ? $data['image'] : '';    

        if(!empty($img)){
        $image_parts = explode(";base64,", $img);
        $data1    = base64_decode($image_parts[1]);
        $file    =  UPLOAD_DIR . uniqid() . '.png';
        $success = file_put_contents($file, $data1);
      
        $image = substr($file,14);
        }
        $data = array(
            'phone_no'       => $phone_no,
            'company_name'   => $company_name,
            'username'       => $username,
            'email'          => $email,
            'address'        => $address,
            'lat'            => $lat,
            'long'           => $long,
            'app_folder'     =>'logincommon',
            'password'       => MD5($password),
            'is_active'      => 0,
            'user_role'      => 3,
            'created_at'     => date('Y-m-d H:i:s'),
            'expire_days'    =>14,
            'check_expiry'   =>1
                );

               
        if(!empty($image)){
          $data['profile_pic']  = $image;
        }

        $id = $this->model->insertData('company_master', $data);
    

        $where           = array(
              'id'        =>$id,
              'is_active' => 0
                );
        $result = $this->model->getAllwhere('company_master', $where,'id,username as name,CONCAT("'.base_url().'","asset/uploads/",profile_pic)AS image');
     
        if(!empty($result)){



          $this->send_otp($phone_no,$id,$email);
          $current_date = date('Y-m-d');

            $where = array(
              'valid_from <='=> $current_date,
              'valid_to >='  => $current_date,
              'wallet_type'  => 'registration' 
            );
            $get_reg_amt = $this->model->getAllwhere('wallet_details',$where,'','id','DESC','1');

            
            if(!empty($get_reg_amt)){
              $unixtime = strtotime("+".$get_reg_amt[0]->valid_upto." days");
              $date     = date("Y-m-d",$unixtime);
              $wallet_data = array(
              'user_id'       => $id,
              'wallet_type'   => 'registration',
              'wallet_amount' => $get_reg_amt[0]->amount,
              'expire_date'   => $date,
              'created_at'    => date('Y-m-d H:i:s')
            );
            $this->model->insertData('wallet_masters',$wallet_data);  
            }

            if(!empty($referal_id)){
              $referal_user_id = $this->model->getAllwhere('company_master',array('unique_id'=> $referal_id));
              if(!empty($referal_user_id)){
                $unique_user_id = $referal_user_id[0]->id;

                $ref_where = array(
                  'valid_from <='=> $current_date,
                  'valid_to >='  => $current_date,
                  'wallet_type'  => 'referal'
                );
              $get_ref_amt = $this->model->getAllwhere('wallet_details',$ref_where,'','id','DESC','1');
                

                if(!empty($get_ref_amt)){
                  $unixtime = strtotime("+".$get_ref_amt[0]->valid_upto." days");
                  $date     = date("Y-m-d",$unixtime);
                    $wallet_data = array(
                    'user_id'       => $unique_user_id,
                    'wallet_type'   => 'referal',
                    'wallet_amount' => $get_ref_amt[0]->amount,
                    'referal_id'    => $id,
                    'expire_date'   => $date,
                    'created_at'    => date('Y-m-d H:i:s') 
                  );
                  $this->model->insertData('wallet_masters',$wallet_data);  
                }

              }
            }
            $update_data = array(
              'unique_id' => "YoApp_".$id,
              'is_active' =>1
            );

            $result = $this->model->updateFields('company_master', $update_data, array('id'=>$id));
            
            $resp = array('rccode' => 1, 'message' => 'Registrered Successfully','user_id'=> $id);   
        }else{

            $resp = array('rccode' => 2, 'message' => 'Not Registrered');
        }
            $this->response($resp);
      } 



    /*Change Password*/
    public function changePassword_post(){
        $pdata = file_get_contents("php://input");
        $data  = json_decode($pdata,true);
       
        
        $required_parameter = array('user_id','old_password','new_password');
        $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }

        $user_id      = $data['user_id'];
        $old_password = md5($data['old_password']);
        $new_password = md5($data['new_password']);

        $where        = array(
                    'is_active' => 1,
                    'id'        =>  $user_id
                );

        $userData =    $this->model->getAllwhere('users',$where);

        if(empty($userData))
        {
            $resp = array('rccode' => 2, 'message' => 'Invalid User Id');
            $this->response($resp);   
        }else if($userData[0]->password != $old_password)
        {
            
            $resp = array('rccode' => 2, 'message' => 'Wrong Old Password');
            $this->response($resp); 
        }
        $data        = array(
                    'password'  => $new_password
                );
        $result = $this->model->updateFields('users', $data, $where);

        /* Response array */
        $resp = array('rccode' => 1, 'message' => 'Password 
        d successfully');

        $this->response($resp);
    }

    
    /*Update user Profile*/
   

    public function get_category_get(){
      $site_url=base_url();
      $where = array('status'=>1);
      $where1 = array('status'=>1);
      $data = $this->model->getAllwhere('category',$where,',id,category_name,category_description,CONCAT("'.base_url().'","asset/uploads/",category_image)AS category_image,CONCAT("'.base_url().'","asset/uploads/",category_image)AS thumbnail_image,sequence','sequence','ASC');
     if(!empty($data)){
        foreach ($data as $key => $value) {
          
          $where  = array('category_id' => $value->id,'status'=>1);
          $sub_category  = $this->model->getAllwhere('sub_category',$where);

          if(!empty($sub_category)){
            $value->has_sub_category = true;
          }else{
            $value->has_sub_category = false;
          }
        }
        
       }


        $banners =    $this->model->getAllwhere('banners',$where1,'CONCAT("'.base_url().'","asset/uploads/",image)AS image,id','sequence','ASC');
        $details =    $this->model->getAllwhere('details','','company_name,theme_color,is_sharing,payment_gateway,slab_rate,CONCAT("'.base_url().'","asset/uploads/",logo)AS logo');
        $login_type =    $this->model->getAllwhere('login_Settings','','login_type');
        $payment_settings = $this->model->getAllwhere('payment_master','','status,user_defined_name');
        $settings     = $this->model->getAllwhere('settings_masters');
        $payment_key  = $this->model->getAllwhere('payment_master');
        
        $cash_on_delivery     = 1;
        $self_pickup          = 1;
        $home_delivery        = 1;
        $wallet_with_discount = 1;
        $cash_on_delivery_name = 'cash_on_delivery';
        $self_pickup_name = 'Self Pickup';
        $home_delivery_name = 'Home Delivery';
        $product_view       = 'list';
        if(!empty($details)){
          $details[0]->login_type = (!empty($login_type) ) ? $login_type[0]->login_type : '1';
          $details[0]->payment_setting = (!empty($payment_settings) ) ? $payment_settings[0]->status : '0';
          $details[0]->payment_setting_name = (!empty($payment_settings[0]->user_defined_name) ) ? $payment_settings[0]->user_defined_name : 'Pay Now';
          if(!empty($settings)){
            foreach ($settings as $key => $value) {
                if($value->name=='cash_on_delivery'){
                  $cash_on_delivery      = $value->value;
                  $cash_on_delivery_name = !empty($value->user_defined_name) ? $value->user_defined_name : 'Cash On Delievery';
                }elseif ($value->name=='self_pickup') {
                  $self_pickup      = $value->value;
                  $self_pickup_name = !empty($value->user_defined_name) ? $value->user_defined_name : 'Self Pickup';
                }elseif ($value->name=='home_delivery') {
                  $home_delivery    = $value->value;
                  $home_delivery_name = !empty($value->user_defined_name) ? $value->user_defined_name : 'Home Delivery';
                }elseif ($value->name=='product_view') {
                   $product_view    = $value->value;
                }
                elseif ($value->name=='wallet_with_discount') {
                   $wallet_with_discount    = $value->value;
                }
            }
          }

          $details[0]->cash_on_delivery          = $cash_on_delivery;
          $details[0]->self_pickup               = $self_pickup;
          $details[0]->home_delivery             = $home_delivery;
          $details[0]->product_view              = $product_view;
          $details[0]->cash_on_delivery_name     = $cash_on_delivery_name;
          $details[0]->self_pickup_name          = $self_pickup_name;
          $details[0]->home_delivery_name        = $home_delivery_name;
          $details[0]->wallet_with_discount      = $wallet_with_discount;
          $details[0]->payment_client_id         = (!empty($payment_key) ) ? $payment_key[0]->client_id : '0';
          $details[0]->payment_client_secret     = (!empty($payment_key) ) ? $payment_key[0]->client_secret : '0';

        } 


     
        $resp = array(
                'rccode'       => 1,
                'message'      => 'SUCCESS',
                'details'      => (!empty($details) ) ? $details[0] : array(),
                'category'     => (!empty($data) ) ? $data: [],
                'banners'      => $banners
                 
            );
        $this->response($resp);
    }

    public function get_sub_category_post(){
        $pdata = file_get_contents("php://input");
        $data  = json_decode($pdata,true);
       
        
        $required_parameter = array('cat_id');
        $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }

        $cat_id    = $data['cat_id'];
        $where  = array('category_id' => $cat_id,'status'=>1);
        $data = $this->model->getAllwhere('sub_category',$where,',id,category_id,sub_cat_name,sub_cat_desc,CONCAT("'.base_url().'","asset/uploads/",sub_cat_image)AS sub_cat_image,CONCAT("'.base_url().'","asset/uploads/thumbnail/",sub_cat_image)AS thumbnail_image','sequence','ASC');
         
        if (!empty($data)) 
        {
            $resp = array(
                    'rccode'      => 1,
                    'message'   => 'SUCCESS',
                    'sub_category'   => $data
                   
                );
        }else{
            $resp = array(
                    'rccode'    => 2,
                    'message' => 'No Sub category Available'
                );
        }
        $this->response($resp);

    }

    public function get_product_post(){
      
      $pdata = file_get_contents("php://input");
      
        $data  = json_decode($pdata,true);
        //$this->response($data);
        
        $required_parameter = array('cat_id','pagenum');
        $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }
        $pagenum       = $data['pagenum'];
        $no_of_records_per_page= '10';
        $cat_id        = $data['cat_id'];
        $s_cat_id      = isset($data['s_cat_id']) ? $data['s_cat_id'] : 0;
        $where  = array('category_id' => $cat_id,'sub_cat_id' => $s_cat_id,'status'=>1);

        $offset = ($pagenum-1) * $no_of_records_per_page;
        $data = $this->model->getAllwhere('product',$where,',id,category_id,sub_cat_id,product_name,product_description,min_qty,increase_qty,mrp,product_price,unit,product_image,stock','sequence','ASC',$no_of_records_per_page,$offset);
       
        if (!empty($data)) 
        {
          foreach ($data as $key => $value) {
            if(!empty($value->product_image)){
              $final_images = [];
              $thumbnail_image = '';
                $images = @unserialize($value->product_image);
                if(!empty($images)){
                foreach ($images as $skey => $svalue) {
                  $final_images[] = base_url()."asset/uploads/".$svalue;
                  if($skey==0){
                    $thumbnail_image = base_url()."asset/uploads/thumbnail/".$svalue;
                  }
                }
              }
                $data[$key]->product_image = $final_images;
                $data[$key]->thumbnail_image = $thumbnail_image;

                
            }else{
              $data[$key]->product_image = [];
            }

            $product_id  = $value->id;
            $attributes = $this->model->getAllwhere('product_attributes',array('product_id'=> $product_id));
            $slab_rate  = $this->model->getAllwhere('slab_rate_setting',array('product_id'=> $product_id));
           
            if(!empty($attributes)){
              foreach ($attributes as $akey => $avalue) {
                $attributes[$akey]->product_attributes = htmlspecialchars_decode($avalue->product_attributes);
              }
              $data[$key]->attributes  = $attributes;
            }

            if(!empty($slab_rate)){
              foreach ($slab_rate as $bkey => $bvalue) {
                $slab_rate[$bkey]->qty_from = $bvalue->qty_from;
              }
              $data[$key]->slab_rate  = $slab_rate;
            }
          }
          
          

            $resp = array(
                    'rccode'      => 1,
                    'message'   => 'SUCCESS',
                    'products'   => $data
                    
                );
        }else{
            $resp = array(
                    'rccode'    => 2,
                    'message' => 'No Product Available'
                );
        }
        $this->response($resp);

    }

    public function place_order_post(){
        $pdata = file_get_contents("php://input");
        $data  = json_decode($pdata,true);

        $required_parameter = array('user_id','items');
        $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }

        $user_id          = $data['user_id'];
        $place_name       = isset($data['place_name']) ? $data['place_name'] : '';
        $lat              = isset($data['lat']) ? $data['lat'] : '';
        $lng              = isset($data['lng']) ? $data['lng'] :'';
        $address          = isset($data['address']) ? $data['address'] : '';
        $shipping_rate    = isset($data['shipping_rate']) ? $data['shipping_rate']:'';
        $address_id       = isset($data['address_id']) ? $data['address_id'] : '';
        $delivery_type    = isset($data['delivery_type']) ? $data['delivery_type'] : '';
        $paymentMode      = isset($data['paymentMode']) ? $data['paymentMode'] : '';
        $orderId          = isset($data['orderId']) ? $data['orderId'] : '';
        $txtime           = isset($data['txtime']) ? $data['txtime'] : '';
        $referenceId      = isset($data['referenceId']) ? $data['referenceId'] : '';
        $type             = isset($data['type']) ? $data['type'] : '';
        $txMsg            = isset($data['txMsg']) ? $data['txMsg'] : '';
        $signature        = isset($data['signature']) ? $data['signature'] : '';
        $orderAmount      = isset($data['orderAmount']) ? $data['orderAmount'] : '';
        $txStatus         = isset($data['txStatus']) ? $data['txStatus'] : '';
        $wallet_amount    = isset($data['wallet_amount']) ? $data['wallet_amount'] : 0;
        $wallet_id        = isset($data['wallet_id']) ? $data['wallet_id'] : 0;
        $coupon_id        = isset($data['couponid']) ? $data['couponid'] :0;
        $coupon_code      = isset($data['couponcode']) ? $data['couponcode'] : 0;
        $discount_amount  = isset($data['couponamount']) ? $data['couponamount'] : 0;
        
        $order  = array(
            'user_id'         => $user_id,
            'place_name'      => $place_name,
            'lat'             => $lat,
            'lng'             => $lng,
            'address'         => $address,
            'shipping_rate'   => $shipping_rate,
            'address_id'      => $address_id,
            'delivery_type'   => $delivery_type,
            'paymentMode'     => $paymentMode,
            'orderId'         => $orderId,
            'txtime'          => $txtime,
            'referenceId'     => $referenceId,
            'type'            => $type,
            'txMsg'           => $txMsg,
            'signature'       => $signature,
            'orderAmount'     => $orderAmount,
            'txStatus'        => $txStatus,
            'wallet_amount'   => $wallet_amount,
            'coupon_id'       => $coupon_id,
            'coupon_code'     => $coupon_code,
            'discount_amount' => $discount_amount

        );
        
        define('UPLOAD_DIR', 'asset/uploads/');
        $order_id = $this->model->insertData('orders', $order);
        $items    = $data['items'];
        if(!empty($order_id)){
          if(!empty($wallet_amount)){
            $wallet_data = array(
              'order_id'      =>  $order_id,
              'wallet_id'     =>  0,
              'amount'        =>  $wallet_amount,
              'user_id'       =>  $user_id,
              'created_at'    =>  date('Y-m-d H:i:s')
            );
            $this->model->insertData('wallet_redeem', $wallet_data);
            } 
            foreach ($items as $key => $value) {
                 $order_items  = array(
                    'order_id'           => $order_id,
                    'category_id'        => $value['category_id'],
                    'sub_cat_id'         => $value['sub_cat_id'],
                    'product_id'         => $value['id'],
                    'product_name'       => $value['product_name'],
                    'product_description'=> $value['product_description'],
                    'product_price'      => $value['product_price'],
                    'product_image'      => $value['product_image'],
                    'qtyTotal'           => $value['qtyTotal'],
                    'totalAmt'           => round($value['totalAmt'],2),
                    'attr_id'            => $value['attr_id'],
                    'product_attribute'  => $value['product_attribute'],
                    'naration'           => $value['naration']
                 );

                 

                  $img     =  isset($value['extra_img']) ?$value['extra_img'] :null;   
                 // $img     = str_replace('data:image/jpeg;base64,', '', $img);
                  //$img     = str_replace(' ', '+', $img);
                  if(!empty($img)){
                    $image_parts = explode(";base64,", $img);
                    $data1    = base64_decode($image_parts[1]);
                    $file    =  UPLOAD_DIR . uniqid() . '.png';
                    $success = file_put_contents($file, $data1);
                   
                    $image = substr($file,14);

                    $order_items['extra_img']  = $image;
                  }

                 $this->model->insertData('orders_items', $order_items);
            }

            $phone_no  = $this->model->getAllwhere('users',array('id'=>$user_id));
            if(!empty($phone_no)){
              $no  = $phone_no[0]->phone_no;
              $this->send_msg($no);
            }

            $resp = array(
                    'rccode'      => 1,
                    'message'   => 'Order Successfully',
                    
                );
        }else{
             $resp = array(
                    'rccode'    => 3,
                    'message' => 'Something Went  Wrong'
                );
        }
       $this->response($resp);

    }

    public function ongoing_order_post(){
        $pdata = file_get_contents("php://input");
        $data  = json_decode($pdata,true);

        $required_parameter = array('user_id');
        $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }
     $user_id  = $data['user_id'];
     $where  = array(
        'user_id' => $user_id,
       // 'created_at LIKE' => date('Y-m-d').'%',
        'status!='=> 'delivered'
      );
      $isVendor =0;
      try
      {
        if(isset($data['vendor']))
        $isVendor=1;
      }
      catch (Exception $e)
      {

      }

            $orders =  $this->model->GetJoinRecord('orders', 'user_id', 'users', 'id', 'orders.*,users.username,users.phone_no',$isVendor==0?$where:'');
           // $orders = $this->model->getAllwhere('orders',$isVendor==0?$where:'');
     
      $order_list  = array();
      if (!empty($orders)) 
      {
        foreach ($orders as $key => $value) {
          if($isVendor==0){
            if($value->status!='cancel'){
            $order_id    = $value->id;
            $items_where = array('order_id'=>$order_id);
            $order_items = $this->model->getAllwhere('orders_items',$items_where);
            $orders[$key]->items = $order_items;

            $order_list[]  = $value;
            }
          }
          else{
            $order_id    = $value->id;
            $items_where = array('order_id'=>$order_id);
            $order_items = $this->model->getAllwhere('orders_items',$items_where);
            $orders[$key]->items = $order_items;

            $order_list[]  = $value;
          }
        }
        
        $resp = array(
                'rccode'      => 1,
                'message'   => 'SUCCESS',
                //'response'  => array(
                'orders'   => $order_list
              //  )
            );
      }else{
        $resp = array(
                'rccode'    => '2',
                'message' => 'No Going Order'
            );
      }
        $this->response($resp);
    }

    public function vendor_ongoing_order_post(){
      $pdata = file_get_contents("php://input");
      $data  = json_decode($pdata,true);

      $required_parameter = array('user_id');
      $chk_error = $this->controller->check_required_value($required_parameter, $data);
      if ($chk_error) 
      {
           $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
           @$this->response($resp);
      }
   $user_id     =  $data['user_id'];
  // $company_id  =  $data['company_id'];
   $status_type =  $data['status_type'];

   $where ="";

   //
   if(strtoupper($status_type)=="PROGRESS"){
    $where  = array(
       'user_id' => $user_id,
      // 'created_at LIKE' => date('Y-m-d').'%',
       'status'=> $status_type,
       //'company_id' =>$company_id
     );
     $isVendor =0;
     try
     {
       if(isset($data['vendor']))
       $isVendor=1;
     }
     catch (Exception $e)
     {

     }

    
   }
   elseif(strtoupper($status_type)=="DISPATCHED"){
     $where  = array(
        'user_id' => $user_id,
       // 'created_at LIKE' => date('Y-m-d').'%',
        'status'=> $status_type,
       // 'company_id' =>$id
      );
      $isVendor =0;
      try
      {
        if(isset($data['vendor']))
        $isVendor=1;
      }
      catch (Exception $e)
      {

      }

     
    }
   elseif(strtoupper($status_type)=="CANCEL"){
     $where  = array(
        'user_id' => $user_id,
       // 'created_at LIKE' => date('Y-m-d').'%',
        'status'=> $status_type,
        //'company_id' =>$id
      );
      $isVendor =0;
      try
      {
        if(isset($data['vendor']))
        $isVendor=1;
      }
      catch (Exception $e)
      {

      }

      
    }
    elseif(strtoupper($status_type)=="PLACED"){
     $where  = array(
        'user_id' => $user_id,
       // 'created_at LIKE' => date('Y-m-d').'%',
        'status'=> $status_type,
        //'company_id' =>$id
      );
      $isVendor =0;
      try
      {
        if(isset($data['vendor']))
        $isVendor=1;
      }
      catch (Exception $e)
      {

      }
    
    
    }
    elseif(strtoupper($status_type)=="ALL"){
      $where  = array(
         'user_id' => $user_id
          
       );
       $isVendor =0;
       try
       {
         if(isset($data['vendor']))
         $isVendor=1;
       }
       catch (Exception $e)
       {
 
       }
     
     }

     if(!empty($where))
     {
      $orders =  $this->model->GetJoinRecord('orders', 'user_id', 'users', 'id', 'orders.*,users.username,users.phone_no',$isVendor==0?$where:'');
      //$orders = $this->model->getAllwhere('orders',$isVendor==0?$where:'');
     }
   

    $order_list  = array();
    if (!empty($orders)) 
    {
      foreach ($orders as $key => $value) {
        if($isVendor==0){
          if($value->status!='cancel'){
          $order_id    = $value->id;
          $items_where = array('order_id'=>$order_id);
          $order_items = $this->model->getAllwhere('orders_items',$items_where);
          $orders[$key]->items = $order_items;

          $order_list[]  = $value;
          }
        }
        else{
          $order_id    = $value->id;
          $items_where = array('order_id'=>$order_id);
          $order_items = $this->model->getAllwhere('orders_items',$items_where);
          $orders[$key]->items = $order_items;

          $order_list[]  = $value;
        }
      }
      
      $resp = array(
              'rccode'      => 1,
              'message'   => 'SUCCESS',
              //'response'  => array(
              'orders'   => $order_list
            //  )
          );
    }else{
      $resp = array(
              'rccode'    => '2',
              'message' => 'No Going Order'
          );
    }
      $this->response($resp);
  }


    public function past_order_post(){
        $pdata = file_get_contents("php://input");
        $data  = json_decode($pdata,true);

        $required_parameter = array('user_id');
        $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }
     $user_id  = $data['user_id'];
     
      $where  = array(
        'user_id' => $user_id,
      );
      $isVendor =0;
      try
      {
        if(isset($data['vendor']))
        $isVendor=1;
      }
      catch (Exception $e)
      {

      }
       
     // $orders = $this->model->getAllwhere('orders',$isVendor==0?$where:'');
  $orders =  $this->model->GetJoinRecord('orders', 'user_id', 'users', 'id', 'orders.*,users.username,users.phone_no',$isVendor==0?$where:'');
      $order_list  = array();
      if (!empty($orders)) 
      {
        foreach ($orders as $key => $value) {
          if($isVendor==0){
            if($value->status=='delivered' ||$value->status=='cancel'){
            $order_id    = $value->id;
            $items_where = array('order_id'=>$order_id);
            $order_items = $this->model->getAllwhere('orders_items',$items_where);
            $orders[$key]->items = $order_items;
            $order_list[]  = $value;
            }
          }else{
            $order_id    = $value->id;
            $items_where = array('order_id'=>$order_id);
            $order_items = $this->model->getAllwhere('orders_items',$items_where);
            $orders[$key]->items = $order_items;
            $order_list[]  = $value;
          }
        }
        
        $resp = array(
                'rccode'      => 1,
                'message'   => 'SUCCESS',
                //'response'  => array(
                'orders'   => $order_list
              //  )
            );
      }else{
        $resp = array(
                'rccode'    => 2,
                'message' => 'No Going Order'
            );
      }
        $this->response($resp);
    }

    public function updateProfile_post(){
        $pdata = file_get_contents("php://input");
        $data  = json_decode($pdata,true);

        $required_parameter = array('user_id');
        $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }

        $where = array('id'=> $data['user_id']);
        $name  = $data['name'];
       // $last_name   = $data['last_name'];
        $address     = $data['address'];
       // $phone_no    = $data['phone_no'];
        $dob         = $data['dob'];
        $gender      = $data['gender'];
        $lat         = $data['lat'];
        $long        = $data['long'];
        $anniversary = $data['anniversary'];
                     
        $insert_data = array(
            'username'       => $name,
            'address'        => $address,
          //  'phone_no'       => $phone_no,
            'date_of_birth'  => $dob,
            'gender'         => $gender,
            'lat'            => $lat,
            'long'           => $long,
            'anniversary'    => $anniversary
        );

        define('UPLOAD_DIR', 'asset/uploads/');

        $img     = $data['image'];    
       // $img     = str_replace('data:image/jpeg;base64,', '', $img);
        //$img     = str_replace(' ', '+', $img);
        if(!empty($img)){
        $image_parts = explode(";base64,", $img);
        $data1    = base64_decode($image_parts[1]);
        $file    =  UPLOAD_DIR . uniqid() . '.png';
        $success = file_put_contents($file, $data1);
       
        $image = substr($file,14);

        $insert_data['profile_pic']  = $image;
        }
      $result = $this->model->updateFields('users', $insert_data, $where);

      /* Response array */
      $resp = array('rccode' => 200, 'message' => 'Profile Updated Successfully');

      $this->response($resp);

        
    }

    /*get user Profile*/
    public function getProfile_post(){
        $pdata = file_get_contents("php://input");
        $data  = json_decode($pdata,true);

        $required_parameter = array('user_id');
        $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }
        $user_id      = $data['user_id'];
        $where        = array(
                    'is_active' => 1,
                    'id'        =>  $user_id
                );
        $userData =    $this->model->getAllwhere('users',$where,'username as name,date_of_birth as DOB ,gender,address,lat,long,phone_no,id as user_id,CONCAT("'.base_url().'","asset/uploads/",profile_pic)AS image,anniversary,email');
        if(empty($userData))
        {
            $resp = array('rccode' => 3, 'message' => 'Invalid User Id');
            $this->response($resp);   
        }else
        {
            $resp = array('rccode' => 1, 'message' => 'SUCCESS', 'user' => $userData[0]);   
            $this->response($resp); 
        }
    }

    // get bannner image 
    public function get_banners_get(){
      $banners =    $this->model->getAllwhere('banners','','CONCAT("'.base_url().'","asset/uploads/",image)AS image,id');
      
      if(empty($banners)) {
            $resp = array('rccode' => 2, 'message' => 'No Banner Image Found');
            $this->response($resp);   
      }else{
            $resp = array('rccode' => 1, 'message' => 'SUCCESS', 'banners' => $banners);  
             
            $this->response($resp); 
      }

    }

    public function get_about_us_get(){
      $about =    $this->model->getAllwhere('about','','about');
      $data  =  !empty($about[0]) ? $about[0]->about : null;
      echo $data;
    }



    public function get_payment_options_get(){
      $payment_options =    $this->model->getAllwhere('payment_options','','payment_options');
      $data  =  !empty($payment_options[0]) ? $payment_options[0]->payment_options : null;
      echo $data;
    }


    public function get_privacy_policy_get(){
      $privacy_policy =    $this->model->getAllwhere('privacy_policy','','privacy_policy');
      $data  =  !empty($privacy_policy[0]) ? $privacy_policy[0]->privacy_policy : null;
      echo $data;
    }

    public function get_terms_conditions_get(){
      $terms_conditions =    $this->model->getAllwhere('terms_conditions','','terms_conditions');
      $data  =  !empty($terms_conditions[0]) ? $terms_conditions[0]->terms_conditions : null;
      echo $data;
    }


    public function get_refund_policy_get(){
      $refund_policy =    $this->model->getAllwhere('refund_policy','','refund_policy');
      $data  =  !empty($refund_policy[0]) ? $refund_policy[0]->refund_policy : null;
      echo $data;
    }

    public function get_contact_us_get(){
      $contact_us =    $this->model->getAllwhere('contact_us','','contact_us');
      $data  =  !empty($contact_us[0]) ? $contact_us[0]->contact_us : null;
      echo $data;
    }


     public function get_shipping_rate_post(){
        $pdata = file_get_contents("php://input");
        $data  = json_decode($pdata,true);

        $required_parameter = array('lat','long');
        $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }
        $lat      = $data['lat'];
        $long     = $data['long'];


        $company_details  = $this->model->getAllwhere('details','','lat,long');

        $clat   = $company_details[0]->lat;
        $clong  = $company_details[0]->long;

        $distance =  $this->distance($clat, $clong,$lat,$long, "K");
        
        // $where = array(
        //   'from >='  => $distance,
        //   'to   <='  => $distance
        // );

        // $shipping_rate  = $this->model->getAllwhere('shipping_master',$where,'rate');
        $shipping_rate  = $this->Common_model->get_shipping_rate($distance);

        $resp = array('rccode' => 1, 'message' => 'SUCCESS', 'shipping_rate' => $shipping_rate);   
        $this->response($resp); 
        // echo $this->db->last_query();
        // echo "<pre>";
        // print_r($shipping_rate);die;
        
     }

      public function verify_address_post(){
        $pdata = file_get_contents("php://input");
        $data  = json_decode($pdata,true);

        $required_parameter = array('lat','long');
        $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }
        $lat      = $data['lat'];
        $long     = $data['long'];


        $company_details  = $this->model->getAllwhere('details','','lat,long');

        $clat   = $company_details[0]->lat;
        $clong  = $company_details[0]->long;

        $distance =  $this->distance($clat, $clong,$lat,$long, "K");
        
        $where    = array('name'=>'delivery_range');
        $get_km   = $this->model->getAllwhere('settings_masters',$where);

        $status  = 1;
        if(!empty($get_km) && $get_km[0]->value!='unlimited'){
            if($distance>$get_km[0]->value){
              $status=0;
            }
        }

        $resp = array('rccode' => 1, 'message' => 'SUCCESS', 'statis' => $status);   
        $this->response($resp); 
        // echo $this->db->last_query();
        // echo "<pre>";
        // print_r($shipping_rate);die;
        
     }

        /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    /*::                                                                         :*/
    /*::  This routine calculates the distance between two points (given the     :*/
    /*::  latitude/longitude of those points). It is being used to calculate     :*/
    /*::  the distance between two locations using GeoDataSource(TM) Products    :*/
    /*::                                                                         :*/
    /*::  Definitions:                                                           :*/
    /*::    South latitudes are negative, east longitudes are positive           :*/
    /*::                                                                         :*/
    /*::  Passed to function:                                                    :*/
    /*::    lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees)  :*/
    /*::    lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees)  :*/
    /*::    unit = the unit you desire for results                               :*/
    /*::           where: 'M' is statute miles (default)                         :*/
    /*::                  'K' is kilometers                                      :*/
    /*::                  'N' is nautical miles                                  :*/
    /*::  Worldwide cities and other features databases with latitude longitude  :*/
    /*::  are available at https://www.geodatasource.com                          :*/
    /*::                                                                         :*/
    /*::  For enquiries, please contact sales@geodatasource.com                  :*/
    /*::                                                                         :*/
    /*::  Official Web site: https://www.geodatasource.com                        :*/
    /*::                                                                         :*/
    /*::         GeoDataSource.com (C) All Rights Reserved 2018                  :*/
    /*::                                                                         :*/
    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    public function distance($lat1, $lon1, $lat2, $lon2, $unit) {
      if (($lat1 == $lat2) && ($lon1 == $lon2)) {
        return 0;
      }
      else {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
          return ($miles * 1.609344);
        } else if ($unit == "N") {
          return ($miles * 0.8684);
        } else {
          return $miles;
        }
      }
    }

// echo distance(32.9697, -96.80322, 29.46786, -98.53506, "M") . " Miles<br>";
// echo distance(32.9697, -96.80322, 29.46786, -98.53506, "K") . " Kilometers<br>";
// echo distance(32.9697, -96.80322, 29.46786, -98.53506, "N") . " Nautical Miles<br>";
    public function get_notification_get(){
      $notification = $this->model->getAllwhere('notification');

      $resp = array(
                'rccode'    => 1,
                'message'   => 'SUCCESS',
                'notification'  => (!empty($notification) ) ? $notification: [],
            );
        $this->response($resp);
    }

    public function cancel_order_post(){
      $pdata = file_get_contents("php://input");
      $data  = json_decode($pdata,true);

      $required_parameter = array('order_id');
      $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }

        $order_id  = $data['order_id'];
        $where = array('id' => $order_id);
        $status = array('status' => 'cancel');

          $this->model->updateFields('orders', $status, $where);
          $resp = array('rccode' => 1, 'message' => 'Order Cancel successfully');   
          $this->response($resp);
    }


    public function add_address_post(){
      $pdata = file_get_contents("php://input");
      $data  = json_decode($pdata,true);

      $required_parameter = array('user_id','addr_type');
      $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }

        $user_id                = $data['user_id'];
        $addr_type              = $data['addr_type'];
        $area_name              = $data['area_name'];
        $lat                    = $data['lat'];
        $long                   = $data['long'];
        $address                = $data['address'];
        $house_no               = $data['house_no'];
        $landmark               = $data['landmark'];
        $floor                  = $data['floor'];
        $area                   = $data['area'];
        $completeAddress        = $data['completeAddress'];
        $city                   = !empty($data['city'])?$data['city'] : '';
        $state                  = !empty($data['state'])?$data['state'] : '';
        $country                = !empty($data['country'])?$data['country'] : '';

        $data  = array(
          'user_id'         => $user_id,
          'addr_type'       => $addr_type,
          'area_name'       => $area_name,
          'lat'             => $lat,
          'long'            => $long,
          'address'         => $address,
          'house_no'        => $house_no,
          'landmark'        => $landmark,
          'floor'           => $floor,
          'area'            => $area,
          'completeAddress' => $completeAddress,
          'city'            => $city,
          'state'           => $state,
          'country'         => $country,
          'created_at'      => date('Y-m-d H:i:s')
        );
         
        $id = $this->model->insertData('address_master', $data);

        if(!empty($id)){
          $resp = array('rccode' => 1, 'message' => 'Added Successfully'); 
        }else{
          $resp = array('rccode' => 2, 'message' => 'Something Went Wrong');
        }
        $this->response($resp);

    }    


    public function get_address_by_userID_post(){
      $pdata = file_get_contents("php://input");
      $data  = json_decode($pdata,true);

      $required_parameter = array('user_id');
      $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }
        $user_id  = $data['user_id'];
        $data     = $this->model->getAllwhere('address_master',array('user_id'=>$user_id));

        $resp = array('rccode' => 1, 'address' => !empty($data)?$data:[]); 
        $this->response($resp);
    }

    public function delete_address_post(){
      $pdata = file_get_contents("php://input");
      $data  = json_decode($pdata,true);

      $required_parameter = array('user_id','address_id');
      $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }
        $user_id    = $data['user_id'];
        $address_id = $data['address_id'];

        $where = array(
                        'id'      => $address_id,
                        'user_id' => $user_id
                   );
        $data     = $this->model->delete('address_master',$where);

        $resp = array('rccode' => 1, 'message' => 'Deleted successfully'); 
        $this->response($resp);
    } 

// Get app version for customer
    public function app_version_get(){
      $data     = $this->model->getAllwhere('app_version_history','','versioncode,versionname','id','DESC','1');

      $resp = array('rccode' => 1, 'version' => !empty($data) ? $data[0]:[]); 
      $this->response($resp);
    
    } 


     // Get app version for vendor
     public function vendor_app_version_get(){
      $data     = $this->model->getAllwhere('vendor_app_version','','versioncode,versionname','id','DESC','1');

      $resp = array('rccode' => 1, 'version' => !empty($data) ? $data[0]:[]); 
      $this->response($resp);
    
    } 

    public function search_post(){
      $pdata = file_get_contents("php://input");
      $data  = json_decode($pdata,true);

      $required_parameter = array('search');
      $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }

      $search_key  = $data['search'];
     
      $data = $this->Common_model->get_product('product',$search_key);

      if (!empty($data)) 
        {
          foreach ($data as $key => $value) {
            if(!empty($value['product_image'])){
              $final_images = [];
                $images = @unserialize($value['product_image']);
                if(!empty($images)){
                foreach ($images as $skey => $svalue) {
                  $final_images[] = base_url()."asset/uploads/".$svalue;
                }
              }
                $data[$key]['product_image'] = $final_images;

                
            }else{
              $data[$key]['product_image'] = [];
            }

            $product_id  = $value['id'];
            $attributes = $this->model->getAllwhere('product_attributes',array('product_id'=> $product_id));

            if(!empty($attributes)){
              $data[$key]['attributes']  = $attributes;
            }
          }
          


            $resp = array(
                    'rccode'      => 1,
                    'message'   => 'SUCCESS',
                    'products'   => $data
                    
                );
        }else{
            $resp = array(
                    'rccode'    => 2,
                    'message' => 'No Product Available'
                );
        }
        $this->response($resp);
    }
// otp verify for Yoapp customer
    public function verify_otp_post(){
      $pdata = file_get_contents("php://input");
      $data  = json_decode($pdata,true);

      $required_parameter = array('otp','user_id');
      $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }

      $otp      = $data['otp'];
      $user_id  = $data['user_id'];

      $where  = array(
        'user_id' => $user_id,
        'otp'     => $otp
      );    

      $verify  = $this->model->getAllwhere('otp_master',$where);
      if(!empty($verify)){
          $update  = array('is_active'=> 1);
          $this->model->updateFields('users',$update,array('id'=>$user_id));
          $this->model->delete('otp_master',array('user_id'=>$user_id));
            $resp = array(
                    'rccode'      => 1,
                    'message'   => 'Otp Verify Successfully',                    
            );
      }else{
            $resp = array(
                    'rccode'      => 2,
                    'message'   => 'Please Enter Valid Otp',                    
            );
      } 

      $this->response($resp); 
    }

   // otp verify for Yoapp vendor
    public function vendor_otp_post(){
      $pdata = file_get_contents("php://input");
      $data  = json_decode($pdata,true);

      $required_parameter = array('otp','user_id');
      $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }

      $otp      = $data['otp'];
      $user_id  = $data['user_id'];

      $where  = array(
        'user_id' => $user_id,
        'otp'     => $otp
      );    

      $verify  = $this->model->getAllwhere('otp_master',$where);
      if(!empty($verify)){
          $update  = array('is_active'=> 1);
          $this->model->updateFields('company_master',$update,array('id'=>$user_id));
          $this->model->delete('otp_master',array('user_id'=>$user_id));
          $where  = array(
            'id' => $user_id,
          );    
  
          $res  = $this->model->getAllwhere('company_master',$where,'unique_id,id,username as name,email,CONCAT("'.base_url().'","asset/uploads/",profile_pic)AS image,is_active,is_verified,phone_no,user_role,app_folder');
          $resp = array('rccode' => 1, 'message' => ' Login SUCCESS', 'vendor' => $res[0],'is_active'=> $res[0]->is_active,'is_verified'=>$res[0]->is_verified,'user_role'=>$res[0]->user_role,);
          // $resp = array(
            //         'rccode'      => 1,
            //         'message'   => 'Otp Verify Successfully',                    
            // );
      }else{
            $resp = array(
                    'rccode'      => 2,
                    'message'   => 'Please Enter Valid Otp',                    
            );
      } 

      $this->response($resp); 
    }

    public function forgot_password_post(){
      $pdata = file_get_contents("php://input");
      $data  = json_decode($pdata,true);

      $required_parameter = array('phone_no');
      $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }

      $phone_no      = $data['phone_no'];
      
      $where  = array(
        'phone_no' => $phone_no
      );    

      $data  = $this->model->getAllwhere('users',$where);
      if(!empty($data)){
          $user_id  = $data[0]->id;
          $this->send_otp($phone_no,$user_id);
            $resp = array(
                    'rccode'    => 1,
                    'message'   => 'SUCCESS',
                    'user_id'   => $user_id                      
            );
      }else{
            $resp = array(
                    'rccode'      => 2,
                    'message'   => 'Please Enter Valid Phone No.',                    
            );
      } 

      $this->response($resp); 
    }

    public function update_password_post(){
      $pdata = file_get_contents("php://input");
      $data  = json_decode($pdata,true);

      $required_parameter = array('user_id','password');
      $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }

      $user_id       = $data['user_id'];
      $password      = md5($data['password']);
      
      $where  = array(
        'id' => $user_id
      );    

      $data  = $this->model->updateFields('users',array('password'=>$password),$where);
      
        $resp = array(
                'rccode'    => 1,
                'message'   => 'password Updated Successfully'               
        );
      

      $this->response($resp);  
    }

    public function send_otp($phone_no,$id,$email = NULL){
      $mobileNumber = '91'.$phone_no;
          //$mobileNumber = '919699996116';
          //Sender ID,While using route4 sender id should be 6 characters long.
          $data = $this->model->getAllwhere('sms_settings',array('type'=>'OTP'));

          $senderId = !empty($data[0]->sender_id)? $data[0]->sender_id:"YOAPPS";
          //Your message to send, Add URL encoding here.
          $otp    = mt_rand(1000,9999);
          $details =    $this->model->getAllwhere('details','');
          $message  = !empty($details[0]->company_name)? "Dear Customer, to confirm your mobile number for ".$details[0]->company_name." Application, please enter the verification code ".$otp." in your online application form." :"Dear Customer, to confirm your mobile number for YoApp Application, please enter the verification code ".$otp." in your online application form.";
          $message  = urlencode("$message");
          $AuthKey  = !empty($data[0]->auth_key)? $data[0]->auth_key :'d55cf7975e584389cf6283ad562be';

          $url  = !empty($data[0]->url) ? $data[0]->url: 'sms.isoftzone.com';
          
          //API URL
          $url="http://$url/rest/services/sendSMS/sendGroupSms?AUTH_KEY=$AuthKey&message=$message&senderId=$senderId&routeId=1&mobileNos=$mobileNumber&smsContentType=english";
          
          // init the resource
          $ch = curl_init();
          curl_setopt_array($ch, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_POST => false,
          //CURLOPT_POSTFIELDS => $postData
          //,CURLOPT_FOLLOWLOCATION => true
          ));
          //Ignore SSL certificate verification
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
          //get response
          $output = curl_exec($ch);
          //Print error if any
          if(curl_errno($ch))
          {
          echo 'error:' . curl_error($ch);
          }
          curl_close($ch);
          

          // ===================================
          $logo  = !empty($details[0]->logo) ? 'http://yoappstore.com/login/asset/uploads/thumbnail/'.$details[0]->logo :'';
          $email_template  = '<!DOCTYPE html PUBLIC "
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
      <!--[if !mso]><!-->
      <meta http-equiv="X-UA-Compatible" content="IE=Edge">
      <!--<![endif]-->
      <!--[if (gte mso 9)|(IE)]>
      <xml>
        <o:OfficeDocumentSettings>
          <o:AllowPNG/>
          <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
      </xml>
      <![endif]-->
      <!--[if (gte mso 9)|(IE)]>
  <style type="text/css">
    body {width: 600px;margin: 0 auto;}
    table {border-collapse: collapse;}
    table, td {mso-table-lspace: 0pt;mso-table-rspace: 0pt;}
    img {-ms-interpolation-mode: bicubic;}
  </style>
<![endif]-->
      <style type="text/css">
    body, p, div {
      font-family: inherit;
      font-size: 14px;
    }
    body {
      color: #000000;
    }
    body a {
      color: #000000;
      text-decoration: none;
    }
    p { margin: 0; padding: 0; }
    table.wrapper {
      width:100% !important;
      table-layout: fixed;
      -webkit-font-smoothing: antialiased;
      -webkit-text-size-adjust: 100%;
      -moz-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
    }
    img.max-width {
      max-width: 100% !important;
    }
    .column.of-2 {
      width: 50%;
    }
    .column.of-3 {
      width: 33.333%;
    }
    .column.of-4 {
      width: 25%;
    }
    @media screen and (max-width:480px) {
      .preheader .rightColumnContent,
      .footer .rightColumnContent {
        text-align: left !important;
      }
      .preheader .rightColumnContent div,
      .preheader .rightColumnContent span,
      .footer .rightColumnContent div,
      .footer .rightColumnContent span {
        text-align: left !important;
      }
      .preheader .rightColumnContent,
      .preheader .leftColumnContent {
        font-size: 80% !important;
        padding: 5px 0;
      }
      table.wrapper-mobile {
        width: 100% !important;
        table-layout: fixed;
      }
      img.max-width {
        height: auto !important;
        max-width: 100% !important;
      }
      a.bulletproof-button {
        display: block !important;
        width: auto !important;
        font-size: 80%;
        padding-left: 0 !important;
        padding-right: 0 !important;
      }
      .columns {
        width: 100% !important;
      }
      .column {
        display: block !important;
        width: 100% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
      }
    }
  </style>
      <!--user entered Head Start--><link href="https://fonts.googleapis.com/css?family=Viga&display=swap" rel="stylesheet"><style>
    body {font-family: "Viga", sans-serif;}
</style><!--End Head user entered-->
    </head>
    <body>
      <center class="wrapper" data-link-color="#000000" data-body-style="font-size:14px; font-family:inherit; color:#000000; background-color:#FFFFFF;">
        <div class="webkit">
          <table cellpadding="0" cellspacing="0" border="0" width="100%" class="wrapper" bgcolor="#FFFFFF">
            <tbody><tr>
              <td valign="top" bgcolor="#FFFFFF" width="100%">
                <table width="100%" role="content-container" class="outer" align="center" cellpadding="0" cellspacing="0" border="0">
                  <tbody><tr>
                    <td width="100%">
                      <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tbody><tr>
                          <td>
                            <!--[if mso]>
    <center>
    <table><tr><td width="600">
  <![endif]-->
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width:100%; max-width:600px;" align="center">
                                      <tbody><tr>
                                        <td role="modules-container" style="padding:0px 0px 0px 0px; color:#000000; text-align:left;" bgcolor="#FFFFFF" width="100%" align="left"><table class="module preheader preheader-hide" role="module" data-type="preheader" border="0" cellpadding="0" cellspacing="0" width="100%" style="display: none !important; mso-hide: all; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0;">
    <tbody><tr>
      <td role="module-content">
        <p></p>
      </td>
    </tr>
  </tbody></table><table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" role="module" data-type="columns" style="padding:0px 0px 0px 0px;" bgcolor="#dde6de">
    <tbody>
      <tr role="module-content">
        <td height="100%" valign="top">
          <table class="column" width="580" style="width:580px; border-spacing:0; border-collapse:collapse; margin:0px 10px 0px 10px;" cellpadding="0" cellspacing="0" align="left" border="0" bgcolor="">
            <tbody>
              <tr>
                <td style="padding:0px;margin:0px;border-spacing:0;"><table class="module" role="module" data-type="spacer" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="10cc50ce-3fd3-4f37-899b-a52a7ad0ccce">
    <tbody>
      <tr>
        <td style="padding:0px 0px 40px 0px;" role="module-content" bgcolor="">
        </td>
      </tr>
    </tbody>
  </table><table class="wrapper" role="module" data-type="image" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="f8665f9c-039e-4b86-a34d-9f6d5d439327">
    <tbody>
      <tr>
        <td style="font-size:6px; line-height:10px; padding:0px 0px 0px 0px;" valign="top" align="center">
          <img class="max-width" border="0" style="display:block; color:#000000; text-decoration:none; font-family:Helvetica, arial, sans-serif; font-size:16px;" width="130" alt="" data-proportionally-constrained="true" data-responsive="false" src="'.$logo.'" height="33">
        </td>
      </tr>
    </tbody>
  </table><table class="module" role="module" data-type="spacer" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="10cc50ce-3fd3-4f37-899b-a52a7ad0ccce.1">
    <tbody>
      <tr>
        <td style="padding:0px 0px 30px 0px;" role="module-content" bgcolor="">
        </td>
      </tr>
    </tbody>
  </table></td>
              </tr>
            </tbody>
          </table>
          
        </td>
      </tr>
    </tbody>
  </table><table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="bff8ffa1-41a9-4aab-a2ea-52ac3767c6f4">
    <tbody>
      <tr>
        <td style="padding:18px 30px 18px 30px; line-height:40px; text-align:inherit; background-color:#dde6de;" height="100%" valign="top" bgcolor="#dde6de" role="module-content"><div><div style="font-family: inherit; text-align: center"><span style="color: #6fab81; font-size: 40px; font-family: inherit">Thank you for downloading the app! Now what?</span></div><div></div></div></td>
      </tr>
    </tbody>
  </table><table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="2f94ef24-a0d9-4e6f-be94-d2d1257946b0">
    <tbody>
      <tr>
        <td style="padding:18px 50px 18px 50px; line-height:22px; text-align:inherit; background-color:#dde6de;" height="100%" valign="top" bgcolor="#dde6de" role="module-content"><div><div style="font-family: inherit; text-align: center"><span style="font-size: 16px; font-family: inherit">Confirm your Registation By Below OTP.&nbsp;</span></div><div></div></div></td>
      </tr>
    </tbody>
  </table><table border="0" cellpadding="0" cellspacing="0" class="module" data-role="module-button" data-type="button" role="module" style="table-layout:fixed;" width="100%" data-muid="c7bd4768-c1ab-4c64-ba24-75a9fd6daed8">
      <tbody>
        <tr>
          <td align="center" bgcolor="#dde6de" class="outer-td" style="padding:10px 0px 20px 0px;">
            <table border="0" cellpadding="0" cellspacing="0" class="wrapper-mobile" style="text-align:center;">
              <tbody>
                <tr>
                <td align="center" bgcolor="#eac96c" class="inner-td" style="border-radius:6px; font-size:16px; text-align:center; background-color:inherit;">
                  <a href="#" style="background-color:#eac96c; border:0px solid #333333; border-color:#333333; border-radius:0px; border-width:0px; color:#000000; display:inline-block; font-size:16px; font-weight:normal; letter-spacing:0px; line-height:normal; padding:20px 30px 20px 30px; text-align:center; text-decoration:none; border-style:solid; font-family:inherit;" >'.$otp.'</a>
                </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table><table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" role="module" data-type="columns" style="padding:30px 0px 0px 0px;" bgcolor="#dde6de">
    <tbody>
      <tr role="module-content">
        <td height="100%" valign="top">
          <table class="column" width="600" style="width:600px; border-spacing:0; border-collapse:collapse; margin:0px 0px 0px 0px;" cellpadding="0" cellspacing="0" align="left" border="0" bgcolor="">
            <tbody>
              <tr>
                <td style="padding:0px;margin:0px;border-spacing:0;"><table class="wrapper" role="module" data-type="image" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="ce6dd3be-5ed4-42d2-b304-55a58022cdf0">
    <tbody>
      <tr>
        <td style="font-size:6px; line-height:10px; padding:0px 0px 0px 0px;" valign="top" align="center">
          <img class="max-width" border="0" style="display:block; color:#000000; text-decoration:none; font-family:Helvetica, arial, sans-serif; font-size:16px; max-width:100% !important; width:100%; height:auto !important;" width="600" alt="" data-proportionally-constrained="true" data-responsive="true" src="http://cdn.mcauto-images-production.sendgrid.net/954c252fedab403f/a8915cf9-9083-4c7b-bf41-dfbe1bdec0f7/600x539.png">
        </td>
      </tr>
    </tbody>
  </table></td>
              </tr>
            </tbody>
          </table>
          
        </td>
      </tr>
    </tbody>
  </table></div></center></body></html>';


           if(!empty($email)){
              $to_visitor  = $email;
              $subject_visitor = 'OTP VERIFICATION';

              $headers = "From: " . strip_tags('info@isoftzone.com') . "\r\n";
              $headers .= "Reply-To: ". strip_tags('info@isoftzone.com') . "\r\n";
              $headers .= "CC: gorav.badlani@gmail.com\r\n";
              $headers .= "MIME-Version: 1.0\r\n";
              $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
              $to  = 'gorav.badlani@gmail.com';
              //mail($to, $subject, $email_template, $headers);
              $mail  =  send_smtp_mail($to_visitor,$subject_visitor,$email_template,'');
            ///  echo $mail;die;

           }


          // ======================================

            $where = array(
                        'user_id' => $id
                   );
            $data     = $this->model->delete('otp_master',$where);
            $otp_data  = array(
              'user_id' => $id,
              'otp'     => $otp
            );
            $this->model->insertData('otp_master',$otp_data);
            $resp = array(
              'rccode'    => 1,
              'message'   => 'otp send succefully',
              'user_id'=> $id               
      );
    

    $this->response($resp);  
    }

    public function email_test_get(){
     $this->send_otp('96999996116','1','gorav.badlani@gmail.com');
    }

    public function send_msg($phone_no){
          $mobileNumber = '91'.$phone_no;
          //$mobileNumber = '919699996116';
          //Sender ID,While using route4 sender id should be 6 characters long.
          $data = $this->model->getAllwhere('sms_settings',array('type'=>'ORDER'));
          if(empty($data)){
            return;
          }
          if(!empty($data[0]->status==0)){
            return;
          }
          $senderId = !empty($data[0]->sender_id)? $data[0]->sender_id:"YOAPPS";
          //Your message to send, Add URL encoding here.
          $otp    = mt_rand(1000,9999);
          $message  = !empty($data[0]->message)? $data[0]->message :"Thanks for placing your order with YoApp.
Your order has been confirmed and would be delivered within the next 2 days.
Regards
Team YoApp";
          $message  = urlencode("$message");
          $AuthKey  = !empty($data[0]->auth_key)? $data[0]->auth_key :'d55cf7975e584389cf6283ad562be';

          $url  = !empty($data[0]->url) ? $data[0]->url: 'sms.isoftzone.com';
          
          //Your message to send, Add URL encoding here.
         
          
          //API URL
          $url="http://$url/rest/services/sendSMS/sendGroupSms?AUTH_KEY=$AuthKey&message=$message&senderId=$senderId&routeId=1&mobileNos=$mobileNumber&smsContentType=english";
          
          // init the resource
          $ch = curl_init();
          curl_setopt_array($ch, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_POST => false,
          //CURLOPT_POSTFIELDS => $postData
          //,CURLOPT_FOLLOWLOCATION => true
          ));
          //Ignore SSL certificate verification
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
          //get response
          $output = curl_exec($ch);
          //Print error if any
          if(curl_errno($ch))
          {
          echo 'error:' . curl_error($ch);
          }
          curl_close($ch);
          

            
    }


    public function get_wallet_amount_post(){
      $pdata = file_get_contents("php://input");
      $data  = json_decode($pdata,true);

      $required_parameter = array('user_id');
      $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }

      $user_id  = $data['user_id'];

      $where  = array(
        'user_id' => $user_id
      );    

      $wallet_details  = $this->model->getAllwhere('wallet_masters',$where);
      $wallet_redeem_amount  = $this->model->getAllwhere('wallet_redeem',array('user_id'=>$user_id),'SUM(amount) as redeem_amount');
      if(!empty($wallet_details)){
            foreach ($wallet_details as $key => $value) {
               // $wallet_where = array(
               //    'user_id'   => $user_id,
               //    'wallet_id' => $value->id
               // );
               // $wallet_redeem_amount  = $this->model->getAllwhere('wallet_redeem',$wallet_where,'SUM(amount) as redeem_amount');
               // $wallet_details[$key]->redeem_amount = !empty($wallet_redeem_amount)?$wallet_redeem_amount[0]->redeem_amount:0;
               $referal_id  = $value->referal_id;

               if(!empty($referal_id)){
                $username  = $this->model->getAllwhere('users',array('id'=>$referal_id),'username');
                $wallet_details[$key]->referal_to  = @$username[0]->username;
               }else{
                $wallet_details[$key]->referal_to  = '';
               }
            }
            $redeem_amount  = $this->model->getAllwhere('wallet_redeem',array('user_id'=>$user_id),'order_id,amount,created_at');
            $resp = array(
                    'rccode'        => 1,
                    'message'       => 'SUCCESS',
                    'wallet_amount' => $wallet_details,
                    'used_amount'   => !empty($wallet_redeem_amount) ? $wallet_redeem_amount[0]->redeem_amount :0,
                    'redeem_amount' => !empty($redeem_amount) ? $redeem_amount : []
            );
      }else{
            $resp = array(
                    'rccode'      => 2,
                    'message'   => 'No Wallet Amount'                    
            );
      } 

      $this->response($resp); 
    }

    public function get_payment_token_post(){
      $pdata = file_get_contents("php://input");
      $data  = json_decode($pdata,true);

      $required_parameter = array('user_id','amount');
      $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }

      $user_id  = $data['user_id'];
      $amount   = $data['amount'];

        $order_id   = 'Order-'.$user_id.mt_rand(0,99);
        $post_fields  = array(
          'orderId'       => $order_id,
          'orderAmount'   => $amount,
          'orderCurrency' => 'INR'
        );

        $payment_data  = $this->model->getAllwhere('payment_master');
        $client_id     = !empty($payment_data[0]->client_id) ? $payment_data[0]->client_id : "167286af2ee404367248b9c9582761";
        $client_secret = !empty($payment_data[0]->client_secret) ? $payment_data[0]->client_secret : "1a8e231be6b729bd41a656d85f44bcc605f0399e";
        $post_header  = array(
          'Content-Type: application/json',
          'x-client-id: '.$client_id,
          'x-client-secret: '.$client_secret
        );
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"https://api.cashfree.com/api/v2/cftoken/order");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                    json_encode($post_fields));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($ch);

        // if($errno = curl_errno($ch)) {
        //     $error_message = curl_strerror($errno);
        //     echo "cURL error ({$errno}):\n {$error_message}";
        // }


        curl_close ($ch);
        $result = json_decode($server_output);
        if(!empty($result)){
        if($result->status=="OK"){
          $response = array(
            'token'     => $result->cftoken,
            'order_id'  => $order_id,
            'user_id'   => $user_id
          );

           $resp = array(
                            'rccode'        => 1,
                            'message'       => 'SUCCESS',
                            'data' => $response
                    );

        }else{
           $resp = array(
                            'rccode'      => 2,
                            'message'   => 'Error Generating Token'                    
                    );

        }
        }else{
          $resp = array(
                            'rccode'      => 2,
                            'message'   => 'Error Generating Token'                  
                    );
        }

         $this->response($resp); 
    }

    public function get_wallet_details_post(){
      $pdata = file_get_contents("php://input");
      $data  = json_decode($pdata,true);

      $required_parameter = array('user_id');
      $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }

      $user_id  = $data['user_id'];

      // $where  = array(
      //   'user_id' => $user_id
      // );    

      
      $current_date    = date('Y-m-d');
      $where = array(
              'user_id'        => $user_id,
              'expire_date >=' => $current_date
              //'wallet_type!='  => 'expired'
            );
      $get_wallet_id = $this->model->getAllwhere('wallet_masters',$where,'SUM(wallet_amount) as total_amount');

      if(!empty($get_wallet_id)){
       $wallet_redeem_amount  = $this->model->getAllwhere('wallet_redeem',array('user_id'=>$user_id),'SUM(amount) as redeem_amount');


         $redeem_where    = array(
          'valid_from <=' => $current_date,
          'valid_to   >=' => $current_date
         );
         $redeem_per  = $this->model->getAllwhere('wallet_details',$redeem_where,'redeem_per','id','ASC','1');
         // echo $this->db->last_query();die;

        // $wallet_details[0]->id  = $get_wallet_id[0]->id;
         $where1 = array(
              'user_id'        => $user_id,
              //'expire_date >=' => $current_date
              'wallet_type'  => 'expired'
            );
        $getexpired_amount  = $this->model->getAllwhere('wallet_masters',$where1,'SUM(wallet_amount) as expire_amount');
        $total_amount       = !empty($get_wallet_id[0]->total_amount) ?$get_wallet_id[0]->total_amount : 0;
        $expire             = !empty($getexpired_amount[0]->expire_amount) ?$getexpired_amount[0]->expire_amount : 0;
        //$final_amount       = $total_amount - $expire;
        $wallet_details = array(
          'total_amount' => $total_amount,
          'used_amount'  => !empty($wallet_redeem_amount)?$wallet_redeem_amount[0]->redeem_amount : 0,
          'redeem_per'  => !empty($redeem_per) ? $redeem_per[0]->redeem_per :0,
          'expire_amount'=> $expire
        );
        // $wallet_details[0]->total_amount  = $get_wallet_id[0]->total_amount;
        // $wallet_details[0]->used_amount  = !empty($wallet_redeem_amount)?$wallet_redeem_amount[0]->redeem_amount : 0;
         $resp = array(
                    'rccode'        => 1,
                    'message'       => 'SUCCESS',
                    'wallet_amount' => $wallet_details
            );
      }else{
            $resp = array(
                    'rccode'      => 2,
                    'message'   => 'No Wallet Amount'                    
            );
      } 

      $this->response($resp); 
    }

    public function verify_coupon_post(){
        $pdata = file_get_contents("php://input");
        $data  = json_decode($pdata,true);

        $required_parameter = array('coupon_code','user_id');
        $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }
        $coupon_code      = $data['coupon_code'];
        $user_id          = $data['user_id'];
        $current_date = date('Y-m-d');
        $where   = array(
          'coupon_code'  => $coupon_code,
          'start_date <='=> $current_date,
          'end_date >='  => $current_date,
          'status'       => 1

        );


        $discount_coupon  = $this->model->getAllwhere('discount_coupon',$where);
        if(!empty($discount_coupon)){
            $attempt   = $discount_coupon[0]->coupon_redeemed_no;
            $get_count = $this->model->getAllwhere('orders',array('user_id'=>$user_id,'coupon_id'=> $discount_coupon[0]->id),'COUNT(id) as total_count');
           
            if(!empty($get_count)){
                if($get_count[0]->total_count >= $attempt){
                  $resp = array('rccode' => 2, 'message' => 'Coupon Already Redeemed');
                }else{
                  $resp = array('rccode' => 1, 'message' => 'SUCCESS','counpon_detail'=>$discount_coupon[0]);    
                }
            }else{
              $resp = array('rccode' => 1, 'message' => 'SUCCESS','counpon_detail'=>$discount_coupon[0]);
            }
        }else{
            $resp = array('rccode' => 2, 'message' => 'Invalid Discount Coupon');  
        }
       
        

         
        $this->response($resp); 
        
     }

    // banners Api for insert,update nd delete. 
      public function banners_post()
      {
        
        $pdata = file_get_contents("php://input");
        $data  = json_decode($pdata,true);

        if (isset($data['id']) )
        {
          
          $id = $data['id'];
          
          
        }
        $msg = "";
        $sequence = $data['sequence']; 
        $status = $data['status'];

         if (!isset($data['id']) )
   {
     $query1 = "SELECT IFNULL(max(sequence),0) + 1 As maxSequence FROM `banners`";
     $result  = $this->Common_model->sequence_update($query1);
     $result = $result->result();
     foreach( $result as $val)
     {
       $sequence = $val->maxSequence;
     }
   }
          $insert_data = array(
            'sequence' => $sequence,
              'status' => $status
          ) ;
        
        define('UPLOAD_DIR', 'asset/uploads/');
        $img     = $data['image'];    
        
      // $img     = str_replace('data:image/jpeg;base64,', '', $img);
        //$img     = str_replace(' ', '+', $img);
        $msg = '';
        if(!empty($img)){
        $image_parts = explode(";base64,", $img);
        $data1    = base64_decode($image_parts[1]);
        $file    =  UPLOAD_DIR . uniqid() . '.png';
        $success = file_put_contents($file, $data1);
      
        $image = substr($file,14);

        $insert_data['image']  = $image;
        if(empty($id))
        {
        $result = $this->Common_model->banners($insert_data);
        //echo $this->db->last_query();
        $msg = "banner insert successfully";
        }
        else
        {
          $result = $this->Common_model->update_banners($insert_data,$id);
        //  echo $this->db->last_query();
          $msg = "banner update successfully";
        }
        }
        else{
          if(!empty($id))
          {
           //*******Start code to change sequence added by Rahul */
        $res = $this->model->getAllwhere('banners',array('id'=>$id));
        $old_sequence=0;
        foreach($res as $value){
          $old_sequence = $value->sequence;
        }
        if($sequence != $old_sequence )
        {
          $query3 = "SELECT * FROM banners order by sequence";
         $query2 = $this->Common_model->sequence_update($query3);
          $query2 = $query2->result();
          $series =0;
          foreach($query2 as $val) 
          {
            if($val->id != $id)
            {
              $series = $series +1;
              if($sequence ==$series)
              $series = $series +1;
              $query ="UPDATE `banners` SET `sequence` = ".$series." WHERE id =".$val->id.""; 
              $res1= $this->Common_model->sequence_update($query);
            }
          } 
        }
        //*******End code to change sequence added by Rahul */
          $result = $this->Common_model->update_banners($insert_data,$id);
        
          $msg = "banners update successfully";
          }
        }
      
      $resp = array('rccode' => 200, 'message' => $msg);
        $this->response($resp);
      }


      //  public function banners_delete()
      //  {
      //   $id = $this->delete('id');
      //   $this->db->where('id', $id);
      //   $delete = $this->db->delete('banners');
      //   $msg = "Record deleted successfully ";  
      //  }

      // Category Api for insert,update nd delete. 
      public function category_post()
      {

        $pdata = file_get_contents("php://input");
        $data  = json_decode($pdata,true);
        
      if (isset($data['id']) )
      {
        
        $id = $data['id'];
        
      }
        $msg = "";
      
        
        $category_name          = $data['category_name'];
        $category_description   = $data['category_description'];
        $image                  = $data['category_image'];
        $sequence               = $data['sequence'];
        $status                 = $data['status'];

        if (!isset($data['id']) )
  {
    $query1 = "SELECT IFNULL(max(sequence),0) + 1 As maxSequence FROM `category`";
    $result  = $this->Common_model->sequence_update($query1);
    $result = $result->result();
    foreach( $result as $val)
    {
      $sequence = $val->maxSequence;
    }
  }
        
      $data = array(
            
            'category_name'             => $category_name,
            'category_description'      => $category_description,
            'sequence'                  => $sequence,
            'status'                    => $status,
            'created_at'                => date('Y-m-d H:i:s'),
            'created_by'                => $this->session->userdata('id')
        );
      
        
        
        define('UPLOAD_DIR', 'asset/uploads/');
        if(!empty($image)){

            $image_parts = explode(";base64,", $image);
            $data1   = base64_decode($image_parts[1]);
            $file    =  UPLOAD_DIR . uniqid() . '.png';
            $success = file_put_contents($file, $data1);
            
            $img = substr($file,14);
          // $this->resizeImage($img);
            $data['category_image'] = $img;
        
            if(empty($id))
            {
              $result = $this->Common_model->category($data);
              $msg = "category insert successfully";
        
            }
        else{
              $result = $this->Common_model->update_category($data,$id);
              //$this->response($data);
              $msg = "category update successfully";
            }
          }
          else{
            if(!empty($id))
            {
              //*******Start code to change sequence added by Rahul */
      $res = $this->model->getAllwhere('category',array('id'=>$id));
      $old_sequence=0;
      foreach($res as $value){
        $old_sequence = $value->sequence;
      }
      if($sequence != $old_sequence )
      {
        $query3 = "SELECT * FROM category order by sequence";
        $query2 = $this->Common_model->sequence_update($query3);
        $query2 = $query2->result();
        $series = 0;
        foreach($query2 as $val) 
        {
          if($val->id != $id)
          {
            $series = $series +1;
            if($sequence ==$series)
            $series = $series +1;
            $query ="UPDATE `category` SET `sequence` = ".$series." WHERE id =".$val->id.""; 
            $res1= $this->Common_model->sequence_update($query);
          }
        } 
      }
      //*******End code to change sequence added by Rahul */
            $result = $this->Common_model->update_category($data,$id);
            $msg = "category update successfully";
            }
          }
        
        $resp = array('rccode' => 200,'id'=>$result,'message' =>$msg);
        $this->response($resp);
        
      }

      // Subcategory Api for insert,update nd delete. 
      public function sub_category_post()
        {
          
          $msg = "";
          $pdata = file_get_contents("php://input");
          $data  = json_decode($pdata,true);
          if (isset($data['id']) )
      {
        
        $id = $data['id'];
        
      }
          $category_id    = $data['category_id'];
          $sub_cat_name   = $data['sub_cat_name'];
          $sub_cat_desc   = $data['sub_cat_desc'];
          $sequence       = $data['sequence'];
          $status         = $data['status'];
          $image          = $data['sub_cat_image'];

            if (!isset($data['id']) )
    {
      $query1 = "SELECT IFNULL(max(sequence),0) + 1 As maxSequence FROM `sub_category` WHERE category_id = $category_id";
      $result  = $this->Common_model->sequence_update($query1);
      $result = $result->result();
      foreach( $result as $val)
      {
        $sequence = $val->maxSequence;
      }
    }

          $data = array(
              'sub_cat_name'             => $sub_cat_name,
              'sub_cat_desc'             => $sub_cat_desc,
              'category_id'              => $category_id,
              'sequence'                 => $sequence,
              'status'                   => $status,
              'created_at'               => date('Y-m-d H:i:s'),
              'created_by'               => $this->session->userdata('id')
          );

          //print_r($data);
          define('UPLOAD_DIR', 'asset/uploads/');
          if(!empty($image)){
        
              $image_parts = explode(";base64,", $image);
              $data1   = base64_decode($image_parts[1]);
              $file    =  UPLOAD_DIR . uniqid() . '.png';
              $success = file_put_contents($file, $data1);
              
            $img = substr($file,14);
            // $this->resizeImage($img);
              $data['sub_cat_image'] = $img;
          if(empty($id))
              {
                $result = $this->Common_model->subcategory($data);
                $msg = "subcategory insert successfully";
              }
          else{
                $result = $this->Common_model->update_subcategory($data,$id);
                $msg = "subcategory update successfully";
              }
            
          }
          else{
            if(!empty($id))
            {
                 //*******Start code to change sequence added by Rahul */
        $res = $this->model->getAllwhere('sub_category',array('id'=>$id));
        $old_sequence=0;
        foreach($res as $value){
          $old_sequence = $value->sequence;
        }
        if($sequence != $old_sequence )
        {
          $query2 = $this->model->getAllwhere('sub_category',array('category_id'=>$category_id),'id,sequence','sequence','ASC');
          $series =0;
          foreach($query2 as $val) 
          {
            if($val->id != $id)
            {
              $series = $series +1;
              if($sequence ==$series)
              $series = $series +1;
              $query ="UPDATE `sub_category` SET `sequence` = ".$series." WHERE id =".$val->id.""; 
              $res1= $this->Common_model->sequence_update($query);
            }
          } 
        }
        //*******End code to change sequence added by Rahul */
            $result = $this->Common_model->update_subcategory($data,$id);
            $msg = "subcategory update successfully";
            }
          }
          $resp = array('rccode' => 200,'subcatergory_id'=>$result,'message' =>$msg);
          $this->response($resp);
            
      }




        // Product Api for insert,update nd delete. 
      public function product_post()
      {

        $msg = "";
        $pdata = file_get_contents("php://input");
        $data  = json_decode($pdata,true);
        if (isset($data['id']) )
      {
        
        $id = $data['id'];
        
      }
        // $category_id          = $data['category_id'];
        // $sub_cat_id           = $data['sub_cat_id'];
        // $product_name         = $data['product_name'];
        // $product_description  = $data['product_description'];
        // $sequence             = $data['sequence'];
        // $status               = $data['status'];
        // $image                = $data['product_image'];
        // $product_price        = $data['product_price'];
        // $stock                = $data['stock'];

        // $data = array(
        //     'product_name'             => $product_name,
        //     'product_description'      => $product_description,
        //     'category_id'              => $category_id,
        //     'sub_cat_id'               => $sub_cat_id,
        //     'sequence'                 => $sequence,
        //     'status'                   => $status,
        //     'product_price'            => $product_price,
        //     'stock'                   => $stock,
        //     'created_at'               => date('Y-m-d H:i:s'),
        //     'created_by'               => $this->session->userdata('id')
        // );
//start add product with sub category.
if (isset($data['sub_cat_id']))
{
  

 $category_id          = $data['category_id'];

 $sub_cat_id           = $data['sub_cat_id'];
 $product_name         = $data['product_name'];

 $product_description  = $data['product_description'];
 $sequence             = $data['sequence'];
 $status               = $data['status'];
 $image                = $data['product_image'];
 $product_price        = $data['product_price'];
 $stock                = $data['stock'];

 if (!isset($data['id']) )
 {
   $query1 = "SELECT IFNULL(max(sequence),0) + 1 As maxSequence FROM `product` WHERE category_id = $category_id and sub_cat_id = $sub_cat_id";
   $result  = $this->Common_model->sequence_update($query1);
   $result = $result->result();
   foreach( $result as $val)
   {
    $sequence = $val->maxSequence;
   }
 }

  $data = array(
     'product_name'             => $product_name,
     'product_description'      => $product_description,
     'category_id'              => $category_id,
     'sub_cat_id'               => $sub_cat_id,
     'sequence'                 => $sequence,
     'status'                   => $status,
     'product_price'            => $product_price,
      'stock'                   => $stock,
     'created_at'               => date('Y-m-d H:i:s'),
     'created_by'               => $this->session->userdata('id')
  );
}

 //end add product with sub category.

 // start add product without sub category.
else{

$category_id          = $data['category_id'];

// $sub_cat_id           = $data['sub_cat_id'];
 $product_name         = $data['product_name'];

 $product_description  = $data['product_description'];
 $sequence             = $data['sequence'];
 $status               = $data['status'];
 $image                = $data['product_image'];
 $product_price        = $data['product_price'];
 $stock                = $data['stock'];

  if (!isset($data['id']) )
 {
   $query1 = "SELECT IFNULL(max(sequence),0) + 1 As maxSequence FROM `product` WHERE category_id = $category_id";
   $result  = $this->Common_model->sequence_update($query1);
   $result = $result->result();
   foreach( $result as $val)
   {
     $sequence = $val->maxSequence;
   }
 }

  $data = array(
     'product_name'             => $product_name,
     'product_description'      => $product_description,
     'category_id'              => $category_id,
     //'sub_cat_id'               => $sub_cat_id,
     'sequence'                 => $sequence,
     'status'                   => $status,
     'product_price'            => $product_price,
      'stock'                   => $stock,
     'created_at'               => date('Y-m-d H:i:s'),
     'created_by'               => $this->session->userdata('id')
 );
 }
 // end add product without sub category.
      
        define('UPLOAD_DIR', 'asset/uploads/');
        define('UPLOAD_DIR1', 'asset/uploads/thumbnail/');
        if(!empty($image)){

            $image_parts = explode(";base64,", $image);
            $data1   = base64_decode($image_parts[1]);
            $file    =  UPLOAD_DIR . uniqid() . '.png';
            $file1   =  UPLOAD_DIR1 . uniqid() . '.png';
        
            $success = file_put_contents($file, $data1);
            $success = file_put_contents($file1, $data1);
            
            $img = substr($file,14);
          
            $product_image[]  = $img;
          
            $data['product_image'] = serialize($product_image);
        if(empty($id))
            {
              $result = $this->Common_model->product($data);
              $msg = "product insert successfully";
            }
        else{

              $result = $this->Common_model->update_product($data,$id);
              $msg = "product update successfully";
            }
          
        }
        else{
          if(!empty($id))
          {
               //*******Start code to change sequence added by Rahul */
        $res = $this->model->getAllwhere('product',array('id'=>$id));
        $old_sequence=0;
        foreach($res as $value){
          $old_sequence = $value->sequence;
        }
        if($sequence != $old_sequence )
        { 
          if(!empty($sub_cat_id))
          {
            $query2 = $this->model->getAllwhere('product',array('category_id'=>$category_id,'sub_cat_id'=>$sub_cat_id),'id,sequence','sequence','ASC');
          }
          else
          {
            $query2 = $this->model->getAllwhere('product',array('category_id'=>$category_id),'id,sequence','sequence','ASC');
          }
          $series =0;
          foreach($query2 as $val) 
          {
            if($val->id != $id)
            {
              $series = $series +1;
              if($sequence == $series)
              $series = $series +1;
              $query ="UPDATE `product` SET `sequence` = ".$series." WHERE id =".$val->id.""; 
             $res1= $this->Common_model->sequence_update($query);
            }
          } 
        }
        //*******End code to change sequence added by Rahul */
            $result = $this->Common_model->update_product($data,$id);
            $msg = "product update successfully";
          }
        }

            $resp = array('rccode' => 200,'id'=>$result,'message' =>$msg);
            $this->response($resp);
      }
// Insert multiple product image
public function image_upload_post()
 {
  
  $pdata = file_get_contents("php://input");
  $data  = json_decode($pdata,true);

  $required_parameter = array('product_id','product_image');
      $chk_error = $this->controller->check_required_value($required_parameter, $data);
        if ($chk_error) 
        {
             $resp = array('code' => 'MISSING_PARAM', 'message' => 'Missing ' . strtoupper($chk_error['param']));
             @$this->response($resp);
        }
    $product_id = $data['product_id'];
    //$image = $data['product_image'];
 
        $product_image  = array();    
        if(!empty($product_id)){
            $p_img  = $this->model->getAllwhere('product',array('id'=> $product_id),'product_image');
         
            if(!empty($p_img)){
                $product_image = @unserialize($p_img[0]->product_image);
            }
        }

  
 
 define('UPLOAD_DIR', 'asset/uploads/');
  $img     = $data['product_image'];   
  
 
// $img     = str_replace('data:image/jpeg;base64,', '', $img);
 //$img     = str_replace(' ', '+', $img);
 $msg = '';
 if(!empty($img)){
 $image_parts = explode(";base64,", $img);
 $data1    = base64_decode($image_parts[1]);
 $file    =  UPLOAD_DIR . uniqid() . '.png';
 $success = file_put_contents($file, $data1);

 $image = substr($file,14);

 $product_image[] = $image;
 //$data['product_image'] = serialize($image);
 $insert_data  = array('product_image' => serialize($product_image));
 
 }
$where = array('id'=> $product_id);
 $result = $this->model->updateFields('product', $insert_data, $where);
 $resp = array('rccode' => 200,'message' =>"image  upload succesfully");
 $this->response($resp);
}


      // insert product attributes
      public function product_attributes_post()
      {

      //   $pdata = file_get_contents("php://input");
      //   $data  = json_decode($pdata,true);

      //   // $id         = $data['product_id'];
        
      //   $attributes  = $data['attributes'];
        
      //     // $price       = $data['price'];
      //     //$sell_price  = $data['sell_price'];
      //     // if (!empty($attributes)) {
      //     //     for ($i = 0; $i < count($attributes); $i++) {
      //     //         $adata[$i]['product_id']         = $id;
      //     //         $adata[$i]['product_price']      = $price;
      //     //         $adata[$i]['sell_price']         = $sell_price;
      //     //         $adata[$i]['product_attributes'] = htmlspecialchars($attributes);
                
      //     //   }
      //     //  $where  = array(
      //     //           'product_id' => $id,
                    
      //     //       );

      //     $result = json_decode($attributes);
      //           $result = $this->model->insertBatch('product_attributes',$result);
      // //}
      // $resp = array('rccode' => 200,'message' =>"attributes insert succesfully");
      // $this->response($resp);
      $pdata = file_get_contents("php://input");
  $pdata = str_replace('"[','[',$pdata);
  $pdata = str_replace(']"',']',$pdata);
  $pdata = str_replace('\\','',$pdata);
  $data  = json_decode($pdata,true);
  $msg = "";
   $id         = $data['id'];
  //print_r($id );
  $attributes  = $data['attributes'];
  
  
  foreach($attributes as $key =>$value){
    $product_id = $value['product_id'];
    $this->db->where('product_id',$product_id);
    $delete = $this->db->delete('product_attributes');
  }
  
    // $result = $attributes;
    foreach($attributes as $key =>$value){
      $insert_data = array(
        'product_attributes'  => $value['product_attributes'],
        'product_id'          => $value['product_id'],
        'product_price'       => $value['product_price'],
        'sell_price'          => $value['sell_price']
     );
      
      $result = $this->model->insertData('product_attributes', $insert_data);
      $msg = "attributes insert succesfully" ;
    }



$resp = array('rccode' => 200,'message' =>$msg);
$this->response($resp);
      }

      // Vendor Api
      public function vender_request_get()
        {
          $result = $this->Common_model->vender();
          $resp = array('rccode' => 200,'message' =>"success");
          $this->response($resp);
        }

      public function vender_post()
        {
        
      $vender_id = $this->input->post('vender_id');
      
          $delete = $this->input->post('delete');
        
        if($delete ==1 && !empty($id))
        {
        
          $this->db->where('vender_id', $vender_id);
          $result = $this->db->delete('vender_permission');
          $msg = "Record deleted successfully ";  
        }
        //$item = $this->input->post('item');
        $data = array(

                "vender_id"   =>  $this->input->post('vender_id'),
                "description" =>  $this->input->post('description'),
                "is_view" => 0,
                "is_save" => 0,
                "is_edit" => 0,
                "is_delete" => 0

        );

          $result  = $this->Common_model->insert_vender($data);
          $resp = array('rccode' => 200,'message' =>"success");
          $this->response($resp);
      }

      //Get all customers api
      public function dashboard_get()
      {
      
          $where         = array(
              'user_role =' => 2
          );
          $data = $this->model->getAllwhere('users', $where);
      

          $resp = array('rccode' => 200,'message' =>"success",'customers'=>$data);
          $this->response($resp);
          
      }

      // change order status api
      public function change_order_status_post()
      {
        $pdata = file_get_contents("php://input");
        $data  = json_decode($pdata,true);
              $id     = $data['order_id'];
              $status = $data['status'];
              $user_id = $data['user_id'];
            // $this->response($user_id);
              $data   = array(
                  'status' => $status
              );
            
              $where  = array(
                  'id' => $id
              );
            $this->model->update('orders', $data, $where);
            $message  = "Your Order is $status";
            
              $resp = array('rccode' => 200,'message' => $message);
                  $this->response($resp);
            //}
          
          
      }

       // Get count in dashboard
public function count_post()
{
  $pdata = file_get_contents("php://input");
  $data  = json_decode($pdata,true);

  // if(isset($data['company_id']))
  // {
  //   $id = $data['company_id'];
  // }

  $totalCustomer  = $this->model->getcount('users', array(
    'user_role' => '2'));
    $todayOrders  = $this->model->getcount('orders', array(
      'DATE(created_at)' => date('Y-m-d')));
      $order_list =  $this->model->GetJoinRecord('orders', 'user_id', 'users', 'id', 'COUNT(orders.id) as total_orders',array('orders.id!='=>'0'));

      $totalOrders = !empty($order_list) ? $order_list[0]->total_orders : 0;
      $pending_order  = $this->model->getcount('orders',array('status='=>'placed'));
      $delivered_order  = $this->model->getcount('orders',array('status='=>'delivered'));
      $cancel_order  = $this->model->getcount('orders',array('status='=>'Cancel'));
      $processing_order  = $this->model->getcount('orders',array('status='=>'Progress'));
      $dispatch_order  = $this->model->getcount('orders',array('status='=>'Dispatched'));
            
      $resp = array(
        'rccode'          => 200,
        'message'         =>'success',
        'total_customer'  =>$totalCustomer,
        'today_order'     =>$todayOrders,
        'total_order'     => $totalOrders,
        'pending_order'   => $pending_order,
        'delivered'       =>$delivered_order,
        'Cancel'          => $cancel_order,
        'Packing'         => $processing_order,
        'shipping'       => $dispatch_order
      );
$this->response($resp);
}
      // For verified and not verified user status.
      public function verify_user_post()
      {
              $pdata = file_get_contents("php://input");
              $data  = json_decode($pdata,true);
              $id        = $data['id'];
            $status    = $data['status'];
              $data   = array(
                  'is_verified' => $status
              );
              $where  = array(
                  'id' => $id
              );
              $this->model->update('users', $data, $where);
          
          $resp = array('rccode' => 200,'message' =>'success');
          $this->response($resp);
      }

      // For delete user .
      public function user_delete_post()
      { 
        $pdata = file_get_contents("php://input");
        $data  = json_decode($pdata,true);
          
              $id    = $data['id'];
              $where = array(
                  'id' => $id
              );
              $this->model->delete('users', $where);
              $resp = array('rccode' => 200,'message' =>'success');
              $this->response($resp);
      }


      // post notification api.

public function notification_post()
{
 
  $pdata = file_get_contents("php://input");
  $data  = json_decode($pdata,true);
  $msg = "";
  if (isset($data['id']))
  {
    
   $id = $data['id'];
   
  }

  if(!empty($id))
   {
    $this->db->where('id', $id);
    $delete = $this->db->delete('notification');
    $msg = "Record deleted successfully ";  
   }
  $type      = $data['type'];
  //$company_id = $data['company_id'];
  $title     = $data['title'];
  $message   = $data['message'];

  $insert_data  = array(
      'type'       => $type,
      'title'      => $title,
      'message'    => $message,
      //'company_id' => $company_id,
      'created_at' => date('Y-m-d H:i:s')
  );
  
  define('UPLOAD_DIR', 'asset/uploads/');
  $img     = $data['image'];    
 
// $img     = str_replace('data:image/jpeg;base64,', '', $img);
 //$img     = str_replace(' ', '+', $img);
 
 if(!empty($img)){
 $image_parts = explode(";base64,", $img);
 $data1    = base64_decode($image_parts[1]);
 $file    =  UPLOAD_DIR . uniqid() . '.png';
 $success = file_put_contents($file, $data1);

 $image = substr($file,14);

 $insert_data['image']  = $image;

    $result = $this->model->insertData('notification', $insert_data);
   $msg     = "notification insert successfully";
  
}
  $resp = array('rccode' => 200,'message' =>$msg);
    $this->response($resp);


}

// get notification api
      public function get_notification_post()
{

  $pdata = file_get_contents("php://input");
  $data  = json_decode($pdata,true);
  if(isset($data['company_id'])){
  $id = $data['company_id'];
  
  $data['notification'] = $this->model->getAllwhere('notification', array('company_id'=>$id));
  }
  else{
    $data['notification'] = $this->model->getAllwhere('notification');
  }
  $resp = array('rccode' => 200,'message' =>$data);
    $this->response($resp);

}

// Theme color insert, update api.
public function app_theme_post()
{

  $pdata = file_get_contents("php://input");
  $data  = json_decode($pdata,true);

  $theme_color    =   $data['theme_color'];
  //$company_id     =  $data['company_id'];
  if(isset($id['id'])){
       $id        = $data['id'];      
  }
  $data = array(
      'theme_color'           => $theme_color,
      //'company_id'           =>  $company_id,
      'created_at'            => date('Y-m-d H:i:s')
  );

  if(!empty($id)){
   // $detail_id = $id[0]->id;
    $where = array(
        'id' => $id
    );
    unset($data['created_at']);
    $result = $this->model->updateFields('details', $data, $where);
    $msg = "theme color update successfully";
}else {
    $result = $this->model->insertData('details', $data);  
    $msg = "theme color insert successfully";  
}

$resp = array('rccode' => 200,'message' =>$msg);
$this->response($resp);
}

// Insert shipping rate api.
public function shipping_rate_post()
{
  $msg = "";
  $pdata = file_get_contents("php://input");
  $data  = json_decode($pdata,true);
  if (isset($data['id']))
  {
    
   $id = $data['id'];
   
  }
 
  if(!empty($id))
   {
    $this->db->where('id', $id);
    $delete = $this->db->delete('shipping_master');
    $msg = "Record deleted successfully";  
   }
   else{
  $from    = $data['from'];
  $to      = $data['to'];
  $rate    = $data['rate'];
//$company_id = $data['company_id'];

  $data  = array(
      'from'  => $from,
      'to'    => $to,
      'rate'  => $rate,
      //'company_id'=>$company_id,
      'created_at' => date('Y-m-d H:i:s')
  );
  
  if(!empty($data)){
      $result = $this->model->insertData('shipping_master', $data);
      $msg = "Data insert successfully ";
  }
$resp = array('rccode' => 200,'message' =>$msg);
$this->response($resp);
}
}

// Get shipping rate api
public function get_shipping_list_post()
{
  $pdata = file_get_contents("php://input");
  $postdata  = json_decode($pdata,true);

  if (isset($postdata['company_id']))
  {
    
    $id = $postdata['company_id'];
    $data['shipping_rates'] = $this->model->getAllwhere('shipping_master',array('company_id'=>$id));
  }else{
    $data['shipping_rates'] = $this->model->getAllwhere('shipping_master');
  }

 
  $resp = array('rccode' => 200,'message' =>$data);
  $this->response($resp);
}

// login setting api.
public function login_setting_post()
{


  $pdata = file_get_contents("php://input");
  $data  = json_decode($pdata,true);

  $login_type   = $data['login_type'];
  //$company_id =  $data['company_id'];
  if($login_type ==1){
      $setting_name = 'Home Page';
  }else if($login_type==2){
       $setting_name = 'Login With Skip';
   }else if($login_type==3){
       $setting_name = 'Login';
  }else if($login_type==4){
       $setting_name = 'Login With Verify User Only';
  }
  $data = array(
      'login_type'        => $login_type,
      'setting_name'      => $setting_name,
      //'company_id'        => $company_id,
      'created_at'        => date('Y-m-d H:i:s')
  );

 
  // if(!empty($id)){
  //    // $login_settings_id = $id[0]->id;
  //     $where = array(
  //         'id' => $login_settings_id
  //     );
  //     unset($data['created_at']);
  //     $result = $this->model->updateFields('login_settings', $data, $where);
  // }else {
      $id = $this->model->insertData('login_settings', $data);    
  //}
  $resp = array('rccode' => 200,'message' =>"Data insert successfully");
  $this->response($resp);

}

// Insert and update wallet api.
public function wallet_detail_post()
{
  $msg="";
  $pdata = file_get_contents("php://input");
  $data  = json_decode($pdata,true);

   

  if (isset($data['id']))
  {
    
   $id = $data['id'];
   
  }

  $delete = $data['delete'];
 
  if(!empty($id) && $delete == 1)
   {
    $this->db->where('id', $id);
    $delete = $this->db->delete('wallet_details');
    $msg = "Record deleted successfully ";  
   }
  $wallet_type   = $data['wallet_type'];
  $status        = !empty($data['status']) ? $data['status'] : 0;
  $valid_from    = $data['valid_from'];
  $valid_to      = $data['valid_to'];
  $amount        = $data['amount'];
 
  $redeem_per    = $data['redeem_per'];
 
  $valid_upto    = $data['valid_upto'];
 // $company_id    = $data['company_id'];
  $data = array(
      'wallet_type'   => $wallet_type,
      'status'        => $status,
      'valid_from'    => $valid_from,
      'valid_to'      => $valid_to,
      'amount'        => $amount,
      'redeem_per'    => $redeem_per,
      'valid_upto'    => $valid_upto,
      //'company_id'    => $company_id,
      'created_at'    => date('Y-m-d H:i:s')
  );
 
  // $id = $this->model->getAllwhere('app_version_history','','id');
  if (!empty($id)) {
      $where = array(
          'id' => $id
      );
      unset($data['created_at']);
     
      $result = $this->model->updateFields('wallet_details', $data, $where);
      $msg="Wallet update successfully";
  } else {
      $result = $this->model->insertData('wallet_details', $data);
      $msg="Wallet insert successfully";
  }
  $resp = array('rccode' => 200,'message' =>$msg);
  $this->response($resp);
}

// Get wallet details api
public function get_wallet_list_post()
{

  $pdata = file_get_contents("php://input");
  $postdata  = json_decode($pdata,true);

  if (isset($postdata['company_id']))
  {
    
    $id = $postdata['company_id'];
    $data = $this->model->getAllwhere('wallet_details',array('company_id'=> $id));
  }else{
    $data = $this->model->getAllwhere('wallet_details');
  }

 

  $resp = array('rccode' => 200,'message' =>"success",'wallet_details'=>$data);
  $this->response($resp);
}

// Api for Enable / disable setting.
public function setting_master_post()
{

  $pdata = file_get_contents("php://input");
  $data  = json_decode($pdata,true);

  $cash_on_delivery      = !empty($data['cash_on_delivery']) ? $data['cash_on_delivery'] : 0;
  $self_pickup           = !empty($data['self_pickup']) ? $data['self_pickup'] : 0;
  $home_delivery         = !empty($data['home_delivery']) ? $data['home_delivery'] : 0;
  $product_view          = !empty($data['product_view']) ? $data['product_view'] : 'list';

  $wallet_with_discount  = !empty($data['wallet_with_discount']) ? $data['wallet_with_discount'] : 0;
  
 $cash_on_delivery_name  = !empty($data['cash_on_delivery_name']) ? $data['cash_on_delivery_name'] : 'cash_on_delivery';
  $self_pickup_name      = !empty($data['self_pickup_name']) ? $data['self_pickup_name'] : 'self_pickup';
  $home_delivery_name    = !empty($data['home_delivery_name']) ? $data['home_delivery_name'] : 'home_delivery_name';
  $product_view_name     = 'product_view';
  $wallet_with_discount_name = 'wallet_with_discount';
  //$company_id            = $data['company_id'];
 
  $settings  = array(
      'cash_on_delivery',
      'self_pickup',
      'home_delivery','product_view',
      'wallet_with_discount'
    );
 
      $insert_data  = array();
  foreach ($settings as $key => $value) {
      $check_key  = $this->model->getAllwhere('settings_masters',array('name'=>$value));
    //print_r($check_key);
      //if(!empty($check_key)){
          $data_value  = $$value;
         
          $name        = $value.'_name';
        
          $f_name      = $$name;
          
          $update_data  = array('value'=> $data_value,'user_defined_name'=>$f_name);
        
          $update_where = array('name'=> $value);
      
       // }
    $this->model->updateFields('settings_masters', $update_data, $update_where);
  }
  $resp = array('rccode' => 200,'message' =>"success");
  $this->response($resp);
}

// Get setting master api.
public function get_setting_master_post()
{
  $pdata = file_get_contents("php://input");
  $postdata  = json_decode($pdata,true);
 if(isset( $postdata['company_id']))
 {

  $id =  $postdata['company_id'];
  $data  = $this->model->getAllwhere('settings_masters',array('company_id'=>$id));
 }else{
  $data  = $this->model->getAllwhere('settings_masters');
 }
  
  //print_r( $data);
  $resp = array('rccode' => 200,'message' =>"success","data"=>$data);
  $this->response($resp);
}

// Delivery_range api.
public function delivery_range_post()
{

  $pdata = file_get_contents("php://input");
  $data  = json_decode($pdata,true);

  $delivery_range      = !empty($data['delivery_range_checkbox']) ? $data['delivery_range_checkbox']: $data['delivery_range_text'] ;
                
      $check_key      = $this->model->getAllwhere('settings_masters',array('name'=>'delivery_range'));
      if(!empty($check_key)){
          $update_data  = array('value'=> $delivery_range);
          $update_where = array('name'=> 'delivery_range');
          $this->model->updateFields('settings_masters', $update_data, $update_where);
                   
          $resp = array('rccode' => 200,'message' =>"success");
          $this->response($resp);

}
}

//Insert,update, and status Discount coupon api.

public function discount_coupon_post()
{
  $pdata = file_get_contents("php://input");
  $data  = json_decode($pdata,true);
  $msg="";
if (isset($data['id']))
  {
    
   $id = $data['id'];
   
  }

  $delete = $data['delete'];
 
  if(!empty($id) && $delete == 1)
   {
    $this->db->where('id', $id);
    $delete = $this->db->delete('discount_coupon');
    $msg = "Record deleted successfully ";  
   }
  
  $coupon_code            = $data['coupon_code'];
  $status                 = !empty($data['status']) ? $data['status'] : 0;
  $start_date             = $data['start_date'];
  $end_date               = $data['end_date'];
  $discount_amt           = $data['discount_amt'];
  $discount_per           = $data['discount_per'];
 
  $created_by             = $data['company_id'];
  
  $min_amount             = $data['min_amount'];
  $coupon_redeemed_no     = $data['coupon_redeemed_no'];
  $per_check              = !empty($data['per_check']) ? true : false ;

  $per_min_amount         = !empty($data['per_min_amount']) ? $data['per_min_amount'] : 0 ;
  //$company_id             = $data['company_id'];

  $data = array(
      //'company_id'        => $company_id,
      'coupon_code'       => $coupon_code,
      'status'            => $status,
      'start_date'        => $start_date,
      'end_date'          => $end_date,
      'discount_amt'      => $discount_amt,
      'discount_per'      => $discount_per,
      'created_by'        => $created_by,
      'min_amount'        => $min_amount,
      'per_check'         => $per_check,
      'per_min_amount'    => $per_min_amount,
      'coupon_redeemed_no'=> $coupon_redeemed_no, 
      'created_at'        => date('Y-m-d H:i:s')
  );
 // print_r($data);
  // $id = $this->model->getAllwhere('app_version_history','','id');
  if (!empty($id)) {
      $where = array(
          'id' => $id
      );
      unset($data['created_at']);
      unset($data['created_by']);
     
      $result = $this->model->updateFields('discount_coupon', $data, $where);
      $msg = "discount coupon update successfully";
  } else {
     $result = $this->model->insertData('discount_coupon', $data);
      $msg = "discount coupon insert successfully";
  }

  $resp = array('rccode' => 200,'message' =>$msg);
  $this->response($resp);
}

// Get discount_coupon_list api.
public function get_discount_coupon_list_post()
{
  $pdata = file_get_contents("php://input");
  $postdata  = json_decode($pdata,true);

  if (isset($postdata['company_id']))
  {
    
    $id = $postdata['company_id'];
    $data  = $this->model->getAllwhere('discount_coupon',array('company_id'=>$id));
  }else{
    $data  = $this->model->getAllwhere('discount_coupon');
  }


  $resp = array('rccode' => 200,'message' =>"success","discount_coupon_list"=> $data);
  $this->response($resp);
}



// Update company detail api.
public function details_post()
{

  $pdata = file_get_contents("php://input");
  $data  = json_decode($pdata,true);
  $msg = "";
    if(isset($data['id']))
    {
      $id = $data['id'];
    }
   $company_name   = $data['company_name'];
   $lat            = $data['lat'];
   $long           = $data['long'];
   $gst_no         = $data['gst_no'];
   $punch_line     = $data['punch_line'];
   //$company_id     = $data['company_id'];

   $insert_data = array(
       'company_name'          => $company_name,
       'lat'                   => $lat,
       'long'                  => $long,
       'gst_no'                => $gst_no,
       'punch_line'            => $punch_line,
       //'company_id'            => $company_id,
       'created_at'            => date('Y-m-d H:i:s')
   );


   define('UPLOAD_DIR', 'asset/uploads/');
  $img     = $data['logo'];    
 
// $img     = str_replace('data:image/jpeg;base64,', '', $img);
 //$img     = str_replace(' ', '+', $img);
 
 if(!empty($img)){
 $image_parts = explode(";base64,", $img);
 $data1    = base64_decode($image_parts[1]);
 $file    =  UPLOAD_DIR . uniqid() . '.png';
 $success = file_put_contents($file, $data1);

 $image = substr($file,14);

 $insert_data['logo']  = $image;

 //  $id = $this->model->getAllwhere('details','','id');
   if(!empty($id)){
      // $detail_id = $id[0]->id;
       $where = array(
           'id' => $id
       );
       unset($data['created_at']);
       $result = $this->model->updateFields('details', $insert_data, $where);
       $msg = "Detail update successfully";
       }

       else{
         if(empty($img) || !empty($img)){
       $result = $this->model->insertData('details', $insert_data);
       $msg = "Detail insert successfully";
         }
       }
      }
   else{
    if(!empty($id)){
      // $detail_id = $id[0]->id;
       $where = array(
           'id' => $id
       );
       unset($data['created_at']);
       $result = $this->model->updateFields('details', $insert_data, $where);
       $msg = "Detail update successfully";
       }
      }

$resp = array('rccode' => 200,'message' =>$msg);
$this->response($resp);
}

// Get company profile api .
public function get_details_post()
{
  $where = array('id'=>1);
  //$where1 = array('status'=>1,'company_id'=>$id);
  $data = $this->model->getAllwhere('details',$where,',id,company_name,theme_color,lat,long,gst_no,punch_line,logo,CONCAT("'.base_url().'","asset/uploads/",logo)AS logo,CONCAT("'.base_url().'","asset/uploads/",logo)AS logo','ASC');
 //print_r($data);
  $resp = array('rccode' => 200,'message' =>"success", 'detials'=>$data);
  $this->response($resp);
}

// Update all profile api .-Rahul mishra.
public function profile_post()
{
  $pdata = file_get_contents("php://input");
  $data  = json_decode($pdata,true);
 $msg = "";
if(isset($data['id']))
{
  $id = $data['id'];
}
  $menu_type   = $data['menu_type'];
  $description = $data['description'];
  //$company_id =  $data['company_id'];

  
  
  if($menu_type == 1){
 
    $data = array(
      'about'             => $description,
      //'company_id'        =>  $company_id,
      'created_at'        => date('Y-m-d H:i:s')
    );
    
    if (!empty($id)) {
      $where = array(
          'id' => $id
      );
  
      unset($data['created_at']);
    $result = $this->model->updateFields('about', $data, $where);
    $msg = "Record update successfully";
    }else{
    $result = $this->model->insertData('about', $data);
    $msg = "Record insert successfully";
    }
}else if($menu_type==2){
 
  $data = array(
    'privacy_policy'    => $description,
    //'company_id'        =>  $company_id,
    'created_at'        => date('Y-m-d H:i:s')
  );
 
  if (!empty($id)) {
    $where = array(
        'id' => $id
    );
    unset($data['created_at']);
  $result = $this->model->updateFields('privacy_policy', $data, $where);
  $msg = "Record update successfully";
  }else{
  $result = $this->model->insertData('privacy_policy', $data);
    $msg = "Record insert successfully";
  }
 }else if($menu_type==3){

  $data = array(
    'terms_conditions'  =>  $description,
    //'company_id'        =>  $company_id,
    'created_at'        => date('Y-m-d H:i:s')
  );
 
  if (!empty($id)) {
    $where = array(
        'id' => $id
    );
    unset($data['created_at']);
  $result = $this->model->updateFields('terms_conditions', $data, $where);
  $msg = "Record update successfully";
  }else{
  $result = $this->model->insertData('terms_conditions', $data);
  $msg = "Record insert successfully";
  }
}else if($menu_type==4){

  $data = array(
    'refund_policy'     =>  $description,
    //'company_id'        =>  $company_id,
    'created_at'        => date('Y-m-d H:i:s')
  );
 
  if (!empty($id)) {
    $where = array(
        'id' => $id
    );
    unset($data['created_at']);
  $result = $this->model->updateFields('refund_policy', $data, $where);
  $msg = "Record update successfully";
  }else{
  $result = $this->model->insertData('refund_policy', $data);
  $msg = "Record insert successfully";
  }
}
else if($menu_type==5){
 
  $data = array(
    'payment_options'   =>  $description,
   // 'company_id'        =>  $company_id,
    'created_at'        => date('Y-m-d H:i:s')
  );
 
  if (!empty($id)) {
    $where = array(
        'id' => $id
    );
    unset($data['created_at']);
  $result = $this->model->updateFields('payment_options', $data, $where);
  $msg = "Record update successfully";
  }else{
  $result = $this->model->insertData('payment_options', $data);
  $msg = "Record insert successfully";
  }
}
else if($menu_type==6){

  $data = array(
    'contact_us'        =>  $description,
    //'company_id'        =>  $company_id,
    'created_at'        => date('Y-m-d H:i:s')
  );
 
  if (!empty($id)) {
    $where = array(
        'id' => $id
    );
    unset($data['created_at']);
  $result = $this->model->updateFields('contact_us', $data, $where);
  $msg = "Record update successfully";
  }else{
  $result = $this->model->insertData('contact_us', $data);
  $msg = "Record insert successfully";
  }
}

$resp = array('rccode' => 200,'message' =>$msg);
$this->response($resp);

}


// Get all profile data api.
public function get_profile_post()
{
  $pdata = file_get_contents("php://input");
  $postdata  = json_decode($pdata,true);
  // if(isset($postdata['company_id']))
  // {
  //   $id = $postdata['company_id'];
  // }
  $menu_type   = $postdata['menu_type'];


  if($menu_type==1){

    $data = $this->Common_model->profile('about');
    $resp = array('rccode' => 200,'message' =>"success",'about'=>$data);
    $this->response($resp);
    }
 elseif($menu_type==2){

  $data = $this->Common_model->profile('privacy_policy');
  $resp = array('rccode' => 200,'message' =>"success",'about'=>$data);
  $this->response($resp);
  }
 elseif($menu_type==3){

  $data = $this->Common_model->profile('terms_conditions');
    $resp = array('rccode' => 200,'message' =>"success",'about'=>$data);
    $this->response($resp);
    }
  elseif($menu_type==4){

    $data = $this->Common_model->profile('refund_policy');
    $resp = array('rccode' => 200,'message' =>"success",'about'=>$data);
    $this->response($resp);
      }
  elseif($menu_type==5){

      $data = $this->Common_model->profile('payment_options');
      $resp = array('rccode' => 200,'message' =>"success",'about'=>$data);
      $this->response($resp);
        }
  elseif($menu_type==6){

      $data = $this->Common_model->profile('contact_us');
      $resp = array('rccode' => 200,'message' =>"success",'about'=>$data);
      $this->response($resp);
      }
  }
// get delivery range api..
  public function get_delivery_range_post()
{
  $data  = $this->model->getAllwhere('settings_masters',array('name'=>'delivery_range'));
  $resp = array('rccode' => 200,'message' =>"success", 'delivery_range'=>$data);
  $this->response($resp);
}


// api for new login
public function newlogin_post()
{ 
  error_reporting(0);

        $pdata     = file_get_contents("php://input");
        $postdata  = json_decode($pdata,true);
      
        $number = $postdata['phone_no'];
        $email  = $postdata['email'];
        //$name   = $postdata['name'];
        $device_token = $postdata['device_token'];
        define('UPLOAD_DIR', 'asset/uploads/');

        $img     = isset($postdata['image']) ? $postdata['image'] : '';    

        if(!empty($img)){
        $image_parts = explode("base64,", $img);
        $data1    = base64_decode($image_parts[1]);
        $file     = UPLOAD_DIR . uniqid() . '.png';
        $success  = file_put_contents($file, $data1);
      
        $image = substr($file,14);
        }
        $data   = array(
          'phone_no'=>$number,
          'app_folder'=>'logincommon',
          'device_token'=>$device_token,
          'expire_days'=>14,
          'check_expiry'=>1,
          'step'=>1,
          'user_role'=>3
      );
      $data1 = array(
        'email'=> $email,
        'app_folder'=>'logincommon',
        //'username'=>$name,
        'device_token'=>$device_token,
        'expire_days'=>14,
        'check_expiry'=>1,
        'step'=>1,
        'user_role'=>3

      );

      if(!empty($image)){
        $data['profile_pic']  = $image;
      }

     
      $check_number = $this->Common_model->get_data($number);
        $id = $check_number[0]->id;

      if(!empty($check_number)){
        $this->send_otp3($number,$id);
       
     
       }
      $where2             = array(
        'email'       => $email,
        'user_role'      => 3
        //'is_active'  => 0
          );
      $check_name = $this->model->getAllwhere('company_master',$where2,'unique_id,id,username as name,email,CONCAT("'.base_url().'","asset/uploads/",profile_pic)AS image,is_active,is_verified,phone_no,user_role,app_folder,created_at,expire_days,check_expiry,step');

     $step = $check_name[0]->step;
      if(!empty($check_name)){
        $resp = array('rccode' => 1,'message' => 'login success','vendor' =>$check_name[0],'is_active'=>  $check_name[0]->is_active,'is_verified'=> $check_name[0]->is_verified,'user_role'=> $check_name[0]->user_role);
      
        $this->response($resp); 
     
       }
      if(!empty($number)){
        $id = $this->model->insertData('company_master', $data);
        $this->send_otp2($number,$id);
      }
      else
      {
        $id = $this->model->insertData('company_master', $data1);
        $where3 = array(
          'id'=>$id
        );
        $res =  $this->model->getAllwhere('company_master',$where3,'unique_id,id,username as name,email,CONCAT("'.base_url().'","asset/uploads/",profile_pic)AS image,is_active,is_verified,phone_no,user_role,app_folder,created_at,expire_days,check_expiry,step');
        $resp = array('rccode' =>1,'message' => 'login success','vendor' => $res[0],'is_active'=>   $res[0]->is_active,'is_verified'=>  $res[0]->is_verified,'user_role'=>  $res[0]->user_role);
      }

      $this->response($resp); 
        $where           = array(
              'id'        =>$id,
              'is_active' => 0
                );

       
    }
    
 // api for select business name and type.
    public function  b_type_post()
    {
      $pdata     = file_get_contents("php://input");
      $postdata  = json_decode($pdata,true);
      $b_name    = $postdata['b_name'];
      $b_type    = $postdata['b_type'];
           $id   = $postdata['id'];
      $where2             = array(
        'id'           =>$id,
        'business_type' => $b_type, 
        'user_role'      => 3
        //'is_active'  => 0
          );
      $check_name = $this->model->getAllwhere('company_master',$where2);
      if(!empty($check_name)){
        // $step = $check_name[0]->step;
         $resp = array('rccode' => 1,'message' => 'login success','data'=>$check_name);
      
        $this->response($resp); 
     
      }

       $data = array(
         'business_type'=>$b_type,
         'business_name'=>$b_name,
         'step'=>2
       );
       $where = array(
         'id'=>$id
       );
     
        $this->model->updateFields('company_master',$data,$where);
        $where3  = array(
          'type' => $b_type,
          //'user_role'      => 3
          //'is_active'  => 0
            );
           
      $check_step = $this->model->getAllwhere('company_master',$where3);
     // print_r($check_step);
      $step =  $check_step[0]->step;
       $resp = array('rccode' => 2,'step'=> $step,'message' => 'login success','data'=>$check_step);
       $this->response($resp); 


    }


    public function send_otp2($phone_no,$id,$email = NULL){
      $mobileNumber = '91'.$phone_no;
          //$mobileNumber = '919699996116';
          //Sender ID,While using route4 sender id should be 6 characters long.
          $data = $this->model->getAllwhere('sms_settings',array('type'=>'OTP'));

          $senderId = !empty($data[0]->sender_id)? $data[0]->sender_id:"YOAPPS";
          //Your message to send, Add URL encoding here.
          $otp    = mt_rand(1000,9999);
          $details =    $this->model->getAllwhere('details','');
          $message  = !empty($details[0]->company_name)? "Dear Customer, to confirm your mobile number for ".$details[0]->company_name." Application, please enter the verification code ".$otp." in your online application form." :"Dear Customer, to confirm your mobile number for YoApp Application, please enter the verification code ".$otp." in your online application form.";
          $message  = urlencode("$message");
          $AuthKey  = !empty($data[0]->auth_key)? $data[0]->auth_key :'d55cf7975e584389cf6283ad562be';

          $url  = !empty($data[0]->url) ? $data[0]->url: 'sms.isoftzone.com';
          
          //API URL
          $url="http://$url/rest/services/sendSMS/sendGroupSms?AUTH_KEY=$AuthKey&message=$message&senderId=$senderId&routeId=1&mobileNos=$mobileNumber&smsContentType=english";
          
          // init the resource
          $ch = curl_init();
          curl_setopt_array($ch, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_POST => false,
          //CURLOPT_POSTFIELDS => $postData
          //,CURLOPT_FOLLOWLOCATION => true
          ));
          //Ignore SSL certificate verification
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
          //get response
          $output = curl_exec($ch);
          //Print error if any
          if(curl_errno($ch))
          {
          echo 'error:' . curl_error($ch);
          }
          curl_close($ch);
          

          // ===================================
          $logo  = !empty($details[0]->logo) ? 'http://yoappstore.com/login/asset/uploads/thumbnail/'.$details[0]->logo :'';
          $email_template  = '<!DOCTYPE html PUBLIC "
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
      <!--[if !mso]><!-->
      <meta http-equiv="X-UA-Compatible" content="IE=Edge">
      <!--<![endif]-->
      <!--[if (gte mso 9)|(IE)]>
      <xml>
        <o:OfficeDocumentSettings>
          <o:AllowPNG/>
          <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
      </xml>
      <![endif]-->
      <!--[if (gte mso 9)|(IE)]>
  <style type="text/css">
    body {width: 600px;margin: 0 auto;}
    table {border-collapse: collapse;}
    table, td {mso-table-lspace: 0pt;mso-table-rspace: 0pt;}
    img {-ms-interpolation-mode: bicubic;}
  </style>
<![endif]-->
      <style type="text/css">
    body, p, div {
      font-family: inherit;
      font-size: 14px;
    }
    body {
      color: #000000;
    }
    body a {
      color: #000000;
      text-decoration: none;
    }
    p { margin: 0; padding: 0; }
    table.wrapper {
      width:100% !important;
      table-layout: fixed;
      -webkit-font-smoothing: antialiased;
      -webkit-text-size-adjust: 100%;
      -moz-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
    }
    img.max-width {
      max-width: 100% !important;
    }
    .column.of-2 {
      width: 50%;
    }
    .column.of-3 {
      width: 33.333%;
    }
    .column.of-4 {
      width: 25%;
    }
    @media screen and (max-width:480px) {
      .preheader .rightColumnContent,
      .footer .rightColumnContent {
        text-align: left !important;
      }
      .preheader .rightColumnContent div,
      .preheader .rightColumnContent span,
      .footer .rightColumnContent div,
      .footer .rightColumnContent span {
        text-align: left !important;
      }
      .preheader .rightColumnContent,
      .preheader .leftColumnContent {
        font-size: 80% !important;
        padding: 5px 0;
      }
      table.wrapper-mobile {
        width: 100% !important;
        table-layout: fixed;
      }
      img.max-width {
        height: auto !important;
        max-width: 100% !important;
      }
      a.bulletproof-button {
        display: block !important;
        width: auto !important;
        font-size: 80%;
        padding-left: 0 !important;
        padding-right: 0 !important;
      }
      .columns {
        width: 100% !important;
      }
      .column {
        display: block !important;
        width: 100% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
      }
    }
  </style>
      <!--user entered Head Start--><link href="https://fonts.googleapis.com/css?family=Viga&display=swap" rel="stylesheet"><style>
    body {font-family: "Viga", sans-serif;}
</style><!--End Head user entered-->
    </head>
    <body>
      <center class="wrapper" data-link-color="#000000" data-body-style="font-size:14px; font-family:inherit; color:#000000; background-color:#FFFFFF;">
        <div class="webkit">
          <table cellpadding="0" cellspacing="0" border="0" width="100%" class="wrapper" bgcolor="#FFFFFF">
            <tbody><tr>
              <td valign="top" bgcolor="#FFFFFF" width="100%">
                <table width="100%" role="content-container" class="outer" align="center" cellpadding="0" cellspacing="0" border="0">
                  <tbody><tr>
                    <td width="100%">
                      <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tbody><tr>
                          <td>
                            <!--[if mso]>
    <center>
    <table><tr><td width="600">
  <![endif]-->
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width:100%; max-width:600px;" align="center">
                                      <tbody><tr>
                                        <td role="modules-container" style="padding:0px 0px 0px 0px; color:#000000; text-align:left;" bgcolor="#FFFFFF" width="100%" align="left"><table class="module preheader preheader-hide" role="module" data-type="preheader" border="0" cellpadding="0" cellspacing="0" width="100%" style="display: none !important; mso-hide: all; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0;">
    <tbody><tr>
      <td role="module-content">
        <p></p>
      </td>
    </tr>
  </tbody></table><table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" role="module" data-type="columns" style="padding:0px 0px 0px 0px;" bgcolor="#dde6de">
    <tbody>
      <tr role="module-content">
        <td height="100%" valign="top">
          <table class="column" width="580" style="width:580px; border-spacing:0; border-collapse:collapse; margin:0px 10px 0px 10px;" cellpadding="0" cellspacing="0" align="left" border="0" bgcolor="">
            <tbody>
              <tr>
                <td style="padding:0px;margin:0px;border-spacing:0;"><table class="module" role="module" data-type="spacer" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="10cc50ce-3fd3-4f37-899b-a52a7ad0ccce">
    <tbody>
      <tr>
        <td style="padding:0px 0px 40px 0px;" role="module-content" bgcolor="">
        </td>
      </tr>
    </tbody>
  </table><table class="wrapper" role="module" data-type="image" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="f8665f9c-039e-4b86-a34d-9f6d5d439327">
    <tbody>
      <tr>
        <td style="font-size:6px; line-height:10px; padding:0px 0px 0px 0px;" valign="top" align="center">
          <img class="max-width" border="0" style="display:block; color:#000000; text-decoration:none; font-family:Helvetica, arial, sans-serif; font-size:16px;" width="130" alt="" data-proportionally-constrained="true" data-responsive="false" src="'.$logo.'" height="33">
        </td>
      </tr>
    </tbody>
  </table><table class="module" role="module" data-type="spacer" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="10cc50ce-3fd3-4f37-899b-a52a7ad0ccce.1">
    <tbody>
      <tr>
        <td style="padding:0px 0px 30px 0px;" role="module-content" bgcolor="">
        </td>
      </tr>
    </tbody>
  </table></td>
              </tr>
            </tbody>
          </table>
          
        </td>
      </tr>
    </tbody>
  </table><table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="bff8ffa1-41a9-4aab-a2ea-52ac3767c6f4">
    <tbody>
      <tr>
        <td style="padding:18px 30px 18px 30px; line-height:40px; text-align:inherit; background-color:#dde6de;" height="100%" valign="top" bgcolor="#dde6de" role="module-content"><div><div style="font-family: inherit; text-align: center"><span style="color: #6fab81; font-size: 40px; font-family: inherit">Thank you for downloading the app! Now what?</span></div><div></div></div></td>
      </tr>
    </tbody>
  </table><table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="2f94ef24-a0d9-4e6f-be94-d2d1257946b0">
    <tbody>
      <tr>
        <td style="padding:18px 50px 18px 50px; line-height:22px; text-align:inherit; background-color:#dde6de;" height="100%" valign="top" bgcolor="#dde6de" role="module-content"><div><div style="font-family: inherit; text-align: center"><span style="font-size: 16px; font-family: inherit">Confirm your Registation By Below OTP.&nbsp;</span></div><div></div></div></td>
      </tr>
    </tbody>
  </table><table border="0" cellpadding="0" cellspacing="0" class="module" data-role="module-button" data-type="button" role="module" style="table-layout:fixed;" width="100%" data-muid="c7bd4768-c1ab-4c64-ba24-75a9fd6daed8">
      <tbody>
        <tr>
          <td align="center" bgcolor="#dde6de" class="outer-td" style="padding:10px 0px 20px 0px;">
            <table border="0" cellpadding="0" cellspacing="0" class="wrapper-mobile" style="text-align:center;">
              <tbody>
                <tr>
                <td align="center" bgcolor="#eac96c" class="inner-td" style="border-radius:6px; font-size:16px; text-align:center; background-color:inherit;">
                  <a href="#" style="background-color:#eac96c; border:0px solid #333333; border-color:#333333; border-radius:0px; border-width:0px; color:#000000; display:inline-block; font-size:16px; font-weight:normal; letter-spacing:0px; line-height:normal; padding:20px 30px 20px 30px; text-align:center; text-decoration:none; border-style:solid; font-family:inherit;" >'.$otp.'</a>
                </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table><table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" role="module" data-type="columns" style="padding:30px 0px 0px 0px;" bgcolor="#dde6de">
    <tbody>
      <tr role="module-content">
        <td height="100%" valign="top">
          <table class="column" width="600" style="width:600px; border-spacing:0; border-collapse:collapse; margin:0px 0px 0px 0px;" cellpadding="0" cellspacing="0" align="left" border="0" bgcolor="">
            <tbody>
              <tr>
                <td style="padding:0px;margin:0px;border-spacing:0;"><table class="wrapper" role="module" data-type="image" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="ce6dd3be-5ed4-42d2-b304-55a58022cdf0">
    <tbody>
      <tr>
        <td style="font-size:6px; line-height:10px; padding:0px 0px 0px 0px;" valign="top" align="center">
          <img class="max-width" border="0" style="display:block; color:#000000; text-decoration:none; font-family:Helvetica, arial, sans-serif; font-size:16px; max-width:100% !important; width:100%; height:auto !important;" width="600" alt="" data-proportionally-constrained="true" data-responsive="true" src="http://cdn.mcauto-images-production.sendgrid.net/954c252fedab403f/a8915cf9-9083-4c7b-bf41-dfbe1bdec0f7/600x539.png">
        </td>
      </tr>
    </tbody>
  </table></td>
              </tr>
            </tbody>
          </table>
          
        </td>
      </tr>
    </tbody>
  </table></div></center></body></html>';


           if(!empty($email)){
              $to_visitor  = $email;
              $subject_visitor = 'OTP VERIFICATION';

              $headers = "From: " . strip_tags('info@isoftzone.com') . "\r\n";
              $headers .= "Reply-To: ". strip_tags('info@isoftzone.com') . "\r\n";
              $headers .= "CC: gorav.badlani@gmail.com\r\n";
              $headers .= "MIME-Version: 1.0\r\n";
              $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
              $to  = 'gorav.badlani@gmail.com';
              //mail($to, $subject, $email_template, $headers);
              $mail  =  send_smtp_mail($to_visitor,$subject_visitor,$email_template,'');
            ///  echo $mail;die;

           }


          // ======================================

            $where = array(
                        'user_id' => $id
                   );
            $data     = $this->model->delete('otp_master',$where);
            $otp_data  = array(
              'user_id' => $id,
              'otp'     => $otp
            );

            $this->model->insertData('otp_master',$otp_data);
            $otp = $this->model->getAllwhere('otp_master',array('user_id'=>$id),'otp');
            $where = array(
              'phone_no'=>$phone_no
            );
            $data2 = $this->model->getAllwhere('company_master', $where,'unique_id,id,username as name,email,step,CONCAT("'.base_url().'","asset/uploads/",profile_pic)AS image,is_active,is_verified,phone_no,user_role,app_folder,created_at,expire_days,check_expiry');
            //$step  =  $data1[0]->step;
            $resp = array('rccode' => 1, 'message' => ' Login SUCCESS', 'vendor' => $data2[0],'is_active'=> $data2[0]->is_active,'is_verified'=>$data2[0]->is_verified,'user_role'=>$data2[0]->user_role,'otp'=>$otp); 
    

    $this->response($resp);  
    }

    public function send_otp3($phone_no,$id){
      $mobileNumber = '91'.$phone_no;
          //$mobileNumber = '919699996116';
          //Sender ID,While using route4 sender id should be 6 characters long.
          $data = $this->model->getAllwhere('sms_settings',array('type'=>'OTP'));

          $senderId = !empty($data[0]->sender_id)? $data[0]->sender_id:"YOAPPS";
          //Your message to send, Add URL encoding here.
          $otp    = mt_rand(1000,9999);
          $details =    $this->model->getAllwhere('details','');
          $message  = !empty($details[0]->company_name)? "Dear Customer, to confirm your mobile number for ".$details[0]->company_name." Application, please enter the verification code ".$otp." in your online application form." :"Dear Customer, to confirm your mobile number for YoApp Application, please enter the verification code ".$otp." in your online application form.";
          $message  = urlencode("$message");
          $AuthKey  = !empty($data[0]->auth_key)? $data[0]->auth_key :'d55cf7975e584389cf6283ad562be';

          $url  = !empty($data[0]->url) ? $data[0]->url: 'sms.isoftzone.com';
          
          //API URL
          $url="http://$url/rest/services/sendSMS/sendGroupSms?AUTH_KEY=$AuthKey&message=$message&senderId=$senderId&routeId=1&mobileNos=$mobileNumber&smsContentType=english";
          
          // init the resource
          $ch = curl_init();
          curl_setopt_array($ch, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_POST => false,
          //CURLOPT_POSTFIELDS => $postData
          //,CURLOPT_FOLLOWLOCATION => true
          ));
          //Ignore SSL certificate verification
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
          //get response
          $output = curl_exec($ch);
          //Print error if any
          if(curl_errno($ch))
          {
          echo 'error:' . curl_error($ch);
          }
          curl_close($ch);
          

          // ===================================
          $logo  = !empty($details[0]->logo) ? 'http://yoappstore.com/login/asset/uploads/thumbnail/'.$details[0]->logo :'';
          $email_template  = '<!DOCTYPE html PUBLIC "
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
      <!--[if !mso]><!-->
      <meta http-equiv="X-UA-Compatible" content="IE=Edge">
      <!--<![endif]-->
      <!--[if (gte mso 9)|(IE)]>
      <xml>
        <o:OfficeDocumentSettings>
          <o:AllowPNG/>
          <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
      </xml>
      <![endif]-->
      <!--[if (gte mso 9)|(IE)]>
  <style type="text/css">
    body {width: 600px;margin: 0 auto;}
    table {border-collapse: collapse;}
    table, td {mso-table-lspace: 0pt;mso-table-rspace: 0pt;}
    img {-ms-interpolation-mode: bicubic;}
  </style>
<![endif]-->
      <style type="text/css">
    body, p, div {
      font-family: inherit;
      font-size: 14px;
    }
    body {
      color: #000000;
    }
    body a {
      color: #000000;
      text-decoration: none;
    }
    p { margin: 0; padding: 0; }
    table.wrapper {
      width:100% !important;
      table-layout: fixed;
      -webkit-font-smoothing: antialiased;
      -webkit-text-size-adjust: 100%;
      -moz-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
    }
    img.max-width {
      max-width: 100% !important;
    }
    .column.of-2 {
      width: 50%;
    }
    .column.of-3 {
      width: 33.333%;
    }
    .column.of-4 {
      width: 25%;
    }
    @media screen and (max-width:480px) {
      .preheader .rightColumnContent,
      .footer .rightColumnContent {
        text-align: left !important;
      }
      .preheader .rightColumnContent div,
      .preheader .rightColumnContent span,
      .footer .rightColumnContent div,
      .footer .rightColumnContent span {
        text-align: left !important;
      }
      .preheader .rightColumnContent,
      .preheader .leftColumnContent {
        font-size: 80% !important;
        padding: 5px 0;
      }
      table.wrapper-mobile {
        width: 100% !important;
        table-layout: fixed;
      }
      img.max-width {
        height: auto !important;
        max-width: 100% !important;
      }
      a.bulletproof-button {
        display: block !important;
        width: auto !important;
        font-size: 80%;
        padding-left: 0 !important;
        padding-right: 0 !important;
      }
      .columns {
        width: 100% !important;
      }
      .column {
        display: block !important;
        width: 100% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
      }
    }
  </style>
      <!--user entered Head Start--><link href="https://fonts.googleapis.com/css?family=Viga&display=swap" rel="stylesheet"><style>
    body {font-family: "Viga", sans-serif;}
</style><!--End Head user entered-->
    </head>
    <body>
      <center class="wrapper" data-link-color="#000000" data-body-style="font-size:14px; font-family:inherit; color:#000000; background-color:#FFFFFF;">
        <div class="webkit">
          <table cellpadding="0" cellspacing="0" border="0" width="100%" class="wrapper" bgcolor="#FFFFFF">
            <tbody><tr>
              <td valign="top" bgcolor="#FFFFFF" width="100%">
                <table width="100%" role="content-container" class="outer" align="center" cellpadding="0" cellspacing="0" border="0">
                  <tbody><tr>
                    <td width="100%">
                      <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tbody><tr>
                          <td>
                            <!--[if mso]>
    <center>
    <table><tr><td width="600">
  <![endif]-->
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width:100%; max-width:600px;" align="center">
                                      <tbody><tr>
                                        <td role="modules-container" style="padding:0px 0px 0px 0px; color:#000000; text-align:left;" bgcolor="#FFFFFF" width="100%" align="left"><table class="module preheader preheader-hide" role="module" data-type="preheader" border="0" cellpadding="0" cellspacing="0" width="100%" style="display: none !important; mso-hide: all; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0;">
    <tbody><tr>
      <td role="module-content">
        <p></p>
      </td>
    </tr>
  </tbody></table><table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" role="module" data-type="columns" style="padding:0px 0px 0px 0px;" bgcolor="#dde6de">
    <tbody>
      <tr role="module-content">
        <td height="100%" valign="top">
          <table class="column" width="580" style="width:580px; border-spacing:0; border-collapse:collapse; margin:0px 10px 0px 10px;" cellpadding="0" cellspacing="0" align="left" border="0" bgcolor="">
            <tbody>
              <tr>
                <td style="padding:0px;margin:0px;border-spacing:0;"><table class="module" role="module" data-type="spacer" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="10cc50ce-3fd3-4f37-899b-a52a7ad0ccce">
    <tbody>
      <tr>
        <td style="padding:0px 0px 40px 0px;" role="module-content" bgcolor="">
        </td>
      </tr>
    </tbody>
  </table><table class="wrapper" role="module" data-type="image" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="f8665f9c-039e-4b86-a34d-9f6d5d439327">
    <tbody>
      <tr>
        <td style="font-size:6px; line-height:10px; padding:0px 0px 0px 0px;" valign="top" align="center">
          <img class="max-width" border="0" style="display:block; color:#000000; text-decoration:none; font-family:Helvetica, arial, sans-serif; font-size:16px;" width="130" alt="" data-proportionally-constrained="true" data-responsive="false" src="'.$logo.'" height="33">
        </td>
      </tr>
    </tbody>
  </table><table class="module" role="module" data-type="spacer" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="10cc50ce-3fd3-4f37-899b-a52a7ad0ccce.1">
    <tbody>
      <tr>
        <td style="padding:0px 0px 30px 0px;" role="module-content" bgcolor="">
        </td>
      </tr>
    </tbody>
  </table></td>
              </tr>
            </tbody>
          </table>
          
        </td>
      </tr>
    </tbody>
  </table><table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="bff8ffa1-41a9-4aab-a2ea-52ac3767c6f4">
    <tbody>
      <tr>
        <td style="padding:18px 30px 18px 30px; line-height:40px; text-align:inherit; background-color:#dde6de;" height="100%" valign="top" bgcolor="#dde6de" role="module-content"><div><div style="font-family: inherit; text-align: center"><span style="color: #6fab81; font-size: 40px; font-family: inherit">Thank you for downloading the app! Now what?</span></div><div></div></div></td>
      </tr>
    </tbody>
  </table><table class="module" role="module" data-type="text" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="2f94ef24-a0d9-4e6f-be94-d2d1257946b0">
    <tbody>
      <tr>
        <td style="padding:18px 50px 18px 50px; line-height:22px; text-align:inherit; background-color:#dde6de;" height="100%" valign="top" bgcolor="#dde6de" role="module-content"><div><div style="font-family: inherit; text-align: center"><span style="font-size: 16px; font-family: inherit">Confirm your Registation By Below OTP.&nbsp;</span></div><div></div></div></td>
      </tr>
    </tbody>
  </table><table border="0" cellpadding="0" cellspacing="0" class="module" data-role="module-button" data-type="button" role="module" style="table-layout:fixed;" width="100%" data-muid="c7bd4768-c1ab-4c64-ba24-75a9fd6daed8">
      <tbody>
        <tr>
          <td align="center" bgcolor="#dde6de" class="outer-td" style="padding:10px 0px 20px 0px;">
            <table border="0" cellpadding="0" cellspacing="0" class="wrapper-mobile" style="text-align:center;">
              <tbody>
                <tr>
                <td align="center" bgcolor="#eac96c" class="inner-td" style="border-radius:6px; font-size:16px; text-align:center; background-color:inherit;">
                  <a href="#" style="background-color:#eac96c; border:0px solid #333333; border-color:#333333; border-radius:0px; border-width:0px; color:#000000; display:inline-block; font-size:16px; font-weight:normal; letter-spacing:0px; line-height:normal; padding:20px 30px 20px 30px; text-align:center; text-decoration:none; border-style:solid; font-family:inherit;" >'.$otp.'</a>
                </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table><table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" role="module" data-type="columns" style="padding:30px 0px 0px 0px;" bgcolor="#dde6de">
    <tbody>
      <tr role="module-content">
        <td height="100%" valign="top">
          <table class="column" width="600" style="width:600px; border-spacing:0; border-collapse:collapse; margin:0px 0px 0px 0px;" cellpadding="0" cellspacing="0" align="left" border="0" bgcolor="">
            <tbody>
              <tr>
                <td style="padding:0px;margin:0px;border-spacing:0;"><table class="wrapper" role="module" data-type="image" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;" data-muid="ce6dd3be-5ed4-42d2-b304-55a58022cdf0">
    <tbody>
      <tr>
        <td style="font-size:6px; line-height:10px; padding:0px 0px 0px 0px;" valign="top" align="center">
          <img class="max-width" border="0" style="display:block; color:#000000; text-decoration:none; font-family:Helvetica, arial, sans-serif; font-size:16px; max-width:100% !important; width:100%; height:auto !important;" width="600" alt="" data-proportionally-constrained="true" data-responsive="true" src="http://cdn.mcauto-images-production.sendgrid.net/954c252fedab403f/a8915cf9-9083-4c7b-bf41-dfbe1bdec0f7/600x539.png">
        </td>
      </tr>
    </tbody>
  </table></td>
              </tr>
            </tbody>
          </table>
          
        </td>
      </tr>
    </tbody>
  </table></div></center></body></html>';


           if(!empty($email)){
              $to_visitor  = $email;
              $subject_visitor = 'OTP VERIFICATION';

              $headers = "From: " . strip_tags('info@isoftzone.com') . "\r\n";
              $headers .= "Reply-To: ". strip_tags('info@isoftzone.com') . "\r\n";
              $headers .= "CC: gorav.badlani@gmail.com\r\n";
              $headers .= "MIME-Version: 1.0\r\n";
              $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
              $to  = 'gorav.badlani@gmail.com';
              //mail($to, $subject, $email_template, $headers);
              $mail  =  send_smtp_mail($to_visitor,$subject_visitor,$email_template,'');
            ///  echo $mail;die;

           }


          // ======================================

            $where = array(
                        'user_id' => $id
                   );
            $data     = $this->model->delete('otp_master',$where);
            $otp_data  = array(
              'user_id' => $id,
              'otp'     => $otp
            );

            $this->model->insertData('otp_master',$otp_data);
            $otp = $this->model->getAllwhere('otp_master',array('user_id'=>$id),'otp');
      //       $check_step = $this->model->getAllwhere('company_master',array('id'=>$id));
      //       $step  = $check_step[0]->step;
      //       $resp = array(
      //         'rccode'    => 1,
      //         'message'   => 'Login success',
      //         'step'  =>$step,
      //         'user_id'   => $id,
      //         'otp'       =>$otp

      // );
      $where = array(
        'phone_no'=>$phone_no
      );
      $data1 = $this->model->getAllwhere('company_master', $where,'unique_id,id,username as name,email,step,CONCAT("'.base_url().'","asset/uploads/",profile_pic)AS image,is_active,is_verified,phone_no,user_role,app_folder,created_at,expire_days,check_expiry');
      $step  =  $data1[0]->step;
      $resp = array('rccode' => 1, 'message' => ' Login SUCCESS', 'vendor' => $data1[0],'is_active'=> $data1[0]->is_active,'is_verified'=>$data1[0]->is_verified,'user_role'=>$data1[0]->user_role,'otp'=>$otp); 
    

    $this->response($resp);  
    }

  //   // resend otp  for new login
  //   public function resend_otp_post()
  //   {
  //     $pdata     = file_get_contents("php://input");
  //     $postdata  = json_decode($pdata,true);

  //     $user_id    = $postdata['user_id'];
  //     $mobile_no  = $this->model->getAllwhere('company_master',array('id'=>$user_id)); 
  //     $mobile_no  = $mobile_no[0]->phone_no;
  //     $this->send_otp2($mobile_no, $user_id ,'');
  //     echo 1;
  //  }

      }
      ?>