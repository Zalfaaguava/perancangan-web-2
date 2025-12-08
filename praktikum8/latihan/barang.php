<?php
require '../functions.php';
require_roles(['admin','gudang']);

// PAGINATION SETTINGS
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// SEARCH
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";
$kategori_filter = isset($_GET['kategori']) ? (int)$_GET['kategori'] : 0;
$supplier_filter = isset($_GET['supplier']) ? (int)$_GET['supplier'] : 0;

// === QUERY COUNT ===
$where = "WHERE 1=1 ";
if ($search != "") $where .= " AND b.nama_barang LIKE '%$search%' ";
if ($kategori_filter > 0) $where .= " AND b.id_kategori = $kategori_filter ";
if ($supplier_filter > 0) $where .= " AND b.id_supplier = $supplier_filter ";

$countQuery = "SELECT COUNT(*) AS total FROM barang b $where";
$countResult = mysqli_query($conn, $countQuery);
$totalData = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalData / $limit);

// === QUERY BARANG + JOIN ===
$query = "
    SELECT b.*, k.nama_kategori, s.nama_supplier
    FROM barang b
    LEFT JOIN kategori k ON b.id_kategori = k.id
    LEFT JOIN supplier s ON b.id_supplier = s.id
    $where
    ORDER BY b.id DESC
    LIMIT $limit OFFSET $offset
";
$res = mysqli_query($conn, $query);

// Ambil semua kategori & supplier untuk dropdown
$kategoriAll = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
$supplierAll = mysqli_query($conn, "SELECT * FROM supplier ORDER BY nama_supplier ASC");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Kelola Barang</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body { background: #f2f4f7; }
    .card-custom {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .table thead th {
        background: #0d6efd;
        color: white;
        border: none;
    }
    .table img {
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }
</style>
</head>
<body>

<div class="container mt-4">

<a href="index.php" class="btn btn-outline-secondary mb-3">← Kembali</a>

<div class="card card-custom p-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold m-0">Kelola Barang</h4>
        <a href="barang_add.php" class="btn btn-primary">+ Tambah Barang</a>
    </div>

    <!-- FILTER SEARCH -->
    <form method="GET" class="row g-2 mb-3">

        <div class="col-md-4">
            <input type="text" name="search" class="form-control"
                   placeholder="Cari nama barang..."
                   value="<?= htmlspecialchars($search) ?>">
        </div>

        <div class="col-md-3">
            <select name="kategori" class="form-control">
                <option value="0">Semua Kategori</option>
                <?php while ($k = mysqli_fetch_assoc($kategoriAll)): ?>
                    <option value="<?= $k['id'] ?>"
                        <?= ($k['id'] == $kategori_filter) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($k['nama_kategori']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="col-md-3">
            <select name="supplier" class="form-control">
                <option value="0">Semua Supplier</option>
                <?php while ($s = mysqli_fetch_assoc($supplierAll)): ?>
                    <option value="<?= $s['id'] ?>"
                        <?= ($s['id'] == $supplier_filter) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($s['nama_supplier']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <!-- TABLE BARANG -->
    <table class="table table-hover align-middle">
        <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Supplier</th>
            <th>Foto</th>
            <th>Stok</th>
            <th style="width:150px;">Aksi</th>
        </tr>
        </thead>

        <tbody>
        <?php
        $no = $offset + 1;
        while ($row = mysqli_fetch_assoc($res)):
        ?>
        <tr>
            <td><?= $no++ ?></td>

            <td class="fw-semibold"><?= htmlspecialchars($row['nama_barang']) ?></td>

            <td><?= $row['nama_kategori'] ?: '<i class="text-muted">Tidak ada</i>' ?></td>

            <td><?= $row['nama_supplier'] ?: '<i class="text-muted">Tidak ada</i>' ?></td>

            <td>
                <?php if ($row['foto']): ?>
                    <img src="../uploads/barang/<?= $row['foto'] ?>" width="60" height="60" style="object-fit: cover;">
                <?php else: ?>
                    <span class="text-muted fst-italic">Tidak ada</span>
                <?php endif; ?>
            </td>

            <td class="fw-bold"><?= $row['stok_minimum'] ?></td>

            <td>
                <a class="btn btn-sm btn-warning" href="barang_edit.php?id=<?= $row['id'] ?>">Edit</a>
                <a class="btn btn-sm btn-danger"
                   href="barang_delete.php?id=<?= $row['id'] ?>"
                   onclick="return confirm('Hapus barang ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- PAGINATION -->
    <nav>
        <ul class="pagination justify-content-center">

            <li class="page-item <?= ($page <= 1 ? 'disabled' : '') ?>">
                <a class="page-link"
                   href="?page=<?= $page - 1 ?>&search=<?= $search ?>&kategori=<?= $kategori_filter ?>&supplier=<?= $supplier_filter ?>">
                    «
                </a>
            </li>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i == $page ? 'active' : '') ?>">
                    <a class="page-link"
                       href="?page=<?= $i ?>&search=<?= $search ?>&kategori=<?= $kategori_filter ?>&supplier=<?= $supplier_filter ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

            <li class="page-item <?= ($page >= $totalPages ? 'disabled' : '') ?>">
                <a class="page-link"
                   href="?page=<?= $page + 1 ?>&search=<?= $search ?>&kategori=<?= $kategori_filter ?>&supplier=<?= $supplier_filter ?>">
                    »
                </a>
            </li>

        </ul>
    </nav>

</div>
</div>

</body>
</html>
