<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Отчет о фишинговых письмах</title>
        <link rel="stylesheet" href="css/report.css">
    </head>
    <body>
        <img src="images/shield.webp" alt="Shield" class="icon">
        <div class="container">
            <h1>Отчет о фишинговых письмах</h1>
            <div class="table-container">
                <table>
                    <tr>
                        <th>Дата анализа</th>
                        <th>От кого</th>
                        <th>Тема</th>
                        <th>DKIM статус</th>
                        <th>SPF статус</th>
                        <th>Ссылки</th>
                    </tr>
                    <?php
                        // Подключение к базе данных
                        $servername = "db";
                        $username = "root";
                        $password = "kali";
                        $dbname = "phishing_db";

                        $conn = new mysqli($servername, $username, $password, $dbname);
                        if ($conn->connect_error) {
                            die("Ошибка подключения: " . $conn->connect_error);
                        }

                        // Выборка результатов анализа
                        $sql = "SELECT analysis_date, email_from, email_subject, dkim_status, spf_status, links FROM analysis_results ORDER BY analysis_date DESC";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr><td>" . $row["analysis_date"] . "</td><td>" . $row["email_from"] . "</td><td>" . $row["email_subject"] . "</td><td>" . $row["dkim_status"] . "</td><td>" . $row["spf_status"] . "</td><td>" . $row["links"] . "</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Нет данных</td></tr>";
                        }

                        $conn->close();
                    ?>
                </table>
            </div>
            <div class="center-content">
                <a href="index.php" class="btn">Вернуться назад</a>
            </div>
        </div>
    </body>
</html>
