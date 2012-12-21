<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AuthModel extends CI_Model{
    function getUserName($user_id){

    $sql = "select * from USERS where user_id=?"; //storing query string 
$query=$this->db->query($sql,array($user_id));
       if($result=$query->row_array())
       return $result['user_name'];
      
    }
    function getUserGroupId($user_id){

        $sql = "select group_id from USERS where user_id=?";  
        $query=$this->db->query($sql,array($user_id));
        if($result=$query->row_array())
            return $result['group_id'];
    }
    function getUserYearId($user_id){

        $sql = "select user_year from USERS where user_id=?";  
        $query=$this->db->query($sql,array($user_id));
        if($result=$query->row_array())
            return $result['user_year'];

    }
    function AddRemoveUserMarkup($group_id){
        $sql='select user_name,request_id from REQUEST_USER where group_id=?';
        $sql1='select * from USERS where group_id=?';
        $sql2='select * from USER_HISTORY_LOG where group_id=?';
        $query=$this->db->query($sql,array($group_id));
        $query1=$this->db->query($sql1,array($group_id));
        $query2=$this->db->query($sql2,array($group_id));
        $result=$query->result_array();
        $result1=$query1->result_array();
        $result2=$query2->result_array();
        $addPrevDeletedMarkup=null;
        $deleteMarkup='';
        $optionMarkup='';
        if($result!=null){
          foreach ($result as $row) {
              $optionMarkup.='<option value="'.$row['request_id'].'">'.$row['user_name'].'</option>';
              
          }
        }
        else{
          $optionMarkup.='<option>No Requests!!</option>';
        }
        if($result1!=null){
          foreach ($result1 as $row1) {
              if($row1['user_level']>='1'&& $row1['user_level']!='2'){
                $deleteMarkup.='';
              }
              else
              $deleteMarkup.='<option value="'.$row1['user_id'].'">'.$row1['user_name'].'</option>';
              
          }
        }
        else{
          $deleteMarkup.='<option>No Users remaining to be deleted!!</option>';
        }
        if($result1!=null){
          foreach ($result2 as $row2) {
              $addPrevDeletedMarkup.='<option value="'.$row2['user_id'].'">'.$row2['user_name'].'</option>';
              
          }
        }
        if($addPrevDeletedMarkup==null)
        {
          $addPrevDeletedMarkup.='<option>Empty!</option>';
        }


       return '<div class="well" > 
              <h2> Adding Users:</h2>
              <h4> Create the User yourself:</h4>

              <a href="'.base_url().'AuthController/AddNewUser">Create New User</a>
              <form action="'.base_url().'AuthController/AddUser" method="post">
              <h4>Create from Existing requests:</h4>
              <p>

              <select name="adduser" >'.$optionMarkup.'
              </select>
              </p>


              <input type="submit" value="Add user">

               <h4> Add Users who were deleted previously:
                <p>
                </form>
                 <form action="'.base_url().'AuthController/AddUserAgain" method="post">
              
              <select name="adduseragain" >'.$addPrevDeletedMarkup.'
              </select>
              </p>
               <input type="submit" value="Add user">
               </form>

              
              <p> </div>
              <div class="well">
              <h2> Removing Users: </h2>
              Want to Remove anyone from the group? </p>
              <form action="'.base_url().'AuthController/RemoveUser" method="post">
              <p>

              <select name="removeuser" >'.$deleteMarkup.'
              </select>
              </p>
              <input type="submit" value="Remove user">
              </form>


              </div>


              ';




        

     }
     function getCenterContentRequestAccount(){
       
        $sql="select group_name,group_id from GROUPS";
         $query=$this->db->query($sql,array());
        $result=$query->result_array();
        $optionMarkup='<option value="">Select Group</option>';
        foreach($result as $row)
        {
            $optionMarkup.='<option value="'.$row['group_id'].'">'.$row['group_name'].'</option>';
        }
        return '<form class="form-horizontal" id="registerHere" method=\'post\' action=\''.base_url().'AuthController/AddAccountRequest\'>
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
            
                           
                          </select>
           
          </div>
    
    </div>
    
    
    <div class="control-group">
        <label class="control-label" for="input01"></label>
          <div class="controls">
           <button type="submit" class="btn btn-success" rel="tooltip" title="create your account">Create My Account</button>
           
          </div>
    
    </div>
    
    
       
      </fieldset>
    </form>
';

     }
     function AddAccountRequest($account){

      $sql="insert into REQUEST_USER(user_id,user_name,group_id,password,email_id,user_year,user_degree,user_course) values(?,?,?,?,?,?,?,?)";
       if($query=$this->db->query($sql,array($account['user_id'],$account['user_name'],$account['user_group'],$account['user_pass'],$account['user_email'],$account['user_year'],$account['user_degree'],$account['user_course'])))
        return 'Added Request SUCCESSFULLY. Kindly wait till your Admin approves your account. 
      Till then you are a Interim User <a href="'.base_url().'ProfileController/viewInterimProfile" > Click here to view your privilege </a>';
        

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
    function AddUserAgain($user_id){

      $sql="select * from USER_HISTORY_LOG where user_id=?";
      $query=$this->db->query($sql,array($user_id));
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
        $sql1="delete from USER_HISTORY_LOG
              where user_id=?";
        $query=$this->db->query($sql1,array($user_id));
        return "ADDED SUCCESSFULLY";
      }
        
      else
        return "Sorry, not possible. Please Try later!";


    }
    
    function RemoveUser($user_id){


      $sql="select * from USERS where user_id=?";
      $query=$this->db->query($sql,array($user_id));
      $row=$query->row_array();
      
      $user_name=$row['user_name'];
      $user_id=$row['user_id'];
      $user_course=$row['user_course'];
      $user_degree=$row['user_degree'];
      $user_year=$row['user_year'];
      $group_id=$row['group_id'];
      $password=$row['password'];
    
      $sql1="insert into USER_HISTORY_LOG(user_name,user_id,user_course,user_degree,user_year,group_id,password) values(?,?,?,?,?,?,?)";
      $query=$this->db->query($sql1,array($user_name,$user_id,$user_course,$user_degree,$user_year,$group_id,$password));
      if($query==1){
        $sql1="delete from USERS
              where user_id=?";
        $query=$this->db->query($sql1,array($user_id));
        return "ADDED SUCCESSFULLY";
      }
      else
        return 'User could not be deleted. Please Try again.';

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