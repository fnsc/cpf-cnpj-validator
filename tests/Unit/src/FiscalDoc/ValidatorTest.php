<?php

namespace Fnsc\FiscalDoc;

use Fnsc\CNPJ\Validator as CNPJ;
use Fnsc\CPF\Validator as CPF;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    /**
     * @dataProvider getCnpjScenarios
     */
    public function testShouldValidateTheCnpj(string $value, bool $expected): void
    {
        // Set
        $validator = new Validator();
        $cnpj = m::mock(CNPJ::class);

        // Expectations
        $cnpj->expects()
            ->passes('cnpj')
            ->andReturn($expected);

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

    /**
     * @dataProvider getCpfScenarios
     */
    public function testShouldValidateTheCpf(string $value, bool $expected): void
    {
        // Set
        $validator = new Validator();
        $cpf = m::mock(CPF::class);

        // Expectations
        $cpf->expects()
            ->passes('cpf')
            ->andReturn($expected);

        // Actions
        $result = $validator->passes('cpf', $value);

        // Assertions
        $this->assertSame($expected, $result);
    }

    public function getCpfScenarios(): array
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

    public function testShouldReturnTheValidatorAlias(): void
    {
        // Set
        $validator = new Validator();

        // Actions
        $result = $validator->getAlias();

        // Assertions
        $this->assertSame('fiscal_doc', $result);
    }
}
