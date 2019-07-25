<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Admin\Model\Application\Query\Auth;

use Shared\Model\Domain\User\Email;
use Shared\Model\Domain\User\UserRepository;
use Shared\Model\Infrastructure\Adapter\IdentityAdapter;
use Shared\Model\Infrastructure\Authentication\Storage;
use Zend\Authentication\AuthenticationService;

class AuthenticateAdmin
{
    /** @var \Zend\Authentication\AuthenticationService */
    private $authentication;
    /** @var \Shared\Model\Domain\User\UserRepository */
    private $userRepository;

    /**
     * @param \Zend\Authentication\AuthenticationService $authentication
     * @param \Shared\Model\Domain\User\UserRepository $userRepository
     */
    public function __construct(
        AuthenticationService $authentication,
        UserRepository $userRepository
    ) {
        $this->authentication = $authentication;
        $this->userRepository = $userRepository;
    }

    /**
     * @param \Admin\Model\Application\Query\Auth\AuthenticateAdminRequest $request
     * @return \Admin\Model\Application\Query\Auth\AuthenticateAdminResponse
     */
    public function handle(AuthenticateAdminRequest $request)
    {
        $adapter = new IdentityAdapter(
            $this->userRepository,
            new Email($request->getEmail()),
            $request->getPassword()
        );

        $storage = new Storage();

        $this->authentication
            ->setAdapter($adapter)
            ->setStorage($storage);

        $authenticationResult = $this->authentication->authenticate();

        return new AuthenticateAdminResponse(
            $authenticationResult,
            $request->hasRememberMe()
        );
    }
}
