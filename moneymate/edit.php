<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM transactions WHERE id=$id");
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $desc = $_POST['description'];
    $type = $_POST['type'];
    $amount = $_POST['amount'];

    $stmt = $conn->prepare("UPDATE transactions SET date=?, description=?, type=?, amount=? WHERE id=?");
    $stmt->bind_param("sssdi", $date, $desc, $type, $amount, $id);
    $stmt->execute();

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Catatan</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Edit Catatan Keuangan</h3>
    <form method="POST">
        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="date" class="form-control" value="<?= $data['date']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <input type="text" name="description" class="form-control" value="<?= $data['description']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Jenis</label>
            <select name="type" class="form-select">
                <option value="income" <?= $data['type']=='income'?'selected':''; ?>>Pemasukan</option>
                <option value="expense" <?= $data['type']=='expense'?'selected':''; ?>>Pengeluaran</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Jumlah (Rp)</label>
            <input type="number" name="amount" class="form-control" step="0.01" value="<?= $data['amount']; ?>" required>
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
