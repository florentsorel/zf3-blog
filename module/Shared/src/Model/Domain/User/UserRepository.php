<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Shared\Model\Domain\User;

interface UserRepository
{
    public function findByEmail(Email $email);
}
