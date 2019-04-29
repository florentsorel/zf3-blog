<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Application\Model\Application\Query\Post;

class ListPostRequest
{
    /** @var int */
    private $currentPage;

    /**
     * @param int $currentPage
     */
    public function __construct(int $currentPage)
    {
        $this->currentPage = $currentPage;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }
}
