
function displayNotification(type,msg,redirectUrl){
    /*
    //display an alert msg
    $('<div class="alert alert-block alert-'+type+' fade in">' +
                            '<button type="button" class="close" data-dismiss="alert">x</button>'+
                            '<h4 class="alert-heading">'+msg+'</h4>'+
                        '</div>').hide().prependTo('#center').fadeIn('slow');
    //exec aftr 4s to remove alert 
    setTimeout(function() {   
       $('.alert').slideUp().fadeOut('slow');
       $('#alert').remove();
       if(redirectUrl!=null){
        location.href=redirectUrl;
       }
    }, 4000);
    */
    $('#alertBox .alertMessage').html('<span>'+msg+'</span>');
    $('#alertBox').fadeIn('slow');
    setTimeout(function() {   
       $('#alertBox').fadeOut('slow');
       if(redirectUrl!=null){
        location.href=redirectUrl;
       }
    }, 3000);
}

$(window).load(function(){

	$('#progressbar').hide();
	$('#center').fadeIn(2);

});

$(document).ready(function(){

    //TODO 
    //deactivated as it is very distracting during dev time
    /*
	$.getJSON(CI.base_url+'HomeController/getTickerContent/'+'questions',
		function(jsonObj){

			$('#left').fadeIn('slow').html(jsonObj.tickerMarkup);
			initializeTicker();

		}
	);
    */

    //askCeg facts
    var facts=new Array();
    facts[0]='You can search using the cool Search Panel right above this message!!!';
    facts[1]='You can share your profile with the your friends!!';
    facts[2]='You can follow your favourite topics!!';
    facts[3]='Posting questions is easy! Just Ask!!';
    facts[4]='"Answer Questions" in the sidebar takes you to the questionsfeed!';
    facts[5]='You can also create posts';
    facts[6]='Is your favourite topic missing? just create it!!';
    facts[7]='Welcome to AskCEG beta version..More features coming soon!!';
    facts[8]='You can vote answers!!';
    facts[9]='You can search using the cool Search Panel right above this message!!!';
    facts[10]='You can search using the cool Search Panel right above this message!!!';
    facts[11]='You can search using the cool Search Panel right above this message!!!';
    var min = 0;
    var max = 11;
    var rand=Math.floor(Math.random() * (max - min + 1) + min)
    
    displayNotification('success','<i class="icon-info-sign icon-white"></i> ' + facts[rand]);

    //img upload
    $('#photoimg').live('change', function()            { 
        $("#preview").html('');
        $("#preview").html('<img src="loader.gif" alt="Uploading...."/>');
        $("#imageform").ajaxForm({
                target: '#preview'
        }).submit();
    });

    //wysiwyg rich text editor
    $('#answerText').redactor();   


	$('.carousel').carousel({
  	interval: 2000
	});

    

    var requiredData,mapped,searchQuery;
    $(".typeahead").typeahead({
        minLength: 4,
        source: function(query, process) {
            searchQuery=query;
            requiredData = [],
            mapped = {}
            $.get(CI.base_url+'SearchController/ajaxSearch', { query: query }, function (data) {
                
                $.each(JSON.parse(data), function (i, item) {
                    mapped[item.resultData] = item;
                    requiredData.push(item.resultData);

                })

                process(requiredData);
            });

            
        },
        updater: function (item) {
            var targetUrl;
            if(mapped[item]!=null){
                targetUrl = mapped[item].resultUrl;
                var dynamicUri = '';
                dynamicUriObj={
                    'Question':'AnswersController/viewAnswersForQuestion/',
                    'Topic':'ProfileController/viewTopic/',
                    'User':'ProfileController/ViewUserProfile/'
                };
                dynamicUri=dynamicUriObj[mapped[item].resultType];
                window.location=CI.base_url+dynamicUri+targetUrl;
            }
            else{
                targetUrl='SearchController/search/'+searchQuery;
                window.location=CI.base_url+targetUrl;
            }
            console.log('url : '+url);
            //document.location = "AjaxSearchController/getData?q=" + encodeURIComponent(item);
            return item;
        },
        sorter: function (items) {
            items.unshift(this.query);
            return items;
        },
        items:11,
        menu: '<ul id="ajaxSearchDropdown" style="margin-left:0px;font-size:16px;left:0px !important;width:100%" class="span12 dropdown-menu"></ul>', //to stretch the box
        
        //display the result type by concatenating either "question/topic" to search keyword
        //TODO: strip search term if the length is too long 
        highlighter: function (item) {

            var result = mapped[item];
            
            if(result!=undefined){
                var query = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&');

                var highlighted_label = item.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
                  return '<strong>' + match + '</strong>'
                });
                //append the type of the search result 
                var view_label = highlighted_label + 
                    ' : [' + result.resultType + ']';            
                return view_label;
            }
            else{
                var regex = new RegExp( '(' + this.query + ')', 'gi' );
                return 'Search : '+item.replace( regex, "<strong>$1</strong>" );
            }
                
            
        }
    });
 


});

