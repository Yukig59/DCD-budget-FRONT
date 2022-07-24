<?php

namespace App\Models;

class TypeModel extends AbstractModel
{
    const URL = "https://localhost:8000/api/types";

    public function getTypeByLabel($label)
    {
        $url = self::URL . "?label=" . $label;
        return $this->requestData($url) ?? false;
    }

    public function getAllTypes()
    {
        $url = self::URL;
        return $this->requestData($url) ?? false;
    }
}