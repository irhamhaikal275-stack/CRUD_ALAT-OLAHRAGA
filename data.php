<?php
include 'koneksi.php';

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM pemesanan WHERE id=$id");
    header("Location: data.php");
    exit();
}

$dataPemesanan = mysqli_query($koneksi, "SELECT * FROM pemesanan ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Pemesanan - Rental Alat Olahraga</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav>
        <a href="index.php">Input Data</a>
        <a href="data.php" class="active">Data Pemesanan</a>
    </nav>

    <h1>Daftar Pemesanan (Data dari MySQL)</h1>
    <table class="tabel1" style="width: 95%;">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pemesan</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Raket</th>
                <th>Sepatu</th>
                <th>Bola</th>
                <th>Total Bayar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if (mysqli_num_rows($dataPemesanan) > 0) {
                while ($row = mysqli_fetch_assoc($dataPemesanan)) {
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['nama']); ?></td>
                    <td><?= htmlspecialchars($row['tanggal']); ?></td>
                    <td><?= htmlspecialchars($row['jam']); ?></td>
                    <td><?= (int)$row['raket']; ?></td>
                    <td><?= (int)$row['sepatu']; ?></td>
                    <td><?= (int)$row['bola']; ?></td>
                    <td>Rp <?= number_format($row['total_bayar'], 0, ',', '.'); ?></td>
                    <td>
                        <a href="index.php?edit=<?= (int)$row['id']; ?>" class="btn-sm btn-edit">Edit</a>
                        <a href="data.php?hapus=<?= (int)$row['id']; ?>" class="btn-sm btn-hapus" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                    </td>
                </tr>
            <?php
                }
            } else {
                echo '<tr><td colspan="9" style="text-align: center;">Belum ada data pemesanan.</td></tr>';
            }
            ?>
        </tbody>
    </table>

    <p><a href="index.php" class="btn">+ Tambah Pemesanan</a></p>

</body>
</html>
