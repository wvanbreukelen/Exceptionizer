# Exceptionizer
An extendable exception handler for PHP

### Install
To install Exceptionizer, download the source (by git or ZIP file) and run composer install afterwards. And done!

### Create a Exceptionizer instance
First, please include your composer autoload file (vendor/autoload.php) in your project.

Then, use the following example to create a new instance. The first argument contains your application name
```php
$ec = new Exceptionizer('MyApp');
```

### Register Exceptionizer
To register Exceptionizer as a exception handler, you may use the following method
```php
$ec->register();
```
And you are done!
