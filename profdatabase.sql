CREATE DATABASE profdb;
USE profdb;

CREATE TABLE department (
	departmentID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	departmentName VARCHAR(255)
);

CREATE TABLE teacher (
	teacherID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	lastname VARCHAR(255) NOT NULL,
	firstname VARCHAR(255) NOT NULL,
	departmentID INT NOT NULL,
	FOREIGN KEY (departmentID) REFERENCES department(departmentID)
);

CREATE TABLE student (
	studentID INT NOT NULL PRIMARY KEY,
	email VARCHAR(255),
	username VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	yeargraduated INT,
	role VARCHAR(255) NOT NULL
);

CREATE TABLE class (
	classID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	coursecode VARCHAR(255) NOT NULL,
	coursename VARCHAR(255) NOT NULL,
	school VARCHAR(255) NOT NULL,
	departmentID INT NOT NULL,
	FOREIGN KEY (departmentID) REFERENCES department(departmentID)
);

CREATE TABLE rating (
	ratingname VARCHAR(255) NOT NULL,
	ratingvalue INT NOT NULL,
	teacherID INT NOT NULL,
	classID INT NOT NULL,
	departmentID INT NOT NULL,
	studentID INT NOT NULL,
	PRIMARY KEY (teacherID, classID, departmentID, studentID),
	FOREIGN KEY (teacherID) REFERENCES teacher(teacherID),
	FOREIGN KEY (classID) REFERENCES class(classID),
	FOREIGN KEY (departmentID) REFERENCES department(departmentID),
	FOREIGN KEY (studentID) REFERENCES student(studentID)
);

CREATE TABLE review (
	reviewText VARCHAR(255),
	teacherID INT NOT NULL,
	classID INT NOT NULL,
	departmentID INT NOT NULL,
	studentID INT NOT NULL,
	PRIMARY KEY (teacherID, classID, departmentID, studentID),
	FOREIGN KEY (teacherID) REFERENCES teacher(teacherID),
	FOREIGN KEY (classID) REFERENCES class(classID),
	FOREIGN KEY (departmentID) REFERENCES department(departmentID),
	FOREIGN KEY (studentID) REFERENCES student(studentID)
);

CREATE TABLE teacherclass (
	teacherID INT NOT NULL,
	classID INT NOT NULL,
	PRIMARY KEY (teacherID, classID),
	FOREIGN KEY (teacherID) REFERENCES teacher(teacherID),
	FOREIGN KEY (classID) REFERENCES class(classID)
);


