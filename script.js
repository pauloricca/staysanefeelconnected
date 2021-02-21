$(function(){
	$('.visible-upload-btn').on('click', function(){ $('input[name=image]').click(); })
	setInterval(function(){
		if($('input[name=image]').val()=='')
		{
			$('.upload-hint').show();
			$('.visible-upload-btn').css('opacity', 0.5);
		}
		else
		{
			$('.upload-hint').hide();
			$('.visible-upload-btn').css('opacity', 1);
		}
	}, 500);
});