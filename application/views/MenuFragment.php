<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> 
            <span class="icon-bar"></span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>

            </a>
            <a class="brand" href="<?php echo base_url(); ?>HomeController"><img height="45" width="120" src="<?php echo base_url();?>assets/img/asklogo1.png" /></a>
            <div class="nav-collapse" id="main-menu">
                
                <div id="notificationsPanel" style="float:left"></div>
                <ul class="nav pull-right" id="main-menu-right">
                    <form class="navbar-search pull-left" action="">
                        <input type="text" id="ajaxSearchPanel" autocomplete="off" 
                        class="typeahead search-query span8"
                        placeholder="Search for Questions, Posts, Topics and CEGians" 
                        data-provide="typeahead" data-items="6">
                    </form>
                    <li style="border-right: 1px solid #4d68a7;">
                        <a href="<?php echo base_url() ?>HomeController"><i class="icon-white icon-home"></i></a>
                    </li>
                    <li style="border-right: 1px solid #4d68a7;">
                        <a href="#" onclick="alert('coming soon!');">
                            <span class="navbar-unread">5</span><i class="icon-white icon-exclamation-sign"></i> &nbsp;Notifications
                        </a>
                    <li style="border-right: 1px solid #4d68a7;" class="dropdown" id="preview-menu">
                        <?php 
                        if ($this->session->userdata('logged_in') == TRUE) { 
                          $url = $this->session->userdata('profile_pic'); 
                          echo '
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                          <span id="profilePicSpan"><img src="' . $url . '" height="20" width="20" alt="No pic " class="display-pic" /></span>
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
                                     
                                    <span class="pull-right" id="userNameSpan"><i class="icon-user"></i>&nbsp;Logged in as <?php echo $this->session->userdata('user_name')?> !&nbsp;&nbsp;</span>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>ProfileController/MyProfile"><i class="icon-wrench"></i>&nbsp; My Profile</a>
                                </li>
                                <li>
                                <?php
                                    echo '<a href="'.base_url().'AuthControllerAsk/destroySession"><i class="icon-off"></i>&nbsp; Logout</a>';
                                 
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
                        <a href="<?php echo base_url() ?>QuestionsController/AskQuestion"><i class="icon-white icon-pencil"></i></a>
                    </li>
                  </ul>
            </div>
        </div>
    </div>
</div>