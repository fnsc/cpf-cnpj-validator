<?php

namespace CpfCnpjValidationRules;

use CpfCnpjValidationRules\CNPJ\Validator as CNPJ;
use CpfCnpjValidationRules\CPF\Validator as CPF;
use CpfCnpjValidationRules\RegistrationNumber\Validator as RegistrationNumber;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * @var array|string[]
     */
    private array $rules = [
        CPF::class,
        CNPJ::class,
        RegistrationNumber::class,
    ];

    public function boot(): void
    {
        $this->registerRules();
    }

    private function registerRules(): void
    {
        $validator = $this->app->make(Validator::class);

        foreach ($this->rules as $rule) {
            $rule = $this->app->make($rule);
            $alias = $rule->getAlias();
            $validator->extend($alias, $rule . '@passes', $rule->message());
        }
    }
}
