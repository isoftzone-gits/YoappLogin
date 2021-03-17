<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//define("site_url", "http://".$_SERVER['HTTP_HOST']."/login/");

class Vendor extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

    }
    public function index($msg = NULL)
    {
        if (!empty($this->session->userdata['user_role'])) {
            $log = $this->session->userdata['user_role'];
            $name  = $this->model->getAllwhere('details','','company_name,logo');
            if(!empty($name)){
                $data['name']   = $name[0]->company_name;
                $data['logo']   = $name[0]->logo;
            }
            if ($log == 1 || $log ==3 || $log==4) {
                redirect('vendor/dashboard');
            }  else {
                $data['msg']  = "You are not authorized to login";
                $this->load->view('admin/login', $data);
            }
        } else {
            $name  = $this->model->getAllwhere('details','','company_name,logo');
            if(!empty($name)){
                $data['name'] = $name[0]->company_name;
                $data['logo']   = $name[0]->logo;
            }
            if (isset($msg) && !empty($msg)) {
                $data['msg'] = $msg;
            } else {
                $data['msg'] = '';
            }
            $this->load->view('admin/login', $data);
        }
    }

     public function get_record()
    {
        $id     = $this->input->get('id');
        $table  = $this->input->get('table');
        $field  = $this->input->get('field');
        $select = $this->input->get('select');
        $where  = array(
            "$field" => $id,
            'status' => 1
        );
        $states = $this->model->getAllwhere($table, $where, $select);

        echo json_encode($states);
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
        $this->controller->verifylogin($data);
      
    }
    public function dashboard()
    {
        if ($this->controller->checkSession()) {
            $user_role             = $this->session->userdata('user_role');
            $data['body']          = 'dashboard';


            $new_orders  =  $this->model->GetJoinRecord('orders', 'user_id', 'users', 'id', 'COUNT(*) as total_count',array('status'=>'placed'));

            $data['new_orders'] = !empty($new_orders[0]->total_count)?$new_orders[0]->total_count:0;
            $data['totalCustomer']  = $this->model->getcount('users', array(
                    'user_role' => '2'));

            $data['totalUser']  = $this->model->getcount('users', array(
                    'user_role' => '3'));


            $order_list =  $this->model->GetJoinRecord('orders', 'user_id', 'users', 'id', 'COUNT(orders.id) as total_orders',array('orders.id!='=>'0'));

            
            // $data['totalOrders']  = $this->model->getcount('orders',array('id!='=>'0'));
            $data['totalOrders']  = !empty($order_list) ? $order_list[0]->total_orders : 0;
            $data['todayOrders']  = $this->model->getcount('orders', array(
                    'DATE(created_at)' => date('Y-m-d')));
            
            $data['total_sales']  = $this->Common_model->get_yearly_sale();
           
            $data['pending_order']  = $this->model->getcount('orders',array('status='=>'placed'));

           
            // $monthly_where = array(
            //     "year(date((created_at)))" => "year(CURDATE())",
            //     "month(date((created_at)))"=> "month(CURDATE())" 

            // );

            // $data['monthly_order']  = $this->model->getcount('orders',$monthly_where);

           


            $this->controller->load_view($data);
        } else {
            redirect('vendor/index');
        }
    }
    public function check_database($password)
    {
        $username = $this->input->post('username', TRUE);
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
                'profile_pic'=>$result->profile_pic
                
            );
           
            if ($result->user_role == 4) {
                $where                = array(
                    'user_id' => $result->id
                );
               // $sess_array['rights'] = $this->model->getsingle('user_rights', $where);
            }
            
            $this->session->set_userdata($sess_array);
            return true;
        } else {
            $this->form_validation->set_message('check_database', 'Invalid Credentials ! Please try again with valid username and password');
            return false;
        }
    }
    public function change_password()
    {
        if ($this->controller->checkSession()) {
            $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
            $this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('errors', validation_errors());
                $data['body'] = 'change_password';
                $this->controller->load_view($data);
            } else {
                $data   = array(
                    'password' => md5($this->input->post('new_password', TRUE))
                );
                $where  = array(
                    'id' => $this->session->userdata('id')
                );
                $table  = 'users';
                $result = $this->model->updateFields($table, $data, $where);
                redirect('vendor/change_password', 'refresh');
            }
        } else {
            redirect('vendor/index');
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
    public function get_port_data()
    {
        $val       = $this->input->get('val');
        $table     = $this->input->get('table');
        $port_data = $this->model->get_matching_record($table, $val);
        echo json_encode($port_data);
    }
    
    public function alpha_dash_space($str)
    {
        if (!preg_match("/^([-a-z_ ])+$/i", $str)) {
            $this->form_validation->set_message('check_captcha', 'Only Aplphabates allowed in this field');
        } else {
            return true;
        }
    }

    public function delete()
    {
        if ($this->controller->checkSession()) {
            $id    = $this->input->post('id');
            $table = $this->input->post('table');
            $where = array(
                'id' => $id
            );
            $this->model->delete($table, $where);
        } else {
            redirect('vendor/index');
        }
    }

    public function delete_product_image(){
        if ($this->controller->checkSession()) {
            $id         = $this->input->post('id');
            $image_name = $this->input->post('image_name');
            $where = array(
                'id' => $id
            );
            $product_image = $this->model->getAllwhere('product', $where,'product_image');

            $images  = @unserialize($product_image[0]->product_image);

            foreach ($images as $key => $value) {
                if($value==$image_name){
                    unset($images[$key]);
                }
            }
            $final_array = serialize(array_values($images));
            

            $data   = array(
                'product_image' => $final_array
            );
            $result = $this->model->updateFields('product', $data, $where);
            

        } else {
            redirect('vendor/index');
        }
    }
    
    public function change_status()
    {
        if ($this->controller->checkSession()) {
            $id     = $this->input->post('id');
            $table  = $this->input->post('table');
            $where  = array(
                'id' => $id
            );
            $data   = array(
                'is_active' => 0
            );
            $result = $this->model->updateFields($table, $data, $where);
        } else {
            redirect('vendor/index');
        }
    }
 
    public function update_status()
    {
        if ($this->controller->checkSession()) {
            $id        = $this->input->post('id');
            $table     = $this->input->post('table');
            $status    = $this->input->post('status');
            $data   = array(
                'status' => $status
            );
            $where  = array(
                'id' => $id
            );
            $this->model->update($table, $data, $where);
        } else {
            redirect('vendor/index');
        }
    }


    public function get_sequence()
    {
        if ($this->controller->checkSession()) {
            $id        = $this->input->post('id');
            $table     = $this->input->post('table');
            $column    = $this->input->post('column');
           
            $where  = array(
                $column => $id
            );
            $sequence = $this->model->getAllwhere($table,$where,'sequence','id','DESC','1');
            $sq_id = !empty($sequence)?$sequence[0]->sequence+1:1;
            echo $sq_id;

        } else {
            redirect('vendor/index');
        }
    }

    public function get_sequence_by_subCategory(){
        if ($this->controller->checkSession()) {
            $id              = $this->input->post('id');
            $category_id     = $this->input->post('category_id');
            
            $where  = array(
                'category_id' => $category_id,
                'sub_cat_id'  => $id
            );
            $sequence = $this->model->getAllwhere('product',$where,'sequence','id','DESC','1');
            $sq_id = !empty($sequence)?$sequence[0]->sequence+1:1;
            echo $sq_id;

        } else {
            redirect('vendor/index');
        }
    }

    public function verify_user()
    {
        if ($this->controller->checkSession()) {
            $id        = $this->input->post('id');
            $table     = $this->input->post('table');
            $status    = $this->input->post('status');
            $data   = array(
                'is_verified' => $status
            );
            $where  = array(
                'id' => $id
            );
            $this->model->update($table, $data, $where);
        } else {
            redirect('vendor/index');
        }
    }
   
    
    public function profile()
    {
        if ($this->controller->checkSession()) {
            $where         = array(
                'id' => $this->session->userdata('id')
            );
            $data['users'] = $this->model->getAllwhere('users', $where);
             if(!empty($this->input->post('username'))){
                if($data['users'][0]->username!= $this->input->post('username')){
                     $this->form_validation->set_rules('username', 'User Name', 'trim|required|is_unique[users.username]');
                }
             }else{
             $this->form_validation->set_rules('username', 'User Name', 'trim|required|is_unique[users.username]');
            }
            // $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|alpha|min_length[2]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            // $this->form_validation->set_rules('date_of_birth', 'Date Of Birth', 'trim|required');
            
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('errors', validation_errors());
                $data['body'] = 'profile';
                $this->controller->load_view($data);
            } else {
                
                
                $username    = $this->input->post('username');
                $first_name  = $this->input->post('first_name');
                $last_name   = $this->input->post('last_name');
                $email       = $this->input->post('email');
                $address     = $this->input->post('address');
                $phone_no    = $this->input->post('phone');
                $dob         = $this->input->post('date_of_birth');
                $gender      = $this->input->post('gender');
                
                $data = array(
                    'username'      => $username,
                    'first_name'    => $first_name,
                    'last_name'     => $last_name,
                    'email'         => $email,
                    'address'       => $address,
                    'phone_no'      => $phone_no,
                    'date_of_birth' => $dob,
                    'gender'        => $gender,
                );
                
                if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], 'asset/uploads/' . $_FILES['image']['name'])) {
                        
                        $data['profile_pic'] = $_FILES['image']['name'];
                        $this->session->set_userdata('profile_pic', $_FILES['image']['name']);
                    }
                }
                $result = $this->model->updateFields('users', $data, $where);
                redirect('/admin/profile', 'refresh');
                
            }
        } else {
            redirect('vendor/index');
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
   
    public function file_upload($file)
    {
        if (!empty($_FILES["$file"]["name"])) {
            $f_name      = $_FILES["$file"]["name"];
            $f_tmp       = $_FILES["$file"]["tmp_name"];
            $f_size      = $_FILES["$file"]["size"];
            $f_extension = explode('.', $f_name); //To breaks the string into array
            $f_extension = strtolower(end($f_extension)); //end() is used to retrun a last element to the array
            $f_newfile   = "";
            
            if ($f_name) {
                $f_newfile = uniqid() . '.' . $f_extension; // It`s use to stop overriding if the image will be same then uniqid() will generate the unique name of both file.
                $store     = 'asset/uploads/' . $f_newfile;
                $image1    = move_uploaded_file($f_tmp, $store);
                return $f_newfile;
            }
        }
    }
    

    public function register($id = NULL, $user_role = NULL)
    {
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|alpha|min_length[2]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|alpha|min_length[2]');
        $this->form_validation->set_rules('dob', 'Date Of Birth', 'trim|required');
        $this->form_validation->set_rules('user_role', 'User Role', 'trim|required');
        
        if (empty($id)) {
            $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|is_unique[users.username]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|alpha_numeric');
        }
        
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errors', validation_errors());

            if (!empty($id)) {
                $where              = array(
                    'id ' => $id,
                   
                );
                $data['details'] = $this->model->getAllwhere('users', $where);
            }
            $data['body'] = 'register';
            $this->controller->load_view($data);
        } else {
            if ($this->controller->checkSession()) {
                $first_name  = $this->input->post('first_name');
                $user_name   = $this->input->post('user_name');
                $last_name   = $this->input->post('last_name');
                $email       = $this->input->post('email');
                $password    = $this->input->post('password');
                $address     = $this->input->post('address');
                $phone_no    = $this->input->post('phone_no');
                $dob         = $this->input->post('dob');
                $gender      = $this->input->post('gender');
                $user_role   = $this->input->post('user_role');
                $status      = $this->input->post('status');
                $data = array(
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'username' => $user_name,
                    'email' => $email,
                    'address' => $address,
                    'phone_no' => $phone_no,
                    'date_of_birth' => $dob,
                    'gender' => $gender,
                    'is_verified' => $status,
                    'user_role' => $user_role,
                    'created_at' => date('Y-m-d H:i:s')
                );

                if(!empty($password)){
                    $data['password']  = md5($password);
                }
                
                
                if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
                    $count = count($_FILES['image']['name']);
                    for ($i = 0; $i < $count; $i++) {
                        if ($_FILES['image']['error'][$i] == 0) {
                            if (move_uploaded_file($_FILES['image']['tmp_name'][$i], 'asset/uploads/' . $_FILES['image']['name'][$i])) {
                                $data['profile_pic'] = $_FILES['image']['name'][$i];
                            }
                        }
                    }
                }
                
                if (!empty($id)) {
                    $where = array(
                        'id' => $id
                    );
                    unset($data['created_at']);
                    unset($data['email']);
                   // unset($data['password']);
                    $result = $this->model->updateFields('users', $data, $where);
                } else {
                    $result = $this->model->insertData('users', $data);
                }

                if($user_role==3){
                    $this->userList();
                }else{
                    $this->customerList();
                }
            }else {
                redirect('vendor/index');
            }
        }
    }

    public function customer_register($id = NULL, $user_role = NULL)
    {
        
        $this->form_validation->set_rules('dob', 'Date Of Birth', 'trim|required');
        $this->form_validation->set_rules('user_role', 'User Role', 'trim|required');
        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required');
       
        if(empty($id)){
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|alpha_numeric');
        }        
        
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errors', validation_errors());

            if (!empty($id)) {
                $where              = array(
                    'id ' => $id,
                   
                );
                $data['details'] = $this->model->getAllwhere('users', $where);
            }
            $data['body'] = 'customer_register';
            $this->controller->load_view($data);
        } else {
            if ($this->controller->checkSession()) {
             //   $first_name  = $this->input->post('first_name');
                $user_name   = $this->input->post('user_name');
               // $last_name   = $this->input->post('last_name');
                $email       = $this->input->post('email');
                $password    = $this->input->post('password');
                $address     = $this->input->post('address');
                $phone_no    = $this->input->post('phone_no');
                $dob         = $this->input->post('dob');
                $gender      = $this->input->post('gender');
                $user_role   = $this->input->post('user_role');
                $status      = $this->input->post('status');
                $data = array(
                //    'first_name' => $first_name,
                  //  'last_name' => $last_name,
                    'username' => $user_name,
                    'email' => $email,
                    'address' => $address,
                    'phone_no' => $phone_no,
                    'date_of_birth' => $dob,
                    'gender' => $gender,
                    'is_verified' => $status,
                    'user_role' => $user_role,
                    'created_at' => date('Y-m-d H:i:s')
                );

                if(!empty($password)){
                    $data['password']  = md5($password);
                }
                
                
                if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
                    $count = count($_FILES['image']['name']);
                    for ($i = 0; $i < $count; $i++) {
                        if ($_FILES['image']['error'][$i] == 0) {
                            if (move_uploaded_file($_FILES['image']['tmp_name'][$i], 'asset/uploads/' . $_FILES['image']['name'][$i])) {
                                $data['profile_pic'] = $_FILES['image']['name'][$i];
                            }
                        }
                    }
                }
                
                if (!empty($id)) {
                    $where = array(
                        'id' => $id
                    );
                    unset($data['created_at']);
                    unset($data['email']);
                   // unset($data['password']);
                    $result = $this->model->updateFields('users', $data, $where);
                } else {
                    $result = $this->model->insertData('users', $data);
                }

                if($user_role==3){
                    $this->userList();
                }else{
                    $this->customerList();
                }
            }else {
                redirect('vendor/index');
            }
        }
    }
    public function userList($user_role = NULL)
    {
        if ($this->controller->checkSession()) {
        $where         = array(
            'user_role =' => 3
        );
        $data['users'] = $this->model->getAllwhere('users', $where);
        $data['body']  = 'userList';
        
        $this->controller->load_view($data);
        }else {
            redirect('vendor/index');
        }
    }
    
    public function customerList($user_role = NULL)
    {
        if ($this->controller->checkSession()) {
        $where         = array(
            'user_role =' => 2
        );
        $data['users'] = $this->model->getAllwhere('users', $where);
        
        $data['body']  = 'customerList';
        
        $this->controller->load_view($data);
        }else {
            redirect('vendor/index');
        }
    }


    public function vendor_register($id = NULL, $user_role = NULL){
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|alpha|min_length[2]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|alpha|min_length[2]');
        $this->form_validation->set_rules('dob', 'Date Of Birth', 'trim|required');
        $this->form_validation->set_rules('user_role', 'User Role', 'trim|required');
        
        if (empty($id)) {
            $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|is_unique[users.username]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|alpha_numeric');
        }
        
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errors', validation_errors());

            if (!empty($id)) {
                $where              = array(
                    'id ' => $id,
                   
                );
                $data['details'] = $this->model->getAllwhere('users', $where);
            }
            $data['body'] = 'vendor_register';
            $this->controller->load_view($data);
        } else {
            if ($this->controller->checkSession()) {
                $first_name  = $this->input->post('first_name');
                $user_name   = $this->input->post('user_name');
                $last_name   = $this->input->post('last_name');
                $email       = $this->input->post('email');
                $password    = $this->input->post('password');
                $address     = $this->input->post('address');
                $phone_no    = $this->input->post('phone_no');
                $dob         = $this->input->post('dob');
                $gender      = $this->input->post('gender');
                $user_role   = $this->input->post('user_role');
                $status      = $this->input->post('status');
                $data = array(
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'username' => $user_name,
                    'email' => $email,
                    'address' => $address,
                    'phone_no' => $phone_no,
                    'date_of_birth' => $dob,
                    'gender' => $gender,
                    'is_verified' => $status,
                    'user_role' => $user_role,
                    'created_at' => date('Y-m-d H:i:s')
                );

                if(!empty($password)){
                    $data['password']  = md5($password);
                }
                
                
                if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
                    $count = count($_FILES['image']['name']);
                    for ($i = 0; $i < $count; $i++) {
                        if ($_FILES['image']['error'][$i] == 0) {
                            if (move_uploaded_file($_FILES['image']['tmp_name'][$i], 'asset/uploads/' . $_FILES['image']['name'][$i])) {
                                $data['profile_pic'] = $_FILES['image']['name'][$i];
                            }
                        }
                    }
                }
                
                if (!empty($id)) {
                    $where = array(
                        'id' => $id
                    );
                    unset($data['created_at']);
                    unset($data['email']);
                   // unset($data['password']);
                    $result = $this->model->updateFields('users', $data, $where);
                } else {
                    $result = $this->model->insertData('users', $data);
                }

               $this->vendorList();
            }else {
                redirect('vendor/index');
            }
        }
    }

    public function vendorList($user_role = NULL)
    {
        if ($this->controller->checkSession()) {
        $where         = array(
            'user_role =' => 5
        );
        $data['users'] = $this->model->getAllwhere('users', $where);

        $data['body']  = 'vendorList';
        
        $this->controller->load_view($data);
        }else {
            redirect('vendor/index');
        }
    }

    public function category($id = NULL)
    {
        if ($this->controller->checkSession()) {
            //$this->form_validation->set_rules('speciality_name', 'Speciality Name', 'trim|required|is_unique[speciality.name]');
            if (empty($id)) {
                $this->form_validation->set_rules('category_name', 'Category name', 'trim|required');
            } else {
                $this->form_validation->set_rules('category_name', 'Category name', 'trim|required');
            }
            $this->form_validation->set_rules('category_description', 'Category Description', 'trim|required');
            
            
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('errors', validation_errors());
                if (!empty($id)) {
                    $where              = array(
                        'id ' => $id,
                       
                    );
                    $data['category'] = $this->model->getAllwhere('category', $where);
                }
                $data['sequence']  = $this->model->getAllwhere('Category','','sequence','id','DESC','1');

                $data['body'] = 'category';
                $this->controller->load_view($data);
            } else {
                
                $category_name          = $this->input->post('category_name');
                $category_description   = $this->input->post('category_description');
                $image                  = $this->input->post('cropped_image');
                $sequence               = $this->input->post('sequence');
                
                 $data = array(
                    'category_name'             => $category_name,
                    'category_description'      => $category_description,
                    'sequence'                  => $sequence,
                    'created_at'                => date('Y-m-d H:i:s'),
                    'created_by'                => $this->session->userdata('id')
                );


                define('UPLOAD_DIR', 'asset/uploads/');
                if(!empty($image)){

                    $image_parts = explode(";base64,", $image);
                    $data1    = base64_decode($image_parts[1]);
                    $file    =  UPLOAD_DIR . uniqid() . '.png';
                    $success = file_put_contents($file, $data1);
                     
                    $img = substr($file,14);
                    $this->resizeImage($img);
                    $data['category_image'] = $img;
                    
                 }
                

                // if (isset($_FILES['category_image']['name']) && !empty($_FILES['category_image']['name'])) {
                    
                //     if (move_uploaded_file($_FILES['category_image']['tmp_name'], 'asset/uploads/' . $_FILES['category_image']['name'])) {
                        
                //         $data['category_image'] = $_FILES['category_image']['name'];
                //     }
                // }

               
                
                if (!empty($id)) {
                    $where = array(
                        'id' => $id
                    );
                    unset($data['created_at']);
                    unset($data['created_by']);
                    $result = $this->model->updateFields('category', $data, $where);
                } else {
                    $result = $this->model->insertData('category', $data);
                }
                redirect('vendor/category_list');
            }
        } else {
            redirect('vendor/index');
        }
    }

    public function category_list()
    {
        if ($this->controller->checkSession()) {
          //  $where  = array('status'=>1);

            // $where  = array('created_by' => $this->session->userdata('id'));
            $data['category'] = $this->model->getAllwhere('category');
            $data['body']       = 'category_list';
            $this->controller->load_view($data);
        } else {
            redirect('vendor/index');
        }
    }


    public function sub_category($id = NULL)
    {
        if ($this->controller->checkSession()) {
            //$this->form_validation->set_rules('speciality_name', 'Speciality Name', 'trim|required|is_unique[speciality.name]');
            if (empty($id)) {
                $this->form_validation->set_rules('sub_cat_name', 'Sub Category name', 'trim|required');
            } else {
                $this->form_validation->set_rules('sub_cat_name', 'Sub Category name', 'trim|required');
            }
            $this->form_validation->set_rules('sub_cat_desc', 'Sub Category Description', 'trim|required');
            
            $this->form_validation->set_rules('category_id', 'Category ID', 'trim|required');

            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('errors', validation_errors());
                if (!empty($id)) {
                    $where              = array(
                        'id ' => $id,
                       
                    );
                    $data['sub_category'] = $this->model->getAllwhere('sub_category', $where);
                }

                

                $data['category_list'] = $this->model->getAllwhere('category',array('status'=>1));
                $data['body'] = 'sub_category';
                $this->controller->load_view($data);
            } else {
                
                $sub_cat_name   = $this->input->post('sub_cat_name');
                $sub_cat_desc   = $this->input->post('sub_cat_desc');
                $category_id    = $this->input->post('category_id');
                $sequence       = $this->input->post('sequence');
                $image          = $this->input->post('cropped_image');
                 $data = array(
                    'sub_cat_name'             => $sub_cat_name,
                    'sub_cat_desc'             => $sub_cat_desc,
                    'category_id'              => $category_id,
                    'sequence'                 => $sequence,
                    'created_at'               => date('Y-m-d H:i:s'),
                    'created_by'               => $this->session->userdata('id')
                );


                define('UPLOAD_DIR', 'asset/uploads/');
                if(!empty($image)){

                    $image_parts = explode(";base64,", $image);
                    $data1    = base64_decode($image_parts[1]);
                    $file    =  UPLOAD_DIR . uniqid() . '.png';
                    $success = file_put_contents($file, $data1);
                     
                    $img = substr($file,14);
                    $this->resizeImage($img);
                    $data['sub_cat_image'] = $img;
                    
                 }

                // if (isset($_FILES['sub_cat_image']['name']) && !empty($_FILES['sub_cat_image']['name'])) {
                    
                //     if (move_uploaded_file($_FILES['sub_cat_image']['tmp_name'], 'asset/uploads/' . $_FILES['sub_cat_image']['name'])) {
                //          $this->resizeImage($_FILES['sub_cat_image']['name']);
                //         $data['sub_cat_image'] = $_FILES['sub_cat_image']['name'];
                //     }
                // }

               
                
                if (!empty($id)) {
                    $where = array(
                        'id' => $id
                    );
                    unset($data['created_at']);
                    unset($data['created_by']);
                    $result = $this->model->updateFields('sub_category', $data, $where);
                } else {
                    $result = $this->model->insertData('sub_category', $data);
                }
                redirect('vendor/sub_cat_list');
            }
        } else {
            redirect('vendor/index');
        }
    }



    public function sub_cat_list()
    {
        if ($this->controller->checkSession()) {
            //$where  = array('sub_category.status'=>1);
            // $where  = array('sub_category.created_by' => $this->session->userdata('id'));

            $data['category'] = $this->model->GetJoinRecord('sub_category', 'category_id', 'category', 'id', 'sub_category.*,category.category_name');
            $data['body']       = 'sub_cat_list';
            $this->controller->load_view($data);
        } else {
            redirect('vendor/index');
        }
    }



    public function product($id = NULL)
    {
        if ($this->controller->checkSession()) {
            //$this->form_validation->set_rules('speciality_name', 'Speciality Name', 'trim|required|is_unique[speciality.name]');
            if (empty($id)) {
                $this->form_validation->set_rules('product_name', 'Product name', 'trim|required');
            } else {
                $this->form_validation->set_rules('product_name', 'Product name', 'trim|required');
            }
            //$this->form_validation->set_rules('product_description', 'Product Description', 'trim|required');
            // $this->form_validation->set_rules('product_price', 'Product Price', 'trim|required');

            $this->form_validation->set_rules('category_id', 'Category ID', 'trim|required');
            //$this->form_validation->set_rules('sub_cat_id', 'Sub Cat ID', 'trim|required');
            

            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('errors', validation_errors());
                if (!empty($id)) {
                    $where              = array(
                        'id ' => $id,
                    );
                    $data['product'] = $this->model->getAllwhere('product', $where);
                    $data['p_attr']  = $this->model->getAllwhere('product_attributes',array('product_id'=> $id));
                    $category_id     = $data['product'][0]->category_id;
                    $sub_where   = array('category_id' => $category_id);
                    $data['sub_category'] = $this->model->getAllwhere('sub_category', $sub_where);
                }

                $data['sequence']  = $this->model->getAllwhere('product','','sequence','id','DESC','1');

                $data['category_list'] = $this->model->getAllwhere('category',array('status'=>1));
                $data['body'] = 'product';
                $this->controller->load_view($data);
            } else {
               
                $product_name           = $this->input->post('product_name');
                $product_description    = $this->input->post('product_description');
                $category_id            = $this->input->post('category_id');
                $sub_cat_id             = $this->input->post('sub_cat_id');
                $product_price          = $this->input->post('product_price');
                $sequence               = $this->input->post('sequence');
                $stock                  = !empty($this->input->post('stock')) ? $this->input->post('stock') : 0;
                $data = array(
                    'product_name'          => $product_name,
                    'product_description'   => $product_description,
                    'category_id'           => $category_id,
                    'sub_cat_id'            => $sub_cat_id,
                    'product_price'         => $product_price,
                    'sequence'              => $sequence,
                    'stock'                 => $stock,    
                    'created_at'            => date('Y-m-d H:i:s'),
                    'created_by'            => $this->session->userdata('id')
                );


                $image                  = $this->input->post('cropped_image');
                $product_image  = array();    
                if(!empty($id)){
                    $p_img  = $this->model->getAllwhere('product',array('id'=>$id),'product_image');
                    if(!empty($p_img)){
                        $product_image = @unserialize($p_img[0]->product_image);
                    }
                }
                
                // if (isset($_FILES['product_image']['name']) && !empty($_FILES['product_image']['name'])) {
                //     $count = count($_FILES['product_image']['name']);
                //     for ($i = 0; $i < $count; $i++) {
                //         if ($_FILES['product_image']['error'][$i] == 0) {
                //             if (move_uploaded_file($_FILES['product_image']['tmp_name'][$i], 'asset/uploads/' . $_FILES['product_image']['name'][$i])) {
                //                 $this->resizeImage($_FILES['product_image']['name'][$i]);
                //                 $product_image[] = $_FILES['product_image']['name'][$i];
                //             }
                //         }
                //     }
                    
                    
                // }

                define('UPLOAD_DIR', 'asset/uploads/');
                if(!empty($image)){
                    foreach ($image as $key => $value) {
                        $image_parts = explode(";base64,", $value);
                        $data1       = base64_decode($image_parts[1]);
                        $file        =  UPLOAD_DIR . uniqid() . '.png';
                        $success     = file_put_contents($file, $data1);
                         
                        $img = substr($file,14);
                        
                        $this->resizeImage($img);
                        $product_image[]  = $img;
                    }
                    
                    $data['product_image']  = serialize($product_image);
                 }

                if (!empty($id)) {
                    $where = array(
                        'id' => $id
                    );
                    unset($data['created_at']);
                    unset($data['created_by']);
                    $result = $this->model->updateFields('product', $data, $where);
                } else {
                    $id = $this->model->insertData('product', $data);    
                }

                if(!empty($id)){
                    $attributes  = $this->input->post('attribute');
                    $price       = $this->input->post('price');
                    $sell_price  = $this->input->post('sell_price');
                    if (!empty($attributes)) {
                        for ($i = 0; $i < count($attributes); $i++) {
                            $adata[$i]['product_id']         = $id;
                            $adata[$i]['product_price']      = $price[$i];
                            $adata[$i]['sell_price']         = $sell_price[$i];
                            $adata[$i]['product_attributes'] = htmlspecialchars($attributes[$i]);
                            
                        }
                        
                            $where  = array(
                                'product_id' => $id,
                                
                            );
                            $delete = $this->model->delete('product_attributes', $where);
                       
                        $result = $this->model->insertBatch('product_attributes', $adata);
                        
                    }
                }

                redirect('vendor/product_list');
            }
        } else {
            redirect('vendor/index');
        }
    }
    
    


    public function product_list(){
        if ($this->controller->checkSession()) {
            $where  = "WHERE product.created_by = ".$this->session->userdata('id')."";
            $data['product_list'] = $this->Common_model->GetJoinedRecord($where);

            $data['body']       = 'product_list';
            $this->controller->load_view($data);
        } else {
            redirect('vendor/index');
        }
    }
   

    public function search_order(){
        if ($this->controller->checkSession()) {
          
        $this->form_validation->set_rules('from_date', 'From Date', 'trim|required');
        $this->form_validation->set_rules('to_date', 'To date', 'trim|required');
        
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errors', validation_errors());
            $data['order_list'] =  $this->model->GetJoinRecord('orders', 'user_id', 'users', 'id', 'orders.*,users.username','');
            if(!empty($data['order_list'])){
                foreach ($data['order_list'] as $key => $value) {
                    $order_id   = $value->id;
                   
                    $order_items       =  $this->model->getAllwhere('orders_items',array('order_id'=>$order_id));
                    $value->order_items = $order_items;
                }
            }
           
            $data['body']       = 'order_list';
            $this->controller->load_view($data);
           
            
        } else {

            $from_date  = $this->input->post('from_date');
            $to_date  = $this->input->post('to_date');

            $where  = array(
                'DATE(orders.created_at) >='   => $from_date,
                'DATE(orders.created_at) <='   => $to_date 
            );
            $data['order_list'] =  $this->model->GetJoinRecord('orders', 'user_id', 'users', 'id', 'orders.*,users.username,users.phone_no',$where);
           
            if(!empty($data['order_list'])){
                foreach ($data['order_list'] as $key => $value) {
                    $order_id   = $value->id;
                   
                    $order_items       =  $this->model->getAllwhere('orders_items',array('order_id'=>$order_id));
                    $value->order_items = $order_items;
                }
            }
           
            $data['body']       = 'order_list';
            $this->controller->load_view($data);
        }
        } else {
            redirect('vendor/index');
        }
    }

    public function orders()
    {
        if ($this->controller->checkSession()) {
            $data['order_list'] =  $this->model->GetJoinRecord('orders', 'user_id', 'users', 'id', 'orders.*,users.username,users.phone_no','','','id','DESC');


            if(!empty($data['order_list'])){
                foreach ($data['order_list'] as $key => $value) {
                    $order_id   = $value->id;
                   
                    $order_items       =  $this->model->getAllwhere('orders_items',array('order_id'=>$order_id));
                    $value->order_items = $order_items;
                }
            }
           
            $data['body']       = 'order_list';
            $this->controller->load_view($data);
        } else {
            redirect('vendor/index');
        }
    }

    public function order_details($id){
        if ($this->controller->checkSession()) {
        $where  = array('orders.id'=>$id);
        $data['orders']       =  $this->model->GetJoinRecord('orders', 'user_id', 'users', 'id', 'orders.*,users.username',$where);
        
        $data['user_address']       =  $this->model->GetJoinRecord('orders', 'address_id', 'address_master', 'id', 'address_master.*',$where);

        $data['order_items'] = $this->model->getAllwhere('orders_items',array('order_id'=>$id));

        $data['body']       = 'order_details';
        $this->controller->load_view($data);
        } else {
            redirect('vendor/index');
        }

    }


    public function change_order_status()
    {
        if ($this->controller->checkSession()) {
            $id     = $this->input->post('order_id');
            $status = $this->input->post('status');
            $user_id= $this->input->post('user_id');
            $data   = array(
                'status' => $status
            );
            $where  = array(
                'id' => $id
            );
            $this->model->update('orders', $data, $where);

            $token  = $this->model->getAllwhere('users',array('id'=> $user_id),'device_token');

            if(!empty($token[0]->device_token)){
                $type     = "Order Status";
                $message  = "Your Order is $status";
                $notification_array = array(
                    'title'   => 'Order Status',
                    'type'    => $type,
                    'message' => $message,
                    'image'   => ''
                );
                
                $this->model->sendPushNotification($notification_array,$token[0]->device_token);
            }
        } else {
            redirect('vendor/index');
        }
    }

  
    
    public function banners($id = NULL)
    {
        if ($this->controller->checkSession()) {
             

            if($this->input->post('uploadFile')){
               $this->form_validation->set_rules('image', 'Image', 'callback_file_check');
            }
            
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('errors', validation_errors());
                
                $data['banners'] = $this->model->getAllwhere('banners');

                $data['body'] = 'add_banners';
                $this->controller->load_view($data);
            } else {
               
                $data  = array();
                if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], 'asset/uploads/' . $_FILES['image']['name'])) {
                        
                        $data['image'] = $_FILES['image']['name'];
                    }
                }

                if(!empty($data)){
                    $result = $this->model->insertData('banners', $data);
                }
               
                redirect('vendor/banners');
            }
        } else {
            redirect('vendor/index');
        }
    }

    public function shipping_rates($id = NULL)
    {
        if ($this->controller->checkSession()) {
             
            $this->form_validation->set_rules('from', 'Distance From', 'trim|required');
            $this->form_validation->set_rules('to', 'Distance From', 'trim|required');
            $this->form_validation->set_rules('rate', 'Shipping Rate', 'trim|required');
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('errors', validation_errors());
                
                $data['shipping_rates'] = $this->model->getAllwhere('shipping_master');

                $data['body'] = 'add_shipping_rates';
                $this->controller->load_view($data);
            } else {
                

                $from    = $this->input->post('from');
                $to      = $this->input->post('to');
                $rate    = $this->input->post('rate');


                $data  = array(
                    'from'  => $from,
                    'to'    => $to,
                    'rate'  => $rate
                );
                
                if(!empty($data)){
                    $result = $this->model->insertData('shipping_master', $data);
                }
               
                redirect('vendor/shipping_rates');
            }
        } else {
            redirect('vendor/index');
        }
    }

    public function file_check($str){
        $allowed_mime_type_arr = array('image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['image']['name']);
        if(isset($_FILES['image']['name']) && $_FILES['image']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('image', 'Please select only gif/jpg/png file.');
                return false;
            }
        }else{
            $this->form_validation->set_message('image', 'Please choose a file to upload.');
            return false;
        }
    }

 // ===============   end 
    public function builders_list()
    {
        if ($this->controller->checkSession()) {
            $data['builders'] = $this->model->getAllwhere('users',array('user_role'=>3));
            $data['body']       = 'builders_list';
            $this->controller->load_view($data);
        } else {
            redirect('vendor/index');
        }
    }
   

   public function leads()
    {
        if ($this->controller->checkSession()) {
            $data['leads'] = $this->model->GetJoinRecord('leads', 'entry_by', 'users', 'id', 'leads.*,users.username','');

            
            $data['body']       = 'leads_list';
            $this->controller->load_view($data);
        } else {
            redirect('vendor/index');
        }
    }

    public function view_leads($id){

        if ($this->controller->checkSession()) {
             $where = array(
                'leads.id' => $id
             ); 
             $data['leads'] = $this->model->GetJoinRecord('leads', 'entry_by', 'users', 'id', 'leads.*,users.username',$where);  
             $location = $data['leads'][0]->location;
             $data['state']  = array();
             if(!empty($location)){
                $location  = explode(",", $location);
                foreach ($location as $key => $value) {
                    $datas    = $this->model->getAllwhere('states',array('id'=>$value),'name');
                    if(!empty($datas)){
                        $data['state'][] = $datas[0];
                    }
                }
                
             }
             $data ['builders'] = $this->model->getAllwhere('users',array('user_role'=>3));
             $data['body']       = 'view_leads1';
             $this->controller->load_view($data);

        }else{
            redirect('vendor/index');
        }

    }

    public function verify_lead($id){
        if ($this->controller->checkSession()) {
                $data = $this->input->post();
                $where  = array(
                    'id' => $id
                );
                $table  = 'leads';
                $result = $this->model->updateFields($table, $data, $where);

                $this->view_leads($id);

        }else{
            redirect('vendor/index');
        }
    }

    public function assign_leads($id){
        if ($this->controller->checkSession()) {
                $data = $this->input->post();
                
                $where  = array(
                    'id' => $id
                );
                $table  = 'leads';
                $result = $this->model->updateFields($table, $data, $where);

                $this->view_leads($id);

        }else{
            redirect('vendor/index');
        }
    }


    public function size_range($id = NULL)
    {
        if ($this->controller->checkSession()) {
            
           
            $this->form_validation->set_rules('min_value', 'Minimum Value', 'trim|required');
            $this->form_validation->set_rules('max_value', 'Maximum Value', 'trim|required');
           
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('errors', validation_errors());
                if (!empty($id)) {
                    $where              = array(
                        'id ' => $id,
                        
                    );
                    $data['size_range'] = $this->model->getAllwhere('size_range', $where);
                }
                $data['body'] = 'size_range';
                $this->controller->load_view($data);
            } else {
                
                $min_value          = $this->input->post('min_value');
                $max_value          = $this->input->post('max_value');
                
                
                $data = array(
                    'min_value'      => $min_value,
                    'max_value'      => $max_value,
                    'created_at' => date('Y-m-d H:i:s'),
                );
                    
                
                if (!empty($id)) {
                    $where = array(
                        'id' => $id
                    );
                    unset($data['created_at']);
                   
                    $result = $this->model->updateFields('size_range', $data, $where);
                } else {
                    $result = $this->model->insertData('size_range', $data);
                }
                redirect('vendor/size_range_list');
            }
        } else {
            redirect('vendor/index');
        }
    }

    public function size_range_list()
    {
        if ($this->controller->checkSession()) {
            $data['size_range'] = $this->model->getAllwhere('size_range');
            $data['body']       = 'size_range_list';
            $this->controller->load_view($data);
        } else {
            redirect('vendor/index');
        }
    }



    public function budget_range($id = NULL)
    {
        if ($this->controller->checkSession()) {
            
           
            $this->form_validation->set_rules('min_value', 'Minimum Value', 'trim|required');
            $this->form_validation->set_rules('max_value', 'Maximum Value', 'trim|required');
           
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('errors', validation_errors());
                if (!empty($id)) {
                    $where              = array(
                        'id ' => $id,
                        
                    );
                    $data['budget_range'] = $this->model->getAllwhere('budget_range', $where);
                }
                $data['body'] = 'budget_range';
                $this->controller->load_view($data);
            } else {
                
                $min_value          = $this->input->post('min_value');
                $max_value          = $this->input->post('max_value');
                
                
                $data = array(
                    'min_value'      => $min_value,
                    'max_value'      => $max_value,
                    'created_at' => date('Y-m-d H:i:s'),
                );
                    
                
                if (!empty($id)) {
                    $where = array(
                        'id' => $id
                    );
                    unset($data['created_at']);
                   
                    $result = $this->model->updateFields('budget_range', $data, $where);
                } else {
                    $result = $this->model->insertData('budget_range', $data);
                }
                redirect('vendor/budget_range_list');
            }
        } else {
            redirect('vendor/index');
        }
    }

    public function budget_range_list()
    {
        if ($this->controller->checkSession()) {
            $data['budget_range'] = $this->model->getAllwhere('budget_range');
            $data['body']       = 'budget_range_list';
            $this->controller->load_view($data);
        } else {
            redirect('vendor/index');
        }
    }
   


    public function about_us($id = NULL)
    {
        if ($this->controller->checkSession()) {
            $this->form_validation->set_rules('about', 'About US', 'trim|required');
            
            
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('errors', validation_errors());
                
                 $data['about'] = $this->model->getAllwhere('about','');
                
                $data['body'] = 'about_us';
                $this->controller->load_view($data);
            } else {
                
                
                $about   = $this->input->post('about');
                
                $data = array(
                    'about'             => $about,
                    'created_at'        => date('Y-m-d H:i:s')
                );

                
                 $this->model->delete('about','1=1');
                $result = $this->model->insertData('about', $data);
                
                redirect('vendor/about_us');
            }
        } else {
            redirect('vendor/index');
        }
    }

        public function payment_options($id = NULL)
    {
        if ($this->controller->checkSession()) {
            $this->form_validation->set_rules('payment_options', 'Payment Options', 'trim|required');
            
            
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('errors', validation_errors());
                
                 $data['payment_options'] = $this->model->getAllwhere('payment_options','');
                
                $data['body'] = 'payment_options';
                $this->controller->load_view($data);
            } else {
                
                
                $payment_options   = $this->input->post('payment_options');
                
                $data = array(
                    'payment_options'             => $payment_options,
                    'created_at'        => date('Y-m-d H:i:s')
                );

                
                 $this->model->delete('payment_options','1=1');
                $result = $this->model->insertData('payment_options', $data);
                
                redirect('vendor/payment_options');
            }
        } else {
            redirect('vendor/index');
        }
    }


    public function terms_conditions($id = NULL)
    {
        if ($this->controller->checkSession()) {
            $this->form_validation->set_rules('terms_conditions', 'Terms & Condtions', 'trim|required');
            
            
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('errors', validation_errors());
                
                 $data['terms_conditions'] = $this->model->getAllwhere('terms_conditions','');
                
                $data['body'] = 'terms_conditions';
                $this->controller->load_view($data);
            } else {
                
                
                $terms_conditions   = $this->input->post('terms_conditions');
                
                $data = array(
                    'terms_conditions'             => $terms_conditions,
                    'created_at'        => date('Y-m-d H:i:s')
                );

                
                $this->model->delete('terms_conditions','1=1');
                $result = $this->model->insertData('terms_conditions', $data);
                
                redirect('vendor/terms_conditions');
            }
        } else {
            redirect('vendor/index');
        }
    }


    public function refund_policy($id = NULL)
    {
        if ($this->controller->checkSession()) {
            $this->form_validation->set_rules('refund_policy', 'Refund Policy', 'trim|required');
            
            
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('errors', validation_errors());
                
                 $data['refund_policy'] = $this->model->getAllwhere('refund_policy','');
                
                $data['body'] = 'refund_policy';
                $this->controller->load_view($data);
            } else {
                
                
                $refund_policy   = $this->input->post('refund_policy');
                
                $data = array(
                    'refund_policy'             => $refund_policy,
                    'created_at'        => date('Y-m-d H:i:s')
                );

                
                $this->model->delete('refund_policy','1=1');
                $result = $this->model->insertData('refund_policy', $data);
                
                redirect('vendor/refund_policy');
            }
        } else {
            redirect('vendor/index');
        }
    }

    public function privacy_policy($id = NULL)
    {
        if ($this->controller->checkSession()) {
            $this->form_validation->set_rules('privacy_policy', 'Privacy Policy', 'trim|required');
            
            
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('errors', validation_errors());
                
                 $data['privacy_policy'] = $this->model->getAllwhere('privacy_policy','');
                
                $data['body'] = 'privacy_policy';
                $this->controller->load_view($data);
            } else {
                
                
                $privacy_policy   = $this->input->post('privacy_policy');
                
                $data = array(
                    'privacy_policy'             => $privacy_policy,
                    'created_at'        => date('Y-m-d H:i:s')
                );

                
                $this->model->delete('privacy_policy','1=1');
                $result = $this->model->insertData('privacy_policy', $data);
                
                redirect('vendor/privacy_policy');
            }
        } else {
            redirect('vendor/index');
        }
    }

     public function contact_us($id = NULL)
    {
        if ($this->controller->checkSession()) {
            $this->form_validation->set_rules('contact_us', 'Contact Policy', 'trim|required');
            
            
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('errors', validation_errors());
                
                 $data['contact_us'] = $this->model->getAllwhere('contact_us','');
                
                $data['body'] = 'contact_us';
                $this->controller->load_view($data);
            } else {
                
                
                $contact_us   = $this->input->post('contact_us');
                
                $data = array(
                    'contact_us'             => $contact_us,
                    'created_at'        => date('Y-m-d H:i:s')
                );

                
                $this->model->delete('contact_us','1=1');
                $result = $this->model->insertData('contact_us', $data);
                
                redirect('vendor/contact_us');
            }
        } else {
            redirect('vendor/index');
        }
    }

    public function details($id = NULL)
    {
        if ($this->controller->checkSession()) {
            
            $this->form_validation->set_rules('company_name', 'Company name', 'trim|required');
            
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('errors', validation_errors());
                
                $data['details'] = $this->model->getAllwhere('details');
                $data['body'] = 'details';
                $this->controller->load_view($data);
            } else {
                $company_name   = $this->input->post('company_name');
               // $theme_color    = $this->input->post('theme_color');
                $lat            = $this->input->post('lat');
                $long           = $this->input->post('long');
                $gst_no         = $this->input->post('gst_no');
                $punch_line     = $this->input->post('punch_line');

                $data = array(
                    'company_name'          => $company_name,
                //    'theme_color'           => $theme_color,
                    'lat'                   => $lat,
                    'long'                  => $long,
                    'gst_no'                => $gst_no,
                    'punch_line'            => $punch_line,
                    'created_at'            => date('Y-m-d H:i:s')
                );


                if (isset($_FILES['logo']['name']) && !empty($_FILES['logo']['name'])) {
                    
                    if (move_uploaded_file($_FILES['logo']['tmp_name'], 'asset/uploads/' . $_FILES['logo']['name'])) {
                        
                        $data['logo'] = $_FILES['logo']['name'];
                    }
                }
                $id = $this->model->getAllwhere('details','','id');
                if(!empty($id)){
                    $detail_id = $id[0]->id;
                    $where = array(
                        'id' => $detail_id
                    );
                    unset($data['created_at']);
                    $result = $this->model->updateFields('details', $data, $where);
                }else {
                    $id = $this->model->insertData('details', $data);    
                }

                redirect('vendor/details');
            }
        } else {
            redirect('vendor/index');
        }
    }

   
    public function notification($id = NULL)
    {
        if ($this->controller->checkSession()) {
             

            $this->form_validation->set_rules('message', 'Notification Message', 'trim|required');

            $this->form_validation->set_rules('type', 'Notification Type', 'trim|required');
            
            $this->form_validation->set_rules('title', 'Notification Title', 'trim|required');
             
           
            
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('errors', validation_errors());
                
                $data['notification'] = $this->model->getAllwhere('notification');

                $data['body'] = 'notification';
                $this->controller->load_view($data);
            } else {
                $type      = $this->input->post('type');
                $title     = $this->input->post('title');
                $message   = $this->input->post('message');
                $data  = array(
                    'type'       => $type,
                    'title'      => $title,
                    'message'    => $message,
                    'created_at' => date('Y-m-d H:i:s')
                );

                if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], 'asset/uploads/' . $_FILES['image']['name'])) {
                        $data['image'] = $_FILES['image']['name'];
                    }
                }



                if(!empty($data)){
                    $result = $this->model->insertData('notification', $data);
                }

                $notification_array = array(
                    'title'   => $title,
                    'type'    => $type,
                    'message' => $message,
                    'image'   => isset($data['image']) ? base_url()."asset/uploads/".$data['image'] : ''
                );
                $get_fcm_token  = $this->model->getAllwhere('users',array('device_token!=' => null),'device_token');
                if(!empty($get_fcm_token)){
                    foreach ($get_fcm_token as $key => $value) {
                        $token[] =  $value->device_token;
                    }
                    $this->model->sendPushNotification($notification_array,$token);
                }
                redirect('vendor/notification');
            }
        } else {
            redirect('vendor/index');
        }
    }
   
   
        /**

    * Manage uploadImage

    *

    * @return Response

   */

   public function resizeImage($filename){
        if(!defined("UPLOAD_DIR1")){
            define('UPLOAD_DIR1', 'asset/uploads/');
        }
        $source_path = UPLOAD_DIR1 . $filename;

        $target_path = UPLOAD_DIR1 . 'thumbnail/';

        $config_manip = array(
              'image_library' => 'gd2',
              'source_image' => $source_path,
              'new_image' => $target_path,
              'maintain_ratio' => FALSE,
              'create_thumb' => TRUE,
              'thumb_marker' => '',
              'width' => 150,
              'height' => 150
          );
         $this->image_lib->initialize($config_manip);

          //$this->load->library('image_lib', $config_manip);
          if (!$this->image_lib->resize()) {
              echo $this->image_lib->display_errors();
          }

         
         $this->image_lib->clear();
   }


    public function reports()
    {
        if ($this->controller->checkSession()) {
            $data['order_list'] =  $this->model->GetJoinRecord('orders', 'user_id', 'users', 'id', 'orders.*,users.username,users.phone_no','','','id','ASC');


            if(!empty($data['order_list'])){
                foreach ($data['order_list'] as $key => $value) {
                    $order_id   = $value->id;
                   
                    $order_items       =  $this->model->getAllwhere('orders_items',array('order_id'=>$order_id));
                    $value->order_items = $order_items;
                }
            }
           
            $data['body']       = 'report_list';
            $this->controller->load_view($data);
        } else {
            redirect('vendor/index');
        }
    }

    public function report_by_item()
    {
        if ($this->controller->checkSession()) {
            $data['order_list'] =  $this->model->GetJoinRecord('orders_items', 'order_id', 'orders', 'id', 'orders_items.*,orders.user_id,orders.address,orders.created_at,orders.status','','','id','ASC');


            if(!empty($data['order_list'])){
                foreach ($data['order_list'] as $key => $value) {
                    $user_id   = $value->user_id;
                   
                    $user_name       =  $this->model->getAllwhere('users',array('id'=>$user_id),'username,phone_no');

                   
                    $value->username = isset($user_name)? $user_name[0]->username :'';
                    $value->phone_no = isset($user_name)? $user_name[0]->phone_no :'';
                }
            }
           
            $data['body']       = 'report_by_item';
            $this->controller->load_view($data);
        } else {
            redirect('vendor/index');
        }
    }


    public function version($id = NULL)
    {
            if ($this->controller->checkSession()) {
            
            
            $this->form_validation->set_rules('version_code', 'Version Code', 'trim|required');
            $this->form_validation->set_rules('version_name', 'Version Name', 'trim|required');
                        
            if ($this->form_validation->run() == false) {
                
                $this->session->set_flashdata('errors', validation_errors());
                
                $data['version'] = $this->model->getAllwhere('app_version_history');
                $data['body'] = 'version';
                $this->controller->load_view($data);
            } else {
                
                $version_code    = $this->input->post('version_code');
                $version_name     = $this->input->post('version_name');

                $data = array(
                    'versioncode'           => $version_code,
                    'versionname'            => $version_name,
                    'created_at'            => date('Y-m-d H:i:s')
                );

                // $id = $this->model->getAllwhere('app_version_history','','id');
                $id = $this->model->insertData('app_version_history', $data);    

                redirect('vendor/version');
            }
        } else {
            redirect('vendor/index');
        }
    }



    public function app_theme($id = NULL)
    {
        if ($this->controller->checkSession()) {
            
            $this->form_validation->set_rules('theme_color', 'THEME COLOR', 'trim|required');
            
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('errors', validation_errors());
                
                $data['app_theme'] = $this->model->getAllwhere('details');
                $data['body'] = 'app_theme';
                $this->controller->load_view($data);
            } else {
                $theme_color    = $this->input->post('theme_color');
                
                $data = array(
                    'theme_color'           => $theme_color,
                    'created_at'            => date('Y-m-d H:i:s')
                );

                $id = $this->model->getAllwhere('details','','id');
                if(!empty($id)){
                    $detail_id = $id[0]->id;
                    $where = array(
                        'id' => $detail_id
                    );
                    unset($data['created_at']);
                    $result = $this->model->updateFields('details', $data, $where);
                }else {
                    $id = $this->model->insertData('details', $data);    
                }

                redirect('vendor/app_theme');
            }
        } else {
            redirect('vendor/index');
        }
    }


    public function test(){
        $post_fields  = array(
  'orderId'       => 'ORDER_11',
  'orderAmount'   => '500',
  'orderCurrency' => 'INR'
);



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://test.cashfree.com/api/v2/cftoken/order",
  CURLOPT_RETURNTRANSFER => true,
  //CURLOPT_ENCODING => "",
  //CURLOPT_MAXREDIRS => 10,
  //CURLOPT_TIMEOUT => 30,
  //CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode($post_fields),
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "x-client-id: 167286af2ee404367248b9c9582761",
    "x-client-secret: 1a8e231be6b729bd41a656d85f44bcc605f0399e"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}

    }


    public function login_settings($id = NULL)
    {
        if ($this->controller->checkSession()) {
            
            $this->form_validation->set_rules('login_type', 'Login Type', 'trim|required');
            
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('errors', validation_errors());
                
                $data['login_settings'] = $this->model->getAllwhere('login_settings');
                $data['body'] = 'login_settings';
                $this->controller->load_view($data);
            } else {
                $login_type   = $this->input->post('login_type');
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
                    'created_at'        => date('Y-m-d H:i:s')
                );

                $id = $this->model->getAllwhere('login_settings','','id');
                if(!empty($id)){
                    $login_settings_id = $id[0]->id;
                    $where = array(
                        'id' => $login_settings_id
                    );
                    unset($data['created_at']);
                    $result = $this->model->updateFields('login_settings', $data, $where);
                }else {
                    $id = $this->model->insertData('login_settings', $data);    
                }

                redirect('vendor/login_settings');
            }
        } else {
            redirect('vendor/index');
        }
    }


    public function sms_settings($id = NULL)
    {
            if ($this->controller->checkSession()) {
            
            
            $this->form_validation->set_rules('sender_id', 'Sender Id', 'trim|required');
            $this->form_validation->set_rules('auth_key', 'Auth Key', 'trim|required');
            
            $this->form_validation->set_rules('message', 'Message', 'trim|required');
           
            $this->form_validation->set_rules('url', 'URL', 'trim|required');
           
            if ($this->form_validation->run() == false) {
                
                $this->session->set_flashdata('errors', validation_errors());
                if (!empty($id)) {
                    $where              = array(
                        'id ' => $id,
                    );
                    $data['sms_settings'] = $this->model->getAllwhere('sms_settings', $where);
                    
                }  
              
                $data['body'] = 'sms_settings';
                $this->controller->load_view($data);
            } else {
               
                $type       = $this->input->post('type');
                $status     = !empty($this->input->post('status')) ? $this->input->post('status') : 0;
                $sender_id  = $this->input->post('sender_id');
                $auth_key   = $this->input->post('auth_key');
                $url        = $this->input->post('url');
                $message    = $this->input->post('message');


                $data = array(
                    'type'          => $type,
                    'status'        => $status,
                    'sender_id'     => $sender_id,
                    'auth_key'      => $auth_key,
                    'message'       => $message,
                    'status'        => $status,
                    'url'           => $url,
                    'created_at'    => date('Y-m-d H:i:s')
                );

                // $id = $this->model->getAllwhere('app_version_history','','id');
                if (!empty($id)) {
                    $where = array(
                        'id' => $id
                    );
                    unset($data['created_at']);
                   
                    $result = $this->model->updateFields('sms_settings', $data, $where);
                } else {
                    $where  = array('type'=>$type);
                    $check  = $this->model->getAllwhere('sms_settings',$where,'id');
                    if(empty($check)){
                        $result = $this->model->insertData('sms_settings', $data);
                    }else{
                        $result = $this->model->updateFields('sms_settings', $data, $where);
                    }
                }

                redirect('vendor/sms_settings_list');
            }
        } else {
            redirect('vendor/index');
        }
    }

    public function sms_settings_list($user_role = NULL)
    {
        if ($this->controller->checkSession()) {
        
        $data['sms_settings'] = $this->model->getAllwhere('sms_settings');
        $data['body']  = 'sms_settings_list';
        
        $this->controller->load_view($data);
        }else {
            redirect('vendor/index');
        }
    }

    public function payment_settings($id = NULL)
    {
        if ($this->controller->checkSession()) {
            
            $this->form_validation->set_rules('client_id', 'Client ID', 'trim|required');

            $this->form_validation->set_rules('client_secret', 'Client Secret', 'trim|required');
            
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('errors', validation_errors());
                
                $data['payment_settings'] = $this->model->getAllwhere('payment_master');
                $data['body'] = 'payment_settings';
                $this->controller->load_view($data);
            } else {
                $client_id       = $this->input->post('client_id');
                $client_secret   = $this->input->post('client_secret');
                $status     = !empty($this->input->post('status')) ? $this->input->post('status') : 0;
                

                $data = array(
                    'client_id'          => $client_id,
                    'client_secret'      => $client_secret,
                    'status'             => $status,
                    'created_at'         => date('Y-m-d H:i:s')
                );

                $id = $this->model->getAllwhere('payment_master','','id');
                if(!empty($id)){
                    $detail_id = $id[0]->id;
                    $where = array(
                        'id' => $detail_id
                    );
                    unset($data['created_at']);
                    $result = $this->model->updateFields('payment_master', $data, $where);
                }else {
                    $id = $this->model->insertData('payment_master', $data);    
                }

                redirect('vendor/payment_settings');
            }
        } else {
            redirect('vendor/index');
        }
    }

    public function wallet_details($id = NULL)
    {
            if ($this->controller->checkSession()) {
            
            
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_rules('valid_from', 'Valid From', 'trim|required');
            
            $this->form_validation->set_rules('valid_to', 'Valid To', 'trim|required');
           
           
            if ($this->form_validation->run() == false) {
                
                $this->session->set_flashdata('errors', validation_errors());
                if (!empty($id)) {
                    $where              = array(
                        'id ' => $id,
                    );
                    $data['wallet_details'] = $this->model->getAllwhere('wallet_details', $where);
                    
                }  
              
                $data['body'] = 'wallet_details';
                $this->controller->load_view($data);
            } else {
               
                $wallet_type   = $this->input->post('wallet_type');
                $status        = !empty($this->input->post('status')) ? $this->input->post('status') : 0;
                $valid_from    = $this->input->post('valid_from');
                $valid_to      = $this->input->post('valid_to');
                $amount        = $this->input->post('amount');
                $redeem_per    = $this->input->post('redeem_per');
                $valid_upto    = $this->input->post('valid_upto');
                $data = array(
                    'wallet_type'   => $wallet_type,
                    'status'        => $status,
                    'valid_from'    => $valid_from,
                    'valid_to'      => $valid_to,
                    'amount'        => $amount,
                    'redeem_per'    => $redeem_per,
                    'valid_upto'    => $valid_upto,
                    'created_at'    => date('Y-m-d H:i:s')
                );

                // $id = $this->model->getAllwhere('app_version_history','','id');
                if (!empty($id)) {
                    $where = array(
                        'id' => $id
                    );
                    unset($data['created_at']);
                   
                    $result = $this->model->updateFields('wallet_details', $data, $where);
                } else {
                    $result = $this->model->insertData('wallet_details', $data);
                }

                redirect('vendor/wallet_details_list');
            }
        } else {
            redirect('vendor/index');
        }
    }

    public function wallet_details_list($user_role = NULL)
    {
        if ($this->controller->checkSession()) {
        
        $data['wallet_details'] = $this->model->getAllwhere('wallet_details');
        $data['body']  = 'wallet_details_list';
        
        $this->controller->load_view($data);
        }else {
            redirect('vendor/index');
        }
    }

    public function settings_masters($id = NULL)
    {
        if ($this->controller->checkSession()) {
            
           

             $this->form_validation->set_rules('default_Value', 'Home Delivery', 'trim|required');
            
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('errors', validation_errors());
                
                $data['settings_masters'] = $this->model->getAllwhere('settings_masters');
                $data['body'] = 'settings_master';
                $this->controller->load_view($data);
            } else {

                $cash_on_delivery      = !empty($this->input->post('cash_on_delivery')) ? $this->input->post('cash_on_delivery') : 0;
                $self_pickup           = !empty($this->input->post('self_pickup')) ? $this->input->post('self_pickup') : 0;
                $home_delivery         = !empty($this->input->post('home_delivery')) ? $this->input->post('home_delivery') : 0;
               
                $settings  = array(
                    'cash_on_delivery','self_pickup','home_delivery');
                $insert_data  = array();
                foreach ($settings as $key => $value) {
                    $check_key  = $this->model->getAllwhere('settings_masters',array('name'=>$value));
                    if(!empty($check_key)){
                        $data_value  = $$value;
                        $update_data  = array('value'=> $data_value);
                        $update_where = array('name'=> $value);
                        $this->model->updateFields('settings_masters', $update_data, $update_where);
                    }else{
                        $data_value  = $$value;
                        $insert_data[] = array(
                            'name'          => $value,
                            'value'         => $data_value,
                            'created_at'    => date('Y-m-d H:i:s')
                        );
                    }
                }
                if(!empty($insert_data)){
                    $this->model->insertBatch('settings_masters',$insert_data);
                }
                redirect('vendor/settings_masters');
            }
        } else {
            redirect('vendor/index');
        }
    }

    public function firebase_key($id = NULL){
        if ($this->controller->checkSession()) {
            
           $this->form_validation->set_rules('firebase_key', 'Firebase key', 'trim|required');
            
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('errors', validation_errors());
                $where = array('name'=>'firebase_key');
                $data['firebase_key'] = $this->model->getAllwhere('settings_masters',$where);
                $data['body'] = 'firebase_key';
                $this->controller->load_view($data);
            } else {

                $firebase_key      = !empty($this->input->post('firebase_key')) ? $this->input->post('firebase_key') : 0;
                
                $check_key  = $this->model->getAllwhere('settings_masters',array('name'=>'firebase_key'));
                if(!empty($check_key)){
                    $update_data  = array('value'=> $firebase_key);
                    $update_where = array('name'=> 'firebase_key');
                    $this->model->updateFields('settings_masters', $update_data, $update_where);
                }else{
                    $insert_data  = array(
                        'name'      => 'firebase_key',
                        'value'     => $firebase_key,
                        'created_at'    => date('Y-m-d H:i:s')
                    );

                    $this->model->insertData('settings_masters',$insert_data);
                }
                
                redirect('vendor/firebase_key');
            }
        } else {
            redirect('vendor/index');
        }   
    }
    
}