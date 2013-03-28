<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
 <span class="icon-bar"></span>
 <span class="icon-bar"></span>

            </a>
            <a class="brand" href="<?php echo base_url(); ?>HomeController">AskCEG</a>
            <div class="nav-collapse" id="main-menu">
                <form class="navbar-search pull-left" action="">
                    <input type="text" id="ajaxSearchPanel" autocomplete="off" 
                    class="typeahead search-query span8"
                    placeholder="Search for Questions, Categories, Topics and CEGians" 
                    data-provide="typeahead" data-items="6">
                </form>
                <div id="notificationsPanel" style="float:left"></div>
                <ul class="nav pull-right" id="main-menu-right">
                    <li class="dropdown" id="preview-menu">
                        <?php 
                        if ($this->session->userdata('logged_in') == TRUE) { 
                          $url = $this->session->userdata('profile_pic'); 
                          echo '
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                          <span id="profilePicSpan"><img src="' . $url . '" height="25" width="25" alt="No pic " class="display-pic" /></span>
                          <span id="userNameSpan">'. $this->session->userdata('user_name').'</span>'; 
                        } 
                        else { 
                          echo '
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">login/signup'; 

                        } ?> 
                        <b class="caret"></b>
                        </a>
                        <?php 
                        if ($this->session->userdata('logged_in') == TRUE) { ?>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo base_url(); ?>ProfileController/MyProfile">MyProfile</a>
                                </li>
                                <li>
                                <?php
                                  if($this->session->userdata('isNormalAccount')==1){
                                    echo '<a href="'.base_url().'AuthControllerAsk/destroySession">Logout</a>';
                                  }
                                  else{
                                    echo '<a href="#" class="fbLoginStatus"><img src="'.base_url().'"assets/img/btns/fbLogout.png></a>';
                                  }
                                ?>
                                    
                                </li>
                            </ul>
                            <? } 
                            else { ?>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#" class="fbLoginStatus">FbConnect</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>AuthControllerAsk/normallogin">Normal Login/Signup</a>
                                </li>
                            </ul>
                            <?php } ?>
                    </li>
                  </ul>
            </div>
        </div>
    </div>
</div>