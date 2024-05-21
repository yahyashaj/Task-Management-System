Task Management System RESTful API

Overview
Welcome to the Task Management System RESTful API! This project serves as a test assignment for evaluating backend development skills, problem-solving abilities, and coding standards. The goal is to develop a comprehensive API for managing a list of tasks (to-do list), providing functionalities such as adding, viewing, editing, and deleting tasks, as well as assigning tasks to users.

Features
- Create Task: Add a new task to the system with a title, description, due date, and status.
- View Task: Retrieve task details including title, description, due date, and status.
- Edit Task: Modify existing task details such as title, description, due date, and status.
- Delete Task: Remove a task from the system.
- Assign Task: Assign a task to a specific user.
- View users: Retrive all users.
- Create User: Add a new user to the system with a name , email , isAdmin.
- Implement role-based access control.
- Implement user authentication using JWT.
- Ensure that only authenticated users can perform CRUD operations on tasks.
- filtering and searching tasks based on various criteria (status, due date, assigned user name).


Technologies Used
This project utilizes the following technologies:

Programming Language: Php
Database: Mysql
API Documentation: Postman


Setup Instructions
To set up the project locally using XAMPP, follow these steps:

- Clone the Repository: git clone https://github.com/yahyashaj/Task-Management-System.git
- Navigate to local Server Installation Directory: Open such as XAMPP Control Panel and locate the installation directory.
- Place Project Files: Move the cloned project directory into the htdocs folder within the XAMPP installation directory.
- Start Apache and MySQL: Launch XAMPP Control Panel and start Apache and MySQL services.
- Database Setup: Access phpMyAdmin via http://localhost/phpmyadmin, create a new database for the project, and import the provided     SQL  file (sql\enagagesoftassignment.sql)  .
- Run the Server: Access the project via a web browser at http://localhost/enagagesoftAssignment/index.php/.
- Access the API: The API endpoints can be accessed via http://localhost/enagagesoftAssignment/index.php/endPoint .


API Endpoints
The following endpoints are available:

- GET /tasks: Retrieve all tasks.
- GET /tasks/:id: Retrieve a specific task by ID.
- POST /tasks: Create a new task.
- PUT /tasks/:id: Update an existing task.
- DELETE /tasks/:id: Delete a task.
- POST /tasks/:id/assign: Assign a task to a user.
- GET /users: Retrieve all users.
- POST /users: Create a new user.
- GET /users/login : login user and return JWT to use it in another API's.


