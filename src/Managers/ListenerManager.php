<?php

namespace Railken\Amethyst\Managers;

use Illuminate\Support\Facades\Config;
use Railken\Lem\Manager;

class ListenerManager extends Manager
{
    /**
     * Describe this manager.
     *
     * @var string
     */
    public $comment = '...';

    /**
     * Register Classes.
     */
    public function registerClasses()
    {
        return Config::get('amethyst.listener.managers.listener');
    }

    /**
     * Retrieve all events_class available.
     *
     * @return array
     */
    public function getAvailableEventClasses()
    {
        /** @var \Railken\Amethyst\Repositories\ListenerRepository */
        $repository = $this->getRepository();

        return $repository->newQuery()->get()->map(function ($v) {
            return $v->event_class;
        })->toArray();
    }
}
