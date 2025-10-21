<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran Ujian Rekrutmen LPK JECA Melalui BBPVP Serang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="p-8">
        <div class="max-w-4xl mx-auto bg-white p-8 shadow-lg rounded-lg">
            <div class="flex mb-10 flex-wrap justify-between">
                <img src="../assets/img/logo.png" alt="Logo" class="mx-auto rounded-xl p-2 shadow-lg mb-4 w-32 h-auto">
                <h1 class="text-3xl font-bold text-center text-gray-800">Formulir Pendaftaran Ujian Rekrutmen LPK JECA Melalui BBPVP Serang</h1>
                <div class="bg-yellow-100 p-4 rounded-lg mt-4 text-left text-gray-700">
                    <h2 class="font-bold">PERHATIAN!</h2>
                    <p>1. Baca dengan seksama data yang dibutuhkan untuk mengisi formulir ini.</p>
                    <p>2. Siapkan data yang sesuai dengan kebutuhan formulir ini.</p>
                    <p>3. Periksa kembali dan pastikan data yang Anda isikan sesuai sebelum submit.</p>
                    <p>4. Setelah submit silahkan untuk langsung mendownload Kartu Peserta Ujian Anda.</p>
                    <p>5. Cetak Kartu Peserta Ujian Anda ke sebuah kertas HVS ukuran A4.</p>
                    <p>6. Simpan dengan baik dan bawa Kartu Peserta Ujian saat pelaksanaan Ujian.</p>
                    <p>7. Pendaftaran hanya dapat dilakukan 1 kali, jadi pastikan semua data Anda sesuai.</p>
                </div>
            </div>

            <form id="kandidatForm" action="../process/register_peserta.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                <div>
                    <label class="block font-medium text-gray-700">Pas Foto (<span class="font-bold">UKURAN 3X4 FORMAT JPG</span>)</label>
                    <input type="file" name="pas_foto" accept="image/jpeg" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label class="block font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label class="block font-medium text-gray-700">Tempat & Tanggal Lahir</label>
                    <input type="text" name="tempat_lahir" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                    <input type="date" name="tanggal_lahir" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label class="block font-medium text-gray-700">Umur (Isikan Angka Saja)</label>
                    <input type="text" name="umur" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label class="block font-medium text-gray-700">Pendidikan Terakhir (Nama Instansi)</label>
                    <input type="text" name="pendidikan_terakhir" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label class="block font-medium text-gray-700">Jenis Kelamin</label>
                    <select name="jenis_kelamin" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block font-medium text-gray-700">No. Telepon</label>
                    <input type="text" name="no_telp" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label class="block font-medium text-gray-700">Email</label>
                    <input type="email" name="email" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label class="block font-medium text-gray-700">Alamat Lengkap (<span class="font-bold">SESUAIKAN DENGAN KTP</span>)</label>
                    <textarea name="alamat" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline"></textarea>
                </div>
                <div class="flex justify-end mt-6">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md">Submit</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>