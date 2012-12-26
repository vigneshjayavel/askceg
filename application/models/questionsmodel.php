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
	function getCenterContentAskQuestion(){

		return '
		<form class="form-horizontal well">
        <fieldset>
          <legend>Post A New Question!</legend>
          <div class="control-group">
            <label class="control-label" for="categorySelectBox">Select Category</label>
            <div class="controls">
              <select rel="tooltip" data-placement="top" data-original-title="Category of your question" id="categorySelectBox">
                <option>Select a category</option>
                <option value="1">Education</option>
                <option value="2">Entertainment</option>
                <option value="3">Sports</option>
                <option value="4">Technology</option>
                <option value="5">Miscellaneous</option>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="topicSelectBox">Select Topic</label>
            <div class="controls">
              <select disabled="true"  id="topicSelectBox">
                <option>Select a category first</option>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="textarea">Question</label>
            <div class="controls">
              <textarea  disabled="true" id="questionText" class="input-xlarge" rows="3"></textarea>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="textarea">Question Description (Optional)</label>
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
                  
                  <label class="radio">
                    <input rel="tooltip" data-placement="top" data-original-title="visible to all"  type="radio" name="scope" id="scope1" value="1" checked="">
                    public
                  </label>
                  
                  
                  
                  <label class="radio">
                    <input rel="tooltip" data-placement="top" data-original-title="visible to only to your group people"  type="radio" name="scope" id="scope3" value="2">
                    private(your group)
                  </label>
                  </div>
                        
          <div class="form-actions">
            <a disabled=true id="postQuestionButton" type="submit" class="btn btn-danger"><i class="icon-ok icon-white"></i>Post It</a>
            <a id="resetQuestionButton" type="reset" class="btn btn-primary"><i class="icon-remove icon-white"></i>Reset</a>
          </div>
        </fieldset>
      </form>
      ';

	}

  
