<?php

namespace spec\Ingenerator\Pigeonhole\Message;

use Ingenerator\Pigeonhole\Message;
use Ingenerator\Pigeonhole\Message\KohanaMessage;
use spec\ObjectBehavior;

class KohanaMessageSpec extends ObjectBehavior
{
    /**
     * @var KohanaMessage
     */
    protected $subject;

    function it_is_initializable()
    {
        $this->beConstructedWith('foo', 'bar', [], Message::SUCCESS);
        $this->subject->shouldHaveType(KohanaMessage::class);
    }

}
