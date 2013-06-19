$(document).ready(function(){
	$('#myCarousel').carousel();
	if(document.getElementById("change") !== null){var num=localStorage.length/3;
	$('#change').text("No of item "+num);}
});