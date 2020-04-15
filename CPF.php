<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CPF implements Rule
{
    protected int $resultOne = 0;
    protected int $resultTwo = 0;
    protected array $cpf;
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
        if ($value == "00000000000" || $value == "11111111111" || $value == "22222222222" || $value == "33333333333" || $value == "44444444444" || $value == "55555555555" || $value == "66666666666" || $value == "77777777777" || $value == "88888888888" || $value == "99999999999") {
            return false;
        }

        $this->cpf = str_split($value);

        if (count($this->cpf) != 11) {
            return false;
        }

        $this->resultOne = $this->calcDigit(10, 2);
        $this->resultTwo = $this->calcDigit(11, 1);

        return ($this->cpf[9] == $this->resultOne && $this->cpf[10] == $this->resultTwo);
    }

    public function calcDigit($aux, $loop)
    {
        $resultTmp = 0;
        for ($i = 0; $i < count($this->cpf) - $loop; $i++) {
            $resultTmp += $this->cpf[$i] * $aux--;
        }
        return ($resultTmp * 10) % 11;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O :attribute é inválido.';
    }
}
