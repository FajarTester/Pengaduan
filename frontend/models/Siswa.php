<?php
require_once __DIR__ . '/../plugins/api.php';

class Siswa
{
    public static function getByNis($nis)
    {
        $response = api_request('GET', 'siswa/' . $nis);

        if (isset($response['success']) && $response['success']) {
            return $response['data'];
        }
        return null;
    }

    public static function create($nis, $kelas)
    {
        $payload = [
            'nis' => $nis,
            'kelas' => $kelas
        ];

        $nis = intval($nis);
        $payload['nis'] = $nis;
        $response = api_request('POST', 'siswa', $payload);

        if (isset($response['success']) && $response['success']) {
            return $response['data'];
        }
        return false;
    }

    public static function getAll()
    {
        $response = api_request('GET', 'siswa');

        if (isset($response['success']) && $response['success']) {
            return $response['data'] ?? [];
        }
        return [];
    }
}
?>