<?php

namespace Gibdd\Core\Tests\Unit;

use Gibdd\Core\Exceptions\ValidationException;
use Opis\JsonSchema\Validator;
use PHPUnit\Framework\TestCase;
use function Gibdd\Core\validateSchema;

class FunctionsTest extends TestCase
{
    public function testAssertSchemaIsNotValid(): void
    {
        self::expectException(ValidationException::class);

        $validator = new Validator();
        $schema = 'Veteran';
        $data = (object) ['name' => 'Vasya', 'lastName' => 'Petrov'];

        validateSchema($validator, $schema, $data);
    }

    public function testAssertSchemaIsValid(): void
    {
        $validator = new Validator();
        $schema = 'Veteran';

        validateSchema($validator, $schema, $this->veteran());
    }

    public function testSchemaAssertionProvidesErrorMessage(): void
    {
        self::expectExceptionMessageMatches('/The required properties \(firstName\) are missing/');

        $validator = new Validator();
        $schema = 'Veteran';
        $veteranWithError = $this->veteran();

        unset($veteranWithError->firstName);

        validateSchema($validator, $schema, $veteranWithError);
    }

    private function veteran(): object
    {
        return (object)[
            'firstName' => 'Иван',
            'lastName' => 'Ивановванов',
            'middleName' => 'Иванович',
            'birthDate' => '1970-03-25',
            'district' => 'Сочи',

            'policeDuty' => (object)[
                'rank' => 'майор полиции',
                'dutyStatus' => 'В отставке',
            ],

            'organisation' => (object)[
                'status' => 'Ветеран',
                'joiningYear' => 2008,
            ],
        ];
    }
}
