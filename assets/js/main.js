jQuery(document).ready(function($) {

$('ul li').click(function(event) {
	
	var index = $(this).index()+1;
	$('.tab').addClass('hidden').removeClass('show');
	$('#tabs div:nth-child('+index+')').addClass('show');
});


});