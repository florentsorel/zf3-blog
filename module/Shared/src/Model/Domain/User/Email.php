<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Shared\Model\Domain\User;

use InvalidArgumentException;

class Email
{
    /** @var string */
    private $value;

    /**
     * @param string $email
     * @throws \InvalidArgumentException
     */
    public function __construct(string $email)
    {
        $value = filter_var($email, FILTER_VALIDATE_EMAIL);

        if ($value === false) {
            throw new InvalidArgumentException(sprintf(
                'Invalid value given "%s"; value must be a valid email address',
                $email
            ));
        }

        $this->value = $value;
    }

    public function sameValueAs(Email $candidate) : bool
    {
        return $this->value === $candidate->value;
    }

    /**
     * @return string
     */
    public function toString() : string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getLocalPart() : string
    {
        $parts = explode('@', $this->value);
        return $parts[0];
    }

    /**
     * @return string
     */
    public function getDomain() : string
    {
        $parts = explode('@', $this->value);
        return $parts[1];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
