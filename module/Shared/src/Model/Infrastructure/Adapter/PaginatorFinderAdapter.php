<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Shared\Model\Infrastructure\Adapter;

use Shared\Model\Infrastructure\Finder\PaginatorFinderInterface;
use Zend\Paginator\Adapter\AdapterInterface;

class PaginatorFinderAdapter implements AdapterInterface
{
    /** @var \Shared\Model\Infrastructure\Finder\PaginatorFinderInterface */
    private $finder;

    /**
     * @param \Shared\Model\Infrastructure\Finder\PaginatorFinderInterface $finder
     */
    public function __construct(PaginatorFinderInterface $finder)
    {
        $this->finder = $finder;
    }

    /**
     * Returns a collection of items for a page.
     *
     * @param int $offset Page offset
     * @param int $itemCountPerPage Number of items per page
     * @return array
     */
    public function getItems($offset, $itemCountPerPage)
    {
        $collection = $this->finder->paginate($offset, $itemCountPerPage);
        return $collection->toArray();
    }

    /**
     * Count elements of an object
     *
     * @link https://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return $this->finder->count();
    }
}
