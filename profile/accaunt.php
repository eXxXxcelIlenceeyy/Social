<?php
session_start();
// Получение ID пользователя из сессии
$user_id = $_SESSION['id'];
ob_start(); // Начало буферизации вывода
include("upload-posts.php");
$output = ob_get_clean(); // Получение содержимого буфера и его очистка
// Теперь переменная $output содержит всё, что было выведено скриптом upload-posts.php
// И вы можете использовать эту переменную в нужном месте вашего HTML
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пользователя</title>
    <link rel="stylesheet" href="../css/profile-styles.css">
    <link rel="stylesheet" href="../css/menu.css">
</head>

<body>
    <header>
        <h1>Профиль пользователя</h1>
        <!-- HTML-код для кнопки выхода -->
        <form action="logout.php" method="post">
            <button type="submit" name="logoutButton">Выйти</button>
        </form>
    </header>

    <?php
    include("../menu.php");
    ?>

    <section id="profile-info">
        <h2>Информация о пользователе</h2>
        <!-- Контейнер для отображения изображения -->
        <div id="profile-picture-container">
            <img id="profile-picture" src="avatars/placeholder.png" alt="avatars/placeholder.png">
        </div>
        <!-- Вставляем имя пользователя из сессии -->
        <p>ФИО:
            <span class="info" id="user-name">
                <?php
                echo isset($_SESSION['login']) ? $_SESSION['login'] : "";
                ?>
            </span>
        </p>
        <!-- Вставляем возраст пользователя из сессии -->
        <p>Возраст:
            <span class="info" id="user-age">
                <?php
                echo isset($_SESSION['age']) ? $_SESSION['age'] : "";
                ?>
            </span>
        </p>

        <p>
            Дата создания аккаунта:
            <span class="info" id="accaunt-creation-date">

            </span>
        </p>
        <p>
            Email:
            <span class="info" id="user-email">

            </span>
        </p>
        <p>
            О себе:
            <span class="info" id="user-info">

            </span>
        </p>
        <h3>Панель управления</h3>
        <button onclick="document.location='editer_profile.php'" id="edit-profile">Редактировать профиль</button>
        <button onclick="document.location='http://localhost/Social/AdminChat/AdminChat.php'" id="admin-chat">Написать администратору</button>
        <!-- Кнопка обновления картинки -->
        <button id="update-picture">Обновить картинку</button>
        <!-- Кнопка удаления картинки -->

        <button id="delete-picture">Удалить картинку</button>

        <input type="file" id="file-input" accept="image/*" style="display: none;">
        <button onclick="document.location='http://localhost/Social/posts/createpost.php'" id="admin-chat">Создать пост</button>
        <?php
        // Проверяем, является ли пользователь администратором
        if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
            echo '<button onclick="document.location=\'http://localhost/Social/AdminTools/allusers.php\'">Все пользователи</button>';
            echo '<button onclick="document.location=\'http://localhost/Social/AdminTools/allposts.php\'">Все посты</button>';
            echo '<button onclick="document.location=\'http://localhost/Social/AdminTools/allcomments.php\'">Все комментарии</button>';
        }
        ?>
    </section>
    <section id="user-posts">
        <h2>Мои посты</h2>
        <?php echo $output; ?>
        <!-- Здесь будут отображаться ранее созданные посты с их лайками и комментариями -->
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Получаем все посты по классу
            var posts = document.querySelectorAll('.post-block');
            posts.forEach(function(post) {
                // Добавляем обработчик события при наведении мыши
                post.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#50576b'; // Светлее при наведении
                });
                // Добавляем обработчик события при уходе мыши
                post.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = ''; // Возвращаем исходный цвет
                });
            });
        });
    </script>
    <script src="../js/profile.js" defer></script>
    <script src="../js/picture.js" defer></script>
</body>

</html>