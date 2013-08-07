

(function($){
	$(function(){
		// replace youtube links with links to video player
		$('.typography a[href^="http://www.youtube.com/watch?v="]').each(function(){
			// if already replaced, skip
			if($("iframe", this).length) return;
			
			// check if id is valid
			results = $(this).attr('href').match("[\\?&]v=([^&#]*)");
			if(!results) return;
			var videoID = results[1];
			$(this).addClass('YoutubeLink');
			
			// generate iframe
			iframe = $("<iframe width='558' height='314' frameborder='0' wmode='transparent' allowfullscreen='allowfullscreen'></iframe>");
			iframe.attr('src', 'http://www.youtube.com/embed/'+videoID+'?wmode=transparent');
			$(this).html(iframe).addClass('Loaded');
		}); 
	});
})(jQuery);