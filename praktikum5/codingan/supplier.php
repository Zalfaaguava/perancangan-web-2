<?php
include "koneksi.php";

$kategori = mysqli_query($koneksi, "SELECT * FROM kategori");
if(!$kategori){
    die("Query kategori gagal: " . mysqli_error($koneksi));
}

$supplier = mysqli_query($koneksi, "SELECT * FROM supplier");
if(!$supplier){
    die("Query supplier gagal: " . mysqli_error($koneksi));
}
?>

<!-- dropdown kategori -->
<select name="id_kategori" required>
    <option value="">-- Pilih Kategori --</option>
    <?php
    if(mysqli_num_rows($kategori) > 0){
        while($row = mysqli_fetch_assoc($kategori)){
            echo "<option value='{$row['id_kategori']}'>{$row['nama_kategori']}</option>";
        }
    } else {
        echo "<option disabled>Belum ada data kategori</option>";
    }
    ?>
</select>

<!-- dropdown supplier -->
<select name="id_supplier" required>
    <option value="">-- Pilih Supplier --</option>
    <?php
    if(mysqli_num_rows($supplier) > 0){
        while($row = mysqli_fetch_assoc($supplier)){
            echo "<option value='{$row['id_supplier']}'>{$row['nama_supplier']}</option>";
        }
    } else {
        echo "<option disabled>Belum ada data supplier</option>";
    }
    ?>
</select>
