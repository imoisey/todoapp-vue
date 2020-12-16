<?php

declare(strict_types=1);

namespace App\Event;

trait EventTrait
{
    /**
     * @var Event[]
     */
    private array $events = [];

    protected function recordEvent(Event $event): void
    {
        $this->events[] = $event;
    }

    /**
     * @return Event[]
     */
    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}
