/*
 * This plugin was modified by Bill Hicks
 * http://www.digitalHicks.com
 * 
 * The original plugin by Erik Uunila can be found at: 
 * https://github.com/eriku/horizontal-chart
 */
(function ($) {
  "use strict"; //You will be happier

  $.fn.horizBarChart = function( options ) {

    var settings = $.extend({
      // default settings
      selector: '.bar',
      speed: 3000,
      barheight: "10px"
    }, options);

    // Cycle through all charts on page
	  return this.each(function(){
	    // Start highest number variable as 0
	    // Nowhere to go but up!
  	  var highestNumber = 0;

      // Set highest number and use that as 100%
      // This will always make sure the graph is a decent size and all numbers are relative to each other
    	$(this).find($(settings.selector)).each(function() {
    	  var num = $(this).data('number');
        if (num > highestNumber) {
          highestNumber = num;
        }
    	});

      // Time to set the widths
    	$(this).find($(settings.selector)).each(function() {
    		var bar = $(this),
    		    // get all the data
    		    num = bar.data('number'),
                clr = bar.data('color') || "#555",
                txt = bar.data('textcolor') || "#000",
    		    // math to convert numbers to percentage and round to closest number (no decimal)
    		    percentage = Math.round((num / highestNumber) * 100) + '%',
                
                // style the object
                styles = {
                    'min-height': settings.barheight,
                    'width': '0px',
                    'background-color': clr,
                    'color': txt,
                    'display': 'inline-block'
                };
                
            // Assign styling
            $(this).css(styles);
                
    		// Time to assign and animate the bar widths
    		$(this).animate({ 'width' : percentage }, settings.speed);
    		$(this).next('.number').animate({ 'left' : percentage }, settings.speed);
    	});
	  });

  }; // horizChart

}(jQuery));