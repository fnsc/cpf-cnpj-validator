<?php

namespace Fnsc\CPF;

use Fnsc\AbstractValidation;
use Illuminate\Contracts\Validation\Rule;

class Validator extends AbstractValidation implements Rule
{
    private const DIGIT_QUANTITY = 11;
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

    public function passes($attribute, $value): bool
    {
        $firstDigit = 0;
        $secondDigit = 0;
        $value = $this->removeSpecialChars($value);

        if (in_array($value, $this->invalidCpf)) {
            return false;
        }

        $this->cpf = str_split($value);

        if (!$this->hasCorrectDigitQuantity()) {
            return false;
        }

        $firstDigit = $this->calculateDigit(10, 2);
        $secondDigit = $this->calculateDigit(11, 1);

        return $this->isValid($firstDigit, $secondDigit);
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

    private function isValid(int $firstDigit, int $secondDigit): bool
    {
        return (int) $this->cpf[9] === $firstDigit && (int) $this->cpf[10] == $secondDigit;
    }

    private function hasCorrectDigitQuantity(): bool
    {
        return count($this->cpf) === self::DIGIT_QUANTITY;
    }
}
