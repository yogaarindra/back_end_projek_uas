<?php
$newPassword1 = "admin123"; // Ganti dengan password yang Anda ingin gunakan
$hashedPassword1 = password_hash($newPassword1, PASSWORD_DEFAULT);
echo "Password asli: " . $newPassword1 . "<br>";
echo "Hashed password: " . $hashedPassword1 . "<br>";

$newPassword2 = "users123"; // Ganti dengan password yang Anda ingin gunakan
$hashedPassword2 = password_hash($newPassword2, PASSWORD_DEFAULT);
echo "Password asli: " . $newPassword2 . "<br>";
echo "Hashed password: " . $hashedPassword2 . "<br>";

$newPassword3 = "password123"; // Ganti dengan password yang Anda ingin gunakan
$hashedPassword3 = password_hash($newPassword3, PASSWORD_DEFAULT);
echo "Password asli: " . $newPassword3 . "<br>";
echo "Hashed password: " . $hashedPassword3 . "<br>";

$newPassword3 = "bunga456"; // Ganti dengan password yang Anda ingin gunakan
$hashedPassword3 = password_hash($newPassword3, PASSWORD_DEFAULT);
echo "Password asli: " . $newPassword3 . "<br>";
echo "Hashed password: " . $hashedPassword3 . "<br>";

$newPassword3 = "B15n15"; // Ganti dengan password yang Anda ingin gunakan
$hashedPassword3 = password_hash($newPassword3, PASSWORD_DEFAULT);
echo "Password asli: " . $newPassword3 . "<br>";
echo "Hashed password: " . $hashedPassword3 . "<br>";

$newPassword3 = "B412U_mahasiswa"; // Ganti dengan password yang Anda ingin gunakan
$hashedPassword3 = password_hash($newPassword3, PASSWORD_DEFAULT);
echo "Password asli: " . $newPassword3 . "<br>";
echo "Hashed password: " . $hashedPassword3 . "<br>";
?>
