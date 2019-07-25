<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Admin\Model\Application\Query\Auth;

use Admin\Form\Auth\LoginForm;

class BuildLoginFormResponse
{
    /** @var \Admin\Form\Auth\LoginForm */
    private $loginForm;

    /**
     * @param \Admin\Form\Auth\LoginForm $loginForm
     */
    public function __construct(LoginForm $loginForm)
    {
        $this->loginForm = $loginForm;
    }

    /**
     * @return \Admin\Form\Auth\LoginForm
     */
    public function getLoginForm(): LoginForm
    {
        return $this->loginForm;
    }
}
