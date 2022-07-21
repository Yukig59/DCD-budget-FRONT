<?php

namespace App\Controllers;

use App\Models\BudgetHeaderModel;
use App\Models\HistoryModel;
use App\Models\TypeModel;

class BudgetHeaderController extends BaseController
{

    public function index()
    {
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
        $bh = new BudgetHeaderModel();
        $log = new HistoryModel();
        $data['bh'] = $bh->getBudgetHeaderById($bhId)[0];
        $data['logs'] = $log->getBhLogsById($bhId);
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

        if (isset($bh->updateHeaders($oldBh, $request)->id)) {
            return redirect()->to('/budget-headers')->with('message', 'Ligne de budget mise à jour avec succès !');
        } else{
            return redirect()->to('/budget-headers')->with('message', 'Une erreur s\'est produite, veuillez réessayer');
    }
}
}