/**
 * File : webroot/js/site/pannel.js
 * Crée par Kevin Joudrier
 *
 * Permet de fermer le pannel
 **/
$(function(){
	pannelInfo_close();
	pannelSuccess_close();
	pannelWarning_close();
	pannelError_close();
});

function pannelInfo_close()
{
	$('.pannel-box.info .close').click(function(){
		
		$('.pannel-box.info p').fadeOut("slow");
		$('.pannel-box.info a').fadeOut("slow");
		
		$('.pannel-box.info').animate({
			width:"0",
			height:"0"
		}, 800);
		
		$('.pannel-box.info').fadeOut("fast");
	});
}

function pannelSuccess_close()
{
	$('.pannel-box.success .close').click(function(){
		
		$('.pannel-box.success p').fadeOut("slow");
		$('.pannel-box.success a').fadeOut("slow");
		
		$('.pannel-box.success').animate({
			width:"0",
			height:"0"
		}, 800);
		
		$('.pannel-box.success').fadeOut("fast");
	});
}

function pannelWarning_close()
{
	$('.pannel-box.warning .close').click(function(){
		
		$('.pannel-box.warning p').fadeOut("slow");
		$('.pannel-box.warning a').fadeOut("slow");
		
		$('.pannel-box.warning').animate({
			width:"0",
			height:"0"
		}, 800);
		
		$('.pannel-box.warning').fadeOut("fast");
	});
}

function pannelError_close()
{
	$('.pannel-box.error .close').click(function(){
		
		$('.pannel-box.error p').fadeOut("slow");
		$('.pannel-box.error a').fadeOut("slow");
		
		$('.pannel-box.error').animate({
			width:"0",
			height:"0"
		}, 800);
		
		$('.pannel-box.error').fadeOut("fast");
	});
}



