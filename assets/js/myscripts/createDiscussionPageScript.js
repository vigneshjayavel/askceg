$(document).ready(function(){

 $('[rel~=popover]').popover();
        //activate tooltips
  $("[rel~=tooltip],[disabled=true]").tooltip();



	//change event listener for the categorySelectBox
	$('#categorySelectBox').change(function(){

		cascadeTopicTextBasedOnCategory();
		enableOrDisablepostTopicButton();
		
	});//categorySelectBox change ends


	function cascadeTopicTextBasedOnCategory(){
		if(isValidCategorySelected()){
			$('#topicText').attr('disabled',false);
			$('#topicDescText').attr('disabled',false);
		}
		else{
			$('#topicText').attr('disabled',true).val('');
			$('#topicDescText').attr('disabled',true).val('');

		}
	}

	//change event listener for topicText
	$('#topicText').keyup(function(){
		enableOrDisablepostTopicButton();
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

	function isValidTopicEntered(){
		var topicTextEntered=$.trim($('#topicText').val());
		if(topicTextEntered!=null && topicTextEntered!='' && topicTextEntered.length>0)
			return true;	
		return false;

	}

	function enableOrDisablepostTopicButton(){

		if(isValidCategorySelected() && isValidTopicEntered()){
			$('#postTopicButton')
				.attr('disabled',false)
				.removeClass('btn-danger')
				.addClass('btn-success');
		}			
		else{
			$('#postTopicButton')
				.attr('disabled',true)
				.addClass('btn-danger')
				.removeClass('btn-success');
		}
	}

	//change event listener for the postTopicButton
	$('#postTopicButton').click(function(){

		var topicObj={
			'topic_name':$('#topicText').val(),
			'topic_desc':$('#topicDescText').val(),
			'category_id':$('#categorySelectBox').attr('value')
		};

		if(!$('#postTopicButton').attr('disabled')){

			//post qs ajaxIly
			$.post(CI.base_url+'QuestionsController/postTopicToDb',
				{'topicObj':JSON.stringify(topicObj)},
				function(jsonObj){
					if(jsonObj.status=='success'){
						displayNotification(jsonObj.status,jsonObj.msg);					
					}
					else{
						var redirectUrl=CI.base_url+'ProfileController/viewTopic/'+jsonObj.topicUrl;
						displayNotificationAndRedirect(jsonObj.msg,redirectUrl);
					}
					
				},//callback ends
				'json'
			);//post ends
			
			resetFormFields();

		}//if ends
		else{
			displayNotification('error','Make sure you have posted a valid topic!!');
		}
		
	});//postTopicButton click ends

	//change event listener for the resetTopicButton
	$('#resetTopicButton').click(function(){

		displayNotification('warning','Topic is now reset!');
		//reset the form to initial values
		resetFormFields();

	});//resetTopicButton click ends

	

});