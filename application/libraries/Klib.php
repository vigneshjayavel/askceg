<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Klib {

	public function processTime($timestamp){//todo
				
		$post_timestamp=$timestamp; //normal GMT UTC from record
		$timezone = 'UP55'; //for IST
		$daylight_saving = FALSE;
		//to test the format
		$datestringFormat = "%h:%i %a - %d %M %Y";
		$post_timestamp_ist=gmt_to_local($post_timestamp, $timezone, $daylight_saving);
		$timeObj['postedDatestring']=mdate($datestringFormat,$post_timestamp_ist);
		$now_ist = gmt_to_local(time(), $timezone, $daylight_saving);
		$timeObj['timeElapsed']=timespan($post_timestamp_ist, $now_ist);
		return $timeObj;
		
	}

	public function generateNotifications($receiver_id,$receiver_type,$notif_msg,$emailData=null){

		$CI =& get_instance();
	    $CI->load->model('notificationsmodel');
		$CI->notificationsmodel->sqlcreateMasterNotifications($receiver_id,$receiver_type,$notif_msg);
		if($emailData!=null){
			$this->sendMail($emailData);	
		}
	}

	public function getUserData($user_id){
		$userData=array();
		$CI=& get_instance();
		$sql="select user_name,email_id from USERS where user_id=?";
        $query=$CI->db->query($sql,array($user_id)); 
        $row=$query->row_array();
        $userData['email_id']=$row['email_id'];
        $userData['user_name']=$row['user_name'];
        return $userData;
	}
	public function sendMail($emailData){  

	  /*
	    Mail Server Username: no-reply+pinnacleceg.com
	    Incoming Mail Server: mail.pinnacleceg.com
	    Incoming Mail Server: (SSL) box562.bluehost.com
	    Outgoing Mail Server: mail.pinnacleceg.com (server requires authentication) port 26
	    Outgoing Mail Server: (SSL) box562.bluehost.com (server requires authentication) port 465
	    Supported Incoming Mail Protocols: POP3, POP3S (SSL/TLS), IMAP, IMAPS (SSL/TLS)
	    Supported Outgoing Mail Protocols: SMTP, SMTPS (SSL/TLS)
	    */
	    
	    /* Email configuration */
	    /*$config = Array(
	        'protocol' => 'smtp',
	        'smtp_host' => 'mail.pinnacleceg.com',
	        'smtp_port' => 26,
	        'smtp_user' => 'no-reply@pinnacleceg.com',
	        'smtp_pass' => 'Pinnacle2013', 
	        'mailtype' => 'html',
	        'charset' => 'iso-8859-1',
	        'wordwrap' => TRUE
	    );  
	  	*/
	    $config = Array(
	        'smtp_user' => 'admin@askceg.krk.org.in',
	        'smtp_pass' => '22091991',
	        'protocol'=>'smtp',
			'smtp_host'=>'mail.askceg.krk.org.in',
			'smtp_port'=>'587',
			'smtp_timeout'=>'30',  
			'charset'=>'utf-8',   
	        'mailtype' => 'html',
			'newline'=>"\r\n"
	    );  
/*
		$config = Array(
	        'smtp_user' => 'askceg.in@gmail.com',
	        'smtp_pass' => 'whythiskolaveri',
	        'protocol'=>'smtp',
			'smtp_host'=>'ssl://smtp.googlemail.com',
			'smtp_port'=>'465',
			'smtp_timeout'=>'30',  
			'charset'=>'utf-8',   
	        'mailtype' => 'html',
			'newline'=>"\r\n"
	    );
*/		
		$CI =& get_instance();
	    $CI->load->library('email', $config);
	    $CI->email->from('admin@askceg.krk.org.in', "AskCEG");
	    $CI->email->to($emailData['to']);
	    $CI->email->subject($emailData['subject']);
	    $CI->email->message($emailData['message']);
	    try{
	   		$CI->email->send();
	    }
	    catch(Exception $e){
	    	echo $e->getMessage();
	    }
	   
	}

function fbpost($title,$message,$description,$link,$image,$kid)
{
	
	$CI=&get_instance();
	$db=$CI->load->database('default',TRUE);
	$q="select user_id from p_pid_email where kid='$kid'";
	$r=$db->query($q);
	if($r->num_rows()==1)
	{
		$row=$r->row();
		$user=$row->user_id;
		$q1="select access_token from fb_details where fb_user_id='$user'";
		$r1=$db->query($q1);
		if($r1->num_rows()==1)
		{
			$row1=$r1->row();
			$token=$row1->access_token;
			try {
				$config['appId'] = FB_APPID;
				$config['secret'] = FB_SECRET;
				$config['cookie'] = true;
				$CI->load->library('facebook-source/facebook',$config);
				$facebook = new Facebook(array(
					'appId'  => FB_APPID,
					'secret' => FB_SECRET,
					));
				
				$publishStream = $facebook->api("/$user/feed", 'post', array(
					'access_token' => $token,
					'message' => $message,
					'link'    => $link,
					'picture' => $image,
					'name'    => $title,
					'description'=> $description
					)
				);
				return 1;
			} catch (FacebookApiException $e) {
				return 0;
			} 	
		}
		else
			return 0;
	}
	else
		return 0;
}

public function generate($seqid)
{
	$key=array('G','Q','A','Z','W','S','P','E','D','C','R','V','T');
	$prefix="K12";
	$i=1;
	$index0=0;
	$index1=0;
	$index2=0;
	$index3=0;
	while(1)
	{
		if($i==$seqid)
			break;
		if($index3<(count($key)-1))
			$index3++;
		else
		{
			$index3=0;
			if($index2<(count($key)-1))
				$index2++;
			else
			{
				$index2=0;
				if($index1<(count($key)-1))
					$index1++;
				else
				{
					$index1=0;
					if($index0<(count($key)-1))
						$index0++;
				}
			}
		}
/*		$current[$level]=$key[++$index];
		if($index==(count($key)-1))
		{
		$level=$level-1;
		
		$j=3;
		while($j>$level)
		{
		$current[$j]=$key[0];
		$j--;
		}
		
		}
		*/
		$i++;
	}
	return $prefix.$key[$index0].$key[$index1].$key[$index2].$key[$index3];
}
	public function fb_generate($seqid)
	{
		$key=array('F','B','Y','H','N','M','U','J','I','K','L','O','X');
		$prefix="a13";
		$i=1;
		$index0=0;
		$index1=0;
		$index2=0;
		$index3=0;
		while(1)
		{
			if($i==$seqid)
				break;
			if($index3<(count($key)-1))
				$index3++;
			else
			{
				$index3=0;
				if($index2<(count($key)-1))
					$index2++;
				else
				{
					$index2=0;
					if($index1<(count($key)-1))
						$index1++;
					else
					{
						$index1=0;
						if($index0<(count($key)-1))
							$index0++;
					}
				}
			}
	/*		$current[$level]=$key[++$index];
			if($index==(count($key)-1))
			{
			$level=$level-1;
			
			$j=3;
			while($j>$level)
			{
			$current[$j]=$key[0];
			$j--;
			}
			
			}
			*/
			$i++;
		}
		return $prefix.$key[$index0].$key[$index1].$key[$index2].$key[$index3];
	}


}
?>
