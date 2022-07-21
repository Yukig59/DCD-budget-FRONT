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
}
