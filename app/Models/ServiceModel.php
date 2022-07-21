<?php

namespace App\Models;

class ServiceModel extends AbstractModel
{

    const URL = "https://127.0.0.1:8000/api/services";
    public function getServices()
    {
        $items = $this->requestData(self::URL);
        return $items ?? FALSE;
    }

}