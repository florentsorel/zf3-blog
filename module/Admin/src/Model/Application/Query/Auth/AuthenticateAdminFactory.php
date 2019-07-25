<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Admin\Model\Application\Query\Auth;

use Interop\Container\ContainerInterface;
use Shared\Model\Domain\User\UserRepository;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Factory\FactoryInterface;

class AuthenticateAdminFactory implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return \Admin\Model\Application\Query\Auth\AuthenticateAdmin
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new AuthenticateAdmin(
            $container->get(AuthenticationService::class),
            $container->get(UserRepository::class)
        );
    }
}
