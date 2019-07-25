<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Shared\View\Helper\Factory;

use Interop\Container\ContainerInterface;
use Shared\View\Helper\FlashMessages;
use Zend\Mvc\Controller\PluginManager;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Zend\ServiceManager\Factory\FactoryInterface;

class FlashMessagesFactory implements FactoryInterface
{

    /**
     * @param  \Interop\Container\ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return \Shared\View\Helper\FlashMessages
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        $mvcPLuginManager = $container->get(PluginManager::class);

        return new FlashMessages(
            $mvcPLuginManager->get(FlashMessenger::class)
        );
    }
}