<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Admin;

use Admin\Controller\AuthController;
use Admin\Controller\IndexController;
use Zend\Router\Http\Literal;

return [
    'router' => [
        'routes' => [
            'admin' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/admin',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'dashboard',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'login' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/connexion',
                            'defaults' => [
                                'controller' => AuthController::class,
                                'action' => 'login',
                            ],

                        ]
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];