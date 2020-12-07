<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Task;

use App\Http\EmptyResponse;
use App\Http\Validator\Validator;
use App\Task\Command\Create\Command;
use App\Task\Command\Create\Handler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CreateAction implements RequestHandlerInterface
{
    private Handler $handler;
    private Validator $validator;

    public function __construct(Handler $handler, Validator $validator)
    {
        $this->handler = $handler;
        $this->validator = $validator;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var array{author:?string, name:?string, description:?string} $data */
        $data = $request->getParsedBody();

        $command = new Command();
        $command->author = $data['author'] ?? '';
        $command->name = $data['name'] ?? '';
        $command->description = $data['description'] ?? '';

        $this->validator->validate($command);

        $this->handler->handle($command);

        return new EmptyResponse(201);
    }
}
