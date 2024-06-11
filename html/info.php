<?php
    $servername = "db";
    $username = "root";
    $password = "kali";

    // Создаем соединение
    $conn = new mysqli($servername, $username, $password);

    // Проверяем соединение
    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }
    echo "Подключение успешно установлено";
    $conn->close();
?>
