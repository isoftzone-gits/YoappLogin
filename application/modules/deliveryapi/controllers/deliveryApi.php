<?php
error_reporting(1);
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');



// This can be removed if you use __autoload() in config.php OR use Modular Extensions

require APPPATH . '/libraries/REST_Controller.php';

class deliveryApi extends REST_Controller
{
    
    function __construct(){
      parent::__construct();
      $this->load->helper(array('smtpMail'));
    }

 /*verify login for delivery*/
 public function verify_login_post()
 {

  $pdata         = file_get_contents("php://input");
  $data          = json_decode($pdata,true);
  $site_url      = base_url();
  $email         = $data['email'];
 
  $password      = $data['password'];

  $where           = array(
         
         'user_role' => 4,
         'phone_no'  => $email,
         'password' =>md5($password)
      );
  $data = $this->model->getAllwhere('users', $where,'unique_id,id,username as name,email,CONCAT("'.base_url().'","asset/uploads/",profile_pic)AS image,is_active,is_verified,phone_no,user_role');
  if(empty($data))
    {
      $where           = array(
          
          'user_role' => 4,
          'email'  => $email,
          'password' =>md5($password)
        );
      $data = $this->model->getAllwhere('users', $where,'unique_id,id,username as name,email,CONCAT("'.base_url().'","asset/uploads/",profile_pic)AS image,is_active,is_verified,phone_no,user_role');
    }

  
 
  
  if(!empty($data))
  {
    //$this->session->sess_destroy();
   
    //$token = array('device_token' => $device_token);

    $resp = array('rccode' => 1, 'message' => ' Login SUCCESS', 'user' => $data[0],'is_active'=> $data[0]->is_active,'is_verified'=>$data[0]->is_verified,'user_role'=>$data[0]->user_role,);   
  }
  else
  {
    $resp = array('rccode' => 2, 'message' => 'Invalid Email Or Password');
  }
    $this->response($resp);
}

// order get api.
public function orders_get()
{
  $where= array(
          
            'status'=> 'progress',
            'status'=> 'placed'
          );
        $data = $this->model->getAllwhere('orders', $where);
if(!empty($data))
{
  $resp = array('rccode'  => 1, 'message' => 'SUCCESS', 'order' => $data );   
}
else
{
  $resp = array('code' => 'ERROR', 'message' => 'Failure', 'response');
}
$this->response($resp);

}


// order received for delivery boys.
public function order_received_post()
{
  $pdata          = file_get_contents("php://input");
  $data           = json_decode($pdata,true);
  $order_id       = $data['id'];
  $user_id        = $data['user_id'];
  $order_accepted = $data['order_accepeted'];
  $data = array(
 'accept_order'=>$order_accepted
  );

  $data1 = array(
    'user_id'=>$user_id,
    'order_id'=>$order_id,
    'created_at'=>date('Y-m-d H:i:s')

  );
  $where = array(
      'id'=>$order_id
  );
  $this->model->updateFields('orders',$data,$where);
  $this->model->insertData('deliveryboys_orders',$data1);

  $resp = array('rccode' => 2, 'message' => 'success');
  $this->response($resp);
}

// show acceted order for deliveryboys.
public function show_acceted_order_post()
{
  $pdata          = file_get_contents("php://input");
  $data           = json_decode($pdata,true);
  $user_id        = $data['user_id'];

  $where = array(
    'user_id'=>$user_id,
    'accept_order'=>1
  );
     $data  = $this->model->getAllwhere('orders',$where);
     $resp = array('rccode' => 2, 'message' => 'success','data'=>$data);
    $this->response($resp);

}

// show all assign orders for delivery boys.
public function show_assign_orders_get()
{
   $result = $this->model->GetJoinRecord('deliveryboys_orders','user_id','users','id','deliveryboys_orders.*,users.username');
   $resp = array('rccode' => 2, 'message' => 'success','data'=>$result);
   $this->response($resp);
   

}

//send  feedback api .
public function feedback_post()
{

  $pdata         = file_get_contents("php://input");
  $data          = json_decode($pdata,true);

  $user_id       = $this->input->post('user_id');
  $description   = $this->input->post('description');
  $insert_data = array(
  
    'description'=>$description,
    'user_id'=>$user_id,
    'created_at'=>date('Y-m-d H:i:s')

  );
 
  

  if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
                    
    if (move_uploaded_file($_FILES['image']['tmp_name'], 'asset/uploads/' . $_FILES['image']['name'])) {
        
        $insert_data['image'] = $_FILES['image']['name'];
        $this->session->set_userdata('image', $_FILES['image']['name']);
    }
}
  
   $res  = $this->model->insertData('feedback', $insert_data);
   $resp = array('rccode'=>1, 'msg'=>"send succesfully");
    $this->response($resp);
}

// get feedback api.
public function get_feedback_get()
{

  $res = $this->model->getAllwhere('feedback','','user_id,description,CONCAT("'.base_url().'","asset/uploads/",image)AS image');

  $resp = array('rccode' => 2, 'message' => 'success','data'=>$res);
  $this->response($resp);
}

//update order status
public function update_status_post()
{
  $pdata         = file_get_contents("php://input");
  $data          = json_decode($pdata,true);
  
  $order_id = $data['order_id'];
  $user_id = $data['user_id'];

  $where=array(
   'order_id'=>$order_id,
   'user_id'=>$user_id
   );

   $status = array('order_status' => 'delivered');
   
     $this->model->updateFields('deliveryboys_orders', $status,$where);
     $resp = array('rccode' => 1, 'message' => 'Updated successfully'); 

   $this->response($resp);
 }




}




  ?>