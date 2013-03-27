    <script type="text/javascript">
    <!--
        var CI = {
          'base_url': '<?php echo base_url(); ?>'
        };
    -->
    </script>
        <script type="text/javascript">
    <!--
        var FBConfig = {
          'appId': '<?php echo FB_APPID; ?>'
        };
    -->
    </script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.js"></script>

<link rel="shortcut icon" href="../favicon.ico"> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/LoginFormAssets/css/demo.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/LoginFormAssets/css/style2.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/LoginFormAssets/css/animate-custom.css" />
<div class="container">
    <section>				
        <div id="container_demo" >
           
            <a class="hiddenanchor" id="toregister"></a>
            <a class="hiddenanchor" id="tologin"></a>
            <div id="wrapper">
                <div id="login" class="animate form">

                    <?php if(!isset($normalSignup) && !isset($normalLogin))
                    { 
                    ?>
                    <form id="updateform" method="post"  action="<?php echo base_url();?>AuthControllerAsk/updateProfile" autocomplete="on"> 
                        <h1> AskCEG - Update Profile </h1> 
                        <p> 
                            <label for="name"  >Your Fullname</label>
                            <input id="name" name="name" placeholder="John Doe.." required="required" type="text"/> 
                        </p>
                        <p> 
                            <label for="degree"  > Degree</label>
                            <input id="degree" name="degree" required="required" placeholder="B.E,M.E,.." type="text"/> 
                        </p>
                        <p> 
                            <label for="course"  > Programme/Course</label>
                            <input id="course" name="course" required="required" placeholder="Mechanical Engineering, Industrial Engineering,.." type="text"/> 
                        </p>
                        <p class="signin button"> 
                            <input type="submit" value="Update Details!"/> 
                        </p>
                        
                    </form>   
                    <?php 
                    }
                    else if(isset($normalSignup)){
                    ?>
                    <form method="post" id="signupform" action="<?php echo base_url();?>AuthControllerAsk/createNormalProfile" autocomplete="on"> 
                        <h1> AskCEG - Normal Signup </h1> 
                        <p> 
                            <label for="name"  >Your Fullname</label>
                            <input id="name" name="name" placeholder="John Doe.." required="required" type="text"/> 
                        </p>
                        <p> 
                            <label for="degree"  > Degree</label>
                            <input id="degree" name="degree" required="required" placeholder="B.E,M.E,.." type="text"/> 
                        </p>
                        <p> 
                            <label for="course"  > Programme/Course</label>
                            <input id="course" name="course" required="required" placeholder="Mechanical Engineering, Industrial Engineering,.." type="text"/> 
                        </p>
                        <p> 
                            <label for="email"  >email</label>
                            <input id="email" name="email" required="required" placeholder="johndoe@mail.com,.." type="email"/> 
                        </p>
                        <p> 
                            <label for="pass"  >Password</label>
                            <input id="pass" name="pass" required="required" placeholder="******" type="password"/> 
                        </p>

                        <p>
                            <!--recaptcha-->
                            <?php 
                                echo $recaptchaMarkup;
                            ?>
                        </p>
                        
                        <p class="signin button"> 
                            <input type="submit" value="Signup!"/> 
                        </p>
                        
                    </form>   
                    <?php
                    }
                    else if(isset($normalLogin)){
                    ?>
                        <form method="post" id="signinform" 
                            action="<?php echo base_url();?>AuthControllerAsk/processNormalLogin" autocomplete="on"> 
                            <h1> AskCEG - Normal Login</h1> 
                            <p> 
                                <label for="email"  >email</label>
                                <input id="email" name="email" required="required" placeholder="johndoe@mail.com,.." type="email"/> 
                            </p>
                            <p> 
                                <label for="pass"  >Password</label>
                                <input id="pass" name="pass" required="required" placeholder="******" type="password"/> 
                            </p>

                            <p class="signin button"> 
                                <input type="submit" value="Login!"/> 
                            </p>
                            <p class="signin button">
                            <a href="<?php base_url()?>normalsignup" >
                                <input type="button" value="New User Signup!"/> 
                            </a>
                            </p>
                            
                        </form>   
                    <?php
                    }
                    ?>
                </div>

                
            </div>
        </div>  
    </section>
</div>