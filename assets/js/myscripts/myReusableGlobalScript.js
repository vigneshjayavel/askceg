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

    //TODO make the function synchronous
    function checkIfDataExists(content,type){

        var dataObj={
            'content':content,
            'type':type
        };
        var result=0;
        $.post(CI.base_url+'ValidationController/checkExistence', 
            { 'dataObj':JSON.stringify(dataObj) }, 
            function (jsonObj) {
                if(jsonObj.result==="yes"){
                    result= true;
                }else{
                    result= false;
                }
                console.log('inside $.post callback, result='+result)
            }
            ,'json'
        );
        return result;
        
    }


    $('#testerButton').click(function(){

        var content='What is Askceg?';
        var type='question';
        var temp=checkIfDataExists(content,type);
        console.log('actual data returned, result='+temp);

    });

});


