<?php
// Змінні для підключення до бази даних
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'booking';

// Підключення до бази даних
$conn = mysqli_connect($host, $user, $password, $database);

// Перевірка підключення до бази даних
if (!$conn) {
    die('Помилка підключення до бази даних: ' . mysqli_connect_error());
}
?>
