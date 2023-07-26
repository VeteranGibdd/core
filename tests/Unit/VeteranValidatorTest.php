<?php

namespace Gibdd\Core\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Opis\JsonSchema\{
    Validator,
    ValidationResult,
    Errors\ErrorFormatter,
};

class VeteranValidatorTest extends TestCase
{
    public function testVeteranValidation()
    {
        $validator = new Validator();

        $validator->resolver()->registerFile('https://vetaran.ru/schema/veteran.json#', __DIR__ . '/../../schema/veteran.json');

        $data = <<<'JSON'
{
    "firstName": "Иван",
    "lastName": "Ивановванов",
    "middleName": "Иванович",
    "birthDate": "1970-03-25",
    "district": "Сочи",
      "policeDuty": {
        "rank": "майор полиции",
        "dutyStatus": "В отставке"
        },
      "organisation": {
        "status": "Ветеран",
        "joiningYear": 2008
        }
}
JSON;

        $data = json_decode($data);

        /** @var ValidationResult $result */
        $result = $validator->validate($data, 'https://vetaran.ru/schema/veteran.json#');

        if ($result->isValid()) {
            echo "Valid", PHP_EOL;
        } else {
            print_r((new ErrorFormatter())->format($result->error()));
        }

        $this->assertSame(true, $result->isValid());

    }

}