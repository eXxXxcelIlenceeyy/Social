<?php
include("../application/db.php");
session_start();
// Получаем ID поста из URL
$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
// SQL запрос на выборку поста по ID
$sql_post = "SELECT posts.title, posts.content, posts.image_url, posts.created_at, users.us_name FROM posts LEFT JOIN users ON posts.user_id = users.id WHERE posts.id = $post_id LIMIT 1";
$result_post = $conn->query($sql_post);
?>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пост</title>
    <!-- Подключение файла CSS -->
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/post.css">
</head>

<body>
    <?php
    include("../menu.php");
    ?>
    <?php
    // Проверка наличия поста
    if ($result_post->num_rows > 0) {
        // Вывод данных поста
        while ($row = $result_post->fetch_assoc()) {
            echo '<div class="post-container">';
            echo '<h1>' . htmlspecialchars($row["title"]) . '</h1>';
            // Проверяем наличие имени автора и выводим его, если оно есть
            if (!empty($row["us_name"])) {
                echo '<p class="author-name">Автор: ' .
                    htmlspecialchars($row["us_name"]) . '</p>';
            }
            if (!empty($row["image_url"])) {
                echo '<img src="' . htmlspecialchars($row["image_url"]) . '" alt="Post Image">';
            }
            echo '<p>' . nl2br(htmlspecialchars($row["content"])) . '</p>';
            echo '<p class="post-time">Опубликовано: ' . $row["created_at"] . '</p>';
            echo '</div>';
        }
    } else {
        echo "Пост не найден.";
        echo "Ошибка запроса к базе данных: " . $conn->error;
    }
    // Вывод формы комментариев
    echo '<div class="comment-form-container">';
    echo '<h3>Оставить комментарий</h3>';
    echo '<form action="" method="post">';
    echo '<input type="hidden" name="post_id" value="' . $post_id . '">';
    echo '<label for="content">Комментарий:</label><br>';
    echo '<textarea id="content" name="content" rows="4" required></textarea><br><br>';
    echo '<button type="submit" name="submit_comment">Отправить комментарий</button>';
    echo '</form>';
    echo '</div>';

    // Обработка отправки комментария
    if (isset($_POST['submit_comment'])) {
        $author_name = isset($_SESSION['login']) ? $conn->real_escape_string($_SESSION['login']) : 'Anonymous';
        $content = $conn->real_escape_string($_POST['content']);
        $sql_comment = "INSERT INTO comments (post_id, author_name, content) VALUES ('$post_id', '$author_name', '$content')";
        if ($conn->query($sql_comment) === TRUE) {
            // После успешного добавления комментария выполняем JavaScript для перезагрузки страницы
            echo "<script>window.location.href = window.location.href;</script>";
            exit; // Для предотвращения выполнения остального PHP кода после перенаправления
        } else {
            echo "<script>alert('Ошибка: " . $conn->error . "');</script>";
        }
    }
    // Вывод комментариев
    $sql_comments = "SELECT author_name, content, created_at FROM comments WHERE post_id = $post_id ORDER BY created_at DESC";
    $result_comments = $conn->query($sql_comments);
    if ($result_comments->num_rows > 0) {
        echo "<div class='comments-container'>";
        echo "<h3>Комментарии:</h3>";
        while ($row = $result_comments->fetch_assoc()) {
            echo "<div class='comment'>";
            echo "<p><b>" . htmlspecialchars($row['author_name']) . "</b> (" . $row['created_at'] . ")</p>";
            echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p>Комментариев пока нет.</p>";
    }
    $conn->close();
    ?>
</body>

</html>