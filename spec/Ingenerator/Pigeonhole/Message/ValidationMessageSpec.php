<?php

namespace spec\Ingenerator\Pigeonhole\Message;

use Ingenerator\Pigeonhole\Message\ValidationMessage;
use spec\ObjectBehavior;
use Validation;

class ValidationMessageSpec extends ObjectBehavior
{
    /**
     * @var ValidationMessage
     */
    protected $subject;

    function it_is_initializable()
    {
        $this->subject->shouldHaveType(ValidationMessage::class);
    }

    /**
     * @param Validation $validation
     */
    function its_message_is_the_kohana_validation_errors(Validation $validation)
    {
        $this->beConstructedWith($validation, 'forms/foo');
        $validation->errors('forms/foo')->willReturn(['field' => 'field must not be empty', 'other' => 'other is bad']);
        $this->subject->message->shouldBe('field must not be empty'.PHP_EOL.'other is bad');
    }

    /**
     * @param Validation $validation
     */
    function let(Validation $validation)
    {
        $this->beConstructedWith($validation, 'messages');
        $validation->errors('messages')->willReturn([]);
    }
}
