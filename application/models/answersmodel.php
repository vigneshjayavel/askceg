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

	function sqlReadAnswers($q_id=null,$curr_id){


		//get question's markup from QuestionModel
		//get_instance() is a function defined in the core files of CodeIgniter. You use it to get the singleton reference to the CodeIgniter super object when you are in a scope outside of the super object.


		$CI =& get_instance();
    	$CI->load->Model('QuestionsModel');

		$questionMarkup=$CI->QuestionsModel->sqlReadQuestions(null,null,$q_id);


		$content=null;

	
		$sql = "SELECT 
			         *
				FROM
					ANSWER a 
				where 
					a.q_id=? 
				order by a.a_id desc
				";

		$query=$this->db->query($sql,array($q_id));
		$i=0;

		$previousAnswers='';
		$url_curr=base_url()."assets/img/".$curr_id.".jpg";
		foreach($query->result() as $row ) {
			$url=base_url()."assets/img/".$this->sqlGetUserid($row->posted_by).".jpg";
		     
		     
			$previousAnswers.='
				<div id="answerDiv'.$row->a_id.'" class="well">
					'.'	<div id="userDetailDiv">
				           	<img src="'.$url.'" height="40px" width="40px" alt="James" class="display-pic" />
				           
				          	<a class="answer" id="#" href="#">'.$row->posted_by.'</a>
				            <div id="answerVoteStats" style="float:right">
						
							</div>
						</div>
						'.$row->a_content.'
		    			<div id="answerStats" style="float:right">
		    				<a href=#><i class="icon-circle-arrow-up"></i>Vote</a>
		    				<a href=#><i class="icon-circle-arrow-down"></i></a>
		    				<i class="icon-time"></i>'.$row->timestamp.' 
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
	    $row=$query->row_array();
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
        $url=base_url()."assets/img/".$posted_by_id.".jpg";
		
				
        $answerMarkup='
        	<div id="answerDiv'.'dummy-id'.'" class="well">
			'.'<div id="userDetailDiv">
				   	<img src="'.$url.'" height="40px" width="40px" alt="James" class="display-pic" />
   				   	<a class="answer" id="#" href="#">'.$posted_by.'</a>
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