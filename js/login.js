$(function(){
	//load header and select the appropriate nav link
	$("header").load("ViewHeader.html", function() {
	  $("a#nav-login").addClass("selected"); 
	});
	//load footer
	$("footer").load("ViewFooter.html");
	
});

function loginFormSubmit(){
	alert("Welcome " + document.forms["login-form"]["UserName"].value + 
		" with the password: "+document.forms["login-form"]["Password"].value+"!");
	return false;
}
