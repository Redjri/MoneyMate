<?php
header('Content-Type: application/json');
include '../db.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? 0;

if ($id) {
    $query = $conn->prepare("DELETE FROM transactions WHERE id=?");
    $query->bind_param("i", $id);
    $query->execute();
    echo json_encode(['success' => true, 'message' => 'Transaction deleted']);
} else {
    echo json_encode(['success' => false, 'message' => 'Transaction ID required']);
}
?>
