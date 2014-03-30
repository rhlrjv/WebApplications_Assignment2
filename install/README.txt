======================================================================================================================
					INSTALLATION INSTRUCTIONS & POINTERS (ASSIGNMENT 2 | CP3101B)
======================================================================================================================

Second assignment for web applications module - A Todo Manager (using AJAX/JQUERY/PHP/HTML5/POSTGRESQL)

INSTALLATION INSTRUCTIONS:
	
1.	Install the unzipped files into a todo Directory on your server.
	Give the following permissions(assuming the base folder is https://cp3101b-1.comp.nus.edu.sg/~userid/todo/)
	- cd public_html
	- chmod 711 -R todoAJAX
	- chmod 711 -R todoAJAX/service
	- chmod 600 -R todoAJAX/service/*.php
	- chmod 700 -R todoAJAX/service/sess

	- chmod 644 -R todoAJAX/index.html

	- chmod 711 -R todoAJAX/lib
	- chmod 644 -R todoAJAX/lib/*.js
	
	- chmod 777 -R todoAJAX/images
	- chmod 777 -R todoAJAX/fonts
	- chmod 777 todoAJAX/styles.css

2. 	Modify the following variables in config.inc to match your specs:
	$db_user=" ";
	$db_name=" ";
	$db_password=" ";
	$url_prefix=" "; //add the base folder address with https(eg : https://cp3101b-1.comp.nus.edu.sg/~userid/todo/)

3. 	Run the schema.sql to create the database prepopulated with some data to test.
	use the following instructions
	- cd public_html/todo
	- psql
	- \i schema.sql
	
4. 	Go to the URL of the base folder, login using either of the following two credentials:
	Username: jane
	Password: janepass
	
	Username: john
	Password: johnpass

CREATIVE ADDITIONS:

1. Inline editing of todos
2. Backend has been designed to perform like a stable API
3. Well defined error msgs sent over JSON
4. Clean formating of the todo-page GUI