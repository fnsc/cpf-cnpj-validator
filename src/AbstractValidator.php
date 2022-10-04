<?php

namespace Fnsc;

abstract class AbstractValidator
{
    protected string $alias;

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function message(): string
    {
        return 'O :attribute é inválido.';
    }

    protected function removeSpecialChars(string $value): string|null
    {
        return preg_replace('/[^0-9]/is', '', $value);
    }
}
