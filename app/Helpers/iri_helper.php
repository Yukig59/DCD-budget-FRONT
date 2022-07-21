<?php

use App\Models\BudgetHeaderModel;

if (!function_exists('getItemFromIri')) {
    function getItemFromIri($iri)
    {
        $bh = new BudgetHeaderModel();
        $url = "https://localhost:8000" . $iri;
        return $bh->requestData($url);
    }
}