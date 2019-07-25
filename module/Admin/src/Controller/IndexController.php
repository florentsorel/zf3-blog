<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function dashboardAction(): ViewModel
    {
        return new ViewModel();
    }
}
