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

  <input type="text" id="ajaxSearchPanel"
   class="search-query span4" placeholder="Search" data-provide="typeahead" data-items="4" data-source="[&quot;Alabama&quot;,&quot;Alaska&quot;,&quot;Arizona&quot;,&quot;Arkansas&quot;,&quot;California&quot;,&quot;Colorado&quot;,&quot;Connecticut&quot;,&quot;Delaware&quot;,&quot;Florida&quot;,&quot;Georgia&quot;,&quot;Hawaii&quot;,&quot;Idaho&quot;,&quot;Illinois&quot;,&quot;Indiana&quot;,&quot;Iowa&quot;,&quot;Kansas&quot;,&quot;Kentucky&quot;,&quot;Louisiana&quot;,&quot;Maine&quot;,&quot;Maryland&quot;,&quot;Massachusetts&quot;,&quot;Michigan&quot;,&quot;Minnesota&quot;,&quot;Mississippi&quot;,&quot;Missouri&quot;,&quot;Montana&quot;,&quot;Nebraska&quot;,&quot;Nevada&quot;,&quot;New Hampshire&quot;,&quot;New Jersey&quot;,&quot;New Mexico&quot;,&quot;New York&quot;,&quot;North Dakota&quot;,&quot;North Carolina&quot;,&quot;Ohio&quot;,&quot;Oklahoma&quot;,&quot;Oregon&quot;,&quot;Pennsylvania&quot;,&quot;Rhode Island&quot;,&quot;South Carolina&quot;,&quot;South Dakota&quot;,&quot;Tennessee&quot;,&quot;Texas&quot;,&quot;Utah&quot;,&quot;Vermont&quot;,&quot;Virginia&quot;,&quot;Washington&quot;,&quot;West Virginia&quot;,&quot;Wisconsin&quot;,&quot;Wyoming&quot;]">
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
