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

function userlogout(){
	$.ajax({
		type: "POST",
		url: "php/userLogout.php",
		dataType: 'json',
		success: function(json)
		{
			console.log(JSON.stringify(json)); // show response from the php script.
		}
	});
	setUserLoginState();
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

//ToDo Page functions ///////////////////////////////////////////////////

function incrementTodo(todoId){
	console.log("increment :"+todoId);
	todoPageBuilder();
}

function decrementTodo(todoId){
	console.log("decrement :"+todoId);	
	todoPageBuilder();
}

function deleteTodo(todoId){
	console.log("delete :"+todoId);
	todoPageBuilder();
}

function editTodo(index, todoId, totalHours, completedHours, important){
	console.log("edit : "+index+ "," + todoId+ "," + completedHours+ "," + totalHours+ "," + important);
	//console.log($("#todo-"+index+" .todo-name").text());
}


function constructTodo(i,todo){
	var completedClass = (todo["completedHrs"] == todo["totalHrs"])? "completed" : "";
	var completePercent = todo["completedHrs"] *100 /todo["totalHrs"];
	var canIncrement = (completePercent == 100)? "disabled":"";
	var canDecrement = (completePercent == 0)? "disabled":"";
	var importantClass = (todo["important"])? "important" : "";
	var returnString = [
		"<div id = \"todo-"+ i +"\" class=\"todo-entry "+completedClass+"",
			""+importantClass+"\" data-todo-id = "+todo['todoId']+" data-todo-no = "+i+">",
			"<div class=\"todo-name\"   onclick = \"editTodo("+i+","+ todo["todoId"]+",",
				""+ todo["totalHrs"]+","+ todo["completedHrs"]+","+ todo["important"] +")\" >",
				""+ todo['todoName'] + "",
			"</div>",
			"<div class = \"completion\">",
				""+ todo['completedHrs'] +"/"+ todo['totalHrs'] +" hours",
			"</div>",
			"<div class=\"progressbar\">",
			  "<div style=\" width : "+ completePercent +"%\"></div>",
			"</div>",
			"<div class=\"right todo-modifiers\">",
				"<input class = \"todo-button increment-button "+canIncrement+"\" onclick = \"incrementTodo("+todo['todoId']+")\" ",
					"type=\"button\" value=\"Increment\" "+canIncrement+"/>",
				"<input class = \"todo-button "+canDecrement+"\" onclick = \"decrementTodo("+todo['todoId']+")\"",
					"type=\"button\" style = \"background-image: url('images/dec.png');\""+canDecrement+"/>",
				"<input class = \"red-btn todo-button\" type=\"button\" onclick = \"deleteTodo("+todo['todoId']+")\"",
					"style = \"background-image: url('images/del.png');\" />",
			"</div>",
			"<div class=\"clear\"></div>",
		"</div>",
		"<hr/>"		
	];
	return returnString.join(" ");
}

function todoPageBuilder(){
	$.ajax({
		type: "POST",
		url: "php/todoRetreiveAll.php",
		dataType: 'json',
		success: function(json)
		{
			console.log(JSON.stringify(json)); // show response from the php script.
			if (json["status"] =='ok'){
				var todos = json['todos'];
				$('#todo-list').html("");

				jQuery.each( todos, function( i, todo ) {
					//console.log(JSON.stringify(todo));
					$(constructTodo(i,todo)).appendTo( "#todo-list" );
				});
			}
			else
				;//error
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

function setTodoErrorMsg(msg){
	clearMsgs();
	$("#todo-error-msg").html(msg);
	$("#todo-error-msg").fadeIn();
}

function setTodoMsg(msg){
	clearMsgs();
	$("#todo-msg").html(msg);
	$("#todo-msg").fadeIn();
}

function clearMsgs(){
	$("#form-error-msg").hide();
	$("#form-msg").hide();
	$("#todo-error-msg").hide();
	$("#todo-msg").hide();
}

//onload function //////////////////////////////////////////////////////

$(function(){
	$( "#content" ).tabs({
		activate: function(event ,ui){
			//console.log(ui.newTab.index()); //get the index of the page
			clearMsgs();
			clearAllMarkedInputFields();

			if(ui.newTab.index() == 3) //todopage
				todoPageBuilder();
		}
	}); //enable the tabs
	setUserLoginState();
	initFormEventHandlers();
	clearMsgs();
	
});


function hello(){
	alert("test");
}