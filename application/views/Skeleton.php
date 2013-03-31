<!DOCTYPE html>
<html lang="en">
  <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# askcegbeta: http://ogp.me/ns/fb/askcegbeta#">
    <meta charset="utf-8">
    <title>AskCEG beta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="AskCEG - an exclusive question and answer platform for CEGians">
    <meta name="author" content="Vignesh Jayavel">
    <meta name="keywords" content="askceg,ceg,ceg questions,ceg forum,ctf,ceg tech forum,anna university forum, anna university chennai">
    <?php 
      if(isset($metaContent))
        echo $metaContent;
    ?>
    <meta property="fb:app_id" content="314511855323893" /> 
  
    <!-- Le styles -->
    <link href="<?php echo base_url()?>assets/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/css/custom1.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }


      textarea {
        width: 360px;
      }

      .scrollup{
          width:40px;
          height:40px;
          opacity:0.3;
          position:fixed;
          bottom:50px;
          right:100px;
          display:none;
          text-indent:-9999px;
          background: url("<?php echo base_url();?>assets/img/icon_top.png") no-repeat;
      }


    </style>
    
    <link href="<?php echo base_url()?>assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo base_url()?>assets/ico/fbthumb.jpg">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url()?>assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url()?>assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url()?>assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url()?>assets/ico/apple-touch-icon-57-precomposed.png">
    <script src="<?php echo base_url()?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap.js"></script>

    <script src="<?php echo base_url()?>assets/js/myscripts/myReusableGlobalScript1.js"></script>
      
    <script src="<?php echo base_url()?>assets/js/underscore.js"></script>
    <script src="<?php echo base_url()?>assets/js/backbone.js"></script>
    <!--rich text editor-->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/redactor-editor/redactor.css" />
    <script src="<?php echo base_url()?>assets/redactor-editor/redactor.min.js"></script>
    
    <script type="text/javascript">
    <!--
        var CI = {
          'base_url': '<?php echo base_url(); ?>'
        };
    -->
    </script>

    <script type="text/javascript">
    <!--
        var userData = {
          'user_id': "<?php $CI =& get_instance(); echo $CI->session->userdata('user_id'); ?>",
          'user_name':"<?php echo $CI->session->userdata('user_name'); ?>",
          'profile_pic':"<?php echo $CI->session->userdata('profile_pic'); ?>"

        };
        var pagination = {
          'required': "<?php if(isset($paginationrequired)) echo $paginationrequired; ?>",
          'type' : "<?php if(isset($paginationtype)) echo $paginationtype; ?>",
          'groupScope' : "<?php if(isset($groupScope)) echo $groupScope; ?>",
          'questionId' : "<?php if(isset($questionId)) echo $questionId; ?>",
          'categoryId' : "<?php if(isset($categoryId)) echo $categoryId; ?>",
          'topicUrl' : "<?php if(isset($topicUrl)) echo $topicUrl; ?>"

          
        }

        var FBConfig = {
          'appId': '<?php echo FB_APPID; ?>'
        };
    -->
    </script>
        
    <?php 
      if(isset($page)){
    ?>
    <script src="<?php echo base_url()?>assets/js/myscripts/<?php echo $page?>Script.js"></script>
   
    
    <?php
      }
    ?>

    <?php 
      $CI = &get_instance();
      if($CI->session->userdata('isProfileComplete')==0){
    ?>
      <script type="text/javascript" src="<?php echo base_url()?>assets/js/login.js"></script>
    <?php
      }
    ?>
    <!--style type="text/css" id="page-css">codeignitor
      /* Styles specific to this particular page */
      .scroll-pane
      {
        width: 100%;
        height: 450px;
        overflow: auto;
      }
      
    </style-->
   
  </head>

  <body data-spy="scroll" data-target=".subnav" data-offset="80">
    <a href="#" class="scrollup">Scroll</a>
    <div class="background-holder"></div>
    <div id="alertBox" style="display:none; padding-top: 58px;">
      <div class="alertMessage">
          Some Msg!!
      </div>
    </div>
    <?php include "MenuFragment.php"; ?>
    <div class="container-fluid" >
      <div id="main" class="row-fluid">
        <div class="span7">
            <div id="progressbar"style="min-height:400px;text-align:center" class="progress progress-striped active">
              <div class="loadGfx" style="margin-top:30%;margin-left:50%;width:25px;height:25px">
                <img src="<?php echo base_url();?>assets/img/mini-loader.gif" />
              </div>
            </div>
            <!--dynamic content in center div-->
            <div id="center" class="well-container" style="display:none;">
              <div id="scrollableContentDiv" class="scroll-pane">
                    
                <?php 
                 echo $centerContent; ?>
              </div><!--/scrollpane-->
            </div><!--/center-->

         </div><!--/span-->
        
        <div class="span3">
          <div id="right" class="affix">
           <?php include "SidebarFragment.php"; ?>
          </div><!--/right -->
        </div><!--/span-->
        
      </div><!--/row-->


    </div><!--/.fluid-container-->

  </body>
  <script>
    $(document).ready(function(){

      //prevent scroll when a is clicked
      $('body').on('click','a[href=#]', function(e) {
         e.preventDefault();
         console.log('clicked');
      });

    });
  </script>
  <?php if(ENVIRONMENT!='local'){ ?>
  <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-39689726-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

  <link href='http://fonts.googleapis.com/css?family=Telex' rel='stylesheet' type='text/css'>
  <?php }

  if(!$CI->session->userdata('logged_in')){

  ?>
  <div class="modal hide fade in" id="registerModal" style="">
    <div class="modal-header">
      <center>
        <h3>
        Oops you need to be logged in!!
        </h3>
      </center>
    </div>
    <div class="modal-body">
      <div class="row-fluid">
        <div class="span12">
          <div class="span3">
            <img height="125" width="125" src="<?php echo base_url();?>assets/img/fbthumb.jpg" />
          </div>
          <div class="span9">
            <p>
              AskCEG is just one away.. Join us via facebook
              <span id="regStatusHolder">
                <a href="#" class="fbLoginStatus"><img src="<?php echo base_url(); ?>assets/img/btns/fbLoginRegister.png"></a>
              </span>
            </p> 
            <p>
              <form method="post"  action="<?php echo base_url();?>AuthControllerAsk/processNormalLogin" autocomplete="on">
                <input type="text" id="email" name="email" placeholder="Email">
                <input type="password" id="pass" name="pass" placeholder="Password">
                <input class="btn" type="submit" value="Login!"/>
              </form>

            </p>  
              
            
            
            <small>
          (If you don't have a facebook account, 
          <a href="<?php echo base_url(); ?>AuthControllerAsk/normalSignup">
            sign up using your email!
          </a>
          )
        </small>
          </div>
    </div>
  </div>
  <hr>
  
  </div>
  </div>
  <!--/registerModal-->
  <script type="text/javascript">
  $(document).ready(function(){
    $('#registerModal').modal({
      show:true,
      backdrop:'static'
    }).on('hide',function(){
      //on hide reload the current page so that session gets set
          location.reload();    
    });

      
  });


  </script>




  <?php
  }
  ?>

  <script type="text/javascript">
    $(document).ready(function(){ 
 
        $(window).scroll(function(){
            if ($(this).scrollTop() > 100) {
                $('.scrollup').fadeIn();
            } else {
                $('.scrollup').fadeOut();
            }
            console.log('scroll')
        }); 
 
        $('.scrollup').click(function(){
            $("html, body").animate({ scrollTop: 0 }, 600);
            return false;
        });
 
    });
    // Load the SDK Asynchronously
    (function (d) {
        var js, id = 'facebook-jssdk',
            ref = d.getElementsByTagName('script')[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement('script');
        js.id = id;
        js.async = true;
        js.src = "//connect.facebook.net/en_US/all.js";
        ref.parentNode.insertBefore(js, ref);
    }(document));
    </script>


</html>