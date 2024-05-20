<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить Видео</title>
    <link rel="stylesheet" href="../css/menu.css"> <!-- Подключение CSS-файла для стилей меню -->
    <link rel="stylesheet" href="../css/loader.css"> <!-- Подключение CSS-файла для стилей загрузчика -->
    <link rel="stylesheet" href="../css/add_video.css"> <!-- Подключение CSS-файла для стилей добавления видео -->
    <script src="../js/loader.js"></script> <!-- Подключение скрипта загрузчика -->
</head>

<body>
    <header>
        <h1>Добавить Видео</h1> <!-- Заголовок страницы -->
    </header>
    <?php
    include("../menu.php"); // Вставка содержимого файла меню
    include("../application/loader.php"); // Вставка содержимого файла загрузчика
    ?>
    <div class="container"> <!-- Создание контейнера для формы -->
        <form action="add_to_base.php" method="post" enctype="multipart/form-data">
            <!-- Форма для добавления видео -->
            <label for="video_name">Название Видео:</label><br> <!-- Метка для названия видео -->
            <input type="text" id="video_name" name="video_name"><br> <!-- Поле ввода для названия видео -->
            <label for="video_description">Описание Видео:</label><br> <!-- Метка для описания видео -->
            <textarea id="video_description" name="video_description"></textarea><br> <!-- Поле ввода для описания видео -->
            <label for="video_source">Источник Видео:</label><br> <!-- Метка для выбора источника видео -->
            <select id="video_source" name="video_source" onchange="toggleInput()">
                <!-- Выпадающий список для выбора источника видео -->
                <option value="" selected disabled>Выберите вариант</option> <!-- Первый пункт выпадающего списка -->
                <option value="link">Ссылка</option> <!-- Пункт выпадающего списка для ссылки -->
                <option value="file">Файл</option> <!-- Пункт выпадающего списка для файла -->
            </select><br> <!-- Закрытие выпадающего списка -->
            <div id="file_input" class="file-input-container"> <!-- Контейнер для загрузки файла -->
                <label for="video_file">Загрузить файл Видео:</label><br> <!-- Метка для загрузки видео -->
                <input type="file" id="video_file" name="video_file" accept="video/mp4, video/webm"> <!-- Поле загрузки файла видео -->
            </div> <!-- Закрытие контейнера для загрузки файла -->
            <div id="link_input" class="file-input-container"> <!-- Контейнер для ввода ссылки -->
                <label for="video_link">Ссылка на Видео:</label><br> <!-- Метка для ввода ссылки на видео -->
                <input type="text" id="video_link" name="video_link"><br> <!-- Поле ввода ссылки на видео -->
            </div> <!-- Закрытие контейнера для ввода ссылки -->
            <input type="submit" value="Добавить Видео"> <!-- Кнопка для отправки формы -->
        </form> <!-- Закрытие формы -->
    </div> <!-- Закрытие контейнера для формы -->
    <script>
        function toggleInput() { // Функция для переключения между полями ввода ссылки и загрузки файла
            var source = document.getElementById("video_source").value; // Получение значения выбранного источника
            var fileInput = document.getElementById("file_input"); // Получение контейнера для загрузки файла
            var linkInput = document.getElementById("link_input"); // Получение контейнера для ввода ссылки
            if (source === "file") { // Если выбран источник файла
                fileInput.classList.remove("fade-out"); // Удаляем класс для анимации скрытия загрузки файла
                fileInput.classList.add("fade-in"); // Добавляем класс для анимации появления загрузки файла
                linkInput.classList.remove("fade-in"); // Удаляем класс для анимации появления ввода ссылки
                linkInput.classList.add("fade-out"); // Добавляем класс для анимации скрытия ввода ссылки
            } else { // Если выбран источник ссылки
                fileInput.classList.remove("fade-in"); // Удаляем класс для анимации появления загрузки файла
                fileInput.classList.add("fade-out"); // Добавляем класс для анимации скрытия загрузки файла
                linkInput.classList.remove("fade-out"); // Удаляем класс для анимации скрытия ввода ссылки
                linkInput.classList.add("fade-in"); // Добавляем класс для анимации появления ввода ссылки
            }
        }
    </script> <!-- Закрытие скрипта -->
</body> <!-- Закрытие тела документа -->

</html> <!-- Закрытие HTML-документа -->