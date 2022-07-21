<?php

namespace App\Controllers;

use App\Models\FournisseurModel;
use App\Models\MarketModel;
use App\Models\UserModel;

class ServiceManagerController extends BaseController
{
    public function index()
    {

        $session = session();
        if ($session->getFlashdata('message') !== null) {
            $message = $session->getFlashdata('message');
        } else {
            $message = null;
        }
        $market = new MarketModel();
        $markets = $market->getAllMarkets($session->service);
        $user = new UserModel();
        $users = $user->getUsers($session->service);
        $fournisseur = new FournisseurModel();
        $fournisseurs = $fournisseur->getFournisseurs($session->service);
        $data = [
            'message' => $message,
            'markets' => $markets,
            "users" => $users,
            "fournisseurs" => $fournisseurs
        ];
        return view('serviceManagement/serviceIndex', $data);
    }
}