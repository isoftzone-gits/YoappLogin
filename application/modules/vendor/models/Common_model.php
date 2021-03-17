<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_model extends CI_Model
{
    
   
    function GetJoinedRecord($where=null){
        $query = $this->db->query("SELECT product.*,category.category_name,sub_category.sub_cat_name from product left join category ON product.category_id = category.id LEFT JOIN sub_category ON product.sub_cat_id  =sub_category.id $where");
        return $query->result_array();
    }

    function get_yearly_sale(){
    		 $query = $this->db->query('SELECT 
    SUM(IF(month = "Jan", total, 0)) AS "Jan",
    SUM(IF(month = "Feb", total, 0)) AS "Feb",
    SUM(IF(month = "Mar", total, 0)) AS "Mar",
    SUM(IF(month = "Apr", total, 0)) AS "Apr",
    SUM(IF(month = "May", total, 0)) AS "May",
    SUM(IF(month = "Jun", total, 0)) AS "Jun",
    SUM(IF(month = "Jul", total, 0)) AS "Jul",
    SUM(IF(month = "Aug", total, 0)) AS "Aug",
    SUM(IF(month = "Sep", total, 0)) AS "Sep",
    SUM(IF(month = "Oct", total, 0)) AS "Oct",
    SUM(IF(month = "Nov", total, 0)) AS "Nov",
    SUM(IF(month = "Dec", total, 0)) AS "Dec"
    
    FROM (
SELECT DATE_FORMAT(created_at, "%b") AS month, COUNT(id) as total
FROM orders
WHERE created_at <= NOW() and created_at >= Date_add(Now(),interval - 12 month)
GROUP BY DATE_FORMAT(created_at, "%m-%Y")) as sub');
        return $query->result_array();
    }
}
