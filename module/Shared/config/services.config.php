<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Shared;

use Zend\Db\Adapter\Adapter;

return [
    'aliases' => [
        'db' => Adapter::class,
    ],
    'invokables' => [
        \Zend\Authentication\AuthenticationService::class,
        Model\Infrastructure\Authentication\Storage::class,
    ],
    'factories' => [
        // Repository
        Model\Domain\User\UserRepository::class => Model\Infrastructure\Repository\Factory\User\UserRepositoryFactory::class,
    ]
];
