<?php

namespace App\Helpers;


class CustomDateTime extends \DateTime implements \JsonSerializable
{

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->format('c');
    }

}