<?php

namespace App\Models;

class PurchaseOrderModel extends AbstractModel
{
    const URL = "https://localhost:8000/api/purchase_orders";

    public function getAllPurchaseOrders($code)
    {
        $url = self::URL . "?service.code=" . $code;
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
            "fournisseur" => array_key_exists('fournisseurId',$data) ? "/api/fournisseurs/" . $data['fournisseurId'] : null,
            "marche" => "/api/marches/" . $data['marcheId'],
            "type" => "/api/types/".$type->getTypeByLabel($data['type'])[0]->id,
            "emetteur" => "/api/users/" . $data['emetteurId'],
            "validator" => $data['validateurId'] ? "/api/users/" . $data['validateurId'] : null,
            "budgetHeader" => "/api/budget_headers/" . $data['bhId'],
            "service" => "/api/services/" . $data['service']
        ];
        var_dump($this->sendData($postData, self::URL));
        die();
    }
}