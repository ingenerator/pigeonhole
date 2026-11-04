<?php

declare(strict_types=1);

namespace test\unit\Ingenerator\Pigeonhole\Message;

use Ingenerator\Pigeonhole\Message\ValidationMessage;
use PHPUnit\Framework\TestCase;
use Validation;

class ValidationMessageTest extends TestCase
{
    public function test_it_is_initializable(): void
    {
        $validation = $this->createMock(Validation::class);
        $validation->expects($this->once())->method('errors')->with('messages')->willReturn([]);
        $subject = new ValidationMessage($validation, 'messages');
        $this->assertInstanceOf(ValidationMessage::class, $subject);
    }

    public function test_its_message_is_the_kohana_validation_errors(): void
    {
        $validation = $this->createMock(Validation::class);
        $validation->expects($this->once())->method('errors')->with('forms/foo')->willReturn([
            'field' => 'field must not be empty',
            'other' => 'other is bad',
        ]);
        $subject = new ValidationMessage($validation, 'forms/foo');
        $this->assertSame('field must not be empty'.PHP_EOL.'other is bad', $subject->message);
    }
}
