<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Shared\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ServiceManagerAwareControllerFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        $controller = new $requestedName($container);
        return $controller;
    }
}
