<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $desc = $_POST['description'];
    $type = $_POST['type'];
    $amount = $_POST['amount'];
    $uid = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO transactions (user_id, date, description, type, amount) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssd", $uid, $date, $desc, $type, $amount);
    $stmt->execute();

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Catatan</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Tambah Catatan Keuangan</h3>
    <form method="POST">
        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <input type="text" name="description" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Jenis</label>
            <select name="type" class="form-select">
                <option value="income">Pemasukan</option>
                <option value="expense">Pengeluaran</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Jumlah (Rp)</label>
            <input type="number" name="amount" class="form-control" step="0.01" required>
        </div>
        <button class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
