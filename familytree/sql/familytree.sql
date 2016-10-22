DROP DATABASE IF EXISTS familyapp;

CREATE DATABASE familyapp CHARACTER SET utf8 COLLATE utf8_general_ci;

USE familyapp;

CREATE TABLE person (
     id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	 name VARCHAR(100) NOT NULL,
	 date_of_birth DATE NOT NULL
);

CREATE TABLE parent (
     parent_id INT(11) NOT NULL,
	 child_id INT(11) NOT NULL,
	 FOREIGN KEY (parent_id) REFERENCES person(id),
	 FOREIGN KEY (child_id) REFERENCES person(id)
);

CREATE TABLE users (
     user_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	 username VARCHAR(100) NOT NULL,
	 password VARCHAR(100) NOT NULL,
	 is_admin TINYINT(1) NOT NULL DEFAULT '0'
);

INSERT INTO person (id, name, date_of_birth) VALUES
(1, 'Rujal Shakya', '1965-04-14'),
(2, 'Govinda Thapa', '1985-10-15'),
(3, 'Srijana Gurung', '2005-07-03'),
(4, 'Ayushma Koirala', '1968-08-22'),
(6, 'Saurya Dhwoj Acharya', '1970-12-22'),
(7, 'Barsha Subedi', '1995-12-23');

INSERT INTO parent (parent_id, child_id) VALUES
(1, 2),
(2, 3),
(4, 2),
(6, 7);

INSERT INTO users (user_id, username, password, is_admin) VALUES
(1, 'admin', '$2y$12$AZrfhguwbc/xSxqGnw5YQOviOkvLt5wAZ2V5vgMRFZYv5Eu5c35kC', 1),
(2, 'phill', '$2y$12$KLUVPAcynyfPVKLcl8mLIO4QllsvMT2LfWS4yNoZvYR0Qq5/WW7Ii', 0);