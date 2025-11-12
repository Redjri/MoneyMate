<?php
header('Content-Type: application/json');
include '../db.php';

$user_id = $_GET['user_id'] ?? 0;

if (!$user_id) {
    echo json_encode(['success' => false, 'message' => 'User ID required']);
    exit;
}

$query = $conn->prepare("SELECT * FROM transactions WHERE user_id=? ORDER BY date DESC");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();

$transactions = [];
while ($row = $result->fetch_assoc()) {
    $transactions[] = $row;
}

echo json_encode(['success' => true, 'data' => $transactions]);
?>
