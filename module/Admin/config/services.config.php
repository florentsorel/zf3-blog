<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Admin;

return [
    'invokables' => [
        Model\Application\Query\Auth\BuildLoginForm::class,
    ],
    'factories' => [
        Model\Application\Query\Auth\AuthenticateAdmin::class => Model\Application\Query\Auth\AuthenticateAdminFactory::class,
    ]
];