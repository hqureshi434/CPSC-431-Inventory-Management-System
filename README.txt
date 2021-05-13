# CPSC 431-01, Spring 2021 - Project
## Project Name: Inventory Management System (IMS)
## Project By: 
* Adam Laviguer | adamlaviguer@csu.fullerton.edu
* Hammda Qureshi | qureshi434@csu.fullerton.edu

## Link to Web-App:
[Project] (http://ecs.fullerton.edu/~cs431s1/P1/)

### Introduction
The goal of the project is to create an online Inventory Management System (IMS) for retailers.

### How to Use the Application
1. Log in with one of the premade logins
	* Username: inventory@ims.com | Password: inventory2021
	* Username: procurement@ims.com | Password: procurement2021
	* Username: manager@ims.com | Password: manager2021
2. Depending on which login you chose (provided above), you'll have certain permissions which match the use-cases described below.
3. The Item Name must be provided for each transaction performed within the Inventory Management System, so don't leave that part out!

#### Use-cases
1. Add new Item Record to the Inventory Management System
	1. Actor(s):
		1. Procurement
		2. Manager
	2. Description:
		1. Procurement will add new Item Records to the IMS (Inventory Management System). The Item Record will have a Name, Price, Onhand Quantity, and Photo.
2. Change the price of an Item Record
	1. Actor(s):
		1. Procurement
		2. Manager
	2. Description:
		1. Procurement will be able to change the price of an item record from the Inventory screen.
3. Log-in to the Inventory Management System
	1. Actor(s):
		1. Managers
		2. Inventory Control
		3. Procurement
	2. Description:
		1. The Actor will enter their Email and Password in order to log into the IMS. NOTE: Actor credentials will be setup ahead of time by the System Admin so there is no registration process.
4. Change the Onhand Quantity for a certain Item Record
	1. Actor(s):
		1. Inventory Control
		2. Manager
	2. Description:
		1. The Manager or Inventory Control will be able to change the current Onhand Quantity from the Inventory Screen.
5. Delete and Item Record
	1. Actor(s):
		1. Manager
		2. Procurement
	2. Description:
		1. The Manager or Procurement will be able to delete an Item Record (from the database and the photo repository)

#### Planned Features
1. File uploads
2. Database access
3. Access Control (Log in/log out functionality)
4. Session Handling
5. Input validation

### Contribution breakdown:
* All UI: Adam Laviguer
* SQL Queries: Hammad Qureshi
* Database Design: Hammad Qureshi
* Session Handling: Adam Laviguer
* Exception Handling: Adam Laviguer
