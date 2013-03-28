<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AnswersModel extends CI_Model{


function sqlGetUserName($user_id){
  
    $query="select user_name from USERS u where u.user_id=?";
        $query=$this->db->query($query,array($user_id));
           if($row=$query->row_array())
            return $row['user_name'];
          else
            return $user_id;

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
      

    return '<a rel="tooltip" data-placement="bottom" data-original-title="'.$user_name.'" href="'.base_url().'ProfileController/ViewUserProfile/'.$user_id.'">
              <img src="'.$url.'" height="40px" width="40px" alt="'.$user_name.'" class="display-pic" />
            </a>';

  }
  

          
  }

  function sqlUpdateVote($a_id,$vote){
  	$CI=&get_instance();
  	$user_id=$CI->session->userdata('user_id');
  	$sql="insert into VOTE(a_id,user_id,vote,timestamp) values(?,?,?,?)";
  	$query=$this->db->query($sql,array($a_id,$user_id,$vote,$this->getCurrentTime()));

  }

  function sqlDeleteAnswer($a_id){
    $sql='delete from ANSWER where a_id=?';
    if($query=$this->db->query($sql,array($a_id)))
      return 'Answer Removed successfully!';
    else
      return 'Sorry!the answer could not be removed!';

  }
  	function sqlgetVoteCount($a_id){
  		$sql="select sum(vote) from VOTE";

		
	}

	function sqlCheckUserVotedStatus($user_id,$a_id){
	
		$query="select user_id,vote from VOTE where user_id=? and a_id=?";
		$query=$this->db->query($query,array($user_id,$q_id));
		if ($row=$query->row_array() ) {
			return $row['vote'];
		}
		else
			return 0;
	}

	function sqlGetVotesCoutForAnswer($a_id){

		$query="select SUM(vote) as cnt from VOTE where a_id=?";
		$query=$this->db->query($query,array($a_id));
	    $row=$query->row_array();
	    if($row['cnt']!=null && $row!=''){
	    	return $row['cnt'];	
	    }
	    else{
	    	return 0;
	    }
	    

	}

	function sqlReadAnswers($identifier=null,$type=null){


		//get question's markup from QuestionModel
		//get_instance() is a function defined in the core files of CodeIgniter. You use it to get the singleton reference to the CodeIgniter super object when you are in a scope outside of the super object.


		$CI =& get_instance();
    	$CI->load->Model('QuestionsModel');

    	$currentUserId=$CI->session->userdata('user_id');
        $currentUserGroupId=$this->sqlGetGroupid($currentUserId);

    	$deleteUrl=base_url().'AnswersController/DeleteAnswer/';


		$content=null;
    	if($type=='all'){
    		$url=$identifier;
    		$q="select q_id from QUESTION where url=? and (scope=? or scope=0)";
	        $query=$this->db->query($q,array($url,$currentUserGroupId));
	        if($row=$query->row_array())
	        $q_id=$row['q_id'];
	        else
	        	redirect('HomeController/error');

	        $sql = "SELECT 
				         a.a_id,a.a_content,a.q_id,a.posted_by,a.timestamp
					FROM
						ANSWER a
					where 
						a.q_id=?  
					order by a.a_id desc
					";
			$query=$this->db->query($sql,array($q_id));
    }
    else{
    	  $ansId=$identifier;
    	  $q="select q.q_id,q.url from QUESTION q,ANSWER a where a.a_id=? and q.q_id=a.q_id and (q.scope=? or q.scope=0)";
	        $query=$this->db->query($q,array($ansId,$currentUserGroupId));
	        if($row=$query->row_array()){
	        $q_id=$row['q_id'];
	        $url=$row['url'];
	        }

	        else
	        	redirect('HomeController/error');
 			$sql = "SELECT 
				         a.a_id,a.a_content,a.q_id,a.posted_by,a.timestamp
					FROM
						ANSWER a
					where 
						a.a_id=?
					
					";
			$query=$this->db->query($sql,array($ansId));

    }
    	$questionMarkup=$CI->QuestionsModel->sqlReadQuestions(null,null,$url);
		
		$i=0;

		$previousAnswers='';
		$dynamicAnswerVotesDiv='';
		$deleteButton='';

		foreach($query->result() as $row ) {
						
						if($currentUserId==$row->posted_by)
          $deleteButton='
                      <a rel="tooltip" data-placement="top" data-original-title="Delete Question"
                      href="'.$deleteUrl.$row->a_id.'" class="label label-inverse">Delete
                      </a>';
        else
          $deleteButton='';
        
			$vote=$this->sqlCheckUserVotedAnswer($currentUserId,$row->a_id);
			if($vote==1){
				$dynamicAnswerVotesDiv='
				<span class="label label-success">You <i class="icon-thumbs-up"></i> this</span>
				<div class="votesCountDiv" style="height:40%; ">
					<span class="votesCount">'.$this->sqlGetVotesCoutForAnswer($row->a_id).'</span>
				</div>';
			}
			else if($vote==-1){
				$dynamicAnswerVotesDiv='
				<span class="label label-warning">You <i class="icon-thumbs-down"></i> this</span>
				<div class="votesCountDiv" style="height:40%; ">
					<span class="votesCount">'.$this->sqlGetVotesCoutForAnswer($row->a_id).'</span>
				</div>';
			}
			else if($vote==0){
				$dynamicAnswerVotesDiv='
				<div class="upVotesDiv" style="height:30%; ">
					<a class="voteButton upVoteButton" href="#" ><i class="icon-thumbs-up"></i></a>
				</div>
				<div class="votesCountDiv" style="height:40%; ">
					<span class="votesCount">'.$this->sqlGetVotesCoutForAnswer($row->a_id).'</span>
				</div>
				<div class="downVotesDiv" style="height:30%; ">
					<a class="voteButton downVoteButton" href="#" ><i class="icon-thumbs-down"></i></a>
				</div>';
			}
		     
			$previousAnswers.='
			
				<div class="answerElementWrapper">
					<div class="answerElementDiv" data-a_id="'.$row->a_id.'" class="well" style="float:left;width:100%">
						<div class="answerVotesDiv" style="float:left;text-align:center">
							'.$dynamicAnswerVotesDiv.'
						</div>
						<div class="answerDiv" style="float:left;">
						'.'	<div class="userDetailDiv">'.
								$this->userMarkup($row->posted_by).'
							</div>
							<div class="answerContentDiv">
							<a href="'.base_url().'AnswersController/viewAnswer/'.$row->a_id.'" class="linkableAnswerContent">'.$row->a_content.'</a>
							</div>
							'. $deleteButton.'
			    			<div class="answerStatsDiv " style="float:right" >
			    				<i class="icon-time"></i>'.$row->timestamp.' 
				    		</div>
			    		</div>
				    </div>
				</div>
				';

		
		}

		$previousAnswersPlusAddNewAnswerFormMarkup='
		<div class="well" id="addAnswerContainer">
			<textarea name="content" id="answerText"></textarea>
	        <input class="btn btn-success" 
	        type="submit" id="postAnswerButton" value="Answer!" />
		</div>
		
		<div id="previousAnswersDiv">'
			.$previousAnswers.'
		</div>
		';


		$str=$questionMarkup.$previousAnswersPlusAddNewAnswerFormMarkup;

		return $str;

	}

	function sqlCheckUserVotedAnswer($user_id,$a_id){

		$query="select vote from VOTE where user_id=? and a_id=?";
		$query=$this->db->query($query,array($user_id,$a_id));
		if ($row=$query->row_array() ) {
			return $row['vote'];
		}
		else
			return 0;
		
	}


	function getCurrentTime(){//todo

		//get current time
		$temp="SELECT DATE_FORMAT(NOW(), '%I:%i %p %d-%b-%y') AS time";
		$query=$this->db->query($temp);
		$row = $query->row_array();		
		$timestamp=$row['time'];
		return $timestamp;

	}

	function sqlGetUserid($user_name)
	{
	
		$query="select user_id from USERS u where u.user_name=?";
		$query=$this->db->query($query,array($user_name));
	    if($row=$query->row_array())
	    return $row['user_id'];

	}
	function sqlGetGroupid($user_id)
	{
	
		$query="select group_id from USERS u where u.user_id=?";
		$query=$this->db->query($query,array($user_id));
	    if($row=$query->row_array())
	    return $row['group_id'];

	}

	

	function sqlCreateAnswer($answerObj,$posted_by){

		$answerArray=json_decode($answerObj,TRUE);
        
        $timestamp=$this->getCurrentTime();

		// This assumes you followed the Getting Start guide...
		$sql = "insert into ANSWER(a_content,q_id,posted_by,timestamp) 
				values(?,?,?,?)";
	$status=$this->db->query($sql,array($answerArray['a_content'],$answerArray['q_id'],$posted_by,$timestamp));
		


        //return the newly added answer
        $CI =& get_instance();
        $posted_by_id=$CI->session->userdata('user_id');
        $url=base_url()."assets/img/users/".$posted_by_id.".jpg";
		
        //re-query to get just the newly inserted answer's a_id
        $sql="select a_id,timestamp from ANSWER 
        where a_content=? and q_id=? and posted_by=? and timestamp=?";
        $query=$this->db->query($sql,array($answerArray['a_content'],$answerArray['q_id'],$posted_by,$timestamp));
        $row=$query->row_array();

    	$deleteUrl=base_url().'AnswersController/DeleteAnswer/';
        
          $deleteButton='
                      <a rel="tooltip" data-placement="top" data-original-title="Delete Question"
                      href="'.$deleteUrl.$row['a_id'].'" class="label label-inverse">Delete
                      </a>';
        

        $answerMarkup='
        	<div class="answerElementDiv" data-a_id="'.$row['a_id'].'" class="well" style="float:left;width:100%">
				<div class="answerVotesDiv" style="float:left;text-align:center">
					<div class="upVotesDiv" style="height:30%; ">
						<a class="voteButton upVoteButton" href="#" ><i class="icon-thumbs-up"></i></a>
					</div>
					<div class="votesCountDiv" style="height:40%; ">
						<span class="votesCount">0</span>
					</div>
					<div class="downVotesDiv" style="height:30%; ">
						<a class="voteButton downVoteButton" href="#" ><i class="icon-thumbs-down"></i></a>
					</div>
				</div>
				<div class="answerDiv" style="float:left;">
				'.'	<div class="userDetailDiv">'.
						$this->userMarkup($posted_by).'
					</div>
					<div class="answerContentDiv">
					'.$answerArray['a_content'].'
					</div>
						'. $deleteButton.'
	    			<div class="answerStatsDiv " style="float:right" >
	    				<i class="icon-time"></i>'.$row['timestamp'].' 
		    		</div>
	    		</div>
		    </div>
        ';

/*
				
        $answerMarkup='
        	<div id="answerDiv'.'dummy-id'.'" class="well">
			'.'<div id="userDetailDiv">
				   	<img src="'.$url.'" height="40px" width="40px" alt="James" class="display-pic" />
   				   	<a class="answer" id="#" href="#">'.$this->sqlGetUserName($posted_by).'</a>
    			</div>'.$answerArray['a_content'].'
    			<div id="answerStats" style="float:right">
    				<a href=#><i class="icon-circle-arrow-up"></i>Vote</a>
    				<a href=#><i class="icon-circle-arrow-down"></i></a>
    				<i class="icon-time"></i>'.$this->getCurrentTime().'
    			</div>
			</div>';

*/

		if($status==-1){
			$status='success';
		}
		else{
			$status='error';
		}
		

		$jsonObj=json_encode(array('status'=>$status,
									'answerMarkup'=>$answerMarkup
							));
		return $jsonObj;

	}

}