# E-Learning System

### Easy Access to Subjects by Students

## Project Summary

This system is a multi-tasking electronic learning system.
Its main mission is to deliver the courses to the students in the easiest way possible through the Internet in the form of downloadable files or direct reading.
It contains some sub-functions such as dialog and social network among students.
It also contains a subsystem which is an electronic bag system that enables students to keep their courses within them.

## Installation


* [eass_db-DOWNLOAD](https://ufile.io/rui0a) - Download Database
* Create a new blank database
* Import From the database that you downloaded to the new empty database
* `composer install`
* Rename The ".env.example" File to ".env"
* `php artisan key:generate`
* Edit ".env" File with your server info. Do not forget to modify the database name to match the name of the new database you created
* Run The server Using Artisan Command 
```
      php artisan serve
```
* Login Info 
```
      Email : admin@admin.com
      Pass  : b12345
```


## Tools
* [AdminLTE](https://adminlte.io/) - Free Control Panel Template
