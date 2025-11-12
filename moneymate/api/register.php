<?php
header('Content-Type: application/json');
include '../db.php';

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

$response = ['success' => false, 'message' => ''];

if ($username && $password) {
    $check = $conn->prepare("SELECT * FROM users WHERE username=?");
    $check->bind_param("s", $username);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        $response['message'] = "Username already exists";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $insert = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $insert->bind_param("ss", $username, $hashed);
        $insert->execute();

        $response['success'] = true;
        $response['message'] = "Registration success";
    }
} else {
    $response['message'] = "Username and password required";
}

echo json_encode($response);
?>
