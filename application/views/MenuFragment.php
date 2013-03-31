<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> 
            <span class="icon-bar"></span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>

            </a>
            <a class="brand" href="<?php echo base_url(); ?>HomeController">AskCEG</a>
            <div class="nav-collapse" id="main-menu">
                
                <div id="notificationsPanel" style="float:left"></div>
                <ul class="nav pull-right" id="main-menu-right">
                    <form class="navbar-search pull-left" action="">
                        <input type="text" id="ajaxSearchPanel" autocomplete="off" 
                        class="typeahead search-query span8"
                        placeholder="Search for Questions, Posts, Topics and CEGians" 
                        data-provide="typeahead" data-items="6">
                    </form>
                    <li>
                        <a href="#" onclick="alert('coming soon!');">
                            <span class="navbar-unread">5</span>Notifications
                        </a>
                    <li style="border-left: 1px solid #4d68a7;border-right: 1px solid #4d68a7;" class="dropdown" id="preview-menu">
                        <?php 
                        if ($this->session->userdata('logged_in') == TRUE) { 
                          $url = $this->session->userdata('profile_pic'); 
                          echo '
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                          <span id="profilePicSpan"><img src="' . $url . '" height="25" width="25" alt="No pic " class="display-pic" /></span>
                          '; 
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
                                     
                                    <span class="pull-right" id="userNameSpan">Logged in as <?php echo $this->session->userdata('user_name')?> !&nbsp;&nbsp;</span>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>ProfileController/MyProfile">MyProfile</a>
                                </li>
                                <li>
                                <?php
                                  if($this->session->userdata('isNormalAccount')==1){
                                    echo '<a href="'.base_url().'AuthControllerAsk/destroySession">Logout</a>';
                                  }
                                  else{
                                    echo '<a href="#" class="fbLoginStatus"><img src="'.base_url().'assets/img/btns/fbLogout.png"></a>';
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
                    <li>
                        <a href="<?php echo base_url();?>home"><i class="icon-white icon-info-sign"></i></a>
                    </li>
                  </ul>
            </div>
        </div>
    </div>
</div>