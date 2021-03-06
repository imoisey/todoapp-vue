<?php

declare(strict_types=1);

namespace Test\Functional\V1\Task;

use Test\Functional\Json;
use Test\Functional\WebTestCase;

class CompleteTest extends WebTestCase
{
    public const NOT_EXIST_TASK_ID = '00000000-0000-1000-8000-000000000000';

    public function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures([
            CompleteFixture::class
        ]);
    }

    public function testMethod(): void
    {
        $response = $this->app()->handle(self::json('GET', '/v1/task/complete', []));

        self::assertEquals(405, $response->getStatusCode());
    }

    public function testSuccess(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/task/complete', [
            'id' => CompleteFixture::TASK_ID
        ]));

        self::assertEquals(201, $response->getStatusCode());
    }

    public function testEmpty(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/task/complete', []));

        self::assertEquals(422, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertEquals([
            'errors' => [
                'id' => 'This value should not be blank.'
            ],
        ], Json::decode($body));
    }

    public function testNotExist(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/task/complete', [
            'id' => self::NOT_EXIST_TASK_ID
        ]));

        self::assertEquals(409, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertEquals([
            'message' => 'Task not found.'
        ], Json::decode($body));
    }
}
