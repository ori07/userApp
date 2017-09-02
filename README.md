# userApp
Simple web login app, in php with MVC.
It is defined 4 roles: PAGE_1, PAGE_2, PAGE_3, ADMIN, each one with its views. The role ADMIN also can use a CRUD restAPI.
For simplicity, it is defined just one controller for User (Login and CRUD).

Settings:
PHP 7.1
PHPUNIT 3.7
Mysql 14.13, dist 5.5
PHP built in server

The script init.sql creates the users, database and tables of the application and its test. To run it:
In the terminal, go to the path where the file is, then login as root in mysql
mysql -u root -p root
Then execute the file
mysql \. init.sql

For the current version, consider:
1. The server must start outside the project folder
2. The file .ht.router.php is not used as a router,please ignore it.




