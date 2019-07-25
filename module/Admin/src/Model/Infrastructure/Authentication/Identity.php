<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Admin\Model\Infrastructure\Authentication;

use Shared\Model\Domain\User\Email;

class Identity
{
    /** @var int */
    private $id;

    /** @var \Shared\Model\Domain\User\Email */
    private $email;

    /** @var string */
    private $displayName;

    /** @var string|null */
    private $firstname;

    /** @var string|null */
    private $lastname;

    /** @var int */
    private $roleId;

    /**
     * @param int $id
     * @param \Shared\Model\Domain\User\Email $email
     * @param string $displayName
     * @param int $roleId
     */
    public function __construct(
        int $id,
        Email $email,
        string $displayName,
        int $roleId
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->displayName = $displayName;
        $this->roleId = $roleId;
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
    public function getEmail(): string
    {
        return $this->email->toString();
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @return int
     */
    public function getRoleId(): int
    {
        return $this->roleId;
    }
}
