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

	$('.carousel').carousel({
  	interval: 2000
	});

    

    var requiredData,mapped,searchQuery;
    $(".typeahead").typeahead({
        minLength: 3,
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
                var dynamicUri = mapped[item].resultType==='Question'?'AnswersController/viewAnswersForQuestion/':'ProfileController/viewTopic/';    
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
        menu: '<ul class="span5 dropdown-menu"></ul>', //to stretch the box
        
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


    /* BackboneJs Implementation */

    ScrollableContentDivView = Backbone.View.extend({
        el: $("#scrollableContentDiv"),
        initialize: function () {
            
        },
        events: {
          "click a.qsFollowButton" :  "followOrUnfollowQs",
          "click a.topicFollowButton" : "followOrUnfollowTopic",
          "mouseover a.followersInfoTooltip" : "displayFollowersTooltip",
          "click #postAnswerButton" : "addAnswerToQuestion",
          "keyup #answerText" : "trackTypedAnswer",
          "click a.privateQsPostButton" : "showPostPrivateQsModal",
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

            $('#postAnswerButton').attr('disabled','disabled').val('Answering..');
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
                    $('#postAnswerButton').attr('disabled','').val('Answer');
                    that.enableOrDisablepostAnswerButton();
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
            var answerLength=$('#answerText').val().length;
            this.enableOrDisablepostAnswerButton(answerLength);  
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

        showPostPrivateQsModal: function(){
            $('#postPrivateQsModal').modal('show');
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