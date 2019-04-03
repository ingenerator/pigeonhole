<?php
/**
 * Create a message for the pigeonhole using a Kohana validation object and the internal errors list
 *
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2014 inGenerator Ltd
 * @licence   BSD
 */

namespace Ingenerator\Pigeonhole\Message;


use Ingenerator\Pigeonhole\Message;

/**
 * Create a message for the pigeonhole using a Kohana validation object and the internal errors list
 *
 * @package Ingenerator\Pigeonhole\Message
 */
class ValidationMessage extends Message {

	/**
	 * Create an instance
	 *
	 * @param \Validation $validation   validation object containing data and errors for rendering
	 * @param string      $message_file message file to use to generate user error messages
	 * @param string      $title        title of the alert to display
	 * @param string      $class        message alert class
	 */
	public function __construct(\Validation $validation, $message_file, $title = 'Sorry, your request could not be processed', $class = Message::DANGER) {
		$this->title = $title;
		$this->class = $class;
		$this->message = \implode(PHP_EOL, $validation->errors($message_file));
	}

} 
