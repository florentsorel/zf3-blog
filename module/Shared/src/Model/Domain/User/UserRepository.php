<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Shared\Model\Domain\User;

interface UserRepository
{
    /**
     * @param \Shared\Model\Domain\User\Email $email
     * @return \Shared\Model\Domain\User\User|null
     */
    public function findByEmail(Email $email);

    /**
     * @param \Shared\Model\Domain\User\Email $email
     * @param \Shared\Model\Domain\User\Role $role
     * @return \Shared\Model\Domain\User\User|null
     */
    public function findByEmailAndRole(Email $email, Role $role);
}
