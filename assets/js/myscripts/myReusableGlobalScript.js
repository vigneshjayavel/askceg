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

    

    var requiredData,mapped,searchQuery;
    $(".typeahead").typeahead({
        minLength: 3,
        source: function(query, process) {
            searchQuery=query;
            requiredData = [],
            mapped = {}
            $.get(CI.base_url+'AjaxSearchController/getData', { q: query }, function (data) {
                
                $.each(JSON.parse(data), function (i, item) {
                    mapped[item.searchTerm] = item;
                    requiredData.push(item.searchTerm);

                })

                process(requiredData);
            });

            
        },
        updater: function (item) {
            if(mapped[item]!=null){
                url = mapped[item].targetURL;    
            }
            else{
                url='AjaxSearchController/getData?q='+searchQuery;
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
        
        //display the result type by concatenating either "question/category/topic" to search keyword
        //TODO: strip search term if the length is too long 
        highlighter: function (item) {

            var result = mapped[item];
            
            if(result!=undefined){
                var query = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&');

                var highlighted_label = item.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
                  return '<strong>' + match + '</strong>'
                });

                var view_label = highlighted_label + ' (<i>' + result.searchType + '</i>)';            
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