<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Application\Model\Application\Query\Post;

use Application\Model\Infrastructure\Finder\Post\PostViewFinder;
use Shared\Model\Infrastructure\Adapter\PaginatorFinderAdapter;
use Zend\Paginator\Paginator;

class ListPost
{
    /** @var \Application\Model\Infrastructure\Finder\Post\PostViewFinder */
    private $postViewFinder;

    /**
     * @param \Application\Model\Infrastructure\Finder\Post\PostViewFinder $postViewFinder
     */
    public function __construct(PostViewFinder $postViewFinder)
    {
        $this->postViewFinder = $postViewFinder;
    }

    /**
     * @param \Application\Model\Application\Query\Post\ListPostRequest $request
     * @return \Application\Model\Application\Query\Post\ListPostResponse
     */
    public function handle(ListPostRequest $request): ListPostResponse
    {
        $paginator = new Paginator(
            new PaginatorFinderAdapter(
                $this->postViewFinder
            )
        );

        $postPerPage = ! empty(getenv('POST_PER_PAGE'))
            ? getenv('POST_PER_PAGE')
            : 10;
        $paginator->setItemCountPerPage($postPerPage);

        $paginator->setCurrentPageNumber(
            $request->getCurrentPage()
        );

        return new ListPostResponse($paginator);
    }
}
