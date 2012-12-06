<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AuthModel extends CI_Model{
    function getUserName($user_id){

    $sql = "select * from USERS where user_id=?"; //storing query string 
$query=$this->db->query($sql,array($user_id));
       if($result=$query->row_array())
       return $result['user_name'];
      
    }
    function getUserGroupId($user_id){

        $sql = "select * from USERS where user_id=?";  
        $query=$this->db->query($sql,array($user_id));
        if($result=$query->row_array())
            return $result['group_id'];
    }
	function authenticate($user_id,$user_pass){

 
        $sql = "select * from USERS where user_id=? and password=?"; //storing query string 
        $query=$this->db->query($sql,array($user_id,$user_pass));

       if($result=$query->row_array())
       {
            //echo $user_id.$user_pass."true";
            //after loggin in redirect to the controller u desire :P
            return true;
        } 
         else
            return false;
       
           
        
    }
       
        function getCenterContentMyProfile(){

	   return ' <form id="login" enctype="application/x-www-form-urlencoded" class="form-vertical login"
        accept-charset="utf-8" method="post" action="#">
            <div class="control-group error">
                <label for="email" class="control-label required">Email address</label>
                <div class="controls">
                    <input type="text" name="email" id="login-email" data-title="Invalid email" value="" tabindex="1">
                </div>
            </div>
            <div class="control-group">
                <label for="password" class="control-label required">Password (
                    <a href="#" class="trigger-lightbox validate-resetpassword">forgot password</a>)</label>
                <div class="controls">
                    <input type="password" name="password" id="login-password" data-title="Invalid password" value="" tabindex="2">
                </div>
            </div>
            <div class="form-actions">
        <button name="submit" id="loginbutton" data-loading-text="logging in.." onclick="javascript:dologin();return false;" 
                tabindex="3" class="btn btn-primary">Log In</button>
                <button name="cancel" id="cancel" type="reset" data-dismiss="modal" class="btn">Cancel</button>
            </div>
        </form>
    ';



	}

	function getCenterContentMyGroup(){

		return '<form id="register" enctype="application/x-www-form-urlencoded" class="form-vertical register"
        accept-charset="utf-8" method="post" action="#">
      
            <div class="control-group">
                <label for="email" class="control-label required">Email address</label>
                <div class="controls">
                    <input type="text" name="email" id="email" value="" title="We\'ll send an email with a confirmation link to this email address."
                    class="tipF" autocomplete="off">
                </div>
            </div>
      
            <div class="control-group">
                <label for="password" class="control-label required">Password</label>
                <div class="controls">
                    <input type="password" name="password" id="password" value="" title="At least 6 chars"
                    class="tipF" autocomplete="off">
                </div>
            </div>
            <div class="control-group">
                <label for="verifypassword" class="control-label required">Confirm password</label>
                <div class="controls">
                    <input type="password" name="verifypassword" id="verifypassword" value=""
                    title="Please repeat your password. We want to ensure you didn\'t mistyped."
                    class="tipF" autocomplete="off">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <label class="checkbox">
                        <input type="hidden" name="terms" value="">
                        <input type="checkbox" name="terms" id="terms" value="1">I accept the
                        <a href="#" target="_blank">Terms of use</a>.</label>
                </div>
            </div>
            <div class="form-actions">
                <button name="submit" id="signupbutton" data-loading-text="signing up.." onclick="javascript:verifysignup();return false;" 
                tabindex="3" class="btn btn-primary">Sign up</button>
                <button name="cancel" id="cancel" type="reset" data-dismiss="modal" class="btn">Cancel</button>
            </div>
        </form> ';

	}



}