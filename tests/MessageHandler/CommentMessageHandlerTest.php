<?php


namespace App\Tests\MessageHandler;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentMessageHandlerTest extends WebTestCase
{
    /*public function testMailerAssertions()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertEmailCount(1);

        $event = $this->getMailerEvent(0);
        $this->assertEmailIsQueued($event);

        $email = $this->getMailerMessage(0);
        $this->assertEmailHeaderSame($email, 'to', 'robin.charlet@laposte.net');
        $this->assertEmailTextBodyContains($email, 'Bar');
        $this->assertEmailAttachmentCount($email, 1);
    }*/

}