//page Change //////////////////////////////////////////////////////

function accessHomwePage() {
	$( "#content" ).tabs( "option", "active", 0 );
}

function accessLoginForm() {
	$( "#content" ).tabs( "option", "active", 1 );
}

function accessSignupForm() {
	$( "#content" ).tabs( "option", "active", 2 );
}

function accessContactForm() {
	$( "#content" ).tabs( "option", "active", 6 );
}

function accessTodoPage() {
	$( "#content" ).tabs( "option", "active", 3 );
}

//form submissions //////////////////////////////////////////////////////

function initFormEventHandlers(){
	$( "#login-form" ).on( "submit", function( event ) {
		event.preventDefault();
		loginFormSubmit();
	});

	$( "#signup-form" ).on( "submit", function( event ) {
		event.preventDefault();
		signupFormSubmit();
	});
}

function loginFormSubmit(){

	//define data to send
	var sendData = {
		requestType: "login",
		data : JSON.stringify($("#login-form").serializeObject())
	};

	//ajax call
	$.ajax({
		type: "POST",
		url: "php/userlogin.php",
		dataType: 'json',
		data: sendData, 
		success: function(json)
		{
			alert(JSON.stringify(json)); // show response from the php script.
			if (json["status"] =='ok')
				accessTodoPage()
			else
			{
				error = json['errors'];
				//alert(JSON.stringify(error));
				if (error['msg'].length > 0)
					alert(error['msg'].join("\n"));
			}
		}
	});
}

function signupFormSubmit(){

	var sendData = {
		requestType: "signup",
		data : JSON.stringify($("#signup-form").serializeObject())
	};

	$.ajax({
		type: "POST",
		url: "php/test.php",
		dataType: 'json',
		data: sendData,
		success: function(json)
		{
			alert(JSON.stringify(json)); // show response from the php script.
		}
	});
}

//onload function //////////////////////////////////////////////////////

$(function(){
	$( "#content" ).tabs(); //enable the tabs
	initFormEventHandlers();
});


