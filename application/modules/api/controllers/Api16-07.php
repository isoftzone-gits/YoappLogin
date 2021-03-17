<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');



// This can be removed if you use __autoload() in config.php OR use Modular Extensions

require APPPATH . '/libraries/REST_Controller.php';

class Api extends REST_Controller
{
    
    function __construct(){
      parent::__construct();
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
               //"username = ".$username." or email=".$username,
               'email'     => $email,
               'password'  => md5($password) 
                );
        $data = $this->model->getAllwhere('users', $where,'id,username as name,email,CONCAT("'.base_url().'","asset/uploads/",profile_pic)AS image,is_active,is_verified,phone_no');
        
        if(!empty($data))
        {
          //$this->session->sess_destroy();
          if($data[0]->is_active==0){
            $this->send_otp($data[0]->phone_no,$data[0]->id);
          }
          $this->session->set_userdata('id',$data[0]->id);
          $where = array('id' => $data[0]->id);
          $token = array('device_token' => $device_token);

          $this->model->updateFields('users', $token, $where);
          $resp = array('rccode' => 1, 'message' => ' Login SUCCESS', 'user' => $data[0],'is_active'=> $data[0]->is_active,'is_verified'=>$data[0]->is_verified);   
        }else{
          $resp = array('rccode' => 2, 'message' => 'Invalid Email Or Password');
        }
          $this->response($resp);
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
               'email'      => $email
               //'is_active'  => 0
                );
        $check_email = $this->model->getAllwhere('users', $where1);
        if(!empty($check_email)){
               $resp = array('rccode' => 2, 'message' => 'Email Already Registrered Please Change Your Email');
               $this->response($resp); 
               return false;
        }
        $where2             = array(
               'phone_no'      => $phone_no
               //'is_active'  => 0
                );
        $check_name = $this->model->getAllwhere('users', $where2);
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



          $this->send_otp($phone_no,$id);
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
        $resp = array('rccode' => 1, 'message' => 'Password changed successfully');

        $this->response($resp);
    }

    
    /*Update user Profile*/
   

    public function get_category_get(){
      $site_url=base_url();
      $where = array('status'=>1);
       $data = $this->model->getAllwhere('category',$where,',id,category_name,category_description,CONCAT("'.base_url().'","asset/uploads/",category_image)AS category_image,CONCAT("'.base_url().'","asset/uploads/thumbnail/",category_image)AS thumbnail_image,sequence','sequence','ASC');
       
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


        $banners =    $this->model->getAllwhere('banners','','CONCAT("'.base_url().'","asset/uploads/",image)AS image');
        $details =    $this->model->getAllwhere('details','','company_name,theme_color,CONCAT("'.base_url().'","asset/uploads/",logo)AS logo');
        $login_type =    $this->model->getAllwhere('login_Settings','','login_type');
        $payment_settings = $this->model->getAllwhere('payment_master','','status');
        $settings     = $this->model->getAllwhere('settings_masters');
        $payment_key  = $this->model->getAllwhere('payment_master');
        
        $cash_on_delivery   = 1;
        $self_pickup        = 1;
        $home_delivery      = 1;
        if(!empty($details)){
          $details[0]->login_type = (!empty($login_type) ) ? $login_type[0]->login_type : '1';
          $details[0]->payment_setting = (!empty($payment_settings) ) ? $payment_settings[0]->status : '0';
          if(!empty($settings)){
            foreach ($settings as $key => $value) {
                if($value->name=='cash_on_delivery'){
                  $cash_on_delivery = $value->value;
                }elseif ($value->name=='self_pickup') {
                  $self_pickup      = $value->value;
                }elseif ($value->name=='home_delivery') {
                  $home_delivery    = $value->value;
                }
            }
          }

          $details[0]->cash_on_delivery          = $cash_on_delivery;
          $details[0]->self_pickup               = $self_pickup;
          $details[0]->home_delivery             = $home_delivery;
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
        $data = $this->model->getAllwhere('product',$where,',id,category_id,sub_cat_id,product_name,product_description,product_image,stock','sequence','ASC',$no_of_records_per_page,$offset);
       
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
           
            if(!empty($attributes)){
              foreach ($attributes as $akey => $avalue) {
                $attributes[$akey]->product_attributes = htmlspecialchars_decode($avalue->product_attributes);
              }
              $data[$key]->attributes  = $attributes;
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

        $user_id       = $data['user_id'];
        $place_name    = isset($data['place_name']) ? $data['place_name'] : '';
        $lat           = isset($data['lat']) ? $data['lat'] : '';
        $lng           = isset($data['lng']) ? $data['lng'] :'';
        $address       = isset($data['address']) ? $data['address'] : '';
        $shipping_rate = isset($data['shipping_rate']) ? $data['shipping_rate']:'';
        $address_id    = isset($data['address_id']) ? $data['address_id'] : '';
        $delivery_type = isset($data['delivery_type']) ? $data['delivery_type'] : '';
        $paymentMode   = isset($data['paymentMode']) ? $data['paymentMode'] : '';
        $orderId       = isset($data['orderId']) ? $data['orderId'] : '';
        $txtime        = isset($data['txtime']) ? $data['txtime'] : '';
        $referenceId   = isset($data['referenceId']) ? $data['referenceId'] : '';
        $type          = isset($data['type']) ? $data['type'] : '';
        $txMsg         = isset($data['txMsg']) ? $data['txMsg'] : '';
        $signature     = isset($data['signature']) ? $data['signature'] : '';
        $orderAmount   = isset($data['orderAmount']) ? $data['orderAmount'] : '';
        $txStatus      = isset($data['txStatus']) ? $data['txStatus'] : '';
        $wallet_amount = isset($data['wallet_amount']) ? $data['wallet_amount'] : 0;
        $wallet_id     = isset($data['wallet_id']) ? $data['wallet_id'] : 0;
        
        $order  = array(
            'user_id'       => $user_id,
            'place_name'    => $place_name,
            'lat'           => $lat,
            'lng'           => $lng,
            'address'       => $address,
            'shipping_rate' => $shipping_rate,
            'address_id'    => $address_id,
            'delivery_type' => $delivery_type,
            'paymentMode'   => $paymentMode,
            'orderId'       => $orderId,
            'txtime'        => $txtime,
            'referenceId'   => $referenceId,
            'type'          => $type,
            'txMsg'         => $txMsg,
            'signature'     => $signature,
            'orderAmount'   => $orderAmount,
            'txStatus'      => $txStatus,
            'wallet_amount' => $wallet_amount
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
          
      $orders = $this->model->getAllwhere('orders',$where);
     
      $order_list  = array();
      if (!empty($orders)) 
      {
        foreach ($orders as $key => $value) {
            if($value->status!='cancel'){
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
          
      $orders = $this->model->getAllwhere('orders',$where);
      $order_list  = array();
      if (!empty($orders)) 
      {
        foreach ($orders as $key => $value) {
            if($value->status=='delivered' ||$value->status=='cancel'){
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
      $banners =    $this->model->getAllwhere('banners','','CONCAT("'.base_url().'","asset/uploads/",image)AS image');
    
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

    public function app_version_get(){
      $data     = $this->model->getAllwhere('app_version_history','','versioncode,versionname','id','DESC','1');

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

    public function send_otp($phone_no,$id){
      $mobileNumber = '91'.$phone_no;
          //$mobileNumber = '919699996116';
          //Sender ID,While using route4 sender id should be 6 characters long.
          $data = $this->model->getAllwhere('sms_settings',array('type'=>'OTP'));

          $senderId = !empty($data[0]->sender_id)? $data[0]->sender_id:"YOAPPS";
          //Your message to send, Add URL encoding here.
          $otp    = mt_rand(1000,9999);
          $details =    $this->model->getAllwhere('details','','company_name');
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
          

            $where = array(
                        'user_id' => $id
                   );
            $data     = $this->model->delete('otp_master',$where);
            $otp_data  = array(
              'user_id' => $id,
              'otp'     => $otp
            );
            $this->model->insertData('otp_master',$otp_data);
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
                $wallet_details[$key]->referal_to  = $username[0]->username;
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
        $wallet_details = array(
          'total_amount' => !empty($get_wallet_id[0]->total_amount) ?$get_wallet_id[0]->total_amount : 0,
          'used_amount'  => !empty($wallet_redeem_amount)?$wallet_redeem_amount[0]->redeem_amount : 0,
          'redeem_per'  => !empty($redeem_per) ? $redeem_per[0]->redeem_per :0
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
}
?>