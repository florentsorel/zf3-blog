<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Admin\Form\Auth;

use Zend\Filter\StringTrim;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Password;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\Validator\EmailAddress;
use Zend\Validator\StringLength;

class LoginForm extends Form
{
    /**
     * {@inheritDoc}
     */
    public function __construct()
    {
        parent::__construct();

        $this->setAttribute('novalidate', 'novalidate');

        $this->add(new Text('email'));
        $this->add(new Password('password'));
        $this->add(new Checkbox('remember_me'));

        $inputFilter = $this->getInputFilter();

        $emailInput = $inputFilter->get('email');
        $emailInput->setRequired(true);
        $emailInput->getFilterChain()
            ->attach(new StringTrim());
        $emailInput->getValidatorChain()
            ->attach(new EmailAddress());

        $passwordInput = $inputFilter->get('password');
        $passwordInput->setRequired(true);
        $passwordInput->getValidatorChain()
            ->attach(new StringLength([
                'min' => 8
            ]));
    }
}
