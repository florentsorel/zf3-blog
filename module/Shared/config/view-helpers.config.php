<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Shared;

use Shared\View\Helper\Factory\FlashMessagesFactory;
use Shared\View\Helper\FormElementError;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'factories' => [
        'flashMessages' => FlashMessagesFactory::class,
        FormElementError::class => InvokableFactory::class,
    ],
    'aliases' => [
        'formElementError' => \Shared\View\Helper\FormElementError::class,
    ]
];
