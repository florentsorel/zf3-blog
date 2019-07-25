<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Admin\Model\Application\Query\Auth;

class AuthenticateAdminRequest
{
    /** @var string */
    private $email;

    /** @var string */
    private $password;

    /** @var bool */
    private $rememberMe;

    /**
     * @param string $email
     * @param string $password
     * @param bool $rememberMe
     */
    public function __construct(string $email, string $password, bool $rememberMe)
    {
        $this->email = $email;
        $this->password = $password;
        $this->rememberMe = $rememberMe;
    }

    /**
     * @param array $data
     *
     * @return \Admin\Model\Application\Query\Auth\AuthenticateAdminRequest
     */
    public static function fromFormData(array $data)
    {
        return new static($data['email'], $data['password'], $data['remember_me'] == '1');
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return bool
     */
    public function hasRememberMe(): bool
    {
        return $this->rememberMe;
    }
}
