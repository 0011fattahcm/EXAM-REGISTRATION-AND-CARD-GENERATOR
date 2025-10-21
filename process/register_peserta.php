<?php
require '../config/database.php';

// Ambil pengaturan dari database
$pengaturan_stmt = $pdo->query("SELECT * FROM pengaturan LIMIT 1");
$pengaturan = $pengaturan_stmt->fetch(PDO::FETCH_ASSOC);

// Cek apakah pendaftaran masih dibuka
$tanggal_sekarang = date("Y-m-d");
if ($tanggal_sekarang < $pengaturan['tanggal_mulai'] || $tanggal_sekarang > $pengaturan['tanggal_akhir']) {
    die("Error: Pendaftaran belum dibuka atau sudah ditutup.");
}

// Cek apakah jumlah peserta sudah mencapai batas
$jumlah_peserta_stmt = $pdo->query("SELECT COUNT(*) as total FROM peserta");
$jumlah_peserta = $jumlah_peserta_stmt->fetch(PDO::FETCH_ASSOC)['total'];

if ($jumlah_peserta >= $pengaturan['batas_peserta']) {
    die("Error: Kuota peserta sudah penuh.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_lengkap = $_POST['nama_lengkap'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $umur = $_POST['umur'];
    $pendidikan_terakhir = $_POST['pendidikan_terakhir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_telp = $_POST['no_telp'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];

    // Cek apakah email sudah ada di database
    $cekEmail = $pdo->prepare("SELECT id FROM peserta WHERE email = :email");
    $cekEmail->execute([':email' => $email]);

    if ($cekEmail->rowCount() > 0) {
        header("Location: ../peserta/daftar.php?error=Email sudah terdaftar!");
        exit();
    }

    // Proses Upload Pas Foto
    $target_dir = "../assets/img/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0775, true); // Pastikan folder ada & bisa ditulis
    }

    // Cek apakah file diunggah
    if (isset($_FILES["pas_foto"]) && $_FILES["pas_foto"]["error"] == 0) {
        $file_ext = strtolower(pathinfo($_FILES["pas_foto"]["name"], PATHINFO_EXTENSION));

        // Pastikan format file JPG
        if ($file_ext != "jpg" && $file_ext != "jpeg") {
            die("Error: Hanya file JPG yang diperbolehkan.");
        }

        // Buat nama file unik
        $file_name = uniqid("foto_") . "." . $file_ext;
        $target_file = $target_dir . $file_name;

        // Simpan file
        if (!move_uploaded_file($_FILES["pas_foto"]["tmp_name"], $target_file)) {
            die("Error: Gagal mengunggah foto.");
        }

        // Simpan path ke database (tanpa `../`)
        $db_file_path = "../assets/img/" . $file_name;
    } else {
        die("Error: Tidak ada file yang diunggah.");
    }

    try {
        $sql = "INSERT INTO peserta (pas_foto, nama_lengkap, tempat_lahir, tanggal_lahir, umur, pendidikan_terakhir, jenis_kelamin, no_telp, email, alamat)
                VALUES (:pas_foto, :nama_lengkap, :tempat_lahir, :tanggal_lahir, :umur, :pendidikan_terakhir, :jenis_kelamin, :no_telp, :email, :alamat)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':pas_foto' => $db_file_path,
            ':nama_lengkap' => $nama_lengkap,
            ':tempat_lahir' => $tempat_lahir,
            ':tanggal_lahir' => $tanggal_lahir,
            ':umur' => $umur,
            ':pendidikan_terakhir' => $pendidikan_terakhir,
            ':jenis_kelamin' => $jenis_kelamin,
            ':no_telp' => $no_telp,
            ':email' => $email,
            ':alamat' => $alamat
        ]);

        // Ambil ID peserta yang baru saja dimasukkan
        $id_peserta = $pdo->lastInsertId();

        // Bersihkan output sebelum redirect
        ob_clean();
        header("Location: ../peserta/terima_kasih.php?id=" . $id_peserta);
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    header("Location: ../peserta/daftar.php");
    exit();
}
