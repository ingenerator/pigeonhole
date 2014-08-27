<?php

namespace spec\Ingenerator\Pigeonhole\View\Pigeonhole;

use spec\ObjectBehavior;
use Prophecy\Argument;
use Ingenerator\Pigeonhole\Message;

class MessagesSpec extends ObjectBehavior
{
	/**
	 * @param \Ingenerator\Pigeonhole\Pigeonhole $pigeonhole
	 */
	function let($pigeonhole)
	{
		$this->beAnInstanceOf('\View');
		$this->beConstructedWith('pigeonhole/messages', array('pigeonhole' => $pigeonhole));
	}
	
	function it_is_initializable()
	{
		$this->shouldHaveType('\View');
	}
	
	function it_is_renderable()
	{
		$this->subject->render()->shouldBeString();
	}
	
	/**
	 * @param \Ingenerator\Pigeonhole\Pigeonhole $pigeonhole
	 */
	function it_renders_empty_with_no_messages($pigeonhole)
	{
		$pigeonhole->has_messages()->willReturn(FALSE);
		$this->subject->render()->shouldMatch('/^\s*$/');
	}

	/**
	 * @param \Ingenerator\Pigeonhole\Pigeonhole $pigeonhole
	 */
	function it_renders_message_with_class_and_content($pigeonhole)
	{
		$this->given_messages($pigeonhole, new Message('title', 'message', Message::SUCCESS));
		
		$content = $this->subject->render();
		$content->shouldMatch('_<div class="alert alert-success">_');
		$content->shouldMatch('_<strong>title</strong>_');
		$content->shouldMatch('_</strong>\s*message\s*</div>_');
	}
	/**
	 * @param \Ingenerator\Pigeonhole\Pigeonhole $pigeonhole
	 */
	function it_renders_multiple_messages($pigeonhole)
	{
		$this->given_messages(
			$pigeonhole, 
			new Message('title1', 'message', Message::SUCCESS),
			new Message('title2', 'message', Message::SUCCESS)
		);
		
		$content = $this->subject->render();
		$content->shouldMatch('/title1.+?title2/s');
	}
	
	/**
	 * @param \Ingenerator\Pigeonhole\Pigeonhole $pigeonhole
	 * @param Message $msg,...
	 */
	protected function given_messages($pigeonhole, $msg)
	{
		$pigeonhole->has_messages()->willReturn(TRUE);
		
		$messages = func_get_args();
		array_shift($messages);
		$pigeonhole->clear()->willReturn($messages);
	}
}
