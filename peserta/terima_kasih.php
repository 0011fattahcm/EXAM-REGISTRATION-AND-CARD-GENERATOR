<?php
if (!isset($_GET['id'])) {
    header("Location: daftar.php");
    exit();
}
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md text-center">
        <h2 class="text-2xl font-bold text-green-600">Pendaftaran Berhasil!</h2>
        <p class="mt-2">Terima kasih telah mendaftar, kami telah menerima data Anda.</p>
        <p class="mt-2">Silakan klik tombol di bawah ini untuk mengunduh kartu peserta ujian Anda.</p>

        <a href="../process/download_kartu.php?id=<?= urlencode($id) ?>"
            class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Download Kartu Peserta
        </a>
    </div>
</body>

</html>