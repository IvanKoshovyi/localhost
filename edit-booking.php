<?php
// Підключення до бази даних
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'booking';
$conn = mysqli_connect($host, $user, $password, $database);

// Перевірка підключення до бази даних
if (!$conn) {
  die("Помилка підключення до бази даних: " . mysqli_connect_error());
}

// Обробка виключення з форми запиту
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
  $id = $_GET['id'];
  $sql = "SELECT * FROM bookings WHERE id=$id";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $barber = $row['barber'];
  $name = $row['name'];
  $phone = $row['phone'];
  $datetime = $row['date'] . 'T' . $row['time'];
}

// Оновлення часу запису в базі даних
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $datetime = $_POST['datetime'];
    $date = date('Y-m-d', strtotime($datetime));
    $time = date('H:i:s', strtotime($datetime));
    $barber_id = $_POST['barber_id'];
    
    $checkSql = "SELECT COUNT(*) AS count FROM bookings WHERE barber_id=$barber_id AND date='$date' AND time='$time'";
    $checkResult = mysqli_query($conn, $checkSql);
    $checkRow = mysqli_fetch_assoc($checkResult);
  
    if ($checkRow['count'] == 0) {
      // If there is no booking for the updated time, update the booking
      $updateSql = "UPDATE bookings SET date='$date', time='$time' WHERE id=$id";
      if (mysqli_query($conn, $updateSql)) {
        echo "<script>alert('Запис змінено.'); window.opener.location.reload(); window.close();</script>";
        exit;
      } else {
        echo "Помилка: " . $updateSql . "<br>" . mysqli_error($conn);
      }
    } else {
      // If there is already a booking for the updated time, show an error message
      echo "<script>alert('Запис на цей час вже існує. Будь ласка, виберіть інший час.'); window.open('edit-booking.php?id=' + $id, '_self');</script>";
      
    }
  }
  

// Закриття підключення до бази даних
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
  <title>Змінити запис</title>
  <script src="zap.js" defer></script>
  <style>
    body {
      font-family: 'Palatino Linotype', sans-serif;
    }

    .button{
        background-color: #685a4e;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        margin-top: 13px;
        margin-left: 150px;
    }

  </style>
</head>

<body>
  <h1>Змінити запис</h1>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="hidden" name="id" value="<?php echo $id ?>">
    <label for="barber">Майстер:</label>
    <input type="text" id="barber" name="barber" value="<?php echo $barber ?>" readonly>
    <br>
    <label for="name">Ім'я клієнта:</label>
    <input type="text" id="name" name="name" value="<?php echo $name ?>" readonly>
    <br>
    <label for="phone">Контактний телефон:</label>
    <input type="text" id="phone" name="phone" value="<?php echo $phone ?>" readonly>
    <br>
    <label for="datetime">Дата та час запису:</label>
    <input type="datetime-local" id="datetime" name="datetime" value="<?php echo $datetime ?>" required>
    <br>
    <input class = "button" type="submit" value="Зберегти зміни">
  </form>
</body


</html>
