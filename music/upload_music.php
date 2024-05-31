<?php
// Подключение к базе данных
include_once '../application/db.php';
// Проверка, был ли отправлен файл
if (isset($_FILES['music_file'])) {
    // Получение имени файла и временного пути
    $file_name = $_FILES['music_file']['name']; // Имя файла
    $file_tmp = $_FILES['music_file']['tmp_name']; // Временное имя файла
    $file_type = $_FILES['music_file']['type']; // Тип файла
    // Проверка типа файла
    if ($file_type == 'audio/mpeg' || $file_type == 'audio/mp3') {
        // Получение имени пользователя из сессии
        session_start();
        $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : '';
        $username = isset($_SESSION['login']) ? $_SESSION['login'] : '';
        // Получение имени файла без расширения
        $file_name_without_extension = pathinfo($file_name, PATHINFO_FILENAME);
        // Перемещаем файл в директорию для загрузок
        move_uploaded_file($file_tmp, "uploads/$file_name");
        // Путь к загруженному файлу
        $music_path = "uploads/$file_name";
        // SQL запрос для добавления информации о музыке в базу данных
        $sql = "INSERT INTO music (user_id, username, music_name, music_path) 
VALUES ('$user_id', '$username', '$file_name_without_extension', '$music_path')";
        // Выполнение запроса
        if ($conn->query($sql) === TRUE) {
            // Перенаправление пользователя на страницу music_list.php после 
            header("Location: music_list.php");
            exit(); // Убедитесь, что прекращаете выполнение скрипта после 
        } else {
            echo "Ошибка при загрузке музыки: " . $conn->error;
        }
    } else {
        echo "Неподдерживаемый формат файла. Пожалуйста, загрузите файл в формате 
MP3.";
    }
} else {
    echo "Файл не был отправлен.";
}
// Закрываем соединение с базой данных
$conn->close();
