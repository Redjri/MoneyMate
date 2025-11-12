<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM transactions WHERE user_id = $user_id ORDER BY date DESC");
$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MoneyMate - Catatan Keuangan</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <span class="navbar-brand">💰 MoneyMate</span>
    <div class="ms-auto text-white">
        Halo, <?= $_SESSION['username']; ?> |
        <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
    </div>
</nav>

<div class="container mt-4">
    <h3 class="mb-3">Catatan Keuangan</h3>
    <a href="add.php" class="btn btn-primary mb-3">+ Tambah Catatan</a>

    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Jenis</th>
                <th>Jumlah (Rp)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['date']; ?></td>
                <td><?= htmlspecialchars($row['description']); ?></td>
                <td><?= $row['type'] == 'income' ? 'Pemasukan' : 'Pengeluaran'; ?></td>
                <td><?= number_format($row['amount'], 2, ',', '.'); ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</a>
                </td>
            </tr>
            <?php
                if ($row['type'] == 'income') $total += $row['amount'];
                else $total -= $row['amount'];
            ?>
        <?php endwhile; ?>
        </tbody>
    </table>

    <div class="alert alert-info text-end">
        <strong>Total Saldo: Rp <?= number_format($total, 2, ',', '.'); ?></strong>
    </div>
</div>
</body>
</html>
