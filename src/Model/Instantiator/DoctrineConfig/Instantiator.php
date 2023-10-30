<?php

namespace Biig\Component\Domain\Model\Instantiator\DoctrineConfig;

use Biig\Component\Domain\Event\DomainEventDispatcherInterface;
use Doctrine\Instantiator\InstantiatorInterface;

/**
 * Decorates the Doctrine standard instantiator to add new behavior.
 */
class Instantiator implements InstantiatorInterface
{
    /**
     * @var DomainEventDispatcherInterface
     */
    private $dispatcher;

    public function __construct(DomainEventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function instantiate(string $className): object
    {
        $object = new $className();
        $this->injectDispatcher($object);

        return $object;
    }

    protected function injectDispatcher($object)
    {
        if ($object instanceof ModelInterface) {
            $object->setDispatcher($this->dispatcher);
        }
    }
}
