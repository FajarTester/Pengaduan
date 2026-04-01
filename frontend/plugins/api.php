<?php
$autoloadPath = dirname(__DIR__) . '/vendor/autoload.php';

if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
} else {
    die("Vendor autoload tidak ditemukan.");
}

try {
    if (file_exists(dirname(__DIR__) . '/.env')) {
        $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
    }
} catch (Exception $e) {

}


$api_base_url = getenv('API_BASE_URL') ?: ($_ENV['API_BASE_URL'] ?? '');


if (!$api_base_url) {
    $api_base_url = "https://" . $_SERVER['HTTP_HOST'];
}
function api_request($method, $endpoint, $payload = null)
{
    global $api_base_url;

    $url = $api_base_url . '/api/' . $endpoint;

    if ($method === 'GET' && $payload) {
        $url .= '?' . http_build_query($payload);
    }

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

    // ✅ Hanya POST/PUT/PATCH yang pakai body
    if ($payload && in_array($method, ['POST', 'PUT', 'PATCH'])) {
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