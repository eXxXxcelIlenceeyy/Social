<?php
session_start();
require_once("../application/db.php");
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    // Подготавливаем SQL-запрос для удаления всех комментариев, связанных с удаляемым постом
    $delete_comments_sql = "DELETE FROM comments WHERE post_id = $post_id";
    // Выполняем запрос на удаление комментариев
    if ($conn->query($delete_comments_sql) === TRUE) {
        // После успешного удаления комментариев, можно удалить сам пост
        // Подготавливаем SQL-запрос для удаления поста
        $delete_post_sql = "DELETE FROM posts WHERE id = $post_id";
        // Выполняем запрос на удаление поста
        if ($conn->query($delete_post_sql) === TRUE) {
            // Если запрос выполнен успешно, перенаправляем пользователя обратно на страницу всех постов
            header("Location: allposts.php");
            exit();
        } else {
            echo "Ошибка при удалении поста: " . $conn->error;
        }
    } else {
        echo "Ошибка при удалении комментариев: " . $conn->error;
    }
} else {
    echo "Ошибка: Не передан параметр id для удаления поста.";
}
