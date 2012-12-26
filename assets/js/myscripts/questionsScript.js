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
			'scope':$('input:radio[name=scope]:checked').val()

		};

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


	function postAnswer(q_id,answer){

		if(answer.length>0){


			displayNotification('success','Answer posted!!');
		}
		else{

			displayNotification('warning','Please enter a valid answer!!');
		}

	}

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