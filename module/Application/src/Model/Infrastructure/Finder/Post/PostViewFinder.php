<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Application\Model\Infrastructure\Finder\Post;

use Application\Model\Infrastructure\PostView;
use DateTimeImmutable;
use Shared\Model\Domain\Common\Slug;
use Shared\Model\Infrastructure\Finder\PaginatorFinderInterface;
use Tightenco\Collect\Support\Collection;
use Zend\Db\Adapter\Adapter;

class PostViewFinder implements PaginatorFinderInterface
{
    /** @var \Zend\Db\Adapter\Adapter */
    private $db;

    /**
     * @param \Zend\Db\Adapter\Adapter $db
     */
    public function __construct(Adapter $db)
    {
        $this->db = $db;
    }

    /**
     * @return \Tightenco\Collect\Support\Collection
     */
    public function findAll(): Collection
    {
        $sql = <<<SQL
            SELECT
                Post.idPost,
                Post.name,
                Post.slug,
                Post.content,
                Post.creationDate,
                Post.lastUpdateDate
            FROM Post
            ORDER BY creationDate DESC
;
SQL;

        $statement = $this->db->createStatement($sql);
        $queryResult = $statement->execute();

        if ($queryResult->isQueryResult() === false && $queryResult->count() < 1) {
            return new Collection();
        }

        $collection = new Collection();
        foreach ($queryResult as $row) {
            $collection->push(
                $this->createPost($row)
            );
        }

        return $collection;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @return \Tightenco\Collect\Support\Collection
     */
    public function paginate(int $offset, int $limit): Collection
    {
        $sql = <<<SQL
            SELECT
                Post.idPost,
                Post.name,
                Post.slug,
                Post.content,
                Post.creationDate,
                Post.lastUpdateDate
            FROM Post
            ORDER BY creationDate DESC
            LIMIT :offset, :limit
;
SQL;

        $statement = $this->db->createStatement($sql);
        $queryResult = $statement->execute([
            ':offset' => $offset,
            ':limit' => $limit,
        ]);

        if ($queryResult->isQueryResult() === false && $queryResult->count() < 1) {
            return new Collection();
        }

        $collection = new Collection();
        foreach ($queryResult as $row) {
            $collection->push(
                $this->createPost($row)
            );
        }

        return $collection;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        $sql = <<<SQL
            SELECT
                COUNT(1) as total
            FROM Post
            LIMIT 1
;
SQL;

        $statement = $this->db->query($sql);
        $queryResult = $statement->execute();

        return (int)$queryResult->current()['total'];
    }

    /**
     * @param array $data
     * @return \Application\Model\Infrastructure\PostView
     */
    private function createPost(array $data): PostView
    {
        $post = new PostView(
            (int)$data['idPost'],
            $data['name'],
            Slug::createFromString($data['name']),
            DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['creationDate'])
        );

        if ($data['content'] !== null) {
            $post->setContent($data['content']);
        }

        if ($data['lastUpdateDate'] !== null) {
            $post->setLastUpdateDate(
                DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['lastUpdateDate'])
            );
        }
        return $post;
    }
}
