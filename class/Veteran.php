<?php
class Veteran implements JsonSerializable
{
    private array $vetData;

    public function __construct(array $vet)
    {
        $this->vetData = $vet;
    }

    public function jsonSerialize(): array
    {
        return $this->vetData;
    }

}
