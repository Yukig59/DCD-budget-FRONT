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

    public function getBudgetHeaderById($id)
    {
        $url = self::URL . "?id=" . $id;
        return $this->requestData($url) ?? false;

    }

    public function addBudgetHeader(array $data)
    {
        $history = new HistoryModel();
        $label = $data['label'];
        $numero = $data['numeroLigne'];
        $bp = floatval($data['budgetPrevisionnel']);
        $br = floatval($data['budgetReel']);
        $depenses = 0.0;

        $postData = [
            "budgetPrevisionnel" => $bp,
            "number" => $numero,
            "label" => $label,
            "dateCreation" => date_create()->getTimestamp(),
            "budgetReel" => $br,
            "depenses" => $depenses,
            "service" => $data['serviceIri'],
            "type" => $data['typeIri']

        ];
        $result = $this->sendData($postData, self::URL);

        $logs = [
            "date" => date_create()->getTimestamp(),
            "action" => self::CREATE,
            "target" => "BudgetHeader",
            "userActor" => $data['userIri'],
            "propertyChanged" => null,
            "oldValue" => null,
            "newValue" => null,
            "budgetHeader" => "/api/budget_headers/" . $result->id
        ];
        return $history->createHistory($logs);

    }

    public function deleteBh($id)
    {
        $url = self::URL . "/" . $id;
        return $this->deleteData($url);
    }

    public function updateHeaders($oldBh, $data)
    {

        $url = self::URL . "/" . $data['id'];
        $postData = [
            "label" => $data['label'],
            "numero" => $data['numeroLigne'],
            "type" => $data['typeIri']
        ];
        $logs = [];
        $history = new HistoryModel();
        $result = $this->patchData($postData, $url);

        if ($oldBh[0]->label !== $data['label']) {
            $logs += [
                "date" => date_create()->getTimestamp(),
                "action" => self::UPDATE,
                "target" => "BudgetHeader",
                "userActor" => $data['userIri'],
                "propertyChanged" => "label",
                "oldValue" => $oldBh[0]->label,
                "newValue" => $data['label'],
                "budgetHeader" => "/api/budget_headers/" . $result->id
            ];
            $history->createHistory($logs);
        }
        if ($oldBh[0]->number !== $data['numeroLigne']) {
            $logs += [
                "date" => date_create()->getTimestamp(),
                "action" => self::UPDATE,
                "target" => "BudgetHeader",
                "userActor" => $data['userIri'],
                "propertyChanged" => "number",
                "oldValue" => $oldBh[0]->number,
                "newValue" => $data['numeroLigne'],
                "budgetHeader" => "/api/budget_headers/" . $result->id
            ];
            $history->createHistory($logs);
        }
        if ($oldBh[0]->type->id !== $this->getItemFromIri($data['typeIri'])) {
            $logs += [
                "date" => date_create()->getTimestamp(),
                "action" => self::UPDATE,
                "target" => "BudgetHeader",
                "userActor" => $data['userIri'],
                "propertyChanged" => "type",
                "oldValue" => $oldBh[0]->type->id,
                "newValue" => $this->getItemFromIri($data['typeIri'])->label,
                "budgetHeader" => "/api/budget_headers/" . $result->id
            ];
            $history->createHistory($logs);
        }

        return $result;
    }
}