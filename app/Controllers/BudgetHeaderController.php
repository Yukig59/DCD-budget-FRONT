<?php

namespace App\Controllers;

use App\Models\BudgetHeaderModel;

class BudgetHeaderController extends BaseController
{

    public function index()
    {$session = session();
        checkLogin($session);
        var_dump(checkLogin($session));

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
        checkLogin();


    }

    public function add()
    {
        checkLogin();

        $session = session();
        $request = $_POST;
        $request['code'] = $session->service;
        $request['user'] = $session->email;

        $bh = new BudgetHeaderModel();
        $result = ($bh->addBudgetHeader($request));
        var_dump($result);
    }

    public function delete($id)
    {
        checkLogin();


        $bh = new BudgetHeaderModel();

        if ($bh->deleteBh($id) == '') {
            return redirect()->to('/budget-headers')->with('message', 'Ligne de budget supprimé avec succès !');
        } else
            return redirect()->to('/budget-headers')->with('message', 'Une erreur s\'est produite, veuillez réessayer');
    }
}