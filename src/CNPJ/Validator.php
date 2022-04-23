<?php

namespace Fnsc\CNPJ;

use Fnsc\AbstractValidator;
use Illuminate\Contracts\Validation\Rule;

class Validator extends AbstractValidator implements Rule
{
    /**
     * @var int
     */
    private const DIGIT_QUANTITY = 14;

    protected string $alias = 'cnpj';

    /**
     * @var array
     */
    private array $cnpj;

    /**
     * @var array|string[]
     */
    private array $invalidCnpj = [
        '00000000000000',
        '11111111111111',
        '22222222222222',
        '33333333333333',
        '44444444444444',
        '55555555555555',
        '66666666666666',
        '77777777777777',
        '88888888888888',
        '99999999999999',
    ];

    public function passes($attribute, $value): bool
    {
        $value = $this->removeSpecialChars($value);

        if (in_array($value, $this->invalidCnpj)) {
            return false;
        }

        $this->cnpj = str_split($value);

        if (!$this->hasCorrectDigitQuantity()) {
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

        $result %= 11;

        return $result < 2 ? 0 : 11 - $result;
    }

    private function isValid(int $firstDigit, int $secondDigit): bool
    {
        return (int) $this->cnpj[12] === $firstDigit && (int) $this->cnpj[13] === $secondDigit;
    }

    private function hasCorrectDigitQuantity(): bool
    {
        return self::DIGIT_QUANTITY === count($this->cnpj);
    }
}
