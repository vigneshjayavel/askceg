<?php
class AuthModelAsk extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    function dodatabasecheck_fbdetails($email, $access_token, $uid,$pic) {
        $db    = $this->load->database('default', TRUE);
        $email = mysql_real_escape_string($email);
        $uid   = mysql_real_escape_string($uid);
        
        
        $access_token = mysql_real_escape_string($access_token);
        /*
        $qr           = "select user_id,acctype from p_registration_info where email='$email'";
        $result       = $db->query($qr);
        */
        $responseObj= array();

        $user_id=null;

        /*
        if ($result->num_rows() == 1) {
            //already registered using normal login..
            $q3 = "select * from p_fb_connect where email='$email'";
            $r3 = $db->query($q3);
            if ($r3->num_rows() == 0) { //not connected with fb app, connect with k!app..
                $q4 = "insert into p_fb_connect(email,fb_user_id,access_token) values('$email','$uid','$access_token')";
                $db->query($q4);
                $rrt = $result->row();
                if (strcmp($rrt->acctype, "college") == 0)
                    $q9 = "select name from USERS where email='$email'";
                
                $result1          = $db->query($q9);
                $row1             = $result1->row();
                $responseObj['statusCode'] = "1";
                $config['apuser_id']  = FB_APuser_id;
                $config['secret'] = FB_SECRET;
                $config['cookie'] = true;
                $this->load->library('facebook-source/facebook', $config);
                $facebook = new Facebook(array(
                    'apuser_id' => FB_APuser_id,
                    'secret' => FB_SECRET
                ));
                $user     = $facebook->getUser();
                if ($user) {
                    try {
                        $publishStream = $facebook->api("/$user/feed", 'post', array(
                            'message' => "Signed-up for AskCEG!",
                            'link' => 'http://askceg.in/home',
                            'picture' => 'http://askceg.in/assets/images/logo.png',
                            'name' => 'AskCEG beta',
                            'description' => 'AskCEG beta!'
                        ));
                    }
                    catch (FacebookApiException $e) {
                    }
                }
                
                return $responseObj;
            }
        }
        
        
        else { 
        */
            //user not registered previously in p_registration_info. ( not signed up using normal login )
            //Let the user login and check for completion of profile.
            
            $q   = "select * from FB_DETAILS where fb_user_id='$uid'";
            $res = $db->query($q);
            if ($res->num_rows() == 1) { //Already present in FB_DETAILS ( USER ALREADY CONNECTED WITH THE APP )
                $r = $res->row();

                if ($r->fb_user_id == '' || $r->access_token == '' || $r->status == 0) {
                    $q1 = "update FB_DETAILS set status=1,fb_user_id='$uid',access_token='$access_token' where email='$email'";
                    $db->query($q1);
                } else {
                    $q1 = "update FB_DETAILS set access_token='$access_token' where fb_user_id='$uid'";
                    $db->query($q1);
                }
                
                $q10   = "select a.complete,a.user_id,a.user_name
                 from USERS a, FB_DETAILS b 
                 where a.email_id=b.email and b.fb_user_id='$uid'";
                $r10   = $db->query($q10);
                $row10 = $r10->row();
                $user_id=$row10->user_id;
                $user_name=$row10->user_name;
                if ($row10->complete == 1) { //already registered ( PROFILE IS COMPLETE )
                    
                    $responseObj['statusCode'] = "2";
                } else{
                    $responseObj['statusCode'] = "4";
                }
                $responseObj['user_id'] = $user_id;
                $responseObj['user_name'] = $user_name;
                $responseObj['profile_pic'] = $pic;
                return $responseObj;
            }
            
            
            else { //Not present in FB_DETAILS.. ( FIRST TIME USER AND HE NEEDS TO AUTHORIZE THE APP )
                $config['apuser_id'] = FB_APuser_id;
                $config['secret'] = FB_SECRET;
                $config['cookie'] = true;
                $this->load->library('facebook-source/facebook', $config);
                $facebook = new Facebook(array(
                    'apuser_id' => FB_APuser_id,
                    'secret' => FB_SECRET
                ));
                $facebook->setExtendedAccessToken();
                $access_token = $facebook->getAccessToken();
                $q2 = "insert into FB_DETAILS(email,fb_user_id,access_token,status) values('$email','$uid','$access_token',1)";
                $db->query($q2);
                $qq    = "select seqid from FB_DETAILS where fb_user_id='$uid'";
                $rr    = $db->query($qq);
                $tr    = $rr->row();
                $seqid = $tr->seqid;
                $this->load->library('klib');
               // $user_id = $this->klib->fb_generate($seqid);
                $user_id="AAA";
                $q5  = "insert into USERS(user_id,email_id,profile_pic) values('$user_id','$email','$pic')";
                $db->query($q5);
                
                $user     = $facebook->getUser();
                if ($user) {
                    try {
                        $publishStream = $facebook->api("/$user/feed", 'post', array(
                            'message' => "Signed-up for AskCEG!",
                            'link' => 'http://askceg.in/home',
                            'picture' => 'http://askceg.in/assets/images/logo.png',
                            'name' => 'AskCEG beta',
                            'description' => 'AskCEG beta!'
                        ));                        
                    }
                    catch (FacebookApiException $e) {
                    }
                }
                
                //auto mail
                $emailData['to']=$email;
                $emailData['subject']='[AskCEG] Welcome to AskCEG!';
                $emailData['message']="Thanks for registering!  Hope you find the beta release interesting! :)";
                $this->klib->sendMail($emailData);
                
                $responseObj['statusCode'] = "3";
                $responseObj['user_id']=$user_id;
                return $responseObj;
            }
        /*
        }
        */
    }
}