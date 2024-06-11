# Проект по инфобезу на PHP: Детектор фишинговых писем

## Описание проекта
Этот проект был разработан в рамках практики по информационной безопасности для создания веб-сервиса, который помогает системным администраторам и обычным пользователям отличать поддельные письма от фишинговых. Сервис анализирует заголовки и содержимое электронных писем и предоставляет оценку на основе определенных алгоритмов.

## Задание для практики
- Изучить работу электронной почты и протокол SMTP.
- Ознакомиться с технологиями DKIM и SPF, а также с работой DNS серверов и утилиты `dig`.
- Реализовать веб-сервис на PHP, который получает письмо, анализирует его содержимое и выдает оценку.

## Функциональность
Анализ заголовков письма:
- Проверка заголовков Received, From, Subject.
- Проверка наличия и корректности DKIM и SPF подписей.

Анализ содержимого письма:
- Поиск подозрительных ссылок.
- Поиск подозрительных вложений.

Сохранение результатов анализа:
- Результаты анализа сохраняются в базе данных для дальнейшего использования и отчетности.

Отчет:
- Веб-интерфейс для просмотра результатов анализа всех загруженных писем.

## Технологии
- **PHP**: Основной язык программирования для реализации веб-сервиса.
- **MySQL/MariaDB**: Для хранения результатов анализа.
- **Docker**: Для контейнеризации приложения и упрощения развертывания.
- **HTML и CSS**: Для создания пользовательского интерфейса.
- **SMTP, DKIM, SPF**: Технологии для проверки подлинности писем и обеспечения безопасности.

## Установка и запуск
Клонирование репозитория:
```sh
https://github.com/kawa11Tensh1/Phishing_email_detector.git
cd Phishing_email_detector
```

Настройка базы данных:
- Убедитесь, что MySQL/MariaDB установлен и запущен.
- Создайте базу данных:
```sql
CREATE DATABASE phishing_db;
```
- Запустите скрипт `db.php`, чтобы создать необходимые таблицы.

Настройка Docker:
- Убедитесь, что Docker установлен.
- Запустите контейнеры:
```sh
sudo docker-compose build
sudo docker-compose up -d
```

Проверка работы контейнеров:
```sh
sudo docker ps
```
Запуск приложения:
- Откройте веб-браузер и перейдите по адресу:
```sh
127.0.0.1:8080
```

## Структура проекта
- **index.php**: Главная страница для загрузки писем.
- **analyze_email.php**: Скрипт для анализа загруженных писем и сохранения результатов в базу данных.
- **report.php**: Страница для просмотра отчетов по анализированным письмам.
- **db.php**: Скрипт для создания базы данных и таблиц.
- **Dockerfile**: Файл для сборки Docker-образа.
- **docker-compose.yml**: Файл для управления Docker-контейнерами.

## Пример использования
1. Перейдите на главную страницу и загрузите файл письма в формате `.eml`.
2. Нажмите кнопку "Анализировать".
3. Посмотрите результаты анализа на странице результатов.
4. Перейдите на страницу отчетов, чтобы увидеть все проанализированные письма.

## Заключение
Этот проект демонстрирует важность автоматизации процессов информационной безопасности, особенно в контексте борьбы с фишингом. Созданный веб-сервис предоставляет надежный инструмент для анализа электронных писем, который может быть полезен как в корпоративной среде, так и для индивидуальных пользователей. В результате выполнения практики был создан минимально жизнеспособный продукт (MVP), который успешно выполняет поставленные задачи по выявлению фишинговых писем, значительно повышая уровень информационной безопасности.