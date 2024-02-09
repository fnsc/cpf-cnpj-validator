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
        foreach ($this->rules as $rule) {
            $instance = $this->app->make($rule);
            $alias = $instance->getAlias();
            Validator::extend($alias, $rule . '@passes', $instance->message());
        }
    }
}
