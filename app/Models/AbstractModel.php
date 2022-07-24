<?php

namespace App\Models;

abstract class AbstractModel
{
    const CREATE = "create";
    const READ = "read";
    const UPDATE = "update";
    const TRANSFER = "transfer";
    const DELETE = "delete";

    public function requestData(string $url)
    {
        $headers = array('Content-Type: application/json',);
        // Open connection
        $ch = curl_init();
        // Set the url, number of GET vars, GET data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute request
        $result = curl_exec($ch);

        // Close connection
        curl_close($ch);
        // get the result and parse to JSON
        return json_decode($result) ?? false;
    }

    public function sendData($data, $url)
    {

        $payload = json_encode($data, JSON_UNESCAPED_SLASHES);
        $headers = array('Content-Type: application/json',);
        // Open connection
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


        /* set the content type json */
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($payload))
        );
        /* set return type json */
        /* execute request */
        $result = curl_exec($ch);
        // Close connection
        curl_close($ch);
        // get the result and parse to JSON
        return json_decode($result);
    }

    public function deleteData($url)
    {
        $headers = array('Content-Type: application/json',);
        // Open connection
        $ch = curl_init();
        // Set the url, number of GET vars, GET data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute request
        $result = curl_exec($ch);

        // Close connection
        curl_close($ch);
        return $result;
    }

    public function patchData($data, $url)
    {
        $payload = json_encode($data, JSON_UNESCAPED_SLASHES);
        // Open connection
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        /* set the content type json */
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/merge-patch+json',
                'Content-Length: ' . strlen($payload))
        );

        /* set return type json */
        /* execute request */
        $result = curl_exec($ch);
        // Close connection
        curl_close($ch);
        // get the result and parse to JSON
        return json_decode($result);
    }

    public function getItemFromIri($iri)
    {
        $url = "https://localhost:8000" . $iri;
        return $this->requestData($url);
    }
}