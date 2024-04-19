<?php
// Подключение к базе данных
require_once '../application/db.php'; // Подключаем файл db.php
$sql = "SELECT id, us_name AS username FROM users WHERE id != 0"; // Выбираем всех пользователей, кроме тех, у кого ID равен 0
$result = $conn->query($sql); // Используем уже существующее подключение $conn
$users = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $users[] = [
            'id' => $row['id'],
            'username' => $row['username']
        ];
    }
    $result->free();
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
echo json_encode($users);
