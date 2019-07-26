<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Shared\Model\Infrastructure\Adapter;

use Shared\Model\Domain\User\Email;
use Shared\Model\Domain\User\Role;
use Shared\Model\Domain\User\UserRepository;
use Shared\Model\Infrastructure\Authentication\Identity;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;

class IdentityAdapter implements AdapterInterface
{

    /** @var \Shared\Model\Domain\User\UserRepository */
    private $userRepository;

    /** @var \Shared\Model\Domain\User\Email */
    private $email;

    /** @var string */
    private $password;

    /** @var \Shared\Model\Domain\User\Role */
    private $role;

    /**
     * @param \Shared\Model\Domain\User\UserRepository $userRepository
     * @param \Shared\Model\Domain\User\Email $email
     * @param string $password
     * @param \Shared\Model\Domain\User\Role $role
     */
    public function __construct(
        UserRepository $userRepository,
        Email $email,
        string $password,
        Role $role
    ) {
        $this->userRepository = $userRepository;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface If authentication cannot be performed
     */
    public function authenticate()
    {
        // Recherche le compte utilisateur à partir de l'adresse email
        /** @var \Shared\Model\Domain\User\User $user */
        $user = $this->userRepository->findByEmailAndRole(
            $this->email,
            $this->role
        );

        // Si aucun compte ne correspond, retourne un code echec
        if ($user === null) {
            return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, null);
        }

        if ($user->verifyPassword($this->password) === false) {
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null);
        }

        // Retourne un code succès
        $identity = new Identity(
            $user->getId(),
            $user->getEmail(),
            $user->getDisplayName(),
            $user->getRole()->toInt()
        );

        return new Result(Result::SUCCESS, $identity);
    }
}
