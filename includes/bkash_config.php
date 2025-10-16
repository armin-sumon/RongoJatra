<?php
// includes/bkash_config.php
// Load existing DB config/connection ($dbh)
require_once __DIR__ . '/config.php';

// Sandbox base URL; change to production when going live
if (!defined('BKASH_BASE_URL')) {
    define('BKASH_BASE_URL', 'https://tokenized.sandbox.bka.sh/v1.2.0-beta/tokenized/checkout/');
}

// TODO: Fill with your sandbox credentials from bKash
if (!defined('BKASH_USERNAME')) define('BKASH_USERNAME', 'YOUR_SANDBOX_USERNAME');
if (!defined('BKASH_PASSWORD')) define('BKASH_PASSWORD', 'YOUR_SANDBOX_PASSWORD');
if (!defined('BKASH_APP_KEY')) define('BKASH_APP_KEY', 'YOUR_SANDBOX_APP_KEY');
if (!defined('BKASH_APP_SECRET')) define('BKASH_APP_SECRET', 'YOUR_SANDBOX_APP_SECRET');

// Publicly reachable URL where bKash redirects after approval/cancel/failure
if (!defined('BKASH_CALLBACK_URL')) {
    // For XAMPP under subfolder RongoJatra
    $scheme = isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    define('BKASH_CALLBACK_URL', $scheme . '://' . $host . '/RongoJatra/bkash/callback.php');
}

if (!defined('BKASH_CURRENCY')) define('BKASH_CURRENCY', 'BDT');

function bkash_validate_credentials() {
    foreach ([BKASH_USERNAME, BKASH_PASSWORD, BKASH_APP_KEY, BKASH_APP_SECRET] as $v) {
        if (strpos($v, 'YOUR_SANDBOX_') === 0) {
            throw new RuntimeException('bKash sandbox credentials are not set in includes/bkash_config.php');
        }
    }
}

function bkash_get_token() {
    bkash_validate_credentials();
    $url = rtrim(BKASH_BASE_URL, '/') . '/token/grant';
    $headers = [
        'Content-Type: application/json',
        'x-app-key: ' . BKASH_APP_KEY,
        'username: ' . BKASH_USERNAME,
        'password: ' . BKASH_PASSWORD,
    ];
    $body = json_encode([
        'app_key' => BKASH_APP_KEY,
        'app_secret' => BKASH_APP_SECRET,
    ], JSON_UNESCAPED_SLASHES);

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => $body,
        CURLOPT_TIMEOUT => 30,
    ]);
    $response = curl_exec($ch);
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err = curl_error($ch);
    curl_close($ch);

    if ($http !== 200 || !$response) {
        throw new RuntimeException('bKash token error: ' . $err . ' Response: ' . $response);
    }
    $data = json_decode($response, true);
    if (!isset($data['id_token'])) {
        throw new RuntimeException('bKash token missing id_token: ' . $response);
    }
    return $data['id_token'];
}

function bkash_api($path, $payload, $token) {
    $url = rtrim(BKASH_BASE_URL, '/') . '/' . ltrim($path, '/');
    $headers = [
        'Content-Type: application/json',
        'authorization: ' . $token,
        'x-app-key: ' . BKASH_APP_KEY,
    ];
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_SLASHES),
        CURLOPT_TIMEOUT => 60,
    ]);
    $response = curl_exec($ch);
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err = curl_error($ch);
    curl_close($ch);

    if ($http < 200 || $http >= 300 || !$response) {
        throw new RuntimeException('bKash API error: ' . $err . ' Response: ' . $response);
    }
    $data = json_decode($response, true);
    return is_array($data) ? $data : [];
}

// Defensive: ensure payment schema exists to avoid runtime SQL errors
function ensure_payment_schema(PDO $dbh) {
    // Create tblpayments if not exists
    $dbh->exec("CREATE TABLE IF NOT EXISTS tblpayments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        booking_id INT NOT NULL,
        payment_id VARCHAR(64) NOT NULL,
        trx_id VARCHAR(64) DEFAULT NULL,
        amount DECIMAL(10,2) NOT NULL,
        method VARCHAR(32) DEFAULT 'bKash',
        status ENUM('pending','success','failed','cancelled') NOT NULL DEFAULT 'pending',
        raw_response MEDIUMTEXT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY uniq_payment_id (payment_id),
        INDEX (booking_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // Ensure tblbooking has payment columns; use information_schema to avoid errors
    $dbNameStmt = $dbh->query('SELECT DATABASE() AS db');
    $dbRow = $dbNameStmt->fetch(PDO::FETCH_ASSOC);
    $dbName = $dbRow && !empty($dbRow['db']) ? $dbRow['db'] : 'RongoJatra';

    $colCheck = $dbh->prepare("SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = :db AND TABLE_NAME = 'tblbooking' AND COLUMN_NAME IN ('payment_status','paid_amount')");
    $colCheck->execute([':db' => $dbName]);
    $existing = array_map(function($r){ return $r['COLUMN_NAME']; }, $colCheck->fetchAll(PDO::FETCH_ASSOC));

    if (!in_array('payment_status', $existing)) {
        $dbh->exec("ALTER TABLE tblbooking ADD COLUMN payment_status ENUM('unpaid','pending','paid','failed','cancelled') NOT NULL DEFAULT 'unpaid'");
    }
    if (!in_array('paid_amount', $existing)) {
        $dbh->exec("ALTER TABLE tblbooking ADD COLUMN paid_amount DECIMAL(10,2) NULL");
    }
}


