<?php
header('Content-Type: application/json');
include '../db.php';

$data = json_decode(file_get_contents("php://input"), true);
$user_id = $data['user_id'] ?? 0;
$description = $data['description'] ?? '';
$amount = $data['amount'] ?? 0;
$type = $data['type'] ?? '';
$date = $data['date'] ?? date('Y-m-d');

if ($user_id && $description && $amount && $type) {
    $query = $conn->prepare("INSERT INTO transactions (user_id, description, amount, type, date) VALUES (?, ?, ?, ?, ?)");
    $query->bind_param("isdss", $user_id, $description, $amount, $type, $date);
    $query->execute();
    echo json_encode(['success' => true, 'message' => 'Transaction added']);
} else {
    echo json_encode(['success' => false, 'message' => 'Missing data']);
}
?>
