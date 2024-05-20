<?php // Подключение к базе данных
include_once '../application/db.php';
// Проверка наличия данных в сессии
session_start();
// Получение данных из формы
$video_name = $_POST['video_name']; // Получаем название видео из формы
$video_description = $_POST['video_description']; // Получаем описание видео из формы 
$video_source = $_POST['video_source']; // Получаем источник видео из формы
$video_link = ($_POST['video_link']) ? $_POST['video_link'] : null; // Получаем ссылку на видео из формы, если она была указана $video_path =null; 
// Переменная для хранения пути к видео
// Получение данных о пользователе из сессии
$user_id = $_SESSION['id']; // Получаем ID пользователя из сессии
$username = $_SESSION['login']; // Получаем имя пользователя из сессии

// Обработка в зависимости от выбранного источника видео
if ($video_source == 'file') {
    // Обработка загрузки файла
    // Путь для сохранения загруженных файлов
    $target_dir = "uploads/"; // Указываем путь для сохранения загруженных файлов
    $target_file = $target_dir . basename($_FILES["video_file"]["name"]); // Создаем полный путь к загруженному файлу 
    $uploadOk = 1; // Флаг, определяющий, прошла ли загрузка успешно
    $videoFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // Получаем расширение загруженного файла 

    // Проверка типа файла
    if (!in_array($videoFileType, array("mp4", "webm"))) {
        echo "Допустимы только файлы MP4, WebM";
        $uploadOk = 0; // Ошибка, если тип файла не поддерживается
    }

    // Проверка наличия файла
    if ($uploadOk == 0) {
        echo "Файл не загружен.";
    } else {
        // Загрузка файла на сервер
        if (move_uploaded_file($_FILES["video_file"]["tmp_name"], $target_file)) {
            // Файл успешно загружен, добавляем информацию в базу данных
            $video_path = $target_file; // Устанавливаем путь к загруженному файлу
        } else {
            echo "Ошибка при загрузке файла.";
        }
    }

    // Обработка ссылки на видео 
} elseif ($video_source == 'link') {

    // Проверка наличия ссылки на видео
    if (!empty($video_link)) {

        // Проверка, является ли ссылка на YouTube видео
        if (strpos($video_link, 'youtube.com') !== false || strpos($video_link, 'youtu.be') !== false) {
            // Разбиваем URL-адрес, чтобы получить идентификатор видео
            $video_id = '';

            if (strpos($video_link, 'youtube.com') !== false) {
                $video_id = explode('v=', $video_link)[1];
            } elseif (strpos($video_link, 'youtu.be') !== false) {
                $video_id = explode('/', $video_link)[3];
            }

            // Собираем URL-адрес YouTube в формате, необходимом для вставки 
            $video_path = "https://www.youtube.com/embed/$video_id";
        }

        // Проверка, является ли ссылка на Rutube видео
        elseif (strpos($video_link, 'rutube.ru') !== false) {
            // Собираем URL-адрес Rutube в формате, необходимом для вставки 
            $video_path = "https://rutube.ru/play/embed/" . basename(parse_url($video_link, PHP_URL_PATH));
        }
    } else {
        echo "Ссылка на видео не указана.";
    }
}

// Если $video_path не равен null, значит либо файл был успешно загружен, либо указана ссылка на видео 
if ($video_path !== null) {

    // Добавляем информацию в базу данных
    $sql = "INSERT INTO videos (user_id, username, video_name, video_description, video_source, video_path) VALUES ('$user_id', '$username', '$video_name',
        '$video_description', '$video_source', '$video_path')";
    if ($conn->query($sql) === TRUE) {
        header("Location: all_videos.php");
        echo "Видео успешно добавлено в базу данных.";
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
}

// Закрываем соединение с базой данных
$conn->close();
