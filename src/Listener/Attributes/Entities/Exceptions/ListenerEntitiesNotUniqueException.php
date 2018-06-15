<?php

namespace Railken\LaraOre\Listener\Attributes\Entities\Exceptions;

use Railken\LaraOre\Listener\Exceptions\ListenerAttributeException;

class ListenerEntitiesNotUniqueException extends ListenerAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'entities';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'LISTENER_ENTITIES_NOT_UNIQUE';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is not unique';
}