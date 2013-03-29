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

 function createbatch(){
  $depart='IT';
  $departid=9;
  $ys=2009;
  $ye=2013;
  $b=array('G','H');
  foreach ($b as $v) {
    for($i=$ys;$i<2013;$i++){
    $name=$depart.' '.$v.' batch '.$i.'-'.($i+4);
    $desc='Here you can discuss about all happenings in your class and to make it private select the private scope(vi
      sible only to your batch mates) when creating a post/question';
    $sql='INSERT into GROUPS(group_name,group_desc,department_id) values(?,?,?)';
    $query=$this->db->query($sql,array($name,$desc,$departid));
    }
  }
  

 }

}