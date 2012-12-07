<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class QuestionsModel extends CI_Model{

	function getCenterContent(){

		return "Content for questions page..";

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
              <select disabled="true" data-placement="top" data-original-title="Topic under which your question fits in" id="topicSelectBox">
                <option>Select a category first</option>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="textarea">Question</label>
            <div class="controls">
              <textarea data-placement="top" data-original-title="Ask something!!!"  disabled="true" id="questionText" class="input-xlarge" rows="3"></textarea>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="textarea">Question Description (Optional)</label>
            <div class="controls">
              <textarea data-placement="top" data-original-title="People will be happy to hear more!!!"  disabled="true" id="questionDescText" class="input-xlarge" rows="3"></textarea>
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
          <div class="form-actions">
            <a disabled=true id="postQuestionButton" type="submit" class="btn btn-danger"><i class="icon-ok icon-white"></i>Post It</a>
            <a id="resetQuestionButton" type="reset" class="btn btn-primary"><i class="icon-remove icon-white"></i>Reset</a>
          </div>
        </fieldset>
      </form>
      ';

	}

	function getCenterContentAnswerQuestion(){

		return "Content for AnswerQuestions page..";

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
              <textarea data-placement="top" data-original-title="create one!!!"  disabled="true" id="questionText" class="input-xlarge" rows="3"></textarea>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="textarea">Topic Description (Optional)</label>
            <div class="controls">
              <textarea data-placement="top" data-original-title="People will be happy to hear more!!!"  disabled="true" id="questionDescText" class="input-xlarge" rows="3"></textarea>
            </div>
          </div>
                   
          <div class="form-actions">
            <a disabled=true id="postQuestionButton" type="submit" class="btn btn-danger"><i class="icon-ok icon-white"></i>Create now</a>
            </div>
        </fieldset>
      </form>
      ';

	}


	
	function sqlReadQuestions($category_id=null,$topic_id=null,$q_id=null){

		$content=null;
		
	
		$sql = "SELECT 
          q.q_id,q.q_content,q.q_description,q.topic_id,
					t.topic_name,c.category_name ,c.category_id,q.posted_by,
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
		if($topic_id!=null){
      $topic_id=mysql_real_escape_string($topic_id);
      $sql.=" and t.topic_id=".$topic_id;
    }
		if($q_id!=null){
      $q_id=mysql_real_escape_string($q_id);
      $sql.=" and q.q_id=".$q_id;
    }
			

		$query=$this->db->query($sql);
		$categoryUrl=base_url().'QuestionsController/viewQuestion/';
		$questionUrl=base_url().'AnswersController/viewAnswersForQuestion/';
		$followUrl=	base_url().'QuestionsController/followQuestion/';
		$unfollowUrl=	base_url().'QuestionsController/unfollowQuestion/';

		$CI =& get_instance();
		$currentUserName=$CI->session->userdata('user_name');
		foreach($query->result_array() as $row ) {
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

				<div id="questionPostDiv" class="well" style="background-color:white">
                  <div id="userDetailDiv">
                   <img src="'.$url.'" height="40px" width="40px" alt="James" class="display-pic" />
                   
                  <strong>'.$row['posted_by'].'</strong>
                    <div style="float:right">'.$dynamicFollowOrUnfollowButton.'</div>
                  </div>
                  <div id="questionDetailsDiv">
                    <p id="questionContent">
                    <strong><a class="question" id="'.$row['q_id'].'" href="'.$questionUrl.$row['q_id'].'">'.$row['q_content'].'</a>
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
                    href="'.$categoryUrl.$row['category_id'].'/'.$row['topic_id'].'" class="label label-info">'.$row['topic_name'].'
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

		$jsonObj=json_encode(array('content'=>$content
							));
		return $content;

	}
	function getGroupScopeQuestions(){
		$content=null;
    $CI =& get_instance();
    $groupId=$CI->session->userdata('group_id');
    $sql="SELECT q.q_id,q.q_content,q.q_description,q.topic_id,
					t.topic_name,c.category_name ,c.category_id,q.posted_by,
					q.timestamp
				
				FROM
					QUESTION q, TOPIC t, CATEGORY c 
				where 
					q.topic_id=t.topic_id and
					t.category_id=c.category_id and q.scope='group' and q.scope_id='$groupId'"
				;

    $query=$this->db->query($sql);
    // $row=$query->result_array();
    $categoryUrl=base_url().'QuestionsController/viewQuestion/';
		$questionUrl=base_url().'AnswersController/viewAnswersForQuestion/';
		$followUrl=	base_url().'QuestionsController/followQuestion/';
		$unfollowUrl=	base_url().'QuestionsController/unfollowQuestion/';

		$CI =& get_instance();
		$currentUserName=$CI->session->userdata('user_name');
		foreach($query->result_array() as $row ) {
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

				<div id="questionPostDiv" class="well" style="background-color:white">
                  <div id="userDetailDiv">
                   <img src="'.$url.'" height="40px" width="40px" alt="James" class="display-pic" />
                   
                  <strong>'.$row['posted_by'].'</strong>
                    <div style="float:right">'.$dynamicFollowOrUnfollowButton.'</div>
                  </div>
                  <div id="questionDetailsDiv">
                    <p id="questionContent">
                    <strong><a class="question" id="'.$row['q_id'].'" href="'.$questionUrl.$row['q_id'].'">'.$row['q_content'].'</a>
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
                    href="'.$categoryUrl.$row['category_id'].'/'.$row['topic_id'].'" class="label label-info">'.$row['topic_name'].'
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


	function sqlCheckUserFollowsQuestion($user_name,$q_id){

		
	
		$query="select user_name from FOLLOWERS where user_name=? and q_id=?";
		$query=$this->db->query($query,array($user_name,$q_id));
		if ($row=$query->row_array() ) {
			return TRUE;
		}
		else
			return FALSE;

	}


	function sqlGetFollowersForQuestion($q_id){

	
		$query="select user_name from FOLLOWERS where q_id=?";
		$query=$this->db->query($query,array($q_id));
		$followers='';
		foreach($query->result_array() as $row ) {
			$followers.=$row['user_name'].'</br>';
		}
		$followers.='also follow this..';
		return $followers;		


	}

	function sqlGetFollwersCountForQuestion($q_id){

	
		$query="select count(*) as cnt from FOLLOWERS where q_id=?";
		$query=$this->db->query($query,array($q_id));
	    $row=$query->row_array();
	    return $row['cnt'];		

	}

	function sqlGetUserid($user_name)
	{
	   
		$query="select u.user_id from USERS u where u.user_name=?";
		$query=$this->db->query($query,array($user_name));
    $row=$query->row_array();
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


		//actual question insert
		$sql = "insert into QUESTION(q_content,q_description,topic_id,posted_by,timestamp) 
				values(?,?,?,?,?)";
		$status=$this->db->query($sql,array($questionArray['q_content'],$questionArray['q_description'],$questionArray['topic_id'],$posted_by,$timestamp));
		


		if($status==-1){
			$status='success';
			$msg='Question posted successfully!!';
		}
		else{
			$status='error';
			$msg='Question cannot be posted due to technical reasons!';
		}
		

		$jsonObj=json_encode(array('status'=>$status,
									'msg'=>$msg
							));
		return $jsonObj;

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
    	
		$sql = "insert into FOLLOWERS(q_id,user_name) values(?,?)";
		$status=$this->db->query($sql,array($q_id,$posted_by));

		
    }
    function sqlDeleteFollower($q_id,$posted_by){
    	 
		// This assumes you followed the Getting Start guide...
		$sql = "delete from FOLLOWERS where q_id =? and user_name =?";
		$status=$this->db->query($sql,array($q_id,$posted_by));

		
    }

    function sqlReadViewCount($q_id){
 
	
		$sql="select views from QUESTION a where a.q_id=?";
			$query=$this->db->query($sql,array($q_id));
			$row=$query->row_array();
				    return $row['views'];


	}
	
	function sqlGetTopicsInCategory($categoryId){

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


}