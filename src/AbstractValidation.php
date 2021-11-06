<?php

namespace Fnsc;

class AbstractValidation
{
    public function message(): string
    {
        return 'O :attribute é inválido.';
    }

    protected function removeSpecialChars(string $value): string
    {
        return preg_replace('/[^0-9]/is', '', $value);
    }
}
