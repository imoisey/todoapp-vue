<?php

declare(strict_types=1);

namespace App\Auth\Test\Unit\Service;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Token;
use App\Auth\Service\JoinConfirmSender;
use App\Frontend\UrlGenerator;
use DateTimeImmutable;
use RuntimeException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Swift_Mailer;
use Swift_Message;

/**
 * @covers JoinConfirmSender
 */
class JoinConfirmSenderTest extends TestCase
{
    public function testSuccess(): void
    {
        $to = new Email('user@app.test');
        $token = new Token(Uuid::uuid4()->toString(), new DateTimeImmutable());
        $confirmUrl = 'http://test/join/confirm?token=' . $token->getValue();

        $urlGenerator = $this->createMock(UrlGenerator::class);
        $urlGenerator->expects(self::once())->method('generate')->with(
            self::equalTo('join/confirm'),
            self::equalTo(['token' => $token->getValue()]),
        )->willReturn($confirmUrl);

        $mailer = $this->createMock(Swift_Mailer::class);
        $mailer->expects(self::once())->method('send')
            ->willReturnCallback(static function (Swift_Message $message) use ($to, $confirmUrl): int {
                self::assertEquals([$to->getValue() => null], $message->getTo());
                self::assertEquals('Join Confirmation', $message->getSubject());
                self::assertStringContainsString($confirmUrl, $message->getBody());
                return 1;
            });

        $sender = new JoinConfirmSender($mailer, $urlGenerator);

        $sender->send($to, $token);
    }

    public function testError(): void
    {
        $to = new Email('user@app.test');
        $token = new Token(Uuid::uuid4()->toString(), new DateTimeImmutable());

        $urlGenerator = $this->createStub(UrlGenerator::class);
        $urlGenerator
            ->method('generate')
            ->willReturn('http://test/join/confirm?token=' . $token->getValue());

        $mailer = $this->createStub(Swift_Mailer::class);
        $mailer->method('send')->willReturn(0);

        $sender = new JoinConfirmSender($mailer, $urlGenerator);

        $this->expectException(RuntimeException::class);
        $sender->send($to, $token);
    }
}
