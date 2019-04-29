<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Application\Model\Application\Query\Post;

use Zend\Paginator\Paginator;

class ListPostResponse
{
    /** @var \Zend\Paginator\Paginator */
    private $paginator;

    /**
     * @param \Zend\Paginator\Paginator $paginator
     */
    public function __construct(Paginator $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @return \Zend\Paginator\Paginator
     */
    public function getPaginator(): Paginator
    {
        return $this->paginator;
    }
}
