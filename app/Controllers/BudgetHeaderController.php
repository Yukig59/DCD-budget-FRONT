<?php

namespace App\Controllers;

use App\Models\BudgetHeaderModel;
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


    }

    public function add()
    {


        $session = session();
        $request = $_POST;
        $type = new TypeModel();
        $request['serviceIri'] = "/api/services/" . $session->serviceId;
        $request['typeIri'] = "/api/types/" . $type->getTypeByLabel($request['type'])[0]->id;
        $request['code'] = $session->service;
        $request['user'] = $session->email;

        $bh = new BudgetHeaderModel();
       if ($bh->addBudgetHeader($request)){
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
}