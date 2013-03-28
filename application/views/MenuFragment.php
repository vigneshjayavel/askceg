<div class="navbar navbar-fixed-top">
   <div class="navbar-inner">
     <div class="container">
       <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
       </a>
       <a class="brand" href="<?php echo base_url() ?>HomeController">
        AskCEG</a>
       <div class="nav-collapse" id="main-menu">
<form class="navbar-search pull-left" action="">

  <input type="text" id="ajaxSearchPanel" autocomplete="off"
   class="typeahead search-query span8" placeholder="Search for Questions, Categories, Topics and CEGians" data-provide="typeahead" data-items="4" >
</form>
<div id="notificationsPanel" style="float:left">
      </div>
<ul class="nav pull-right" id="main-menu-right">
	<li class="dropdown" id="preview-menu">
      <?php if ($this->session->userdata('logged_in') == TRUE)
      {
        $url=$this->session->userdata('profile_pic');
        echo '<a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <img src="'.$url.'" height="10%" width="10%" alt="No pic " class="display-pic" />'
                .$this->session->userdata('user_name');
      }
      else
      {
        echo '<a class="dropdown-toggle" data-toggle="dropdown" href="#">
              login/signup';
      }
      ?>
  <b class="caret"></b>
</a>

<?php
  if($this->session->userdata('logged_in') == TRUE)
  {
  ?>
  <ul class="dropdown-menu">
  
    <li><a href="<?php echo base_url() ?>ProfileController/MyProfile">MyProfile</a></li>
    <li><a href="<?php echo base_url() ?>AuthControllerAsk/destroySession">Logout</a></li>
  </ul>
  <?
  }
  else
  {
  ?>
  <ul class="dropdown-menu">
    <li><a href="#" id="fbLoginStatus">FbConnect</a></li>
    <li><a href="<?php echo base_url() ?>AuthControllerAsk/normallogin">Normal Login/Signup</a></li>
  </ul>
  <?php
  }
  ?>

</li>

 </div>
     </div>
   </div>
 </div>
