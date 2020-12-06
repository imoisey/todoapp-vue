<?php

declare(strict_types=1);

namespace Test\Functional\V1\Task;

use Test\Functional\WebTestCase;

class CreateTest extends WebTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures([
            CreateFixture::class
        ]);
    }

    public function testMethod(): void
    {
        self::markTestIncomplete('Not release.');

        $response = $this->app()->handle(self::json('GET', '/v1/task/create'));

        self::assertEquals(405, $response->getStatusCode());
    }

    public function testSuccess(): void
    {
        self::markTestIncomplete('Not release.');

        $response = $this->app()->handle(self::json('POST', '/v1/task/create', [
            'author' => CreateFixture::USER_UUID,
            'name' => 'New Task',
            'description' => 'Description Task',
        ]));

        self::assertEquals(201, $response->getStatusCode(), (string)$response->getBody());
        self::assertEquals('', (string)$response->getBody());
    }
}
