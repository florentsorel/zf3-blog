<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Shared\Model\Infrastructure\Adapter;

use Shared\Model\Domain\User\UserRepository;
use Shared\Model\Infrastructure\Authentication\Identity;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;

class IdentityAdapter implements AdapterInterface
{

    /** @var \Shared\Model\Domain\User\UserRepository */
    private $userRepository;

    /** @var string */
    private $email;

    /** @var string */
    private $password;

    /**
     * @param \Shared\Model\Domain\User\UserRepository $userRepository
     * @param \Shared\Model\Domain\User\Email $email
     * @param null|string $password
     */
    public function __construct(
        UserRepository $userRepository,
        $email,
        $password
    ) {
        $this->userRepository = $userRepository;
        $this->email = $email;
        $this->password = $password;
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
        $user = $this->userRepository->findByEmail($this->email);

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
