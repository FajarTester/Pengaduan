<?php
require_once __DIR__ . '/../plugins/api.php';

class Auth
{
    public static function login($username, $password)
    {
        $payload = [
            'username' => $username,
            'password' => $password
        ];

        $response = api_request('POST', 'auth/login', $payload);

        if (isset($response['success']) && $response['success']) {
            return $response['data'];
        }
        return false;
    }

    public static function register($username, $password)
    {
        $payload = [
            'username' => $username,
            'password' => $password
        ];

        $response = api_request('POST', 'auth/register', $payload);

        if (isset($response['success']) && $response['success']) {
            return $response['data'];
        }
        return false;
    }
}
?>