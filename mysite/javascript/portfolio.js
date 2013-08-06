
(function($){
	$.entwine('damo.blog', function($) {
		
		var expandedClasses = 'selected quadro double-vertical';
		var minimisedClasses = 'double';
		
		// Portfolio item action
		$('.portfolio-item:not(.selected)').entwine({
			onclick: function() {
				$('.portfolio-item')
					.removeClass(expandedClasses)
					.addClass(minimisedClasses);
				this
					.removeClass(minimisedClasses)
					.addClass(expandedClasses);
			}
		});
		
		$(".portfolio-item.selected").entwine({
			onclick: function() {
				this
					.removeClass(expandedClasses)
					.addClass(minimisedClasses);
			}
		});
	});
})(jQuery);