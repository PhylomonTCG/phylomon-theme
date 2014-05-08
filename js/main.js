/************************************
 *
 * Phylomon Main JS
 *
 *
 ****/
jQuery(document).ready(function($) {
    
    // autocomplete 
    var cache = {};
    
    $("#card-autosearch").autocomplete({			
			source:function(request, response) {
				if (cache.term == request.term && cache.content) {
					response(cache.content);
				}
				if (new RegExp(cache.term).test(request.term) && cache.content && cache.content.length < 13) {
					var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
					response($.grep(cache.content, function(value) {
	    				return matcher.test(value.value)
					}));
				}
				request.action = "search_cards";
				//console.log(request,PhylomonSettings.ajaxurl);
				$.ajax({
					url: PhylomonSettings.ajaxurl,
					dataType: "json",
					data: request,
					success: function(data) {
						// Set the cache term
						cache.term = request.term;
						
						// Loop over the returned data and format it for display
						for(var i in data){
							var img = "";
							if(data[i].img != ""){
								// Build the image tag					
								img = '<img src="'+data[i].img+'" class="card-thumb" alt="'+data[i].value+'" />';									
							}
							// Build the label
							var label = "<span>"+data[i].value+"</span>"+img; 		
							// Set the new label
							data[i].label = label;							
						}
						
						// Fill the cache with the formated data
						cache.content = data;
						// Pass the retrieved card data to the autocomplete function to display them
						response(data);
					},
					error: function(jqXHR, textStatus, errorThrown){
						console.log("AJAX FAILED! textStatus: ",textStatus,"errorThrown: ",errorThrown);
					}					
				});
			},
			delay:100,
			minLength:1,			
			select: function(event, ui) {						
				$("#card-searchform").submit();
			}
		});
	
	/* Card Cart */
    var COOKIE_NAME = 'phylomon_cards';
    var COOKIE_OPTIONS = { path: '/'};
    var cookie_value = $.cookie(COOKIE_NAME);
    
    
	// Create Card Actions 
	$("ul.card-action").each(function(){
		el = $(this);
		card_id = el.attr('id').substring(12);
    	//card_id = id;
    	
    	// console.log(card_id,cookie_value);
    	checked =""; // reset the value
    	if(cookie_value)
    	{   
	    	var cookie_array = new Array();
	  		cookie_array = cookie_value.split(',');
	  		var index = indexInArray(cookie_array,card_id);
	  		
	    	if(index != -1)
	    		checked = "checked='checked'"; 
    	}
		
    	el.prepend('<li><label><input type="checkbox" class="checkbox" value="'+card_id+'" '+checked+' /> Select </label></li><li class="flip-container"><a id="flip-'+card_id+'" href="#flip" class="flip">Flip Card</a></li>');
		
	});
	
	

  
    // Flip event 
    $('a.flip').live("click",function() {
    	el 			= $(this);
    	card_id		= el.attr('id').substring(5);
    	HTMLcontent = $("#card-flip-content-"+card_id).html();
    	// console.log("flip", HTMLcontent);

    	
    	$("#card-"+card_id).flip({
			direction:'rl',
			content:HTMLcontent,
			color:"#FFFFFF",
			speed: 300
		});
		el.removeClass("flip").addClass("unflip").text("Unflip Card");
		
    });
    
    $('a.unflip').live("click", function() {
    	el 			= $(this);
    	card_id		= el.attr('id').substring(5);
    	$("#card-"+card_id).revertFlip();
    	el.removeClass("unflip").addClass("flip").text("Flip Card");
    	
    });
    
    
    $("#toggle-photo-graphic-trigger").toggleClass("graphic","photo").toggle(function(){
    	$(this).attr("class","show-photo").text("Graphic set");
    	$('.graphic').hide();
    	$('.photo').show();
    	return false;
    },function(){
    	$(this).attr("class","show-graphic").text("Photo set");
    	$('.photo').hide();
    	$('.graphic').show();
    	return false;
    });
    
    // Remove all the cards from the cart at once
    $("#remove-cards").click(function() {
    	if(confirm("Are you sure you want to remove all selected Cards? \nThis cannot be undone! "))
    	{
    		// delete the cookie 
    		$.cookie(COOKIE_NAME, null, COOKIE_OPTIONS);
    		$('input.checkbox').attr('checked', false);
    		$("#phylomon-cards-cart-list").html(" ");
    		$("#no-cards").show();
    		
    		
    	}
    	
    	// do nothing
    	return false;
    })
    
    // Select cards and place them into the card cart
    $('input.checkbox').live('click', function() {
  		// modify cookie
  		cookie_value = $.cookie(COOKIE_NAME);
  		card_id = $(this).val();
  		card_permalink = $('#card-permalink-'+card_id);
  		card_link = card_permalink.attr("title");
  		card_url  = card_permalink.attr("href");
  		// console.log("start ",this.checked,cookie_value);
  		if(this.checked)
  		{
  			// set cookie 
  			if(cookie_value)
  				cookie_value = cookie_value+","+card_id;
  			
  			else 			
  				cookie_value = card_id;
  			
  			$.cookie(COOKIE_NAME, cookie_value,COOKIE_OPTIONS);
  			
  			// add the card to the cart
  			$("#phylomon-cards-cart-list").prepend("<li id='card-in-cart-"+card_id+"'><a href='"+card_url+"'>"+card_link+"</a></li>");
  			
  			$("#card-in-cart-"+card_id).hide().animate({"opacity": "toggle" }, 1000);
			$("#phylomon-cards-cart-list").effect("highlight",{},500,function(){});

  			
  			$("#no-cards").hide();
  		}
  		else{
  			// delete the sting from the cookie
  			var cookie_array = new Array();
  			cookie_array = cookie_value.split(',');
  			var index = indexInArray(cookie_array,card_id);
  			if(index != -1)
  				cookie_array.splice(index,1)
  			
  			cookie_value = cookie_array.toString();
  			
  			//console.log("remove cookie", cookie_value);
  			$.cookie(COOKIE_NAME, cookie_value,COOKIE_OPTIONS);
  			
  			// console.log( cookie_value );
  			// remove the card from the cart 
  			$("#card-in-cart-"+card_id).remove();
  			
  			if( !cookie_value )
  				$("#no-cards").show();
  			

  			
  		}
  		
		
  		// modify cart 
  		
  	
  	});
    
    
    
});

/* in array */
function indexInArray(arr,val){
	for(var i=0;i<arr.length;i++) if(arr[i]==val) return i;
	return -1;
} 
/*** 
 jQuery Cookie 
 via. http://stilbuero.de/jquery/cookie/
 ***/
jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
			options = jQuery.extend({}, options); // clone object since it's unexpected behavior if the expired property were changed
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // NOTE Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};

