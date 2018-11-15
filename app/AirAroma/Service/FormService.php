<?php

namespace AirAroma\Service;

use Illuminate\Validation\Factory as Validator;

class FormService
{
    protected $messages;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * 
     */
    protected function getMessages() 
    {
        return $messages = [
            'required' => 'This field is required', 
            'unique' => 'Item already exists',
            'min' => 'A minimum of :min required',
            'alpha' => 'Only letters allowed',
            'alpha_spaces' => 'Only letters and spaces allowed',
            'confirmed' => 'Fields do not match',
            'current_password' => 'Password not correct'
        ];
    }

    /**
    * Validate Contact Form contents
    *
    * @param null
    * @return validator object
    */
    public function validate($rules, $customMessages = [])
    {
        return $this->validator->make(request()->all(), $rules, array_merge($this->getMessages(), $customMessages));
    }
}