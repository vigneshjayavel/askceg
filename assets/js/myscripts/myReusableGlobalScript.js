function displayNotification(type,msg,redirectUrl){

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
          "click a.qsFollowButton":  "followOrUnfollowTopic",
          "mouseover a.followersInfoTooltip" : "displayFollowersTooltip"
        },
        /* method for Ajaxifying follow/unfollow of qs*/
        followOrUnfollowTopic: function (ev) {
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
                    followUnfollowText : 'Unfollow',
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
            $.get(CI.base_url+'QuestionsController/getFollowersForQuestion/'+$(tooltipElement).data('q_id'),
                function(data){
              $(tooltipElement).tooltip('hide')
              .attr('data-original-title', data)
              .tooltip('fixTitle')
              .tooltip('show');
        });
        }


    });
    var scrollableContentDivView = new ScrollableContentDivView();


});


