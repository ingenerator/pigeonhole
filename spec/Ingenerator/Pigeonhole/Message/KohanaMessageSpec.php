<?php

namespace spec\Ingenerator\Pigeonhole\Message;

use spec\ObjectBehavior;
use Prophecy\Argument;
use Ingenerator\Pigeonhole\Message;

class KohanaMessageSpec extends ObjectBehavior
{
	/**
	 * @var \Ingenerator\Pigeonhole\Message\KohanaMessage
	 */
	protected $subject;

	function it_is_initializable()
	{
		$this->beConstructedWith('foo', 'bar', array(), Message::SUCCESS);
		$this->subject->shouldHaveType('Ingenerator\Pigeonhole\Message\KohanaMessage');
	}

}
