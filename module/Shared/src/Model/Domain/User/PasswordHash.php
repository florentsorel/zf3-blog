<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Shared\Model\Domain\User;

use UnexpectedValueException;
use Zend\Stdlib\StringUtils;

class PasswordHash
{
    const PASSWORD_MIN_LENGTH = 8;

    /** @var string */
    private $value;

    /**
     * @param string $hash
     * @return PasswordHash
     */
    public static function fromHash($hash)
    {
        return new self($hash);
    }

    /**
     * @param string $rawPassword
     * @return PasswordHash
     * @throws \UnexpectedValueException
     */
    public static function fromRawPassword($rawPassword)
    {
        $stringWrapper = StringUtils::getWrapper();
        if ($stringWrapper->strlen($rawPassword) < self::PASSWORD_MIN_LENGTH) {
            throw new UnexpectedValueException(sprintf(
                'Password must be at least %d chars long',
                self::PASSWORD_MIN_LENGTH
            ));
        }

        $hash = password_hash($rawPassword, PASSWORD_BCRYPT);

        return new self($hash);
    }

    /**
     * @param string $hash
     */
    private function __construct($hash)
    {
        $this->value = $hash;
    }

    /**
     * @param PasswordHash $candidate
     * @return bool
     */
    public function sameValueAs(PasswordHash $candidate)
    {
        return $this->value === $candidate->value;
    }

    /**
     * Vérifie qu'un mot de passe correspond à un hash donné
     *
     * @param string $rawPassword
     * @return boolean
     */
    public function challengeAgainst($rawPassword)
    {
        return password_verify($rawPassword, $this->value);
    }

    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->value;
    }
}
