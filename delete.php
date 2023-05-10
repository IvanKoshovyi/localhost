
<?php
  $host = 'localhost';
  $user = 'root';
  $password = '';
  $database = 'booking';

  // Підключення до бази даних
  $conn = mysqli_connect($host, $user, $password, $database);

  // Отримання ID запису для видалення та інформації про клієнта
  $id = isset($_POST['id']) ? $_POST['id'] : '';
  $booking_sql = "SELECT * FROM bookings WHERE id = '$id'";
  $booking_result = mysqli_query($conn, $booking_sql);
  $booking_row = mysqli_fetch_assoc($booking_result);
  $name = $booking_row['name'];
  $date = $booking_row['date'];
  $time = $booking_row['time'];
  $barber = $booking_row['barber'];
  $client_email = $booking_row['email'];

  // Виконання запиту на видалення запису з бази даних
  $delete_sql = "DELETE FROM bookings WHERE id = '$id'";
  if (mysqli_query($conn, $delete_sql)) {
    // Відправлення повідомлення на електронну адресу клієнта про видалення запису
    $to = $client_email;
    $subject = 'Запис видалено';
    $message = "Шановний(а) $name,\n\nВаш запис на $date о $time до барбера $barber було видалено з нашої системи.\n\nДякуємо за користування нашими послугами!";
    $headers = 'From: vakosovij@gmail.com';
    mail($to, $subject, $message, $headers);

    echo "<script>alert('Запис видалено.'); 
    window.location = 'kk.php';</script>";
  } else {
    echo "<script>alert('Помилка'); 
    window.location = 'kk.php';</script>";
  }

  // Закриття підключення до бази даних
  mysqli_close($conn);
?>