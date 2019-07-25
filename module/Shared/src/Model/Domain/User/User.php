<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Shared\Model\Domain\User;

use DateTimeImmutable;

class User
{
    /** @var int */
    private $id;

    /** @var \Shared\Model\Domain\User\Role */
    private $role;

    /** @var \Shared\Model\Domain\User\Status */
    private $status;

    /** @var string|null */
    private $displayName;

    /** @var string|null */
    private $firstname;

    /** @var string|null */
    private $lastname;

    /** @var \Shared\Model\Domain\User\Email */
    private $email;

    /** @var \Shared\Model\Domain\User\PasswordHash */
    private $passwordHash;

    /** @var \DateTimeImmutable */
    private $creationDate;

    /** @var \DateTimeImmutable|null */
    private $lastUpdateDate;

    /**
     * @param \Shared\Model\Domain\User\Role $role
     * @param \Shared\Model\Domain\User\Status $status
     * @param \Shared\Model\Domain\User\Email $email
     * @param \Shared\Model\Domain\User\PasswordHash $passwordHash
     * @param \DateTimeImmutable $creationDate
     */
    public function __construct(
        Role $role,
        Status $status,
        Email $email,
        PasswordHash $passwordHash,
        DateTimeImmutable $creationDate
    ) {
        $this->role = $role;
        $this->status = $status;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->creationDate = $creationDate;
    }

    /**
     * @param User $candidate
     * @return bool
     */
    public function sameIdentityAs(User $candidate)
    {
        return $this->getId() === $candidate->getId();
    }

    /**
     * @param string $password
     * @return bool
     */
    public function verifyPassword($password)
    {
        return $this->passwordHash->challengeAgainst($password);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return \Shared\Model\Domain\User\Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     * @param \Shared\Model\Domain\User\Role $role
     */
    public function setRole(Role $role): void
    {
        $this->role = $role;
    }

    /**
     * @return \Shared\Model\Domain\User\Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @param \Shared\Model\Domain\User\Status $status
     */
    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * @param string $displayName
     */
    public function setDisplayName(string $displayName): void
    {
        $this->displayName = $displayName;
    }

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string|null $firstname
     */
    public function setFirstname(?string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string|null $lastname
     */
    public function setLastname(?string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return \Shared\Model\Domain\User\Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @param \Shared\Model\Domain\User\Email $email
     */
    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    /**
     * @return \Shared\Model\Domain\User\PasswordHash
     */
    public function getPasswordHash(): PasswordHash
    {
        return $this->passwordHash;
    }

    /**
     * @param \Shared\Model\Domain\User\PasswordHash $passwordHash
     */
    public function setPasswordHash(PasswordHash $passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreationDate(): DateTimeImmutable
    {
        return $this->creationDate;
    }

    /**
     * @param \DateTimeImmutable $creationDate
     */
    public function setCreationDate(DateTimeImmutable $creationDate): void
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getLastUpdateDate(): ?DateTimeImmutable
    {
        return $this->lastUpdateDate;
    }

    /**
     * @param \DateTimeImmutable|null $lastUpdateDate
     */
    public function setLastUpdateDate(?DateTimeImmutable $lastUpdateDate): void
    {
        $this->lastUpdateDate = $lastUpdateDate;
    }
}
