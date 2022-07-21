<?php

namespace App\Controllers;

use App\Models\ServiceModel;
use App\Models\UserModel;
use Couchbase\User;

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
        $password = $request['userPassword'];
        $userModel = new UserModel();
        $user = $userModel->logUser($email, $password);
        if (!empty($user)) {
            $session_data = [
                'id' => $user[0]->id,
                'email' => $user[0]->email,
                'nom' => $user[0]->nom,
                'prenom' => $user[0]->prenom,
                'service' => $user[0]->service->code,
                'serviceId' => $user[0]->service->id,
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
        if (empty($_POST)) {
            $session = session();
            if ($session->getFlashdata('message') !== null) {
                $message = $session->getFlashdata('message');
            } else {
                $message = null;
            }
            $service = new ServiceModel();
            $services = $service->getServices();
            $data = [
                'message' => $message,
                'services' => $services
            ];

            return view("auth/register", $data);
        } else {

            $request = $_POST;
            $user = new UserModel();
            if ($request['userPassword'] != $request['userPasswordSecond']) {
                return redirect()->to('/register')->with('message', 'Les mots de passe saisis sont différents !');
            }
            if ($user->checkIfEmailAlreadyExists($request['userEmail'])) {
                return redirect()->to('/register')->with('message', 'Cet email est déja inscrit !');
            }

            if (isset($user->register($request)->id)) {
                return redirect()->to('/login')->with('message', 'Inscription réussie !');
            } else {
                return redirect()->to('/register')->with('message', 'Une erreur est survenue, veuillez réessayer');
            }
        }
    }

    public function delete($id)
    {
        $session = session();
        if ($session->id == $id) {
            return redirect()->to('/gestion-service')->with('message', 'Vous ne pouvez pas supprimer un compte connecté.');
        } else {
            $user = new UserModel();
            if ($user->revoke($id) == '') {
                return redirect()->to('/gestion-service')->with('message', 'Utilisateur supprimé avec succès !');
            } else
                return redirect()->to('/gestion-service')->with('message', 'Une erreur s\'est produite, veuillez réessayer');
        }
    }
}

