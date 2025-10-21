<?php
// a. 4 6 9 13 18 ? ?
// Pola: tambah 2, 3, 4, 5, 6, dst
$a = [4];
$selisih = 2;
for ($i = 1; $i < 7; $i++) {
    $a[] = $a[$i-1] + $selisih;
    $selisih++;
}

echo "a. ";
foreach ($a as $num) {
    echo $num . " ";
}
echo "<br>";


// b. 2 2 3 3 4 ? ?
// Pola: setiap angka muncul 2 kali, lalu naik 1
$b = [];
$angka = 2;
for ($i = 0; $i < 7; $i++) {
    $b[] = $angka;
    if ($i % 2 == 1) {
        $angka++;
    }
}

echo "b. ";
foreach ($b as $num) {
    echo $num . " ";
}
echo "<br>";


// c. 1 9 2 10 3 ? ?
// Pola: barisan 1 (1,2,3,4,5...), barisan 2 (9,10,11,12...)
$c = [];
$angka1 = 1;
$angka2 = 9;

for ($i = 0; $i < 7; $i++) {
    if ($i % 2 == 0) {
        $c[] = $angka1;
        $angka1++;
    } else {
        $c[] = $angka2;
        $angka2++;
    }
}

echo "c. ";
foreach ($c as $num) {
    echo $num . " ";
}
?>