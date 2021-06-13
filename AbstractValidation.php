<?php

namespace App\Rules;

class AbstractValidation
{
    protected function removeSpecialChars(string &$value): void
    {
        str_replace(['.', '-', '/', ' ', '&', '*'], '', $value);
    }
}
