<html>
<head>
    <title>Proses Input</title>
</head>
<body>
<?php
// Pastikan data POST ada, supaya tidak muncul warning
$bil1 = isset($_POST["bil1"]) ? $_POST["bil1"] : 0;
$bil2 = isset($_POST["bil2"]) ? $_POST["bil2"] : 0;
?>

<h1>Perbandingan Bilangan</h1>
<hr>

Bil I : <?php echo $bil1; ?><br>
Bil II: <?php echo $bil2; ?><br><br>

<?php
if ($bil1 < $bil2) {
    echo "$bil1 lebih kecil dari $bil2";
} elseif ($bil1 > $bil2) {
    echo "$bil1 lebih besar dari $bil2";
} else {
    echo "$bil1 sama dengan $bil2";
}
?>
</body>
</html>
