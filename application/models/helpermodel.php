<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class HelperModel extends CI_Model{

	function sqlIsUrlExists($url){

		//check if the url is already present in the db
		//if so return true else false
		$query="select count(url) as cnt from URL where url = ?";
        $query=$this->db->query($query,array($url));
        $row=$query->row_array();
        if($row['cnt']==1)
    	    return true;
    	else
    		return false;

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


	function sqlIsQuestionExists($qs){
		//check if the qs is already present in the db
		//if so return true else false
		$query="select count(q_content) as cnt from QUESTION where q_content = ?";
        $query=$this->db->query($query,array($qs));
        $row=$query->row_array();
        if($row['cnt']==1)
    	    return true;
    	else
    		return false;

	}

	function sqlGetUrl($q_id){

		//return url for a given q_id
		$query="select url from URL where q_id = ?";
        $query=$this->db->query($query,array($q_id));
        $row=$query->row_array();
        if($row!=null){
        	return $row['url'];
        }
    	else
    		echo "no url found";

	}

	function sqlGetQid($url){

		//return q_id for a given url
		$query="select q_id from URL where url = ?";
        $query=$this->db->query($query,array($url));
        $row=$query->row_array();
        if($row!=null){
        	return $row['q_id'];
        }
    	else
    		echo "no qid found";

	}

	function sqlgetQContent($url){
		//return q_content for a given url
		$query="select q.q_content from 
		QUESTION q, URL u where q.q_id=u.q_id and u.url = ?";
        $query=$this->db->query($query,array($url));
        $row=$query->row_array();
        if($row!=null){
        	return $row['q_content'];
        }
    	else
    		echo "nothing found";
	}



}