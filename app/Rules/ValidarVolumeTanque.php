<?php

namespace App\Rules;

use App\Tanque;
use Illuminate\Contracts\Validation\Rule;

class ValidarVolumeTanque implements Rule
{
    protected $tanque = null;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($tanque_id)
    {
        $this->tanque = Tanque::find($tanque_id);
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
        return ($this->tanque->capacidade >= $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Volume superior a capacidade. ['.$this->tanque->descricao_tanque.' = '.$this->tanque->capacidade.' Lts].';
    }
}
