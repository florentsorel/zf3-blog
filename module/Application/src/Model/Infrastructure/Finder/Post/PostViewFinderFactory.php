<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Application\Model\Infrastructure\Finder\Post;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class PostViewFinderFactory implements FactoryInterface
{

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return \Application\Model\Infrastructure\Finder\Post\PostViewFinder
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ): PostViewFinder {
        return new PostViewFinder(
            $container->get('db')
        );
    }
}
