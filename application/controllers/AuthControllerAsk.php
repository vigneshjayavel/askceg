<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AuthControllerAsk extends CI_Controller {
    public $data=array();
    function AuthControllerAsk() {
        parent::__construct();
    }

    public function index()
    {
        # code...
        echo "asas";
    }

    function updateProfile(){

        $name=mysql_real_escape_string($this->input->post('name'));
        $phone=mysql_real_escape_string($this->input->post('phone'));
        $college=mysql_real_escape_string($this->input->post('college'));
        $degree=mysql_real_escape_string($this->input->post('degree'));
        $course=mysql_real_escape_string($this->input->post('course'));
        if($this->session->userdata('user_id')){
            $user_id=$this->session->userdata('user_id');
            //update profile
            $q1 = "update USERS set user_name='$name',
                     user_degree='$degree', user_course='$course', complete='1'
                     where user_id='$user_id'";
            $this->db->query($q1);
            echo 'Thanks for updating !!You will be redirected to the home!
            <script>
                window.setInterval(function(){
                    window.location="'.base_url().'HomeController";
                },3000);
            </script>
            ';

        }
        else{
            echo "something wrong!";
        }
    }
    function normalsignup(){

        //normal signup
        //loads view
        $lib=APPPATH.'libraries/recaptchalib.php';
        require_once($lib);
        $publickey = "6Ld80d0SAAAAAMnQ3Qm-bJTiN9s_GzHY-3aMcamC"; // you got this from the recaptcha signup page
        $recaptchaMarkup= recaptcha_get_html($publickey);

        $data['normalSignup']=true;
        $data['recaptchaMarkup']=$recaptchaMarkup;
        
               
        $this->load->view('login-register-view',$data);

    }
    function createNormalProfile(){

        $name=mysql_real_escape_string($this->input->post('name'));
        $phone=mysql_real_escape_string($this->input->post('phone'));
        $college=mysql_real_escape_string($this->input->post('college'));
        $degree=mysql_real_escape_string($this->input->post('degree'));
        $course=mysql_real_escape_string($this->input->post('course'));
        $email=mysql_real_escape_string($this->input->post('email'));
        $pass=mysql_real_escape_string($this->input->post('pass'));
        //validate recaptcha
        $challenge=$this->input->post('recaptcha_challenge_field');
        $response=$this->input->post('recaptcha_response_field');
        $this->load->library('captcha');
        $isCaptchaValid = $this->captcha->verifycaptcha($challenge,$response);//return 1 if valid..

        //if captcha fails reload the page
        if(!$isCaptchaValid){
            echo 'captcha error..Please enter correct captcha!
            You \'ll be taken back !
            <script>
                window.setInterval(function(){
                    window.history.back();
                },3000);
            </script>
            ';
        }
        //else
        else{
            //check if email is already registered in USERS
            $q="select user_id from USERS where email_id='$email'";
            $res=$this->db->query($q);
            if ($res->num_rows() > 0){
            //if yes then err
                echo "You have registered already using the emailId!";
            }
            //else 
            else{
                //TODO

                
                //insert a dummy record into FB_DETAILS for sequence id
                $q2 = "insert into FB_DETAILS(fb_user_id,email) values('$email','$email')";
                $this->db->query($q2);

                //generate a user_id
                $qq    = "select seqid from FB_DETAILS where fb_user_id='$email'";
                $rr    = $this->db->query($qq);
                $tr    = $rr->row();
                $seqid = $tr->seqid;
                $this->load->library('klib');
                $user_id = $this->klib->fb_generate($seqid);

                //generate a hash
                $hash=md5($user_id);

                //insert new record in USERS with hash
                $q1 = "insert into USERS(user_name,user_degree, user_course, 
                    complete,isNormalAccount,user_id,email_id,password,hash) values('$name','$degree',
                    '$course',1,1,'$user_id','$email','$pass','$hash')";
                $this->db->query($q1);
                echo 'Thanks for registering !! Check your inbox for activation instructions!<br><b>Please check spam if you haven\'t received the mail!</b>';
                //send activation to email
                //auto mail
                $activationLink=base_url()."AuthControllerAsk/activateAccount/".urlencode($email)."/$hash";
                $this->load->library('klib');
                $emailData['to']=$email;
                $emailData['subject']='[AskCEG] Account Activation';
                $emailData['message']="Please click the following link to activate your AskCEG account !
                <a href=$activationLink>$activationLink</a><br>Cheers<br>Team AskCEG";
                $this->klib->sendMail($emailData);

            }
        }   
    }

    function activateAccount($email,$hash){

        //get email and hash from GET
        //check whether there is a record with the given email n hash match
        //if so
        $email=urldecode($email);
        $q="select user_id from USERS where email_id='$email' and hash='$hash'";
        $res=$this->db->query($q);
        if ($res->num_rows() > 0){

            $row=$res->row_array();
            $user_id=$row['user_id'];
            //remove hash value from that record and thus it is activated
            $this->db->query("update USERS set hash='' where email_id='$email' and hash='$hash'");
            //send him confirmation mail with user_id
            $this->load->library('klib');
            $emailData['to']=$email;
            $emailData['subject']='[AskCEG] Account Activation Successful';
            $emailData['message']="Thanks for registering! Hope you find the beta release interesting! :)<br>Cheers<br>Team AskCEG";
            $this->klib->sendMail($emailData);            
            echo 'Thanks for activating your account!! Please wait while you are being redirected!
                <script>
                window.setInterval(function(){
                    window.location="'.base_url().'HomeController";
                },3000);
                </script>';
        }
        //else 
        else{
            //throw err
            echo "activation failed! contact us !";
        }
    }
    function normallogin(){
        if(!($this->session->userdata('user_id'))){
            $data['normalLogin']=true;
            $this->load->view('login-register-view',$data);
        }
        else{
            echo "You are already logged in !! ".$this->session->userdata('user_id');
        }
    }

    function processNormalLogin(){
        //TODO
        //if ders no session already
        if(!($this->session->userdata('user_id'))){
            //get form data
            $email=mysql_real_escape_string($this->input->post('email'));
            $pass=mysql_real_escape_string($this->input->post('pass'));
            //check whether he is activated and theres a valid record for given data
            $q="select user_id,user_name,group_id,hash,profile_pic from USERS where email_id='$email' and password='$pass'";
            $res=$this->db->query($q);
            if ($res->num_rows() > 0){
                $row=$res->row_array();
                if($row['hash']==NULL){
                    //he has acativated
                    $sessionData = array(
                    'user_id'  => $row['user_id'],
                    'logged_in' => TRUE,
                    'user_name' => $row['user_name'],
                    'group_id' => $row['group_id'],
                    'isNormalAccount' => 1,
                    'profile_pic' => $row['profile_pic']

                    );

                    //jus like $this->session->userdata('someKey']='someValue';
                    //but note that here the key itself is an array of keys!!
                    $this->session->set_userdata($sessionData);
                    redirect(base_url()."HomeController"); 
                }
                else{
                    //he is yet to activate
                    echo "please check your mail for activation details and activate your account!!";
                }   
            }
            else{
                echo "Check your username and password!";
            }    
        }
        else{
            //else if thers session already
            //throw err
            echo "You are already logged in !!";

        }
            

    }
    function profile(){
        $user_id=$this->session->userdata('user_id');
        //check if profile s complete
        $query=$this->db->query("select complete from USERS where user_id='$user_id'");
        if($query->num_rows()>0){
            $row=$query->row_array();
            //if not show the form
            if($row['complete']==0){
                $this->load->view('login-register-view');
            }
            //else show warning
            else{
                echo 'You profile is already complete!!
                <script>
                window.setInterval(function(){
                    window.location="'.base_url().'";
                },3000);
                </script>';
            }

        }
        else{
            if($user_id=="")
                echo "asas";
        }
    }

    function dofbcheck(){
        if($this->input->is_ajax_request()){
            
            $access_token=$this->input->post('access_token');
            $uid=$this->input->post('uid');
            $email=$this->input->post('email');
            $sex=$this->input->post('sex');
            $pic=$this->input->post('pic');
            $name=$this->input->post('name');
            $this->load->model('authmodelask');
            $responseObj=$this->authmodelask->dodatabasecheck_fbdetails($email,$access_token,$uid,$pic);
            //if user is a valid user with user_id
            $sessionData = array(
            'user_id'  => $responseObj['user_id'],
            'logged_in' => TRUE,
            'user_name' => $responseObj['user_name'],
            'group_id' => 0,
            'isNormalAccount' => 0,
            'profile_pic' => $responseObj['profile_pic']
            );
            //jus like $this->session->userdata('someKey']='someValue';
            //but note that here the key itself is an array of keys!!
            $this->session->set_userdata($sessionData);
            echo $responseObj['statusCode'];
        }
               
    } 

    function destroySession(){
        //session_destroy();
        $this->session->sess_destroy();
        redirect('AuthController');
    }

    function normalLogout(){
        //session_destroy();
        $this->session->sess_destroy();
        redirect('AuthController');
    }

}   