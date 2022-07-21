<?php

namespace App\Controllers;

use App\Models\BudgetHeaderModel;
use App\Models\FournisseurModel;
use App\Models\MarketModel;
use App\Models\PurchaseOrderModel;
use App\Models\UserModel;

class PurchaseOrderController extends BaseController
{
    public function index()
    {
        helper('number');

        $session = session();
        if ($session->getFlashdata('message') !== null) {
            $data['message'] = $session->getFlashdata('message');
        } else {
            $data['message'] = null;
        }
        $po = new PurchaseOrderModel();
        $marche = new MarketModel();
        $user = new UserModel();
        $fournisseur = new FournisseurModel();
        $bh = new BudgetHeaderModel();
        $data['budgetHeaders'] = $bh->getAllBudgetHeaders($session->service);
        $data['fournisseurs'] = $fournisseur->getFournisseurs($session->service);
        $data['users'] = $user->getUsers($session->service);
        $data['purchaseOrders'] = $po->getAllPurchaseOrders($session->service);
        $data['marches'] = $marche->getAllMarkets($session->service);
        return view('PO/index', $data);
    }

    public function add()
    {
        $request = $_POST;
        $session = session();
        $po = new PurchaseOrderModel();
        $request['service'] = $session->serviceId;
        var_dump($po->add($request));
        die();
    }
}