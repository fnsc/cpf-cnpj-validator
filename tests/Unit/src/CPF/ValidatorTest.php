<?php

namespace CpfCnpjValidationRules\CPF;

use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    /**
     * @dataProvider getCpfScenarios
     */
    public function testShouldValidateCpf(string $value, bool $expected): void
    {
        // Set
        $validator = new Validator();

        // Actions
        $result = $validator->passes('cpf', $value);

        // Assertions
        $this->assertSame($expected, $result);
    }

    public function testShouldReturnTheErrorMessage(): void
    {
        // Set
        $validator = new Validator();

        // Actions
        $result = $validator->message();

        // Assertions
        $this->assertSame('The :attribute is invalid.', $result);
    }

    public function testShouldReturnTheValidatorAlias(): void
    {
        // Set
        $validator = new Validator();

        // Actions
        $result = $validator->getAlias();

        // Assertions
        $this->assertSame('cpf', $result);
    }

    /**
     * @return mixed[]
     */
    public static function getCpfScenarios(): array
    {
        return [
            'valid cpf without special chars' => [
                'value' => '71368207073',
                'expected' => true,
            ],
            'valid cpf with special chars' => [
                'value' => '072.#@&084.$)+!870jaf-90',
                'expected' => true,
            ],
            'invalid cpf that belongs to invalid cases' => [
                'value' => '00000000000',
                'expected' => false,
            ],
            'invalid cpf that has incorrect digit quantity' => [
                'value' => '1234567890',
                'expected' => false,
            ],
            'invalid cpf' => [
                'value' => '12345678901',
                'expected' => false,
            ],
            'valid cpf' => [
                'value' => '123.456.789-09',
                'expected' => true,
            ],
            'invalid cpf #2' => [
                'value' => '123.456.789-10',
                'expected' => false,
            ],
        ];
    }
}
