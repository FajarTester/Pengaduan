<?php
require_once __DIR__ . '/../plugins/api.php';

class Aspirasi
{
    public static function getAll()
    {
        $response = api_request('GET', 'aspirasi');

        if (isset($response['success']) && $response['success']) {
            return $response['data'] ?? [];
        }
        return [];
    }

    public static function getById($id)
    {
        $response = api_request('GET', 'aspirasi/' . $id);

        if (isset($response['success']) && $response['success']) {
            return $response['data'];
        }
        return null;
    }

    public static function create($status, $id_kategori, $feedback)
    {
        $payload = [
            'status' => $status,
            'id_kategori' => $id_kategori,
            'feedback' => $feedback
        ];
        $status = trim($status);
        $payload['status'] = $status;
        $id_kategori = intval($id_kategori);
        $payload['id_kategori'] = $id_kategori;
        $feedback = trim($feedback);
        $payload['feedback'] = $feedback;

        $response = api_request('POST', 'aspirasi', $payload);

        if (isset($response['success']) && $response['success']) {
            return $response['data'];
        }
        return false;
    }

    public static function update($id, $status, $feedback)
    {
        $payload = [
            'status' => $status,
            'feedback' => $feedback
        ];

        $response = api_request('PUT', 'aspirasi/' . $id, $payload);

        if (isset($response['success']) && $response['success']) {
            return true;
        }
        return false;
    }

    public static function updateByPelaporan($id_pelaporan, $status, $feedback)
    {
        // Admin update status + feedback untuk aspirasi berdasarkan id_pelaporan
        $payload = [
            'status' => $status,
            'feedback' => $feedback
        ];

        // Call the new aspirasi endpoint for updating by pelaporan
        $response = api_request('PUT', 'aspirasi/pelaporan/' . $id_pelaporan, $payload);

        if (isset($response['success']) && $response['success']) {
            return true;
        }

        return false;
    }
}
?>