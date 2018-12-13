SET foreign_key_checks = 0;
Drop table rating;
Drop table review;
Drop table profclass;
Drop table studentclass;
Drop table student;
Drop table professor;
Drop table class;
Drop table department;
Drop table studentprofclass;
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

CREATE TABLE studentprofclass (
	studentID INT NOT NULL,
	professorID INT NOT NULL,
	classID INT NOT NULL,
	PRIMARY KEY (studentID, professorID, classID),
	FOREIGN KEY (studentID) REFERENCES student(studentID),
	FOREIGN KEY (professorID) REFERENCES professor(professorID),
	FOREIGN KEY (classID) REFERENCES class(classID)
);


INSERT INTO department 
VALUES 
(1, "Sociology and Anthropology Department"),
(11, "Psychology Department"),
(21, "History Department "),
(31, "English Department "),
(41, "Department of Philosophy"),
(51, "Department of Physics"),
(61, "Department of Mathematics"),
(71, "Department of Biology"),
(81, "Marketing Department")
;

INSERT INTO class 
VALUES 
(1, "ANTHRO 262", "THEORIES OF DEVELOPMENT", "SOSS", 1 ),
(11, "ANTHRO 281", "HISTORY OF ANTHROPOLOGICAL THEORY", "SOSS", 1 ),
(21, "SA 157", "INTRODUCTION TO CULTURAL HERITAGE", "SOSS", 1 ),

(31, "PSY 101", "GENERAL PSYCHOLOGY", "SOSS", 11 ),
(41, "PSYCH 272	", "ORGANIZATIONAL PSYCHOLOGY	", "SOSS", 11 ),
(51, "LEADS 305	", "INNOVATION, CREATIVITY AND CHANGE", "SOSS", 11 ),

(61, "HI 16	", "ASIAN HISTORY", "SOSS", 21 ),
(71, "HI 165", "RIZAL AND THE EMERGENCE OF THE PHILIPPINE NATION", "SOSS", 21 ),

(81, "ELL 327", "LITERATURE, MEMORY, AND TRAUMA STUDIES	", "SOH", 31 ),
(91, "EN 12", "COMMUNICATION IN ENGLISH II", "SOH", 31 ),

(101, "PH 101	", "PHILOSOPHY OF THE HUMAN PERSON I", "SOH", 41 ),
(111, "PH 213", "PHILOSOPHY OF RELIGION", "SOH", 41 ),

(121, "PS 197", "INTRODUCTION TO QUANTUM MECHANICS I", "SOSE", 51 ),
(131, "AS 201", "FOUNDATIONS OF ATMOSPHERIC SCIENCE", "SOSE", 51 ),

(141, "AMC 124", "MATH FOR COMPUTER SCIENCE I", "SOSE", 61 ),
(151, "MA 18A", "PRINCIPLES OF MODERN MATHEMATICS I", "SOSE", 61 ),

(161, "BI 3.1", "BIODIVERSITY: LIFE ON EARTH, LABORATORY", "SOSE", 71 ),
(171, "SED 271", "INTEGRATED SCIENCE 1 - EARTH AND ENVIRONMENTAL SCIENCE", "SOSE", 71 ),


(181, "LAW 11", "ESSENTIALS OF PHILIPPINE BUSINESS LAW", "SOM", 81 ),
(191, "MKT 104	", "MARKETING COMMUNICATIONS", "SOM", 81 )
; 



INSERT INTO professor 
VALUES (1, "Karl", "G.", "Tan", 1 ), 
(11, "Georgina", "A.", "Ching", 1 ), 
(21, "Julius", "B.", "Tiu", 11 ),
(31, "Adolfo", "C.", "Chua", 21 ),
(41, "Alfred", "D.", "Ng", 21 ),
(51, "Allan", "E.", "Derapopa", 31 ),
(61, "Theodoro", "X.", "Alungson", 31 ),
(71, "Norman", "J.", "Martino", 41 ),
(81, "Andreas", "K.", "Depulan", 41 ),
(91, "Claudio", "L.", "de Dios", 51 ),
(101, "Isobelo", "M.", "Sanchez", 51 ),
(111, "Conchito", "N.", "Carmine", 61 ),
(121, "Glen", "O.", "de los Santos", 61 ),
(131, "Vincenz", "P.", "Boromeo", 71 ),
(141, "Martina", "Y.", "Ninael", 71 ),
(151, "Mariana", "Q.", "Trench", 81 ),
(161, "Anglika", "Z.", "Grande", 81 )
;

INSERT INTO profclass 
VALUES 
(1, 1),
(1, 11),
(1, 21),
(11, 1),
(11, 11),
(21, 31),
(21, 41),
(21, 51),
(31, 61),
(41, 61),
(41, 71),
(41, 11),
(51, 81),
(51, 91),
(61, 81),
(61, 91),
(61, 21),
(71, 101),
(71, 111),
(81, 101),
(91, 121),
(91, 131),
(91, 151),
(91, 141),
(101, 131),
(101, 121),
(101, 141),
(111, 141),
(111, 151),
(121, 141),
(121, 151),
(121, 131),
(131, 161),
(131, 171),
(141, 171),
(151, 161),
(151, 171),
(151, 31),
(161, 1)
;
