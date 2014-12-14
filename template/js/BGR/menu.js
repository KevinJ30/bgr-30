/**
 * File : webroot/js/site/menu.js
 * Crée par Kevin Joudrier
 *
 * Permet de rendre le menu déroulant
 **/
$(function(){
	$('#menu li.bouton').hover(function(){
		$('ul:first', this).stop().fadeIn("slow");
	}, function(){

		$('ul:first', this).stop().fadeOut('slow');

	});
});