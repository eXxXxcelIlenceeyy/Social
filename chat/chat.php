<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Чат</title>
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/chat-styles.css">
</head>

<body>
    <?php
    include("../menu.php");
    ?>
    <div id="chat-container">
        <div id="user-list">
            <h3>Пользователи</h3>
            <ul id="all-users">
                <!-- Здесь будут отображаться все пользователи -->
                <!-- Пример: <li class="selected">Пользователь 1</li> -->
            </ul>
        </div>
        <div id="chat-messages">
            <h3>Выберите пользователя из списка, для начала общения 😈</h3>
            <!-- Здесь будут отображаться сообщения чата -->
            <?php
            if (isset($_SESSION['user-id'])) {
                // isset - используется для проверки определена ли переменная, если переменная существует то true иначе false
                echo '<script>selectedUserId = ' . $_SESSION['user_id'] . ';</script>';
                include 'getMessages.php';
            }
            ?>
        </div>
    </div>
    <div id="message-input">
        <input type="text" id="message" contenteditable="true" placeholder="Введите ваше сообщение...">
        <div id="sticker-trigger" onclick="toggleStickerList()">😊</div>
        <div id="sticker-list" class="hidden">
            <div class="sticker" onclick="insertSticker('🤑')">🤑</div>
            <div class="sticker" onclick="insertSticker('😢')">😢</div>
            <div class="sticker" onclick="insertSticker('🌟')">🌟</div>
            <div class="sticker" onclick="insertSticker('🤡')">🤡</div>
            <div class="sticker" onclick="insertSticker('🤐')">🤐</div>
            <div class="sticker" onclick="insertSticker('🤬')">🤬</div>
            <div class="sticker" onclick="insertSticker('💖')">💖</div>
            <div class="sticker" onclick="insertSticker('😹')">😹</div>
            <div class="sticker" onclick="insertSticker('🏃‍♂️')">🏃‍♂️</div>
            <div class="sticker" onclick="insertSticker('👌')">👌</div>
            <div class="sticker" onclick="insertSticker('👆')">👆</div>
            <div class="sticker" onclick="insertSticker('💔')">💔</div>
            <div class="sticker" onclick="insertSticker('🖐')">🖐</div>
            <div class="sticker" onclick="insertSticker('😶‍ 🌫️')">😶‍ 🌫️</div>
            <!-- Добавьте другие стикеры по аналогии -->
        </div>
        <button id="send-button" onclick="sendMessage()">Отправить</button>
    </div>
    <script src="../js/chat.js"></script>
</body>

</html>