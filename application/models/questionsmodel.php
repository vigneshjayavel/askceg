<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class QuestionsModel extends CI_Model{

	function getCenterContent(){

		return "Content for questions page..";

	}

  function sqlIsUrlExists($url){//this is for question url

    //check if the url is already present in the db
    //if so return true else false
    $query="select count(url) as cnt from QUESTION where url = ?";
        $query=$this->db->query($query,array($url));
        $row=$query->row_array();
        if($row['cnt']==1)
          return true;
      else
        return false;

  }
  function sqlgetPromotedQuestions($category_id){
    return '<h2>QuestionsPromoted</h2>coming soon';
  }
  function generateQuestionUrl($qs){
    $url=$qs;
    $url = preg_replace('/[^A-Za-z0-9]+/', '-', $url);
    $url = trim($url, '-');
    //append timestamp if url is redundant
    if($this->sqlIsUrlExists($url)){
      $url=$url.'-'.time();
    }
    return $url;
  }
  function sqlIsTopicUrlExists($url){

    //check if the url is already present in the db
    //if so return true else false
    $query="select count(topic_url) as cnt from TOPIC where topic_url = ?";
        $query=$this->db->query($query,array($url));
        $row=$query->row_array();
        if($row['cnt']==1)
          return true;
      else
        return false;
  }

  function generateTopicUrl($t){
    $url=$t;
    $url = preg_replace('/[^A-Za-z0-9]+/', '-', $url);
    $url = trim($url, '-');
    //append timestamp if url is redundant
    if($this->sqlIsUrlExists($url)){
      $url=$url.'-'.time();
    }
    return $url;
  }
  

  function convert(){
    $sql='select * from QUESTION';
    $query=$this->db->query($sql);
    $result=$query->result_array();
    foreach($result as $row){
      $q="update QUESTION set url=? where q_id=?";
      $query=$this->db->query($q,array($this->generateQuestionUrl($row['q_content']),$row['q_id']));
    }
  }
  function getCategoryOptions(){

    $sql="select category_id,category_name from  CATEGORY ";
    $query=$this->db->query($sql,array());
    $result=$query->result_array();
    $optionMarkup='<option>Select a category</option>';
                
    foreach($result as $row){
      $optionMarkup.=' <option value="'.$row['category_id'].'">'.$row['category_name'].'</option>';
               
    }
    return $optionMarkup;

  }
	function getCenterContentAskQuestion(){
    
		return '
		<form class="form-horizontal well">
        <fieldset>
          <h3>Create A New Question/Post!</h3>
          <p>You can create a question or a post to fellow CEGians under any topic!</p>
          <div class="control-group">
            <label class="control-label" for="categorySelectBox">Select Category</label>
            <div class="controls">
              <select rel="tooltip" data-placement="top" data-original-title="Category of your question" id="categorySelectBox">
                '.$this->getCategoryOptions().'
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="topicSelectBox">Select Topic</label>
            <div class="controls">
              <select disabled="true"  id="topicSelectBox">
                <option>Select a topic</option>
              </select>
            </div>
            <p>Could\'nt find a topic you are looking for?Create a topic by <a href="'.base_url().'QuestionsController/CreateDiscussion">clicking here</a></p> 
          </div>
          <div class="control-group">
            <label class="control-label" for="textarea">Question / Post title</label>
            <div class="controls">
              <textarea  disabled="true" id="questionText" class="input-xlarge" rows="3"></textarea>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="textarea">Question Description / Post Content</label>
            <div class="controls">
              <textarea  disabled="true" id="questionDescText" class="input-xlarge" rows="3"></textarea>
            </div>
          </div>
          <div class="control-group">
            <div class="controls">
              <label class="checkbox">
                <input id="anonymousCheckbox" type="checkbox" value="true">
                Post Anonymously
              </label>
            </div>
          </div> 
          <label class="control-label" for="scope">Scope</label>
          <div class="controls">
            <div class="btn-group" data-toggle="buttons-radio" data-toggle-name="scope" id="scopegroup">
              <button class="btn active " type="button" rel="tooltip" data-placement="top" data-original-title="visible to all"  name="scope" id="scope1" value="1" checked="">
              public</button>
              <button class="btn  " type="button" rel="tooltip" data-placement="top" data-original-title="visible only to your group people"  name="scope" id="scope3" value="2">
              private(your group)</button>
            </div> 
          </div>
          <div class="form-actions">
            <a disabled=true id="postQuestionButton" type="submit" class="btn btn-danger"><i class="icon-ok icon-white"></i>Post It</a>
            <a id="resetQuestionButton" type="reset" class="btn btn-primary"><i class="icon-remove icon-white"></i>Reset</a>
          </div>
        </fieldset>
      </form>
      ';

	}
function printanswer($qid){
  $sql="select * from ANSWER where q_id=?";
  $query=$this->db->query($sql,array($qid));
  $markup='';
  $result=$query->result_array();
  foreach($result as $row){
    $markup.=$row['a_content']."<br>";

  }
  if($markup == null){
    return "No content exists";
  }
  else
  return $markup;
}
  

	function getCenterContentCreateDiscussion(){

		return '<form class="form-horizontal well">
        <fieldset>
          <h3>Create a topic!!</h3>
        <p>create a topic and start discussing with fellow CEGIANS!!</p>
        </br>
          <div class="control-group">
            <label class="control-label" for="categorySelectBox">Select Category</label>
            <div class="controls">
              <select rel="tooltip" data-placement="top" data-original-title="Category to which the  topic belongs" id="categorySelectBox">
               '.$this->getCategoryOptions().'</select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="textarea">Topic </label>
            <div class="controls">
              <textarea data-placement="top" data-original-title="create one!!!"  disabled="true" id="topicText" class="input-xlarge" rows="3"></textarea>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="textarea">Topic Description (Optional)</label>
            <div class="controls">
              <textarea data-placement="top" data-original-title="People will be happy to hear more!!!"  disabled="true" id="topicDescText" class="input-xlarge" rows="3"></textarea>
            </div>
          </div>
                   
          <div class="form-actions">
            <a disabled=true id="postTopicButton" type="submit" class="btn btn-danger"><i class="icon-ok icon-white"></i>Create now</a>
            <a id="resetQuestionButton" type="reset" class="btn btn-primary"><i class="icon-remove icon-white"></i>Reset</a>
            </div>
        </fieldset>
      </form>
      ';

	}
  function get_gravatar( $email, $s = 40, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
             
     return $url;
    }
  function userMarkup($user_id){
    $sql="select user_name,profile_pic,email_id from USERS where user_id=?";
    $query=$this->db->query($sql,array($user_id));
  $markup='';
  if($row=$query->row_array()){
    
    $user_name=$this->sqlGetUserName($user_id);
    if(strlen($row['profile_pic'])==0||strlen($row['profile_pic'])==1){
          $email=$row['email_id'];
         $url=$this->get_gravatar($email);
      }
      else
        $url=$row['profile_pic'];
      

    return '
              <a rel="tooltip" data-placement="bottom" data-original-title="'.$user_name.'" href="'.base_url().'ProfileController/ViewUserProfile/'.$user_id.'">
                <img src="'.$url.'" height="40px" width="40px" alt="'.$user_name.'" class="display-pic" />
              </a>
                <a href="'.base_url().'ProfileController/ViewUserProfile/'.$user_id.'">'.$user_name.'</a>

              ';

  }
  

          
  }
  function sqlGetGroupId($user_id){

    $query="select u.group_id from USERS u where u.user_id=?";
    $query=$this->db->query($query,array($user_id));
   if( $row=$query->row_array())
    return $row['group_id'];
  }
  
  function sqlReadQuestions($category_id=null,$topic_url=null,$url=null,$group_scope=null,$set=null){
    
  /*IMPORTANT NOTE: if group scope is true only the group scope questions are selected 
  without any other filters.(used in user's group page)
  If group scope = null then it means query is used to fetch results for normal pages
  But even here the questions having group/private scope is fetched only if the user belongs
  to that group
*/

    $content='';
    $limit=20;
    $count=0;
    $this->load->library('klib');

      $CI =& get_instance();
      $currentUserId=$CI->session->userdata('user_id');
      $groupId=$this->sqlGetGroupId($currentUserId);
      if($groupId===null||$groupId==''||$groupId==0){
        $groupId=0;        
      }
    if($group_scope===true || $group_scope=="true"){ //group_scope questions

      
      $sql="SELECT q.q_id,q.q_content,q.q_description,q.topic_id,q.url,
        t.topic_name,t.topic_url,c.category_name ,c.category_id,q.posted_by,
        q.timestamp,q.anonymous
      FROM
        QUESTION q, TOPIC t, CATEGORY c 
      where 
        q.topic_id=t.topic_id and
        t.category_id=c.category_id and q.scope='$groupId'"
        ;
    }
    else{ //public qs
      $sql = "SELECT 
          q.q_id,q.q_content,q.q_description,q.topic_id,q.url,t.topic_name,
          c.category_name ,c.category_id,q.posted_by,t.topic_url,q.anonymous,
          q.timestamp
          FROM
          QUESTION q, TOPIC t, CATEGORY c 
          where 
            q.topic_id=t.topic_id and
            t.category_id=c.category_id";

    }

    if($category_id!=null && $category_id!="null"){
      $category_id=mysql_real_escape_string($category_id);
      $sql.=" and c.category_id=".$category_id;
    }
    if($topic_url!=null && $topic_url!="null"){
      $topic_id=$this->sqlgetTopicId($topic_url);
      $sql.=" and t.topic_id=".$topic_id;
    }
    if($url!=null && $url!="null"){
      //$q_id=mysql_real_escape_string($q_id);
      $sql.=" and q.url=".'\''.$url.'\'';
    }
    

    $CurrentuserGroup=$groupId;
    if($group_scope=="null"||$group_scope===null){
    $sql.=" and (q.scope=0 or q.scope=".$CurrentuserGroup.") order by q_id desc"; 
      }
    if($set!=null){
      /*
      set = start,   limit
      1  = 20   , 20
      2=40,20
      3=60,20
      4=80,20
      5=100,20
      for set=1 we'll be getting records 
Sign up for AskCEG (Already registered? Click here to login )

Login/Register with just one click via facebook


We protect your privacy!

or
Create an account here.
from 0,19 (20 being the limit)
      for set=2 we'll be getting records from 20,39 (20 being the limit)
      for set=3 we'll be getting records from 40,59 (20 being the limit)
      */
      $startIndex=$set*20;
      $sql.=" LIMIT ".$startIndex.",".$limit;
    }else{
      $sql.=" LIMIT 0,".$limit;      
    }
   
    $query=$this->db->query($sql);
    $deleteUrl=base_url().'QuestionsController/DeleteQuestion/';
    $categoryUrl=base_url().'ProfileController/viewCategory/';
    $topicUri=base_url().'ProfileController/viewTopic/';
    $questionUrl=base_url().'AnswersController/viewAnswersForQuestion/';
    $followUrl= base_url().'QuestionsController/followQuestion/';
    $unfollowUrl= base_url().'QuestionsController/unfollowQuestion/';
    //$content.=$row['category_name'];
    if($result=$query->result_array()){
    
      foreach($result as $row){
        $currentUrl=urlencode(current_url());
        if($row['anonymous']==1)
          $userMarkup='
              <a rel="tooltip" data-placement="bottom" data-original-title="Anonymous" href="#">
              <img src="'.base_url().'assets/img/users/9999.jpg" height="40px" width="40px" alt="Anonymous" class="display-pic" />
            </a>';
        else
          $userMarkup=$this->userMarkup($row['posted_by']);
       //$content.=$row['category_name'];
        $dynamicFollowOrUnfollowButton='';
        $deleteButton='';
        if($currentUserId==$row['posted_by'])
          $deleteButton.='
                      <a rel="tooltip" data-placement="top" data-original-title="Delete Question"
                      href="'.$deleteUrl.$row['q_id'].'" class="label label-inverse">Delete
                      </a>';
        else
          $deleteButton.='';
        if($this->sqlCheckUserFollowsQuestion($currentUserId,$row['q_id'])){
          $dynamicFollowOrUnfollowButton='
            <a href="#" class="qsFollowButton btn-small btn-primary" data-follow_status="yes" data-q_id="'.$row['q_id'].'" rel="tooltip" data-placement="top" 
            data-original-title="Click to unfollow the question!">
            <i class="icon-minus-sign icon-white"></i>
            Followed</a>';
        }
        else{
          $dynamicFollowOrUnfollowButton='
            <a href="#" class="qsFollowButton btn-small btn-primary" data-follow_status="no" data-q_id="'.$row['q_id'].'" rel="tooltip" data-placement="top" 
            data-original-title="Click to follow the question!">
            <i class="icon-plus-sign icon-white"></i>
            Follow</a>';
        }
          $count++;
          //time
          $timeObj=$this->klib->processTime($row['timestamp']);
        $content.=' 
        <div class="questionElementDiv">
          <div class="questionPostDiv" class="well questionElement" >
          
            <div class="qsFollowButtonDiv" style="float:right">'.$dynamicFollowOrUnfollowButton.'</div>
            <div class="questionExtraDetailsDiv">    
              <a rel="tooltip" data-placement="top" data-original-title="Category"
              href="'.$categoryUrl.$row['category_name'].'" class="label label-warning">'.$row['category_name'].'
              </a>
              <i class="icon-arrow-right"></i>
              <a rel="tooltip" data-placement="top" data-original-title="Topic"
              href="'.$topicUri.$row['topic_url'].'" class="label label-info">'.$row['topic_name'].'
              </a> 
            '.$deleteButton.'
              <p>      </p>
            </div><!--/questionExtraDetailsDiv-->
            <div class="questionDetailsDiv">
              <p id="questionContent">
              <a class="question" id="'.$row['q_id'].'" href="'.$questionUrl.$row['url'].'">'.$row['q_content'].'</a>
              </p>
              <p id="questionDescription"><span>'.$row['q_description'].'</span></p>
            </div><!--/questionDetailsDiv-->
            <div class="questionStatsDiv">
              <p>
                '.$userMarkup.'
                <i class="icon-time"></i>
                <a data-placement="bottom" data-original-title="'.$timeObj['postedDatestring'].'" rel="tooltip popover" href="#">'.$timeObj['timeElapsed'].' ago</a>
                <i class="icon-comment"></i>
                <a rel="tooltip popover" href="'.$questionUrl.$row['url'].'" 
                  data-placement="bottom">
                  <span class="answersCountSpan" data-q_id="'.$row['q_id'].'" >'.$this->sqlGetAnswerCount($row['q_id']).'</span> Answers
                </a>
                <i class="icon-eye-open"></i>
                <a href="#">'.$this->sqlReadViewCount($row['q_id']).' Views</a>
                <i class="icon-user"></i>
                <a href="#" class="followersInfoTooltip" rel="tooltip" data-placement="bottom" data-type="qs"
                data-q_id="'.$row['q_id']
                .'">
                <span class="followersCountSpan" data-q_id="'.$row['q_id'].'"> '.$this->sqlGetFollwersCountForQuestion($row['q_id']).'
                </span>Followers</a>
              </p>
            </div><!--/questionStatsDiv-->
            
          </div><!--/questionPostDiv-->
        </div><!--/questionElementDiv-->
        ';
      
      }
      
      
    }

    //$jsonObj=json_encode(array('content'=>$content
       //       ));
  
    
    return $content;

  }

	
  function sqlDeleteQuestions($q_id){
    $sql='delete from QUESTION where q_id=?';
    if($query=$this->db->query($sql,array($q_id)))
      return 'Question Removed successfully!';
    else
      return 'Sorry the Question could not be removed!';

  }
  
  function getTopicPage($topic_id){
    $sql="select * from topic where topic_id=?";
    $query=$this->db->query($sql,array($topic_id));
    $row=$query->row_array();
    return '<div class="well">
              '.$row['topic_name'].'
              </div>
              <div class="well">
              '.$row['topic_desc'].'
              </div>
              <div class="well">

              '.$row['posted_by'].'
              </div>
              <div class="label-info">'
              .$row['timestamp'].'
              </div>
               ';

  }
 
  function getQuestionsAnswered($user_id){
    $sql="select q.q_id ,q.q_content,q.posted_by,a.a_content,a.timestamp,a.a_id,q.url,q.anonymous
    from QUESTION q,ANSWER a 
    where a.posted_by=? and a.q_id=q.q_id 
   ";

    $CI =& get_instance();

    $CurrentuserGroup=$CI->session->userdata('group_id');
    $sql.=" and (q.scope=0 or q.scope=".$CurrentuserGroup.")  order by q.q_id desc ";
    //$query=$this->db->query($sql);
      
    $query=$this->db->query($sql,array($user_id));
    if( $result=$query->result_array()){
      
      $questionUrl=base_url().'AnswersController/viewAnswersForQuestion/';
      $content='<h3> Questions Answered:</h>';
      $url1=base_url()."assets/img/".$user_id.".jpg"; // for getting images of the user who posted the ans

      foreach($result as $row){
        //time

        $this->load->library('klib');
        $timeObj=$this->klib->processTime($row['timestamp']);
        if($row['anonymous']==1)
        $userMarkup='<img src="'.base_url().'assets/img/users/9999.jpg" height="40px" width="40px" alt="Anonymous" class="display-pic" />
                  
                 <strong>Anonymous</strong> 
            ';
      else
        $userMarkup=$this->userMarkup($row['posted_by']);
     

      $content.='

                  <div id="questionAnswerDiv" class="well" style="background-color:white">
                    <div id="questionDiv">
                      <div id="userDetailDiv">'.$userMarkup.'
                      </div><!--/userDetailDiv-->
                      <div id="questionDetailsDiv">
                        <p id="questionContent">
                        <a class="question" id="'.$row['q_id'].'" href="'.$questionUrl.$row['url'].'"><p>'.$row['q_content'].'</p></a>
                        </p>
                      </div><!--/questionDetailsDiv-->
                    </div><!--/questionDiv-->
                    <div id="answerDiv'.$row['a_id'].'" style="background-color:#DDD">
                      <p>'.$row['a_content'].'</p>
                      <div id="answerStats" style="float:right">
                        <a data-placement="bottom" data-original-title="'.$timeObj['postedDatestring'].'" rel="tooltip popover" href="#">'.$timeObj['timeElapsed'].' ago</a>
                </div>
                    </div><!--/answerDiv-->
                  </div><!--/questionAnswerDiv-->
                  ';

       }
       return $content;
      }
      else{
        return 'No  Questions Answered yet! ';        
      }
    }

  function getQuestionsAsked($user_id){
    $sql="select q.q_id,q.url,q.q_content,q.posted_by
          from QUESTION q
          where q.posted_by=? and q.anonymous=?";
        $CI =& get_instance();

    $CurrentuserGroup=$CI->session->userdata('group_id');
    $sql.=" and (q.scope=0 or q.scope=".$CurrentuserGroup.")";    
    $query=$this->db->query($sql,array($user_id,0));
    if($result=$query->result_array()){

      $questionUrl=base_url().'AnswersController/viewAnswersForQuestion/';
      $content='<h3> Questions Asked:</h3>';
      foreach($result as $row){

        $content.='

        <div id="questionPostDiv" class="well questionElement" >
                  <div id="userDetailDiv">
                  '.$this->userMarkup($row['posted_by']).' </div><!--/userDetailDiv-->
                   <div id="questionDetailsDiv">
                    <p id="questionContent">
                    <a class="question" id="'.$row['q_id'].'" href="'.$questionUrl.$row['url'].'">'.$row['q_content'].'</a>
                    </p>
                    </div><!--/questionDetailsDiv-->
                  
                </div><!--/questionPostDiv-->';
      }
      return $content;
    }
    else{
      return 'No Questions asked yet! ';
    }
  }
  function getQuestionsFollowed($user_id){
    $sql="select q.q_id ,q.url,q.q_content,q.posted_by,q.anonymous
     from QUESTION q,FOLLOWERS f 
     where f.user_id=? and f.q_id=q.q_id  ";
   
    $CI =& get_instance();

    $CurrentuserGroup=$CI->session->userdata('group_id');
    $sql.=" and (q.scope=0 or q.scope=".$CurrentuserGroup.") order by q.q_id desc";
    //$query=$this->db->query($sql); 
    $query=$this->db->query($sql,array($user_id));
    if($result=$query->result_array()){

      $questionUrl=base_url().'AnswersController/viewAnswersForQuestion/';
      $content='<h2> Questions Followed:</h2>';
      foreach($result as $row){
        if($row['anonymous']==1)
        $userMarkup='<img src="'.base_url().'assets/img/users/9999.jpg" height="40px" width="40px" alt="James" class="display-pic" />
                  
                 <strong>Anonymous</strong> 
            ';
      else
        $userMarkup=$this->userMarkup($row['posted_by']);
     

        $content.='

        <div id="questionPostDiv" class="well questionElement" >
                  <div id="userDetailDiv">
                  '.$userMarkup.' </div><!--/userDetailDiv-->
                   <div id="questionDetailsDiv">
                    <p id="questionContent">
                    <a class="question" id="'.$row['q_id'].'" href="'.$questionUrl.$row['url'].'">'.$row['q_content'].'</a>
                    </p>
                    </div><!--/questionDetailsDiv-->
                  
                </div><!--/questionPostDiv-->';
      }
      return $content;
    }
    else{
      return '</br>No Questions Followed ';
    }
  }
  function sqlGetUserName($user_id){
  
    $query="select user_name from USERS u where u.user_id=?";
        $query=$this->db->query($query,array($user_id));
           if($row=$query->row_array())
            return $row['user_name'];
          

  }

  function sqlGetUserYear($user_id){
  
    $query="select user_year from USERS u where u.user_id=?";
        $query=$this->db->query($query,array($user_id));
           if($row=$query->row_array())
            return $row['user_year'];
          

  }
  function sqlGetTopicId($topic_url){
  
    $query="select topic_id from TOPIC where topic_url=?";
        $query=$this->db->query($query,array($topic_url));
           if($row=$query->row_array())
            return $row['topic_id'];
          

  }


  function getGlobalScopeQuestions(){
    $content=null;
    $sql="SELECT *

      FROM
        QUESTION 
      where 
         scope=0"
      ;
    //$CI =& get_instance();
    // $group_id=$CI->session->userdata('group_id');
    $query=$this->db->query($sql);

    /// $row=$query->result_array();
    //$categoryUrl=base_url().'QuestionsController/viewQuestion/';
    $questionUrl=base_url().'AnswersController/viewAnswersForQuestion/';
    //$followUrl= base_url().'QuestionsController/followQuestion/';
    // $unfollowUrl= base_url().'QuestionsController/unfollowQuestion/';

    //$CI =& get_instance();
    // $currentUserName=$CI->session->userdata('user_name');
    if($result=$query->result_array())
    {
      foreach( $result as $row ) {
      ///$url=base_url()."assets/img/".$this->sqlGetUserid($row['posted_by']).".jpg";
      //$currentUrl=urlencode(current_url());
      if($row['anonymous']==1)
        $userMarkup='<img src="'.base_url().'assets/img/users/9999.jpg" height="40px" width="40px" alt="Anonymous" class="display-pic" />
                  
                 <strong>Anonymous</strong> 
            ';
      else
        $userMarkup=$this->userMarkup($row['posted_by']);


      $content.='
        <div id="questionPostDiv" class="well questionElement" >
                  <div id="userDetailDiv">
                  '.$userMarkup.' <div style="float:right"></div>
                  </div>
                  <div id="questionDetailsDiv">
                    <p id="questionContent">
                    <a class="question" id="'.$row['q_id'].'" href="'.$questionUrl.$row['url'].'">'.$row['q_content'].'</a>
                    </p>
                    <p id="questionDescription"><span>'.$row['q_description'].'</span></p>
                  </div><!--/questionDetailsDiv-->
                 
              
      ';
      }

      return $content;
      }
      else

    return 'No Questions posted in the global scope yet ';
  }
function getGroupScopeQuestions($group_id){
    $content=null;
    $sql="SELECT *

      FROM
        QUESTION 
      where 
         scope=?"
      ;
    $query=$this->db->query($sql,array($group_id));

    /// $row=$query->result_array();
    //$categoryUrl=base_url().'QuestionsController/viewQuestion/';
    $questionUrl=base_url().'AnswersController/viewAnswersForQuestion/';
    $content=' <div class="well">
        questions posted by the group members in the group scope
        </div>
       ';
    if($result=$query->result_array())
    {
      foreach( $result as $row ) {
      ///$url=base_url()."assets/img/".$this->sqlGetUserid($row['posted_by']).".jpg";
      //$currentUrl=urlencode(current_url());
      if($row['anonymous']==1)
        $userMarkup='<img src="'.base_url().'assets/img/users/9999.jpg" height="40px" width="40px" alt="Anonymous" class="display-pic" />
                  
                 <strong>Anonymous</strong> 
            ';
      else
        $userMarkup=$this->userMarkup($row['posted_by']);


      $content.='
        <div id="questionPostDiv" class="well questionElement" >
                  <div id="userDetailDiv">
                  '.$userMarkup.' <div style="float:right"></div>
                  </div>
                  <div id="questionDetailsDiv">
                    <p id="questionContent">
                    <a class="question" id="'.$row['q_id'].'" href="'.$questionUrl.$row['url'].'">'.$row['q_content'].'</a>
                    </p>
                    <p id="questionDescription"><span>'.$row['q_description'].'</span></p>
                  </div><!--/questionDetailsDiv-->
                 
              
      ';
      }

      return $content;
      }
      else

    return 'No Questions posted in the global scope yet ';
  }



	function sqlCheckUserFollowsQuestion($user_id,$q_id){

		
	
		$query="select user_id from FOLLOWERS where user_id=? and q_id=?";
		$query=$this->db->query($query,array($user_id,$q_id));
		if ($row=$query->row_array() ) {
			return TRUE;
		}
		else
			return FALSE;

	}

  function sqlCheckUserFollowsTopic($user_id,$topic_id){

    
  
    $sql="select * from TOPIC_FOLLOWERS where user_id=? and topic_id=?";
    $query=$this->db->query($sql,array($user_id,$topic_id));
    if ($row=$query->row_array() ) {
      return TRUE;
    }
    else
      return FALSE;

  }

  function sqlGetFollowers($type,$id){

    if($type=='qs'){
      $query="select * from FOLLOWERS where q_id=?";  
    }
    else if($type=='topic'){
      $query="select * from TOPIC_FOLLOWERS where topic_id=?";  
    }
    
    $query=$this->db->query($query,array($id));
    $followers='';
    if($result=$query->result_array()){
            foreach($result as $row ) {
              $followers.=$this->sqlGetUserName($row['user_id']).'</br>';
            }
            return $followers;
    }
    else
      return 'no one follows';


  }

	function sqlGetFollwersCountForQuestion($q_id){

	
		$query="select count(*) as cnt from FOLLOWERS where q_id=?";
		$query=$this->db->query($query,array($q_id));
	    $row=$query->row_array();
	    return $row['cnt'];		

	}
  function sqlGetFollwersCountForTopic($topic_id){

  
    $query="select count(*) as cnt from TOPIC_FOLLOWERS where topic_id=?";
    $query=$this->db->query($query,array($topic_id));
      $row=$query->row_array();
      return $row['cnt'];   

  }

	function sqlGetUserid($user_name)
	{
	   
		$query="select u.user_id from USERS u where u.user_name=?";
		$query=$this->db->query($query,array($user_name));
   if( $row=$query->row_array())
    return $row['user_id'];

	}

	function sqlGetAnswerCount($q_id){
	
		$query="select count(a.a_id) as count from ANSWER a where a.q_id=?";
		$query=$this->db->query($query,array($q_id));
	    $row=$query->row_array();
	    return $row['count'];


	}

	function sqlCreateQuestion($questionObj,$posted_by){

		$questionArray=json_decode($questionObj,TRUE);

		//current time

		$timestamp=time();
    if($questionArray['anonymous'])
      $anonymous=1;
    else
      $anonymous=0;
    if($questionArray['scope']==1){
      $scope=0;
  
    }
    
    else if($questionArray['scope']==2){

    $CI=&get_instance();
  
      $scope=$CI->session->userdata('group_id');
    }
    $qsUrl='';
    $qsResult=$this->sqlIsQuestionExists($questionArray['q_content']);
    if(!$qsResult['exists']){
      //actual question insert
      $q_url=$this->generateQuestionUrl($questionArray['q_content']);
      $sql = "insert into QUESTION(q_content,q_description,topic_id,posted_by,timestamp,url,anonymous,scope) 
          values(?,?,?,?,?,?,?,?)";
      $status=$this->db->query($sql,array($questionArray['q_content'],$questionArray['q_description'],$questionArray['topic_id'],$posted_by,$timestamp,$q_url,$anonymous,$scope));
      
      $receiver_id=$questionArray['topic_id'];//topic to which the question belongs
      $sqlt="SELECT
             topic_name,topic_url
             FROM TOPIC 
             where topic_id=?";
    $queryt=$this->db->query($sqlt,array($receiver_id));
    $topic=$queryt->row_array();
      if($status==-1){
        $status='success';
        $msg='Question posted successfully!!.. Redirecting you';
        
        $qsUrl=$this->sqlGetQuestionUrlForQuestion($questionArray['q_content']);
        $questionUrl=base_url().'AnswersController/viewAnswersForQuestion/'.$q_url;
        $topicUrl=base_url().'ProfileController/viewTopic/'.$topic['topic_url'];
          $this->load->library('klib');
          $questionAuthor=$this->klib->getUserData($posted_by);
          if($anonymous==1){


            $msg1='Anonymous user';
            $initiator_id=-1;
          }
          else{
            $msg1=$questionAuthor['user_name'];
            $initiator_id=$posted_by;
          }
          $msg1.=' asked a question <b><a href="'.$questionUrl.'">"'.substr( $questionArray['q_content'],0,20).'..."</a> in the topic <a href="'.$topicUrl.'">'.$topic['topic_name'].'</a></b>';
          $this->klib->generateNotifications($receiver_id,'t',$msg1,$initiator_id);
          if($scope!=0){
             $this->klib->generateNotifications($scope,'g',$msg1,$initiator_id);
         
          }
      }
      else{
        $status='error';
        $msg='Question cannot be posted due to technical reasons!';
      }
    }
    else{
      $status='warning';
      $msg='Question already exists!!...Redirecting you..';
      $qsUrl=$qsResult['url'];
    }
		$jsonObj=json_encode(array('status'=>$status,
									'msg'=>$msg,'qsUrl'=>$qsUrl
							));
		return $jsonObj;

	}

  function sqlIsTopicExists($topic_name){

    $query="select count(topic_name) as cnt,topic_url from TOPIC where topic_name = ?";
    $query=$this->db->query($query,array($topic_name));
    $row=$query->row_array();
    $result=array();
    if($row['cnt']!=0){
      $result['exists']=true;
      $result['topicUrl']=$row['topic_url'];
    }
    else{
      $result['exists']=false;
    }
    return $result;
  }

  function sqlCreateTopic($topicObj,$posted_by){

    //TODO  
    $topicArray=json_decode($topicObj,TRUE);
    $topicUrl='';
    $topicResult=$this->sqlIsTopicExists($topicArray['topic_name']);
    if(!$topicResult['exists']){

      $timestamp=$this->getCurrentTime();
      $topicUrl=$this->generateTopicUrl($topicArray['topic_name']);
       //actual question insert
      $sql = "insert into TOPIC(topic_name,topic_desc,posted_by,timestamp,category_id,topic_url) 
          values(?,?,?,?,?,?)";
      $status=$this->db->query($sql,array($topicArray['topic_name'],
        $topicArray['topic_desc'],$posted_by,$timestamp,
          $topicArray['category_id'],$topicUrl));
      
      if($status==-1){
        $status='success';
        $msg='Topic '.$topicArray['topic_name'].' created successfully!! Redirecting you...';
        $topicUrl=$this->sqlGetTopicUrlForTopic($topicArray['topic_name']);
      }
      else{
        $status='error';
        $msg='oops.. something went wrong!!';
      }
    
    }
    else{
      $status='warning';
      $msg='Topic '.$topicArray['topic_name'].' already exists. Redirecting you...';
      $topicUrl=$topicResult['topicUrl'];
    }



    $jsonObj=json_encode(array('status'=>$status,
                  'msg'=>$msg,'topicUrl'=>$topicUrl
              ));
    return $jsonObj;

  }

  function sqlGetTopicUrlForTopic($topic_name){
    $sql="select topic_url from TOPIC where topic_name=?";
    $query=$this->db->query($sql,array($topic_name));
    $row=$query->row_array();
    return $row['topic_url'];
  }

  function sqlGetQuestionUrlForQuestion($q_content){
    $sql="select url from QUESTION where q_content=?";
    $query=$this->db->query($sql,array($q_content));
    $row=$query->row_array();
    return $row['url'];
  }

	function getCurrentTime(){//todo

		
		//get current time
		$temp="SELECT DATE_FORMAT(NOW(), '%I:%i %p %d-%b-%y') AS time";
		$query=$this->db->query($temp);
		$row = $query->row_array();		
		$timestamp=$row['time'];
		return $timestamp;

	}

  function sqlUpdateViewCount($url){
  	$sql = "update QUESTION set views = views + 1 where url=?"; 
  	$status=$this->db->query($sql,array($url));

  }

  function sqlCreateFollower($q_id,$posted_by){
  	
  	$sql = "insert into FOLLOWERS(q_id,user_id) values(?,?)";
  	$status=$this->db->query($sql,array($q_id,$posted_by));
    if($status==-1){
      return "success";
    }
  }

  function sqlCreateFollowerTopic($topic_id,$follower){
    $sql = "insert into TOPIC_FOLLOWERS(topic_id,user_id) values(?,?)";
    $status=$this->db->query($sql,array($topic_id,$follower));
    if($status==-1){
      return "success";
    }
  }
  function sqlDeleteFollower($q_id,$posted_by){
  	 
  	$sql = "delete from FOLLOWERS where q_id =? and user_id =?";
  	$status=$this->db->query($sql,array($q_id,$posted_by));
    if($status==-1){
      return "success";
    }
  }
  function sqlDeleteFollowerTopic($topic_id,$follower){
     
    $sql = "delete from TOPIC_FOLLOWERS where topic_id =? and user_id =?";
    $status=$this->db->query($sql,array($topic_id,$follower));
    if($status==-1){
      return "success";
    }
    
  }

  function sqlReadViewCount($q_id){

    $sql="select views from QUESTION a where a.q_id=?";
    $query=$this->db->query($sql,array($q_id));
    $row=$query->row_array();
    return $row['views'];

	}

	function sqlGetTopicsInCategory1($categoryId){

    $content=null;

    $sql = 
    'SELECT 
      T.TOPIC_ID,T.TOPIC_NAME FROM TOPIC T
     WHERE 
      T.CATEGORY_ID =?
     ';
     $query=$this->db->query($sql,array($categoryId));

    foreach ($query->result_array() as $row) {
      
     
    
      $content.='<option value='.$row['TOPIC_ID'].'>'.$row['TOPIC_NAME'] .'</option>';
    
    }
    if($content==null)
      $content='no data';

    $jsonObj=json_encode(array('topicsData'=>$content
              ));
    return $jsonObj;

  }


	function sqlGetTopicsInCategory($categoryId){

		$content='<h2>Topics Under this Category are:</h2>';
    $sql = 
    'select * FROM TOPIC 
    WHERE 
    	CATEGORY_ID =?
    ';
    $query=$this->db->query($sql,array($categoryId));
    $result=$query->result_array();
    $followUrl=  base_url().'QuestionsController/followTopic/';
    $unfollowUrl= base_url().'QuestionsController/unfollowTopic/';
    $CI =& get_instance();
    $currentUserId=$CI->session->userdata('user_id');
    $currentUrl=urlencode(current_url());

    foreach ($result as $row) {
    	
      if($this->questionsmodel->sqlCheckUserFollowsTopic($currentUserId,$row['topic_id'])){
        $dynamicFollowOrUnfollowButton='
        <a href="#" class="topicFollowButton btn-primary btn-small" data-follow_status="yes" data-topic_id="'.$row['topic_id'].'" rel="tooltip" data-placement="top" 
        data-original-title="Click to unfollow the topic!">
        <i class="icon-minus-sign"></i>
        Followed</a>';

      }
      else{
        $dynamicFollowOrUnfollowButton='
        <a href="#" class="topicFollowButton btn-primary btn-small" data-follow_status="no" data-topic_id="'.$row['topic_id'].'" rel="tooltip" data-placement="top" 
        data-original-title="Click to Follow the topic!">
        <i class="icon-plus-sign"></i>
        Follow</a>';

      }
        

      $content.='<div class=well> <a href="'.base_url().'ProfileController/ViewTopic/'.$row['topic_url'].'"> '.$row['topic_name'].'</a><div style="float:right">'.$dynamicFollowOrUnfollowButton.'</div></div>';

    }

    if($content=='<h2>Topics Under this Category are:</h2>'){
      $content.='No topics Under this Category yet!'; 
    }
    
    return $content;

	}

  function sqlIsQuestionExists($qs){
    $query="select count(q_content) as cnt,url from QUESTION where q_content = ?";
    $query=$this->db->query($query,array($qs));
    $row=$query->row_array();
    $result=array();
    if($row['cnt']!=0){
      $result['exists']=true;
      $result['url']=$row['url'];
    }
    else{
      $result['exists']=false;
    }
    return $result;
  }

}