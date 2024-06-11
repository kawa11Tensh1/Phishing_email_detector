<?php
    $servername = "db";
    $username = "root";
    $password = "kali";

    // Подключаемся к серверу базы данных без указания имени базы данных
    $conn = new mysqli($servername, $username, $password);

    // Проверяем соединение
    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    // Создаем базу данных, если она не существует
    $sql = "CREATE DATABASE IF NOT EXISTS phishing_db";
    if ($conn->query($sql) !== TRUE) {
        die("Ошибка при создании базы данных: " . $conn->error);
    }

    // Подключаемся к базе данных phishing_db
    $conn->select_db("phishing_db");

    // Создаем таблицу, если она не существует
    $sql = "CREATE TABLE IF NOT EXISTS analysis_results (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email_from VARCHAR(255),
        email_subject VARCHAR(255),
        dkim_status VARCHAR(255),
        spf_status VARCHAR(255),
        links TEXT,
        analysis_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql) !== TRUE) {
        die("Ошибка при создании таблицы: " . $conn->error);
    }

    // Закрываем соединение с базой данных
    $conn->close();
?>
