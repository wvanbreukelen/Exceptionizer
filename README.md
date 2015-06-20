# Exceptionizer
An extendable exception handler for PHP

### Install
To install Exceptionizer, download the source (by git or ZIP file) and run composer install afterwards. And done!

### Create a Exceptionizer instance
First, please include your composer autoload file (vendor/autoload.php) in your project.

Then, use the following example to create a new instance. If you supply the true boolean to the constructor, the handler will be automatically been loaded (no need to run the register method again)
```php
$ec = new Exceptionizer();
```

### Register Exceptionizer
To register Exceptionizer as a exception handler, you may use the following method
```php
$ec->register();
```
And you are done!

### Extending Exceptionizer
Exceptionizer comes with a standard installed exception handler, called Whoops. Your program would run perfectly fine on this realiable platform.
The may reason for me to build Exceptionizer is that I was looking for a way to improve logging support into my framework, but this was a difficult job to do in Whoops itself.

To extend Exceptionizer with additional modules, please use the following

#### Extending by calling a class method or running a anomynous function

For anonymous function
```php
$en->addExceptionAction(function($exception) {
	echo "<b>Some error occurred: </b>" . $exception;
});
```

For calling a class
```php
$en->addExceptionAction(array(ClassInstance, Method));
```

#### Implement another whole exception handler into Exceptionizer
```php
$en->addImplementor(new Exceptionizer\Implement\WhoopsImplementor);
```
In this example, the pre-given Whoops Implementor has been used

It is possible to add multiple actions for one exception, they will be executed in row order.

### Restore build-in exception handler
To restore the default PHP's build-in exception handler, use the revert method
```php
$ec->revert();
```

To also remove all registered actions, please pass through the true boolean
```php
$ec->revert(true);
```
