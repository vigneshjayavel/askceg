<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>AskCEG</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?php echo base_url()?>assets/css/bootstrap1.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/css/custom11.css" rel="stylesheet">
    
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    
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
    <script src="<?php echo base_url()?>assets/js/myscripts/myReusableGlobalScript1.js"></script>
    <script src="<?php echo base_url()?>assets/js/login.js"></script>
    <!--flatui-->
    <link href="<?php echo base_url()?>assets/flatui/css/flat-ui...css" rel="stylesheet">
    <script src="<?php echo base_url()?>assets/flatui/js/jquery-1.8.2.min.js"></script>
    <script src="<?php echo base_url()?>assets/flatui/js/jquery-ui-1.10.0.custom.min.js"></script>
    <script src="<?php echo base_url()?>assets/flatui/js/jquery.dropkick-1.0.0.js"></script>
    <script src="<?php echo base_url()?>assets/flatui/js/custom_checkbox_and_radio.js"></script>
    <script src="<?php echo base_url()?>assets/flatui/js/custom_radio.js"></script>
    <script src="<?php echo base_url()?>assets/flatui/js/jquery.tagsinput.js"></script>
    <script src="<?php echo base_url()?>assets/flatui/js/bootstrap-tooltip.js"></script>
    <script src="<?php echo base_url()?>assets/flatui/js/jquery.placeholder.js"></script>
    <script src="<?php echo base_url()?>assets/flatui/js/application.js"></script>

    <style type="text/css" id="page-css">
      /* Styles specific to this particular page */
      .scroll-pane
      {
        width: 100%;
        height: 450px;
        overflow: auto;
      }
      
    </style>
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
    <script type="text/javascript">
      $(document).ready(function(){

        //activate tooltips
        $('[rel~=popover]').popover();
        $("[rel~=tooltip],[disabled=true]").tooltip();


      });
    </script>
  </head>

  <body>

    <--?php include "MenuFragment.php"; ?-->
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <div id="left" class="well" style="min-height:400px">
            <h1>Ticker</h1>
          </div><!--/left-->
        </div><!--/span-->
        <div class="span6">
            <!--dynamic content in center div-->
            <div id="center" class="well">
              <div>
                <div class="todo mrm">
            
            <ul>
              <li class="todo-done">
                <div class="todo-content">
                  <h4 class="todo-name">
                    Vishnu posted a question at NSO
                  </h4>
                  <span class="fui-time-16"></span>4 minutes ago
                </div>
              </li>

              <li class="todo-done">
                <div class="todo-content">
                  <h4 class="todo-name">
                    <strong>Bala</strong> followed you
                  </h4>
                  <span class="fui-time-16"></span>10 mins ago
                </div>
              </li>

              <li>
                <div class="todo-content">
                  <h4 class="todo-name">
                    Narain joined <strong>CTF</strong>
                  </h4>
                  <span class="fui-time-16"></span>10 mins ago
                </div>
              </li>

              <li class="">
                <div class="todo-content">
                  <h4 class="todo-name">
                    Shibu answered your question <stron>Why is Shibu lazy?</strong>
                  </h4>
                  <span class="fui-time-16"></span>10 mins ago
                </div>
              </li>
            </ul>
          </div>

              </div>

              <!--custom markup-->
              <div class="notificationsWrapper">
                <div class="notificationsDiv">
                  <ul class="nav nav-list bs-docs-sidenav affix-top">
                    <li class="unread"><a href="#typography"><i class="icon-info-sign"></i> Typography</a></li>
                    <li><a href="#code"><i class="icon-ok"></i> Code</a></li>
                    <li class="unread"><a href="#tables"><i class="icon-info-sign"></i> Tables</a></li>
                    <li><a href="#forms"><i class="icon-ok"></i> Forms</a></li>
                    <li><a href="#buttons"><i class="icon-ok"></i> Buttons</a></li>
                    <li><a href="#images"><i class="icon-ok"></i> Images</a></li>
                    <li><a href="#icons"><i class="icon-ok"></i> Icons by Glyphicons</a></li>
                  </ul>
                </div>
              </div>

            </div><!--/center-->

         </div><!--/span-->
        
        <div class="span3">
          <div id="right" class="well sidebar-nav">
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
