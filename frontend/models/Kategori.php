<?php
require_once __DIR__ . '/../plugins/api.php';

class Kategori
{
    public static function getAll()
    {
        $response = api_request('GET', 'kategori');

        if (isset($response['success']) && $response['success']) {
            return $response['data'] ?? [];
        }
        return [];
    }

    public static function getById($id)
    {
        $response = api_request('GET', 'kategori/' . $id);

        if (isset($response['success']) && $response['success']) {
            return $response['data'];
        }
        return null;
    }

    public static function create($ket_kategori)
    {
        $payload = [
            'ket_kategori' => $ket_kategori
        ];

        $response = api_request('POST', 'kategori', $payload);

        if (isset($response['success']) && $response['success']) {
            return $response['data'];
        }
        return false;
    }
}
?>