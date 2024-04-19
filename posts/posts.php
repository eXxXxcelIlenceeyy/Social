<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главные Новости</title>
    <link rel="stylesheet" href="../css/menu.css">
    <!-- Стили для отображения постов -->
    <link rel="stylesheet" href="../css/main-posts.css">
</head>

<body>
    <header>
        <h1>Посты</h1>
    </header>
    <?php
    include("../menu.php");
    ?>
    <div class="container">
        <?php
        // Проверяем, авторизован ли пользователь
        if (isset($_SESSION['id'])) {
            // Если да, отображаем кнопку для создания поста
            echo '<a href="createpost.php" class="create-post-button">Создать пост</a>';
        }
        ?>
        <div class="posts">
            <!-- Здесь будет выводиться содержимое файла с постами -->
            <?php include("showposts.php"); ?>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Получаем все посты по классу
            var posts = document.querySelectorAll('.post');
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
</body>

</html>