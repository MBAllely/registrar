# Registrar

Many to many relationship practice in PHP

### By _**Marika Allely and Mary Warrington**_

## Description

####This app was built as an exercise for Epicodus and is not meant to be replicated. I'm keeping it here for my own records, and for nostalgia's sake. Feel free to play with it, but be aware that it is not a complete project.

_This web app is designed to serve as a basic registrar site. Students and courses can be created, stored, deleted individually, or deleted as a group.  The app was built using the micro-framework Silex, as well as Bootstrap._

_The goal of this project is to show basic understanding and competency with php and the Silex micro-framework, including the ability to create, store, and delete instants of a given class._

## Setup/Installation Requirements

1. Fork and clone this repository from [gitHub](https://github.com/MBAllely/registrar).
2. In the terminal, navigate to the root directory of the project and run the command: __composer install__ .
3. In the terminal, start SQL by running the command: __mysql.server start__, and then run the command __mysql -uroot -proot__ .
4. In another terminal tab, start Apache by running the command __apachectl start__ .
5. In your browser, navigate to __localhost:8080/phpmyadmin__ . Click the Import tab, choose the file for _registrar.sql.zip_ in the project folder, and press go.
6. On a mac: Create a local server in the /web directory within the project folder  the command: __php -S localhost:8000__ .  On a windows, shrug.  Sorry, hoss.
7. Open the directory http://localhost:8000 in any standard web browser. (#chrome4lyfe)

## IF YOU NEED TO CREATE THE DATABASE

1. If you haven't already: In the terminal, start SQL by running the command: __mysql.server start__, and then run the command __mysql -uroot -proot__.
2. Run the command __CREATE DATABASE registrar;__ .
3. Use the database by running the command __USE registrar__ .
4. Create the __students__ table by running the command __CREATE TABLE students (name TEXT, date DATE, department_id INT, id serial PRIMARY KEY);__ .
5. Create the __courses__ table by running the command __CREATE TABLE courses (course_name TEXT, course_num INT, id serial PRIMARY KEY);__ .
6. Create the __enrollment__ table by running the command __CREATE TABLE enrollment (student_id INT, course_id INT, id serial PRIMARY KEY);__ .
7. In your browser, navigate to http://localhost:8080/phpmyadmin.  The username is __root__ and the password is __root__.
8. Click on the _registrar_ database.
9. Click on the _Operations_ tab
10. Under _Copy database to_, name the copy __registrar_test__, select _Structure only_, unselect _Add contraints_ and _Adjust privileges_, then click _Go_.

## Known Bugs

_This application is not fully designed and may have unknown bugs._

The Department class isn't functional yet and is not in the database.

## Support and contact details

If you have any questions, concerns, or feedback, please contact the author through [gitHub](https://github.com/MBAllely).

## Technologies Used

_This web application was created using the_  [Silex micro-framework](http://silex.sensiolabs.org/)_, as well _[Twig](http://twig.sensiolabs.org/), a template engine for php.

### License

MIT License.

Copyright (c) 2016 **_Marika Allely and Mary Warrington_**
