<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Shared\Model\Domain\User;

class Role
{
    const ADMINISTRATOR = 10;
    const USER = 1;
    const GUEST = -1;

    /** @var int */
    private $value;

    /**
     * @param int $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return \Shared\Model\Domain\User\Role
     */
    public static function createAdministrator(): Role
    {
        return new static(static::ADMINISTRATOR);
    }

    /**
     * @return \Shared\Model\Domain\User\Role
     */
    public function createUser(): Role
    {
        return new static(static::USER);
    }

    /**
     * @return int
     */
    public function toInt(): int
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isAdministrator(): bool
    {
        return $this->value === self::ADMINISTRATOR;
    }

    /**
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->value === self::USER;
    }
}
