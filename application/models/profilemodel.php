<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProfileModel extends CI_Model{

	function getCenterContent(){


		return ' <form id="login" enctype="application/x-www-form-urlencoded" class="form-vertical login"
        accept-charset="utf-8" method="post" action="../models/Authmodel/authenticate" >
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
  function isStudent($user_id){
    $sql="select user_level from USERS where user_id=?";
    $query=$this->db->query($sql,array($user_id)); 
    $row=$query->row_array();  
    if($row['user_level']!=2)
      return true;
    else
      return false;
    

  }
  function getTeacherProfile($user_id){
      

    
      $sql='select t.user_id,u.user_name,u.user_degree,u.user_course,u.group_id,
        t.graduated_at,t.field_of_interest
        from USERS u,TEACHER_DETAILS t where t.user_id=u.user_id and u.user_id=?';
      $query=$this->db->query($sql,array($user_id));
      if($row=$query->row_array()){
       if($row['graduated_at']){
        $graduated_at='  <div class="well">
      graduated in:'.$row['graduated_at'].'
      </div>';

       }
       else{
        $graduated_at='';
       }
       if($row['field_of_interest']){
        $field=' <div class="well">
      Field of interest:'.$row['field_of_interest'].'
      </div>';
       }else{
        $field='';
       }
       $CI=&get_instance();
       if($user_id==$CI->session->userdata('user_id')){
          $edit='
      <a href="'.base_url().'/ProfileController/EditTeacherProfile/'.$user_id.'" class="btn btn-primary disabled"><i class="icon-cog"></i>EditProfile</a>';
       }
       else
         $edit='';



      return '<div class="well">
      <table>
      <tr>
            <td>Name:
            </td>
            <td>'.$row['user_name'].'
            </td>
     
      </tr>
      </table>
      </div>
      

      <div class="well">
          <div class="ask-dp pull-right">
              <img src="'.base_url().'assets/img/users/'.$row['user_id'].'.jpg">
          </div>
           
            Department:<a href="'.base_url().'ProfileController/ViewGroupProfile/'.$row['user_id'].'">'.$this->getGroupName($row['group_id']).'</a>
     </div>
        
        


          <div class="well">
      classes handled:to be included soon
      </div>
      '.$graduated_at.$field.$edit.'
     


            
      ';
    }
      else{

        return 'sorry.this user doesnt exist ';

    }
  }




  function getTopicProfile($topic_url){

    $sql="select * from TOPIC where topic_url=?";
    $query=$this->db->query($sql,array($topic_url)); 
    if($row=$query->row_array()){
    $sql1="select count(*) from QUESTION where topic_id=?";
    

    $query1=$this->db->query($sql1,array($row['topic_id'])); 
    $row1=$query1->row_array();
    $followUrl=  base_url().'QuestionsController/followTopic/';
     $unfollowUrl= base_url().'QuestionsController/unfollowTopic/';
     $CI =& get_instance();
     $currentUserId=$CI->session->userdata('user_id');
     $currentUrl=urlencode(current_url());
      if($this->questionsmodel->sqlCheckUserFollowsTopic($currentUserId,$row['topic_id']))

  $dynamicFollowOrUnfollowButton='
          <i class="icon-minus-sign"></i>
                  <a href="'.$unfollowUrl.$row['topic_id'].'?redirectUrl='.$currentUrl.'" rel="tooltip" data-placement="bottom" 
                    data-original-title="Click to unfollow the question!">Unfollow</a>';
      else
        $dynamicFollowOrUnfollowButton='
          <i class="icon-plus-sign"></i>
                  <a href="'.$followUrl.$row['topic_id'].'?redirectUrl='.$currentUrl.'" rel="tooltip" data-placement="bottom" 
                    data-original-title="Click to follow the question!">Follow</a>';

    if($row['topic_desc']){
      $topicDescMarkup=$row['topic_desc'].'<br><a href='.base_url().'ProfileController/editTopicDesc/'.$row['topic_id'].'>Edit description</a>';
    }
    else{
      $topicDescMarkup='No description yet!!!<a href='.base_url().'ProfileController/editTopicDesc/'.$row['topic_id'].'>Add description</a>';
    }
    return ' <div class="ask-dp pull-right">
              <img src="'.base_url().'assets/img/topics/'.$row['topic_id'].'.jpg">
              </div>
            <div> <h2>'.$row['topic_name'].'</h2><br>About:'.$topicDescMarkup.'<div style="float:right">'.$dynamicFollowOrUnfollowButton.'</div>
        
              </div> <div class="well" >No Of Questions: '.$row1['count(*)'].' </div>

         <div><a rel="tooltip" data-placement="bottom" 
                    data-original-title="'.
                    $this->questionsmodel->sqlGetFollowersForTopic($row['topic_id'])
                    .'">
                    '.$this->questionsmodel->sqlGetFollwersCountForTopic($row['topic_id']).'
                    Followers</a>

                  <div style="float:right"><br>
                  
        </div>
        </div>
        
                '.$this->getTopicFollowersImage($row['topic_id']).'

                <br>
                <br>
                <br>
        
      
         ';}
         else{
          return 'sorry this topic doesnt exist ';

    }
  }
    function getTopicFollowersImage($topic_id)
    {
      $sql="select * from TOPIC_FOLLOWERS where topic_id=?";
       $query=$this->db->query($sql,array($topic_id)); 
        $result=$query->result_array();
        $content='';
        foreach($result as $row){

      $content.='<a href="'.base_url().'ProfileController/ViewUserProfile/'.($row['follower']).'">
        <img class="thumbnail" height="25px" width="25px" align="left" src="'.base_url().'assets/img/users/'.$row['follower'].'.jpg" alt="">
        </a>';
      }
      return $content;
    }
      function getGroupMembersImage($group_id)
    {
      $sql="select * from USERS where group_id=?";
       $query=$this->db->query($sql,array($group_id)); 
        $result=$query->result_array();
        $content='';
        foreach($result as $row){

      $content.='<a href="'.base_url().'ProfileController/ViewUserProfile/'.($row['user_id']).'">
     
        <img class="thumbnail" height="25px" width="25px" align="left" src="'.base_url().'assets/img/users/'.$row['user_id'].'.jpg" alt="">
        </a>';
      }
      $content.='<br> <br> <br>';
        return $content;
    

  }
   function EditTopicDesc($topic_id){

    $sql="select topic_desc from TOPIC where topic_id=?";
    $query=$this->db->query($sql,array($topic_id));
    $row=$query->row_array();
    return '
     <h4>Please write the topic description <h4>
     <form class="form-horizontal" id="editTopicDesc" method=\'post\' action=\''.base_url().'ProfileController/editTopicDescAgain/'.$topic_id.'\'>
    <textarea id="EditTopicDesc" > '.$row['topic_desc'].'</textarea> <br>
    <input type="Submit" id="TopicDesc" "" name="TopicDesc"> </input>'
    ;

}
  function editTopicDescAgain($topic_desc,$topic_id)
  {
    $sql="update TOPIC set topic_desc='?' where topic_id=? ";
    if($query=$this->db->query($sql,array($topic_desc,$topic_id)))
     { return 'Topic Description Updated!';
      $sql="insert into TOPIC_DESC_HISTORY values(?,?)";
       $query=$this->db->query($sql,array($topic_desc,$topic_id));
     }
    else
      return 'Cannot be updated!';
}

   function getCategoryProfile($category_id){

    $sql="select * from CATEGORY where category_id=?";
    $NoOfTopics="select count(*) from CATEGORY c,TOPIC t where c.category_id=t.category_id and c.category_id=?";
    $NoOfQuestions="select count(*) FROM CATEGORY c, TOPIC t, QUESTION q WHERE c.category_id = t.category_id AND t.topic_id = q.topic_id AND c.category_id =?";
    $query=$this->db->query($sql,array($category_id)); 
    $query1=$this->db->query($NoOfTopics,array($category_id)); 
    $query2=$this->db->query($NoOfQuestions,array($category_id));    
    $row=$query->row_array();
    $row1=$query1->row_array();
      $row2=$query2->row_array();
    
    return '<h2>'.$row['category_name'].'</h3>
            <div class="ask-dp pull-right">
            <img src="'.base_url().'assets/img/category/'.$row['category_id'].'.jpg">
            </div>
     <div class="well">
        
         About:'.$row['category_desc'].'
        <br>
        
        </div>
        <div class=well>
        
        No of Questions under this category: '.$row2['count(*)'].'<br> <br>

        No of Topics under this category: '.$row1['count(*)'].'<br> <br>

        <a href="'.base_url().'QuestionsController/ViewTopicsInCategory/'.$row['category_id'].'" > Click here </a> to view all the topics list! 
        </div>
         ';

    }
function getInterimProfile(){       
    return ' <div class="well">
        
        <a href="#">
        <img class="thumbnail" height="200px" width="140px" src="'.base_url().'assets/img/welcome.jpg" alt="">
       </a>      
<h3> Privileges of Interim Users are: </h3>
<p>1) Can View (Not Answer) the global scope questions. </p>
<p>2)As soon as the admin aprroves your account, you will be able to access all the facilities of AskCEG. :) </p>
      <div class="well">
        Questions posted  in the Global scope..
        </div>
         ';






  } 


     function loginForm(){
         $base_url=base_url();
        return ' <form id="login" enctype="application/x-www-form-urlencoded" class="form-vertical login"
        accept-charset="utf-8" method="post" action="'.$base_url.'AuthController/process_login">
            <div class="control-group error">
                <label for="email" class="control-label required">User id</label>
                <div class="controls">
                    <input type="text" name="user_id" id="user_id" data-title="Invalid email" value="" tabindex="1">
                </div>
            </div>
            <div class="control-group">
                <label for="password" class="control-label required">Password (
                    <a href="#" class="trigger-lightbox validate-resetpassword">forgot password</a>)</label>
                <div class="controls">
                    <input type="password" name="user_pass" id="user_pass" data-title="Invalid password" value="" tabindex="2">
                </div>
            </div>
            <div class="form-actions">
        <button name="submit" id="loginbutton" data-loading-text="logging in.." onclick="javascript:dologin();return false;" 
                tabindex="3" class="btn btn-primary">Log In</button>
                <button name="cancel" id="cancel" type="reset" data-dismiss="modal" class="btn">Cancel</button>
            </div>
        </form>
        New User? <a href="'.base_url().'AuthController/RequestAccount">Click here to create your account.</a>
    ';



    }
    function getGroupId($user_id){
      echo $user_id;
     $sql='select group_id from USERS where user_id=?';
     $query=$this->db->query($sql,array($user_id));   
       if($row=$query->row_array())
        echo 'Yess';
      else
        echo 'No';
       return $row['group_id'];
     }
     function getYearUserPhoto($year_id){//get the photos of users belonging to specified year
          $sql="select user_id from USERS where user_year=?";
           $query=$this->db->query($sql,array($year_id));
           $result=$query->result_array();
           $imageMarkup='<div class="well1">';
           $i=0;
           foreach($result as $row){
            if($i%8==0&&$i!=0){
              $imageMarkup.='</div><div class="well1">';
              
            }
            $imageMarkup.='<a href="'.base_url().'ProfileController/ViewUserProfile/'.($row['user_id']).'">
        <img class="thumbnail" height="75px" width="75px" align="left" src="'.base_url().'assets/img/users/'.$row['user_id'].'.jpg" alt="">
        </a>';
      
           $i++;
            }
            $imageMarkup.='</div>';
            
            return $imageMarkup;
      }


      function getYearProfile($user_year){
            $CI =& get_instance();
    $currentUserId=$CI->session->userdata('user_id');
    $yearId=$CI->session->userdata('user_year');
   $sql='select * from USERS where user_year=?';
      $query=$this->db->query($sql,array($user_year));
      $row=$query->row_array();



    return '       
        <div class="well">
        
        
        <img  height="200px" width="740px" src="'.base_url().'assets/img/year/year1.jpg" alt="">
        <h3> Year '.$user_year.'</h3>
        <br>
        
        </div>
        
        
     
    
         '.$this->getYearUserPhoto($user_year).'
        
          

         ';

    }

    function getGroupProfile($group_id){
            $CI =& get_instance();
            $currentUserId=$CI->session->userdata('user_id');
            $sql='select user_level from USERS where user_id=?';

            $query=$this->db->query($sql,array($currentUserId));   
            $row=$query->row_array();
            $AdminMarkup='';
            if($row['user_level']>='1'&& $row['user_level']!='2'){
            $AdminMarkup='<input type="button" value="Add/Remove users" onclick="window.location =\''.base_url().'AuthController/AddRemoveuser/'.'\';">
            ';
             }
            $sql='select * from GROUPS where group_id=?';

            $query=$this->db->query($sql,array($group_id));
            $row=$query->row_array();



        return '<div class="well">
        
       '.$row['group_name'].'
        <div class="ask-dp pull-right">
            <img src="'.base_url().'assets/img/group/'.$row['group_id'].'.jpg">
        </div>
        <br>
        '.$AdminMarkup.'
        </div>
        <div class="well">
        group_desc
       '.$row['group_desc'].' 

        
        
        </div>
        
     
        <div class="well1">
        Group members photo:
        </div>
        <div>'.$this->getGroupMembersImage($group_id).' </div>
        <div class="well">
        questions posted by the group members in the group scope
        </div>
         ';

    }

    
    
    function getUserProfile($user_id){

    
      $sql='select * from USERS where user_id=?';
      $query=$this->db->query($sql,array($user_id));
      $row=$query->row_array();
      $CI=&get_instance();
      if($user_id==$CI->session->userdata('user_id')){
          $edit='
      <a href="'.base_url().'/ProfileController/EditStudentProfile/'.$user_id.'" class="btn btn-primary disabled"><i class="icon-cog"></i>EditProfile</a>';
       }
       else
         $edit='';




      return'<div class="well">
      <table>
      <tr>
            <td>Name:
            </td>
            <td>'.$row['user_name'].'
            </td>
             <div class="ask-dp pull-right">
            <img src="'.base_url().'assets/img/users/'.$row['user_id'].'.jpg">
            </div>
     
      </tr>
      </table>
      </div>
      <div class="well">
      <table>
      <tr>
           <td>Group/Batch :
           </td>
           <td><a href="'.base_url().'ProfileController/ViewGroupProfile/'.$row['group_id'].'">'.$this->getGroupName($row['group_id']).'</a>
           </td>


      </tr>
      </table>
      </div>
      
<div class="well">
      <table>
      <tr>
          <td>Year:
          </td>
          <td><a href="'.base_url().'ProfileController/ViewYearProfile/'.$row['user_year'].'"> '.$row['user_year'].'</a>
          </td>

      </tr>
      </table>
      </div>
      
      <div class="well">
      <table>
      <tr>
          <td>Degree and Course:
          </td>
          <td>'.$row['user_degree'].'-'.$row['user_course'].'
          </td>

      </tr>
      <tr>
        '.$edit.'
      </tr>
      </table>
      </div>
    ';
    

    }
    function getGroupName($group_id){
      $sql='select group_name from GROUPS where group_id=?';
      $query=$this->db->query($sql,array($group_id));
       $row=$query->row_array();
       return $row['group_name'];

    }
	 function getCenterContentMyProfileEdit(){

     return '<fieldset>
                 <label class="control-label" for="name">Your Name</label>
                  <div class="controls">
                  <input type="text" class="input-xlarge" name="name" id="name" value="vishnu jayvel">
                  
                  </div>
                  <br>
                 
                <label class="control-label" for="sex">Sex</label>
                  <div class="controls">
                  
                  <label class="radio">
                    <input type="radio" name="sex" id="sexRadios1" value="1" checked="">
                    Male
                  </label>
                  
                  <label class="radio">
                    <input type="radio" name="sex" id="sexRadios2" value="2">
                    Female
                  </label>
                  
                  <label class="radio">
                    <input type="radio" name="sex" id="sexRadios3" value="3">
                    Other
                  </label>
                  
                  
                  </div>
                 <br> 
                  <label class="control-label" for="email">Email Address</label>
                  <div class="controls">
                  <input type="text" class="input-xlarge" name="email" id="email" disabled="readonly" value="vishnuj81093@gmail.com">
                  </div>
                  <label class="controls checkbox">
                    <input id="shareemail" type="checkbox" checked="checked"> Show email to others
                  </label> 
                  
                <br>
                 <label class="control-label" for="phone">Phone Number</label>
                  <div class="controls">
                  <input type="text" class="input-xlarge" name="phone" id="phone" value="8220557222">
                   
                  </div>
                 <br>
                
                <label class="control-label" for="acctype">Account Type</label>
                  <div class="controls">
                  <select class="span3" id="acctype" onchange="changeform();">
                   <option value="coll" selected="selected">College Student</option>
                   <option value="school">School Student</option>
                   <option value="fac">Faculty</option>
                   <option value="corp">Corporate</option>
                  </select>   
                  
                   
                  </div>
                <br>
                  <div id="dynamic"><label class="control-label" for="institution">Your Institution</label>
                  <div class="controls">
                  
                  </div>
                <br>

                  <label class="control-label" for="degree">Your degree</label>
                  <div class="controls">
                  <select class="span3" id="degree">
                   <option value="1" selected="selected"> B.E </option><option value="2">B.A</option><option value="3">B.Arch</option><option value="4">B.Com</option><option value="5">B.Sc</option><option value="6">B.Tech</option><option value="7">BBA</option><option value="8">BCA</option><option value="9">DEEE</option><option value="10">Diploma</option><option value="11">Dual Degree</option><option value="12">Intermediate</option><option value="13">M.A</option><option value="14">M.E</option><option value="15">M.Sc</option><option value="16">M.Sc(Integrated)</option><option value="17">M.Tech</option><option value="18">MBA</option><option value="19">MCA</option><option value="20">MS</option><option value="21">Ph.D</option><option value="22">Other</option>   
                  </select>
                   
                  </div>
                 <br>

                  <label class="control-label" for="branch">Your Course</label>
                  <div class="controls">
                  <select class="span3" id="course">
                    <option value="1">Aeronautical Engineering</option><option value="2">Aerospace Engineering</option><option value="3">Agricultural &amp; Irrigation Engineering</option><option value="4">Aircraft Maintenance Engineering</option><option value="5">Animation</option><option value="6">Apparel technology</option><option value="7">Applied electronics</option><option value="8">Applied Mathematics</option><option value="9">Architecture</option><option value="10">Automobile Engineering</option><option value="11">Avionics</option><option value="12">Bio Informatics</option><option value="13">Bio Medical Engineering</option><option value="14">Biotechnology</option><option value="15">Ceramic Technology</option><option value="16">Charted Accountancy</option><option value="17">Chemical Engineering</option><option value="18">Chemistry</option><option value="19">Civil Engineering</option><option value="20">Communication Systems</option><option value="21" selected="selected">Computer Science &amp; Engineering</option><option value="22">Cryogenic Engineering</option><option value="23">Elecrical Engineering</option><option value="24">Electrical &amp; Electronics Engineering</option><option value="25">Electronic media</option><option value="26">Electronics &amp; Communication Engineering</option><option value="27">Electronics &amp; Instrumentation</option><option value="28">Embedded Systems</option><option value="29">Energy Engineering</option><option value="30">Engineering Design</option><option value="31">Engineering Physics</option><option value="32">English Literature</option><option value="33">Finance</option><option value="34">Fluid Mechanics</option><option value="35">Food Technology</option><option value="36">Geo Informatics</option><option value="37">Harbour Engineering </option><option value="38">High Voltage Engineering</option><option value="39">Hospitality Administration</option><option value="40">HR</option><option value="41">Humanities &amp; Social Sciences</option><option value="42">Industrial Engineering</option><option value="43">Information &amp; Communications Technology</option><option value="44">Information Technology</option><option value="45">Internal Combustion Engineering</option><option value="46">Logistics</option><option value="47">Manufacturing Engineering</option><option value="48">Marine Engineering</option><option value="49">Marketing</option><option value="50">Material Science </option><option value="51">Mathematics</option><option value="52">Mechanical Engineering</option><option value="53">Mechatronics</option><option value="54">Media Sciences</option><option value="55">Metallurgy</option><option value="56">Mining Engineering</option><option value="57">Nano Science and Technology</option><option value="58">Photonics </option><option value="59">Physics</option><option value="60">Printing Technology</option><option value="61">Production Engineering</option><option value="62">Remote Sensing</option><option value="63">Software Engineering</option><option value="64">Systems Engineering &amp; Operations Research</option><option value="65">Technology Managment</option><option value="66">Telecommunication Engineering</option><option value="67">Textile Technology</option><option value="68">Theoretical Computer Science</option><option value="69">Thermal</option><option value="70">Transportation Engineering</option><option value="71">VLSI Design</option><option value="72">Other</option>  
                  </select>   
                  
                  </div>
                <br>

                  <label class="control-label" for="year">Your Year Of Study</label>
                  <div class="controls">
                  <label class="radio">
                    <input type="radio" name="year" id="optionsRadios1" value="1">
                    1
                  </label>
                  <label class="radio">
                    <input type="radio" name="year" id="optionsRadios2" value="2" checked="checked">
                    2
                  </label>
                  <label class="radio">
                    <input type="radio" name="year" id="optionsRadios3" value="3">
                    3
                  </label>
                  <label class="radio">
                    <input type="radio" name="year" id="optionsRadios4" value="4">
                    4
                  </label>
                  <label class="radio">
                    <input type="radio" name="year" id="optionsRadios5" value="5">
                    5
                  </label>
                  
                  </div></div><!-- end of account type div. This is dynamic part of the form -->
                 <br>
                 <label class="controls checkbox">
                    <input id="shareprofile" type="checkbox" checked="checked"> Show profile to others
                  </label> 
                <br>
          
          <div class="alert fade in" id="form-err" style="display:none">
          <span id="form-err-text"></span>
            </div>
          
                <br>
                <label class="controls">
                  <button id="updateButton" class="btn btn-primary btn-large" data-loading-text="saving.." onclick="Javascript:verify();" type="button">Save</button>
                 <label>
                 </label></label></fieldset>';
    



  }
  //$a=array();


	function getCenterContentMyGroup(){

    $CI =& get_instance();
    $currentUserId=$CI->session->userdata('user_id');
    $groupId=$CI->session->userdata('group_id');
    $sql='select user_level from USERS where user_id=?';

    $query=$this->db->query($sql,array( $currentUserId));
     $row=$query->row_array();
     $AdminMarkup='';
     if($row['user_level']>='1'&& $row['user_level']!='2')
     {
        $AdminMarkup=' 
        <div class="well"> <p>
                      <a href="'.base_url().'ProfileController/ViewAdminPrivileges/'.'"> Click here </a> to see Admin Privileges!! 
                       </p><p> </p> <p> </p>';
        $AdminMarkup.='<p> <input type="button" value="Add/Remove users" onclick="window.location =\''.base_url().'AuthController/AddRemoveuser/'.'\';">
        </p> </div>';
      }

    
    $sql='select * from GROUPS  where group_id=?';
    $query=$this->db->query($sql,array($groupId));
    $row=$query->row_array();
    
		return '        <div class="well">
        
        <a href="#">
        <img class="thumbnail" height="200px" width="140px" src="'.base_url().'assets/img/group/'.$row['group_id'].'.jpg" alt="">
        </a>'.$row['group_name'].'
        <br>
        </div>
        '.$AdminMarkup.'
        
        
        <div class="well">
        group_desc
       '.$row['group_desc'].' 

        
        
        </div>
        
     
        <div class="well">
        group members photo
        </div>
        <div>'.$this->getGroupMembersImage($groupId).' </div>
        <div class="well">
        questions posted by the group members in the group scope
        </div>
        
         ';

	}

  function getAdminPrivileges(){
    return '
           <h3> Welcome, Admin </h3>
           <div class="well">
           <h4> ADMIN PRIVILEGES ARE: </h4>
           <p> In order to avoid duplicate profiles, the users of your batch cannot be addedd to the group without your permission </p>
           <p> The students can register themselves and becomes INTERIM user (temperory). </p>
           <p> It is you duty to add ONLY your batch people to your group. </p>
           <p> You can do so by clicking on the Add/Remove people button that you see on your group profile page</p>
           <p> Still not clear? Feel free to contact us. We are more than happy to be of help to you </p>
           </div>
           ';
         }

function getCenterContentMyYear(){

     $CI =& get_instance();
    $currentUserId=$CI->session->userdata('user_id');
    $yearId=$CI->session->userdata('user_year');
    echo "$yearId";
   $sql='select * from USERS where user_year=?';
      $query=$this->db->query($sql,array($yearId));
      $row=$query->row_array();



    return '        <div class="well">
        
        <a href="#">
        <img class="thumbnail" height="200px" width="140px" src="'.base_url().'assets/img/year.jpg" alt="">
      </a> YEAR:'.$row['user_year'].'
         <br>
        
        </div>
        <div class="well">
        Department:
       '.$row['user_course'].' 

        
        
        </div>
        
     
        <div class="well">
        Photo of members of this year..
        </div>
        <div class="well">
        Questions posted by the group members in the Year scope..
        </div>
         ';

  }



}
