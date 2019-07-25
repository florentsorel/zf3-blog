<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Shared\Listener;

use Shared\Model\Domain\User\Role;
use Zend\Authentication\AuthenticationService;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\Router\RouteMatch;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ResponseInterface;

class CheckAuthorizationListener extends AbstractListenerAggregate
{

    /** @var \Zend\ServiceManager\ServiceManager */
    private $serviceManager;

    /**
     * @param \Zend\ServiceManager\ServiceManager $serviceManager
     */
    public function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * {@inheritDoc}
     */
    public function attach(
        EventManagerInterface $events,
        $priority = 1
    ) {
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_ROUTE,
            [$this, 'checkAccessToRoute'],
            $priority
        );
    }

    /**
     * Vérifie que le compte utilisateur authentifié a accès à la route demandée
     *
     * @param MvcEvent $event
     * @return null|ResponseInterface|\Zend\View\Model\ModelInterface
     */
    public function checkAccessToRoute(MvcEvent $event)
    {
        // Vérifie que la route demandée existe
        if (! $event->getRouteMatch() instanceof RouteMatch) {
            return null;
        }

        // Regarde si l'utilisateur courant a accès à la route
        /** @var AuthenticationService $authentication */
        $authentication = $this->serviceManager->get(
            AuthenticationService::class
        );

        $routeName = $event->getRouteMatch()->getMatchedRouteName();
        $routeFirstPart = explode('/', $routeName)[0];

        if ($routeFirstPart === 'admin' && $authentication->hasIdentity() === false) {
            if ($routeName === 'admin/login') {
                return $event->getViewModel();
            }

            $event->getResponse()
                ->getHeaders()
                ->addHeaderLine('Location', '/admin/connexion');

            $event->getResponse()->setStatusCode(302);
            return $event->getResponse();
        } elseif ($authentication->hasIdentity() === false) {
            $roleId = Role::GUEST;
        } else {
            $roleId = $authentication->getIdentity()->getRoleId();
        }

        if (! $this->isAllowed($roleId, $routeName)) {
            $url = $event->getRouter()->assemble(
                [],
                [
                    'name' => $this->determineRedirectRouteFromRole($roleId)
                ]
            );
            $event->getResponse()
                ->getHeaders()
                ->addHeaderLine('Location', $url);
            $event->getResponse()->setStatusCode(302);

            return $event->getResponse();
        }
    }

    /**
     * @param null|int $roleId
     * @param string $routeName
     *
     * @return bool
     */
    private function isAllowed($roleId, $routeName)
    {
        $routeFirstPart = explode('/', $routeName)[0];

        // Admin : bloque l'accès aux utilisateurs hors administrateurs
        if ($routeFirstPart === 'admin'
            && $roleId !== Role::ADMINISTRATOR
        ) {
            return false;
        }

        // Compte utilisateur : bloque l'accès aux utilisateurs déconnectés
        if ($routeFirstPart === 'profile'
            && $roleId < 1
        ) {
            return false;
        }

        // Routes accessibles en étant déconnecté, et bloquées une fois connecté
        $unauthenticatedRoutes = [
            'admin/login' => true,
        ];

        // Refuse l'accès aux utilisateurs connectés (n'importe quel rôle)
        // aux routes publiques type inscription, activation de compte, etc.
        if ($roleId > 0
            && array_key_exists($routeName, $unauthenticatedRoutes)
        ) {
            return false;
        }

        return true;
    }

    /**
     * Determine la route vers laquelle sera redirigé l'utilisateur dans le cas
     * où il tente d'accéder à une ressource dont il n'a pas les droits
     *
     * @param string $role
     * @return string
     */
    private function determineRedirectRouteFromRole($role)
    {
        if ($role < 0) {
            return 'application';
        } elseif ($role === Role::USER) {
            return 'application';
        } elseif ($role === Role::ADMINISTRATOR) {
            return 'admin';
        }

        return 'application';
    }

}