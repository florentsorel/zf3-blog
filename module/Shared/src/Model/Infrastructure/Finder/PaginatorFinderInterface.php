<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Shared\Model\Infrastructure\Finder;

use Tightenco\Collect\Support\Collection;

interface PaginatorFinderInterface
{
    /**
     * @param int $offset
     * @param int $limit
     * @return \Tightenco\Collect\Support\Collection
     */
    public function paginate(int $offset, int $limit): Collection;

    /**
     * @return int
     */
    public function count(): int;
}
