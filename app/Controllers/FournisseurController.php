<?php

namespace App\Controllers;

use App\Models\FournisseurModel;
use App\Models\MarketModel;
use App\Models\TypeModel;

class FournisseurController extends BaseController
{
    public function add()
    {

        $session = session();
        $request = $_POST;

        $request['user'] = $session->email;
        $fournisseur = new FournisseurModel();
        $request['serviceIri'] = "/api/services/" . $session->serviceId;

        if ($fournisseur->addFournisseur($request)) {
            return redirect()->to('/gestion-service')->with('message', 'Fournisseur créé avec succes !');
        } else {
            return redirect()->to('/gestion-service')->with('message', 'Une erreur s\'est produite, veuillez réessayer');
        }
    }

    public function delete($id)
    {

        $fournisseur = new FournisseurModel();
        if ($fournisseur->deleteFournisseur($id) == '') {
            return redirect()->to('/gestion-service')->with('message', 'Fournisseur supprimé avec succès !');
        } else
            return redirect()->to('/gestion-service')->with('message', 'Une erreur s\'est produite, veuillez réessayer');
    }

    public function edit($id)
    {
        $fournisseur = new FournisseurModel();
        $data['session'] = session();
        if (isset($_POST) && !empty($_POST)) {
            $request = $_POST;
            $request['serviceIri'] = "/api/services/" . $data['session']->serviceId;
            $request['id'] = $id;
       
            if ($fournisseur->updateFournisseur($request)->id) {
                return redirect()->to('/gestion-service')->with('message', 'Fournisseur mis à jour avec succès !');
            } else {
                return redirect()->to('/gestion-service')->with('message', 'Une erreur s\'est produite, veuillez réessayer');
            }
        } else {
            $data['fournisseur'] = $fournisseur->getFournisseursById($id);
            return view('serviceManagement/showFournisseur', $data);
        }
    }
}