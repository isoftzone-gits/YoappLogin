<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Common_model extends CI_Model

{

    public function self_join_records($comment_id){
        $this->db->select('*');
        $this->db->from('post_comment T1,post_comment T2');
        $this->db->where('T1.id = '.$comment_id.' and T2.comment_id = '.$comment_id);
        $q = $this->db->get();
        return $q->result_array();
    }

   
   

}