function initializeTicker() {

    var timeID = 0;


    if ($("div.text > div")
        .length > 0) {
        $("div.text > div")
            .css("display", "none");
        $("div.text > div:first")
            .fadeIn(2000)
            .css("display", "block")
            .addClass("nowShowing");
        timeID = setInterval('textRotate()', 2000);
    }

    $("div.text")
        .mouseenter(function () {
        clearInterval(timeID);
    });

    $("div.text")
        .mouseleave(function () {
        timeID = setInterval('textRotate()', 2000);
    });



}

function textRotate() {


    var items = $("div.text > .nowShowing");

    if (items.length < 6) {

        if ($("div.text > .nowShowing:last")
            .next()
            .length > 0) {

            items.next()
                .fadeIn(2000)
                .css("display", "block")
                .addClass("nowShowing");
        } else {

            $("div.text > div.nowShowing")
                .each(function () {
                $(this)
                    .slideUp("2000")
                    .removeClass("nowShowing");
            });

            $("div.text > div:first")
                .fadeIn(2000)
                .css("display", "block")
                .addClass("nowShowing");
        }


    } else {

        $("div.text > div.nowShowing:first")
            .slideUp("2000")
            .removeClass("nowShowing");

    }

}

//TODO
$(document).ready(function(){
    if(required=="true")
    $('#scrollableContentDiv').append('');
    $(window).scroll(function () {
        if ($(window).scrollTop() == ($(document).height() - $(window).height())) {
            if(required=="true")
                triggerDataLoad();
        }
    });
    $('input#loadMoreQs').on('click',function(){
       triggerDataLoad();
         
    });
    var endOfRecords=false;
    var set=1;
    var required,categoryId,topicUrl,questionUrl;
    required=pagination.required;
    if(pagination.categoryId!="")
        categoryId=pagination.categoryId;
    else
        categoryId=null;
    if(pagination.topicUrl!="")
        topicUrl=pagination.topicUrl;
    else
        topicUrl=null;
   if(pagination.questionUrl!="")
        questionUrl=pagination.questionUrl;
   else
        questionUrl=null;
    if(pagination.groupScope!="")
        groupScope=pagination.groupScope;
    else
        groupScope=null;

    function triggerDataLoad() {


        if(!endOfRecords){
            displayNotification('warning','<div id="paginationLoadingGfx"><center><img height=20 width=20 src="'+CI.base_url+'assets/img/mini-loader.gif"/>Loading...</center></div>');
            $.ajax({
                type: "post",
                url: CI.base_url+'TestController/api_getQuestionsMarkup/',
                cache: false,
                data: {
                    'set':set,
                    'categoryId':categoryId,
                    'topicUrl':topicUrl,
                    'questionUrl':questionUrl,
                    'groupScope' :groupScope


                }, 
                success: function (response) {
                    var obj = JSON.parse(response);
                        if(obj.data!=""){
                        //valid result is obtained

                        
                        try {
                            var str = '';
                            var items=obj.data;

                            $(this).append(str).fadeIn('slow');
                            $('#loadMoreQs').remove();
                            //$('#paginationLoadingGfx').remove();
                            $('#scrollableContentDiv').append(items).append('');
    ;
                            
                            console.log('got data for set:'+set)
                            //initialize next set
                            set++;
                        } catch (e) {
                            alert('Exception while request..'+e);
                        }
                    }
                    else{
                        endOfRecords=true;
                    }
                },
                error: function () {
                    alert('Error while request..');
                }
            });

        }
        else{
            $('paginationLoadingGfx').remove();

            displayNotification('warning','End of Questions for now!');

        }
    }//end triggerDataLoad

    /* BackboneJs Implementation */

    ScrollableContentDivView = Backbone.View.extend({
        el: $("#scrollableContentDiv"),
        initialize: function () {
            
        },
        events: {
          "click a.qsFollowButton" :  "followOrUnfollowQs",
          "click a.topicFollowButton" : "followOrUnfollowTopic",
          "mouseover a.followersInfoTooltip" : "displayFollowersTooltip",
          "click #postAnswerButton" : "trackTypedAnswer",
          "click a.directQsPostButton" : "showPostDirectQsModal",
          "click a.voteButton" : "voteAnswer" ,
          "click a.votedButton" :"diplayAlreadyVotedNotification"
        },
        /* method for Ajaxifying follow/unfollow of qs*/
        followOrUnfollowQs: function (ev) {
            var qsFollowButtonElement=ev.currentTarget;
            var q_id=$(qsFollowButtonElement).data('q_id');
            var follow_status=$(qsFollowButtonElement).data('follow_status');
            var follow_text='';
            var qsFollowButtonMarkupObj={};
            $(qsFollowButtonElement).empty().append('loading..');
            var followUrl= CI.base_url+'QuestionsController/followQuestion/';
            var unfollowUrl= CI.base_url+'QuestionsController/unfollowQuestion/';
            var url=follow_status=='yes'?unfollowUrl+q_id:followUrl+q_id;
            console.log('existing follow_status='+follow_status);
            if(follow_status=='yes'){
                qsFollowButtonMarkupObj={
                follow_status : 'no',
                tooltipText : 'Click to follow the question!',
                icon : 'icon-plus-sign',
                followUnfollowText : 'Follow',
                notificationStatus : 'success',
                notificationMsg : 'You have unfollowed the question successfully!'
                };

            }
            else{
                qsFollowButtonMarkupObj={
                    follow_status : 'yes',
                    tooltipText : 'Click to unfollow the question!',
                    icon : 'icon-minus-sign',
                    followUnfollowText : 'Followed',
                    notificationStatus : 'success',
                    notificationMsg : 'You have followed the question successfully!'
                };
            }
            this.updateQsFollowStatus(url,qsFollowButtonElement,qsFollowButtonMarkupObj);
            console.log('new follow_status='+follow_status);
        },
        /*after following/unfollowing update the markup of the button*/
        convertMarkupOfQsFollowButtonElement:function(qsFollowButtonElement,qsFollowButtonMarkupObj){
            
            $(qsFollowButtonElement).empty()
            $(qsFollowButtonElement).data('follow_status',qsFollowButtonMarkupObj.follow_status)
            $(qsFollowButtonElement).prepend('<i class="'+qsFollowButtonMarkupObj.icon+'"></i> ')
            $(qsFollowButtonElement).append(qsFollowButtonMarkupObj.followUnfollowText)
            $(qsFollowButtonElement).tooltip('hide')
            $(qsFollowButtonElement).attr('data-original-title', qsFollowButtonMarkupObj.tooltipText)
            displayNotification(qsFollowButtonMarkupObj.notificationStatus,qsFollowButtonMarkupObj.notificationMsg)

            //determining whether to inc/dec the followerscount
            var updationType;
            if(qsFollowButtonMarkupObj.followUnfollowText=='Followed'){
                updationType='increment';
            }
            else{
                updationType='decrement';
            }
            //updating the followers count
            this.updateFollowersCount($(qsFollowButtonElement).data('q_id'),updationType,'qs');
            
        },
        /*after following/unfollowing update db */
        updateQsFollowStatus:function(url,qsFollowButtonElement,qsFollowButtonMarkupObj){
            var that=this;
            $.get(url,function(data){
                that.convertMarkupOfQsFollowButtonElement(qsFollowButtonElement,qsFollowButtonMarkupObj);
            });
        },

        /* script for Ajaxifying listing of followers on hovering on followers link */
        displayFollowersTooltip:function(ev){
            var tooltipElement=$(ev.currentTarget);
            $(tooltipElement).attr('data-original-title','loading..')
            var tooltipType=$(tooltipElement).attr('data-type');
            var apiUrl='';
            if(tooltipType==='qs'){
                apiUrl='QuestionsController/getFollowersForQuestion/';
            }
            else if(tooltipType==='topic'){
                apiUrl='QuestionsController/getFollowersForTopic/';
            }
            $.get(CI.base_url+apiUrl+$(tooltipElement).data('q_id'),
                function(data){
              $(tooltipElement).tooltip('hide')
              .attr('data-original-title', data)
              .tooltip('fixTitle')
              .tooltip('show');
            });
        },

        updateFollowersCount: function(item_id,updationType,itemType){
            
            //get the q_id of the qs that was followed/unfollowed
            //get the target span element to be updated based on q_id

            var followersCountSpanElement='';
            if(itemType==='qs'){
                followersCountSpanElement=$('span.followersCountSpan[data-q_id='+item_id+']');
            }
            else if(itemType==='topic'){
                followersCountSpanElement=$('span.followersCountSpan[data-topic_id='+item_id+']');
            }
            var count=parseInt(followersCountSpanElement.text());
            count=updationType=='increment'?count+1:count-1;
            followersCountSpanElement.text(count+' ');

        },

        addAnswerToQuestion: function(){

            $('#postAnswerButton').val('Answering..');
            $('span.error').remove();

            //get the question id from 'id' attr of the question <a> element
            //all question links willl be in <a class="question"></a> element
            //in a particular question's page i.e AnswersController/ViewAnswerForQuestion/q_id
            //there will be only 1 qs <a> element with class "question"

            var q_id=$('.question').attr('id');
            var a_content=$('#answerText').val();
            var answerObj={
                'a_content':a_content,
                'q_id':q_id

            };

            var that=this;
            $.post(CI.base_url+'AnswersController/postAnswerForQuestionToDb',
                {'answerObj':JSON.stringify(answerObj)},
                function(jsonObj){

                working = false;
                $('#submit').val('Submit');
                
                if(jsonObj.status=='success'){

                    var answerMarkup=jsonObj.answerMarkup;

                    $(answerMarkup).hide().prependTo('#previousAnswersDiv').slideDown();
                    $('#body').val('');
                    displayNotification('success','thanks for ur post! :)');
                    $('#answerText').val('');
                    $('#postAnswerButton').val('Answer');
                    //that.enableOrDisablepostAnswerButton();
                    $('#answerText').setCode('');//clear editor
                    that.updateAnswersCount(q_id);
                }
                else {

                    displayNotification('error','oops something went wrong :(');
                }
            },'json');//post ends
        },

        enableOrDisablepostAnswerButton : function(answerLength){
            if(answerLength>0){
                $('#postAnswerButton')
                    .attr('disabled',false)
                    .removeClass('btn-danger')
                    .addClass('btn-success');
            }           
            else{
                $('#postAnswerButton')
                    .attr('disabled',true)
                    .addClass('btn-danger')
                    .removeClass('btn-success');
            }
        },

        trackTypedAnswer : function(){
            var answerLength=$.trim($('#answerText').getText()).length;
            //this.enableOrDisablepostAnswerButton(answerLength);  
            if(answerLength==0){
                alert("Please enter a valid answer!");
            }
            else{
                this.addAnswerToQuestion();
            }
        },

        updateAnswersCount: function(q_id){
            var followersCountSpanElement=$('span.answersCountSpan[data-q_id='+q_id+']');
            var count=parseInt(followersCountSpanElement.text());
            count++;
            followersCountSpanElement.text(count+' ');
        },

        followOrUnfollowTopic : function(ev){
            var topicFollowButtonElement=ev.currentTarget;
            var topic_id=$(topicFollowButtonElement).data('topic_id');
            var follow_status=$(topicFollowButtonElement).data('follow_status');
            var follow_text='';
            var topicFollowButtonMarkupObj={};
            $(topicFollowButtonElement).empty().append('loading..');
            var followUrl= CI.base_url+'QuestionsController/followTopic/';
            var unfollowUrl= CI.base_url+'QuestionsController/unfollowTopic/';
            var url=follow_status=='yes'?unfollowUrl+topic_id:followUrl+topic_id;
            console.log('existing follow_status='+follow_status);
            if(follow_status=='yes'){
                topicFollowButtonMarkupObj={
                follow_status : 'no',
                tooltipText : 'Click to follow the topic!',
                icon : 'icon-plus-sign',
                followUnfollowText : 'Follow',
                notificationStatus : 'success',
                notificationMsg : 'You have unfollowed the topic successfully!'
                };

            }
            else{
                topicFollowButtonMarkupObj={
                    follow_status : 'yes',
                    tooltipText : 'Click to unfollow the topic!',
                    icon : 'icon-minus-sign',
                    followUnfollowText : 'Followed',
                    notificationStatus : 'success',
                    notificationMsg : 'You have followed the topic successfully!'
                };
            }
            this.updateTopicFollowStatus(url,topicFollowButtonElement,topicFollowButtonMarkupObj);
        },
        /*after following/unfollowing update the markup of the button*/
        convertMarkupOfTopicFollowButtonElement:function(topicFollowButtonElement,topicFollowButtonMarkupObj){
            
            $(topicFollowButtonElement).empty()
            $(topicFollowButtonElement).data('follow_status',topicFollowButtonMarkupObj.follow_status)
            $(topicFollowButtonElement).prepend('<i class="'+topicFollowButtonMarkupObj.icon+'"></i> ')
            $(topicFollowButtonElement).append(topicFollowButtonMarkupObj.followUnfollowText)
            $(topicFollowButtonElement).tooltip('hide')
            $(topicFollowButtonElement).attr('data-original-title', topicFollowButtonMarkupObj.tooltipText)
            displayNotification(topicFollowButtonMarkupObj.notificationStatus,topicFollowButtonMarkupObj.notificationMsg);

             //determining whether to inc/dec the followerscount
            var updationType;
            if(topicFollowButtonMarkupObj.followUnfollowText=='Followed'){
                updationType='increment';
            }
            else{
                updationType='decrement';
            }
            //updating the followers count
            this.updateFollowersCount($(topicFollowButtonElement).data('topic_id'),updationType,'topic');
        },
        /*after following/unfollowing update db */
        updateTopicFollowStatus:function(url,topicFollowButtonElement,topicFollowButtonMarkupObj){
            var that=this;
            $.get(url,function(data){
                that.convertMarkupOfTopicFollowButtonElement(topicFollowButtonElement,topicFollowButtonMarkupObj);
            
            });
            
        },

        showPostDirectQsModal: function(){
            $('#postDirectQsModal').modal('show');
        },

        //voting answer implementation

        voteAnswer: function(ev){

            var voteButton=ev.currentTarget;            
            var count=0;
            
            //devide whether upvote/downvote
            if($(voteButton).hasClass('upVoteButton')){
                count=1;
                
            }
            else{
                count=-1;
                
            }
                
            //get the answerElementDiv that holds the voteButton
            var parentAnswerElementDiv=$(voteButton).closest('div.answerElementDiv');

            var a_id=$(parentAnswerElementDiv).data('a_id');
            //get votescountspan element inside the parent div element
            var votesCountSpan=$(parentAnswerElementDiv).find('span.votesCount');
            //update count in the markup
            this.updateMarkupOfVotesCountDiv(votesCountSpan,count);
            //update count in the db
            this.updateVote(count,a_id)
            //disable voteButtons for that answer
            this.disableAndHideVoteButton(parentAnswerElementDiv)
            //display voted status in answerVotesDiv
            var answerVotesDiv=$(parentAnswerElementDiv).find('div.answerVotesDiv');
            this.updateMarkupOfAnswerVotesDiv(answerVotesDiv,count)

        },

        updateVote : function(count,a_id){

            console.log('ans : '+a_id)
            var voteUrl= CI.base_url+'AnswersController/' 
            voteUrl+= (count==1?'voteUp/':'voteDown/') + a_id;
            var that=this;
            console.log(voteUrl)
            $.get(voteUrl,function(data){
                //feedback
                displayNotification('success','Thanks for your vote!');             
            });

        },

        disableAndHideVoteButton : function(divToFindVoteButtons){


            $(divToFindVoteButtons).find('.voteButton').removeClass('voteButton').addClass('votedButton').hide();

        },

        updateMarkupOfVotesCountDiv: function(spanToUpdate,count){

            var existingCount=parseInt($(spanToUpdate).text());
            console.log(existingCount)
            existingCount+=count;
            $(spanToUpdate).text(existingCount);         

        },

        diplayAlreadyVotedNotification : function(){

            displayNotification('success','Oops..You can vote only once!')

        },

        updateMarkupOfAnswerVotesDiv : function(divToAddVoteStatus,count){

            var dynamicText = (count==1?'<span class="label label-success">You <i class="icon-thumbs-up"></i> this</span>':'<span class="label label-warning">You <i class="icon-thumbs-down"></i> this</span>')
            
            $(divToAddVoteStatus).prepend(dynamicText)
                 
        }






    });
    var scrollableContentDivView = new ScrollableContentDivView();


});


