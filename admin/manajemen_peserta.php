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
    <title>Manajemen Data Peserta</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex">
    <?php
    require '../config/database.php';

    // Pagination
    $limit = 20;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // Pencarian dan filter
    $whereClause = " WHERE 1=1 ";
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $whereClause .= " AND (nama_lengkap LIKE '%$search%' OR email LIKE '%$search%')";
    }
    if (isset($_GET['jenis_kelamin']) && $_GET['jenis_kelamin'] !== '') {
        $jenis_kelamin = $_GET['jenis_kelamin'];
        $whereClause .= " AND jenis_kelamin = '$jenis_kelamin'";
    }
    if (isset($_GET['pendidikan_terakhir']) && $_GET['pendidikan_terakhir'] !== '') {
        $pendidikan = $_GET['pendidikan_terakhir'];
        $whereClause .= " AND pendidikan_terakhir = '$pendidikan'";
    }

    // Ambil data peserta dengan pagination dan urutan terbaru
    $stmt = $pdo->query("SELECT id, pas_foto, nama_lengkap, umur, pendidikan_terakhir, email FROM peserta" . $whereClause . " ORDER BY id DESC LIMIT $limit OFFSET $offset");
    $peserta = $stmt->fetchAll();

    // Hitung total data untuk pagination
    $stmtTotal = $pdo->query("SELECT COUNT(*) as total FROM peserta" . $whereClause);
    $totalData = $stmtTotal->fetch()['total'];
    $totalPages = ceil($totalData / $limit);
    ?>

    <!-- Sidebar -->
    <div class="w-64 bg-blue-900 text-white min-h-screen p-6">
        <h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>
        <ul class="space-y-4">
            <li><a href="dashboard.php" class="block p-2 hover:bg-blue-700 rounded">Dashboard</a></li>
            <li><a href="detail_peserta.php?id" class="block p-2 bg-blue-700 rounded">Data Peserta</a></li>
            <li><a href="pengaturan.php" class="block p-2 hover:bg-blue-700 rounded">Pengaturan</a></li>
            <li><a href="logout.php" class="block p-2 hover:bg-blue-700 rounded">Logout</a></li>
        </ul>
    </div>

    <!-- Konten Manajemen Peserta -->
    <div class="flex-1 p-6">
        <h1 class="text-3xl font-bold mb-6">Manajemen Data Peserta</h1>

        <!-- Form Pencarian dan Filter -->
        <form method="GET" class="mb-4 flex gap-4">
            <input type="text" name="search" placeholder="Cari Nama atau Email" class="p-2 border rounded w-1/3" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <select name="jenis_kelamin" class="p-2 border rounded">
                <option value="">Semua Jenis Kelamin</option>
                <option value="Laki-laki" <?php if (isset($_GET['jenis_kelamin']) && $_GET['jenis_kelamin'] == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                <option value="Perempuan" <?php if (isset($_GET['jenis_kelamin']) && $_GET['jenis_kelamin'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
            </select>
            <input type="text" name="pendidikan_terakhir" placeholder="Pendidikan Terakhir" class="p-2 border rounded" value="<?php echo isset($_GET['pendidikan_terakhir']) ? $_GET['pendidikan_terakhir'] : ''; ?>">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
        </form>

        <!-- Tabel Data Peserta -->
        <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
            <table class="w-full border-collapse border border-gray-200 text-sm">
                <thead>
                    <tr class="bg-blue-500 text-white text-center">
                        <th class="border border-gray-200 p-2">ID</th>
                        <th class="border border-gray-200 p-2">Pas Foto</th>
                        <th class="border border-gray-200 p-2">Nama Lengkap</th>
                        <th class="border border-gray-200 p-2">Umur</th>
                        <th class="border border-gray-200 p-2">Pendidikan Terakhir</th>
                        <th class="border border-gray-200 p-2">Email</th>
                        <th class="border border-gray-200 p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($peserta as $index => $row): ?>
                        <tr class="<?php echo $index % 2 == 0 ? 'bg-gray-100' : 'bg-white'; ?> text-center">
                            <td class="border border-gray-200 p-2"><?php echo $row['id']; ?></td>
                            <td class="border border-gray-200 p-2">
                                <img src="<?php echo $row['pas_foto']; ?>" alt="Pas Foto" class="h-12 w-12 rounded-full mx-auto">
                            </td>
                            <td class="border border-gray-200 p-2"><?php echo $row['nama_lengkap']; ?></td>
                            <td class="border border-gray-200 p-2"><?php echo $row['umur']; ?></td>
                            <td class="border border-gray-200 p-2"><?php echo $row['pendidikan_terakhir']; ?></td>
                            <td class="border border-gray-200 p-2"><?php echo $row['email']; ?></td>
                            <td class="border border-gray-200 p-2">
                                <a href="detail_peserta.php?id=<?php echo $row['id']; ?>" class="bg-blue-500 text-white px-3 py-1 rounded">Detail</a>
                                <a href="edit_peserta.php?id=<?php echo $row['id']; ?>" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>
                                <button onclick="confirmDelete(<?php echo $row['id']; ?>)" class="bg-red-500 text-white px-3 py-1 rounded">Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 flex justify-center space-x-2">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" class="px-3 py-1 border rounded <?php echo $i == $page ? 'bg-blue-500 text-white' : 'bg-white'; ?>"> <?php echo $i; ?> </a>
            <?php endfor; ?>
        </div>
    </div>
</body>

<!-- Pop-up Konfirmasi Hapus -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">
        <h2 class="text-xl font-bold">Konfirmasi Hapus</h2>
        <p class="mt-2">Apakah Anda yakin ingin menghapus peserta ini?</p>
        <div class="mt-4 flex justify-center space-x-4">
            <button onclick="hideModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
            <a id="deleteConfirm" href="#" class="bg-red-500 text-white px-4 py-2 rounded">Hapus</a>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        document.getElementById('deleteConfirm').href = 'hapus_peserta.php?id=' + id;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function hideModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>

</html>