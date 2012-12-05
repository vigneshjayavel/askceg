	function displayNotification(type,msg){

		//display an alert msg
		$('<div class="alert alert-block alert-'+type+' fade in">' +
			                    '<button type="button" class="close" data-dismiss="alert">x</button>'+
			                    '<h4 class="alert-heading">'+msg+'</h4>'+
			                '</div>').hide().prependTo('#center').fadeIn('slow');
		//exec aftr 4s to remove alert 
		setTimeout(function() {   
		   $('.alert').slideUp().fadeOut('slow');
		   $('#alert').remove();
		   console.log('alert removed!!')
		}, 4000);

	}

$(window).load(function(){

	$('#progressbar').hide();
	$('#center').fadeIn(2);

});

$(document).ready(function(){

	$.getJSON(CI.base_url+'HomeController/getTickerContent/'+'questions',
		function(jsonObj){

			$('#left').fadeIn('slow').html(jsonObj.tickerMarkup);
			initializeTicker();

		}
	);

	$('.carousel').carousel({
  	interval: 2000
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