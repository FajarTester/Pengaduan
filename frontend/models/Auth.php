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

    public static function getByEmail($email)
    {
        $payload = ['email' => $email];
        $response = api_request('GET', 'admin/email?' . http_build_query($payload));

        if (isset($response['success']) && $response['success']) {
            return $response['data'];
        }
        return null;
    }


    public static function register($username, $password, $email)
    {
        $payload = [
            'email' => $email,
            'username' => $username,
            'password' => $password,
        ];

        $response = api_request('POST', 'auth/register', $payload);

    
        if (isset($response['success']) && $response['success'] === true) {
            return true;
        }
        return false;
    }
}
?>