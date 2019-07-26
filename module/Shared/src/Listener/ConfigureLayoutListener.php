<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Shared\Listener;

use Zend\Authentication\AuthenticationService;
use Zend\Console\Request as ConsoleRequest;
use Zend\Console\RouteMatcher\RouteMatcherInterface as ConsoleRouteMatch;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\Router\RouteMatch;
use Zend\ServiceManager\ServiceManager;

/**
 * @package zf3-blog
 * @author Rtransat
 */

class ConfigureLayoutListener extends AbstractListenerAggregate
{
    /** @var \Zend\ServiceManager\ServiceManager */
    private $serviceManager;

    /** @var string */
    private $appVersion;

    /** @var bool */
    private $isLayoutConfigured;

    /** @var \Shared\Model\Infrastructure\Authentication\Identity */
    private $identity;

    /**
     * @param \Zend\ServiceManager\ServiceManager $serviceManager
     */
    public function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        $this->isLayoutConfigured = false;

        $config = $serviceManager->get('config');
        $this->appVersion = $config['app']['version'];
        unset($config);
    }

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_DISPATCH,
            [$this, 'initializeLayout'],
            $priority
        );

        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_DISPATCH_ERROR,
            [$this, 'initializeLayout'],
            $priority
        );
    }

    /**
     * @param \Zend\Mvc\MvcEvent $event
     */
    public function initializeLayout(MvcEvent $event)
    {
        // Empêche le layout d'être configuré plusieurs fois
        // Cela peut se produire lorsque MvcEvent::EVENT_DISPATCH_ERROR est
        // déclenché après MvcEvent::EVENT_DISPATCH
        if ($this->isLayoutConfigured) {
            return;
        }
        $this->isLayoutConfigured = true;

        // Ne configure pas le layout en contexte console
        if ($event->getRequest() instanceof ConsoleRequest
            || $event->getRouteMatch() instanceof ConsoleRouteMatch
        ) {
            return;
        }

        // Récupère l'utilisateur connecté
        /* @var $identity \Shared\Model\Infrastructure\Authentication\Identity */
        $this->identity = $this->serviceManager
            ->get(AuthenticationService::class)
            ->getIdentity();

        // Si la route demandée n'existe pas, configure le layout Application
        if (! $event->getRouteMatch() instanceof RouteMatch) {
            $this->configureApplicationLayout($event);
            return;
        }

        // Sinon configure la layout en fonction de la route
        $routeParts = explode('/', $event->getRouteMatch()->getMatchedRouteName());
        if ($routeParts[0] === 'admin' && isset($routeParts[1]) && $routeParts[1] === 'login') {
            $this->configureApplicationLayout($event);
        } elseif ($routeParts[0] === 'admin') {
            $this->configureAdminLayout($event);
        } else {
            $this->configureApplicationLayout($event);
        }
    }

    /**
     * @param \Zend\Mvc\MvcEvent $event
     */
    private function configureApplicationLayout(MvcEvent $event)
    {
        $layoutViewModel = $event->getViewModel();
        $layoutViewModel->setTemplate('layout/application');
        $layoutViewModel->setVariable('identity', $this->identity);
        $layoutViewModel->setVariable('appVersion', $this->appVersion);

        $viewHelperManager = $this->serviceManager->get('ViewHelperManager');

        $viewHelperManager->get('headLink')
            ->headLink([
                'rel' => 'icon',
                'type' => 'image/png',
                'href' => "/{$this->appVersion}/favicon.png",
            ])
            ->appendStylesheet("/{$this->appVersion}/css/application.css")
            ->setAutoEscape(false);

        $viewHelperManager->get('headScript')
            ->appendFile("/{$this->appVersion}/js/application.js")
            ->setAutoEscape(false);

        $viewHelperManager->get('headTitle')
            ->setSeparator(' - ')
            ->append('Blog')
            ->setAutoEscape(false);
    }

    /**
     * @param \Zend\Mvc\MvcEvent $event
     */
    private function configureAdminLayout(MvcEvent $event)
    {
        $layoutViewModel = $event->getViewModel();
        $layoutViewModel->setTemplate('layout/admin');
        $layoutViewModel->setVariable('identity', $this->identity);
        $layoutViewModel->setVariable('appVersion', $this->appVersion);

        $viewHelperManager = $this->serviceManager->get('ViewHelperManager');

        $viewHelperManager->get('headLink')
            ->headLink([
                'rel' => 'icon',
                'type' => 'image/png',
                'href' => "/{$this->appVersion}/favicon.png",
            ])
            ->appendStylesheet("/{$this->appVersion}/css/application.css")
            ->setAutoEscape(false);

        $viewHelperManager->get('headScript')
            ->appendFile("/{$this->appVersion}/js/application.js")
            ->setAutoEscape(false);

        $viewHelperManager->get('headTitle')
            ->setSeparator(' - ')
            ->append('Admin Blog')
            ->setAutoEscape(false);
    }
}
