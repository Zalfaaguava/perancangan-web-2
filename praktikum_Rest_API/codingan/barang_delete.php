<?php
header("Content-Type: application/json");
include 'koneksi.php';

// pastikan method DELETE
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    echo json_encode([
        "status" => "error",
        "pesan" => "Method harus DELETE"
    ]);
    exit;
}

// ambil body raw JSON
$data = json_decode(file_get_contents("php://input"), true);

// validasi JSON
if (!is_array($data)) {
    echo json_encode([
        "status" => "error",
        "pesan" => "Body harus berupa JSON"
    ]);
    exit;
}

// ambil ID
$id = $data['id'] ?? null;

// validasi ID
if (!$id) {
    echo json_encode([
        "status" => "error",
        "pesan" => "ID wajib diisi"
    ]);
    exit;
}

// cek data ada atau tidak
$cek = mysqli_query($conn, "SELECT id FROM barang WHERE id = '$id'");
if (mysqli_num_rows($cek) == 0) {
    echo json_encode([
        "status" => "error",
        "pesan" => "Data barang tidak ditemukan"
    ]);
    exit;
}

// query delete
$query = "DELETE FROM barang WHERE id = '$id'";

if (mysqli_query($conn, $query)) {
    echo json_encode([
        "status" => "success",
        "pesan" => "Data barang berhasil dihapus"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "pesan" => "Data barang gagal dihapus",
        "error_db" => mysqli_error($conn)
    ]);
}
?>
