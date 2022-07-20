<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {        checkLogin();


        $session = session();
        $data = [
            "session"=>$session
        ];
        return view('dashboard.php',$data   );
    }
}