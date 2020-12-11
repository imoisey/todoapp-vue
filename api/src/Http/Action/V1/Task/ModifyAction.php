<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Task;

use App\Http\EmptyResponse;
use App\Http\Validator\Validator;
use App\Task\Command\Modify\Command;
use App\Task\Command\Modify\Handler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ModifyAction implements RequestHandlerInterface
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
        /** @var array{id:?string, name:?string, description:?string} $data */
        $data = $request->getParsedBody();

        $command = new Command();
        $command->id = $data['id'] ?? '';
        $command->name = $data['name'] ?? '';
        $command->description = $data['description'] ?? '';

        $this->validator->validate($command);

        $this->handler->handle($command);

        return new EmptyResponse(201);
    }
}
