<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HomeModel extends CI_Model{

	function getCenterContent(){
    //if($this->session->userdata('logged_in')==true)
//$name=;
//$url=base_url()."images/profile_normal.jpg";
		$carousel='
               <div id="myCarousel" class="carousel slide">
                <div class="carousel-inner">
                  <div class="item">
                    <img src="'.base_url().'assets/img/carousel/1.jpg" height="500px" width="800px" alt="">
                    <div class="carousel-caption">
                      <h4>ASkCEG-Online forum</h4>
                      <p>have questions?we will help you find your answer!!!</p>
                    </div>
                  </div>
                  <div class="item active">
                    <img src="'.base_url().'assets/img/carousel/2.jpg" height="500px" width="800px" alt="">
                    <div class="carousel-caption">
                      <h4>CEG\'s first ever online forum</h4>
                      <p>welcome to AskCEG ,first of its kind app to help CEG students!!</div>
                  </div>
                  <div class="item">
                    <img src="'.base_url().'assets/img/carousel/3.jpg" height="500px" width="800px" alt="">
                    <div class="carousel-caption">
                      <h4>ASkCEG - revolutionizing CEG</h4>
                      <p>help your fellow cegians by answering their questions !!</p></div>
                  </div>
                </div>
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
              </div>
              ';
		return $carousel;

	}
  function sqlGetUserid($user_name)
  {


  
    $query="select user_id from USERS u where u.user_name=?";
    $query=$this->db->query($query,array($user_name));
   
      $row=$query->row_array();
      return $row['user_id'];

  }
  function getTicker($page=null)
  {


    
  
    $sql = "select 
    *
    from QUESTION order by q_id desc limit 0,10";
    $query=$this->db->query($sql);
    
    

    
    
    $tickerMarkup='';    

    $tickerMarkup.='<div class="text" style="height:645px;"">';
       
    $i=0;
    foreach($query->result_array() as $row){
      $url=base_url()."assets/img/".$this->sqlGetUserid($row['posted_by']).".jpg";
      
      $tickerMarkup.=' <div id="updateElement" style="height: 113px;">
       <img src="'.$url.'" height="40px" width="40px" alt="James" class="display-pic" />
                   
                  <strong>'.$row['posted_by'].'</strong>
                 

      <p id="questionDescription"><span>'.$row['q_content'].'</span></p>
                  
        </div>';
      $i++; 
    }
    $tickerMarkup.='</div>';

    $jsonObj=json_encode(array('tickerMarkup'=>$tickerMarkup
              ));
    return $jsonObj;
  }
}
