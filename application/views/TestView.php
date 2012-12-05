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
      $(document).ready(function(){

        //activate tooltips
        $('[rel~=popover]').popover();
        $("[rel~=tooltip],[disabled=true]").tooltip();


      });
    </script>
  </head>

  <body>

    <?php include "MenuFragment.php"; ?>
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
              <div id="scrollableContentDiv" class="scroll-pane">
              <?php

                for($i=0;$i<10;$i++){

              ?>
                <div id="questionPostDiv" class="well" style="background-color:white">
                  <div id="questionDetailsDiv">
                    <p><strong>Question Content</strong></p>
                    <p><span>Question description...</span></p>
                  </div><!--/questionDetailsDiv-->
                  <div id="questionExtraDetailsDiv">    
                    <a class="label label-warning">Ques Category</a>
                    <i class="icon-arrow-right"></i>
                    <a class="label label-info">Ques Topic</a>
                    <p></p>
                  </div><!--/questionExtraDetailsDiv-->
                  <div id="questionStatsDiv">
                    <i class="icon-time"></i>
                    <a>Date, Time</a>
                    <i class="icon-comment"></i>
                    <a rel="tooltip popover" data-placement="bottom" data-original-title="Click to answer!" 
                      href="#" 
                      data-content="<textarea placeholder='Enter answer here..'></textarea><br/>
                                    <button class='btn btn-success'><i class='icon-share-alt icon-white'></i>Answer!</button> " 
                      data-original-title="Post Answer"
                      data-placement="bottom">
                      Answers
                    </a>
                    <i class="icon-eye-open"></i>
                    <a >Views</a>
                    <i class="icon-user"></i>
                    <a href="#" rel="tooltip" data-placement="bottom" data-original-title="Click to follow this question!">Followers</a>
                    
                    <div style="float:right">
                    FLike,Tweet,Share buttons                    
                    </div>
                  </div><!--/questionStatsDiv-->
                  
                </div><!--/questionPostDiv-->
              <?php
                }
              ?>           

              </div><!--/scrollpane-->
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
