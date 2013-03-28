<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Klib {
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
		
		$CI =& get_instance();
	    $CI->load->library('email', $config);
	    $CI->email->from('askceg.in@gmail.com', "AskCEG");
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
	function getcollege($x)
	{
		$con = mysql_connect("mysql.kurukshetra.org.in", "k12_admin", "this1is2absolute3nonsense") or die("Cannot connect to database:".mysql_error());
		mysql_select_db("kuruk12",$con);
		$q="select * from k_registration_info where kid='$x'";
		$r=mysql_query($q,$con);
		
		if(mysql_num_rows($r)==1)
		{
			
			$rr=mysql_fetch_array($r);
			$acc=$rr['acctype'];
			$email=$rr['email'];
			if(strcmp($acc,"college")==0)
				{$tb="k_college_student";
			$fl=1;
		}
		else if(strcmp($acc,"corporate")==0)
			{$tb="k_corporate";
		$fl=2;
	}
	else if(strcmp($acc,"faculty")==0)
		{$tb="k_faculty";
	$fl=3;
}
else if(strcmp($acc,"school")==0)
{
	$tb="k_school_student";
	$fl=4;
}
if($fl==1)
{
	$qq="select * from ".$tb." where email='$email'";
	$qr=mysql_query($qq,$con);
	$qrr=mysql_fetch_array($qr);
	
	$coll=$qrr['college'];

	$q1="select * from coll_list where coll_id='$coll'";
	
	$r1=mysql_query($q1,$con);
	
	$rr1=mysql_fetch_array($r1);

	return $rr1['coll_name'];
}
else if($fl==2)
{
	$qq="select * from ".$tb." where email='$email'";
	$qr=mysql_query($qq,$con);
	$qrr=mysql_fetch_array($qr);
	
	$com=$qrr['company'];
	return $com;
}
else if($fl==3)
{
	$qq="select * from ".$tb." where email='$email'";
	$qr=mysql_query($qq,$con);
	$qrr=mysql_fetch_array($qr);

	$coll=$qrr['college'];

	$q1="select * from coll_list where coll_id='$coll'";
	
	
	$r1=mysql_query($q1,$con);
	
	
	$rr1=mysql_fetch_array($r1);


	return $rr1['coll_name'];
}
else if($fl==4)
{
	$qq="select * from ".$tb." where email='$email'";
	$qr=mysql_query($qq,$con);
	$qrr=mysql_fetch_array($qr);
	
	$sch=$qrr['school'];
	return $sch;
}
}
else
{
	$q8="select * from p_pid_email where kid='$x'";
	$r8=mysql_query($q8);
	$rr8=mysql_fetch_array($r8);
	$acc=$rr8['acctype'];
	$email=$rr8['email'];
	$fbid=$rr8['user_id'];
	$fl=0;
	if(strcmp($acc,"college")==0)
		{$tb="college_student";
	$fl=1;
}
else if(strcmp($acc,"corporate")==0)
	{$tb="corporate";
$fl=2;
}
else if(strcmp($acc,"faculty")==0)
	{$tb="faculty";
$fl=3;
}
else if(strcmp($acc,"school")==0)
{
	$tb="school_student";
	$fl=4;
}
if($fl==1)
{
	$qq="select * from ".$tb." where user_id='$fbid'";
	$qr=mysql_query($qq,$con);
	$qrr=mysql_fetch_array($qr);

	$coll=$qrr['college'];
	
	$q1="select * from coll_list where coll_id='$coll'";

	$r1=mysql_query($q1,$con);

	$rr1=mysql_fetch_array($r1);

	return $rr1['coll_name'];
}
else if($fl==2)
{
	$qq="select * from ".$tb." where email='$email'";
	$qr=mysql_query($qq,$con);
	$qrr=mysql_fetch_array($qr);
	
	$com=$qrr['company'];
	return $com;
}
else if($fl==3)
{
	$qq="select * from ".$tb." where email='$email'";
	$qr=mysql_query($qq,$con);
	$qrr=mysql_fetch_array($qr);
	
	$coll=$qrr['college'];

	$q1="select * from coll_list where coll_id='$coll'";
	

	$r1=mysql_query($q1,$con);
	
	
	$rr1=mysql_fetch_array($r1);


	return $rr1['coll_name'];
}
else if($fl==4)
{
	$qq="select * from ".$tb." where email='$email'";
	$qr=mysql_query($qq,$con);
	$qrr=mysql_fetch_array($qr);
	
	$sch=$qrr['school'];
	
	return $sch;
}

}
}
function getname($x)
{
	$con = mysql_connect("mysql.kurukshetra.org.in", "k12_admin", "this1is2absolute3nonsense") or die("Cannot connect to database:".mysql_error());
	mysql_select_db("kuruk12",$con);
	$q="select * from k_registration_info where kid='$x'";
	$r=mysql_query($q,$con);
	
	if(mysql_num_rows($r)==1)
	{
		
		$rr=mysql_fetch_array($r);
		$acc=$rr['acctype'];
		$email=$rr['email'];
		if(strcmp($acc,"college")==0)
			{$tb="k_college_student";
		$fl=1;
	}
	else if(strcmp($acc,"corporate")==0)
		{$tb="k_corporate";
	$fl=2;
}
else if(strcmp($acc,"faculty")==0)
	{$tb="k_faculty";
$fl=3;
}
else if(strcmp($acc,"school")==0)
{
	$tb="k_school_student";
	$fl=4;
}
if($fl==1)
{
	$qq="select * from ".$tb." where email='$email'";
	$qr=mysql_query($qq,$con);
	$qrr=mysql_fetch_array($qr);
	$name=$qrr['name'];
	return $name;
}
else if($fl==2)
{
	$qq="select * from ".$tb." where email='$email'";
	$qr=mysql_query($qq,$con);
	$qrr=mysql_fetch_array($qr);
	$name=$qrr['name'];
	return $name;
}
else if($fl==3)
{
	$qq="select * from ".$tb." where email='$email'";
	$qr=mysql_query($qq,$con);
	$qrr=mysql_fetch_array($qr);
	$name=$qrr['name'];
	return $name;
}
else if($fl==4)
{
	$qq="select * from ".$tb." where email='$email'";
	$qr=mysql_query($qq,$con);
	$qrr=mysql_fetch_array($qr);
	$name=$qrr['name'];
	return $name;
}
}
else
{
	$q8="select * from p_pid_email where kid='$x'";
	$r8=mysql_query($q8);
	$rr8=mysql_fetch_array($r8);
	$acc=$rr8['acctype'];
	$email=$rr8['email'];
	$fbid=$rr8['user_id'];
	$fl=0;
	if(strcmp($acc,"college")==0)
		{$tb="college_student";
	$fl=1;
}
else if(strcmp($acc,"corporate")==0)
	{$tb="corporate";
$fl=2;
}
else if(strcmp($acc,"faculty")==0)
	{$tb="faculty";
$fl=3;
}
else if(strcmp($acc,"school")==0)
{
	$tb="school_student";
	$fl=4;
}
if($fl==1)
{
	$qq="select * from ".$tb." where user_id='$fbid'";
	$qr=mysql_query($qq,$con);
	$qrr=mysql_fetch_array($qr);
	$name=$qrr['name'];
	return $name;
}
else if($fl==2)
{
	$qq="select * from ".$tb." where email='$email'";
	$qr=mysql_query($qq,$con);
	$qrr=mysql_fetch_array($qr);
	$name=$qrr['name'];
	return $name;
}
else if($fl==3)
{
	$qq="select * from ".$tb." where email='$email'";
	$qr=mysql_query($qq,$con);
	$qrr=mysql_fetch_array($qr);
	$name=$qrr['name'];
	return $name;
}
else if($fl==4)
{
	$qq="select * from ".$tb." where email='$email'";
	$qr=mysql_query($qq,$con);
	$qrr=mysql_fetch_array($qr);
	$name=$qrr['name'];
	return $name;
}


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
public function fbuserid()
{
	$CI=&get_instance();
	$config['appId'] = FB_APPID;
	$config['secret'] = FB_SECRET;
	$config['cookie'] = true;
	$CI->load->library('facebook-source/facebook',$config);
	$facebook = new Facebook(array(
		'appId'  => FB_APPID,
		'secret' => FB_SECRET,
		));
	$user = $facebook->getUser();
	if($user)
		return $user;
}
public function fbemail()
{
	$CI=&get_instance();
	$config['appId'] = FB_APPID;
	$config['secret'] = FB_SECRET;
	$config['cookie'] = true;
	$CI->load->library('facebook-source/facebook',$config);
	$facebook = new Facebook(array(
		'appId'  => FB_APPID,
		'secret' => FB_SECRET,
		));
	$user = $facebook->getUser();
	if($user)
	{
		$user_profile = $facebook->api('/me');
		$email=$user_profile['email'];
		return $email;
	}
}
public function fbname()
{
	$CI=&get_instance();
	$config['appId'] = FB_APPID;
	$config['secret'] = FB_SECRET;
	$config['cookie'] = true;
	$CI->load->library('facebook-source/facebook',$config);
	$facebook = new Facebook(array(
		'appId'  => FB_APPID,
		'secret' => FB_SECRET,
		));
	$user = $facebook->getUser();
	if($user)
	{
		$user_profile = $facebook->api('/me');
		$name=$user_profile['name'];
		return $name;
	}
}
public function fbloggedin()
{
	$CI=&get_instance();
	$config['appId'] = FB_APPID;
	$config['secret'] = FB_SECRET;
	$config['cookie'] = true;
	$CI->load->library('facebook-source/facebook',$config);
	$facebook = new Facebook(array(
		'appId'  => FB_APPID,
		'secret' => FB_SECRET,
		));
	$user = $facebook->getUser();
	if($user)
	{
		if($CI->input->cookie('fbuser',TRUE)!="")
			return 1;
	}
	return 0;
}

public function isLoggedin()
{
	$CI=&get_instance();
	if($CI->input->cookie('kuser',TRUE)!="")
		return 1;
	else
	{
		$config['appId'] = FB_APPID;
		$config['secret'] = FB_SECRET;
		$config['cookie'] = true;
		$CI->load->library('facebook-source/facebook',$config);
		$facebook = new Facebook(array(
			'appId'  => FB_APPID,
			'secret' => FB_SECRET,
			));
		$user = $facebook->getUser();
		if($user)
		{
			if($CI->input->cookie('fbuser',TRUE)!="")
				return 2;
		}
	}
	return 0;
}

public function getkid()
{
	$CI=&get_instance();
	if($CI->input->cookie('kuser',TRUE)!="")
	{
		$CI->load->library('encrypt');
		$id=$CI->input->cookie('kuser',TRUE);
		$c=$CI->encrypt->decode($id,"HgTyLkOhjGdc765gftg2913QTyD");	
		return $c;
	}
	else
	{
		$config['appId'] = FB_APPID;
		$config['secret'] = FB_SECRET;
		$config['cookie'] = true;
		$CI->load->library('facebook-source/facebook',$config);
		$facebook = new Facebook(array(
			'appId'  => FB_APPID,
			'secret' => FB_SECRET,
			));
		$user = $facebook->getUser();
		if($user)
		{
			$db=$CI->load->database('default',TRUE);
			$q="select kid from p_pid_email where user_id='$user'";
			$r=$db->query($q);
			if($r->num_rows()==1)
			{
				$rr=$r->row();
				$db->close();
				return $rr->kid;
			}
			$db->close();
		}
	}
}

public function getemail()
{
	$CI=&get_instance();
	if($CI->input->cookie('kuser',TRUE)!="")
	{
		$CI->load->library('encrypt');
		$id=$CI->input->cookie('kuser',TRUE);
		$c=$CI->encrypt->decode($id,"HgTyLkOhjGdc765gftg2913QTyD");	
		$db=$CI->load->database('default',TRUE);
		$q="select email from k_registration_info where kid='$c'";
		$r=$db->query($q);
		if($r->num_rows()==1)
		{
			$rr=$r->row();
			return $rr->email;
		}
	}
	else
	{
		$config['appId'] = FB_APPID;
		$config['secret'] = FB_SECRET;
		$config['cookie'] = true;
		$CI->load->library('facebook-source/facebook',$config);
		$facebook = new Facebook(array(
			'appId'  => FB_APPID,
			'secret' => FB_SECRET,
			));
		$user = $facebook->getUser();
		if($user)
		{
			
			$user_profile = $facebook->api('/me');
			$email=$user_profile['email'];
			return $email;
		}
	}
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
		$prefix="P13";
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


function validEmail($email)
{
	$isValid = true;
	$atIndex = strrpos($email, "@");
	if (is_bool($atIndex) && !$atIndex)
	{
		$isValid = false;
	}
	else
	{
		$domain = substr($email, $atIndex+1);
		$local = substr($email, 0, $atIndex);
		$localLen = strlen($local);
		$domainLen = strlen($domain);
		if ($localLen < 1 || $localLen > 64)
		{
         // local part length exceeded
			$isValid = false;
		}
		else if ($domainLen < 1 || $domainLen > 255)
		{
         // domain part length exceeded
			$isValid = false;
		}
		else if ($local[0] == '.' || $local[$localLen-1] == '.')
		{
         // local part starts or ends with '.'
			$isValid = false;
		}
		else if (preg_match('/\\.\\./', $local))
		{
         // local part has two consecutive dots
			$isValid = false;
		}
		else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
		{
         // character not valid in domain part
			$isValid = false;
		}
		else if (preg_match('/\\.\\./', $domain))
		{
         // domain part has two consecutive dots
			$isValid = false;
		}
		else if
			(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
				str_replace("\\\\","",$local)))
		{
         // character not valid in local part unless 
         // local part is quoted
			if (!preg_match('/^"(\\\\"|[^"])+"$/',
				str_replace("\\\\","",$local)))
			{
				$isValid = false;
			}
		}
		if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
		{
         // domain not found in DNS
			$isValid = false;
		}
	}
	return $isValid;
}
}
?>
