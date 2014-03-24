$(function(){
	$( "#content" ).tabs();
});

function loginFormSubmit(){
	alert("Welcome " + document.forms["login-form"]["UserName"].value + 
		" with the password: "+document.forms["login-form"]["Password"].value+"!");
	return false;
}