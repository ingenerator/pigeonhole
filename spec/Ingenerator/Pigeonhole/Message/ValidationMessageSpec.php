<?php

namespace spec\Ingenerator\Pigeonhole\Message;

use spec\ObjectBehavior;
use Prophecy\Argument;

class ValidationMessageSpec extends ObjectBehavior
{
    /**
     * @var \Ingenerator\Pigeonhole\Message\ValidationMessage
     */
    protected $subject;
    
    /**
     * @param \Validation $validation
     */
    function let($validation)
    {
      $this->beConstructedWith($validation, 'messages');
      $validation->errors('messages')->willReturn(array());
    }

    function it_is_initializable()
    {
        $this->subject->shouldHaveType('Ingenerator\Pigeonhole\Message\ValidationMessage');
    }

    /**
     * @param \Validation $validation
     */
    function its_message_is_the_kohana_validation_errors($validation)
    {
      $this->beConstructedWith($validation, 'forms/foo');
      $validation->errors('forms/foo')->willReturn(array('field' => 'field must not be empty', 'other' => 'other is bad'));
      $this->subject->message->shouldBe('field must not be empty'.PHP_EOL.'other is bad');
    }
}
