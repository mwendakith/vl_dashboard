<<<<<<< HEAD
<?php

// First, include Requests
include('../library/Requests.php');

// Next, make sure Requests can load internal classes
Requests::register_autoloader();

// Now let's make a request!
$request = Requests::post('http://httpbin.org/post', array(), array('mydata' => 'something'));

// Check what we received
=======
<?php

// First, include Requests
include('../library/Requests.php');

// Next, make sure Requests can load internal classes
Requests::register_autoloader();

// Now let's make a request!
$request = Requests::post('http://httpbin.org/post', array(), array('mydata' => 'something'));

// Check what we received
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
var_dump($request);