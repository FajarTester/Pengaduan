<?php
require_once __DIR__ . '/../plugins/api.php';

class InputAspirasi
{
    public static function getAll()
    {
        $response = api_request('GET', 'input_aspirasi');

        if (isset($response['success']) && $response['success']) {
            return $response['data'] ?? [];
        }
        return [];
    }

    public static function getById($id)
    {
        $response = api_request('GET', 'input_aspirasi/' . $id);

        if (isset($response['success']) && $response['success']) {
            return $response['data'];
        }
        return null;
    }

    public static function getByNis($nis)
    {
        $response = api_request('GET', 'input_aspirasi/siswa/' . $nis);

        if (isset($response['success']) && $response['success']) {
            return $response['data'] ?? [];
        }
        return [];
    }

    public static function create($nis, $id_kategori, $lokasi, $ket)
    {
        $payload = [
            'nis' => $nis,
            'id_kategori' => $id_kategori,
            'lokasi' => $lokasi,
            'ket' => $ket
        ];

        $id_kategori = intval($id_kategori);
        $payload['id_kategori'] = $id_kategori;
        $ket = trim($ket);
        $payload['ket'] = $ket;
        $lokasi = trim($lokasi);
        $payload['lokasi'] = $lokasi;

        $response = api_request('POST', 'input_aspirasi', $payload);
        
        if (isset($response['success']) && $response['success']) {
            return $response['data'];
        }
        return false;
    }

    public static function update($id, $lokasi, $ket)
    {
        $payload = [
            'lokasi' => $lokasi,
            'ket' => $ket
        ];

        $response = api_request('PUT', 'input_aspirasi/' . $id, $payload);

        if (isset($response['success']) && $response['success']) {
            return true;
        }
        return false;
    }

    public static function delete($id)
    {
        $response = api_request('DELETE', 'input_aspirasi/' . $id);

        if (isset($response['success']) && $response['success']) {
            return true;
        }
        return false;
    }
}
?>