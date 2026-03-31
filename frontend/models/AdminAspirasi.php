<?php
require_once __DIR__ . '/../plugins/api.php';

class AdminAspirasi
{

    public static function getAll(): array
    {
        $response = api_request('GET', 'aspirasi');

        if (isset($response['success']) && $response['success']) {
            return $response['data'] ?? [];
        }

        if (is_array($response) && !isset($response['success'])) {
            return $response;
        }

        return [];
    }

    public static function review(int $id_pelaporan, string $status, string $feedback, int $id_kategori): bool
    {
        $payload = [
            'id_pelaporan' => $id_pelaporan,
            'status' => $status,
            'feedback' => $feedback,
            'id_kategori' => $id_kategori,
        ];

        $response = api_request('POST', 'aspirasi', $payload);

        if (isset($response['success'])) {
            return (bool) $response['success'];
        }

        return false;
    }
}