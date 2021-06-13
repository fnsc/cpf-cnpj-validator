<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CPF extends AbstractValidation implements Rule
{
    private array $cpf;
    private array $invalidCpf = [
        "00000000000",
        "11111111111",
        "22222222222",
        "33333333333",
        "44444444444",
        "55555555555",
        "66666666666",
        "77777777777",
        "88888888888",
        "99999999999",
    ];

    public function passes(string $attribute, string $value): bool
    {
        $resultOne = 0;
        $resultTwo = 0;

        $this->removeSpecialChars($value);

        if (in_array($value, $this->invalidCpf)) {
            return false;
        }

        $this->cpf = str_split($value);

        if (count($this->cpf) !== 11) {
            return false;
        }

        $resultOne = $this->calculateDigit(10, 2);
        $resultTwo = $this->calculateDigit(11, 1);

        return $this->isValid($resultOne, $resultTwo);
    }

    private function calculateDigit(int $aux, int $loop): int
    {
        $result = 0;
        $loop = count($this->cpf) - $loop;

        for ($i = 0; $i < $loop; $i++) {
            $result += $this->cpf[$i] * $aux--;
        }

        return ($result * 10) % 11;
    }

    public function message(): string
    {
        return 'O :attribute é inválido.';
    }

    private function isValid(int $firstDigit, int $secondDigit): bool
    {
        return ($this->cpf[9] == $firstDigit && $this->cpf[10] == $secondDigit);
    }
}
