<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Результаты анализа</title>
        <link rel="stylesheet" href="css/analyze_email.css">
    </head>
    <body>
        <img src="images/shield.webp" alt="Shield" class="icon">
        <div class="container">
            <?php
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);

                function analyzeEmail($emailContent) {
                    $headers = [];
                    $body = '';
                    $inHeaders = true;

                    foreach (explode("\n", $emailContent) as $line) {
                        if ($inHeaders) {
                            if (trim($line) == '') {
                                $inHeaders = false;
                                continue;
                            }
                            $headers[] = $line;
                        } else {
                            $body .= $line . "\n";
                        }
                    }

                    $results = [];
                    foreach ($headers as $header) {
                        if (stripos($header, 'Received:') !== false) {
                            $results['received'][] = $header;
                        } elseif (stripos($header, 'From:') !== false) {
                            $results['from'] = $header;
                        } elseif (stripos($header, 'Subject:') !== false) {
                            $results['subject'] = $header;
                        } elseif (stripos($header, 'DKIM-Signature:') !== false) {
                            $results['dkim'] = $header;
                        } elseif (stripos($header, 'Authentication-Results:') !== false) {
                            $results['spf'] = $header;
                        }
                    }

                    if (empty($results['dkim'])) {
                        $results['dkim_warning'] = 'Внимание: DKIM подпись отсутствует';
                    }

                    if (empty($results['spf'])) {
                        $results['spf_warning'] = 'Внимание: SPF запись отсутствует';
                    }

                    $results['links'] = [];
                    if (preg_match_all('/https?:\/\/[^\s"]+/', $body, $matches)) {
                        $results['links'] = $matches[0];
                    }

                    if (preg_match('/\.(exe|bat|cmd|sh|js|vbs|scr|pif|chm|hta|cpl|jar|wsf|vbe|jse|msc|reg)$/i', $body)) {
                        $results['virus_warning'] = 'Внимание: Обнаружены подозрительные вложения.';
                    }

                    foreach ($results['links'] as $link) {
                        if (stripos($link, 'download') !== false || stripos($link, 'attachment') !== false) {
                            $results['virus_warning'] = 'Внимание: Обнаружены подозрительные ссылки.';
                            break;
                        }
                    }

                    return $results;
                }

                function saveAnalysisResults($conn, $analysisResults) {
                    $emailFrom = isset($analysisResults['from']) ? $conn->real_escape_string($analysisResults['from']) : '';
                    $emailSubject = isset($analysisResults['subject']) ? $conn->real_escape_string($analysisResults['subject']) : '';
                    $dkimStatus = isset($analysisResults['dkim']) ? 'Присутствует' : 'Отсутствует';
                    $spfStatus = isset($analysisResults['spf']) ? 'Присутствует' : 'Отсутствует';
                    $links = isset($analysisResults['links']) ? $conn->real_escape_string(implode(', ', $analysisResults['links'])) : '';

                    $sql = "INSERT INTO analysis_results (email_from, email_subject, dkim_status, spf_status, links) 
                            VALUES ('$emailFrom', '$emailSubject', '$dkimStatus', '$spfStatus', '$links')";

                    if ($conn->query($sql) !== TRUE) {
                        echo "Ошибка при сохранении данных: " . $conn->error;
                    }
                }

                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['email']) && $_FILES['email']['error'] == UPLOAD_ERR_OK) {
                    require_once 'db.php';

                    $servername = "db";
                    $username = "root";
                    $password = "kali";
                    $dbname = "phishing_db";

                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        die("Ошибка подключения: " . $conn->connect_error);
                    }

                    $emailFile = $_FILES['email']['tmp_name'];
                    $emailContent = file_get_contents($emailFile);

                    $analysisResults = analyzeEmail($emailContent);

                    saveAnalysisResults($conn, $analysisResults);

                    echo '<div class="center-content">';
                    echo '<h1>Результаты анализа</h1>';
                    echo '<pre>';
                    print_r($analysisResults);
                    echo '</pre>';
                    echo '<a href="index.php" class="btn">Вернуться назад</a>';
                    echo '</div>';

                    $conn->close();
                } else {
                    echo '<div class="center-content">';
                    echo '<p>Файл письма не загружен.</p>';
                    echo '<a href="index.php" class="btn">Вернуться назад</a>';
                    echo '</div>';
                }
            ?>
        </div>
    </body>
</html>
