<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Shared\Model\Infrastructure\Repository\Factory\User;

use Interop\Container\ContainerInterface;
use Shared\Model\Infrastructure\Hydrator\Sql\User\SqlUserHydrator;
use Shared\Model\Infrastructure\Repository\Sql\User\SqlUserRepository;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserRepositoryFactory implements FactoryInterface
{

    /**
     * @param  \Interop\Container\ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        return new SqlUserRepository(
            $container->get('db'),
            new SqlUserHydrator()
        );
    }
}