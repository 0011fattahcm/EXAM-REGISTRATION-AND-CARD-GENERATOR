<?php
session_start(); // Memulai session
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Card Generator</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex">
    <?php
    require '../config/database.php';

    // Ambil data dari database
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM peserta");
    $total_peserta = $stmt->fetch()['total'];

    $stmt = $pdo->query("SELECT COUNT(*) as laki FROM peserta WHERE jenis_kelamin = 'Laki-laki'");
    $peserta_laki = $stmt->fetch()['laki'];

    $stmt = $pdo->query("SELECT COUNT(*) as perempuan FROM peserta WHERE jenis_kelamin = 'Perempuan'");
    $peserta_perempuan = $stmt->fetch()['perempuan'];
    ?>

    <!-- Sidebar -->
    <div class="w-64 bg-blue-900 text-white min-h-screen p-6">
        <h2 class="text-xl text-center font-bold mb-6">CARD GENERATOR</h2>
        <ul class="space-y-4">
            <li><a href="dashboard.php" class="block p-2 bg-blue-700 rounded">Dashboard</a></li>
            <li><a href="manajemen_peserta.php" class="block p-2 hover:bg-blue-700 rounded">Data Peserta</a></li>
            <li><a href="pengaturan.php" class="block p-2 hover:bg-blue-700 rounded">Pengaturan</a></li>
            <li><a href="logout.php" class="block p-2 hover:bg-blue-700 rounded">Logout</a></li>
        </ul>
    </div>

    <!-- Konten Dashboard -->
    <div class="flex-1 p-6">
        <h1 class="text-3xl font-bold mb-6">Selamat Datang, Admin</h1>

        <div class="grid grid-cols-3 gap-6">
            <!-- Card Total Peserta -->
            <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center text-center border-l-4 border-blue-500">
                <h2 class="text-xl font-semibold text-gray-700">Total Peserta</h2>
                <p class="text-4xl font-bold text-blue-600 mt-2"><?php echo $total_peserta; ?></p>
            </div>

            <!-- Card Peserta Laki-laki -->
            <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center text-center border-l-4 border-green-500">
                <h2 class="text-xl font-semibold text-gray-700">Peserta Laki-laki</h2>
                <p class="text-4xl font-bold text-green-600 mt-2"><?php echo $peserta_laki; ?></p>
            </div>

            <!-- Card Peserta Perempuan -->
            <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center text-center border-l-4 border-pink-500">
                <h2 class="text-xl font-semibold text-gray-700">Peserta Perempuan</h2>
                <p class="text-4xl font-bold text-pink-600 mt-2"><?php echo $peserta_perempuan; ?></p>
            </div>
        </div>
    </div>
</body>

</html>