<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MetaModel extends CI_Model{

    function getMeta($type,$identifier=null){
      $meta='';
        switch($type){
          case 'question':
                          $sql="select q.q_content,q.q_description,q.topic_id,q.posted_by,u.user_name from QUESTION q,USERS u where q.url=? and q.posted_by=u.user_id and q.scope=0";
                          $query=$this->db->query($sql,array($identifier));

                          if($row=$query->row_array()){
                             if(file_exists(base_url().'assets/img/topic/'.$row['topic_id'].'.jpg'))
                              $url=base_url().'assets/img/topic/'.$row['topic_id'].'.jpg';
                            else
                              $url=base_url().'assets/img/defaultquestion.jpg';
                          $meta='<meta property="og:title" content="'.$row['q_content'].'"/>
                               <meta property="og:image" content="'.$url.'"/>
                               <meta property="og:site_name" content="askceg.in"/>
                               <meta property="og:description" content="posted by '.$row['user_name'].$row['q_description'].'"/>
                             ';
                          }
                          else{
                            return $this->getMeta("normal");
                       
                          }
                          break;
          case 'topic':
                          $sql="select t.topic_id,t.topic_name,t.topic_desc,t.posted_by,u.user_name from TOPIC t,USERS u where t.topic_url=? and t.posted_by=u.user_id";
                          $query=$this->db->query($sql,array($identifier));
                          
                          if($row=$query->row_array()){

                             if(file_exists(base_url().'assets/img/topic/'.$row['topic_id'].'.jpg'))
                              $url=base_url().'assets/img/topic/'.$row['topic_id'].'.jpg';
                            else
                              $url=base_url().'assets/img/defaulttopic.jpg';
                            if($row['topic_desc']==null){
                              $desc='created by'.$row['user_name'];
                            }
                            else{
                              $desc=$row['topic_desc'];
                            }
                            $meta='<meta property="og:title" content="'.$row['topic_name'].'"/>
                               <meta property="og:image" content="'.base_url().'assets/img/topics/'.$row['topic_id'].'"/>
                               <meta property="og:site_name" content="askceg.in"/>
                               <meta property="og:description" content="'.$desc.'"/>
                             ';
                          }
                          else{
                            return $this->getMeta("normal");
                       
                          }
                          break;
        case 'answer':
                         $sql = "SELECT 
                        q.q_content,a.a_content,a.posted_by,q.topic_id
                        FROM
                        ANSWER a,QUESTION q
                        where 
                        a.q_id=q.q_id AND a.a_id=?
                        order by a.a_id desc
                        ";
                         $query=$this->db->query($sql,array($identifier));
                          if($row=$query->row_array()){

                             if(file_exists(base_url().'assets/img/topic/'.$row['topic_id'].'.jpg'))
                              $url=base_url().'assets/img/topic/'.$row['topic_id'].'.jpg';
                            else
                              $url=base_url().'assets/img/defaulttopic.jpg';
                              $meta='<meta property="og:title" content="'.$row['q_content'].'"/>
                               <meta property="og:image" content="'.base_url().'assets/img/topics/'.$row['topic_id'].'"/>
                               <meta property="og:site_name" content="askceg.in"/>
                               <meta property="og:description" content="'.$row['a_content'].'"/>
                             ';
                           }
                           else{
                            return $this->getMeta("normal");
                       
                          }
                           break;
        case 'normal' :
                       $meta='<meta property="og:title" content="AskCEG"/>
                               <meta property="og:image" content="'.base_url().'assets/img/fbthumb.jpg"/>
                               <meta property="og:site_name" content="askceg.in"/>
                               <meta property="og:description" content="AskCEG - an exclusive question and answer platform for CEGians"/>
                             ';
                             break;



                          
        }
        return $meta;
         
    }

    


	}
