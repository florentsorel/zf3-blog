<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Admin\Model\Application\Query\Auth;

use Zend\Authentication\Result;

class AuthenticateAdminResponse
{
    /** @var \Zend\Authentication\Result */
    private $authenticationResult;

    /** @var bool */
    private $rememberMe;

    /**
     * @param \Zend\Authentication\Result $result
     * @param bool $rememberMe
     */
    public function __construct(
        Result $result,
        bool $rememberMe
    ) {
        $this->authenticationResult = $result;
        $this->rememberMe = $rememberMe;
    }

    /**
     * @return \Zend\Authentication\Result
     */
    public function getAuthenticationResult() : Result
    {
        return $this->authenticationResult;
    }

    /**
     * @return bool
     */
    public function hasRememberMe(): bool
    {
        return $this->rememberMe;
    }
}
