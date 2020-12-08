<?php

declare(strict_types=1);

namespace Test\Functional\V1\Task;

use Test\Functional\Json;
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
        $response = $this->app()->handle(self::json('GET', '/v1/task/create'));

        self::assertEquals(405, $response->getStatusCode());
    }

    public function testSuccess(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/task/create', [
            'author' => CreateFixture::USER_UUID,
            'name' => 'New Task',
            'description' => 'Description Task',
        ]));

        self::assertEquals(201, $response->getStatusCode(), (string)$response->getBody());
        self::assertEquals('', (string)$response->getBody());
    }

    public function testEmpty(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/task/create', []));

        self::assertEquals(422, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        self::assertEquals([
            'errors' => [
                'author' => 'This value should not be blank.',
                'name' => 'This value is too short. It should have 3 characters or more.'
            ]
        ], Json::decode($body));
    }

    public function testNotExisting(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/task/create', [
            'author' => 'not-uuid',
            'name' => '',
        ])->withHeader('Accept-Language', 'es;q=0.9, ru;q=0.8, *;q=0.5'));

        self::assertEquals(422, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        $data = Json::decode($body);

        self::assertEquals([
            'errors' => [
                'author' => 'Значение не соответствует формату UUID.',
                'name' => 'Значение слишком короткое. Должно быть равно 3 символам или больше.'
            ],
        ], $data);
    }
}
