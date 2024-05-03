<?php
// Подключение к базе данных и начало сессии
include("../application/db.php");
// Получение ID пользователя из сессии
$user_id = $_SESSION['id'];
// SQL запрос на выборку постов пользователя и подсчет комментариев
$sql_posts = "SELECT posts.id, posts.title, posts.content, posts.image_url, 
COUNT(comments.id) AS comments_count 
FROM posts 
LEFT JOIN comments ON posts.id = comments.post_id 
WHERE posts.user_id = '$user_id' 
GROUP BY posts.id 
ORDER BY posts.created_at DESC";
$result_posts = $conn->query($sql_posts);
if ($result_posts->num_rows > 0) {
    while ($row = $result_posts->fetch_assoc()) {
        echo "<div class='post-block'>";
        if (!empty($row['image_url'])) {
            // Подставляем путь к изображению
            echo "<div class='post-image'><img src='../posts/" .
                htmlspecialchars($row['image_url']) . "' alt='Post Image'></div>";
        }
        echo "<div class='post-content'>";
        echo "<h3><a href='http://localhost/Social/posts/post.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['title']) . "</a></h3>";
        echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
        echo "<p>Количество комментариев: " . $row['comments_count'] . "</p>";
        echo "</div>"; // Закрытие блока контента поста
        echo "</div>"; // Закрытие блока поста
    }
} else {
    echo "<p>У вас нет ни одного поста.</p>";
}
