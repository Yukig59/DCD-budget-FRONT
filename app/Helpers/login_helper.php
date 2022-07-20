<?php
if (!function_exists('checkLogin')) {
    function isLoggedIn($session): bool
    {
        if (!array_key_exists('email', $session->get())) {
            return false;
        } else {
            return true;
        }
    }
}
