<?php

namespace Gibdd\Core;

use Opis\JsonSchema\{
    Validator,
    ValidationResult,
    Errors\ErrorFormatter,
};

function testVeteranValidation(\stdClass|string $data, Validator $validator, string $schemaId): bool
{
    if (is_string($data)) {
        $data = json_decode($data);
    }

    /** @var ValidationResult $result */
    $result = $validator->validate($data, $schemaId);

    try {

        if ($result->isValid()) {
            return true;
        } else {
            throw new \Exception(print_r((new ErrorFormatter())->format($result->error()), true));
        }

    } catch (\Exception $e) {
        echo $e->getMessage();
        return false;
    }

}
