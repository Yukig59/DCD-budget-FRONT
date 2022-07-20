<?php

namespace App\Models;


class UserModel extends AbstractModel
{
    const URL = "https://127.0.0.1:8000/api/users";

    public function getUsers($code)
    {
        $items = $this->requestData(self::URL."?service.code=" . $code);
        return $items ?? FALSE;
    }

    public function logUser($email, $hashedPass)
    {
        $url = self::URL . "?email=$email&password=$hashedPass";
        // ?? -> if triplet
        return $this->requestData($url) ?? false;
    }
}