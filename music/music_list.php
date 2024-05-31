<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Музыкальная коллекция</title>
    <!-- Подключение стилей -->
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/loader.css">
    <link rel="stylesheet" href="../css/music_styles.css">
    <!-- Подключение скрипта для модального окна -->
    <script src="../js/loader.js"></script>
    <script src="../js/music.js"></script>
</head>

<body>
    <h1>Музыкальная коллекция</h1>
    <!-- Кнопка для открытия модального окна -->
    <?php
    session_start();
    if (isset($_SESSION['id'])) {
        echo '<button id="uploadButton">Загрузить музыку</button>';
    }
    ?>
    <!-- Контейнер с музыкальными треками -->
    <div class="music-container">
        <?php
        // Подключение к базе данных
        include_once '../application/db.php';
        include("../menu.php");
        include("../application/loader.php");
        // Запрос на получение всей музыки из таблицы
        $sql = "SELECT * FROM music ORDER BY upload_date DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // Вывод музыкальных треков, если они есть в базе данных
            while ($row = $result->fetch_assoc()) {
                $music_name = $row['music_name'];
                $music_path = $row['music_path'];
                // HTML-разметка для каждого трека
                echo "<div class='music-item'>";
                echo "<h2>$music_name</h2>";
                echo "<audio controls>";
                echo "<source src='$music_path' type='audio/mpeg'>";
                echo "Браузер не поддерживает воспроизведение аудио.";
                echo "</audio>";
                echo "</div>";
            }
        } else {
            // Вывод сообщения, если музыка не найдена
            echo "Музыка не найдена.";
        }
        $conn->close();
        ?>
    </div>
    <!-- Модальное окно для загрузки музыки -->
    <div id="myModal" class="modal">
        <!-- Содержимое модального окна -->
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Загрузка музыки</h2>
            <!-- Форма для загрузки музыкального файла -->
            <form action="upload_music.php" method="post" enctype="multipart/form-data">
                <input type="file" name="music_file" accept=".mp3,.mpeg" required>
                <button type="submit">Загрузить</button>
            </form>
        </div>
    </div>
</body>

</html>