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
		return 'Welcome!';

	}
  function getHomePage(){

    $CI=&get_instance();
    $query="select profile_pic from USERS u where u.user_id=?";
    $query=$this->db->query($query,array($CI->session->userdata('user_id')));
    $content='';
    if($row=$query->row_array()){
                  $content.='<div id="bio">
                  <img src="'.$row['profile_pic'].'" alt="No pic" class="display-pic" />
                  <h3>Greetings '.$CI->session->userdata('user_name').'!</h3>
                  <p>
                  <img height="125" width="125" src="'.base_url().'assets/img/fbthumb.jpg" />
                   Get to know about AskCEG.. Please read the following info..</p>
                   </div>';
    }
    $content.='
    
          <div class="">
            
            <ul id="myTab" class="nav nav-tabs">
              <li class="active"><a href="#about" data-toggle="tab">About AskCEG</a></li>
              <li><a href="#team" data-toggle="tab">The Team</a></li>
              <li><a href="#tech" data-toggle="tab">Technologies Used</a></li>              
              <li><a href="#suggestions" data-toggle="tab">Suggestions</a></li>  
            </ul>
            <div id="myTabContent" class="tab-content">
              <div class="tab-pane fade active in" id="about">
               
             <div class="accordion" id="accordion2">
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                      What is AskCEG?
                    </a>
                  </div>
                  <div id="collapseOne" class="accordion-body collapse in">
                    <div class="accordion-inner">
                      An interactive online forum exclusively for fellow CEGians.
                    </div>
                  </div>
                </div>
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                      How it is different from other online forums?
                    </a>
                  </div>
                  <div id="collapseTwo" class="accordion-body collapse">
                    <div class="accordion-inner">
                        <p><p><ul><li><span style="line-height: 1.45em;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;AskCeg provides an unparalleled platform for hands-on interaction with teachers.</span><br></li><li><span style="line-height: 1.45em;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Authenticity is assured.</span><br></li><li><span style="line-height: 1.45em;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Facilities to follow teachers.</span><br></li><li><span style="line-height: 1.45em;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Post questions to teachers.</span><br></li><li><span style="line-height: 1.45em;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Inculcates a healthy relation with seniors.</span><br></li><li><span style="line-height: 1.45em;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Not only do we have our doubts cleared, discussions on placements,&nbsp;</span><span style="line-height: 1.45em;">&nbsp;internships, college fests will enlighten the student community as a&nbsp;</span><span style="line-height: 1.45em;">whole.</span><br></li></ul></p><br></p>
                    </div>
                  </div>
                </div>
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
                      What are its cool features?
                    </a>
                  </div>
                  <div id="collapseThree" class="accordion-body collapse">
                    <div class="accordion-inner">
                      <p><ul><li><span style="line-height: 1.45em;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Easy categorization of questions/posts.</span><br></li><li><span style="line-height: 1.45em;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Create topics within categories.</span><br></li><li><span style="line-height: 1.45em;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Follow Users.</span><br></li><li><span style="line-height: 1.45em;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Follow Questions.</span><br></li><li><span style="line-height: 1.45em;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Answer Questions</span><br></li><li><span style="line-height: 1.45em;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Vote up/down Answers.</span><br></li><li><span style="line-height: 1.45em;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Follow Topics.</span><br></li><li><span style="line-height: 1.45em;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Separate group profiles for each batch.</span><br></li></ul></p>                    

                    </div>
                  </div>
                </div>
              </div>
              </div>     
              <div class="tab-pane fade" id="team">
              <h2>The Developers</h2>
                <div id="vikki" >
                  <div >
                    <div class="span12">
                      <h4><strong><a href="https://www.facebook.com/Vikki.ceg">Vignesh Jayavel</a></strong></h4>
                    </div>
                  </div>
                  <div >
                    <div class="span2">
                      <a href="https://www.facebook.com/Vikki.ceg" class="thumbnail">
                          <img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-snc7/c37.37.457.457/s160x160/418158_513008858731558_1392611612_n.jpg" alt="">
                      </a>
                    </div>
                    <div class="span6">      
                      <p>4th year MSc CS (Integrated)</p>
                      <address>
                      Student Director at <a href="www.cegtechforum.com">CEG Tech Forum</a>
                      </address>
                    </div>
                  </div>
                  
                </div>
                <div id="vishnu">
                  <div >
                    <div class="span12">
                      <h4><strong><a href="https://www.facebook.com/vishnu.jayvel">Vishnu Jayavel</a></strong></h4>
                    </div>
                  </div>
                  <div >
                    <div class="span2">
                      <a href="https://www.facebook.com/vishnu.jayvel" class="thumbnail">
                          <img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-prn1/c66.66.828.828/s160x160/532511_387198618032683_200153497_n.jpg" alt="">
                      </a>
                    </div>
                    <div class="span6">      
                      <p>2nd year BE - CSE</p>
                      
                    </div>
                  </div>
                  
                </div>
                <div class="span12" id="others">
                  <h3>We also have these cool folks in our team!</h3>
                  <p><a href=""><b>Narain Sharma</b></a> 2nd year BE - CSE</p>
                  <p><a href=""><b>Hema Varman</b></a> 2nd year BE - CSE</p>
                </div>
              </div>     

              <div class="tab-pane fade" id="tech">
                <h2>We have used some cool Web technologies!</h2>
                <ul>
                  <li>CodeIgniter Php framework</li>
                  <li>MySQL database</li>
                  <li>jQuery</li>
                  <li>BackboneJS</li>
                  <li>Twitter Bootstrap</li>
                  <li>Amazon WebServices</li>
                  <li>git DVCS</li>
                </ul>
              </div>     
              <div class="tab-pane fade" id="suggestions">
                <h2>Your suggestions help us!</h2>
                <p>Send us your view/ideas/suggestions to <a href="emailto:admin@askceg.krk.org.in"></a></p>
              </div>         
            </div>
          </div>




    ';


    return $content;

  }
  function sqlGetUserid($user_name)
  {


  
    $query="select user_id from USERS u where u.user_name=?";
    $query=$this->db->query($query,array($user_name));
   
      if($row=$query->row_array())
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
