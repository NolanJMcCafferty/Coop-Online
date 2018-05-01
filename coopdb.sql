DROP DATABASE IF EXISTS COOP;

CREATE DATABASE COOP;

USE COOP;


CREATE TABLE Customer (
	cid INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR (256) NOT NULL,
	email VARCHAR (256) NOT NULL,
	studentNum INT UNSIGNED NOT NULL,
	building VARCHAR (256) NOT NULL,
	room INT UNSIGNED NOT NULL
);

CREATE TABLE PurchaseOrder (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	cid INT UNSIGNED NOT NULL
);

CREATE TABLE Food (
	orderid INT UNSIGNED NOT NULL,
	foodid INT UNSIGNED NOT NULL,
	quantity INT UNSIGNED NOT NULL
);


CREATE TABLE FoodItems (
	fid INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR (256) NOT NULL,
	price INT UNSIGNED NOT NULL,
	imageName VARCHAR (256) NOT NULL
);


INSERT INTO FoodItems (name, price, imageName) VALUES ("Fountain Burger", 7, "fountainburger");
INSERT INTO FoodItems (name, price, imageName) VALUES ("Breakfast Burrito", 6, "burrito");
INSERT INTO FoodItems (name, price, imageName) VALUES ("Quesadilla", 5, "quesadilla");
INSERT INTO FoodItems (name, price, imageName) VALUES ("BLT", 6, "blt");
INSERT INTO FoodItems (name, price, imageName) VALUES ("Caesar Salad", 5, "caesarsalad");
INSERT INTO FoodItems (name, price, imageName) VALUES ("Ice Cream", 3, "icecream");
INSERT INTO FoodItems (name, price, imageName) VALUES ("Float", 4, "float");
INSERT INTO FoodItems (name, price, imageName) VALUES ("Shake", 3, "shake");
