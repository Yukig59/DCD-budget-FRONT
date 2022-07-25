<?php

namespace App\Models;

class PurchaseOrderModel extends AbstractModel
{
    const URL = "https://localhost:8000/api/purchase_orders";

    public function getAllPurchaseOrdersByService($code)
    {
        $url = self::URL . "?service.code=" . $code;
        return $this->requestData($url) ?? false;

    }

    public function getPurchaseOrderById($id)
    {
        $url = self::URL . "/" . $id;
        return $this->requestData($url) ?? false;

    }

    public function getAllPurchaseOrders()
    {
        $url = self::URL;
        return $this->requestData($url) ?? false;

    }

    public function add($data)
    {
        $type = new TypeModel();
        $postData = [
            "number" => $data['number'],
            "imputation" => intval($data['imputation']),
            "label" => $data['label'],
            "montant" => floatval($data['montant']),
            "dateCreation" => date_create()->getTimestamp(),
            "dateValidation" => null,
            "fournisseur" => array_key_exists('fournisseurId', $data) ? "/api/fournisseurs/" . $data['fournisseurId'] : null,
            "marche" => "/api/marches/" . $data['marcheId'],
            "type" => "/api/types/" . $type->getTypeByLabel($data['type'])[0]->id,
            "emetteur" => "/api/users/" . $data['emetteurId'],
            "validator" => $data['validateurId'] ? "/api/users/" . $data['validateurId'] : null,
            "budgetHeader" => "/api/budget_headers/" . $data['bhId'],
            "service" => "/api/services/" . $data['service']
        ];
        $result = $this->sendData($postData, self::URL);
        $history = new HistoryModel();
        $poLog = [
            "date" => (int)date_create()->getTimestamp(),
            "action" => self::CREATE,
            "target" => "Bon de commande",
            "userActor" => $data['userIri'],
            "purchaseOrder" => "/api/purchase_orders/" . $result->id,
            "service" => "/api/services/" . $data['service'],
        ];
        $this->sendData($poLog, "https://localhost:8000/api/logs");
        $newBhData = [
            "montant" => $result->montant,
            "bhId" => $data['bhId'],
            "userIri" => $data['userIri'],
        ];
        $bh = new BudgetHeaderModel();
        return $bh->addPoToBh($newBhData);
    }

    public function delete($data)
    {
        $bh = new BudgetHeaderModel();
        $bh = $bh->getBudgetHeaderById($data['PO']->budgetHeader->id);
        $url = self::URL . "/" . $data['id'];
        var_dump($this->deleteData($url));
        if ($this->deleteData($url)) {
            $logs = [
                "date" => date_create()->getTimestamp(),
                "action" => self::DELETE,
                "target" => "Bon de commande",
                "userActor" => $data['userIri'],
                "propertyChanged" => "Dépenses",
                "oldValue" => strval($bh->depenses),
                "newValue" => strval($bh->depenses - $data['PO']->montant),
                "budgetHeader" => "/api/budget_headers/" . $data['PO']->budgetHeader->id
            ];
            $history = new HistoryModel();
            var_dump($history->createHistory($logs));
            $newBhData = [
                "id" => $data['PO']->budgetHeader->id,
                "budgetReel" => $bh->budgetReel + $data['PO']->montant,
                "depenses" => $bh->budgetReel - $data['PO']->montant
            ];
            return $this->patchData($newBhData, 'https://localhost:8000/api/budget_headers/' . $newBhData['id']);
        } else {
            return false;
        }
    }

    public function edit($data)
    {
        $type = new TypeModel();

        $postData = [
            "number" => $data['number'],
            "imputation" => intval($data['imputation']),
            "label" => $data['label'],
            "montant" => floatval($data['montant']),
            "fournisseur" => array_key_exists('fournisseurId', $data) ? "/api/fournisseurs/" . $data['fournisseurId'] : null,
            "marche" => "/api/marches/" . $data['marcheId'],
            "type" => "/api/types/" . $type->getTypeByLabel($data['type'])[0]->id,
            "emetteur" => "/api/users/" . $data['emetteurId'],
            "budgetHeader" => "/api/budget_headers/" . $data['bhId'],
        ];
        $result = $this->patchData($postData, self::URL . "/" . $data['id']);
        $history = new HistoryModel();

        $poLog = [
            "date" => (int)date_create()->getTimestamp(),
            "action" => self::UPDATE,
            "target" => "Bon de commande",
            "userActor" => $data['userIri'],
            "purchaseOrder" => "/api/purchase_orders/" . $result->id,
            "service" => "/api/services/" . $data['service'],
        ];
        return $history->createHistory($poLog);
    }
}