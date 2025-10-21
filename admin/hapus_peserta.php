<?php
require '../config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data peserta untuk menghapus pas foto jika ada
    $stmt = $pdo->prepare("SELECT pas_foto FROM peserta WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $peserta = $stmt->fetch();

    if ($peserta) {
        // Hapus file pas foto jika ada
        if (!empty($peserta['pas_foto']) && file_exists($peserta['pas_foto'])) {
            unlink($peserta['pas_foto']);
        }

        // Hapus data peserta dari database
        $stmt = $pdo->prepare("DELETE FROM peserta WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

    // Redirect kembali ke halaman manajemen peserta dengan pesan sukses
    header("Location: manajemen_peserta.php?status=deleted");
    exit();
} else {
    // Redirect jika tidak ada ID
    header("Location: manajemen_peserta.php");
    exit();
}
