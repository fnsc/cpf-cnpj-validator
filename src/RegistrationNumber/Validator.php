<?php

namespace Fnsc\RegistrationNumber;

use Fnsc\AbstractValidator;
use Fnsc\CNPJ\Validator as CNPJ;
use Fnsc\CPF\Validator as CPF;
use Illuminate\Contracts\Validation\Rule;

class Validator extends AbstractValidator implements Rule
{
    private const CPF_DIGIT_QUANTITY = 11;

    protected string $alias = 'registration_number';

    public function passes($attribute, $value): bool
    {
        $value = $this->removeSpecialChars($value);

        if (self::CPF_DIGIT_QUANTITY === strlen($value)) {
            $validator = new CPF();

            return $validator->passes($attribute, $value);
        }

        $validator = new CNPJ();

        return $validator->passes($attribute, $value);
    }
}
