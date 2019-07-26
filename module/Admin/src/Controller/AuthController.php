<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */


namespace Admin\Controller;

use Admin\Model\Application\Query\Auth\AuthenticateAdmin;
use Admin\Model\Application\Query\Auth\AuthenticateAdminRequest;
use Admin\Model\Application\Query\Auth\BuildLoginForm;
use Shared\Model\Infrastructure\Authentication\Storage;
use Zend\Authentication\Result;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\ViewModel;

class AuthController extends AbstractActionController
{
    /** @var \Zend\ServiceManager\ServiceManager */
    private $serviceManager;

    /**
     * @param \Zend\ServiceManager\ServiceManager $serviceManager
     */
    public function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function loginAction()
    {
        // Configuration du layout
        $this->layout()->setVariable('metaTitle', "Connexion");

        /* @var $buildFormResponse \Admin\Model\Application\Query\Auth\BuildLoginFormResponse */
        $buildFormResponse = $this->serviceManager
            ->get(BuildLoginForm::class)
            ->handle();

        $view = new ViewModel([
            'form' => $buildFormResponse->getLoginForm()
        ]);

        if ($this->request->isPost() === false) {
            return $view;
        }

        $signInForm = $buildFormResponse->getLoginForm();
        $signInForm->setData($this->params()->fromPost());
        if ($signInForm->isValid() === false) {
            return $view;
        }

        /* @var $authenticateUserResponse \Admin\Model\Application\Query\Auth\AuthenticateAdminResponse */
        $authenticateUserResponse = $this->serviceManager
            ->get(AuthenticateAdmin::class)
            ->handle(
                AuthenticateAdminRequest::fromFormData($signInForm->getData())
            );

        $result = $authenticateUserResponse->getAuthenticationResult();
        if ($result->getCode() === Result::SUCCESS) {
            if ($authenticateUserResponse->hasRememberMe() === true) {
                /** @var \Shared\Model\Infrastructure\Authentication\Storage $sessionStorage */
                $sessionStorage = $this->serviceManager->get(Storage::class);
                $sessionStorage->setRememberMe();
            }

            return $this->redirect()->toRoute('admin');
        }

        $view->setVariable('authenticationFailed', true);
        return $view;
    }
}
