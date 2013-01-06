<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AnswersModel extends CI_Model{

	/*
	function dbTest(){

		$sql="select * from dummy where id=? and name=?";
		$query=$this->db->query($sql,array(1,"vishnu"));
		$i=1;
		foreach($query->result() as $row){

			echo $i.' '.$row->name.' '.$row->id."\n";
			$i++;

		}
	}
*/
function sqlGetUserName($user_id){
  
    $query="select user_name from USERS u where u.user_id=?";
        $query=$this->db->query($query,array($user_id));
           if($row=$query->row_array())
            return $row['user_name'];
          else
            return $user_id;

  }
  function userMarkup($user_id){
          $url=base_url()."assets/img/users/".$user_id.".jpg";

    return '<img src="'.$url.'" height="40px" width="40px" alt="James" class="display-pic" />
                   
                <a href="'.base_url().'ProfileController/ViewUserProfile/'.$user_id.'"> <strong>'.$this->sqlGetUserName($user_id).'</strong> </a>
                   ';

  }
  function sqlUpdateVote($a_id,$vote){
  	$CI=&get_instance();
  	$user_id=$CI->session->userdata('user_id');
  	$sql="insert into VOTE(a_id,user_id,vote,timestamp) values(?,?,?,?)";
  	$query=$this->db->query($sql,array($a_id,$user_id,$vote,$this->getCurrentTime()));

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

	function sqlReadAnswers($url=null,$curr_id){


		//get question's markup from QuestionModel
		//get_instance() is a function defined in the core files of CodeIgniter. You use it to get the singleton reference to the CodeIgniter super object when you are in a scope outside of the super object.


		$CI =& get_instance();
    	$CI->load->Model('QuestionsModel');

		$questionMarkup=$CI->QuestionsModel->sqlReadQuestions(null,null,$url);


		$content=null;
        $q="select q_id from QUESTION where url=?";
        $query=$this->db->query($q,array($url));
        $row=$query->row_array();
        $q_id=$row['q_id'];
		

	
		$sql = "SELECT 
			         a.a_id,a.a_content,a.q_id,a.posted_by,a.timestamp
				FROM
					ANSWER a
				where 
					a.q_id=? 
				order by a.a_id desc
				";

		$query=$this->db->query($sql,array($q_id));
		$i=0;

		$previousAnswers='';
		$url_curr=base_url()."assets/img/users/".$curr_id.".jpg";
		foreach($query->result() as $row ) {
		     
		     
			$previousAnswers.='
				<div class="answerElementDiv" data-a_id="'.$row->a_id.'" class="well" style="float:left;width:100%">
					<div class="answerVotesDiv" style="float:left;text-align:center">
						<div class="upVotesDiv" style="height:30%; ">
							<a class="voteButton upVoteButton" href="#" ><i class="icon-thumbs-up"></i></a>
	    				</div>
	    				<div class="votesCountDiv" style="height:40%; ">
	    					<span class="votesCount">'.$this->sqlGetVotesCoutForAnswer($row->a_id).'</span>
	    				</div>
						<div class="downVotesDiv" style="height:30%; ">
							<a class="voteButton downVoteButton" href="#" ><i class="icon-thumbs-down"></i></a>
						</div>
					</div>
					<div class="answerDiv" style="float:left;">
					'.'	<div class="userDetailDiv">'.
							$this->userMarkup($row->posted_by).'
						</div>
						<div class="answerContentDiv">
						'.$row->a_content.'
						</div>
		    			<div class="answerStatsDiv " style="float:right" >
		    				<i class="icon-time"></i>'.$row->timestamp.' 
			    		</div>
		    		</div>
			    </div>';

		
		}

		$previousAnswersPlusAddNewAnswerFormMarkup='
		<div class="well" id="addAnswerContainer">
			<img src="'.$url_curr.'" height="40px" width="40px" alt="James" class="display-pic" />
				           <textarea name="body" id="answerText"></textarea>
	        <input disabled=true class="btn btn-danger" 
	        type="submit" id="postAnswerButton" value="Answer!" />
		</div>
		
		<div id="previousAnswersDiv">'
			.$previousAnswers.'
		</div>
		';


		$str=$questionMarkup.$previousAnswersPlusAddNewAnswerFormMarkup;

		return $str;

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