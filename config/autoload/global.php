<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

use Zend\Log\Filter\Priority;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;

return [
    'app' => [
        'name' => 'ZF3 Blog',
        'version' => file_get_contents('./VERSION')
    ],
    'db' => [
        'driver' => 'pdo_mysql',
        'dsn' => 'mysql:dbname=' . getenv('DB_NAME') . ';host=' . getenv('DB_HOST'),
        'username' => getenv('DB_USERNAME'),
        'password' => getenv('DB_PASSWORD'),
        'driver_options' => [
            1002 => 'SET NAMES \'UTF8\'',
        ],
    ],
    'log' => [
        'Log\Error' => [
            'writers' => [
                [
                    'name' => Stream::class,
                    'priority' => 1,
                    'options'  => [
                        'stream' => 'log/php/error.log',
                        'filters' => [
                            [
                                'name' => Priority::class,
                                'options' => [
                                    'priority' => Logger::ERR,
                                    'operator' => '<='
                                ],
                            ],
                        ],
                        'formatter' => [
                            'name' => 'simple',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => false,
        'display_exceptions' => false,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'layout' => 'layout/application',
        'template_map' => [
            'error/404' => __DIR__ . '/../../module/Shared/view/error/404.phtml',
            'error/index' => __DIR__ . '/../../module/Shared/view/error/index.phtml',
            'pagination' => __DIR__ . '/../../module/Shared/view/partial/pagination.phtml',
        ],
    ],
];
