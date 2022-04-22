# CPF and CNPJ Validator

[![Latest Version on Packagist](https://img.shields.io/packagist/v/fonseca/cpf_cnpj_validation.svg?style=flat-square)](https://packagist.org/packages/fonseca/cpf_cnpj_validation)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/fonseca/cpf_cnpj_validation.svg?style=flat-square)](https://packagist.org/packages/fonseca/cpf_cnpj_validation)
[![Build Status](https://github.com/fnsc/cpf-cnpj-validation/workflows/Tests/badge.svg)](https://github.com/fnsc/cpf-cnpj-validation/actions?query=workflow%3ATests)

- [Introduction](#introduction)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage Guide](#usage)
- [License](#license)

<a name="introduction"></a>
## Introduction
This package provides a simple way to validate CPF and CNPJ for Laravel applications.

<a name="requirements"></a>
## Requirements
- PHP >= 8.0.2
- Laravel >= 9.*

<a name="installation"></a>
## Installation
You can install the library via Composer:
```bash
composer require fonseca/cpf_cnpj_validation
```

<a name="usage"></a>
## Usage Guide
Add this code to your `App\Providers\AppServiceProvider::class`.

```php
<?php

namespace App\Providers;

use Fnsc\RegistrationNumber\Validator as RegistrationNumber;
use Fnsc\CPF\Validator as CPF;
use Fnsc\CNPJ\Validator as CNPJ;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    private array $rules = [
        CPF::class,
        CNPJ::class,
        RegistrationNumber::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRules();
    }

    private function registerRules(): void
    {
        foreach ($this->rules as $rule) {
            $alias = (new $rule)->getAlias();
            Validator::extend($alias, $rule . '@passes');
        }
    }
}
```

Add these code to `resources/lang/en/validation.php` file.
```php
return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    ...
    'cpf' => 'The :attribute is invalid.',
    'cnpj' => 'The :attribute is invalid.',
    'registration_number' => 'The :attribute is invalid.',
    ...
];
```

And, finally, on your `FooRequest.php` file. 
Here you can choose which rule will be used. <br> 
The `Fnsc\RegistrationNumber\Validator as RegistrationNumber;` class made both validations, depending on the size of the string received.<br>
The `Fnsc\CPF\Validator as CPF;` made only cpf validations, and `Fnsc\CNPJ\Validator as CNPJ;` made only cnpj validations.
```php
public function rules()
{
    return [
        'fiscal_doc' => 'required|registration_number',
        'cpf' => 'required|cpf',
        'cnpj' => 'required|cnpj',
    ];
}
```

<a name="license"></a>
## License
This package is free software distributed under the terms of the [MIT license](http://opensource.org/licenses/MIT)