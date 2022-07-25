<?php

namespace App\Controllers;

use App\Models\BudgetHeaderModel;
use App\Models\FournisseurModel;
use App\Models\MarketModel;
use App\Models\PurchaseOrderModel;
use App\Models\ServiceModel;
use App\Models\TypeModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        helper('number');
        $data['session'] = session();
        $bh = new BudgetHeaderModel();

        $data['BudgetHeadersF'] = $bh->getBudgetHeadersByType($data['session']->service, "Fonctionnement");
        $data['BudgetHeadersI'] = $bh->getBudgetHeadersByType($data['session']->service, "Investissement");
        $data['totalInvestissement'] = 0;
        $data['totalDepensesInvestissement'] = 0;
        $data['NbreLigneInvestissement'] = 0;
        $data['totalFonctionnement'] = 0;
        $data['totalDepensesFonctionnement'] = 0;
        $data['NbreLigneFonctionnement'] = 0;
        foreach ($data['BudgetHeadersI'] as $bh) {
            $data['totalInvestissement'] += $bh->budgetReel;
            $data['totalDepensesInvestissement'] += $bh->depenses;
            $data['NbreLigneInvestissement']++;
        }
        foreach ($data['BudgetHeadersF'] as $bh) {
            $data['totalFonctionnement'] += $bh->budgetPrevisionnel;
            $data['totalDepensesFonctionnement'] += $bh->depenses;
            $data['NbreLigneFonctionnement']++;
        }
        $marche = new MarketModel();
        $user = new UserModel();
        $actualUserNotif = empty($user->getUserById($data['session']->userId)[0]->notifications) ? null : $user->getUserById($data['session']->userId)[0]->notifications;

        $data['notification'] = $actualUserNotif;
        $fournisseur = new FournisseurModel();
        $bh = new BudgetHeaderModel();
        $data['budgetHeaders'] = $bh->getAllBudgetHeaders($data['session']->service);
        $data['fournisseurs'] = $fournisseur->getFournisseursByService($data['session']->service);
        $data['users'] = $user->getUsers($data['session']->service);
        $data['marches'] = $marche->getMarketsByService($data['session']->service);
        return view('dashboard.php', $data);
    }

    public function powerBi()
    {
        $service = new ServiceModel();
        $po = new PurchaseOrderModel();
        $bh = new BudgetHeaderModel();
        $marche = new MarketModel();
        $fournisseur = new FournisseurModel();
        $type = new TypeModel();
        $user = new UserModel();
        $data = [
            "services" => $service->getServices(),
            "budgetHeaders" => $bh->getBudgetHeaders(),
            "purchaseOrders" => $po->getAllPurchaseOrders(),
            "marches" => $marche->getAllMarkets(),
            "fournisseurs" => $fournisseur->getAllFournisseurs(),
            "types" => $type->getAllTypes(),
            "users" => $user->getAllUsers()
        ];
        return $this->response->setStatusCode(200)->setJSON($data);
    }

    public function deleteNotification($userId)
    {
        $url = "https://localhost:8000/api/users/" . $userId;
        $patchData = [
            "notifications" => []
        ];
        $user = new UserModel();
     
        if ($user->patchData($patchData, $url)->id) {
            return redirect()->to('/dashboard')->with('message', 'Demande refusée !');
        } else
            return redirect()->to('/dashboard')->with('message', 'Une erreur s\'est produite, veuillez réessayer');

    }
}