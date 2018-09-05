<<<<<<< HEAD
<?php

// First, include Requests
include('../library/Requests.php');

// Next, make sure Requests can load internal classes
Requests::register_autoloader();

// Say you need to fake a login cookie
$c = new Requests_Cookie('login_uid', 'something');

// Now let's make a request!
$request = Requests::get('http://httpbin.org/cookies', array('Cookie' => $c->formatForHeader()));

// Check what we received
=======
<?php

// First, include Requests
include('../library/Requests.php');

// Next, make sure Requests can load internal classes
Requests::register_autoloader();

// Say you need to fake a login cookie
$c = new Requests_Cookie('login_uid', 'something');

// Now let's make a request!
$request = Requests::get('http://httpbin.org/cookies', array('Cookie' => $c->formatForHeader()));

// Check what we received
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
var_dump($request);