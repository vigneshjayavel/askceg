<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MetaModel extends CI_Model{
  public function curPageURL() {
     $pageURL = 'http';
     if ( isset( $_SERVER["HTTPS"] ) && strtolower( $_SERVER["HTTPS"] ) == "on" ) {$pageURL .= "s";}
     $pageURL .= "://";
     if ($_SERVER["SERVER_PORT"] != "80") {
      $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
     } else {
      $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
     }
     return $pageURL;
  }

    function getMeta($type,$identifier=null){

      $currentUrl=$this->curPageURL();

      $meta='';
        switch($type){
          case 'question':
                          $sql="select q.q_content,q.q_description,q.topic_id,q.posted_by,u.user_name from QUESTION q,USERS u where q.url=? and q.posted_by=u.user_id and q.scope=0";
                          $query=$this->db->query($sql,array($identifier));

                          if($row=$query->row_array()){
                             if(file_exists($_SERVER['DOCUMENT_ROOT'] .SERVERPATH.$row['topic_id'].'.jpg'))
    
                              $url=base_url().'assets/img/topic/'.$row['topic_id'].'.jpg';
                            else
                              $url=base_url().'assets/img/defaultquestion.jpg';
                          $meta='
                              <meta property="og:type" content="question" /> 
                              <meta property="question:options" content="'.$currentUrl.'" /> 
                              <meta property="og:title" content="'.$row['q_content'].'"/>
                               <meta property="og:image" content="'.$url.'"/>
                               <meta property="og:site_name" content="'.base_url().'"/>
                               <meta property="og:description" content=" Posted by '.$row['q_content'].$row['user_name'].'. '.$row['q_description'].'"/>
                                <meta property="og:url" content="'.$currentUrl.'" />';
                          }
                          else{
                            return $this->getMeta("normal");
                       
                          }
                          break;
          case 'topic':
                          $sql="select t.topic_id,t.topic_name,t.topic_desc,
                          t.posted_by,u.user_name from TOPIC t,USERS u 
                          where t.topic_url=? and t.posted_by=u.user_id";
                          $query=$this->db->query($sql,array($identifier));
                          
                          if($row=$query->row_array()){

                             if(file_exists($_SERVER['DOCUMENT_ROOT'] .SERVERPATH.$row['topic_id'].'.jpg'))
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
                               <meta property="og:image" content="'.$url.'"/>
                               <meta property="og:site_name" content="'.base_url().'"/>
                               <meta property="og:description" content="'.$desc.'"/>
                               <meta property="og:url" content="'.$currentUrl.'" />
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

                             if(file_exists($_SERVER['DOCUMENT_ROOT'] .SERVERPATH.$row['topic_id'].'.jpg'))
                                  $url=base_url().'assets/img/topic/'.$row['topic_id'].'.jpg';
                            else
                              $url=base_url().'assets/img/defaulttopic.jpg';
                              $meta='<meta property="og:type"   content="askcegbeta:question" /> 
                                <meta property="og:title" content="'.$row['q_content'].'"/>
                               <meta property="og:image" content="'.$url.'"/>
                               <meta property="og:site_name" content="'.base_url().'"/>
                               <meta property="og:description" content="Answer : '.strip_tags($row['a_content']).'"/>
                               <meta property="og:url" content="'.$currentUrl.'" />
                             ';
                           }
                           else{
                            return $this->getMeta("normal");
                       
                          }
                           break;
        case 'normal' :
                       $meta='<meta property="og:title" content="AskCEG"/>
                               <meta property="og:image" content="'.base_url().'assets/img/fbthumb-new.jpg"/>
                               <meta property="og:site_name" content="'.base_url().'"/>
                               <meta property="og:description" content="AskCEG - an exclusive question and answer platform for CEGians"/>
                               <meta property="og:url" content="'.$currentUrl.'" />
                             ';
                             break;



                          
        }
        return $meta;
         
    }

    


	}
