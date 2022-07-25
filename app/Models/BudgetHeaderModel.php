<?php

namespace App\Models;

use App\Helpers\CustomDateTime;
use DateTime;
use Exception;

class BudgetHeaderModel extends AbstractModel
{
    const URL = "https://localhost:8000/api/budget_headers";

    public function getAllBudgetHeaders($code)
    {
        $url = self::URL . "?service.code=" . $code;
        return $this->requestData($url) ?? false;

    }

    public function getBudgetHeaders()
    {
        $url = self::URL;
        return $this->requestData($url) ?? false;

    }

    public function getBudgetHeaderById($id)
    {
        $url = self::URL . "/" . $id;
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
            "target" => "Ligne de budget",
            "userActor" => $data['userIri'],
            "propertyChanged" => null,
            "oldValue" => null,
            "newValue" => null,
            "budgetHeader" => "/api/budget_headers/" . $result->id
        ];
        return $history->createHistory($logs);

    }

    public function getPurchaseOrders($id)
    {
        $url = self::URL . "/" . $id . "/purchase_orders";
        return $this->requestData($url);
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
                "target" => "Ligne de budget",
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
                "target" => "Ligne de budget",
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

    public function addPoToBh($data)
    {
        $url = self::URL . "/" . $data['bhId'];
        $montant = $data['montant'];
        $bh = $this->getBudgetHeaderById($data['bhId']);
        $log1 = [
            "date" => date_create()->getTimestamp(),
            "action" => self::CREATE,
            "target" => "Bon de commande",
            "userActor" => $data['userIri'],
            "propertyChanged" => "depenses",
            "oldValue" => strval($bh->depenses),
            "newValue" => strval($bh->depenses + $montant),
            "budgetHeader" => "/api/budget_headers/" . $data['bhId']
        ];

        $this->sendData($log1, "https://localhost:8000/api/logs");
        $putData = [
            "budgetReel" => $bh->budgetReel - $montant,
            "depenses" => $bh->depenses + $montant,
        ];
        return $this->patchData($putData, $url);
    }

    public function getBudgetHeadersByType($code, $type)
    {
        $url = self::URL . "?service.code=" . $code . "&type.label=" . $type;
        return $this->requestData($url) ?? false;
    }

    public function internalTransfert($data)
    {

        $history = new HistoryModel();
        $fromBh = $this->getBudgetHeaderById($data['fromBhId']);
        $toBh = $this->getBudgetHeaderById($data['toBhId']);
        $fromBhLog = [
            "date" => date_create()->getTimestamp(),
            "action" => self::TRANSFER,
            "target" => "Ligne de budget",
            "userActor" => $data['userIri'],
            "propertyChanged" => "depenses (virement effectué)",
            "oldValue" => strval($fromBh->depenses),
            "newValue" => strval($fromBh->depenses + floatval($data['montant'])),
            "budgetHeader" => "/api/budget_headers/" . $data['fromBhId']
        ];
        $fromBh->budgetReel -= $data['montant'];
        $fromBh->depenses += $data['montant'];
        $firstPatchData = [
            "budgetReel" => $fromBh->budgetReel,
            "depenses" => $fromBh->depenses
        ];
        $resultFromBh = $this->patchData($firstPatchData, self::URL . "/" . $data['fromBhId']);

        if ($resultFromBh) {
            $history->sendData($fromBhLog, "https://localhost:8000/api/logs");
        }

        $toBhLog = [
            "date" => date_create()->getTimestamp(),
            "action" => self::TRANSFER,
            "target" => "Ligne de budget",
            "userActor" => $data['userIri'],
            "propertyChanged" => "depenses (virement reçu)",
            "oldValue" => strval($toBh->budgetReel),
            "newValue" => strval($toBh->budgetReel + floatval($data['montant'])),
            "budgetHeader" => "/api/budget_headers/" . $data['toBhId']
        ];
        $toBh->budgetReel += $data['montant'];
        $resultToBh = $this->patchData([
            "budgetReel" => $toBh->budgetReel
        ], self::URL . "/" . $data['toBhId']);
        if ($resultToBh) {
            $this->sendData($toBhLog, "https://localhost:8000/api/logs");
        }
        return [$resultFromBh, $resultToBh];

    }

    public function externalTransfer($data)
    {
        $history = new HistoryModel();
        $fromBh = $this->getBudgetHeaderById($data['fromBhId']);
        $toBh = $this->getBudgetHeaderById($data['toBhId']);
        $fromBhLog = [
            "date" => date_create()->getTimestamp(),
            "action" => self::TRANSFER,
            "target" => "Ligne de budget",
            "userActor" => "/api/users/" . $data['fromUser'],
            "propertyChanged" => "depenses (virement effectué)",
            "oldValue" => strval($fromBh->depenses),
            "newValue" => strval($fromBh->depenses + floatval($data['montant'])),
            "budgetHeader" => "/api/budget_headers/" . $data['fromBhId']
        ];
        $fromBh->budgetReel -= $data['montant'];
        $fromBh->depenses += $data['montant'];
        $firstPatchData = [
            "budgetReel" => $fromBh->budgetReel,
            "depenses" => $fromBh->depenses
        ];
        $resultFromBh = $this->patchData($firstPatchData, self::URL . "/" . $data['fromBhId']);

        if ($resultFromBh) {
            $history->sendData($fromBhLog, "https://localhost:8000/api/logs");
        }

        $toBhLog = [
            "date" => date_create()->getTimestamp(),
            "action" => self::TRANSFER,
            "target" => "Ligne de budget",
            "userActor" => "/api/users/" . $data['fromUser'],
            "propertyChanged" => "depenses (virement reçu)",
            "oldValue" => strval($toBh->budgetReel),
            "newValue" => strval($toBh->budgetReel + floatval($data['montant'])),
            "budgetHeader" => "/api/budget_headers/" . $data['toBhId']
        ];
        $toBh->budgetReel += $data['montant'];
        $resultToBh = $this->patchData([
            "budgetReel" => $toBh->budgetReel
        ], self::URL . "/" . $data['toBhId']);
        if ($resultToBh) {
            $this->sendData($toBhLog, "https://localhost:8000/api/logs");
        }
        return [$resultFromBh, $resultToBh];

    }

}