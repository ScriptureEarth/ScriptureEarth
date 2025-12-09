// App Builder Audio Functions 
// Requires jQuery and Popcorn plugins

function initAudioTimings(pop, timings) {

	$.each(timings, function(i) {
		
		$("#T" + this.label).attr('data-start', this.start);
		
		// Highlight target element between start/end times
		pop.footnote({
			start: this.start,
			end: this.end,
			text: '',
			target: "T" + this.label,
			effect: "applyclass",
			applyclass: "selected"
		});

		// Scroll element into view
		pop.code({
			start: this.start,
			end: this.end,
			onStart: function( options ) {
				var el = $("#T" + this.label);
				if (el.position()) {
					var top    = el.position().top;
					var height = el.height();
					var windowHeight = window.innerHeight || document.documentElement.clientHeight;
					var topToolbarHeight    = $("#toolbar-top").height();
					var bottomToolbarHeight = $("#toolbar-bottom").height();

					if ((top < $(window).scrollTop() + topToolbarHeight) ||
						(top + height > $(window).scrollTop() + windowHeight - topToolbarHeight - bottomToolbarHeight - 30)) {
						$('html,body').animate({scrollTop:top - topToolbarHeight - 30}, 1000);
					}
				}
			},
			onEnd: function( options ) {
			   ;
			}
		});
	});

	// Start playing from element when clicked
	$('.txs').click(function() {
		var audio = $('#audio');
		audio[0].currentTime = parseFloat($(this).data('start'), 10);
		audio[0].play();
	});
}