function getQuestionsAskedToTeacher($user_id){
    $sql='select q.q_id,q.q_content,q.anonymous, q.posted_by,q.url from  QUESTION q,QUESTION_POST_TO_TEACHER t
     where q.q_id=t.q_id and t.user_id=?';
    $query=$this->db->query($sql,array($user_id));
    if($result=$query->result_array()){
      $questionUrl=base_url().'AnswersController/viewAnswersForQuestion/';
      $content='<h2> Questions posted to '.$this->sqlGetUserName($user_id).' :</h2>';
      foreach($result as $row){
       if($row['anonymous']==1){
        $userMarkup='<img src="'.base_url().'assets/img/users/9999.jpg" height="40px" width="40px" alt="James" class="display-pic" />
                  
                 <strong>Anonymous</strong> 
            ';
          }
          else{
            $userMarkup=$this->userMarkup($user_id);
          }
          
         

        $content.='<div id="questionPostDiv" class="well questionElement" style="background-color:white">
                  <div id="userDetailDiv">
                  '.$this->userMarkup($row['posted_by']).' </div><!--/userDetailDiv-->
                   <div id="questionDetailsDiv">
                    <p id="questionContent">
                    <strong><a class="question" id="'.$row['q_id'].'" href="'.$questionUrl.$row['url'].'">'.$row['q_content'].'</a>
                    </strong>
                    </p>
                    </div><!--/questionDetailsDiv-->
                  
                </div><!--/questionPostDiv-->';
      }
      return $content;
    }
    else{
      return 'No Questions Posted yet  ';
    }
  }

	function getCenterContentCreateDiscussion(){

		return '<form class="form-horizontal well">
        <fieldset>
          <legend>Create a topic!!</legend>
          <div class="control-group">
            <label class="control-label" for="categorySelectBox">Select Category</label>
            <div class="controls">
              <select rel="tooltip" data-placement="top" data-original-title="Category of your question" id="categorySelectBox">
                <option>Select a category</option>
                <option value="1">Education</option>
                <option value="2">Entertainment</option>
                <option value="3">Sports</option>
                <option value="4">Technology</option>
                <option value="5">Miscellaneous</option>
              </select>
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
  function userMarkup($user_id){
          $url=base_url()."assets/img/users/".$user_id.".jpg";

    return '<img src="'.$url.'" height="40px" width="40px" alt="James" class="display-pic" />
                   
                <a href="'.base_url().'ProfileController/ViewUserProfile/'.$user_id.'"> <strong>'.$this->sqlGetUserName($user_id).'</strong> </a>
                   ';

  }
  /*function getTopics($category_id)
  {
    $content='';
    $sql="select * from TOPIC where category_id=?";
    $query=$this->db->query($sql);
    $result=$query->result_array();
    foreach($result as $row){

      $content.='<p> '.$row['topic_name'].' </p>';
    }

      $jsonObj=json_encode(array('content'=>$content
              ));
    return $content;

  }*/
  function sqlTeacherReadQuestions($category_id=null,$topic_url=null,$url=null){
    $content='';
    $sql = "SELECT 
          q.q_id,q.q_content,q.q_description,q.topic_id,q.url,t.topic_name,
          c.category_name ,c.category_id,q.posted_by,t.topic_url,q.anonymous,
          q.timestamp
          FROM
          QUESTION q, TOPIC t, CATEGORY c 
          where 
            q.topic_id=t.topic_id and
            t.category_id=c.category_id";
    if($category_id!=null){
      $category_id=mysql_real_escape_string($category_id);
      $sql.=" and c.category_id=".$category_id;
    }
    if($topic_url!=null){
      $topic_id=$this->sqlgetTopicId($topic_url);
      $sql.=" and t.topic_id=".$topic_id;
    }
    if($url!=null){
      //$q_id=mysql_real_escape_string($q_id);
      $sql.=" and q.url=".'\''.$url.'\'';
    }
    $CI =& get_instance();
    $currentUserId=$CI->session->userdata('user_id');

    $CurrentuserGroup=$CI->session->userdata('group_id');
    $CurrentUserYear=$this->sqlgetUserYear($currentUserId);
    $sql.=" and visible_to_ (q.scope='global' or( q.scope='group' and 
      q.scope_id=".$CurrentuserGroup.") ) "; 
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
          $userMarkup='<img src="'.base_url().'assets/img/users/9999.jpg" height="40px" width="40px" alt="James" class="display-pic" />
                    
                   <strong>Anonymous</strong> 
              ';
        else
          $userMarkup=$this->userMarkup($row['posted_by']);
       //$content.=$row['category_name'];
        $dynamicFollowOrUnfollowButton='';
        $deleteButton='';
        if($currentUserId==$row['posted_by'])
          $deleteButton.='<i class="icon-remove-sign"> </i>
                      <a rel="tooltip" data-placement="top" data-original-title="Delete Question"
                      href="'.$deleteUrl.$row['q_id'].'" class="label label-inverse">Delete
                      </a>';
        else
          $deleteButton.='';
        if($this->sqlCheckUserFollowsQuestion($currentUserId,$row['q_id'])){
          $dynamicFollowOrUnfollowButton='
            <a href="#" class="qsFollowButton" data-follow_status="yes" data-q_id="'.$row['q_id'].'" rel="tooltip" data-placement="top" 
            data-original-title="Click to unfollow the question!">
            <i class="icon-minus-sign"></i>
            Unfollow</a>';
        }
        else{
          $dynamicFollowOrUnfollowButton='
            <a href="#" class="qsFollowButton" data-follow_status="no" data-q_id="'.$row['q_id'].'" rel="tooltip" data-placement="top" 
            data-original-title="Click to follow the question!">
            <i class="icon-plus-sign"></i>
            Follow</a>';
        }
          
        $content.=' 
        
          <div id="questionPostDiv" class="well questionElement" style="background-color:white">
            <div id="userDetailDiv">'.$userMarkup.'
              <div style="float:right">'.$dynamicFollowOrUnfollowButton.'</div>
            </div>
            <div id="questionDetailsDiv">
              <p id="questionContent">
              <strong><a class="question" id="'.$row['q_id'].'" href="'.$questionUrl.$row['url'].'">'.$row['q_content'].'</a>
              </strong>
              </p>
              <p id="questionDescription"><span>'.$row['q_description'].'</span></p>
            </div><!--/questionDetailsDiv-->
            <div id="questionExtraDetailsDiv">    
              <a rel="tooltip" data-placement="top" data-original-title="Category"
              href="'.$categoryUrl.$row['category_name'].'" class="label label-warning">'.$row['category_name'].'
              </a>
              <i class="icon-arrow-right"></i>
              <a rel="tooltip" data-placement="top" data-original-title="Topic"
              href="'.$topicUri.$row['topic_url'].'" class="label label-info">'.$row['topic_name'].'
              </a> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
               &nbsp &nbsp &nbsp &nbsp   &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
            '.$deleteButton.'
              <p>      </p>
            </div><!--/questionExtraDetailsDiv-->
            <div id="questionStatsDiv">
              <i class="icon-time"></i>
              <a>'.$row['timestamp'].'</a>
              <i class="icon-comment"></i>
              <a rel="tooltip popover" href="#" 
                data-placement="bottom" 
                data-original-title="Quick answer!" 
                data-content=\'<textarea placeholder="Enter answer here.."></textarea><br/>
                              <button class="postAnswerButton btn btn-success pull-right">
                              <i class="icon-share-alt icon-white"></i>
                              Answer!</button>\' 
                data-original-title="Post Answer"
                data-placement="bottom">
                '.$this->sqlGetAnswerCount($row['q_id']).' Answers
              </a>
              <i class="icon-eye-open"></i>
              <a >'.$this->sqlReadViewCount($row['q_id']).' Views</a>
              <i class="icon-user"></i>
              <a class="followersInfoTooltip" rel="tooltip" data-placement="bottom" 
              data-q_id="'.$row['q_id']
              .'">
              '.$this->sqlGetFollwersCountForQuestion($row['q_id']).'
              Followers</a>
            <div style="float:right">
              FLike,Tweet                    
              </div>
            </div><!--/questionStatsDiv-->
            
          </div><!--/questionPostDiv-->

        ';
      
      }
      
      
    }

    $jsonObj=json_encode(array('content'=>$content
              ));
    return $content;

  }

   

  
  function sqlReadQuestions($category_id=null,$topic_url=null,$url=null){
    $content='';
    $sql = "SELECT 
          q.q_id,q.q_content,q.q_description,q.topic_id,q.url,t.topic_name,
          c.category_name ,c.category_id,q.posted_by,t.topic_url,q.anonymous,
          q.timestamp
          FROM
          QUESTION q, TOPIC t, CATEGORY c 
          where 
            q.topic_id=t.topic_id and
            t.category_id=c.category_id";
    if($category_id!=null){
      $category_id=mysql_real_escape_string($category_id);
      $sql.=" and c.category_id=".$category_id;
    }
    if($topic_url!=null){
      $topic_id=$this->sqlgetTopicId($topic_url);
      $sql.=" and t.topic_id=".$topic_id;
    }
    if($url!=null){
      //$q_id=mysql_real_escape_string($q_id);
      $sql.=" and q.url=".'\''.$url.'\'';
    }
    $CI =& get_instance();
    $currentUserId=$CI->session->userdata('user_id');

    $CurrentuserGroup=$CI->session->userdata('group_id');
    $sql.=" and (q.scope=0 or q.scope=".$CurrentuserGroup.")";
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
          $userMarkup='<img src="'.base_url().'assets/img/users/9999.jpg" height="40px" width="40px" alt="James" class="display-pic" />
                    
                   <strong>Anonymous</strong> 
              ';
        else
          $userMarkup=$this->userMarkup($row['posted_by']);
       //$content.=$row['category_name'];
        $dynamicFollowOrUnfollowButton='';
        $deleteButton='';
        if($currentUserId==$row['posted_by'])
          $deleteButton.='<i class="icon-remove-sign"> </i>
                      <a rel="tooltip" data-placement="top" data-original-title="Delete Question"
                      href="'.$deleteUrl.$row['q_id'].'" class="label label-inverse">Delete
                      </a>';
        else
          $deleteButton.='';
        if($this->sqlCheckUserFollowsQuestion($currentUserId,$row['q_id'])){
          $dynamicFollowOrUnfollowButton='
            <a href="#" class="qsFollowButton" data-follow_status="yes" data-q_id="'.$row['q_id'].'" rel="tooltip" data-placement="top" 
            data-original-title="Click to unfollow the question!">
            <i class="icon-minus-sign"></i>
            Unfollow</a>';
        }
        else{
          $dynamicFollowOrUnfollowButton='
            <a href="#" class="qsFollowButton" data-follow_status="no" data-q_id="'.$row['q_id'].'" rel="tooltip" data-placement="top" 
            data-original-title="Click to follow the question!">
            <i class="icon-plus-sign"></i>
            Follow</a>';
        }
          
        $content.=' 
        
          <div id="questionPostDiv" class="well questionElement" style="background-color:white">
            <div id="userDetailDiv">'.$userMarkup.'
              <div style="float:right">'.$dynamicFollowOrUnfollowButton.'</div>
            </div>
            <div id="questionDetailsDiv">
              <p id="questionContent">
              <strong><a class="question" id="'.$row['q_id'].'" href="'.$questionUrl.$row['url'].'">'.$row['q_content'].'</a>
              </strong>
              </p>
              <p id="questionDescription"><span>'.$row['q_description'].'</span></p>
            </div><!--/questionDetailsDiv-->
            <div id="questionExtraDetailsDiv">    
              <a rel="tooltip" data-placement="top" data-original-title="Category"
              href="'.$categoryUrl.$row['category_name'].'" class="label label-warning">'.$row['category_name'].'
              </a>
              <i class="icon-arrow-right"></i>
              <a rel="tooltip" data-placement="top" data-original-title="Topic"
              href="'.$topicUri.$row['topic_url'].'" class="label label-info">'.$row['topic_name'].'
              </a> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
               &nbsp &nbsp &nbsp &nbsp   &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
            '.$deleteButton.'
              <p>      </p>
            </div><!--/questionExtraDetailsDiv-->
            <div id="questionStatsDiv">
              <i class="icon-time"></i>
              <a>'.$row['timestamp'].'</a>
              <i class="icon-comment"></i>
              <a rel="tooltip popover" href="#" 
                data-placement="bottom" 
                data-original-title="Quick answer!" 
                data-content=\'<textarea placeholder="Enter answer here.."></textarea><br/>
                              <button class="postAnswerButton btn btn-success pull-right">
                              <i class="icon-share-alt icon-white"></i>
                              Answer!</button>\' 
                data-original-title="Post Answer"
                data-placement="bottom">
                '.$this->sqlGetAnswerCount($row['q_id']).' Answers
              </a>
              <i class="icon-eye-open"></i>
              <a >'.$this->sqlReadViewCount($row['q_id']).' Views</a>
              <i class="icon-user"></i>
              <a class="followersInfoTooltip" rel="tooltip" data-placement="bottom" 
              data-q_id="'.$row['q_id']
              .'">
              '.$this->sqlGetFollwersCountForQuestion($row['q_id']).'
              Followers</a>
            <div style="float:right">
              FLike,Tweet                    
              </div>
            </div><!--/questionStatsDiv-->
            
          </div><!--/questionPostDiv-->

        ';
      
      }
      
      
    }

    $jsonObj=json_encode(array('content'=>$content
              ));
    return $content;

  }

   

	function sqlStudentReadQuestions($category_id=null,$topic_url=null,$url=null){
     $content='';
  		$sql = "SELECT 
          q.q_id,q.q_content,q.q_description,q.topic_id,q.url,t.topic_name,
				  c.category_name ,c.category_id,q.posted_by,t.topic_url,q.anonymous,
					q.timestamp
					FROM
					QUESTION q, TOPIC t, CATEGORY c 
  				where 
  					q.topic_id=t.topic_id and
  					t.category_id=c.category_id";
		if($category_id!=null){
      $category_id=mysql_real_escape_string($category_id);
      $sql.=" and c.category_id=".$category_id;
    }
		if($topic_url!=null){
      $topic_id=$this->sqlgetTopicId($topic_url);
      $sql.=" and t.topic_id=".$topic_id;
    }
		if($url!=null){
      //$q_id=mysql_real_escape_string($q_id);
      $sql.=" and q.url=".'\''.$url.'\'';
    }
   $CI =& get_instance();
     $currentUserId=$CI->session->userdata('user_id');

    $CurrentuserGroup=$CI->session->userdata('group_id');
    $sql.=" and (q.scope=0 or q.scope=".$CurrentuserGroup.")";
   	$query=$this->db->query($sql);
    $deleteUrl=base_url().'QuestionsController/DeleteQuestion/';
		$categoryUrl=base_url().'ProfileController/viewCategory/';
		$topicUri=base_url().'ProfileController/viewTopic/';
    $questionUrl=base_url().'AnswersController/viewAnswersForQuestion/';
		$followUrl=	base_url().'QuestionsController/followQuestion/';
		$unfollowUrl=	base_url().'QuestionsController/unfollowQuestion/';
		 ///$content.=$row['category_name'];
     if($result=$query->result_array()){
    
     foreach($result as $row){
      
			$currentUrl=urlencode(current_url());
      if($row['anonymous']==1)
        $userMarkup='<img src="'.base_url().'assets/img/users/9999.jpg" height="40px" width="40px" alt="James" class="display-pic" />
                  
                 <strong>Anonymous</strong> 
            ';
      else
        $userMarkup=$this->userMarkup($row['posted_by']);
     //$content.=$row['category_name'];
			$dynamicFollowOrUnfollowButton='';
      $deleteButton='';
      if($currentUserId==$row['posted_by'])
        $deleteButton.='<i class="icon-remove-sign"> </i>
                    <a rel="tooltip" data-placement="top" data-original-title="Delete Question"
                    href="'.$deleteUrl.$row['q_id'].'" class="label label-inverse">Delete
                    </a>';
      else
        $deleteButton.='';
			if($this->sqlCheckUserFollowsQuestion($currentUserId,$row['q_id']))
				$dynamicFollowOrUnfollowButton='
					<i class="icon-minus-sign"></i>
               		<a href="'.$unfollowUrl.$row['q_id'].'?redirectUrl='.$currentUrl.'" rel="tooltip" data-placement="bottom" 
                    data-original-title="Click to unfollow the question!">Unfollow</a>';
			else
				$dynamicFollowOrUnfollowButton='
					<i class="icon-plus-sign"></i>
               		<a href="'.$followUrl.$row['q_id'].'?redirectUrl='.$currentUrl.'" rel="tooltip" data-placement="bottom" 
                    data-original-title="Click to follow the question!">Follow</a>';

			$content.=' 

				<div id="questionPostDiv" class="well questionElement" style="background-color:white">
                  <div id="userDetailDiv">'.$userMarkup.'
                    <div style="float:right">'.$dynamicFollowOrUnfollowButton.'</div>
                  </div>
                  <div id="questionDetailsDiv">
                    <p id="questionContent">
                    <strong><a class="question" id="'.$row['q_id'].'" href="'.$questionUrl.$row['url'].'">'.$row['q_content'].'</a>
                    </strong>
                    </p>
                    <p id="questionDescription"><span>'.$row['q_description'].'</span></p>
                  </div><!--/questionDetailsDiv-->
                  <div id="questionExtraDetailsDiv">    
                    <a rel="tooltip" data-placement="top" data-original-title="Category"
                    href="'.$categoryUrl.$row['category_name'].'" class="label label-warning">'.$row['category_name'].'
                    </a>
                    <i class="icon-arrow-right"></i>
                    <a rel="tooltip" data-placement="top" data-original-title="Topic"
                    href="'.$topicUri.$row['topic_url'].'" class="label label-info">'.$row['topic_name'].'
                    </a> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                     &nbsp &nbsp &nbsp &nbsp   &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
                  '.$deleteButton.'
                    <p>      </p>
                  </div><!--/questionExtraDetailsDiv-->
                  <div id="questionStatsDiv">
                    <i class="icon-time"></i>
                    <a>'.$row['timestamp'].'</a>
                    <i class="icon-comment"></i>
                    <a rel="tooltip popover" href="#" 
                      data-placement="bottom" 
                      data-original-title="Quick answer!" 
                      data-content=\'<textarea placeholder="Enter answer here.."></textarea><br/>
                                    <button class="postAnswerButton btn btn-success pull-right">
                                    <i class="icon-share-alt icon-white"></i>
                                    Answer!</button>\' 
                      data-original-title="Post Answer"
                      data-placement="bottom">
                      '.$this->sqlGetAnswerCount($row['q_id']).' Answers
                    </a>
                    <i class="icon-eye-open"></i>
                    <a >'.$this->sqlReadViewCount($row['q_id']).' Views</a>
                    <i class="icon-user"></i>
                    <a class="followersInfoTooltip" rel="tooltip" data-placement="bottom" 
                    data-q_id="'.$row['q_id']
                    .'">
                    '.$this->sqlGetFollwersCountForQuestion($row['q_id']).'
                    Followers</a>
               		<div style="float:right">
                    FLike,Tweet                    
                    </div>
                  </div><!--/questionStatsDiv-->
                  
                </div><!--/questionPostDiv-->

			';
    
    }
    
		
		}

		$jsonObj=json_encode(array('content'=>$content
							));
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
      
    $query=$this->db->query($sql,array($this->sqlGetUserName($user_id)));
    if( $result=$query->result_array()){
      
      $questionUrl=base_url().'AnswersController/viewAnswersForQuestion/';
      $content='<h3> Questions Answered:</h>';
      $url1=base_url()."assets/img/".$user_id.".jpg"; // for getting images of the user who posted the ans

      foreach($result as $row){
        if($row['anonymous']==1)
        $userMarkup='<img src="'.base_url().'assets/img/users/9999.jpg" height="40px" width="40px" alt="James" class="display-pic" />
                  
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
                        <strong><a class="question" id="'.$row['q_id'].'" href="'.$questionUrl.$row['url'].'">'.$row['q_content'].'</a>
                        </strong>
                        </p>
                      </div><!--/questionDetailsDiv-->
                    </div><!--/questionDiv-->
                    <div id="answerDiv'.$row['a_id'].'" style="background-color:#DDD">
                      '.$row['a_content'].'
                      <div id="answerStats" style="float:right">
                        <i class="icon-time"></i>'.$row['timestamp'].' 
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

        <div id="questionPostDiv" class="well questionElement" style="background-color:white">
                  <div id="userDetailDiv">
                  '.$this->userMarkup($row['posted_by']).' </div><!--/userDetailDiv-->
                   <div id="questionDetailsDiv">
                    <p id="questionContent">
                    <strong><a class="question" id="'.$row['q_id'].'" href="'.$questionUrl.$row['url'].'">'.$row['q_content'].'</a>
                    </strong>
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

        <div id="questionPostDiv" class="well questionElement" style="background-color:white">
                  <div id="userDetailDiv">
                  '.$userMarkup.' </div><!--/userDetailDiv-->
                   <div id="questionDetailsDiv">
                    <p id="questionContent">
                    <strong><a class="question" id="'.$row['q_id'].'" href="'.$questionUrl.$row['url'].'">'.$row['q_content'].'</a>
                    </strong>
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
	function getGroupScopeQuestions(){
		$content=null;
    $CI =& get_instance();
    $groupId=$CI->session->userdata('group_id');
    $sql="SELECT q.q_id,q.q_content,q.q_description,q.topic_id,q.url,
					t.topic_name,t.topic_url,c.category_name ,c.category_id,q.posted_by,
					q.timestamp,q.anonymous
				
				FROM
					QUESTION q, TOPIC t, CATEGORY c 
				where 
					q.topic_id=t.topic_id and
					t.category_id=c.category_id and q.scope='$groupId'"
				;

    $query=$this->db->query($sql);
    
    // $row=$query->result_array();
    $categoryUrl=base_url().'QuestionsController/viewQuestion/';
    $topicUri=base_url().'ProfileController/viewTopic/';
		$questionUrl=base_url().'AnswersController/viewAnswersForQuestion/';
		$followUrl=	base_url().'QuestionsController/followQuestion/';
		$unfollowUrl=	base_url().'QuestionsController/unfollowQuestion/';

		$CI =& get_instance();
		$currentUserName=$CI->session->userdata('user_name');
    if($result=$query->result_array()){


		foreach( $result as $row ) {
      if($row['anonymous']==1)
        $userMarkup='<img src="'.base_url().'assets/img/users/9999.jpg" height="40px" width="40px" alt="James" class="display-pic" />
                  
                 <strong>Anonymous</strong> 
            ';
      else
        $userMarkup=$this->userMarkup($row['posted_by']);
     
			$url=base_url()."assets/img/".$this->sqlGetUserid($row['posted_by']).".jpg";
			$currentUrl=urlencode(current_url());

			$dynamicFollowOrUnfollowButton='';
			if($this->sqlCheckUserFollowsQuestion($currentUserName,$row['q_id']))
				$dynamicFollowOrUnfollowButton='
					<i class="icon-minus-sign"></i>
               		<a href="'.$unfollowUrl.$row['q_id'].'?redirectUrl='.$currentUrl.'" rel="tooltip" data-placement="bottom" 
                    data-original-title="Click to unfollow the question!">Unfollow</a>';
			else
				$dynamicFollowOrUnfollowButton='
					<i class="icon-plus-sign"></i>
               		<a href="'.$followUrl.$row['q_id'].'?redirectUrl='.$currentUrl.'" rel="tooltip" data-placement="bottom" 
                    data-original-title="Click to follow the question!">Follow</a>';

			$content.='

				<div id="questionPostDiv" class="well questionElement" style="background-color:white">
                  <div id="userDetailDiv">
                  '.$userMarkup.' <div style="float:right">'.$dynamicFollowOrUnfollowButton.'</div>
                  </div>
                  <div id="questionDetailsDiv">
                    <p id="questionContent">
                    <strong><a class="question" id="'.$row['q_id'].'" href="'.$questionUrl.$row['url'].'">'.$row['q_content'].'</a>
                    </strong>
                    </p>
                    <p id="questionDescription"><span>'.$row['q_description'].'</span></p>
                  </div><!--/questionDetailsDiv-->
                  <div id="questionExtraDetailsDiv">    
                    <a rel="tooltip" data-placement="top" data-original-title="Category"
                    href="'.$categoryUrl.$row['category_name'].'" class="label label-warning">'.$row['category_name'].'
                    </a>
                    <i class="icon-arrow-right"></i>
                    <a rel="tooltip" data-placement="top" data-original-title="Topic"
                    href="'.$topicUri.$row['topic_url'].'" class="label label-info">'.$row['topic_name'].'
                    </a>
                    <p>      </p>
                  </div><!--/questionExtraDetailsDiv-->
                  <div id="questionStatsDiv">
                    <i class="icon-time"></i>
                    <a>'.$row['timestamp'].'</a>
                    <i class="icon-comment"></i>
                    <a rel="tooltip popover" href="#" 
                      data-placement="bottom" 
                      data-original-title="Quick answer!" 
                      data-content=\'<textarea placeholder="Enter answer here.."></textarea><br/>
                                    <button class="postAnswerButton btn btn-success pull-right">
                                    <i class="icon-share-alt icon-white"></i>
                                    Answer!</button>\' 
                      data-original-title="Post Answer"
                      data-placement="bottom">
                      '.$this->sqlGetAnswerCount($row['q_id']).' Answers
                    </a>
                    <i class="icon-eye-open"></i>
                    <a >'.$this->sqlReadViewCount($row['q_id']).' Views</a>
                    <i class="icon-user"></i>
                    <a rel="tooltip" data-placement="bottom" 
                    data-original-title="'.
                    $this->sqlGetFollowersForQuestion($row['q_id'])
                    .'">
                    '.$this->sqlGetFollwersCountForQuestion($row['q_id']).'
                    Followers</a>
               		<div style="float:right">
                    FLike,Tweet                    
                    </div>
                  </div><!--/questionStatsDiv-->
                  
                </div><!--/questionPostDiv-->

			';
		}

return $content;
  }
else

  return 'No Questions posted in the group yet ';
  }

/*function getYearScopeQuestions(){
    $content=null;
    $CI =& get_instance();
    $yearId=$this->sqlGetUserYear($CI->session->userdata('user_id'));
    $sql="SELECT q.q_id,q.q_content,q.q_description,q.topic_id,q.url,
          t.topic_name,t.topic_url,c.category_name ,c.category_id,q.posted_by,
          q.timestamp,q.anonymous
        
        FROM
          QUESTION q, TOPIC t, CATEGORY c 
        where 
          q.topic_id=t.topic_id and
          t.category_id=c.category_id and q.scope='year' and q.scope_id='$yearId'"
        ;

    $query=$this->db->query($sql);
    
    // $row=$query->result_array();
    $categoryUrl=base_url().'QuestionsController/viewQuestion/';
    $topicUri=base_url().'ProfileController/viewTopic/';
    $questionUrl=base_url().'AnswersController/viewAnswersForQuestion/';
    $followUrl= base_url().'QuestionsController/followQuestion/';
    $unfollowUrl= base_url().'QuestionsController/unfollowQuestion/';

    $CI =& get_instance();
    $currentUserName=$CI->session->userdata('user_name');
    if($result=$query->result_array()){


    foreach( $result as $row ) {
      if($row['anonymous']==1)
        $userMarkup='<img src="'.base_url().'assets/img/users/9999.jpg" height="40px" width="40px" alt="James" class="display-pic" />
                  
                 <strong>Anonymous</strong> 
            ';
      else
        $userMarkup=$this->userMarkup($row['posted_by']);
     
      $currentUrl=urlencode(current_url());

      $dynamicFollowOrUnfollowButton='';
      if($this->sqlCheckUserFollowsQuestion($currentUserName,$row['q_id']))
        $dynamicFollowOrUnfollowButton='
          <i class="icon-minus-sign"></i>
                  <a href="'.$unfollowUrl.$row['q_id'].'?redirectUrl='.$currentUrl.'" rel="tooltip" data-placement="bottom" 
                    data-original-title="Click to unfollow the question!">Unfollow</a>';
      else
        $dynamicFollowOrUnfollowButton='
          <i class="icon-plus-sign"></i>
                  <a href="'.$followUrl.$row['q_id'].'?redirectUrl='.$currentUrl.'" rel="tooltip" data-placement="bottom" 
                    data-original-title="Click to follow the question!">Follow</a>';

      $content.='


        <div id="questionPostDiv" class="well questionElement" style="background-color:white">
                  <div id="userDetailDiv">
                  '.$userMarkup.' <div style="float:right">'.$dynamicFollowOrUnfollowButton.'</div>
                  </div>
                  <div id="questionDetailsDiv">
                    <p id="questionContent">
                    <strong><a class="question" id="'.$row['q_id'].'" href="'.$questionUrl.$row['url'].'">'.$row['q_content'].'</a>
                    </strong>
                    </p>
                    <p id="questionDescription"><span>'.$row['q_description'].'</span></p>
                  </div><!--/questionDetailsDiv-->
                  <div id="questionExtraDetailsDiv">    
                    <a rel="tooltip" data-placement="top" data-original-title="Category"
                    href="'.$categoryUrl.$row['category_id'].'" class="label label-warning">'.$row['category_name'].'
                    </a>
                    <i class="icon-arrow-right"></i>
                    <a rel="tooltip" data-placement="top" data-original-title="Topic"
                    href="'.$topicUri.$row['topic_url'].'" class="label label-info">'.$row['topic_name'].'
                    </a>
                    <p>      </p>
                  </div><!--/questionExtraDetailsDiv-->
                  <div id="questionStatsDiv">
                    <i class="icon-time"></i>
                    <a>'.$row['timestamp'].'</a>
                    <i class="icon-comment"></i>
                    <a rel="tooltip popover" href="#" 
                      data-placement="bottom" 
                      data-original-title="Quick answer!" 
                      data-content=\'<textarea placeholder="Enter answer here.."></textarea><br/>
                                    <button class="postAnswerButton btn btn-success pull-right">
                                    <i class="icon-share-alt icon-white"></i>
                                    Answer!</button>\' 
                      data-original-title="Post Answer"
                      data-placement="bottom">
                      '.$this->sqlGetAnswerCount($row['q_id']).' Answers
                    </a>
                    <i class="icon-eye-open"></i>
                    <a >'.$this->sqlReadViewCount($row['q_id']).' Views</a>
                    <i class="icon-user"></i>
                    <a rel="tooltip" data-placement="bottom" 
                    data-original-title="'.
                    $this->sqlGetFollowersForQuestion($row['q_id'])
                    .'">
                    '.$this->sqlGetFollwersCountForQuestion($row['q_id']).'
                    Followers</a>
                  <div style="float:right">
                    FLike,Tweet                    
                    </div>
                  </div><!--/questionStatsDiv-->
                  
                </div><!--/questionPostDiv-->

      ';
    }

return $content;
  }
else

  return 'No Questions posted in the year scope yet ';
  }*/
  function getGlobalScopeQuestions(){
    $content=null;
    $sql="SELECT *

      FROM
        QUESTION 
      where 
         scope=0"
      ;

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
        $userMarkup='<img src="'.base_url().'assets/img/users/9999.jpg" height="40px" width="40px" alt="James" class="display-pic" />
                  
                 <strong>Anonymous</strong> 
            ';
      else
        $userMarkup=$this->userMarkup($row['posted_by']);


      $content.='
        <div id="questionPostDiv" class="well questionElement" style="background-color:white">
                  <div id="userDetailDiv">
                  '.$userMarkup.' <div style="float:right"></div>
                  </div>
                  <div id="questionDetailsDiv">
                    <p id="questionContent">
                    <strong><a class="question" id="'.$row['q_id'].'" href="'.$questionUrl.$row['url'].'">'.$row['q_content'].'</a>
                    </strong>
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

    
  
    $sql="select * from TOPIC_FOLLOWERS where follower=? and topic_id=?";
    $query=$this->db->query($sql,array($user_id,$topic_id));
    if ($row=$query->row_array() ) {
      return TRUE;
    }
    else
      return FALSE;

  }


	function sqlGetFollowersForQuestion($q_id){

	
		$query="select user_id from FOLLOWERS where q_id=?";
		$query=$this->db->query($query,array($q_id));
		$followers='';
    if($result=$query->result_array()){
        		foreach($result as $row ) {
        			$followers.=$this->sqlGetUserName($row['user_id']).'</br>';
        		}
		        $followers.='also follow this..';
		        return $followers;
    }
    else
      return 'no one follows';


	}
  function sqlGetFollowersForTopic($topic_id){

  
    $query="select * from TOPIC_FOLLOWERS where topic_id=?";
    $query=$this->db->query($query,array($topic_id));
    $followers='';
    if($result=$query->result_array()){
            foreach($result as $row ) {
              $followers.=$this->sqlGetUserName($row['follower']).'</br>';
            }
            $followers.='also follow this..';
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

		$timestamp=$this->getCurrentTime();
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
      $sql = "insert into QUESTION(q_content,q_description,topic_id,posted_by,timestamp,url,anonymous,scope) 
          values(?,?,?,?,?,?,?,?)";
      $status=$this->db->query($sql,array($questionArray['q_content'],$questionArray['q_description'],$questionArray['topic_id'],$posted_by,$timestamp,$this->generateQuestionUrl($questionArray['q_content']),$anonymous,$scope,$scope_id));
      if($status==-1){
        $status='success';
        $msg='Question posted successfully!!.. Redirecting you';
        $qsUrl=$this->sqlGetQuestionUrlForQuestion($questionArray['q_content']);
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

  function sqlUpdateViewCount($q_id){
  	$sql = "update QUESTION set views = views + 1 where q_id=?"; 
  	$status=$this->db->query($sql,array($q_id));

  }

  function sqlCreateFollower($q_id,$posted_by){
  	
  	$sql = "insert into FOLLOWERS(q_id,user_id) values(?,?)";
  	$status=$this->db->query($sql,array($q_id,$posted_by));
    if($status==-1){
      return "success";
    }
  }

  function sqlCreateFollowerTopic($topic_id,$follower){
    
    $sql = "insert into TOPIC_FOLLOWERS(topic_id,follower) values(?,?)";
    $status=$this->db->query($sql,array($topic_id,$follower));

  }
  function sqlDeleteFollower($q_id,$posted_by){
  	 
  	$sql = "delete from FOLLOWERS where q_id =? and user_id =?";
  	$status=$this->db->query($sql,array($q_id,$posted_by));
    if($status==-1){
      return "success";
    }
  }
  function sqlDeleteFollowerTopic($topic_id,$follower){
     
    $sql = "delete from TOPIC_FOLLOWERS where topic_id =? and follower =?";
    $status=$this->db->query($sql,array($topic_id,$follower));

    
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

		
			$content.='<div class=well> <a href="'.base_url().'ProfileController/ViewTopic/'.$row['topic_url'].'"> '.$row['topic_name'].'</a><div style="float:right">'.$dynamicFollowOrUnfollowButton.'</div></div>';
		
		}
		if($content=='<h2>Topics Under this Category are:</h2>')
			$content.='No topics Under this Category yet!'; 

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