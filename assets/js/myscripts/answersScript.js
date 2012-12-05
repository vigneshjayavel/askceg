$(document).ready(function(){
	

	function enableOrDisablepostAnswerButton(answerLength){

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
	}

	//change event listener for questionText
	$('#answerText').keyup(function(){
		var answerLength=$('#answerText').val().length;
		enableOrDisablepostAnswerButton(answerLength);		

	});

	/* This flag will prevent multiple answer submits: */
	var working = false;
	

	$('#postAnswerButton').click(function(e){

 		e.preventDefault();
		if(working) 
			return false;
		
		working = true;
		$('#submit').val('Please wait..');
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
				enableOrDisablepostAnswerButton();
			}
			else {

				displayNotification('error','oops something went wrong :(');
			}
		},'json');//post ends

	});//callback ends form submit
	
});