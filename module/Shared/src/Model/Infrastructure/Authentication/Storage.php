<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Shared\Model\Infrastructure\Authentication;

use Zend\Authentication\Storage\Session;

class Storage extends Session
{
    /**
     * 2592000 = 1 mois
     *
     * @param int $time
     */
    public function setRememberMe($time = 2592000)
    {
        $this->session->getManager()->rememberMe($time);
    }

    public function forgetMe()
    {
        $this->session->getManager()->forgetMe();
    }
}