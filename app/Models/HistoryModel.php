<?php

namespace App\Models;

use stdClass;
use function PHPUnit\Framework\returnArgument;

class HistoryModel extends AbstractModel
{
    const URL = "https://localhost:8001/api/logs";

    public function createHistory($data)
    {
        $postData = [
            "date" => (int)date_create()->getTimestamp(),
            "action" => $data['action'],
            "target" => $data['target'],
            "userActor" => $data['userActor'],
            "TargetUser" => $data['TargetUser'] ?? null,
            "purchaseOrder" => $data['purchaseOrder'] ?? null,
            "budgetHeader" => $data['budgetHeader'] ?? null,
            "service" => $data['service'] ?? null,
            "propertyChanged" => $data['propertyChanged'] ?? null,
            "oldValue" => $data['oldValue'] ?? null,
            "newValue" => $data['newValue'] ?? null,
        ];

        return $this->sendData($postData, self::URL);
    }

    public function getBhLogsById($id)
    {
        $url = "https://localhost:8001/api/budget_headers/" . $id . "/logs";
        return $this->requestData($url);
    }

    public function diff($old, $new)
    {
        $oldArray = json_decode(json_encode($old), true)[0];
        $result = array_diff_key($oldArray, $new);
        print_r($result);
        die();
    }
}