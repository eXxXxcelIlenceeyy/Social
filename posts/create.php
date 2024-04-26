<?php
session_start();
include_once '../application/db.php';
// Проверяем, был ли отправлен POST-запрос
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $image_url = '';
    $user_id = $_SESSION['id'];
    // Обработка загрузки файла
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = 'uploads/'; // Папка для сохранения изображений
        $upload_file = $upload_dir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
            $image_url = $upload_file;
        } else {
            echo "Произошла ошибка при загрузке файла.";
        }
    }
    // SQL запрос на вставку данных в таблицу
    $sql = "INSERT INTO posts (title, content, image_url, user_id) VALUES ('$title', '$content', '$image_url', '$user_id')";
    // Выполнение запроса
    if ($conn->query($sql) === TRUE) {
        echo "Новый пост успешно создан";
        header("Location: http://localhost/Social/posts/posts.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
// Закрываем соединение
$conn->close();
