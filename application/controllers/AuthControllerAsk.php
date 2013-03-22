<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AuthControllerPin extends CI_Controller {
 
    function AuthControllerPin() {
        parent::__construct();
        session_start();
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
        if(isset($_SESSION['pid'])){
            $pid=$_SESSION['pid'];
            //update profile
            $q1 = "update p_student_profile set name='$name',phone='$phone',college='$college',
                     degree='$degree', course='$course', complete='1'
                     where pid='$pid'";
            $this->db->query($q1);
            echo 'Thanks for updating !!You will be redirected to the home!
            <script>
                window.setInterval(function(){
                    window.location="'.base_url().'";
                },3000);
            </script>
            ';

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
            //check if email is already registered in p_student_profile
            $q="select pid from p_student_profile where email='$email'";
            $res=$this->db->query($q);
            if ($res->num_rows() > 0){
            //if yes then err
                echo "You have registered already using the emailId!";
            }
            //else 
            else{
                //TODO

                
                //insert a dummy record into p_fb_details for sequence id
                $q2 = "insert into p_fb_details(fb_user_id,email) values('$email','$email')";
                $this->db->query($q2);

                //generate a PID
                $qq    = "select seqid from p_fb_details where fb_user_id='$email'";
                $rr    = $this->db->query($qq);
                $tr    = $rr->row();
                $seqid = $tr->seqid;
                $this->load->library('klib');
                $pid = $this->klib->fb_generate($seqid);

                //generate a hash
                $hash=md5($pid);

                //insert new record in p_student_profile with hash
                $q1 = "insert into p_student_profile(name,phone,college,
                     degree, course, complete,isNormalAccount,pid,email,password,hash) values('$name','$phone','$college','$degree','$course',
                     1,1,'$pid','$email','$pass','$hash')";
                $this->db->query($q1);
                echo 'Thanks for registering !! Check your inbox for activation instructions!';
                //send activation to email
                //auto mail
                $activationLink=base_url()."authcontroller/activateAccount/".urlencode($email)."/$hash";
                $this->load->library('klib');
                $emailData['to']=$email;
                $emailData['subject']='[Pinnacle 2013] Account Activation';
                $emailData['message']="Please click the following link to activate your Pinnacle 2013 account !
                <a href=$activationLink>$activationLink</a>";
                $this->klib->sendMail($emailData);

            }
        }   
    }

    function activateAccount($email,$hash){

        //get email and hash from GET
        //check whether there is a record with the given email n hash match
        //if so
        $email=urldecode($email);
        $q="select pid from p_student_profile where email='$email' and hash='$hash'";
        $res=$this->db->query($q);
        if ($res->num_rows() > 0){

            $row=$res->row_array();
            $pid=$row['pid'];
            //remove hash value from that record and thus it is activated
            $this->db->query("update p_student_profile set hash='' where email='$email' and hash='$hash'");
            //send him confirmation mail with PID
            $this->load->library('klib');
            $emailData['to']=$email;
            $emailData['subject']='[Pinnacle 2013] Account Activation Successful';
            $emailData['message']="Thanks for registering! Please note your Pinnacle ID : $pid . You need the Pinnacle ID for all of your communications.";
            $this->klib->sendMail($emailData);            
            echo 'Thanks for activating your account!! Please wait while you are being redirected!
                <script>
                window.setInterval(function(){
                    window.location="'.base_url().'";
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
        if(!isset($_SESSION['pid'])){
            $data['normalLogin']=true;
            $this->load->view('login-register-view',$data);
        }
        else{
            echo "You are already logged in !!";
        }
    }

    function processNormalLogin(){
        //TODO
        //if ders no session already
        if(!isset($_SESSION['pid'])){
            //get form data
            $email=mysql_real_escape_string($this->input->post('email'));
            $pass=mysql_real_escape_string($this->input->post('pass'));
            //check whether he is activated and theres a valid record for given data
            $q="select pid,hash from p_student_profile where email='$email' and password='$pass'";
            $res=$this->db->query($q);
            if ($res->num_rows() > 0){
                $row=$res->row_array();
                if($row['hash']==NULL){
                    //he has acativated
                    $_SESSION['pid']=$row['pid'];
                    $_SESSION['isNormalAccount']=1;
                    redirect(base_url()); 
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
        $pid=$_SESSION['pid'];
        //check if profile s complete
        $query=$this->db->query("select complete from p_student_profile where pid='$pid'");
        if($query->num_rows()>0){
            $row=$query->row_array();
            //if not show the form
            if($row['complete']==0){
                $this->load->view('login-register-view',$data);
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
            $responseObj=$this->authmodelask->dodatabasecheck_fbdetails($email,$access_token,$uid);
            //if user is a valid user with pid
            $_SESSION['pid']=$responseObj['pid'];
            echo $responseObj['statusCode'];
        }
               
    } 

    function destroySession(){
        session_destroy();
    }

    function normalLogout(){
        session_destroy();
        redirect(base_url());   
    }

}   