//variables ////////////////////////////////////////////////////////


//check application state //////////////////////////////////////////
function setUserLoginState(){
	$.ajax({
		type: "POST",
		url: "php/getLoginState.php",
		dataType: 'json',
		success: function(json)
		{
			console.log(JSON.stringify(json)); // show response from the php script.
			if (json["state"] =='logged_in'){
				$( "#content" ).tabs( "enable");
				$( "#content" ).tabs( "option", "disabled", [ 1, 2 ] );
				$('.nav-lin').show();
				$('.nav-lout').hide();
				accessTodoPage();
			}
			else{
				$( "#content" ).tabs( "enable");
				$( "#content" ).tabs( "option", "disabled", [ 3, 4 ] );
				$('.nav-lin').hide();
				$('.nav-lout').show();
				accessHomePage();
			}
		}
	});
}

//page Change //////////////////////////////////////////////////////

function accessHomePage() {
	$( "#content" ).tabs( "option", "active", 0 );
}

function accessLoginForm() {
	$( "#content" ).tabs( "option", "active", 1 );
}

function accessSignupForm() {
	$( "#content" ).tabs( "option", "active", 2 );
}

function accessTodoPage() {
	$( "#content" ).tabs( "option", "active", 3 );
}

function accessContactForm() {
	$( "#content" ).tabs( "option", "active", 6 );
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

function clearAllMarkedInputFields(){
	$('.text-error').removeClass('text-error');
}

function loginFormSubmit(){

	clearAllMarkedInputFields();

	//define data to send
	var sendData = {
		requestType: "login",
		data : JSON.stringify($("#login-form").serializeObject())
	};

	//ajax call
	$.ajax({
		type: "POST",
		url: "php/userLogin.php",
		dataType: 'json',
		data: sendData, 
		success: function(json)
		{
			console.log(JSON.stringify(json)); // show response from the php script.
			if (json["status"] =='ok'){
				setUserLoginState();
				$("#login-form")[0].reset(); //clear the form
			}
			else
			{
				error = json['errors'];

				if (error['msg'].length > 0)
					setFormErrorMsg(error['msg'].join("<br/>"));
				else
					setFormErrorMsg("Undefined Error. Pls contact system admin");

				if (error['username'])
					$("#login-form input[name=UserName]").addClass("text-error");
				if (error['password'])
					$("#login-form input[name=Password]").addClass("text-error");
			}
		}
	});
}

function signupFormSubmit(){

	clearAllMarkedInputFields();

	//define data to send
	var sendData = {
		requestType: "signup",
		data : JSON.stringify($("#signup-form").serializeObject())
	};

	//ajax call
	$.ajax({
		type: "POST",
		url: "php/userCreate.php",
		dataType: 'json',
		data: sendData, 
		success: function(json)
		{
			console.log(JSON.stringify(json)); // show response from the php script.
			if (json["status"] =='ok'){
				setUserLoginState();
				$("#signup-form")[0].reset(); //clear the form
			}
			else
			{
				error = json['errors'];

				if (error['msg'].length > 0)
					setFormErrorMsg(error['msg'].join("<br/>"));
				else
					setFormErrorMsg("Undefined Error. Pls contact system admin");

				if (error['username'])
					$("#signup-form input[name=UserName]").addClass("text-error");
				if (error['password'])
					$("#signup-form input[name=Password]").addClass("text-error");
				if (error['reenterpassword'])
					$("#signup-form input[name=reEnterPassword]").addClass("text-error");
				if (error['email'])
					$("#signup-form input[name=email]").addClass("text-error");
				if (error['dob'])
					$("#signup-form input[name=dob]").addClass("text-error");
			}
		}
	});
}

//User Message functions ////////////////////////////////////////////////

function setFormErrorMsg(msg){
	clearMsgs();
	$("#form-error-msg").html(msg);
	$("#form-error-msg").fadeIn();
}

function setFormMsg(msg){
	clearMsgs();
	$("#form-msg").html(msg);
	$("#form-msg").fadeIn();
}

function clearMsgs(){
	$("#form-error-msg").hide();
	$("#form-msg").hide();
}

//onload function //////////////////////////////////////////////////////

$(function(){
	$( "#content" ).tabs({
		activate: function(event ,ui){
			//console.log(ui.newTab.index()); //get the index of the page
			clearMsgs();
			clearAllMarkedInputFields();
		}
	}); //enable the tabs
	initFormEventHandlers();
	clearMsgs();
	setUserLoginState();
});


