<?php
/**
 * Create a message for the pigeonhole using the Kohana::message message lookup system
 *
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2013 inGenerator Ltd
 * @licence   BSD
 */

namespace Ingenerator\Pigeonhole\Message;

use Ingenerator\Pigeonhole\Message;

/**
 * Create a message for the pigeonhole using the Kohana::message message lookup system
 *
 * @package Ingenerator\Pigeonhole\Message
 */
class KohanaMessage extends Message {

	/**
	 * Create an instance
	 *
	 *     // in calling code
	 *     new KohanaMessage('errors/common', 'not_found', array(':type' => 'page'), Message::DANGER);
	 *
	 *     // in messages/errors/common.php
	 *     return array(
	 *        'not_found' => array(
	 *            'title'   => 'Thing not found',
	 *            'message' => 'We could not find the requested :type.'
	 *        )
	 *     );
	 *
	 * @param string $message_file message file to load from - will be located in messages/{message_file}.php
	 * @param string $base_path    path of the message group to load - should contain title and array keys
	 * @param string $params       array of params to replace in the message if required
	 * @param string $class        class to use to display the message
	 */
	public function __construct($message_file, $base_path, $params, $class)
	{
		$this->title   = $this->lookup_message($message_file, $base_path.'.title', $params);
		$this->message = $this->lookup_message($message_file, $base_path.'.message', $params);
		$this->class = $class;
	}

	/**
	 * Locate a message and replace any parameters
	 *
	 * @param string $message_file message file to load from - will be located in messages/{message_file}.php
	 * @param string $path         path of the message to load
	 * @param string $params       array of params to replace in the message if required
	 *
	 * @return string
	 */
	protected function lookup_message($message_file, $path, $params)
	{
		//@todo: Refactor the KohanaMessage class to be clean and allow better parameter substitution and string lookup
		$message = \Kohana::message($message_file, $path);

		if ($message) {
			return strtr($message, $params);
		} else {
			$full_path = $message_file.":".$path;
			\Kohana::$log->add(\Log::WARNING, "Unknown message - ".$full_path);
			return $full_path.' '.json_encode($params);
		}
	}
} 
