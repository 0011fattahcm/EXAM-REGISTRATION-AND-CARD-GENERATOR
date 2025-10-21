<?php
session_start(); // Memulai session
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
require '../config/database.php';

if (!isset($_GET['id'])) {
    echo "ID peserta tidak ditemukan!";
    exit();
}

$id = $_GET['id'];

// Ambil data peserta berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM peserta WHERE id = :id");
$stmt->execute(['id' => $id]);
$peserta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$peserta) {
    echo "Peserta tidak ditemukan!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peserta</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <div class="w-64 bg-blue-900 text-white min-h-screen p-6">
        <h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>
        <ul class="space-y-4">
            <li><a href="dashboard.php" class="block p-2 hover:bg-blue-700 rounded">Dashboard</a></li>
            <li><a href="manajemen_peserta.php" class="block p-2 hover:bg-blue-700 rounded">Data Peserta</a></li>
            <li><a href="pengaturan.php" class="block p-2 hover:bg-blue-700 rounded">Pengaturan</a></li>
            <li><a href="logout.php" class="block p-2 hover:bg-blue-700 rounded">Logout</a></li>
        </ul>
    </div>

    <!-- Konten Detail Peserta -->
    <div class="flex-1 p-8">
        <div class="max-w-5xl mx-auto bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold text-center mb-8">Detail Peserta</h1>

            <!-- Foto Peserta -->
            <div class="text-center mb-8">
                <img src="<?php echo $peserta['pas_foto']; ?>" alt="Pas Foto"
                    class="w-30 h-40 mx-auto rounded-lg shadow-md border border-gray-300">
            </div>

            <!-- Tabel Data Peserta -->
            <table class="w-full border-collapse border border-gray-300 text-lg">
                <tr>
                    <th class="p-4 border bg-gray-100 text-left">ID</th>
                    <td class="p-4 border"><?php echo $peserta['id']; ?></td>
                </tr>
                <tr>
                    <th class="p-4 border bg-gray-100 text-left">Nama Lengkap</th>
                    <td class="p-4 border"><?php echo $peserta['nama_lengkap']; ?></td>
                </tr>
                <tr>
                    <th class="p-4 border bg-gray-100 text-left">Tempat & Tanggal Lahir</th>
                    <td class="p-4 border"><?php echo $peserta['tempat_lahir'] . ", " . $peserta['tanggal_lahir']; ?></td>
                </tr>
                <tr>
                    <th class="p-4 border bg-gray-100 text-left">Umur</th>
                    <td class="p-4 border"><?php echo $peserta['umur']; ?> Tahun</td>
                </tr>
                <tr>
                    <th class="p-4 border bg-gray-100 text-left">Pendidikan Terakhir</th>
                    <td class="p-4 border"><?php echo $peserta['pendidikan_terakhir']; ?></td>
                </tr>
                <tr>
                    <th class="p-4 border bg-gray-100 text-left">Jenis Kelamin</th>
                    <td class="p-4 border"><?php echo $peserta['jenis_kelamin']; ?></td>
                </tr>
                <tr>
                    <th class="p-4 border bg-gray-100 text-left">No. Telepon</th>
                    <td class="p-4 border"><?php echo $peserta['no_telp']; ?></td>
                </tr>
                <tr>
                    <th class="p-4 border bg-gray-100 text-left">Email</th>
                    <td class="p-4 border"><?php echo $peserta['email']; ?></td>
                </tr>
                <tr>
                    <th class="p-4 border bg-gray-100 text-left">Alamat</th>
                    <td class="p-4 border"><?php echo $peserta['alamat']; ?></td>
                </tr>
            </table>

            <!-- Tombol Cetak Kartu Peserta -->
            <div class="text-center mt-8">
                <a href="../process/download_kartu.php?id=<?php echo $peserta['id']; ?>"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded text-lg font-semibold">
                    Cetak Kartu Peserta Ujian
                </a>
            </div>
        </div>
    </div>

</body>

</html>