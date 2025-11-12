<?php
header('Content-Type: application/json');
include '../db.php';

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

$response = ['success' => false, 'message' => ''];

if ($username && $password) {
    $query = $conn->prepare("SELECT * FROM users WHERE username=?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $response['success'] = true;
        $response['message'] = "Login success";
        $response['user_id'] = $user['id'];
    } else {
        $response['message'] = "Invalid username or password";
    }
} else {
    $response['message'] = "Username and password required";
}

echo json_encode($response);
?>
