<?php
class AuthModelAsk extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    function dodatabasecheck_fbdetails($email, $access_token, $uid) {
        $db    = $this->load->database('default', TRUE);
        $email = mysql_real_escape_string($email);
        $uid   = mysql_real_escape_string($uid);
        
        
        $access_token = mysql_real_escape_string($access_token);
        $qr           = "select pid,acctype from p_registration_info where email='$email'";
        $result       = $db->query($qr);
        $responseObj= array();

        $pid=null;

        if ($result->num_rows() == 1) {
            //already registered using normal login..
            $q3 = "select * from p_fb_connect where email='$email'";
            $r3 = $db->query($q3);
            if ($r3->num_rows() == 0) { //not connected with fb app, connect with k!app..
                $q4 = "insert into p_fb_connect(email,fb_user_id,access_token) values('$email','$uid','$access_token')";
                $db->query($q4);
                $rrt = $result->row();
                if (strcmp($rrt->acctype, "college") == 0)
                    $q9 = "select name from p_student_profile where email='$email'";
                
                $result1          = $db->query($q9);
                $row1             = $result1->row();
                $responseObj['statusCode'] = "1";
                $config['appId']  = FB_APPID;
                $config['secret'] = FB_SECRET;
                $config['cookie'] = true;
                $this->load->library('facebook-source/facebook', $config);
                $facebook = new Facebook(array(
                    'appId' => FB_APPID,
                    'secret' => FB_SECRET
                ));
                $user     = $facebook->getUser();
                if ($user) {
                    try {
                        $publishStream = $facebook->api("/$user/feed", 'post', array(
                            'message' => "Registered for Pinnacle 2013!",
                            'link' => 'http://pinnacleceg.com/home',
                            'picture' => 'http://pinnacleceg.com/assets/images/pi_logo/pi-color.png',
                            'name' => 'Pinnacle 2013',
                            'description' => 'Ascend and Conquer!'
                        ));
                    }
                    catch (FacebookApiException $e) {
                    }
                }
                
                return $responseObj;
            }
        }
        
        
        else { //user not registered previously in p_registration_info. ( not signed up using normal login )
            //Let the user login and check for completion of profile.
            
            $q   = "select * from p_fb_details where fb_user_id='$uid'";
            $res = $db->query($q);
            if ($res->num_rows() == 1) { //Already present in p_fb_details ( USER ALREADY CONNECTED WITH THE APP )
                $r = $res->row();

                if ($r->fb_user_id == '' || $r->access_token == '' || $r->status == 0) {
                    $q1 = "update p_fb_details set status=1,fb_user_id='$uid',access_token='$access_token' where email='$email'";
                    $db->query($q1);
                } else {
                    $q1 = "update p_fb_details set access_token='$access_token' where fb_user_id='$uid'";
                    $db->query($q1);
                }
                
                $q10   = "select a.complete,a.pid
                 from p_student_profile a, p_fb_details b 
                 where a.email=b.email and b.fb_user_id='$uid'";
                $r10   = $db->query($q10);
                $row10 = $r10->row();
                $pid=$row10->pid;
                if ($row10->complete == 1) { //already registered ( PROFILE IS COMPLETE )
                    
                    $responseObj['statusCode'] = "2";
                } else{
                    $responseObj['statusCode'] = "4";
                }
                $responseObj['pid'] = $pid;
                return $responseObj;
            }
            
            
            else { //Not present in p_fb_details.. ( FIRST TIME USER AND HE NEEDS TO AUTHORIZE THE APP )
                $config['appId'] = FB_APPID;
                $config['secret'] = FB_SECRET;
                $config['cookie'] = true;
                $this->load->library('facebook-source/facebook', $config);
                $facebook = new Facebook(array(
                    'appId' => FB_APPID,
                    'secret' => FB_SECRET
                ));
                $facebook->setExtendedAccessToken();
                $access_token = $facebook->getAccessToken();
                $q2 = "insert into p_fb_details(email,fb_user_id,access_token,status) values('$email','$uid','$access_token',1)";
                $db->query($q2);
                $qq    = "select seqid from p_fb_details where fb_user_id='$uid'";
                $rr    = $db->query($qq);
                $tr    = $rr->row();
                $seqid = $tr->seqid;
                $this->load->library('klib');
                $pid = $this->klib->fb_generate($seqid);
                $q5  = "insert into p_pid_email(pid,email,user_id) values('$pid','$email','$uid')";
                $db->query($q5);

                $q5  = "insert into p_student_profile(pid,email) values('$pid','$email')";
                $db->query($q5);
                
                $user     = $facebook->getUser();
                if ($user) {
                    try {
                        $publishStream = $facebook->api("/$user/feed", 'post', array(
                            'message' => "Registered for Pinnacle 2013!",
                            'link' => 'http://pinnacleceg.com/home',
                            'picture' => 'http://pinnacleceg.com/assets/images/pi_logo/pi-color.png',
                            'name' => 'Pinnacle 2013',
                            'description' => '20+ events 2000+ participants from 300+ colleges of the past made this Warfield a remarkable one. We invite you back to this Warfield with more strength for the National 2 day combat of the Mechanical brains. We welcome u for PINNACLE 2013. Come let’s ascend and conquer to show who is the champion.'
                        ));                        
                    }
                    catch (FacebookApiException $e) {
                    }
                }
                
                //auto mail
                $emailData['to']=$email;
                $emailData['subject']='[Pinnacle 2013] Welcome to Pinnacle 2013!';
                $emailData['message']="Thanks for registering! Please note your Pinnacle ID : $pid . You need the Pinnacle ID for all of your communications.";
                $this->klib->sendMail($emailData);
                
                $responseObj['statusCode'] = "3";
                $responseObj['pid']=$pid;
                return $responseObj;
            }
        }
    }
}