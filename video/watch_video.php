<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Просмотр Видео</title>
    <link rel="stylesheet" href="../css/menu.css">
    <!-- <link rel="stylesheet" href="../css/loader.css"> так как на странице 
видео может загружаться долго лоадер идет на усмотрение -->
    <link rel="stylesheet" href="../css/video_styles.css">
    <!--<script src="../js/loader.js"></script>-->
</head>

<body>
    <h1>Просмотр Видео</h1>
    <div class="video-container">
        <?php
        session_start();
        include("../menu.php");
        // include("../application/loader.php");
        // Подключение к базе данных
        include_once '../application/db.php';
        // Проверка наличия параметра ID в URL
        if (isset($_GET['id'])) {
            $video_id = $_GET['id'];
            // Получение информации о видео из базы данных по ID
            $sql = "SELECT * FROM videos WHERE id = $video_id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // Вывод видео, если оно найдено в базе данных
                $row = $result->fetch_assoc();
                $video_name = $row['video_name'];
                $video_description = $row['video_description'];
                $video_source = $row['video_source'];
                $video_path = $row['video_path'];
                // Вывод названия и описания видео
                echo "<h2>$video_name</h2>";
                if ($video_source == 'file') {
                    // Проверка на источник видео (файл)
                    echo "<video controls class='video'>";
                    echo "<source src='$video_path' type='video/mp4'>";
                    echo "Ваш браузер не поддерживает видео в формате MP4.";
                    echo "</video>";
                } elseif ($video_source == 'link') {
                    // Проверка на источник видео (ссылка)
                    // Подставляем ссылку из базы данных в атрибут src элемента iframe
                    $iframe_src = $video_path; // Предполагая, что $video_path содержит ссылку на YouTube видео
                    echo "<iframe src='$iframe_src' frameborder='0' 
allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; 
picture-in-picture; web-share' title='YouTube video player' allowfullscreen 
class='video'></iframe>";
                }
                echo "<p>$video_description</p>";
            } else {
                // Вывод сообщения, если видео не найдено
                echo "Видео не найдено.";
            }
        } else {
            // Вывод сообщения об ошибке, если отсутствует параметр ID
            echo "Ошибка: ID видео не указан.";
        }
        echo '<div class="comment-form-container">';
        echo '<h3>Оставить комментарий</h3>';
        echo '<form action="" method="post">';
        echo '<input type="hidden" name="video_id" value="' . $video_id . '">';
        echo '<label for="content">Комментарий:</label><br>';
        echo '<textarea id="content" name="content" rows="4" required></textarea><br><br>';
        echo '<button type="submit" name="submit_comment">Отправить комментарий</button>';
        echo '</form>';
        echo '</div>';
        if (isset($_POST['submit_comment'])) {
            // Проверяем, установлена ли сессия
            $author_name = isset($_SESSION['login']) ? $conn->real_escape_string($_SESSION['login']) : 'Anonymous';
            $content = $conn->real_escape_string($_POST['content']);
            $video_id = $_POST['video_id'];
            // SQL запрос для вставки комментария
            $sql_comment = "INSERT INTO comments_for_video (video_id, author_name, content) 
VALUES ('$video_id', '$author_name', '$content')";
            // Выполнение запроса
            if ($conn->query($sql_comment) === TRUE) {
                // Если комментарий успешно добавлен, перезагружаем страницу
                echo "<script>window.location.href = window.location.href;</script>";
                exit;
            } else {
                // Если произошла ошибка при добавлении комментария, выводим сообщение об ошибке
                echo "<script>alert('Ошибка: " . $conn->error . "');</script>";
            }
        }
        // SQL запрос для выборки комментариев к видео
        $sql_comments = "SELECT author_name, content, created_at FROM comments_for_video 
WHERE video_id = $video_id ORDER BY created_at DESC";
        // Выполнение запроса
        $result_comments = $conn->query($sql_comments);
        // Если есть комментарии, выводим их
        if ($result_comments->num_rows > 0) {
            echo "<div class='comments-container'>";
            echo "<h3>Комментарии:</h3>";
            while ($row = $result_comments->fetch_assoc()) {
                echo "<div class='comment'>";
                echo "<p><b>" . htmlspecialchars($row['author_name']) . "</b> (" .
                    $row['created_at'] . ")</p>";
                echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            // Если нет комментариев, выводим сообщение
            echo "<p>Комментариев пока нет.</p>";
        }
        // Закрываем соединение с базой данных
        $conn->close();
        ?>