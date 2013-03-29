<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SearchModel extends CI_Model{

	function getCenterContentSearchQuestion(){

		return "Content for search questions page..";

	}


	function getCenterContentSearchDiscussion(){

		return "Content for search discussion page..";

	}
	function sqlReturnSearchResult($searchTerm){

		//search questions
		$sql="select q_content,url from QUESTION where q_content LIKE '%".$this->db->escape_like_str($searchTerm)."%'";
		$query=$this->db->query($sql);
		$searchResults=array();
		$result=$query->result_array();
		foreach($result as $row){
			array_push($searchResults,array('resultData'=>$row['q_content'],'resultType'=>'Question','resultUrl'=>$row['url']));
		}

		//search topics
		$sql="select topic_name,topic_url from TOPIC where topic_name LIKE '%".$this->db->escape_like_str($searchTerm)."%'";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		foreach($result as $row){
			array_push($searchResults,array('resultData'=>$row['topic_name'],'resultType'=>'Topic','resultUrl'=>$row['topic_url']));
		}

		//search users
		$sql="select user_id,user_name from USERS where user_name LIKE '%".$this->db->escape_like_str($searchTerm)."%'";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		foreach($result as $row){
			array_push($searchResults,array('resultData'=>$row['user_name'],'resultType'=>'User','resultUrl'=>$row['user_id']));
		}

		return json_encode($searchResults);
		
		
	}

}
