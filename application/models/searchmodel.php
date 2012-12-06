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
		$sql="select q_content from QUESTION where q_content LIKE '%".$this->db->escape_like_str($searchTerm)."%'";
		$query=$this->db->query($sql);
		$searchResults=array();
		$result=$query->result_array();
		foreach($result as $row){
			array_push($searchResults,array('resultData'=>$row['q_content'],'resultType'=>'Question'));
		}

		//search topics
		$sql="select topic_name from TOPIC where topic_name LIKE '%".$this->db->escape_like_str($searchTerm)."%'";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		foreach($result as $row){
			array_push($searchResults,array('resultData'=>$row['topic_name'],'resultType'=>'Topic'));
		}

		return json_encode($searchResults);
		
		
	}

}
