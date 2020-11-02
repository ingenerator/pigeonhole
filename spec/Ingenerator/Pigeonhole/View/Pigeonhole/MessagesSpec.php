<?php

namespace spec\Ingenerator\Pigeonhole\View\Pigeonhole;

use Ingenerator\Pigeonhole\Message;
use Ingenerator\Pigeonhole\Pigeonhole;
use spec\ObjectBehavior;
use View;
use function array_shift;
use function func_get_args;

class MessagesSpec extends ObjectBehavior
{
    /**
     * @param Pigeonhole $pigeonhole
     */
    function let(Pigeonhole $pigeonhole)
    {
        $this->beAnInstanceOf(View::class);
        $this->beConstructedWith('pigeonhole/messages', ['pigeonhole' => $pigeonhole]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(View::class);
    }

    function it_is_renderable()
    {
        $this->subject->render()->shouldBeString();
    }

    /**
     * @param Pigeonhole $pigeonhole
     */
    function it_renders_empty_with_no_messages(Pigeonhole $pigeonhole)
    {
        $pigeonhole->has_messages()->willReturn(FALSE);
        $this->subject->render()->shouldMatch('/^\s*$/');
    }

    /**
     * @param Pigeonhole $pigeonhole
     */
    function it_renders_message_with_class_and_content(Pigeonhole $pigeonhole)
    {
        $this->given_messages($pigeonhole, new Message('title', 'message', Message::SUCCESS));

        $content = $this->subject->render();
        $content->shouldMatch('_<div class="alert alert-success">_');
        $content->shouldMatch('_<strong>title</strong>_');
        $content->shouldMatch('_</strong>\s*message\s*</div>_');
    }

    /**
     * @param Pigeonhole $pigeonhole
     */
    function it_renders_multiple_messages(Pigeonhole $pigeonhole)
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
     * @param Pigeonhole $pigeonhole
     * @param Message    $msg,...
     */
    protected function given_messages(Pigeonhole $pigeonhole, Message $msg)
    {
        $pigeonhole->has_messages()->willReturn(TRUE);

        $messages = func_get_args();
        array_shift($messages);
        $pigeonhole->clear()->willReturn($messages);
    }
}
