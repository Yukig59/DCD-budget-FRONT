<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{


    public function index()
    {
        $session = session();
        if ($session->getFlashdata('message') !== null) {
            $message = $session->getFlashdata('message');
        } else {
            $message = null;
        }
        $data = [
            'message' => $message
        ];
        return view('auth/login', $data);
    }

    public function login()
    {

        $session = session();
        if (empty($_POST)) {
            return redirect()->to('/login');
        }
        $request = $_POST;
        $email = $request['userEmail'];
        $password = ($request['userPassword']);
        $userModel = new UserModel();
        $user = $userModel->logUser($email, $password);
        if (!empty($user)) {
            $session_data = [
                'id' => $user[0]->id,
                'email' => $user[0]->email,
                'nom' => $user[0]->nom,
                'prenom' => $user[0]->prenom,
                'service' => $user[0]->service->code,
                'serviceId'=>$user[0]->service->id,
                'isLoggedIn' => TRUE
            ];
            $session->set($session_data);

            session_write_close();

            return redirect()->to('/dashboard');
        } else {

            return redirect()->to('/login')->with('message', 'Impossible de se connecter avec les données saisies');

        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();

        session_write_close();
        return redirect()->to('/login');
    }

    public function register()
    {


        return view("auth/register");
    }
}
