<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>AskCEG</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?php echo base_url()?>assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      .popover {
        width: 400px;
      }
      textarea {
        width: 360px;
      }
    </style>
    <link href="<?php echo base_url()?>assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo base_url()?>assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url()?>assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url()?>assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url()?>assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url()?>assets/ico/apple-touch-icon-57-precomposed.png">
    <script src="<?php echo base_url()?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap.js"></script>
    <script src="<?php echo base_url()?>assets/js/myscripts/myReusableGlobalScript.js"></script>
      
    <script src="<?php echo base_url()?>assets/js/underscore.js"></script>
    <script src="<?php echo base_url()?>assets/js/backbone.js"></script>
    
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
          'user_name':"<?php echo $CI->session->userdata('user_name'); ?>"
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
    
    <!--style type="text/css" id="page-css">
      /* Styles specific to this particular page */
      .scroll-pane
      {
        width: 100%;
        height: 450px;
        overflow: auto;
      }
      
    </style-->
   
  </head>

  <body>
    <div class="background-holder"></div>
    <div id="alertBox" style="display:none; padding-top: 60px;">
      <div class="alertMessage">
          Some Msg!!
      </div>
    </div>
    <?php include "MenuFragment.php"; ?>
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <div id="left" class="well" style="min-height:648px">
            <h3>Trending Questions</h3>
          </div><!--/left-->
        </div><!--/span-->
        <div class="span6">
            <div id="progressbar"style="min-height:400px;text-align:center" class="progress progress-striped active">
              
                <div class="bar" style="width:38%;margin-left:30%;margin-top:5%"></div></br>
                Loading..
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

      <hr>

      <footer>
        <?php include "FooterFragment.php"; ?>
      </footer>

    </div><!--/.fluid-container-->


  </body>
</html>
