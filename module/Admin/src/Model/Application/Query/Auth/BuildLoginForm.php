<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Admin\Model\Application\Query\Auth;

use Admin\Form\Auth\LoginForm;

class BuildLoginForm
{
    /**
     * @return \Admin\Model\Application\Query\Auth\BuildLoginFormResponse
     */
    public function handle()
    {
        $form = new LoginForm();
        return new BuildLoginFormResponse($form);
    }
}