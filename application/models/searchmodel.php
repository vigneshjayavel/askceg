<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SearchModel extends CI_Model{

	function getCenterContentSearchQuestion(){

		return "Content for search questions page..";

	}


	function getCenterContentSearchDiscussion(){

		return "Content for search discussion page..";

	}
	function sqlReturnSearchResult($searchTerm){
		$searchTerm="ibatch website";
		$sql="select q_content from question where q_content like ?";
		$query=$this->db->query($sql,array($searchTerm));
		//$result=$query->result_array();
		$searchResults=array();
		foreach($query->result_array() as $row){
			array_push($searchResults,array('result'=>$row['q_content'],'type'=>'question'));
		}
		$sql="select topic_name from topic where topic_name like ?";
		$query=$this->db->query($sql,array($searchTerm));
		$result=$query->result_array();
		$searchResults=array();
		foreach($query->result_array() as $row){
			array_push($searchResults,array('result'=>$row['topic_name'],'type'=>'topic'));
		}
		return ($searchResults);
		
		
	}

}
