<?php
session_start(); // Memulai session
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
require '../config/database.php';


// Cek apakah data pengaturan sudah ada
$stmt = $pdo->query("SELECT * FROM pengaturan LIMIT 1");
$pengaturan = $stmt->fetch(PDO::FETCH_ASSOC);

// Jika tabel `pengaturan` kosong, tambahkan data default
if (!$pengaturan) {
    $default_sql = "INSERT INTO pengaturan (batas_peserta, tanggal_mulai, tanggal_akhir) 
                    VALUES (100, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY))";
    $pdo->query($default_sql);

    // Ambil ulang data setelah menambahkan default
    $stmt = $pdo->query("SELECT * FROM pengaturan LIMIT 1");
    $pengaturan = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Jika form dikirim, update pengaturan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $batas_peserta = $_POST['batas_peserta'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_akhir = $_POST['tanggal_akhir'];

    $sql = "UPDATE pengaturan SET batas_peserta = :batas_peserta, tanggal_mulai = :tanggal_mulai, tanggal_akhir = :tanggal_akhir WHERE id = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':batas_peserta' => $batas_peserta,
        ':tanggal_mulai' => $tanggal_mulai,
        ':tanggal_akhir' => $tanggal_akhir
    ]);

    header("Location: pengaturan.php?success=Pengaturan berhasil diperbarui!");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Sistem</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <div class="w-64 bg-blue-900 text-white min-h-screen p-6">
        <h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>
        <ul class="space-y-4">
            <li><a href="dashboard.php" class="block p-2 hover:bg-blue-700 rounded">Dashboard</a></li>
            <li><a href="manajemen_peserta.php" class="block p-2 hover:bg-blue-700 rounded">Data Peserta</a></li>
            <li><a href="pengaturan.php" class="block p-2 bg-blue-700 rounded">Pengaturan</a></li>
            <li><a href="#" class="block p-2 hover:bg-blue-700 rounded">Logout</a></li>
        </ul>
    </div>

    <!-- Konten Pengaturan -->
    <div class="flex-1 p-8">
        <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold text-center mb-6">Pengaturan Sistem</h1>

            <?php if (isset($_GET['success'])): ?>
                <p class="text-green-500 text-center"><?php echo $_GET['success']; ?></p>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <div>
                    <label class="block font-medium text-gray-700">Batas Maksimal Peserta</label>
                    <input type="number" name="batas_peserta" value="<?php echo htmlspecialchars($pengaturan['batas_peserta']); ?>" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Tanggal Mulai Pendaftaran</label>
                    <input type="date" name="tanggal_mulai" value="<?php echo htmlspecialchars($pengaturan['tanggal_mulai']); ?>" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Tanggal Akhir Pendaftaran</label>
                    <input type="date" name="tanggal_akhir" value="<?php echo htmlspecialchars($pengaturan['tanggal_akhir']); ?>" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md">Simpan Pengaturan</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>