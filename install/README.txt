======================================================================================================================
					INSTALLATION INSTRUCTIONS & POINTERS (ASSIGNMENT 2 | CP3101B)
======================================================================================================================

Second assignment for web applications module - A Todo Manager (using AJAX/JQUERY/PHP/HTML5/POSTGRESQL)

INSTALLATION INSTRUCTIONS:
	
1.	Install the unzipped files into a todo Directory on your server.
	Give the following permissions(assuming the base folder is https://cp3101b-1.comp.nus.edu.sg/~userid/todo/)
	- cd public_html
	- chmod 711 -R todoAJAX

	- chmod 777 -R todoAJAX/images
	- chmod 777 -R todoAJAX/fonts

	- chmod 644 todoAJAX/styles.css
	- chmod 644  todoAJAX/index.html

	- chmod 644 -R todoAJAX/lib/*.js

2. 	Modify the following variables in config.inc to match your specs:
	$db_user=" ";
	$db_name=" ";
	$db_password=" ";
	
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

1. Inline editing of todos and adding of todos
2. Creative task summary UI
3. Backend has been designed to perform like a standalone API
4. Well defined unformatted error msgs sent over JSON
5. Clean formating of the todo-page GUI