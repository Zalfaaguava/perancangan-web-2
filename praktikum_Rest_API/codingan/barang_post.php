<?php
header("Content-Type: application/json");
include 'koneksi.php';

// ambil data dari body raw (JSON)
$data = json_decode(file_get_contents("php://input"), true);

// validasi JSON
if (!is_array($data)) {
    echo json_encode([
        "status" => "error",
        "pesan" => "Body harus berupa JSON"
    ]);
    exit;
}

// ambil data dengan aman
$kode_barang  = $data['kode_barang']  ?? null;
$nama_barang  = $data['nama_barang']  ?? null;
$id_kategori  = $data['id_kategori']  ?? null;
$stok         = $data['stok']         ?? null;
$stok_minimum = $data['stok_minimum'] ?? null;
$id_supplier  = $data['id_supplier']  ?? null;
$foto         = $data['foto']         ?? null;

// cek wajib isi
if (!$nama_barang || !$stok) {
    echo json_encode([
        "status" => "error",
        "pesan" => "Field wajib belum diisi"
    ]);
    exit;
}

// query insert
$query = "INSERT INTO barang 
(kode_barang, nama_barang, id_kategori, stok, stok_minimum, id_supplier, foto)
VALUES 
('$kode_barang', '$nama_barang', '$id_kategori', '$stok', '$stok_minimum', '$id_supplier', '$foto')";

if (mysqli_query($conn, $query)) {
    echo json_encode([
        "status" => "success",
        "pesan" => "Data barang berhasil ditambahkan"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "pesan" => "Data barang gagal ditambahkan",
        "error_db" => mysqli_error($conn)
    ]);
}
?>
