# Coop-Online

Website to order food from the Coop Fountain online. 

First, start Sql and Apache in MAMP. Website uses php, javascript, html, w3css, SMTP email protocol, and mvc architecture. 

Application Structure


Coop-Online (Folder)

	Application (Folder) 

		Model (Folder) 
		
			cart.php - contains information about items to order
			dbconnect.php - starts up database and connects sql to appache
			model.php - deals with session, adding to removing from cart
			querries.php - file containing relevant queries to the database

		View (Folder)

			checkout.php - page that interfaces with db, stores information, and sends email
			orderform.php - page users input their orders, uses sessions
			view.php - main view others are loaded into
			viewcart.php - displays contents of cart in session. Results seen when adding food items to cart.

		Controller (Folder)

			controller.php - creates model and view. Loads initail view and when changes happen to model, it renders new view

	Public (Folder)

	index.php - welcome page
	order.php - file that creates and invokes controller
	coopdb.sql - Instantiates database on sql server creates the tables being used to store customer information
	README.md


###Alex - Set up initial MVC modified it for our purposes instead of gsc, W3 css style for website, orderform/controller issue, presentation, README

###Matt - In charge of order form, field validation of fields in order form, creating presentation, session security

###Nolan - set up sql database php/database interaction and email notifications
