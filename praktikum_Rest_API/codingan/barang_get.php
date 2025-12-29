<?php
include 'koneksi.php';

// ambil data dari tabel barang
$query = "SELECT * FROM barang";
$result = mysqli_query($conn, $query);

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        "id"            => $row['id'],
        "kode_barang"   => $row['kode_barang'],
        "nama_barang"   => $row['nama_barang'],
        "id_kategori"   => $row['id_kategori'],
        "stok"          => $row['stok'],
        "stok_minimum"  => $row['stok_minimum'],
        "id_supplier"   => $row['id_supplier'],
        "created_at"    => $row['created_at'],
        "foto"          => $row['foto']
    ];
}

// response JSON
echo json_encode([
    "status" => "success",
    "jumlah_data" => count($data),
    "data" => $data
]);
?>
