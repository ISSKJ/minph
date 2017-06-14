# Minph framework

Minph framework is the minimal framework based on MVC design.

## How to install
```
$ git clone https://github.com/ISSKJ/minph.git
$ ./bin/install
$ chmod 777 app/storage/ -R or chown www-data:www-data app/storage/
$ ./bin/minph development
```
### Server requirements
* PHP >= 5.6
* PDO extension
* OpenSSL extension
* Mbstring extension
* Linux environment

## External libraries
* [phpdotenv (https://github.com/vlucas/phpdotenv)](https://github.com/vlucas/phpdotenv)
* [Tracy (https://github.com/nette/tracy)](https://github.com/nette/tracy)
* Template engine (anything you like!)  
  * [Smarty (http://www.smarty.net/)](http://www.smarty.net/)
  * [Mustache (https://github.com/bobthecow/mustache.php)](https://github.com/bobthecow/mustache.php)

## Project directory
* `app/`
  * `controller/`  
    Controller class. (UserController.php, etc.)
  * `event/`  
    Event handler. (SendMailEvent.php, etc.)
  * `exception/`  
    Exception class. (UserAuthException.php, etc.)
  * `locale/`  
    Locale mapping files. (/en/.., /ja/.., etc.)
  * `migration/`  
    Database schema files. (tables.sql, etc.)
  * `repository/`  
    Database repository class. (UserRepository.php, etc.)
  * `service/`  
    Program logic class. (UserService.php, etc.)
  * `storage/`  
    Template cache and log class. (Smarty template cache, etc.)
  * `template/`  
    Template class. (TemplateSmarty.php, etc.)
  * `test/`  
    Unit test class. (UserServiceTest.php, etc.)
  * `validator/`  
    Validator class. (MyValidator.php, etc.)
  * `view/`  
    View template files. (index.tpl, etc.)
  * `boot.php`  
    It is an entry point of App.
  * `locales.php`
    It defines locale mapping configuration.
  * `routes.php`
    It defines URI and Controller's mapping configuration.
  * `bin/`  
      * `bin/install`  
        This just calls `composer update -vvv` on framework and app.
      * `bin/minph`  
        [release|development|clear-cache]
  * `framework/`  
    Framework itself.
  * `public/`  
    Web document root directory.
  * `resource/`  
    Web resource directory.

# Getting started

[GettingStarted](./en/GettingStarted.md)
