<?php
    
    // встановлюємо параметри підключення до бази даних
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "booking";
    
    // створюємо з'єднання з базою даних
    $conn = new mysqli($servername, $username, $password_db, $dbname);
    
    // перевіряємо, чи вдалося підключитися до бази даних
    if ($conn->connect_error) {
        die("Помилка з'єднання з базою даних: " . $conn->connect_error);
    }
    
    // отримуємо хеш введеного пароля
    $password = $_GET['password'];
    $hashed_password = hash('sha256', $password);
    
    // готуємо запит до бази даних, щоб знайти запис з паролем, який збігається з хешем введеного користувачем
    $query = "SELECT password FROM users WHERE id = 1";
    $result = $conn->query($query);
    
    if ($result->num_rows == 0) {
        // якщо запис не знайдено
        echo "Помилка: користувач не знайдений!";
    } else {
        // отримуємо запис з паролем з бази даних
        $row = $result->fetch_assoc();
        $stored_password = $row['password'];
        
        if ($hashed_password == $stored_password) {
            // якщо хеш введеного пароля збігається з хешем з бази даних
            echo "<script>window.location = 'kk.php';</script>";
        } else {
            // якщо хеш введеного пароля не збігається з хешем з бази даних
            echo "<script>alert('Неправильний пароль!');</script>";
            echo "<script>window.location = 'index.html';</script>";
        }
    }
    
    // закриваємо з'єднання з базою даних і звільняємо пам'ять від підготовлених запитів
    $result->close();
    $conn->close();

?>



