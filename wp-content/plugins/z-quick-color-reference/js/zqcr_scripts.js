(function($){
$(function(){
	/*
		DOCUMENT ON LOAD
	*/
	$(document).ready(function(){		
		/*
			FIX COLOR BUTTONS
		*/
		$('#wp-admin-bar-zqcr_dropdown li a').each(function(){
			var colorCode = $(this).attr('href').replace('#', '');
			var colorName = $(this).html();
			$(this).replaceWith('<b class="ab-item"><span class="colorCode" style="background:#' + colorCode + ';" colorcode="' + colorCode + '"></span><span class="colorName">' + colorName + '</span></b>');
			//$(this).removeAttr('href');
		});
	});

	/*
		CLICK TO COPY COLORS
	*/
	$(document).on('click','#wp-admin-bar-zqcr_dropdown li b',function(){
		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val($(this).find('.colorCode').attr('colorcode')).select();
		document.execCommand("copy");
		$temp.remove();
		// Notify user of successful copy
		$(this).find('.colorCode').animate({'width' : '100%'},100,function(){
			$(this).animate({'width' : '25'},200);
		});
			
	});
	/**/
		
});
})(jQuery);