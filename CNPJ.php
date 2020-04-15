<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CNPJ implements Rule
{
    protected int $resultOne = 0;
    protected int $resultTwo = 0;
    protected array $cnpj;
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
        if ($value == "00000000000000" || $value == "11111111111111" || $value == "22222222222222" || $value == "33333333333333" || $value == "44444444444444" || $value == "55555555555555" || $value == "66666666666666" || $value == "77777777777777" || $value == "88888888888888" || $value == "99999999999999") {
            return false;
        }

        $this->cnpj = str_split($value);

        if (count($this->cnpj) != 14) {
            return false;
        }

        $this->resultOne = $this->calcDigit(5, 2);
        $this->resultTwo = $this->calcDigit(6, 1);

        return ($this->cnpj[12] == $this->resultOne && $this->cnpj[13] == $this->resultTwo);
    }

    public function calcDigit($aux, $loop)
    {
        $resultTmp = 0;
        for ($i = 0; $i < count($this->cnpj) - $loop; $i++) {
            $resultTmp += $this->cnpj[$i] * $aux--;
            if ($aux < 2) {
                $aux = 9;
            }
        }
        return $resultTmp % 11 < 2 ? 0 : 11 - $resultTmp % 11;
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
