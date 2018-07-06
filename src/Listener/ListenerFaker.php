<?php

namespace Railken\LaraOre\Listener;

use Railken\Bag;
use Faker\Factory;
use Railken\LaraOre\Work\WorkFaker;
use Railken\Laravel\Manager\BaseFaker;

class ListenerFaker extends BaseFaker
{
    /**
     * @var string
     */
    protected $manager = ListenerManager::class;

    /**
     * @return \Railken\Bag
     */
    public function parameters()
    {
        $faker = Factory::create();
        
        $bag = new Bag();
        $bag->set('name', 'El. psy. congroo. '.microtime(true));
        $bag->set('condition', '{{ message is not empty ? 1 : 0 }}');
        $bag->set('work', WorkFaker::make()->parameters()->toArray());
        $bag->set('event_class', 'Dummy');

        return $bag;
    }
}
