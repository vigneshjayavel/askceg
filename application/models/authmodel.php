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
    function AddRemoveUserMarkup($group_id){
        $sql='select user_name,request_id from REQUEST_USER where group_id=?';

        $query=$this->db->query($sql,array($group_id));
        $result=$query->result_array();
        $optionMarkup='';
        if($result!=null){
          foreach ($result as $row) {
              $optionMarkup.='<option value="'.$row['request_id'].'">'.$row['user_name'].'</option>';
              
          }
        }
        else{
          $optionMarkup.='<option>No Requests!!</option>';
        }

       return '<h6>add user:</h6>

              <a href="'.base_url().'AuthController/AddNewUser">Create New User</a>
              <form action="'.base_url().'AuthController/AddUser" method="post">
              <h6>create from exiting requests</h6>
              <p>

              <select name="adduser">'.$optionMarkup.'
              </select>
              </p>

              <input type="submit">
              </form>';
        

     }
    function getCenterContentAddNewUser()
    {

        $sql="select group_name,group_id from GROUPS";
         $query=$this->db->query($sql,array());
        $result=$query->result_array();
        $optionMarkup='<option value="">Select Group</option>';
        foreach($result as $row)
        {
            $optionMarkup.='<option value="'.$row['group_id'].'">'.$row['group_name'].'</option>';
        }
        return '<form class="form-horizontal" id="registerHere" method=\'post\' action=\'\'>
      <fieldset>
        <legend>Registration</legend>
        <div class="control-group">
          <label class="control-label" for="input01">Name</label>
          <div class="controls">
            <input type="text" class="input-xlarge" id="user_name" name="user_name" rel="popover" data-content="Enter your first and last name." data-original-title="Full Name">
            
          </div>
    </div>

    <div class="control-group">
          <label class="control-label" for="input01">Degree</label>
          <div class="controls">
            <input type="text" class="input-xlarge" id="degree" name="degree" rel="popover" data-content="Enter your degree" data-original-title="Degree">
            
          </div>
    </div>
    <div class="control-group">
          <label class="control-label" for="input01">Course</label>
          <div class="controls">
            <input type="text" class="input-xlarge" id="course" name="course" rel="popover" data-content="Enter your first and last name." data-original-title="Course">
            
          </div>
    </div>

    <div class="control-group">
          <label class="control-label" for="input01">Registration No</label>
          <div class="controls">
            <input type="text" class="input-xlarge" id="reg_no" name="reg_no" rel="popover" data-content="Enter your Registration Number" data-original-title="Registration Number">
            
          </div>
    </div>
    
     <div class="control-group">
        <label class="control-label" for="input01">Email</label>
          <div class="controls">
            <input type="text" class="input-xlarge" id="user_email" name="user_email" rel="popover" data-content="What’s your email address?" data-original-title="Email">
           
          </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="input01">Year</label>
          <div class="controls">
            <select name="Year" id="Year" >
                            <option value="">Year</option>
                            <option value="1">1st Year</option>
                            <option value="2">2nd Year</option>
                            <option value="3">3rd Year</option>
                            <option value="4">4th Year</option>           
                          </select>
           
          </div>
    
    </div>

    <div class="control-group">
        <label class="control-label" for="input01">Group/Batch</label>
          <div class="controls">
            <select name="group" id="group" >
                           '.$optionMarkup.';           
                          </select>
           
          </div>
    
    </div>
    
    <div class="control-group">
        <label class="control-label" for="input01">Password</label>
          <div class="controls">
            <input type="password" class="input-xlarge" id="pwd" name="pwd" rel="popover" data-content="6 characters or more! Be tricky" data-original-title="Password" >
           
          </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="input01">Confirm Password</label>
          <div class="controls">
            <input type="password" class="input-xlarge" id="cpwd" name="cpwd" rel="popover" data-content="Re-enter your password for confirmation." data-original-title="Re-Password" >
           
          </div>
    </div>
    
    
     <div class="control-group">
        <label class="control-label" for="input01">Gender</label>
          <div class="controls">
            <select name="gender" id="gender" >
                            <option value="">Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
            <option value="other">Other</option>
                           
                          </select>
           
          </div>
    
    </div>
    
    
    <div class="control-group">
        <label class="control-label" for="input01"></label>
          <div class="controls">
           <button type="submit" class="btn btn-success" rel="tooltip" title="first tooltip">Create My Account</button>
           
          </div>
    
    </div>
    
    
       
      </fieldset>
    </form>
';
















    }
    function AddUser($request_id){

      $sql="select * from REQUEST_USER where request_id=?";
      $query=$this->db->query($sql,array($request_id));
      $row=$query->row_array();
      
      $user_name=$row['user_name'];
      $user_id=$row['user_id'];
      $user_course=$row['user_course'];
      $user_degree=$row['user_degree'];
      $user_year=$row['user_year'];
      $group_id=$row['group_id'];
      $password=$row['password'];
    
      $sql1="insert into USERS(user_name,user_id,user_course,user_degree,user_year,group_id,password) values(?,?,?,?,?,?,?)";
      $query=$this->db->query($sql1,array($user_name,$user_id,$user_course,$user_degree,$user_year,$group_id,$password));
      if($query==1){
        $sql1="delete from REQUEST_USER
              where request_id=?";
        $query=$this->db->query($sql1,array($request_id));
        return "ADDED SUCCESSFULLY";
      }
        
      else
        return "NOPE :(";


    }

    function RemoveUser(){










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


}