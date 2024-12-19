Project: Attendance Management System

Project Structure ----------------------------------------------------------------------------------

project-root/
|-- config.php
|-- register.php
|-- admin_dashboard.php
|-- attendance_logs.php
|-- attendance.php
|-- database.sql
|-- edit_employee.php


Description of Files-----------------------------------------------------------------------------

config.php: Contains database connection details and configuration settings.

register.php: here employee can register themselves.

admin_dashboard.php: The dashboard for admin users, displaying an overview and navigation options.

attendance_logs.php: Displays the attendance records in a tabular format.

attendance.php: allows employee to mark their attendance

edit_employee.php: Allows editing of employee details.

database.sql: SQL script for setting up database tables.

INSTALLATION PROCESS--------------------------------------------------
 1...install the xampp server

 2...next run the apache and mysql server

 3...next open phpmyadmin

 4...here import the database.sql , so that the database and also tables in the database are loaded...


EXECUTION PROCESS---------------------------------------------------------------------------------
 1... Import the database in the phpmyadmin

 2... run this command "http://localhost/attendance_management_system/register.php" in your browser
      This will open a registration page where employee can register themselves

      ![image alt](https://github.com/ManiGanji/attendance_management_system/blob/main/registeroutput.png?raw=true)
    
 3... run this command "http://localhost/attendance_management_system/attendance.php" in your browser
      This will open a page where employee can mark attendence , and it is not compatible to desktop browsers

 4... run this command "http://localhost/attendance_management_system/admin_dashboard.php" in your browser
      This will open a page where employee details will be displayed to the admin , admin can edit / delete /create a new employee details

 5... run this command "http://localhost/attendance_management_system/attendance_logs.php" in your browser
      This will open a page where employee attendance details will be displayed to the admin

 6...employee details will be stored in attendance__system database (in employees table). 

 7...employee who marks the attedance details will be   stored in attendance__system database (in attendance_logs table)..
 

https://github.com/ManiGanji/attendance_management_system/blob/81213f01c7f5aad98ad5fcfcadc23e9647c9c406/registeroutput.png

