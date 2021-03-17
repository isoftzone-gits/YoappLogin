<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Front extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }
    
    
    
    public function index($msg = NULL)
    {
        $data['body']       = 'main_bar';
        $where              = array(
            'status' => 1
        );
        $category = $this->model->getAllwhere('category',$where);
        if(!empty($category)){
            foreach ($category as $key => $value) {
                $cat_id   = $value->id;
                $products = $this->model->getAllwhere('product',array('category_id'=>$cat_id));
                if(!empty($products)){
                    foreach ($products as $skey => $svalue) {
                      $product_attributes  = $this->model->getAllwhere('product_attributes',array('product_id'=>$svalue->id),'','id','DESC',1);

                      $products[$skey]->attributes  = $product_attributes[0];
                    }
                }
                $category[$key]->products  = $products;
            }
        }

        
        $data['category']   = $category;
        $this->controller->load_view($data);
    }
    
    
    public function about(){
        $data['body']  = 'about';
       $category = $this->model->getAllwhere('category',array('status'=>1));
        $data['category'] = $category;
        $data['about'] = $this->model->getAllwhere('about','');
        $this->controller->load_view($data);
    } 

    public function contact(){
        $data['body']  = 'contact';
        $category = $this->model->getAllwhere('category',array('status'=>1));
        $data['category'] = $category;
        $data['contact'] = $this->model->getAllwhere('contact_us','');
        $this->controller->load_view($data);
    } 

    public function last_executed_query()
    {
        echo $this->db->last_query();
        die;
    }
    
    
    
    public function print_array($data = NULL)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
    
    
    
    public function verifylogin()
    {
        $data = $this->input->post();
        if ($data) {
            $this->form_validation->set_rules('login_username', 'Username', 'trim|required');
            $this->form_validation->set_rules('login_password', 'Password', 'trim|required|callback_check_database');
            if ($this->form_validation->run() == false) {
                redirect('front/index');
            } else {
                if ($this->checkSession()) {
                    $log = $this->session->userdata['user_role'];
                    if ($log == 3) {
                        redirect('patient/dashboard');
                    }else{
                    	$this->session->set_flashdata('alert', 'Username & Password not matched...!!!');
                    	redirect('front/index');
                    }
                }
            }
        }
    }
    
    
    
    public function checkSession()
    {
        if (!empty($this->session->userdata('user_role'))) {
            $log = $this->session->userdata('user_role');
            if (!empty($log)) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    
    
    
    public function check_database($password)
    {
        $username = $this->input->post('login_username', TRUE);
        $where    = array(
            'username' => $username,
            'password' => md5($password),
            'is_active' => 1
        );
        $result   = $this->model->getsingle('users', $where);
        if (!empty($result)) {
            $sess_array = array(
                'id' => $result->id,
                'username' => $result->username,
                'email' => $result->email,
                'user_role' => $result->user_role,
                'first_name' => $result->first_name,
                'last_name' => $result->last_name,
                'hospital_id' => $result->hospital_id
            );
            if ($result->user_role == 1 || $result->user_role == 3) {
                unset($sess_array['hospital_id']);
            }
            if ($result->user_role == 4) {
                $where                = array(
                    'user_id' => $result->id
                );
                $sess_array['rights'] = $this->model->getsingle('user_rights', $where);
            }
            $this->session->set_userdata($sess_array);
            return true;
        } else {
            $this->form_validation->set_message('check_database', 'Invalid Credentials ! Please try again with valid username and password');
            return false;
        }
    }
    
    
    
    public function oldpass_check($oldpass)
    {
        $user_id = $this->session->userdata('id');
        $result  = $this->model->check_oldpassword($oldpass, $user_id);
        if ($result == 0) {
            $this->form_validation->set_message('oldpass_check', "%s does not match.");
            return FALSE;
        } else {
            $this->session->set_flashdata('success_msg', 'Password Successfully Updated!!!');
            return TRUE;
        }
    }
    
    
    
    public function logout()
    {
        $user_data = $this->session->all_userdata();
        foreach ($user_data as $key => $value) {
            if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
                $this->session->unset_userdata($key);
            }
        }
        $this->session->sess_destroy();
        $msg = "You have been logged out Successfully...";
        $this->index($msg);
    }
    
    
    
    public function alpha_dash_space($str)
    {
        if (!preg_match("/^([-a-z_ ])+$/i", $str)) {
            $this->form_validation->set_message('check_captcha', 'Only Aplphabates allowed in this field');
        } else {
            return true;
        }
    }
    
    
    
    public function check_password()
    {
        $old_password = $this->input->post('data');
        $where        = array(
            'id' => $this->session->userdata('id'),
            'password' => md5($old_password)
        );
        $result       = $this->model->getsingle('users', $where);
        if (!empty($result)) {
            echo '0';
        } else {
            echo '1';
        }
    }
    
    
    
    
    public function add_user()
    {
        $this->form_validation->set_rules('signup_first_name', 'First Name', 'trim|required|callback_alpha_dash_space|min_length[2]');
        $this->form_validation->set_rules('signup_last_name', 'Last Name', 'trim|required|callback_alpha_dash_space|min_length[2]');
        $this->form_validation->set_rules('signup_dob', 'Date Of Birth', 'trim|required');
        $this->form_validation->set_rules('signup_username', 'User Name', 'trim|required|is_unique[users.username]');
        $this->form_validation->set_rules('signup_email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('signup_password', 'Password', 'trim|required|min_length[6]|alpha_numeric');
        $this->form_validation->set_rules('signup_sex', 'Gender', 'trim|required');
        $this->form_validation->set_rules('signup_contact', 'Contact', 'trim|required');
        $this->form_validation->set_rules('signup_address', 'Address', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errors', validation_errors());
            $data['body'] = 'main_bar';
            $this->controller->load_view($data);
        } else {
            $first_name       = $this->input->post('signup_first_name');
            $last_name        = $this->input->post('signup_last_name');
            $dob              = $this->input->post('signup_dob');
            $username         = $this->input->post('signup_username');
            $email            = $this->input->post('signup_email');
            $password         = $this->input->post('signup_password');
            $confirm_password = $this->input->post('signup_confirm_password');
            $sex              = $this->input->post('signup_sex');
            $user_type        = $this->input->post('signup_type');
            $contact          = $this->input->post('signup_contact');
            $address          = $this->input->post('signup_address');
            if (!empty($_FILES)) {
                $file_name = $this->file_upload('image');
            } else {
                $file_name = '';
            }
            $data   = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'username' => $username,
                'email' => $email,
                'password' => MD5($password),
                'date_of_birth' => $dob,
                'gender' => $sex,
                'is_active' => 1,
                'user_role' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'profile_pic' => $file_name,
                'mobile' => $contact,
                'address' => $address
            );
            $result = $this->model->insertData('users', $data);
            if ($user_type == 2) {
                if (!empty($address)) {
                    $formattedAddr   = str_replace(' ', '+', $address);
                    $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $formattedAddr . '&sensor=false&key=AIzaSyCSZ2Wy8ghd5Zby2FlNwgzUXPYgg0xqVIA');
                    $output          = json_decode($geocodeFromAddr, true);
                    if (!empty($output)) {
                        $latitude  = $output['results'][0]['geometry']['location']['lat'];
                        $longitude = $output['results'][0]['geometry']['location']['lng'];
                    } else {
                        $latitude  = NULL;
                        $longitude = NULL;
                    }
                }
                $data = array(
                    'doctor_id' => $result,
                    'is_active' => 1,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'created_at' => date('Y-m-d H:i:s')
                );
                $data = $this->model->insertData('doctor', $data);
            }
        }
        $this->session->set_flashdata('msg', 'user registered successfully');
        redirect('front/index');
    }
    
    
    public function catbypro($id){
        $data['category']    = $this->model->getAllwhere('category',array('status'=>1));
        $data['category_id'] = $id;
        $data['body']        = 'catbypro';
        $this->controller->load_view($data);
    }

    public function get_product(){
       
        //print_r($this->input->post());die;
        $filter_data  = $this->input->post('filter_data');
        $category_id  = $this->input->post('category_id');
        $from_amount  = $this->input->post('from_amount');
        $to_amount    = $this->input->post('to_amount');
        
        $order_by  ='';
        if(!empty($filter_data)){
            if($filter_data=='2'){
                $order_by = "order by product_name ASC";
            }else if($filter_data == '3'){
                $order_by = "order by product_name DESC";
            }else if($filter_data == '4'){
              //  $order_by = "order by product_price ASC";
            }else if($filter_data == '5'){
              //  $order_by = "order by product_price DESC";
            }
        }

        $data  = $this->Common_model->get_product($category_id,$from_amount,$to_amount,$order_by);
        $product_html = "";
        if(!empty($data)){
            foreach ($data as $key => $value) {
                $images  = '';
            if(!empty($value['product_image'])) {
                $images  = @unserialize($value['product_image']); 
                $images  = !empty($images)?$images:[];
             }
             $product_attributes  = $this->model->getAllwhere('product_attributes',array('product_id'=>$value['id']),'','id','DESC',1);

                  
                                            
                                   
            $product_html .= '<div class="col-md-3 product-men">
            <div class="men-pro-item simpleCart_shelfItem">
               <div class="men-thumb-item">
                  <img src="'.base_url().'asset/uploads/'. @$images[0] .'" alt="" class="pro-image-front" style="height:250px">
                  <img src="'.base_url().'asset/uploads/'. @$images[0] .'" alt="" class="pro-image-back" style="height:250px">
                  <div class="men-cart-pro">
                     <div class="inner-men-cart-pro">
                        <a href="'.site_url().'front/product/'.$value['id'].'" class="link-product-add-cart">QuickView</a>
                     </div>
                  </div>
                  <span class="product-new-top">New</span>
               </div>
               <div class="item-info-product ">
                  <b><a href="'.site_url().'front/product/'.$value['id'].'">'.substr($value['product_name'], 0, 25).'</a></b>

                  <h5><a href="'.site_url().'front/product/'.$value['id'].'">'.substr($product_attributes[0]->product_attributes, 0, 25).'</a></h5> 
                                    <div class="info-product-price">
                                       <span class="item_price">'.$product_attributes[0]->sell_price.'</span>
                                       <del>'.$product_attributes[0]->product_price.'</del>
                                    </div>
                 
                  <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out button2" onclick="show_modal()">
                                     Inquiry
                                    </div>
               </div>
            </div>
         </div>';
        }
        }else{
            $product_html = "<h3>No Data Found</h3>";
        }
        echo  $product_html;
    }

    public function product($id){
        if(!empty($id)){
           $category = $this->model->getAllwhere('category',array('status'=>1));
           $data['category'] = $category;
           $data['product']  = $this->model->getAllwhere('product',array('id'=>$id));

            $data['attributes'] = $this->model->getAllwhere('product_attributes',array('product_id'=> $id));
            if(!empty($data['product'])){
                $cat_id  = $this->model->getAllwhere('product',array('category_id'=> $data['product'][0]->category_id,'id!='=> $id ),'','','','4');
                if(!empty($cat_id)){
                    foreach ($cat_id as $skey => $svalue) {
                        $product_attributes  = $this->model->getAllwhere('product_attributes',array('product_id'=>$svalue->id),'','id','DESC',1);

                        $cat_id[$skey]->attributes  = $product_attributes[0];
                    }
                }
                $data['related_product']  = $cat_id;
            }
            $data['body']     = 'product';
            $this->controller->load_view($data);
        }else{
            $this->index();
        }
    }

    public function insert_inquiry(){
        $data     = $this->input->post();
        $name     = $data['name'];
        $email    = $data['email'];
        $phone    = $data['phone']; 
        $message  = $data['message'];

        $insert_data  = array(
            'name'       => $name,
            'phone'      => $phone,
            'email'      => $email,
            'message'    => $message,
            'created_at' => date('Y-m-d H:i:s'),
        );

        $this->model->insertData('inquiry',$insert_data);
        echo '1';


    }
}