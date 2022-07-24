<?php

namespace App\Models;


class UserModel extends AbstractModel
{
    const URL = "https://127.0.0.1:8000/api/users";

    public function getUsers($code)
    {
        $items = $this->requestData(self::URL . "?service.code=" . $code);
        return $items ?? FALSE;
    }

    public function getAllUsers()
    {
        $items = $this->requestData(self::URL);
        return $items ?? FALSE;
    }

    public function logUser($email, $hashedPass)
    {
        $url = self::URL . "?email=$email&password=$hashedPass";
        // ?? -> if triplet
        return $this->requestData($url) ?? false;
    }

    public function checkIfEmailAlreadyExists($email): bool
    {
        $items = $this->requestData(self::URL . "?email=$email");
        return (bool)$items;

    }

    public function getUserById($id)
    {
        $items = $this->requestData(self::URL . "?id=" . $id);
        return $items ?? FALSE;
    }

    public function register($data)
    {
        $email = $data['userEmail'];
        $nom = $data['userNom'];
        $prenom = $data['userPrenom'];
        $serviceId = $data['userService'];
        $serviceIri = "/api/services/" . $serviceId;
        $postData = [
            "email" => $email,
            "password" => $data['userPassword'],
            "nom" => $nom,
            "prenom" => $prenom,
            "dateCreation" => (int)date_create()->getTimestamp(),
            "service" => $serviceIri
        ];
        return $this->sendData($postData, self::URL);

    }

    public function revoke($id)
    {
        $url = self::URL . "/" . $id;
        return $this->deleteData($url);
    }

    public function sendNotification($data)
    {
        $url = self::URL . "/" . $data['targetUserId'];
        $notif = [
            "notifications" => [
                "fromService" => $data['fromService'],
                "fromUser" => $data['fromUser'],
                "montant" => $data['montant'],
                "secret" => [
                    "askForBhId" => $data['secret']['askForBhId']
                ]
            ],
        ];
        return $this->patchData($notif, $url);
    }
}