//question-script.js

$(document).ready(function(){

 $('[rel~=popover]').popover();
        //activate tooltips
  $("[rel~=tooltip],[disabled=true]").tooltip();



    function cascadeTopicSelectBoxBasedOnCategory(){
        //get selected value
        var selectedCategoryId=$('#categorySelectBox').attr('value');
        //cear the topics select box
        $('#topicSelectBox').html('<option>Select a category first</option>');
        $('#topicSelectBox').attr('disabled',true);
        if(isValidCategorySelected()){

                
            //cascade topicSelectBox
            $.getJSON(CI.base_url+'QuestionsController/getTopicsInCategory/'+selectedCategoryId,
                function(jsonObj){
                    if(jsonObj.topicsData!='no data'){
                        $('#topicSelectBox').html('<option>Select a topic</option>'+jsonObj.topicsData);
                        $('#topicSelectBox').attr('disabled',false);
                    }else
                        $('#topicSelectBox').html('<option>Select a category</option>');
                }
            );

        }

    }//cascade topic ends

    //change event listener for the categorySelectBox
    $('#categorySelectBox').change(function(){

        cascadeTopicSelectBoxBasedOnCategory();
        cascadeQuestionTextBasedOnTopic();
        enableOrDisablepostQuestionButton();
        
    });//categorySelectBox change ends


    function cascadeQuestionTextBasedOnTopic(){
        if(isValidTopicSelected()){
            $('#questionText').attr('disabled',false);
            $('#questionDescText').attr('disabled',false);
        }
        else{
            $('#questionText').attr('disabled',true).val('');
            $('#questionDescText').attr('disabled',true).val('');

        }
    }//cascade question ends

    //change event listener for the topicSelectBox
    $('#topicSelectBox').change(function(){

        cascadeQuestionTextBasedOnTopic();
        enableOrDisablepostQuestionButton();
    });//topicSelectBox change ends

    //change event listener for questionText
    $('#questionText').keyup(function(){

        enableOrDisablepostQuestionButton();

    });



    function resetFormFields(){

        //clear all textfields n selectbox
        $('#categorySelectBox')
            .html('<option>Select a category</option>'+
                '<option value="1">Education</option>'+
                '<option value="2">Entertainment</option>'+
                '<option value="3">Sports</option>'+
                '<option value="4">Technology</option>'+
                '<option value="5">Miscellaneous</option>');
        $('#categorySelectBox').trigger('change');

    }

    function isValidCategorySelected(){

        //return true if valid
        if($('#categorySelectBox').val()!='Select a category')
            return true;    
        return false;
    }

    function isValidTopicSelected(){

        if($('#topicSelectBox').val()!='Select a topic' && $('#topicSelectBox').val()!='Select a category first')
            return true;    
        return false;
    }

    function isValidQuestionEntered(){
        var questionTextEntered=$.trim($('#questionText').val());
        if(questionTextEntered!=null && questionTextEntered!='' && questionTextEntered.length>0)
            return true;    
        return false;

    }

    function enableOrDisablepostQuestionButton(){

        if(isValidCategorySelected() && isValidTopicSelected() && isValidQuestionEntered()){
            $('#postQuestionButton')
                .attr('disabled',false)
                .removeClass('btn-danger')
                .addClass('btn-success');
        }           
        else{
            $('#postQuestionButton')
                .attr('disabled',true)
                .addClass('btn-danger')
                .removeClass('btn-success');
        }
    }
            



    //change event listener for the postQuestionButton
    $('#postQuestionButton').click(function(){

        //construct the questionObj to be sent
        var questionObj={
            'q_content':$('#questionText').val(),
            'q_description':$('#questionDescText').val(),
            'topic_id':$('#topicSelectBox').attr('value'),
            'anonymous':$('#anonymousCheckbox').is(':checked'),
            'scope':$('button.active[name=scope]').val()

        };

        //incase any modal is opened..just close it
        $('.modal').modal('hide');

        if(!$('#postQuestionButton').attr('disabled')){
                console.log(questionObj);
            //post qs ajaxIly
            $.post(CI.base_url+'QuestionsController/postQuestionToDb',
                {'questionObj':JSON.stringify(questionObj)},
                function(jsonObj){
                    var redirectUrl=CI.base_url+'AnswersController/viewAnswersForQuestion/';
                    if(jsonObj.status=='success'){
                        redirectUrl+=jsonObj.qsUrl;
                        displayNotification(jsonObj.status,jsonObj.msg,redirectUrl);                    
                    }
                    else if(jsonObj.status=='warning'){
                        redirectUrl+=jsonObj.qsUrl;
                        displayNotification(jsonObj.status,jsonObj.msg,redirectUrl);
                    }
                    else{
                        displayNotification(jsonObj.status,jsonObj.msg);
                    }
                },//callback ends
                'json'
            );//post ends
            
            resetFormFields();

        }//if ends
        else{
            displayNotification('error','Make sure you have posted a valid question!!');
        }
        
    });//postQuestionButton click ends

    //change event listener for the resetQuestionButton
    $('#resetQuestionButton').click(function(){

        displayNotification('warning','Question is now reset!');
        //reset the form to initial values
        resetFormFields();

    });//resetQuestionButton click ends

    //the following code is for setting popover show/hide dynamically
    popoverPreviouslyOpened = true;

    //add event handlers for elements with class=.postAnswerButton dynamically
    $('body').on('click','.postAnswerButton',function(){

        popoverPreviouslyOpened = true;
        $('a[rel~=popover]').popover('hide');

        postAnswer('asas','asasas');
    });

    /*#####################dont touch######################
    //add event handlers for popovers which are dynamically
    //hide open popover if another popover is open or clicked out

    $('body').on('click','a[rel~=popover]',function(e) {
      
      if(popoverPreviouslyOpened)
      {
        $('a[rel~=popover]').popover();
        popoverPreviouslyOpened = false;

      }
      else
      {
        popoverPreviouslyOpened = true;
        $('a[rel~=popover]').popover('hide');
      }
    });

    */

    var isVisible = false;
    var clickedAway = false;

    $('a[rel~=popover]').each(function(e) {
        $(this).popover({
            html: true,
            trigger: 'manual'
        }).click(function(e) {
            $(this).popover('show');
            isVisible = true;
            //e.preventDefault();
        });
    });

    $('#center,#left,#right').click(function(e) {
      if(isVisible & clickedAway)
      {
         $('a[rel~=popover]').each(function() {
              $(this).popover('hide');
         });
        isVisible = clickedAway = false;
      }
      else
      {
        clickedAway = true;
      }
    });


});