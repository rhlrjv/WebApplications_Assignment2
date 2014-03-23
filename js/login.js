$(function(){
	//load header and select the appropriate nav link
	$("header").load("ViewHeader.html", function() {
	  $("a#nav-login").addClass("selected"); 
	});
	//load footer
	$("footer").load("ViewFooter.html");
});
