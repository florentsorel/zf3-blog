<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Admin;

use Shared\Controller\ServiceManagerAwareControllerFactory;

return [
    'factories' => [
        Controller\IndexController::class => ServiceManagerAwareControllerFactory::class,
        Controller\AuthController::class => ServiceManagerAwareControllerFactory::class
    ],
];