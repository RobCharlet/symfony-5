<?php

namespace App\Tests;

use App\Entity\Comment;
use App\SpamChecker;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class SpamCheckerTest extends TestCase
{
    public function testSpamScoreWithInvalidRequest()
    {
        $comment = new Comment();
        $comment->setCreatedAtValue();
        $context = [];

        $client = new MockHttpClient([
            new MockResponse('invalid'),
            ['response_headers' => ['x-akismet-debug-help: Invalid key']]
        ]);
        $checker = new SpamChecker($client, 'abcde');

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Unable to check for spam: invalid (Invalid key).');
        $checker->getSpamScore($comment, $context);
    }

    /**
     * @dataProvider getComments
     *
     * @param int               $expectedScore
     * @param ResponseInterface $response
     * @param Comment           $comment
     * @param array             $context
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testSpamScore(
        int $expectedScore,
        ResponseInterface $response,
        Comment $comment,
        array $context
    )
    {
        $client = new MockHttpClient([$response]);
        $checker = new SpamChecker($client, 'abcde');

        $score = $checker->getSpamScore($comment, $context);
        $this->assertSame($expectedScore, $score);
    }
}
