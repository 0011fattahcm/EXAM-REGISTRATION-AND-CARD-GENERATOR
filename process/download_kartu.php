<?php
require '../config/database.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

if (!isset($_GET['id'])) {
    die("ID peserta tidak ditemukan.");
}
$id = $_GET['id'];

// Ambil data peserta dari database
$stmt = $pdo->prepare("SELECT * FROM peserta WHERE id = :id");
$stmt->execute(['id' => $id]);
$peserta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$peserta) {
    die("Peserta tidak ditemukan.");
}

// Membuat file Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set font default dan border semua cell
$spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman')->setSize(11);
$sheet->getStyle('A1:L34')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
$sheet->getDefaultRowDimension()->setRowHeight(20);

// Tambahkan Logo
$logo = new Drawing();
$logo->setPath('../assets/img/logo.png');
$logo->setHeight(130);
$logo->setCoordinates('A1');
$logo->setOffsetX(30);
$logo->setOffsetY(20);
$logo->setWorksheet($sheet);
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);

// Merge untuk header dan kop perusahaan
$sheet->mergeCells('A1:C7');
$sheet->mergeCells('D1:I1');
$sheet->mergeCells('D2:I7');
$sheet->mergeCells('J1:L7');
$sheet->mergeCells('A8:L8');

$sheet->setCellValue('D1', 'PT GIKEN KAIZEN EDUCENTER');
$sheet->getStyle('D1')->getFont()->setBold(true);
$sheet->getStyle('D1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);

$sheet->setCellValue('D2', "LPK JAPAN EDUCATIONAL\nCOOPERATION ASSOCIATION");
$sheet->getStyle('D2')->getFont()->setBold(true)->setSize(20);
$sheet->getStyle('D2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
$sheet->getStyle('D2')->getAlignment()->setWrapText(true);

$sheet->setCellValue('J1', $peserta['id']);
$sheet->getStyle('J1')->getFont()->setBold(true)->setSize(20);
$sheet->getStyle('J1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);

$sheet->setCellValue('A8', 'KARTU PESERTA UJIAN');
$sheet->getStyle('A8')->getFont()->setBold(true);
$sheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);

// Merge untuk Foto dan Data Peserta
$sheet->mergeCells('A9:C17');
$sheet->mergeCells('D9:E9');
$sheet->mergeCells('F9:L9');
$sheet->setCellValue('D9', 'Nama Lengkap');
$sheet->setCellValue('F9', $peserta['nama_lengkap']);
$sheet->getStyle('D9:F9')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

// Tambahkan Pas Foto dengan ukuran yang sesuai
$foto = new Drawing();
$foto->setPath($peserta['pas_foto']);
$foto->setHeight(200);
$foto->setCoordinates('A9');
$foto->setOffsetX(20);
$foto->setOffsetY(10);
$foto->setWorksheet($sheet);
$sheet->getStyle('A9')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);


$sheet->mergeCells('D10:E10');
$sheet->mergeCells('F10:L10');
$sheet->setCellValue('D10', 'TTL');
$sheet->setCellValue('F10', $peserta['tempat_lahir'] . ', ' . $peserta['tanggal_lahir']);
$sheet->getStyle('D10:F10')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

$sheet->mergeCells('D11:E11');
$sheet->mergeCells('F11:L11');
$sheet->setCellValue('D11', 'Umur');
$sheet->setCellValue('F11', $peserta['umur'] . ' tahun');
$sheet->getStyle('D11:F11')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

$sheet->mergeCells('D12:E12');
$sheet->mergeCells('F12:L12');
$sheet->setCellValue('D12', 'Pendidikan Terakhir');
$sheet->setCellValue('F12', $peserta['pendidikan_terakhir']);
$sheet->getStyle('D12:F12')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);


$sheet->mergeCells('D13:E13');
$sheet->mergeCells('F13:L13');
$sheet->setCellValue('D13', 'Jenis Kelamin');
$sheet->setCellValue('F13', $peserta['jenis_kelamin']);
$sheet->getStyle('D13:F13')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

$sheet->mergeCells('D14:E14');
$sheet->mergeCells('F14:L14');
$sheet->setCellValue('D14', 'Nomor Telp');
$sheet->setCellValue('F14', $peserta['no_telp']);
$sheet->getStyle('D14:F14')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

$sheet->mergeCells('D15:E15');
$sheet->mergeCells('F15:L15');
$sheet->setCellValue('D15', 'Email');
$sheet->setCellValue('F15', $peserta['email']);
$sheet->getStyle('D15:F15')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

$sheet->mergeCells('D16:E16');
$sheet->mergeCells('F16:L17');
$sheet->setCellValue('D16', 'Alamat Lengkap');
$sheet->setCellValue('F16', $peserta['alamat']);
$sheet->getStyle('D16')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
$sheet->getStyle('F16')->getAlignment()->setVertical(Alignment::VERTICAL_TOP)->setHorizontal(Alignment::HORIZONTAL_LEFT);

// Area Kosong dan Tanda Tangan
$sheet->mergeCells('D17:E17');
$sheet->mergeCells('A18:L18');
$sheet->mergeCells('A19:C24');
$sheet->mergeCells('H19:H24');
$sheet->mergeCells('D20:G24');
$sheet->mergeCells('I20:L24');
$sheet->mergeCells('A25:L27');
$sheet->mergeCells('D19:G19');
$sheet->mergeCells('I19:L19');
$sheet->setCellValue('D19', 'Tanda Tangan Peserta');
$sheet->setCellValue('I19', 'Tanda Tangan Pengawas');
$sheet->getStyle('D19:I19')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);

// Area Perhatian
$sheet->mergeCells('A28:L28');
$sheet->setCellValue('A28', 'PERHATIAN');
$sheet->getStyle('A28')->getFont()->setBold(true);
$sheet->getStyle('A28')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);

$sheet->mergeCells('A29:L34');
$sheet->setCellValue('A29', "1. Kartu Peserta Ujian Rekrutmen LPK JECA ini WAJIB dibawa saat pelaksanaan Ujian.\n2. Peserta wajib membawa Kartu Identitas Diri (ASLI) yang tercantum pada kartu ini.\n3. Kartu Peserta Ujian tidak boleh rusak, terlipat, atau terkena cairan.\n4. Jika Kartu Peserta Ujian hilang, peserta diwajibkan untuk mencetak ulang.\n5. Peserta diwajibkan untuk mematuhi segala peraturan yang berlaku selama ujian berlangsung.\n6. Pastikan daya handphone terisi penuh saat akan melaksanakan ujian.");
$sheet->getStyle('A29')->getAlignment()->setVertical(Alignment::VERTICAL_TOP)->setHorizontal(Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('A29')->getAlignment()->setWrapText(true);

// Simpan dan Download File
$filename = "Kartu_Peserta_" . $peserta['id'] . "_" . str_replace(' ', '_', $peserta['nama_lengkap']) . ".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$writer = new Xlsx($spreadsheet);
$writer->save("php://output");
exit();
