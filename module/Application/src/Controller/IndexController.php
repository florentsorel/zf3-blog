<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Model\Application\Query\Post\ListPost;
use Application\Model\Application\Query\Post\ListPostRequest;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
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
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction(): ViewModel
    {
        $this->layout()->setVariable('metaTitle', 'Liste des articles');

        if (empty($this->params()->fromQuery('page')) === false
            && is_numeric($this->params()->fromQuery('page')) === false
        ) {
            $this->redirect()->toRoute('application')->setStatusCode(301);
        }

        $currentPage = (int)$this->params()->fromQuery('page', 1) > 0
            ? (int)$this->params()->fromQuery('page')
            : 1;

        /** @var \Application\Model\Application\Query\Post\ListPostResponse $postResponse */
        $postResponse = $this->serviceManager
            ->get(ListPost::class)
            ->handle(new ListPostRequest($currentPage));

        return new ViewModel([
            'paginator' => $postResponse->getPaginator()
        ]);
    }
}
