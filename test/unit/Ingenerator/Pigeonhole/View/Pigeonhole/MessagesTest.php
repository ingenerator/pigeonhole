<?php

declare(strict_types=1);

namespace test\unit\Ingenerator\Pigeonhole\View\Pigeonhole;

use Ingenerator\Pigeonhole\Message;
use Ingenerator\Pigeonhole\Pigeonhole;
use PHPUnit\Framework\TestCase;
use View;

class MessagesTest extends TestCase
{

    private $pigeonhole;

    public function test_it_is_initializable(): void
    {
        $this->assertInstanceOf(View::class, $this->newSubject());
    }

    public function test_it_is_renderable(): void
    {
        $this->assertIsString($this->newSubject()->render());
    }

    public function test_it_renders_empty_with_no_messages(): void
    {
        $this->pigeonhole = $this->createMock(Pigeonhole::class);
        $this->pigeonhole->expects($this->once())->method('has_messages')->willReturn(FALSE);

        $this->assertMatchesRegularExpression('/^\s*$/', $this->newSubject()->render());
    }

    public function test_it_renders_message_with_class_and_content(): void
    {
        $this->pigeonhole = $this->createPigeonholeWithMessages(new Message('title', 'message', Message::SUCCESS));

        $content = $this->newSubject()->render();
        $this->assertMatchesRegularExpression('_<div class="alert alert-success">_', $content);
        $this->assertMatchesRegularExpression('_<strong>title</strong>_', $content);
        $this->assertMatchesRegularExpression('_</strong>\s*message\s*</div>_', $content);
    }

    public function test_it_renders_multiple_messages(): void
    {
        $this->pigeonhole = $this->createPigeonholeWithMessages(
            new Message('title1', 'message', Message::SUCCESS),
            new Message('title2', 'message', Message::SUCCESS)
        );

        $content = $this->newSubject()->render();
        $this->assertMatchesRegularExpression('/title1.+?title2/s', $content);
    }

    private function createPigeonholeWithMessages(Message ...$messages): Pigeonhole
    {
        $pigeonhole = $this->createMock(Pigeonhole::class);
        $pigeonhole->expects($this->once())->method('has_messages')->willReturn(TRUE);
        $pigeonhole->expects($this->once())->method('clear')->willReturn($messages);

        return $pigeonhole;
    }

    private function newSubject(): View
    {
        return new View(
            'pigeonhole/messages',
            ['pigeonhole' => $this->pigeonhole]
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->pigeonhole = $this->createStub(Pigeonhole::class);
    }


}
