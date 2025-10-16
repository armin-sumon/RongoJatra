<?php
session_start();
require_once __DIR__ . '/../includes/config.php';

try {
    $bookingId = isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : 0;
    $amount = isset($_POST['amount']) ? (float)$_POST['amount'] : 0;
    if ($bookingId <= 0 || $amount <= 0) {
        http_response_code(400);
        exit('Invalid booking or amount');
    }

    // Ensure tblpayments exists for logging test transactions
    $dbh->exec("CREATE TABLE IF NOT EXISTS tblpayments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        booking_id INT NOT NULL,
        payment_id VARCHAR(64) NOT NULL,
        trx_id VARCHAR(64) DEFAULT NULL,
        amount DECIMAL(10,2) NOT NULL,
        method VARCHAR(32) DEFAULT 'TestPay',
        status ENUM('pending','success','failed','cancelled') NOT NULL DEFAULT 'pending',
        raw_response MEDIUMTEXT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY uniq_payment_id (payment_id),
        INDEX (booking_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // Ensure tblbooking has payment_status and paid_amount
    $dbh->exec("ALTER TABLE tblbooking ADD COLUMN IF NOT EXISTS payment_status ENUM('unpaid','pending','paid','failed','cancelled') NOT NULL DEFAULT 'unpaid'");
    $dbh->exec("ALTER TABLE tblbooking ADD COLUMN IF NOT EXISTS paid_amount DECIMAL(10,2) NULL");

    // Create a fake transaction
    $paymentId = 'TESTPAY-' . $bookingId . '-' . time();
    $trxId = strtoupper(substr(md5($paymentId . mt_rand()), 0, 12));

    // Insert as pending; admin can confirm later
    $stmt = $dbh->prepare("INSERT INTO tblpayments (booking_id, payment_id, trx_id, amount, status, method, raw_response) VALUES (:bid, :pid, :trx, :amt, 'pending', 'TestPay', :raw)");
    $stmt->execute([
        ':bid' => $bookingId,
        ':pid' => $paymentId,
        ':trx' => $trxId,
        ':amt' => number_format($amount, 2, '.', ''),
        ':raw' => json_encode(['note' => 'Demo test payment created'], JSON_UNESCAPED_SLASHES),
    ]);

    // Mark booking payment pending
    $dbh->prepare("UPDATE tblbooking SET payment_status='pending', paid_amount=NULL WHERE BookingId=:id")->execute([':id' => $bookingId]);

    // Redirect to thankyou page with pending status and transaction id
    header('Location: /RongoJatra/thankyou.php?booking_id=' . $bookingId . '&status=pending&trx=' . urlencode($trxId));
    exit;
} catch (Throwable $e) {
    http_response_code(500);
    echo 'Test payment error: ' . htmlspecialchars($e->getMessage());
}


