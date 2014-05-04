<?php
namespace Models;
use Resources;

class FormValidation extends Resources\Validation {

    public $checkNIDN = true;
    public $ruleConfig = array();

    public function __construct()
    {
        parent::__construct();
        
        // $this->session      = new Resources\Session;
        // $this->request      = new Resources\Request;
        $this->datatables   = new Datatables;
    }

    public function setRules(){
        $rules = array();
        $default = array(
            'NUMBER' => array(
                'rules' => array(
                    'required',
                    'min' => 3,
                    'numeric'
                    ),
                'label' => 'FIELD',
                'filter' => array('trim', 'strtolower', 'ucwords')
                ),
            'STRING' => array(
                'rules' => array(
                    'required',
                    'min' => 3,
                    ),
                'label' => 'FIELD',
                'filter' => array('trim', 'strtoupper', 'ucwords')
                ),
            'USERNAME' => array(
                'rules' => array(
                    'required',
                    'min' => 3,
                    'max' => 10,
                    'regex' => '/^([-a-z0-9_-])+$/i',
                    'callback' => 'usernameExists'
                    ),
                'label' => 'Username',
                'filter' => array('trim', 'strtolower')
                ),
            'EMAIL' => array(
                'rules' => array(
                    'required',
                    'min' => 3,
                    'email',
                    'callback' => 'emailExists'
                    ),
                'label' => 'Email',
                'filter' => array('trim', 'strtolower')
                ),
            'PASSWORD' => array(
                'rules' => array(
                    'required',
                    'min' => 5,
                    'compare' => 'repassword'
                    ),
                'label' => 'Password'
                ),
            'REPASSWORD' => array(
                'rules' => array(
                    'required'
                    ),
                'label' => 'Retype Password'
                ),
            'FILE' => array(
                'rules' => array(
                    'file'
                    ),
                'label' => 'File'
                )
        );

        foreach ($this->ruleConfig as $key => $value) {
            if (array_key_exists($value['validate'], $default)) {
                $rules[$key] = $default[$value['validate']];

                if (! empty($value['rules'])) {
                    $value['rules'] = array_merge_recursive ($rules[$key]['rules'], $value['rules']);
                }

                $rules[$key] = array_merge($rules[$key], $value);
            }
        }
        return $rules;
    }

    public function nidnExists($field, $value, $label)
    {
        if( ! $this->checkNIDN )
            return true;

        if( ! $nidn = $this->datatables->getOne( array('NIDNNTBDOS' => $value) ) )
            return true;

        $this->setErrorMessage($field, 'NIDN already exists.');

        return false;
    }

    public function usernameExists($field, $value, $label)
    {
        if( $value != 'admin' )
            return true;

        $this->setErrorMessage($field, 'Username already exists.');

        return false;
    }

    public function emailExists($field, $value, $label)
    {
        if( $value != 'admin@site.com' )
            return true;

        $this->setErrorMessage($field, 'Email already exists.');

        return false;
    }
}