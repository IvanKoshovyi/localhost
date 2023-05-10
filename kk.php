<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'booking';

// Підключення до бази даних
$conn = mysqli_connect($host, $user, $password, $database);

// Отримання даних з форми пошуку, якщо вони були введені
$barber = isset($_POST['barber']) ? $_POST['barber'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : '';


// Формування запиту до бази даних з урахуванням критеріїв пошуку
if (!empty($barber) || !empty($date)) {
  $sql = "SELECT * FROM bookings WHERE 1=1";
  if (!empty($barber)) {
    $sql .= " AND barber LIKE '%$barber%'";
  }
  if (!empty($date)) {
    $sql .= " AND date = '$date'";
  }
  // Додати ORDER BY time до запиту
  $sql .= " ORDER BY date, time";
} else {
  // Додати ORDER BY time до запиту
  $sql = "SELECT * FROM bookings ORDER BY date, time";
}

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>

<head>
  <title>Записи барбера</title>
  <link rel="stylesheet" href="list.css">
  <script src="zap.js" defer></script>
</head>

<body>

  <a href="index.html">Повернутись на головну</a>

  <form class="rent" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label class="label" for="barber">Майстер:</label>
    <select id="barber" name="barber">
      <option value="">--Виберіть майстра--</option>
      <option>Ковальчук Віталій</option>
      <option>Даниленко Олександр</option>
      <option>Петров Вадим</option>
      <option>Лисенко Микола</option>
    </select>
    <label class="date" for="date">Дата:</label>
    <input class="date" type="date" id="date" name="date">
    <input class="serf" type="submit" value="Пошук">
  </form>

  <table class="table">
    <thead>
      <tr>
        <th>Ім'я барбера</th>
        <th>Ім'я клієнта</th>
        <th>Дата запису</th>
        <th>Час запису</th>
        <th>Контактний телефон</th>
        <th>Дії</th>
        <th>Змінити</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Відображення даних у таблиці HTML
      

        // Виведення інформації про бронювання, якщо воно ще не пройшло
        if (mysqli_fetch_assoc($result) > 0) {
          mysqli_data_seek($result, 0);
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["barber"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["date"] . "</td>";
            echo "<td>" . $row["time"] . "</td>";
            echo "<td>" . $row["phone"] . "</td>";
            echo "<td>
              <form style='max-width: 20px; 
                           white-space: nowrap; 
                           position: absolute;
                           margin-top: -28px;
                           text-overflow: ellipsis; 
                           height: 10px;
                           padding: 10px;' method='post' 
                           action='delete.php'
                           onsubmit='return confirmDelete()'>
                <input style='background-color: #685a4e;
                              color: white;
                              border: none;
                              border-radius: 5px;
                              padding: 10px 20px;
                              font-size: 16px;
                              cursor: pointer;' 
                              type='submit' value='Видалити'>
                <input type='hidden' name='id' value='" . $row["id"] . "'>
              </form>
            </td>
            <td>
  <button style='background-color: #685a4e;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;' 
  type='submit' onclick='editBooking(" . $row["id"] . ")'>Редагувати</button>
</td>
            
            <script>
              function confirmDelete() {
                var result = window.confirm('Ви впевнені, що хочете видалити цей запис?');
                return result;
              }
            </script>";
            echo "</tr>";
          }
        } else {
          echo "<tr>";
          echo "<td>" . "Немає записів" . "</td>";
          echo "<td>" . "Немає записів" . "</td>";
          echo "<td>" . "Немає записів" . "</td>";
          echo "<td>" . "Немає записів" . "</td>";
          echo "<td>" . "Немає записів" . "</td>";
          echo "<td>" . "Немає записів" . "</td>";
          echo "<td>" . "Немає записів" . "</td>";
          echo "</tr>";
        }
      



      // Закриття підключення до бази даних
      mysqli_close($conn);
      ?>
    </tbody>
  </table>
</body>

</html>