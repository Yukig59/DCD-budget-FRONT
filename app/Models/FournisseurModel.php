<?php

namespace App\Models;

class FournisseurModel extends AbstractModel
{
    const URL = "https://127.0.0.1:8000/api/fournisseurs";
    public function getFournisseurs($code)
    {
        $items = $this->requestData(self::URL."?service.code=" . $code);
        return $items ?? FALSE;
    }

    public function addFournisseur($data){
        $postData = [
            "raisonSociale"=>$data['raisonSociale'],
            "addressLine1"=>$data['addr1'],
            "addressLine2"=>$data['addr2'],
            "zipCode"=>(int)$data['zipcode'],
            "city"=>$data['city'],
            "telephone"=>(string)$data['telephone'],
            "siret"=>(string)$data['siret'],
            "service"=>$data['serviceIri'],
        ];
        return $this->sendData($postData, self::URL);
    }
    public function deleteFournisseur($id){
        $url = self::URL."/". $id;
        return $this->deleteData($url);
    }
}