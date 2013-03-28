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
    if( $row=$query->row_array()){  
    if($row['user_level']!=2)
      return true;
    else
      return false;
    }
    else
      return null;

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
      <a href="'.base_url().'ProfileController/EditTeacherProfile/'.$user_id.'" class="btn btn-primary disabled"><i class="icon-cog"></i>EditProfile</a>';
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

    $sql="select t.topic_url,t.topic_id,t.topic_name,t.topic_desc, c.category_id,c.category_name
     from TOPIC t,CATEGORY c 
    where t.category_id=c.category_id and t.topic_url=?";
    $query=$this->db->query($sql,array($topic_url)); 
    if($row=$query->row_array()){
    $sql1="select count(*) from QUESTION where topic_id=?";
    

    $query1=$this->db->query($sql1,array($row['topic_id'])); 
    $row1=$query1->row_array();
     $CI =& get_instance();
     $currentUserId=$CI->session->userdata('user_id');
      if($this->questionsmodel->sqlCheckUserFollowsTopic($currentUserId,$row['topic_id'])){

        $dynamicFollowOrUnfollowButton='
          <a href="#" class="topicFollowButton" data-follow_status="yes" data-topic_id="'.$row['topic_id'].'" rel="tooltip" data-placement="top" 
          data-original-title="Click to unfollow the topic!">
          <i class="icon-minus-sign"></i>
          Followed</a>';

      }
      else{
        $dynamicFollowOrUnfollowButton='
        <a href="#" class="topicFollowButton" data-follow_status="no" data-topic_id="'.$row['topic_id'].'" rel="tooltip" data-placement="top" 
        data-original-title="Click to Follow the topic!">
        <i class="icon-plus-sign"></i>
        Follow</a>';

      }

    if($row['topic_desc']){
      $topicDescMarkup=$row['topic_desc'].'<br><a href='.base_url().'ProfileController/editTopicDesc/'.$row['topic_id'].'>Edit description</a>';
    }
    else{
      $topicDescMarkup='No description yet!!!<a href='.base_url().'ProfileController/editTopicDesc/'.$row['topic_id'].'>Add description</a>';
    }
    return ' 
    <div class="profileContainer">
      <div class="profileHolder">
        <div class="span6 pull-left style="min-height: 200px;">      
          <div class="profilePicHolder">
            <img src="'.base_url().'assets/img/topics/'.$row['topic_id'].'.jpg" alt="300x200" style="width: 300px; height: 200px;">
          </div>
          <div class="profileTitle caption">
            <h3>'.$row['topic_name'].'</h3>
          </div>
          <div class="profileDesc">
              '.$topicDescMarkup.'
          </div>
        </div><!--/span6-->
        <div class="span6 pull-left">
          <div class="profileFollowersHolder">
            '.$this->getTopicFollowersImage($row['topic_id']).'
          </div>
          <div class="profileFollowButtonHolder">
            '.$dynamicFollowOrUnfollowButton.'
          </div>
          <div class="profileStatsHolder">
            No Of Questions: '.$row1['count(*)'].' 
            <a class="followersInfoTooltip" rel="tooltip" data-placement="bottom" data-type="topic"
              data-q_id="'.$row['topic_id']
              .'">
              <span class="followersCountSpan" data-topic_id="'.$row['topic_id'].'"> '.$this->questionsmodel->sqlGetFollwersCountForTopic($row['topic_id']).'
              </span>Followers</a>
          </div>
        </div><!--/span6-->
      </div>
    </div>

    <div class="postQsButtonHolder well">
      Do you want to ask something here ?
      <a class="directQsPostButton btn btn-primary">Post Question</a>
    </div> 

    <!--Modal to post direct qs -->
    <div id="postDirectQsModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Post a new question in '.$row['topic_name'].'</h3>
      </div>
      <div class="modal-body">
        <form class="form-horizontal well">
        <fieldset>
          <div class="control-group">
            <label class="control-label" for="categorySelectBox">Category</label>
            <div class="controls">
              <select id="categorySelectBox" data-qs_type="popup">
                <option value="'.$row['category_id'].'">'.$row['category_name'].'</option> 
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="topicSelectBox">Topic</label>
            <div class="controls">
              <select id="topicSelectBox" data-qs_type="popup" >
                <option value="'.$row['topic_id'].'">'.$row['topic_name'].'</option>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="textarea">Question</label>
            <div class="controls">
              <textarea  id="questionText" class="input-xlarge" data-qs_type="popup" rows="3"></textarea>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="textarea">Question Description (Optional)</label>
            <div class="controls">
              <textarea  id="questionDescText"  data-qs_type="popup" class="input-xlarge" rows="3"></textarea>
            </div>
          </div>
          <div class="control-group">
            <div class="controls">
              <label class="checkbox">
                <input id="anonymousCheckbox"  data-qs_type="popup" type="checkbox" value="true">
                Post Anonymously
              </label>
            </div>
          </div>   
          <label class="control-label" for="scope">Scope</label>
          <div class="controls">
            <div class="btn-group" data-toggle="buttons-radio" data-toggle-name="scope" id="scopegroup">
              <button class="btn active " type="button" rel="tooltip" data-placement="top" data-original-title="visible to all" name="scope" id="scope1" value="1" checked="">
              public</button>
              <button class="btn  " type="button" rel="tooltip" data-placement="top" data-original-title="visible only to your group people" name="scope" id="scope3" value="2">
              private(your group)</button>
            </div>         
          </div>                      
          <div class="form-actions">
            <a disabled=true id="postQuestionButton" data-qs_type="popup" type="submit" 
            class="btn btn-danger">
              <i class="icon-ok icon-white"></i>Post It
            </a>
            <a id="resetQuestionButton" type="reset" data-qs_type="popup" class="btn btn-primary">
              <i class="icon-remove icon-white"></i>Reset
            </a>
          </div>
        </fieldset>
      </form>
      </div>
    </div>
    <!--/modal -->

    ';
  }
         else{
          return 'sorry this topic doesnt exist ';

    }
  }
    function getTopicFollowersImage($topic_id)
    {
      $sql="select t.user_id,u.profile_pic,u.email_id from TOPIC_FOLLOWERS t,USERS u where topic_id=? and t.user_id=u.user_id";
       $query=$this->db->query($sql,array($topic_id)); 
        $result=$query->result_array();
        $content='';
       
        foreach($result as $row){
           if(strlen($row['profile_pic'])==0||strlen($row['profile_pic'])==1){
             $email=$row['email_id'];
             $url=$this->get_gravatar($email);
          }
      else
             $url=$row['profile_pic'];
      

      $content.='<a href="'.base_url().'ProfileController/ViewUserProfile/'.($row['user_id']).'">
        <img class="thumbnail" height="25px" width="25px" align="left" src="'.$url.'" alt="">
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
           if(strlen($row['profile_pic'])==0||strlen($row['profile_pic'])==1){
             $email=$row['email_id'];
             $url=$this->get_gravatar($email);
          }
      else
             $url=$row['profile_pic'];
      

      $content.='<a href="'.base_url().'ProfileController/ViewUserProfile/'.($row['user_id']).'">
        <img class="thumbnail" height="25px" width="25px" align="left" src="'.$url.'" alt="">
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
function sqlgetCategoryId($category_url){
  $sql="select category_id from CATEGORY where category_url=?";
   $query=$this->db->query($sql,array($category_url)); 
   if($row=$query->row_array())
   return $row['category_id'];
 else
  return 0;
   
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
    
    return '<h2>'.$row['category_name'].'</h2>
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
        return ' <div id="normallogin" class="span6">
        <form id="login" enctype="application/x-www-form-urlencoded" class="form-vertical login"
        accept-charset="utf-8" method="post" action="'.$base_url.'AuthControllerAsk/processNormalLogin">
            <div class="control-group error">
                <label for="email" class="control-label required">email id</label>
                <div class="controls">
                    <input type="email" name="email" id="email" value="" required="required" placeholder="you@mail.com,.."  >
                </div>
            </div>
            <div class="control-group">
                <label for="password" class="control-label required">Password (
                    <a href="#" class="trigger-lightbox validate-resetpassword">forgot password</a>)</label>
                <div class="controls">
                    <input id="pass" name="pass" required="required" placeholder="******" type="password"/> 
                    </div>
            </div>
            <div class="form-actions">
        <button name="submit" id="loginbutton" data-loading-text="logging in.." onclick="javascript:dologin();return false;" 
                tabindex="3" class="btn btn-primary">Log In</button>
                <button name="cancel" id="cancel" type="reset" data-dismiss="modal" class="btn">Cancel</button>
            </div>
        </form>
        New User? <a href="'.base_url().'AuthControllerAsk/normalsignup">Click here to SIGNUP</a>
    </div>
    <div id="fblogin" class="span6">
    </br>
    </br>
    </br>
    Just one click to use AskCEG!!!
    <a class="fbLoginStatus" href="#">
    <img src="http://askceg.in/ask/assets/img/btns/fbLoginRegister.png">
    </a>
    </div>
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
            <img src="'.base_url().'assets/img/groups/'.$row['group_id'].'.jpg">
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
         ';

    }

    
     function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
              if ( $img ) {
              $url = '<img src="' . $url . '"';
              foreach ( $atts as $key => $val )
                  $url .= ' ' . $key . '="' . $val . '"';
              $url .= ' />';
          }
     return $url;
    }
    function getUserProfile($user_id){

    
      $sql='select * from USERS where user_id=?';
      $query=$this->db->query($sql,array($user_id));
    if($row=$query->row_array()){
      $CI=&get_instance();
      if($user_id==$CI->session->userdata('user_id')){
          
     $edit=' <a href="'.base_url().'ProfileController/EditProfile" class="btn btn-primary disabled"><i class="icon-cog"></i>EditProfile</a>';
 }
       else
         $edit='';
    //groupMarkup
      if($row['group_id']==0){
        $q="select * from GROUP_REQUEST where user_id=?";
          $qu=$this->db->query($q,array($user_id));
          if($r=$qu->row_array()){
            $groupMarkup='<td><a href="'.base_url().'ProfileController/ViewGroupProfile/'.$r['group_id'].'">'.$this->getGroupName($r['group_id']).'(request pending)</a>
                   </td>
                  ';
          }
          else{
        $groupMarkup="Batch info not updated yet";
          }
      }
      else{
        $groupMarkup='<td><a href="'.base_url().'ProfileController/ViewGroupProfile/'.$row['group_id'].'">'.$this->getGroupName($row['group_id']).'</a>
                   </td>
                  ';
      }  
       //yearMarkup
      if($row['user_year']==0){

          

          $yearMarkup="year info not updated yet";
      }
      else{
        $yearMarkup='<a href="'.base_url().'ProfileController/ViewYearProfile/'.$row['user_year'].'"> '.$row['user_year'].'</a>
                 ';

      }          
      //userpic markup
     
      if(strlen($row['profile_pic'])==0||strlen($row['profile_pic'])==1){
        $email=$row['email_id'];
         $url=$this->get_gravatar($email);
      }
      else
        $url=$row['profile_pic'];
      

      return'<div class="well">
              <table>
              <tr>
                    <td>Name:
                    </td>
                    <td>'.$row['user_name'].'
                    </td>
                     <div class="ask-dp pull-right">
                    <img src="'.$url.'">
                    </div>
              </tr>
              </table>
              </div>
              <div class="well">
              <table>
              <tr>
                   <td>Group/Batch :
                   </td>
                   <td>'.$groupMarkup.'
              </tr>
              </table>
              </div>
              
        <div class="well">
              <table>
              <tr>
                  <td>Year:
                  </td>
                  <td>
                 '.$yearMarkup.' </td>

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

    }
    function getGroupName($group_id){
      $sql='select group_name from GROUPS where group_id=?';
      $query=$this->db->query($sql,array($group_id));
       if($row=$query->row_array())
       return $row['group_name'];

    }
    function sqlEditStudentProfile($account,$user_id){
        $base_url=base_url();

      $sql="update USERS set user_name=?,email_id=?,user_year=?,user_degree=?,user_course=? where user_id=?";
       if($query=$this->db->query($sql,array($account['user_name'],$account['user_email'],$account['user_year'],$account['user_degree'],$account['user_course'],$user_id)))
        return 1;
      else
        return 'something went wrong ';
    
    }
    function sqlSendGroupRequest($group_id){

      $CI=&get_instance();
      $user_id=$CI->session->userdata('user_id');
      $sql="INSERT into GROUP_REQUEST(user_id,group_id) values(?,?)";
      if($query=$this->db->query($sql,array($user_id,$group_id)))
        return 1;
      else
        return 0;

    }
    function sqlCancelGroupRequest($user_id){
         $sql="DELETE from GROUP_REQUEST where user_id=?";
          if($query=$this->db->query($sql,array($user_id)))
        return 1;
      else
        return 0;

    }
	 function getStudentProfileEdit($user_id){
    $sql="select * from USERS where user_id=?";
    $query=$this->db->query($sql,array($user_id));
    if($row=$query->row_array()){
    $batchOptionMarkup='
          ';
     //profile pic markup
          $msg='';
    if($row['profile_pic']==0||$row['profile_pic']==null||$row['profile_pic']==''){
        $email=$row['email_id'];
         $url=$this->get_gravatar($email);
         $msg='change your profile pic using gravatar.<a href="https://en.gravatar.com/">click here!</a>';
      }
      else
        $url=$row['profile_pic'];
      

    $profilePicMarkup= '<a rel="tooltip" data-placement="bottom" data-original-title="'.$row['user_name'].'" href="'.base_url().'ProfileController/ViewUserProfile/'.$user_id.'">
              <img src="'.$url.'" alt="'.$row['user_name'].'" class="display-pic" />
            </a>'.$msg.'</br>';


    if($row['group_id']==0){
      $sql0="select r.group_id,g.group_name from GROUP_REQUEST r, GROUPS g where user_id=? and r.group_id=g.group_id";
      $query0=$this->db->query($sql0,array($user_id));
              if($row0=$query0->row_array()){
                $batchOptionMarkup='You have given request to join '.$row0['group_name'].'<a href="'.base_url().'ProfileController/cancelGroupRequest">cancel request</a>';
              }
              else{
              $batchOptionMarkup.='<div class="control-group">
                    <label class="control-label" for="BatchSelectBox">Batch</label>
                    <div class="controls">
                      <select id="BatchSelectBox" name="BatchSelectBox">
                      <option value="0">Select a batch</option>';
              $sql1="select group_name,group_id from GROUPS";
              $q=$this->db->query($sql1,array());
              $result=$q->result_array();
               foreach($result as $r) { 
                 $batchOptionMarkup.='
                 <option value="'.$r['group_id'].'">'.$r['group_name'].'</option>';
               }
              $batchOptionMarkup.='</select>
            </div>
          </div>';
             }
    }
    else{
              $currentGroupName=$this->getGroupName($row['group_id']);
              $batchOptionMarkup='you now belong to '.$currentGroupName.'</br>If you need
              to change your batch give request to other batch by selecting from the given options';
              $batchOptionMarkup.='<div class="control-group">
                    <label class="control-label" for="BatchSelectBox">Batch</label>
                    <div class="controls">
                      <select id="BatchSelectBox" name="BatchSelectBox">
                      <option value="'.$row['group_id'].'">'.$currentGroupName.'</option>
              ';
              $sql1="select group_name,group_id from GROUPS";
              $q=$this->db->query($sql1,array());
              $result=$q->result_array();
               foreach($result as $r) { 
                if($r['group_id']!=$row['group_id'])
                 $batchOptionMarkup.='<option value="'.$r['group_id'].'">'.$r['group_name'].'</option>';
               }
              $batchOptionMarkup.='</select>
            </div>
          </div>
              ';
     }
     return '<h2>Edit Profile</h2>
                 <form action="'.base_url().'ProfileController/EditStudentProfile" method="post">
                 <fieldset>
                 <label class="control-label" for="name">Your Name</label>
                  <div class="controls">
                  <input type="text" class="input-xlarge" name="name" id="name" value="'.$row['user_name'].'">
                  
                  </div>
                  <br>
                  '.$profilePicMarkup.'
                 <br> 
                  <label class="control-label" for="email">Email Address</label>
                  <div class="controls">
                  <input type="text" class="input-xlarge" name="email" id="email"  value="'.$row['email_id'].'">
                  </div>
                  <label class="controls checkbox">
                    <input id="shareemail" type="checkbox" checked="checked"> Show email to others
                  </label> 
                  
                   
                  </div>
                
                 <label class="control-label" for="name">degree</label>
                <div class="controls">
                  <input type="text" class="input-xlarge" name="degree" id="name" value="'.$row['user_degree'].'">
                  
                  </div>
                  

                  <label class="control-label" for="degree">course</label>
                  <div class="controls">
                   <input type="text" class="input-xlarge" name="course" id="name" value="'.$row['user_course'].'">
                  
                  </div>
                 <br>

                
                '.$batchOptionMarkup.'
              
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
                
          <div class="alert fade in" id="form-err" style="display:none">
          <span id="form-err-text"></span>
            </div>
          
                <br>
                <label class="controls">
                  <button id="updateButton" type="submit" class="btn btn-primary btn-large" data-loading-text="saving.." onclick="Javascript:verify();" type="button">Save</button>
                 <label>
                 </label></label></fieldset>
                 </form>';
    

}
else
return 'something went wrong :(';

  }
  function updateProfile($userobj){
    $name=$userobj('name');
    $year=$userobj('year');
    $emailid=$userobj('emailid');
    $degree=$userobj('degree');
    $course=$userobj('course');

    $sql="update USERS set user_name=?,user_year=?,email_id=?,user_degree=?,user_course=?";
    $query=$this->db->query($sql,array($name,$year,$emailid,$degree,$course));

  }

	function getCenterContentMyGroup(){

    $CI =& get_instance();
    $currentUserId=$CI->session->userdata('user_id');
    $sql='select user_level,group_id from USERS where user_id=?';

    $query=$this->db->query($sql,array( $currentUserId));
     if($row=$query->row_array()){
     $groupId=$row['group_id'];
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
     if( $row=$query->row_array()){
    
		return '        <div class="well">
        <div class="ask-dp pull-right">
              <img src="'.base_url().'assets/img/groups/1.jpg">
          </div>
        <h3>'.$row['group_name'].'</h3>
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
       else{
        return 'You havnt specified your group yet!';
       }

   }
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
