<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Application;

use Application\Model\Application\Query\Post\ListPost;
use Application\Model\Application\Query\Post\ListPostFactory;
use Application\Model\Infrastructure\Finder\Post\PostViewFinder;
use Application\Model\Infrastructure\Finder\Post\PostViewFinderFactory;

return [
    'factories' => [
        // Query
        ListPost::class => ListPostFactory::class,
        // Finder
        PostViewFinder::class => PostViewFinderFactory::class
    ]
];
