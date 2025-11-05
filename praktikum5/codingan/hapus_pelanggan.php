<?php
include "koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $hapus = mysqli_query($koneksi, "DELETE FROM pelanggan WHERE id_pelanggan='$id'");
    if ($hapus) {
        echo "<script>
                alert('✅ Data pelanggan berhasil dihapus!');
                window.location='pelanggan.php';
              </script>";
    } else {
        echo "<script>
                alert('❌ Gagal menghapus data pelanggan!');
                window.location='pelanggan.php';
              </script>";
    }
} else {
    echo "<script>
            alert('⚠️ Tidak ada data yang dipilih untuk dihapus.');
            window.location='pelanggan.php';
          </script>";
}
?>
