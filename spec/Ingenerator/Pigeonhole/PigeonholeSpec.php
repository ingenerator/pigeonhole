<?php

namespace spec\Ingenerator\Pigeonhole;

use Ingenerator\Pigeonhole\Message;
use Ingenerator\Pigeonhole\Pigeonhole;
use Session_Fake;
use spec\ObjectBehavior;

class PigeonholeSpec extends ObjectBehavior
{
    /**
     * @var Session_Fake
     */
    protected $mock_session;

    function let()
    {
        $this->mock_session = new Session_Fake;
        $this->beConstructedWith($this->mock_session);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Pigeonhole::class);
    }

    /**
     * @param Message $message
     */
    function it_adds_messages_and_stores_them(Message $message)
    {
        $this->add($message);

        $this->peek()->shouldReturn([$message]);
    }

    /**
     * @param Message $old_message
     * @param Message $new_message
     */
    function it_appends_to_existing_message_list(Message $old_message, Message $new_message)
    {
        $this->add($old_message);
        $this->add($new_message);

        $this->peek()->shouldReturn([$old_message, $new_message]);
    }

    /**
     * @param Message $message
     */
    function its_peek_method_returns_messages_without_removing(Message $message)
    {
        $this->add($message);

        $this->peek()->shouldReturn([$message]);
        $this->peek()->shouldReturn([$message]);
    }

    /**
     * @param Message $message
     */
    function its_clear_method_returns_and_removes_messages(Message $message)
    {
        $this->add($message);

        $this->clear()->shouldReturn([$message]);
        $this->clear()->shouldReturn([]);
    }

    function its_has_messages_method_returns_false_when_clear()
    {
        $this->has_messages()->shouldReturn(FALSE);
    }

    /**
     * @param Message $message
     */
    function its_has_messages_method_returns_true_with_messages(Message $message)
    {
        $this->add($message);
        $this->has_messages()->shouldReturn(TRUE);
    }

    /**
     * @param Message $message
     */
    function its_has_messages_method_returns_false_after_clear(Message $message)
    {
        $this->add($message);
        $this->clear();
        $this->has_messages()->shouldReturn(FALSE);
    }

    /**
     * @param Message $message
     */
    function it_persists_messages_in_the_session(Message $message)
    {
        $other_instance = new Pigeonhole($this->mock_session);
        $other_instance->add($message->getWrappedObject());

        $this->has_messages()->shouldReturn(TRUE);
        $this->peek()->shouldReturn([$message]);

        $other_instance->clear();
        $this->has_messages()->shouldReturn(FALSE);
    }

}
