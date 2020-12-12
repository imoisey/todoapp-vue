<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Task;

use App\Http\EmptyResponse;
use App\Http\Validator\Validator;
use App\Task\Command\Execute\Command;
use App\Task\Command\Execute\Handler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ExecuteAction implements RequestHandlerInterface
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
        /** @var array{id:?string} $data */
        $data = $request->getParsedBody();

        $command = new Command();
        $command->id = $data['id'] ?? '';

        $this->validator->validate($command);

        $this->handler->handle($command);

        return new EmptyResponse(201);
    }
}
