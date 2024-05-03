<?php
session_start();
require_once("../application/db.php");
// Проверяем, был ли передан идентификатор пользователя для удаления
if (isset($_GET['id'])) {
    // Получаем идентификатор пользователя из параметра запроса
    $user_id = $_GET['id'];
    // Подготавливаем SQL-запрос для удаления всех постов пользователя
    $sql_delete_posts = "DELETE FROM posts WHERE user_id = ?";
    $stmt_delete_posts = $conn->prepare($sql_delete_posts);
    $stmt_delete_posts->bind_param("i", $user_id);
    // Выполняем запрос на удаление всех постов пользователя
    if ($stmt_delete_posts->execute()) {
        // Подготавливаем SQL-запрос для удаления всех сообщений, где пользователь является отправителем или получателем
        $sql_delete_messages = "DELETE FROM messages WHERE sender_id = ? OR receiver_id = ?";
        $stmt_delete_messages = $conn->prepare($sql_delete_messages);
        $stmt_delete_messages->bind_param("ii", $user_id, $user_id);
        // Выполняем запрос на удаление всех сообщений пользователя
        if ($stmt_delete_messages->execute()) {
            // Подготавливаем SQL-запрос для удаления пользователя
            $sql_delete_user = "DELETE FROM users WHERE id = ?";
            $stmt_delete_user = $conn->prepare($sql_delete_user);
            $stmt_delete_user->bind_param("i", $user_id);
            // Выполняем запрос на удаление пользователя
            if ($stmt_delete_user->execute()) {
                // Перенаправляем пользователя обратно на страницу всех пользователей после успешного удаления
                header("Location: allusers.php");
                exit();
            } else {
                // Выводим сообщение об ошибке, если удаление пользователя не удалось
                echo "Ошибка при удалении пользователя: " . $conn->error;
            }
            // Закрываем подготовленные выражения для удаления пользователя
            $stmt_delete_user->close();
        } else {
            // Выводим сообщение об ошибке, если удаление сообщений пользователя не удалось
            echo "Ошибка при удалении сообщений пользователя: " . $conn->error;
        }
        // Закрываем подготовленные выражения для удаления сообщений пользователя
        $stmt_delete_messages->close();
    } else {
        // Выводим сообщение об ошибке, если удаление постов пользователя не удалось
        echo "Ошибка при удалении постов пользователя: " . $conn->error;
    }
    // Закрываем подготовленные выражения для удаления постов пользователя
    $stmt_delete_posts->close();
} else {
    // Выводим сообщение об ошибке, если идентификатор пользователя не был передан
    echo "Идентификатор пользователя не был передан для удаления.";
}
// Закрываем соединение с базой данных
$conn->close();
