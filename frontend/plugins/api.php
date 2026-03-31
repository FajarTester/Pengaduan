<?php
$autoloadPath = dirname(__DIR__) . '/vendor/autoload.php';

if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
} else {
    // Jangan langsung die, kita berikan pesan yang jelas untuk debug
    echo "Debug Path: " . $autoloadPath . "<br>";
    die("Vendor autoload tidak ditemukan. Jika ini di Vercel, pastikan folder vendor sudah di-upload atau composer install berhasil.");
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$api_base_url = $_ENV['API_BASE_URL'];

function api_request($method, $endpoint, $payload = null)
{
    global $api_base_url;

    $url = $api_base_url . '/api/' . $endpoint;
    $ch = curl_init($url);

    $headers = [
        "Content-Type: application/json",
        "Accept: application/json"
    ];

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    if ($payload) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    }

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        return [
            'success' => false,
            'error' => curl_error($ch)
        ];
    }

    return json_decode($response, true);
}
?>