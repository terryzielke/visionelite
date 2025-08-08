(function($){
$(function(){
	/*
		DOCUMENT ON LOAD
	*/
	$(document).ready(function(){
		
		/*
			WP COLOR PICKER
		*/
		var myOptions = {
		    // default color
		    defaultColor: '',
		    // valid color
		    change: function(event, ui){},
		    // invalid color
		    clear: function() {},
		    // hide controls on load
		    hide: true,
		    // show common colors or, supply an array of colors
		    palettes: false
		};
		$('.colorpicker').wpColorPicker(myOptions);
		
		/*
			FIX COLOR BUTTONS
		*/
		$('#wp-admin-bar-zqcr_dropdown-default li a').each(function(){
			var colorCode = $(this).attr('href').replace('#', '');
			var colorName = $(this).html();
			$(this).replaceWith('<b class="ab-item"><span class="colorCode" style="background:#' + colorCode + ';" colorcode="' + colorCode + '"></span><span class="colorName">' + colorName + '</span></b>');
			//$(this).removeAttr('href');
		});
	});

	/*
		CLICK TO COPY COLORS
	*/
	$(document).on('click','#wp-admin-bar-zqcr_dropdown-default li b',function(){
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
	
	/*
		UPDATE BACKGROUND COLOR
	*/
	$(document).ready(function(){
		var box = $('div.color.color1');
		
		$('#zqcr_color_code_one').iris({
			change: function(event, ui){
				box.css("background", this.value);
			}
		});
		$('#zqcr_color_code_one').keyup(function(){
				var value = $(this).val();
				box.css("background", this.value);
		});
	});
	$(document).ready(function(){
		var box = $('div.color.color2');
		
		$('#zqcr_color_code_two').iris({
			change: function(event, ui){
				box.css("background", this.value);
			}
		});
		$('#zqcr_color_code_two').keyup(function(){
				var value = $(this).val();
				box.css("background", this.value);
		});
	});
	$(document).ready(function(){
		var box = $('div.color.color3');
		
		$('#zqcr_color_code_three').iris({
			change: function(event, ui){
				box.css("background", this.value);
			}
		});
		$('#zqcr_color_code_three').keyup(function(){
				var value = $(this).val();
				box.css("background", this.value);
		});
	});
	$(document).ready(function(){
		var box = $('div.color.color4');
		
		$('#zqcr_color_code_four').iris({
			change: function(event, ui){
				box.css("background", this.value);
			}
		});
		$('#zqcr_color_code_four').keyup(function(){
				var value = $(this).val();
				box.css("background", this.value);
		});
	});
	$(document).ready(function(){
		var box = $('div.color.color5');
		
		$('#zqcr_color_code_five').iris({
			change: function(event, ui){
				box.css("background", this.value);
			}
		});
		$('#zqcr_color_code_five').keyup(function(){
				var value = $(this).val();
				box.css("background", this.value);
		});
	});
	/**/
		
});
})(jQuery);