<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Детектор фишинговых писем</title>
        <link rel="stylesheet" href="css/index.css">
    </head>
    <body>
        <img src="images/shield.webp" alt="Shield" class="icon">
        <div class="container">
            <h1>Детектор фишинговых писем</h1>
            <form action="analyze_email.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="email">Загрузите файл EML:</label>
                    <input type="file" name="email" id="email" accept=".eml">
                </div>
                <input type="submit" value="Анализировать">
            </form>
            <br>
            <a href="report.php" class="report-link">Посмотреть отчет</a>
        </div>
    </body>
</html>