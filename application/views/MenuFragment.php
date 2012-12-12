<div class="navbar navbar-inverse navbar-fixed-top">
   <div class="navbar-inner">
     <div class="container">
       <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
       </a>
       <a class="brand" href="<?php echo base_url() ?>HomeController">AskCEG</a>
       <div class="nav-collapse" id="main-menu"><ul class="nav" id="main-menu-left">
	<li><a id="swatch-link" href="<?php echo base_url() ?>HomeController">Home</a></li>
	<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Category <b class="caret"></b></a>
		<ul class="dropdown-menu" id="swatch-menu">
		
			<li><a href="<?php echo base_url() ?>QuestionsController/Education">Education</a></li>
              <li><a href="<?php echo base_url() ?>QuestionsController/Entertainment">Entertainment</a></li>
              <li><a href="<?php echo base_url() ?>QuestionsController/Sports">Sports</a></li>
              <li><a href="<?php echo base_url() ?>QuestionsController/Technology">Technology</a></li>
              <li><a href="<?php echo base_url() ?>QuestionsController/Miscellaneous">Miscellaneous</a></li>
              
		</ul>
	</li>
<li class="dropdown" id="preview-menu"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Post<b class="caret"></b></a>
<ul class="dropdown-menu">
	<li><a href="<?php echo base_url() ?>QuestionsController/AskQuestion">question</a></li>
	<li><a href="<?php echo base_url() ?>QuestionsController/AnswerQuestion">answer</a></li>
	
</ul></li></ul>
<form class="navbar-search pull-left" action="">

  <input type="text" id="ajaxSearchPanel" autocomplete="off"
   class="typeahead search-query span6" placeholder="Search for Questions, Categories and Topics" data-provide="typeahead" data-items="4" >
</form>
<ul class="nav pull-right" id="main-menu-right">
	<li class="dropdown" id="preview-menu"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php if ($this->session->userdata('logged_in') == TRUE)
      {
$url=base_url()."assets/img/".$this->session->userdata('user_id').".jpg";
        //redirect to controller/function if there's no valid session
          echo '<img src="'.$url.'" alt="James" height="38px" width="20px" class="display-pic" />'.$this->session->userdata('user_name');
          //$this->load->view('login');
      }
      else
      {
        echo "login/signup";
      }
      ?>
  <b class="caret"></b></a>
<ul class="dropdown-menu">
  <li><a href="<?php echo base_url() ?>ProfileController/MyProfile">MyProfile</a></li>
  <li><a href="<?php echo base_url() ?>AuthController/logout">Logout</a></li>
  
</ul></li>
 </div>
     </div>
   </div>
 </div>
