<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action  = $_POST['action'] ?? '';
    $id      = (int)($_POST['id'] ?? 0);
    $nama    = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $jam     = mysqli_real_escape_string($koneksi, $_POST['jam']);
    $raket   = (int)$_POST['raket'];
    $sepatu  = (int)$_POST['sepatu'];
    $bola    = (int)$_POST['bola'];

    $total_bayar = ($raket * 25000) + ($sepatu * 25000) + ($bola * 25000);

    if ($action == 'create') {
        mysqli_query($koneksi, "INSERT INTO pemesanan (nama, tanggal, jam, raket, sepatu, bola, total_bayar)
            VALUES ('$nama', '$tanggal', '$jam', '$raket', '$sepatu', '$bola', '$total_bayar')");
    } elseif ($action == 'update') {
        mysqli_query($koneksi, "UPDATE pemesanan SET
            nama='$nama', tanggal='$tanggal', jam='$jam',
            raket='$raket', sepatu='$sepatu', bola='$bola',
            total_bayar='$total_bayar' WHERE id=$id");
    }

    header("Location: data.php");
    exit();
}

$isEdit = false;
$editData = ['id' => '', 'nama' => '', 'tanggal' => '', 'jam' => '', 'raket' => 0, 'sepatu' => 0, 'bola' => 0];

if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $res = mysqli_query($koneksi, "SELECT * FROM pemesanan WHERE id=$id");
    if ($row = mysqli_fetch_assoc($res)) {
        $isEdit = true;
        $editData = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Input Pemesanan - Rental Alat Olahraga</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav>
        <a href="index.php" class="active">Input Data</a>
        <a href="data.php">Data Pemesanan</a>
    </nav>

    <div class="box" style="max-width: 600px; margin-bottom: 30px;">
        <h1>Sewa Alat Olahraga</h1>
        <h2><?= $isEdit ? 'Edit Data Pemesanan' : 'Form Pemesanan Baru'; ?></h2>

        <form method="POST" action="index.php">
            <input type="hidden" name="id" value="<?= (int)$editData['id']; ?>">

            <label>Nama:</label><br>
            <input type="text" name="nama" value="<?= htmlspecialchars($editData['nama']); ?>" required><br><br>

            <label>Tanggal:</label><br>
            <input type="date" name="tanggal" value="<?= htmlspecialchars($editData['tanggal']); ?>" required><br><br>

            <label>Jam:</label><br>
            <input type="time" name="jam" value="<?= htmlspecialchars($editData['jam']); ?>" required><br><br>

            <h3>Pilih Jumlah Alat</h3>
            <table class="tabel1" style="width: 100%; margin-bottom: 20px;">
                <thead>
                    <tr><th>Alat</th><th>Harga</th><th>Jumlah</th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Raket Badminton</td>
                        <td>25.000</td>
                        <td><input type="number" name="raket" min="0" value="<?= (int)$editData['raket']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Sepatu Futsal</td>
                        <td>25.000</td>
                        <td><input type="number" name="sepatu" min="0" value="<?= (int)$editData['sepatu']; ?>"></td>
                    </tr>
                    <tr>
                        <td>Bola Futsal</td>
                        <td>25.000</td>
                        <td><input type="number" name="bola" min="0" value="<?= (int)$editData['bola']; ?>"></td>
                    </tr>
                </tbody>
            </table>

            <?php if ($isEdit): ?>
                <button type="submit" name="action" value="update" class="btn" style="background: #f39c12;">Update Data</button>
                <a href="data.php" class="btn" style="background: #6c757d;">Batal</a>
            <?php else: ?>
                <button type="submit" name="action" value="create" class="btn">Simpan Data</button>
            <?php endif; ?>
        </form>
    </div>

</body>
</html>
