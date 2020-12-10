<?php

declare(strict_types=1);

namespace Test\Functional\V1\Task;

use Test\Functional\Json;
use Test\Functional\WebTestCase;

class ModifyTest extends WebTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures([
            ModifyFixture::class
        ]);
    }

    public function testMethod(): void
    {
        self::markTestSkipped('Not release action.');

        $response = $this->app()->handle(self::json('GET', '/v1/task/edit'));

        self::assertEquals(405, $response->getStatusCode());
    }

    public function testSuccess(): void
    {
        self::markTestSkipped('Not release action.');

        $response = $this->app()->handle(self::json('PUT', '/v1/task/edit', [
            'id' => ModifyFixture::TASK_UUID,
            'name' => 'Modify Name Task',
            'description' => 'Modify Description Task',
        ]));

        self::assertEquals(201, $response);
    }

    public function testNotTaskId(): void
    {
        self::markTestSkipped('Not release action.');

        $response = $this->app()->handle(self::json('PUT', '/v1/task/edit', [
            'id' => '',
            'name' => 'Modify Name Task',
            'description' => 'Modify Description Task',
        ]));

        self::assertEquals(422, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertEquals([
            'errors' => [
                'id' => 'This value should not be blank.'
            ],
        ], Json::decode($body));
    }
}
