<?php

declare(strict_types=1);

namespace test\unit\Ingenerator\Pigeonhole\Message;

use Ingenerator\Pigeonhole\Message;
use Ingenerator\Pigeonhole\Message\KohanaMessage;
use PHPUnit\Framework\TestCase;

class KohanaMessageTest extends TestCase
{
    public function test_it_is_initializable(): void
    {
        $this->assertInstanceOf(KohanaMessage::class, $this->newSubject());
    }

    private function newSubject(): KohanaMessage
    {
        return new KohanaMessage('foo', 'bar', [], Message::SUCCESS);
    }
}
