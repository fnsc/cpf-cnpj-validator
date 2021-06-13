<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CNPJ extends AbstractValidation implements Rule
{
    private array $cnpj;
    private array $invalidCnpj = [
        "00000000000000",
        "11111111111111",
        "22222222222222",
        "33333333333333",
        "44444444444444",
        "55555555555555",
        "66666666666666",
        "77777777777777",
        "88888888888888",
        "99999999999999",
    ];

    public function passes(string $attribute, string $value): bool
    {
        $firstDigit = 0;
        $secondDigit = 0;

        $this->removeSpecialChars($value);

        if (in_array($value, $this->invalidCnpj)) {
            return false;
        }

        $this->cnpj = str_split($value);

        if (count($this->cnpj) !== 14) {
            return false;
        }

        $firstDigit = $this->calculateDigit(5, 2);
        $secondDigit = $this->calculateDigit(6, 1);

        return $this->isValid($firstDigit, $secondDigit);
    }

    private function calculateDigit(int $aux, int $loop): int
    {
        $result = 0;
        $loop = count($this->cnpj) - $loop;

        for ($i = 0; $i < $loop; $i++) {
            $result += $this->cnpj[$i] * $aux--;
            if ($aux < 2) {
                $aux = 9;
            }
        }

        return $result % 11 < 2 ? 0 : 11 - $result % 11;
    }

    public function message(): string
    {
        return 'O :attribute é inválido.';
    }

    private function isValid(int $firstDigit, int $secondDigit): bool
    {
        return $this->cnpj[12] === $firstDigit && $this->cnpj[13] === $secondDigit;
    }
}
