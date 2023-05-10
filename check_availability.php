<?php
// Отримати значення дати та майстра з запиту
$date = $_POST['date'];
$barber = $_POST['barber'];

// З'єднання з базою даних
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "booking";

$conn = new mysqli($servername, $username, $password, $dbname);

// Перевірити наявність записів у базі даних для обраної дати та майстра
$sql = "SELECT time FROM bookings WHERE date = '$date' AND barber = '$barber'";
$result = $conn->query($sql);
// Створити масив зайнятих часів
$busy_times = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $busy_times[] = $row['time'];
    }
}

// Повернути список зайнятих часів у форматі JSON
echo json_encode($busy_times);

// Закрити з'єднання з базою даних
$conn->close();
?>