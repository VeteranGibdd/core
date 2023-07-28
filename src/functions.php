<?php

namespace Gibdd\Core;

use Gibdd\Core\Exceptions\ValidationException;
use Opis\JsonSchema\{
    Validator,
    Errors\ErrorFormatter,
};

/**
 * @param Validator $validator
 * @param string $schemaName
 * @param \StdClass $data
 * @return void
 * @throws ValidationException
 */
function validateSchema(Validator $validator, string $schemaName, \StdClass $data): void
{
    $schema = __DIR__ . "/../schema/$schemaName.json";
    $schemaId = "https://veteran.ru/schema/$schemaName.json#";

    $validator->resolver()->registerFile($schemaId, $schema);

    $result = $validator->validate($data, $schemaId);

    if (!$result->isValid()) {
        throw new ValidationException(print_r((new ErrorFormatter())->format($result->error()), true));
    }
}
