<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */


namespace Admin;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;

class Module implements
    BootstrapListenerInterface,
    ConfigProviderInterface,
    ServiceProviderInterface,
    ControllerProviderInterface,
    ViewHelperProviderInterface
{

    public function getConfig()
    {
        return require __DIR__ . '/../config/module.config.php';
    }

    public function getControllerConfig()
    {
        return require __DIR__ . '/../config/controllers.config.php';
    }

    public function getServiceConfig()
    {
        return require __DIR__ . '/../config/services.config.php';
    }

    public function getViewHelperConfig()
    {
        return require __DIR__ . '/../config/view-helpers.config.php';
    }

    public function onBootstrap(EventInterface $event)
    {
        //
    }


}
