<?php

namespace App\Controllers;

use App\Models\BudgetHeaderModel;
use App\Models\HistoryModel;
use App\Models\TypeModel;
use App\Models\UserModel;

class BudgetHeaderController extends BaseController
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
        $code = $session->service;
        $bh = new BudgetHeaderModel();
        $budgetHeaders = $bh->getAllBudgetHeaders($code);
        $data['budgetHeaders'] = $budgetHeaders;
        return view('BH/index.php', $data);
    }

    public function show($bhId)
    {
        helper('iri');
        helper('number');
        $session = session();
        $bh = new BudgetHeaderModel();
        $log = new HistoryModel();
        $user = new UserModel();
        $data['users'] = $user->getAllUsers();
        $data['bh'] = $bh->getBudgetHeaderById($bhId);
        $data['budgetHeaders'] = $bh->getAllBudgetHeaders($session->service);
        $data['purchaseOrders'] = $bh->getPurchaseOrders($bhId);
        $data['logs'] = $log->getBhLogsById($bhId);
        $data['session'] = $session;
        return view('BH/show', $data);
    }

    public function add()
    {
        $session = session();
        $request = $_POST;
        $type = new TypeModel();
        $request['serviceIri'] = "/api/services/" . $session->serviceId;
        $request['typeIri'] = "/api/types/" . $type->getTypeByLabel($request['type'])[0]->id;
        $request['userIri'] = "/api/users/" . $session->id;
        $request['code'] = $session->service;
        $request['user'] = $session->email;

        $bh = new BudgetHeaderModel();

        if (isset($bh->addBudgetHeader($request)->id)) {
            return redirect()->to('/budget-headers')->with('message', 'Ligne de budget créée avec succes !');
        } else {
            return redirect()->to('/budget-headers')->with('message', 'Une erreur s\'est produite, veuillez réessayer');
        }

    }

    public function delete($id)
    {

        $bh = new BudgetHeaderModel();

        if ($bh->deleteBh($id) == '') {
            return redirect()->to('/budget-headers')->with('message', 'Ligne de budget supprimé avec succès !');
        } else
            return redirect()->to('/budget-headers')->with('message', 'Une erreur s\'est produite, veuillez réessayer');
    }

    public function updateHeaders()
    {
        $request = $_POST;
        $session = session();
        $bh = new BudgetHeaderModel();
        $type = new TypeModel();
        $request['userIri'] = "/api/users/" . $session->id;
        $request['typeIri'] = "/api/types/" . $type->getTypeByLabel($request['type'])[0]->id;
        $oldBh = $bh->getBudgetHeaderById($request['id']);

        if ($bh->updateHeaders($oldBh, $request)->id) {
            return redirect()->to('/budget-headers')->with('message', 'Ligne de budget mise à jour avec succès !');
        } else {
            return redirect()->to('/budget-headers')->with('message', 'Une erreur s\'est produite, veuillez réessayer');
        }
    }

    public function transfer()
    {
        $request = $_POST;
        $session = session();
        $request['userIri'] = "/api/users/" . $session->id;
        $bh = new BudgetHeaderModel();
        $request['fromBhIRI'] = "/api/budget_headers/" . $request['fromBhId'];
        $request['toBhIRI'] = "/api/budget_headers/" . $request['toBhId'];
        if (count($bh->internalTransfert($request)) == 2) {
            return redirect()->to('/budget-headers')->with('message', 'Le virement a été effectué !');
        } else {
            return redirect()->to('/budget-headers')->with('message', 'Une erreur s\'est produite, veuillez réessayer');
        }
    }

    public function askCredit()
    {
        $request = $_POST;
        $session = session();
        $notification = [
            "fromService" => $session->service,
            "targetUserId" => $request['userIdToNotify'],
            "fromUser" => $session->id,
            "montant" => $request['montant'],
            "secret" => [
                "askForBhId" => $request['bhId']
            ],
        ];
        $user = new UserModel();
        if ($user->sendNotification($notification)->id) {
            return redirect()->to('/budget-headers')->with('message', 'La demande a été effectuée !');
        } else {
            return redirect()->to('/budget-headers')->with('message', 'Une erreur s\'est produite, veuillez réessayer');
        }

    }

    public function acceptVirement()
    {
        $request = $_POST;
        $request['fromUser'] = session()->id;
        $bh = new BudgetHeaderModel();
        if (count($bh->externalTransfer($request)) == 2) {
            return redirect()->to('/budget-headers')->with('message', 'Le virement a été éffectué !');
        } else {
            return redirect()->to('/budget-headers')->with('message', 'Une erreur s\'est produite, veuillez réessayer');

        }
    }
}