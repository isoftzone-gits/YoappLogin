<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once "vendor/autoload.php";
// ------------------------------------------------------------------------

if ( ! function_exists('send_smtp_mail'))
{
	function send_smtp_mail($recipient, $subject, $message, $doc)
	{

        $mail = new PHPMailer;
        //Enable SMTP debugging. 
       // $mail->SMTPDebug = 2;
        //Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';
        //Set PHPMailer to use SMTP.
        $mail->isSMTP();            
        //Set SMTP host name                          
        $mail->Host = "webmail.yoappstore.com";
        //Set this to true if SMTP host requires authentication to send email
        $mail->SMTPAuth = true;
        //Provide username and password     
        /*$mail->Username = "ibill.support@isoftzone.com";                 
        $mail->Password = "isoft@1209";*/                           
        $mail->Username = "noreply@yoappstore.com";                 
        $mail->Password = "isoft@1209ISZ";
        //If SMTP requires TLS encryption then set it
        //$mail->SMTPSecure = "tls";                           
        //Set TCP port to connect to 
        $mail->Port = 25;  
       // $mail->SMTPDebug=2;                                 
        
        $mail->From = "noreply@yoappstore.com";
        $mail->FromName = 'YoApp Support Team';
        
        $mail->addAddress($recipient);
        
        $mail->isHTML(true);
        
        $mail->Subject = $subject;
        $mail->Body = $message;
        if($doc)
        {
            $mail->addAttachment($doc);
        }
        
        //$mail->AltBody = "This is the plain text version of the email content";
        
        if(!$mail->send()) 
        {
            return false;
           // echo "Mailer Error: " . $mail->ErrorInfo;
        } 
        else 
        {
            return true;//"Message has been sent successfully";
        }
		
	}
}

if ( ! function_exists('send_smtp_mail_to_support'))
{
    function send_smtp_mail_to_support($recipient, $subject, $message, $from, $name)
    {

        $mail = new PHPMailer;
        //Enable SMTP debugging. 
        //$mail->SMTPDebug = 2;
        //Ask for HTML-friendly debug output
        //$mail->Debugoutput = 'html';
        //Set PHPMailer to use SMTP.
        $mail->isSMTP();            
        //Set SMTP host name                          
        $mail->Host = "webmail.isoftzone.com";
        //Set this to true if SMTP host requires authentication to send email
        $mail->SMTPAuth = true;
        //Provide username and password     
        $mail->Username = "ibill.support@isoftzone.com";                 
        $mail->Password = "isoft@1209";                           
        //If SMTP requires TLS encryption then set it
        //$mail->SMTPSecure = "tls";                           
        //Set TCP port to connect to 
        $mail->Port = 25;                                   
        
        $mail->From = $from;
        $mail->FromName = $name.' i-Bill Support From Portal';
        
        $mail->addAddress($recipient);
        
        $mail->isHTML(true);
        
        $mail->Subject = $subject;
        $mail->Body = $message;
        //$mail->AltBody = "This is the plain text version of the email content";
        
        if(!$mail->send()) 
        {
            return false;//"Mailer Error: " . $mail->ErrorInfo;
        } 
        else 
        {
            return true;//"Message has been sent successfully";
        }
        
    }
}


if ( ! function_exists('get_mail'))
{
	function get_mail($userid)
	{
        $ci =& get_instance();
        $ci->load->database();
        
        $ci->db->select('email,firm_name,username');
        $ci->db->from('user');
        $ci->db->where('id',$userid);
        $query = $ci->db->get();
        return $query->row();
    }    
}

function get_request_subject($reqid)
	{
        $ci =& get_instance();
        $ci->load->database();
        
        $ci->db->select('*');
        $ci->db->from('request');
        $ci->db->where('id',$reqid);
        $query = $ci->db->get();
        return $query->row();
    }
	
function get_assign($reqid)
	{
        $ci =& get_instance();
        $ci->load->database();
        
        $ci->db->select('a.*,u.username');
        $ci->db->from('assign_task as a');
		$ci->db->join('user as u','a.assign_to=u.id','LEFT');
        $ci->db->where('a.request_id',$reqid);
        $query = $ci->db->get();
        return $query->result();
    }  
