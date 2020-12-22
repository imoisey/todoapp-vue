<?php

declare(strict_types=1);

namespace App\Task\Entity\Task\Event;

use App\Event\Event;
use App\Task\Entity\Task\Id;

class TaskWasDeleted implements Event
{
    public Id $id;

    public function __construct(Id $id)
    {
        $this->id = $id;
    }
}
