<?php
/**
 * Clean user flash message handler
 *
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2013 inGenerator Ltd
 * @license   BSD
 */
namespace Ingenerator\Pigeonhole;

/**
 * Holder for flash messages that should be displayed to the user on the next full page render
 *
 * @package Ingenerator\Pigeonhole
 */
class Pigeonhole
{

	/**
	 * @var \Session
	 */
	protected $session;

	/**
	 * @var string key to use for storing message collection in the session
	 */
	protected $session_key = 'pigeonhole';

	/**
	 * Create an instance
	 *
	 * @param \Session $session the session instance
	 */
	public function __construct(\Session $session)
    {
        $this->session = $session;
    }

	/**
	 * Add a message for display to the user
	 *
	 * @param Message $message message to display
	 */
	public function add(Message $message)
    {
        $messages = $this->peek();
	    $messages[] = $message;
	    $this->session->set($this->session_key, $messages);
    }

	/**
	 * Whether there are any messages pending for this session
	 *
	 * @return bool
	 */
	public function has_messages()
    {
		return (\count($this->peek()) > 0);
    }

	/**
	 * Retrieve the list of outstanding messages without clearing it
	 *
	 * @return Message[]
	 */
	public function peek()
    {
        return $this->session->get($this->session_key, array());
    }

	/**
	 * Retrieve the list of outstanding messages for display and clear them from the container
	 *
	 * @return Message[]
	 */
	public function clear()
    {
		return $this->session->get_once($this->session_key, array());
    }
}
