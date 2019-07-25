<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Admin\Form\Auth;

use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Email;
use Zend\Form\Element\Password;
use Zend\Form\Form;
use Zend\InputFilter\Input;

class LoginForm extends Form
{
    /**
     * {@inheritDoc}
     */
    public function __construct()
    {
        parent::__construct();

        $this->add(new Email('email'));
        $this->add(new Password('password'));
        $this->add(new Checkbox('remember_me'));

        $inputFilter = $this->getInputFilter();

        $emailInput = new Input('email');
        $emailInput->setRequired(true);
        $inputFilter->add($emailInput);

        $passwordInput = new Input('password');
        $passwordInput->setRequired(true);
        $inputFilter->add($passwordInput);
    }
}