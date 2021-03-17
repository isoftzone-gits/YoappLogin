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

    public function get_rank($table,$id){
        $query = "SELECT id, user_id, total_marks, FIND_IN_SET( total_marks, (    
                  SELECT GROUP_CONCAT( total_marks
                  ORDER BY total_marks DESC ) 
                  FROM $table )
                  ) AS rank
                  FROM $table
                  WHERE user_id =  '$id'";

        $rank  = $this->db->query($query)->result_array();

        return $rank;
    }


    public function get_product($table,$key){
        $query = "SELECT id,category_id,sub_cat_id,product_name,product_description,product_image,stock,status FROM $table WHERE product_name LIKE  '%$key%' AND status=1;";

        $rank  = $this->db->query($query)->result_array();

        return $rank;
    }

    // public function get_shipping_rate($distance){
    //     $sql = "SELECT IF(a.val BETWEEN tv.from AND tv.to, tv.rate,'') AS result
    //           FROM (
    //           SELECT $distance AS val) a
    //           JOIN shipping_master as tv ";

    //     $data  = $this->db->query($sql)->result_array();

    //     $temp = array_map(function ($ar) {return $ar['result'];}, $data);
       
    //     $result  = array_filter($temp);
    //     return !empty($result[0])?$result[0]:0;

    // }

    public function get_shipping_rate($distance){
        $sql = "SELECT IF(a.val BETWEEN tv.from AND tv.to, tv.rate,'') AS result
              FROM (
              SELECT $distance AS val) a
              JOIN shipping_master as tv ";

        $data  = $this->db->query($sql)->result_array();
       
        $rate = 0;
        if(!empty($data)){
          foreach ($data as $key => $value) {
            if(!empty($value['result'])){
              $rate  = $value['result'];
              break;
            }
          }
        }
        // echo "<pre>";
        // print_r($data)
        // $temp = array_map(function ($ar) {return $ar['result'];}, $data);
       
        // $result  = array_filter($temp);
        
        return !empty($rate)?$rate:0;

    }
    
    public function category($data)
    {
      $this->db->insert('category',$data);
          return $this->db->insert_id();
          
    }

    public function update_category($data,$id)
    {
      $this->db->where('id', $id);
      $update = $this->db->update('category', $data);
    }

 
    public function banners($insert_data)
    {
      $this->db->insert('banners',$insert_data);
          return $this->db->insert_id();
    }

    public function update_banners($insert_data,$id)
    {
      $this->db->where('id', $id);
      $update = $this->db->update('banners', $insert_data);
    }
   
    public function subcategory($data)
    {
      
      $this->db->insert('sub_category',$data);
      return $this->db->insert_id();
    }

    public function update_subcategory($data,$id)
    {
      $this->db->where('id', $id);
      $update = $this->db->update('sub_category', $data);
    }

    public function product($data)
    {
      
      $this->db->insert('product',$data);
      return $this->db->insert_id();
    }

    public function update_product($data,$id)
    {
      $this->db->where('id', $id);
      $update = $this->db->update('product', $data);
    }

    //Model for vender
 public function vender()
 {

    $query = $this->db->query("SELECT * from users where user_role = 3");
    return $query->result();

 }

public function insert_vender($data)
{
 $this->db->insert('vender_permission',$data);
 return $this->db->insert_id();
}


// public function insertBatch($data)
// {
 
//   $this->db->insert_batch('product_attributes', $data);
//         return $this->db->insert_id();

// }

function profile($table)
{
  $query = $this->db->query("SELECT  id,$table as about from $table");
  return $query->result();
}

public function sequence_update($query)
{
  $res = $this->db->query($query);
  return $res;
}

public function get_data($number)
{
  $query = $this->db->query("SELECT * from company_master where phone_no = '$number'");
  return $query->result();
}
   

}

