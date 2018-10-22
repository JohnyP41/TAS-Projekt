--CREATE DATABASE TASProjekt;

IF OBJECT_ID('Roles','U') IS NOT NULL
DROP TABLE Roles;
IF OBJECT_ID('Users','U') IS NOT NULL
DROP TABLE Users;
IF OBJECT_ID('Candidates','U') IS NOT NULL
DROP TABLE Candidates;


CREATE TABLE Roles
(
	id INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
	name VARCHAR(30) NOT NULL UNIQUE
);

CREATE TABLE Users
(
	id INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
	login VARCHAR(30) NOT NULL UNIQUE,
	password VARCHAR(60) NOT NULL,
	name VARCHAR(100) NOT NULL,
	surname VARCHAR(100),
	can_Candidate BIT NOT NULL DEFAULT 0,
	role INT NOT NULL REFERENCES Roles(id) DEFAULT 1
);

CREATE TABLE Candidates
(
	id INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
	user_id INT REFERENCES Users(id)
);

INSERT INTO Roles(name) VALUES
('user'),('admin')

INSERT INTO users (login, password, name, surname, role)
  VALUES ('user1', 'password1', 'Krzysztof', 'Czerwiński', 2)
INSERT INTO users (login, password, name, surname, role)
  VALUES ('user2', 'password2', 'Jan', 'Przybylski', 2)
INSERT INTO users (login, password, name, surname, role)
  VALUES ('user3', 'password3', 'Kasia', 'Zbroja', 2)
INSERT INTO users (login, password, name, surname, role)
  VALUES ('user4', 'password4', 'Dariusz', 'Wdowczyk', 2)  
