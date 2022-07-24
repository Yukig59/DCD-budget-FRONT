<?php

namespace App\Models;

use Cassandra\Date;

class MarketModel extends AbstractModel
{
    const URL = "https://localhost:8000/api/marches";

    public function getMarketsByService($code)
    {
        $url = self::URL . "?service.code=" . $code;
        return $this->requestData($url) ?? false;

    }

    public function getMarketById($id)
    {
        $url = self::URL . "/" . $id;
        return $this->requestData($url) ?? false;

    }

    public function getAllMarkets()
    {
        $url = self::URL;
        return $this->requestData($url) ?? false;

    }

    public function addMarket($data)
    {
        $startDate = date_create($data['startDate'])->getTimestamp();
        $endDate = date_create($data['endDate'])->getTimestamp();
        $postData = [
            "label" => $data['label'],
            "code" => $data['numero'],
            "dateDebut" => (int)$startDate,
            "dateFin" => (int)$endDate,
            "service" => $data['serviceIri'],
            "type" => [
                "label" => $data['typologie']
            ] // TODO : get Type by value selected
        ];
        return $this->sendData($postData, self::URL);
    }

    public function deleteMarket($id)
    {
        $url = self::URL . "/" . $id;
        return $this->deleteData($url);
    }

    public function editMarket($id)
    {

    }
}