<<<<<<< HEAD
<?php
/**
 * Exception for 418 I'm A Teapot responses
 *
 * @see https://tools.ietf.org/html/rfc2324
 * @package Requests
 */

/**
 * Exception for 418 I'm A Teapot responses
 *
 * @see https://tools.ietf.org/html/rfc2324
 * @package Requests
 */
class Requests_Exception_HTTP_418 extends Requests_Exception_HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 418;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = "I'm A Teapot";
=======
<?php
/**
 * Exception for 418 I'm A Teapot responses
 *
 * @see https://tools.ietf.org/html/rfc2324
 * @package Requests
 */

/**
 * Exception for 418 I'm A Teapot responses
 *
 * @see https://tools.ietf.org/html/rfc2324
 * @package Requests
 */
class Requests_Exception_HTTP_418 extends Requests_Exception_HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 418;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = "I'm A Teapot";
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6
}