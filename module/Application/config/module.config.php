<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'application' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/[?page=:page]',
                    'defaults' => [
                        'page' => 1,
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'logout' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/deconnexion',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action' => 'logout',
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
