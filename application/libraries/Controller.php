<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controller
{
    
    var $CI;
    public function __construct($params = array())
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->config->item('base_url');
        $this->CI->load->library('session', 'form_validation');
        $this->CI->load->database();   

    }
    
    public function verifylogin($data)
    {
        if ($data) {
            $this->CI->form_validation->set_rules('username', 'username', 'trim|required');
            $this->CI->form_validation->set_rules('password', 'password', 'trim|required|callback_check_database');
            $name  = $this->CI->model->getAllwhere('details','','company_name,logo');
                        if(!empty($name)){
                            $data['name'] = $name[0]->company_name;
                            $data['logo']   = $name[0]->logo;
                        }
            if ($this->CI->form_validation->run() == false) {
                $this->CI->load->view('login',$data);
            } else {
                
                if ($this->checkSession()) {
                    $log = $this->CI->session->userdata['user_role'];
                    if ($log == 1) {
                        redirect('admin/dashboard');
                    } else if ($log == 3) {
                        redirect('admin/dashboard');
                    }else if ($log == 4) {
                        redirect('admin/dashboard');
                    }else if ($log == 5) {
                        redirect('vendor/category_list');
                    }else {

                        $data['msg'] = 'You are not authorized';
                        $this->CI->load->view('login',$data);
                    } 
                }
            }
        }
    }
    
    public function checkSession()
    {
        if (!empty($this->CI->session->userdata('user_role'))) {
            $log = $this->CI->session->userdata('user_role');
            if (!empty($log)) {
                return true;
            } else {
                return false;
            }
        }
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
    
    public function load_view($page_data)
    {
        $this->CI->load->view('common/templates/default', $page_data);
    }

    public function load_view1($page_data)
    {
        $this->CI->load->view('common/templates1/default', $page_data);
    }

    function check_required_value($chk_params, $converted_array) {
        foreach ($chk_params as $param) {

            if (array_key_exists($param, $converted_array) && ($converted_array[$param] != '')) {

                $check_error = 0;

            } else {

                $check_error = array('check_error' => 1, 'param' => $param);

                break;

            }

        }

        return $check_error;

    }
}