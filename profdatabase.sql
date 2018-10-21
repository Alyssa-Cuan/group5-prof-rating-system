Drop table rating;
Drop table review;
Drop table profclass;
Drop table student;
Drop table professor;
Drop table class;
Drop table department;

CREATE TABLE department (
	departmentID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	departmentName VARCHAR(255)
);

CREATE TABLE professor (
	professorID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	lastName VARCHAR(255) NOT NULL,
	firstName VARCHAR(255) NOT NULL,
	departmentID INT NOT NULL,
	FOREIGN KEY (departmentID) REFERENCES department(departmentID)
);

CREATE TABLE student (
	studentID INT NOT NULL PRIMARY KEY,
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
	ratingValue INT NOT NULL,
	professorID INT NOT NULL,
	classID INT NOT NULL,
	departmentID INT NOT NULL,
	studentID INT NOT NULL,
	PRIMARY KEY (professorID, classID, departmentID, studentID),
	FOREIGN KEY (professorID) REFERENCES professor(professorID),
	FOREIGN KEY (classID) REFERENCES class(classID),
	FOREIGN KEY (departmentID) REFERENCES department(departmentID),
	FOREIGN KEY (studentID) REFERENCES student(studentID)
);

CREATE TABLE review (
	reviewText VARCHAR(10000),
	professorID INT NOT NULL,
	classID INT NOT NULL,
	departmentID INT NOT NULL,
	studentID INT NOT NULL,
	PRIMARY KEY (professorID, classID, departmentID, studentID),
	FOREIGN KEY (professorID) REFERENCES professor(professorID),
	FOREIGN KEY (classID) REFERENCES class(classID),
	FOREIGN KEY (departmentID) REFERENCES department(departmentID),
	FOREIGN KEY (studentID) REFERENCES student(studentID)
);

CREATE TABLE profclass (
	professorID INT NOT NULL,
	classID INT NOT NULL,
	PRIMARY KEY (professorID, classID),
	FOREIGN KEY (professorID) REFERENCES professor(professorID),
	FOREIGN KEY (classID) REFERENCES class(classID)
);


