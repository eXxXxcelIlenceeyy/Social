<?php
session_start();
require_once("../application/db.php");
$sql = "SELECT comments.id, comments.content, comments.post_id, posts.title AS post_title, author_name, comments.created_at
FROM comments
JOIN users ON author_name = users.id
JOIN posts ON comments.post_id = posts.id";
$result = $conn->query($sql);
if (!$result) {
    // Если запрос не выполнен, выводим сообщение об ошибке
    die("Ошибка выполнения запроса: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Все комментарии</title>
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/tools.css">
</head>

<body>
    <?php
    include("../menu.php");
    ?>
    <h1>Все комментарии</h1>
    <?php if ($result->num_rows > 0) : ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Комментарий</th>
                <th>Пост</th> <!-- Столбец для названия поста -->
                <th>Пользователь</th>
                <th>Дата создания</th>
                <th>Действия</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['content']); ?></td>
                    <!-- Изменен вывод: теперь показывается название поста -->
                    <td><a href="http://localhost/final/posts/post.php?id=<?php echo $row['post_id']; ?>"><?php echo htmlspecialchars($row['post_title']); ?></a></td>
                    <td><?php echo htmlspecialchars($row['author_name']); ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td><a href="delete_comment.php?id=<?php echo $row['id']; ?>">Удалить</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else : ?>
        <p>Комментариев нет.</p>
    <?php endif; ?>
</body>

</html>