<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Language;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Validator\AbstractValidator;

class Module implements
    BootstrapListenerInterface,
    ConfigProviderInterface,
    ServiceProviderInterface
{

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return require __DIR__ . '/../config/module.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceConfig()
    {
        return require __DIR__ . '/../config/services.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function onBootstrap(EventInterface $event)
    {
        // Configuration de la traduction des validateurs
        AbstractValidator::setDefaultTranslator(
            $event->getApplication()->getServiceManager()->get('MvcTranslator')
        );
    }


}
