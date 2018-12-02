SET foreign_key_checks = 0;
Drop table rating;
Drop table review;
Drop table profclass;
Drop table studentclass;
Drop table student;
Drop table professor;
Drop table class;
Drop table department;
SET foreign_key_checks = 1;

CREATE TABLE department (
	departmentID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	departmentName VARCHAR(255)
);

CREATE TABLE professor (
	professorID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	firstName VARCHAR(255) NOT NULL,
	middleName VARCHAR(255),
	lastName VARCHAR(255) NOT NULL,
	departmentID INT NOT NULL,
	FOREIGN KEY (departmentID) REFERENCES department(departmentID)
);

CREATE TABLE student (
	studentID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	email VARCHAR(255),
	username VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	yearGraduated INT,
	role VARCHAR(255) NOT NULL
);

CREATE TABLE class (
	classID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	courseCode VARCHAR(255) NOT NULL,
	courseName VARCHAR(255) NOT NULL,
	school VARCHAR(255) NOT NULL,
	departmentID INT NOT NULL,
	FOREIGN KEY (departmentID) REFERENCES department(departmentID)
);

CREATE TABLE rating (
	ratingName VARCHAR(255) NOT NULL,
	ratingValue FLOAT(2) NOT NULL,
	professorID INT NOT NULL,
	classID INT NOT NULL,
	studentID INT NOT NULL,
	lastmodified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (professorID, classID, studentID, ratingName),
	FOREIGN KEY (professorID) REFERENCES professor(professorID),
	FOREIGN KEY (classID) REFERENCES class(classID),
	FOREIGN KEY (studentID) REFERENCES student(studentID)
);

CREATE TABLE review (
	reviewText VARCHAR(10000),
	professorID INT NOT NULL,
	classID INT NOT NULL,
	studentID INT NOT NULL,
	lastmodified TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (professorID, classID, studentID),
	FOREIGN KEY (professorID) REFERENCES professor(professorID),
	FOREIGN KEY (classID) REFERENCES class(classID),
	FOREIGN KEY (studentID) REFERENCES student(studentID)
);

CREATE TABLE profclass (
	professorID INT NOT NULL,
	classID INT NOT NULL,
	PRIMARY KEY (professorID, classID),
	FOREIGN KEY (professorID) REFERENCES professor(professorID),
	FOREIGN KEY (classID) REFERENCES class(classID)
);

CREATE TABLE studentclass (
	studentID INT NOT NULL,
	classID INT NOT NULL,
	PRIMARY KEY (studentID, classID),
	FOREIGN KEY (studentID) REFERENCES student(studentID),
	FOREIGN KEY (classID) REFERENCES class(classID)
);


INSERT INTO department 
VALUES (NULL, "Filipino");
INSERT INTO department 
VALUES (NULL, "Science");
INSERT INTO department 
VALUES (NULL, "English");
INSERT INTO department 
VALUES (NULL, "Philosophy");

INSERT INTO class 
VALUES (NULL, "CS 21A", "Comp Sci", "SOSE", 11);
INSERT INTO class 
VALUES (NULL, "EN 12", "EngLit", "SOH", 21);
INSERT INTO class 
VALUES (NULL, "CS 129.1", "SaavedraDB", "SOSE", 11);
INSERT INTO class 
VALUES (NULL, "PH 101", "Intro to Philo", "SOH", 31);

INSERT INTO professor 
VALUES (NULL, "hi", "hii", "hello", 1);
INSERT INTO professor 
VALUES (NULL, "nigel", "h", "yu", 21);
INSERT INTO professor 
VALUES (NULL, "kristi", "d", "ingco", 31);

INSERT INTO profclass 
VALUES (1, 1); 
INSERT INTO profclass 
VALUES (1, 11); 
INSERT INTO profclass 
VALUES (11, 21); 
INSERT INTO profclass 
VALUES (21, 31); 

INSERT INTO student 
VALUES (1, "hi", "hello", "pass", 2017, "admin");
INSERT INTO student 
VALUES (2, "hi", "hello", "pass", 2015, "regular");

INSERT INTO rating 
VALUES ("LENIENCY", 5, 1, 1, 1);
INSERT INTO rating 
VALUES ("GRADING", 5, 1, 1, 1);
INSERT INTO rating 
VALUES ("STRICTNESS", 5, 1, 1, 1);

INSERT INTO rating 
VALUES ("LENIENCY", 4.2, 11, 21, 1);
INSERT INTO rating 
VALUES ("GRADING", 4.5, 11, 21, 1);
INSERT INTO rating 
VALUES ("STRICTNESS", 4.8, 11, 21, 1);

INSERT INTO rating 
VALUES ("LENIENCY", 3.2, 11, 21, 2);
INSERT INTO rating 
VALUES ("GRADING", 3.5, 11, 21, 2);
INSERT INTO rating 
VALUES ("STRICTNESS", 3.8, 11, 21, 2);
