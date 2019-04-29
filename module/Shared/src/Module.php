<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */


namespace Shared;

use Shared\Listener\ConfigureLayoutListener;
use Zend\EventManager\EventInterface;
use Zend\I18n\View\Helper\Plural;
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
        $eventManager = $event->getApplication()->getEventManager();
        $serviceManager = $event->getApplication()->getServiceManager();

        // Enregistre le listener qui gère la configuration du layout
        $configureLayoutListener = new ConfigureLayoutListener($serviceManager);
        $configureLayoutListener->attach($eventManager, 2);

        /* @var $pluralViewHelper \Zend\I18n\View\Helper\Plural */
        $pluralViewHelper = $serviceManager
            ->get('ViewHelperManager')
            ->get(Plural::class);
        $pluralViewHelper->setPluralRule('nplurals=2; plural=(n==0 || n==1 ? 0 : 1)');
    }
}
