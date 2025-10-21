<?php
session_start(); // Memulai session
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
require '../config/database.php';

// Pastikan ID peserta tersedia
if (!isset($_GET['id'])) {
    die("ID peserta tidak ditemukan!");
}

$id = $_GET['id'];

// Ambil data peserta berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM peserta WHERE id = :id");
$stmt->execute(['id' => $id]);
$peserta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$peserta) {
    die("Peserta tidak ditemukan!");
}

// Jika form dikirim, update data peserta
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

    // Proses upload pas foto jika ada perubahan
    if ($_FILES['pas_foto']['size'] > 0) {
        $target_dir = "../assets/img/";
        $file_ext = strtolower(pathinfo($_FILES["pas_foto"]["name"], PATHINFO_EXTENSION));

        // Pastikan file JPG
        if ($file_ext != "jpg" && $file_ext != "jpeg") {
            die("Error: Hanya file JPG yang diperbolehkan.");
        }

        // Nama file unik
        $file_name = uniqid("foto_") . "." . $file_ext;
        $target_file = $target_dir . $file_name;

        if (!move_uploaded_file($_FILES["pas_foto"]["tmp_name"], $target_file)) {
            die("Error: Gagal mengunggah foto.");
        }

        // Hapus foto lama jika ada
        if (file_exists("../" . $peserta['pas_foto'])) {
            unlink("../" . $peserta['pas_foto']);
        }

        $db_file_path = "../assets/img/" . $file_name;
    } else {
        $db_file_path = $peserta['pas_foto']; // Gunakan foto lama jika tidak diubah
    }

    // Update data peserta di database
    $sql = "UPDATE peserta SET 
                pas_foto = :pas_foto, 
                nama_lengkap = :nama_lengkap, 
                tempat_lahir = :tempat_lahir, 
                tanggal_lahir = :tanggal_lahir, 
                umur = :umur, 
                pendidikan_terakhir = :pendidikan_terakhir, 
                jenis_kelamin = :jenis_kelamin, 
                no_telp = :no_telp, 
                email = :email, 
                alamat = :alamat
            WHERE id = :id";

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
        ':alamat' => $alamat,
        ':id' => $id
    ]);

    // Redirect kembali ke halaman detail peserta
    header("Location: detail_peserta.php?id=" . $id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Peserta</title>
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

    <!-- Konten Edit Peserta -->
    <div class="flex-1 p-8">
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold text-center mb-6">Edit Peserta</h1>

            <form method="POST" enctype="multipart/form-data" class="space-y-6">

                <div>
                    <label class="block font-medium text-gray-700">Pas Foto (JPG)</label>
                    <input type="file" name="pas_foto" accept=".jpg, .jpeg"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="<?php echo $peserta['nama_lengkap']; ?>" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Tempat & Tanggal Lahir</label>
                    <input type="text" name="tempat_lahir" value="<?php echo $peserta['tempat_lahir']; ?>" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <input type="date" name="tanggal_lahir" value="<?php echo $peserta['tanggal_lahir']; ?>" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Umur</label>
                    <input type="number" name="umur" value="<?php echo $peserta['umur']; ?>" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Pendidikan Terakhir</label>
                    <input type="text" name="pendidikan_terakhir" value="<?php echo $peserta['pendidikan_terakhir']; ?>" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Jenis Kelamin</label>
                    <input type="text" name="jenis_kelamin" value="<?php echo $peserta['jenis_kelamin']; ?>" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Nomor Telepon</label>
                    <input type="text" name="no_telp" value="<?php echo $peserta['no_telp']; ?>" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Email</label>
                    <input type="text" name="email" value="<?php echo $peserta['email']; ?>" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Alamat Lengkap</label>
                    <textarea name="alamat" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"><?php echo $peserta['alamat']; ?></textarea>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>