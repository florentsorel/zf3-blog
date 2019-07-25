<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Shared\View\Helper;

use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Zend\View\Helper\AbstractHelper;

class FlashMessages extends AbstractHelper
{
    const NAMESPACE_LAYOUT = 'layout';

    /**
     * @var \Zend\Mvc\Plugin\FlashMessenger\FlashMessenger
     */
    private $flashMessenger;

    /**
     * @param \Zend\Mvc\Plugin\FlashMessenger\FlashMessenger $flashMessenger
     */
    public function __construct(
        FlashMessenger $flashMessenger
    ) {
        $this->flashMessenger = $flashMessenger;
    }

    /**
     * @param string $namespace
     *
     * @return string
     */
    public function get($namespace = FlashMessenger::NAMESPACE_DEFAULT)
    {
        if ($this->flashMessenger->hasCurrentMessages($namespace) === false) {
            return '';
        }

        switch ($namespace) {
            case FlashMessenger::NAMESPACE_WARNING:
                $class = 'warning';
                break;
            case FlashMessenger::NAMESPACE_INFO:
                $class = 'info';
                break;
            case FlashMessenger::NAMESPACE_ERROR:
                $class = 'danger';
                break;
            case FlashMessenger::NAMESPACE_SUCCESS:
                $class = 'success';
                break;
            default:
                $class = 'default';
                break;
        }

        $html = '';

        foreach ($this->flashMessenger->getCurrentMessages($namespace) as $message) {
            $html .= '<div class="alert alert-' . $class . '">' . $message . '</div>';
        }

        return $html;
    }

    /**
     * @return string
     */
    public function getSuccessMessages()
    {
        return $this->get(FlashMessenger::NAMESPACE_SUCCESS);
    }

    /**
     * @return string
     */
    public function getErrorMessages()
    {
        return $this->get(FlashMessenger::NAMESPACE_ERROR);
    }

    /**
     * @return string
     */
    public function getInfoMessages()
    {
        return $this->get(FlashMessenger::NAMESPACE_INFO);
    }

    /**
     * @return string
     */
    public function getWarningMessages()
    {
        return $this->get(FlashMessenger::NAMESPACE_WARNING);
    }

    /**
     * @return string
     */
    public function getAllMessages()
    {
        return $this->getSuccessMessages()
            . $this->getErrorMessages()
            . $this->getInfoMessages()
            . $this->getWarningMessages();
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->flashMessenger->getNamespace();
    }
}
