<?php

namespace Fnsc\CNPJ;

use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    /**
     * @dataProvider getCnpjScenarios
     */
    public function testShouldValidateCnpj(string $value, bool $expected): void
    {
        // Set
        $validator = new Validator();

        // Actions
        $result = $validator->passes('cnpj', $value);

        // Assertions
        $this->assertSame($expected, $result);
    }

    public function getCnpjScenarios(): array
    {
        return [
            'valid cnpj without special chars' => [
                'value' => '02307964000102',
                'expected' => true,
            ],
            'valid cnpj with special chars' => [
                'value' => '60-#.240&%.843/0001-97',
                'expected' => true,
            ],
            'invalid cnpj that belongs to invalid cases' => [
                'value' => '00000000000000',
                'expected' => false,
            ],
            'invalid cnpj that has incorrect digit quantity' => [
                'value' => '123456789012345',
                'expected' => false,
            ],
            'invalid cnpj' => [
                'value' => '12345678901234',
                'expected' => false,
            ],
        ];
    }

    public function testShouldReturnTheValidatorAlias(): void
    {
        // Set
        $validator = new Validator();

        // Actions
        $result = $validator->getAlias();

        // Assertions
        $this->assertSame('cnpj', $result);
    }
}
