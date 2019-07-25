<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Shared\View\Helper;

use Traversable;
use Zend\Form\ElementInterface;
use Zend\Form\Exception;
use Zend\Form\View\Helper\FormElementErrors;

class FormElementError extends FormElementErrors
{
    /**@+
     * @var string Templates for the open/close/separators for message tags
     */
    protected $messageCloseString     = '</div>';
    protected $messageOpenFormat      = '<div%s>';

    /**
     * @param \Zend\Form\ElementInterface $element
     * @param array $attributes
     * @return string
     */
    public function render(ElementInterface $element, array $attributes = [])
    {
        $messages = $element->getMessages();
        if (empty($messages)) {
            return '';
        }
        if (! is_array($messages) && ! $messages instanceof Traversable) {
            throw new Exception\DomainException(sprintf(
                '%s expects that $element->getMessages() will return an array or Traversable; received "%s"',
                __METHOD__,
                (is_object($messages) ? get_class($messages) : gettype($messages))
            ));
        }

        // Prepare attributes for opening tag
        $attributes = array_merge($this->attributes, $attributes);
        $attributes = $this->createAttributesString($attributes);
        if (! empty($attributes)) {
            $attributes = ' ' . $attributes;
        }

        // Flatten message array
        $escapeHtml      = $this->getEscapeHtmlHelper();
        $messagesToPrint = [];
        array_walk_recursive($messages, function ($item) use (&$messagesToPrint, $escapeHtml) {
            $messagesToPrint[] = $escapeHtml($item);
        });

        if (empty($messagesToPrint)) {
            return '';
        }

        // Generate markup
        $markup  = sprintf($this->getMessageOpenFormat(), $attributes);
        // Affiche le premier élement du tableau
        $markup .= $messagesToPrint[0];
        $markup .= $this->getMessageCloseString();

        return $markup;
    }
}