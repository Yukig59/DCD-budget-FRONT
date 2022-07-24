<?php

namespace App\Controllers;

use App\Models\MarketModel;
use App\Models\TypeModel;

class MarketController extends BaseController
{
    public function add()
    {
        $session = session();
        $request = $_POST;
        $request['user'] = $session->email;
        $marche = new MarketModel();
        $type = new TypeModel();
        $request['serviceIri'] = "/api/services/" . $session->serviceId;
        $request['typeIri'] = "/api/types/" . $type->getTypeByLabel($request['typologie'])[0]->id;

        if ($marche->addMarket($request)) {
            return redirect()->to('/gestion-service')->with('message', 'Marché créé avec succes !');
        } else {
            return redirect()->to('/gestion-service')->with('message', 'Une erreur s\'est produite, veuillez réessayer');
        }
    }

    public function delete($id)
    {


        $market = new MarketModel();
        if ($market->deleteMarket($id) == '') {
            return redirect()->to('/gestion-service')->with('message', 'Marché supprimé avec succès !');
        } else
            return redirect()->to('/gestion-service')->with('message', 'Une erreur s\'est produite, veuillez réessayer');
    }

    public function edit($id)
    {
        helper('iri');
        if (isset($_POST) && !empty($_POST)) {
            $data = $_POST;
            $startDate = date_create($data['startDate'])->getTimestamp();
            $endDate = date_create($data['endDate'])->getTimestamp();
            $type = new TypeModel();
            $postData = [
                "label" => $data['label'],
                "code" => $data['numero'],
                "dateDebut" => (int)$startDate,
                "dateFin" => (int)$endDate,
                "type" => "/api/types/" . $type->getTypeByLabel($data['typologie'])[0]->id
            ];
            $market = new MarketModel();

            if ($market->patchData($postData, $market::URL . "/$id")->id) {

                return redirect()->to('/gestion-service')->with('message', 'Marché modifié avec succès !');
            } else {
                return redirect()->to('/gestion-service')->with('message', 'Une erreur s\'est produite, veuillez réessayer');
            }
        } else {
            $market = new MarketModel();
            $data['market'] = $market->getMarketById($id);
            $data['session'] = session();
            $iri = $data['market']->type;
            $data['market']->type = getItemFromIri($iri);
            return view('serviceManagement/showMarket', $data);
        }
    }


}
