<?php

namespace spec\Ingenerator\Pigeonhole;

use Ingenerator\Pigeonhole\Pigeonhole;
use spec\ObjectBehavior;
use Prophecy\Argument;

class PigeonholeSpec extends ObjectBehavior
{
	/**
	 * @var \Session_Fake
	 */
	protected $mock_session;

	function let()
	{
		$this->mock_session = new \Session_Fake;
		$this->beConstructedWith($this->mock_session);
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('Ingenerator\Pigeonhole\Pigeonhole');
    }

	/**
	 * @param \Ingenerator\Pigeonhole\Message $message
	 */
	function it_adds_messages_and_stores_them($message)
	{
		$this->add($message);

		$this->peek()->shouldReturn(array($message));
	}

	/**
	 * @param \Ingenerator\Pigeonhole\Message $old_message
	 * @param \Ingenerator\Pigeonhole\Message $new_message
	 */
	function it_appends_to_existing_message_list($old_message, $new_message)
	{
		$this->add($old_message);
		$this->add($new_message);

		$this->peek()->shouldReturn(array($old_message, $new_message));
	}

	/**
	 * @param \Ingenerator\Pigeonhole\Message $message
	 */
	function its_peek_method_returns_messages_without_removing($message)
	{
		$this->add($message);

		$this->peek()->shouldReturn(array($message));
		$this->peek()->shouldReturn(array($message));
	}

	/**
	 * @param \Ingenerator\Pigeonhole\Message $message
	 */
	function its_clear_method_returns_and_removes_messages($message)
	{
		$this->add($message);

		$this->clear()->shouldReturn(array($message));
		$this->clear()->shouldReturn(array());
	}

	function its_has_messages_method_returns_false_when_clear()
	{
		$this->has_messages()->shouldReturn(FALSE);
	}

	/**
 	 * @param \Ingenerator\Pigeonhole\Message $message
	 */
	function its_has_messages_method_returns_true_with_messages($message)
	{
		$this->add($message);
		$this->has_messages()->shouldReturn(TRUE);
	}

	/**
	 * @param \Ingenerator\Pigeonhole\Message $message
	 */
	function its_has_messages_method_returns_false_after_clear($message)
	{
		$this->add($message);
		$this->clear();
		$this->has_messages()->shouldReturn(FALSE);
	}

	/**
	 * @param \Ingenerator\Pigeonhole\Message $message
	 */
	function it_persists_messages_in_the_session($message)
	{
		$other_instance = new Pigeonhole($this->mock_session);
		$other_instance->add($message->getWrappedObject());

		$this->has_messages()->shouldReturn(TRUE);
		$this->peek()->shouldReturn(array($message));

		$other_instance->clear();
		$this->has_messages()->shouldReturn(FALSE);
	}

}
