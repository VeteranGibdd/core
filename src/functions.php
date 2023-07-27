<?php

namespace Gibdd\Core;
require_once __DIR__ . '/../vendor/autoload.php';

use stdClass;
use Opis\JsonSchema\{
    Validator,
    ValidationResult,
    Errors\ErrorFormatter,
};

function testVeteranValidation(stdClass|string $data): bool
{
    $validator = new Validator();

    $validator->resolver()->registerFile('https://veteran.ru/schema/veteran.json#', __DIR__ . '/../schema/veteran.json');

    if (is_string($data)) {
        $data = json_decode($data);
    }

    /** @var ValidationResult $result */
    $result = $validator->validate($data, 'https://veteran.ru/schema/veteran.json#');

    if ($result->isValid()) {
        echo "Valid", PHP_EOL;
        return true;
    } else {
        print_r((new ErrorFormatter())->format($result->error()));
        return false;
    }

}
