<?php

namespace Gibdd\Core;

use JsonSerializable;

class Veteran implements JsonSerializable
{
    private array $dbRow;

    public function __construct(array $dbRow)
    {
        $this->dbRow = $dbRow;
    }

    public function jsonSerialize(): array
    {
        return $this->dbRow;
    }

}
