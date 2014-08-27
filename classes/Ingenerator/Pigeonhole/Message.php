<?php
/**
 * Basic message for display to the user
 *
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2013 inGenerator Ltd
 * @license   BSD
 */
namespace Ingenerator\Pigeonhole;

/**
 * Basic message for display to the user
 *
 * @package Ingenerator\Pigeonhole
 */
class Message
{
	const DANGER = 'alert-danger';
	const INFO = 'alert-info';
	const WARNING = 'alert-warning';
	const SUCCESS = 'alert-success';

	/**
	 * @var string the class to display the message with
	 */
	public $class = '';

	/**
	 * @var string
	 */
	public $title = '';

	/**
	 * @var string
	 */
	public $message = '';

	/**
	 * Create an instance
	 *
	 * @param string $title   title of the flash to display
	 * @param string $message message to display. will be HTML escaped on output
	 * @param string $class   class to apply to the message - one of Message:: constants
	 */
	function __construct($title, $message, $class)
	{
		$this->class   = $class;
		$this->title   = $title;
		$this->message = $message;
	}
}
