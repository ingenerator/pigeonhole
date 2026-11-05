<?php

declare(strict_types=1);

namespace test\unit\Ingenerator\Pigeonhole;

use Ingenerator\Pigeonhole\Message;
use Ingenerator\Pigeonhole\Pigeonhole;
use PHPUnit\Framework\TestCase;
use Session_Array;

class PigeonholeTest extends TestCase
{
    private Session_Array $session;

    protected function setUp(): void
    {
        parent::setUp();
        $this->session = new Session_Array();
    }

    private function newSubject(): Pigeonhole
    {
        return new Pigeonhole($this->session);
    }

    public function test_it_is_initializable(): void
    {
        $this->assertInstanceOf(Pigeonhole::class, $this->newSubject());
    }

    public function test_it_adds_messages_and_stores_them(): void
    {
        $message = new Message('title', 'msg', Message::SUCCESS);
        $this->newSubject()->add($message);

        $this->assertSame([$message], $this->newSubject()->peek());
    }

    public function test_it_appends_to_existing_message_list(): void
    {
        $old_message = new Message('old', 'msg', Message::SUCCESS);
        $new_message = new Message('new', 'msg', Message::SUCCESS);

        $subject = $this->newSubject();
        $subject->add($old_message);
        $subject->add($new_message);

        $this->assertSame([$old_message, $new_message], $subject->peek());
    }

    public function test_its_peek_method_returns_messages_without_removing(): void
    {
        $message = new Message('title', 'msg', Message::SUCCESS);
        $subject = $this->newSubject();
        $subject->add($message);

        $this->assertSame([$message], $subject->peek());
        $this->assertSame([$message], $subject->peek());
    }

    public function test_its_clear_method_returns_and_removes_messages(): void
    {
        $message = new Message('title', 'msg', Message::SUCCESS);
        $subject = $this->newSubject();
        $subject->add($message);

        $this->assertSame([$message], $subject->clear());
        $this->assertSame([], $subject->clear());
    }

    public function test_its_has_messages_method_returns_false_when_clear(): void
    {
        $this->assertFalse($this->newSubject()->has_messages());
    }

    public function test_its_has_messages_method_returns_true_with_messages(): void
    {
        $message = new Message('title', 'msg', Message::SUCCESS);
        $subject = $this->newSubject();
        $subject->add($message);
        $this->assertTrue($subject->has_messages());
    }

    public function test_its_has_messages_method_returns_false_after_clear(): void
    {
        $message = new Message('title', 'msg', Message::SUCCESS);

        $subject = $this->newSubject();
        $subject->add($message);
        $subject->clear();
        $this->assertFalse($subject->has_messages());
    }

    public function test_it_persists_messages_in_the_session(): void
    {
        $message        = new Message('title', 'msg', Message::SUCCESS);
        $other_instance = $this->newSubject();
        $other_instance->add($message);

        $subject = $this->newSubject();

        $this->assertTrue($subject->has_messages());
        $this->assertSame([$message], $subject->peek());

        $other_instance->clear();
        $this->assertFalse($subject->has_messages());
    }
}
