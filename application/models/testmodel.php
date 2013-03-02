<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestModel extends CI_Model{


  function getQuestions($set){   

    $limit=20;
    if($set!=null){
      /*
      set = start,   limit
      1  = 20   , 20
      2=40,20
      3=60,20
      4=80,20
      5=100,20
      for set=1 we'll be getting records from 0,19 (20 being the limit)
      for set=2 we'll be getting records from 20,39 (20 being the limit)
      for set=3 we'll be getting records from 40,59 (20 being the limit)
      */
      $startIndex=$set*20;
      $q="select q_id,q_content from QUESTION order by q_id "."LIMIT ".$startIndex.",".$limit;
    }else{
      $q="select q_id,q_content from QUESTION order by q_id LIMIT 0,".$limit;      
    }
    $query = $this->db->query($q);  
    return $query->result();  
    
  } 



}