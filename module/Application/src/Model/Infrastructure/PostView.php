<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Application\Model\Infrastructure;

use DateTimeImmutable;
use Shared\Model\Domain\Common\Slug;

class PostView
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var \Shared\Model\Common\Slug\Slug */
    private $slug;

    /** @var string|null */
    private $content;

    /** @var \DateTimeImmutable */
    private $creationDate;

    /** @var \DateTimeImmutable */
    private $lastUpdateDate;

    /**
     * @param int $id
     * @param string $name
     * @param \Shared\Model\Domain\Common\Slug $slug
     * @param \DateTimeImmutable $creationDate
     */
    public function __construct(
        int $id,
        string $name,
        Slug $slug,
        DateTimeImmutable $creationDate
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->creationDate = $creationDate;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return \Shared\Model\Domain\Common\Slug
     */
    public function getSlug(): Slug
    {
        return $this->slug;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     */
    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreationDate(): \DateTimeImmutable
    {
        return $this->creationDate;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getLastUpdateDate(): \DateTimeImmutable
    {
        return $this->lastUpdateDate;
    }

    /**
     * @param \DateTimeImmutable $lastUpdateDate
     */
    public function setLastUpdateDate(\DateTimeImmutable $lastUpdateDate): void
    {
        $this->lastUpdateDate = $lastUpdateDate;
    }

    /**
     * @return bool
     */
    public function hasContent()
    {
        return $this->content !== null;
    }

    /**
     * @return bool
     */
    public function hasLastUpdateDate()
    {
        return $this->lastUpdateDate !== null;
    }
}
