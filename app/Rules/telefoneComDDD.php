<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class telefoneComDDD implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->validateCelularComDDD($value) || $this->validateTelefoneComDDD($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.telefone');
    }

    public function validateCelularComDDD($value) {
        return preg_match('/^\(\d{2}\)\d{4,5}-\d{4}$/', $value) > 0;
    }

    public function validateTelefoneComDDD($value) {
        return preg_match('/^\(\d{2}\)\d{4}-\d{4}$/', $value) > 0;  
    }
}
