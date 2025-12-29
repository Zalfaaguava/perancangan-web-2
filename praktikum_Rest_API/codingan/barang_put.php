<?php
header("Content-Type: application/json");
require_once "../config/koneksi.php";

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if (!$data) {
    echo json_encode([
        "status" => "error",
        "pesan" => "Body harus berupa JSON"
    ]);
    exit;
}

$id = $data['id'];
$nama_barang = $data['nama_barang'];
$id_kategori = $data['id_kategori'];
$stok = $data['stok'];
$stok_minimum = $data['stok_minimum'];
$id_supplier = $data['id_supplier'];
$foto = $data['foto'];

$query = "UPDATE barang SET
            nama_barang='$nama_barang',
            id_kategori='$id_kategori',
            stok='$stok',
            stok_minimum='$stok_minimum',
            id_supplier='$id_supplier',
            foto='$foto'
          WHERE id='$id'";

if (mysqli_query($conn, $query)) {
    echo json_encode([
        "status" => "success",
        "pesan" => "Data barang berhasil diupdate"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "pesan" => "Update gagal",
        "error_db" => mysqli_error($conn)
    ]);
}
