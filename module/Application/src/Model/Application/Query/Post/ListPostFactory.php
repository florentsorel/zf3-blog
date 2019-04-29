<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Application\Model\Application\Query\Post;

use Application\Model\Infrastructure\Finder\Post\PostViewFinder;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ListPostFactory implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return \Application\Model\Application\Query\Post\ListPost
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        return new ListPost(
            $container->get(PostViewFinder::class)
        );
    }
}
