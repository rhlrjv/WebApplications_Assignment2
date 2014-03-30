-- Dropping and creating task table
DROP TABLE task;
CREATE TABLE task (
	id integer PRIMARY KEY NOT NULL,
	taskname VARCHAR(40) NOT NULL,
	totalhrs integer,
	completedhrs integer,
	important boolean,
	username VARCHAR(20) NOT NULL
);

-- Adding rows to task table
INSERT INTO task (id, taskname, totalhrs, completedhrs, important, username) VALUES(1,'Buy groceries',1, 0, true,'jane');
INSERT INTO task (id, taskname, totalhrs, completedhrs, important, username) VALUES(4,'Read Case in Point',10, 1, true,'jane');
INSERT INTO task (id, taskname, totalhrs, completedhrs, important, username) VALUES(2,'Book tickets',1, 0, false,'jane');
INSERT INTO task (id, taskname, totalhrs, completedhrs, important, username) VALUES(5,'Train for marathon',20, 2, true,'john');
INSERT INTO task (id, taskname, totalhrs, completedhrs, important, username) VALUES(6,'Build portfolio website',10, 3, true,'john');
INSERT INTO task (id, taskname, totalhrs, completedhrs, important, username) VALUES(3,'Visit the dentist',3, 0, false,'john');
INSERT INTO task (id, taskname, totalhrs, completedhrs, important, username) VALUES(8,'Do laundry',2, 0, true,'john');


-- Dropping and creating users table
DROP TABLE users;
CREATE TABLE users (
	username VARCHAR(20) PRIMARY KEY NOT NULL,
	pwd VARCHAR(200) NOT NULL,
	email VARCHAR(40),
	dob DATE
);

-- Adding rows to users table
INSERT INTO users (username, pwd, email, dob) VALUES('john','$2y$11$69e3956c7d691ae43a13fuqOdvuRMw9k1cnA/lxYaUSV1FFOpxgyq','john91@gmail.com','1991-12-05');
INSERT INTO users (username, pwd, email, dob) VALUES('jane','$2y$11$df99c1c4ed7d68eca3e1bO91w35GpCJtnreJSt7dow3MdH9JrC1xG','jane92@gmail.com','1992-08-30');
