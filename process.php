<?php
// Підключення до бази даних
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'booking';

$conn = mysqli_connect($host, $user, $password, $database);

// Перевірка з'єднання з базою даних
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Збереження даних з форми в базу даних
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$barber = $_POST['barber'];
$date = $_POST['date'];
$time = $_POST['time'];

$sql = "SELECT * FROM bookings WHERE barber = '$barber' AND date = '$date' AND time = '$time'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<script>alert('Барбер зайнятий в цей час.'); 
    window.location.href='javascript:history.go(-1)';</script>";
}else {
    $sql = "INSERT INTO bookings (name, email, phone, barber, date, time) VALUES ('$name', '$email', '$phone', '$barber', '$date', '$time')";
    if (mysqli_query($conn, $sql)) {
      // Відправка листа на пошту
        $to = $email; // Адреса отримувача
        $subject = 'Підтвердження запису'; // Тема листа
        $message = "Шановний(а) $name,\n\nВаш запис на $date о $time до барбера $barber підтверджено.\n\nДякуємо за користування нашими послугами!"; // Тіло листа
        $headers = 'From: vakosovij@gmail.com' . "\r\n" .
        'Reply-To: vakosovij@gmail.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

        if (mail($to, $subject, $message, $headers)) {
        echo "<script>alert('Запис успішно підтверджено та відправлено на пошту.');</script>";
        echo "<script>window.location = 'index.html';</script>";
        } else {
        echo "<script>alert('Запис успішно підтверджено, але лист не вдалося відправити.');</script>";
        echo "<script>window.location = 'index.html';</script>";
        }   
    }
}
// Закриття з'єднання з базою даних
mysqli_close($conn);
?>