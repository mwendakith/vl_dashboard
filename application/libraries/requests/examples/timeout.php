<<<<<<< HEAD
<?php

// First, include Requests
include('../library/Requests.php');

// Next, make sure Requests can load internal classes
Requests::register_autoloader();

// Define a timeout of 2.5 seconds
$options = array(
	'timeout' => 2.5,
);

// Now let's make a request to a page that will delay its response by 3 seconds
$request = Requests::get('http://httpbin.org/delay/3', array(), $options);

// An exception will be thrown, stating a timeout of the request !
=======
<?php

// First, include Requests
include('../library/Requests.php');

// Next, make sure Requests can load internal classes
Requests::register_autoloader();

// Define a timeout of 2.5 seconds
$options = array(
	'timeout' => 2.5,
);

// Now let's make a request to a page that will delay its response by 3 seconds
$request = Requests::get('http://httpbin.org/delay/3', array(), $options);

// An exception will be thrown, stating a timeout of the request !
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
