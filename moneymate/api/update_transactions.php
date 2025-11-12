<?php
header('Content-Type: application/json');
include '../db.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? 0;
$description = $data['description'] ?? '';
$amount = $data['amount'] ?? 0;
$type = $data['type'] ?? '';
$date = $data['date'] ?? '';

if ($id && $description && $amount && $type && $date) {
    $query = $conn->prepare("UPDATE transactions SET description=?, amount=?, type=?, date=? WHERE id=?");
    $query->bind_param("sdssi", $description, $amount, $type, $date, $id);
    $query->execute();
    echo json_encode(['success' => true, 'message' => 'Transaction updated']);
} else {
    echo json_encode(['success' => false, 'message' => 'Missing data']);
}
?>
