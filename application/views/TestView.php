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
              <div id="searchResultsDiv">
                <center><legend>Search Results</legend></center>
                <div id="searchResultsQuestionsDiv">
                  <legend>Questions Found...</legend>
                  <div id="questionsFoundDiv">
                    <div id="questionPostDiv" class="well" style="background-color:white">
                      <div id="userDetailDiv">
                       <img src="http://localhost/ask/assets/img/2011103089.jpg" height="40px" width="40px" alt="James" class="display-pic">
                       
                      <strong>vishnu</strong>
                        <div style="float:right">
                      <i class="icon-minus-sign"></i>
                      <a href="http://localhost/ask/QuestionsController/unfollowQuestion/1?redirectUrl=http%3A%2F%2Flocalhost%2Fask%2FQuestionsController%2FEducation" rel="tooltip" data-placement="bottom" data-original-title="Click to unfollow the question!">Unfollow</a></div>
                      </div>
                      <div id="questionDetailsDiv">
                        <p id="questionContent">
                        <strong><a class="question" id="1" href="http://localhost/ask/AnswersController/viewAnswersForQuestion/1">HFFVHVNVVV</a>
                        </strong>
                        </p>
                        <p id="questionDescription"><span>HNBVNV</span></p>
                      </div><!--/questionDetailsDiv-->
                      <div id="questionExtraDetailsDiv">    
                        <a data-original-title="Category" href="http://localhost/ask/QuestionsController/viewQuestion/1" class="label label-warning">education
                        </a>
                        <i class="icon-arrow-right"></i>
                        <a data-original-title="Topic" href="#" class="label label-info">computer
                        </a>
                        <p>      </p>
                      </div><!--/questionExtraDetailsDiv-->
                      <div id="questionStatsDiv">
                        <i class="icon-time"></i>
                        <a>10:47 pm 02 Dec-12 </a>
                        <i class="icon-comment"></i>
                        <a rel="tooltip popover" href="#" data-placement="bottom" data-original-title="Quick answer!" data-content="&lt;textarea placeholder=&quot;Enter answer here..&quot;&gt;&lt;/textarea&gt;&lt;br/&gt;
                                        &lt;button class=&quot;postAnswerButton btn btn-success pull-right&quot;&gt;
                                        &lt;i class=&quot;icon-share-alt icon-white&quot;&gt;&lt;/i&gt;
                                        Answer!&lt;/button&gt;">
                          5 Answers
                        </a>
                        <i class="icon-eye-open"></i>
                        <a>27 Views</a>
                        <i class="icon-user"></i>
                        <a rel="tooltip" data-placement="bottom" data-original-title="vishnu&lt;/br&gt;also follow this..">
                        1
                        Followers</a>
                      <div style="float:right">
                        FLike,Tweet                    
                        </div>
                      </div><!--/questionStatsDiv-->
                  
                    </div><!--/questionPostDiv-->
                    <div id="questionPostDiv" class="well" style="background-color:white">
                      <div id="userDetailDiv">
                       <img src="http://localhost/ask/assets/img/2011103089.jpg" height="40px" width="40px" alt="James" class="display-pic">
                       
                      <strong>vishnu</strong>
                        <div style="float:right">
                      <i class="icon-minus-sign"></i>
                      <a href="http://localhost/ask/QuestionsController/unfollowQuestion/1?redirectUrl=http%3A%2F%2Flocalhost%2Fask%2FQuestionsController%2FEducation" rel="tooltip" data-placement="bottom" data-original-title="Click to unfollow the question!">Unfollow</a></div>
                      </div>
                      <div id="questionDetailsDiv">
                        <p id="questionContent">
                        <strong><a class="question" id="1" href="http://localhost/ask/AnswersController/viewAnswersForQuestion/1">HFFVHVNVVV</a>
                        </strong>
                        </p>
                        <p id="questionDescription"><span>HNBVNV</span></p>
                      </div><!--/questionDetailsDiv-->
                      <div id="questionExtraDetailsDiv">    
                        <a data-original-title="Category" href="http://localhost/ask/QuestionsController/viewQuestion/1" class="label label-warning">education
                        </a>
                        <i class="icon-arrow-right"></i>
                        <a data-original-title="Topic" href="#" class="label label-info">computer
                        </a>
                        <p>      </p>
                      </div><!--/questionExtraDetailsDiv-->
                      <div id="questionStatsDiv">
                        <i class="icon-time"></i>
                        <a>10:47 pm 02 Dec-12 </a>
                        <i class="icon-comment"></i>
                        <a rel="tooltip popover" href="#" data-placement="bottom" data-original-title="Quick answer!" data-content="&lt;textarea placeholder=&quot;Enter answer here..&quot;&gt;&lt;/textarea&gt;&lt;br/&gt;
                                        &lt;button class=&quot;postAnswerButton btn btn-success pull-right&quot;&gt;
                                        &lt;i class=&quot;icon-share-alt icon-white&quot;&gt;&lt;/i&gt;
                                        Answer!&lt;/button&gt;">
                          5 Answers
                        </a>
                        <i class="icon-eye-open"></i>
                        <a>27 Views</a>
                        <i class="icon-user"></i>
                        <a rel="tooltip" data-placement="bottom" data-original-title="vishnu&lt;/br&gt;also follow this..">
                        1
                        Followers</a>
                      <div style="float:right">
                        FLike,Tweet                    
                        </div>
                      </div><!--/questionStatsDiv-->
                  
                    </div><!--/questionPostDiv-->
                    <div id="questionPostDiv" class="well" style="background-color:white">
                      <div id="userDetailDiv">
                       <img src="http://localhost/ask/assets/img/2011103089.jpg" height="40px" width="40px" alt="James" class="display-pic">
                       
                      <strong>vishnu</strong>
                        <div style="float:right">
                      <i class="icon-minus-sign"></i>
                      <a href="http://localhost/ask/QuestionsController/unfollowQuestion/1?redirectUrl=http%3A%2F%2Flocalhost%2Fask%2FQuestionsController%2FEducation" rel="tooltip" data-placement="bottom" data-original-title="Click to unfollow the question!">Unfollow</a></div>
                      </div>
                      <div id="questionDetailsDiv">
                        <p id="questionContent">
                        <strong><a class="question" id="1" href="http://localhost/ask/AnswersController/viewAnswersForQuestion/1">HFFVHVNVVV</a>
                        </strong>
                        </p>
                        <p id="questionDescription"><span>HNBVNV</span></p>
                      </div><!--/questionDetailsDiv-->
                      <div id="questionExtraDetailsDiv">    
                        <a data-original-title="Category" href="http://localhost/ask/QuestionsController/viewQuestion/1" class="label label-warning">education
                        </a>
                        <i class="icon-arrow-right"></i>
                        <a data-original-title="Topic" href="#" class="label label-info">computer
                        </a>
                        <p>      </p>
                      </div><!--/questionExtraDetailsDiv-->
                      <div id="questionStatsDiv">
                        <i class="icon-time"></i>
                        <a>10:47 pm 02 Dec-12 </a>
                        <i class="icon-comment"></i>
                        <a rel="tooltip popover" href="#" data-placement="bottom" data-original-title="Quick answer!" data-content="&lt;textarea placeholder=&quot;Enter answer here..&quot;&gt;&lt;/textarea&gt;&lt;br/&gt;
                                        &lt;button class=&quot;postAnswerButton btn btn-success pull-right&quot;&gt;
                                        &lt;i class=&quot;icon-share-alt icon-white&quot;&gt;&lt;/i&gt;
                                        Answer!&lt;/button&gt;">
                          5 Answers
                        </a>
                        <i class="icon-eye-open"></i>
                        <a>27 Views</a>
                        <i class="icon-user"></i>
                        <a rel="tooltip" data-placement="bottom" data-original-title="vishnu&lt;/br&gt;also follow this..">
                        1
                        Followers</a>
                      <div style="float:right">
                        FLike,Tweet                    
                        </div>
                      </div><!--/questionStatsDiv-->
                  
                    </div><!--/questionPostDiv-->
                    <div id="questionPostDiv" class="well" style="background-color:white">
                      <div id="userDetailDiv">
                       <img src="http://localhost/ask/assets/img/2011103089.jpg" height="40px" width="40px" alt="James" class="display-pic">
                       
                      <strong>vishnu</strong>
                        <div style="float:right">
                      <i class="icon-minus-sign"></i>
                      <a href="http://localhost/ask/QuestionsController/unfollowQuestion/1?redirectUrl=http%3A%2F%2Flocalhost%2Fask%2FQuestionsController%2FEducation" rel="tooltip" data-placement="bottom" data-original-title="Click to unfollow the question!">Unfollow</a></div>
                      </div>
                      <div id="questionDetailsDiv">
                        <p id="questionContent">
                        <strong><a class="question" id="1" href="http://localhost/ask/AnswersController/viewAnswersForQuestion/1">HFFVHVNVVV</a>
                        </strong>
                        </p>
                        <p id="questionDescription"><span>HNBVNV</span></p>
                      </div><!--/questionDetailsDiv-->
                      <div id="questionExtraDetailsDiv">    
                        <a data-original-title="Category" href="http://localhost/ask/QuestionsController/viewQuestion/1" class="label label-warning">education
                        </a>
                        <i class="icon-arrow-right"></i>
                        <a data-original-title="Topic" href="#" class="label label-info">computer
                        </a>
                        <p>      </p>
                      </div><!--/questionExtraDetailsDiv-->
                      <div id="questionStatsDiv">
                        <i class="icon-time"></i>
                        <a>10:47 pm 02 Dec-12 </a>
                        <i class="icon-comment"></i>
                        <a rel="tooltip popover" href="#" data-placement="bottom" data-original-title="Quick answer!" data-content="&lt;textarea placeholder=&quot;Enter answer here..&quot;&gt;&lt;/textarea&gt;&lt;br/&gt;
                                        &lt;button class=&quot;postAnswerButton btn btn-success pull-right&quot;&gt;
                                        &lt;i class=&quot;icon-share-alt icon-white&quot;&gt;&lt;/i&gt;
                                        Answer!&lt;/button&gt;">
                          5 Answers
                        </a>
                        <i class="icon-eye-open"></i>
                        <a>27 Views</a>
                        <i class="icon-user"></i>
                        <a rel="tooltip" data-placement="bottom" data-original-title="vishnu&lt;/br&gt;also follow this..">
                        1
                        Followers</a>
                      <div style="float:right">
                        FLike,Tweet                    
                        </div>
                      </div><!--/questionStatsDiv-->
                  
                    </div><!--/questionPostDiv-->
                  </div><!--/questionsFoundDiv-->
                </div><!--/searchResultsQuestionsDiv-->
                <div id="searchResultsTopicsDiv">
                  <legend>Topics Found...</legend>
                  <div id="topicsFoundDiv">
                    <a data-original-title="Topic" href="#" class="label label-info">computer</a></br>
                    <a data-original-title="Topic" href="#" class="label label-info">computer</a></br>
                    <a data-original-title="Topic" href="#" class="label label-info">computer</a></br>
                  </div><!--/topicsFoundDiv-->
                </div><!--/searchResultsTopicsDiv-->
              </div><!--/searchResultsDiv-->
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
