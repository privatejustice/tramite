<?php

namespace Tramite\Worker\Explorer\QueryList;

/**
 * PreenchedorDeFormulario Class
 *
 * @class   PreenchedorDeFormulario
 * @package crawler
 */
class PreenchedorDeFormulario
{

    public $person = false;

    public $fields = [];

    public function __construct($person = false)
    {
        if (!$person) {
            $person = $this->newFakePerson();
        }
        $this->person = $person;
    }

    public function executeForm($formInstance)
    {
        $form = $ql->get('https://github.com/login')->find('form');
        $formFields = $formInstance->fields()->get();
        foreach($formFields as $formField) {
            $form->find('input[name=login]')->val('your github username or email');
        }
    }

    protected function newFakePerson()
    {
        // @todo PEgar via Factory
    }

    protected function getFields()
    {
        return [
            'login' => $this->person->login,
            'email' => $this->person->email
        ];
    }

    public function getField($field)
    {
        return $this->getFields()[$field];
    }
}