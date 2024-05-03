<?php
session_start();
require_once("../application/db.php");
$sql = "SELECT * FROM users WHERE id != 0";
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
    <title>Все пользователи</title>
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/tools.css">
</head>

<body>
    <?php include("../menu.php"); ?>
    <h1>Все пользователи</h1>
    <?php if ($result->num_rows > 0) : ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Имя пользователя</th>
                <th>Email</th>
                <th>Возраст</th>
                <th>Аккаунт создан</th>
                <th>Действия</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['us_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['age']); ?></td>
                    <td><?php echo htmlspecialchars($row['created']); ?></td>
                    <td><a href="delete_user.php?id=<?php echo $row['id']; ?>">Удалить</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else : ?>
        <p>Пользователей нет.</p>
    <?php endif; ?>
</body>

</html>