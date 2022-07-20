<?php

namespace App\Models;

use App\Helpers\CustomDateTime;
use DateTime;

class BudgetHeaderModel extends AbstractModel
{
    const URL = "https://localhost:8000/api/budget_headers";

    public function getAllBudgetHeaders($code)
    {
        $url = self::URL . "?service.code=" . $code;
        return $this->requestData($url) ?? false;

    }

    public function addBudgetHeader(array $data)
    {
        var_dump($data["code"]);
        $label = $data['label'];
        $date = date_create()->getTimestamp();
        $numero = $data['numeroLigne'];
        $type = $data['type'];
        $bp = floatval($data['budgetPrevisionnel']);
        $br = floatval($data['budgetReel']);
        $depenses = 0.0;
        $logs = [
            "date" => $date,
            "action" => self::CREATE,
            "target" => "BudgetHeader",
            "userActor" => $data['user'],
            "propertyChanged" => null,
            "oldValue" => null,
            "newValue" => null
        ];
        $postData = [
            "budgetPrevisionnel" => $bp,
            "number" => $numero,
            "label" => $label,
            "dateCreation" => $date,
            "budgetReel" => $br,
            "depenses" => $depenses,
            "service" => $data['serviceIri'],
            "type" => $data['typeIri']

        ];
        return $this->sendData($postData, self::URL);
    }
    public function deleteBh($id){
        $url = self::URL."/". $id;
        return $this->deleteData($url);
    }
}