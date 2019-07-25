<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Shared\Model\Domain\User;

class Status
{
    /** En attente de l'activation par email */
    const PENDING_ACTIVATION = 1;
    /** Compte actif */
    const ACTIVE = 2;
    /** Compte désactivé */
    const DISABLED = 3;
    /** Compte marqué comme inactif */
    const INACTIVE = 4;
    /** Compte supprimé */
    const DELETED = 5;

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
     * @return \Shared\Model\Domain\User\Status
     */
    public static function createPendingActivation(): Status
    {
        return new static(static::PENDING_ACTIVATION);
    }

    /**
     * @return \Shared\Model\Domain\User\Status
     */
    public static function createActive(): Status
    {
        return new static(static::ACTIVE);
    }

    /**
     * @return \Shared\Model\Domain\User\Status
     */
    public static function createDisabled(): Status
    {
        return new static(static::DISABLED);
    }

    /**
     * @return \Shared\Model\Domain\User\Status
     */
    public static function createInactive(): Status
    {
        return new static(static::INACTIVE);
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
    public function isPendingActivation(): bool
    {
        return $this->value === self::PENDING_ACTIVATION;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->value === self::ACTIVE;
    }

    /**
     * @return bool
     */
    public function isDisabled(): bool
    {
        return $this->value === self::DISABLED;
    }

    /**
     * @return bool
     */
    public function isInactive(): bool
    {
        return $this->value === self::INACTIVE;
    }
}
