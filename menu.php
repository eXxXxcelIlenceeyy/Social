<input type="checkbox" class="menu-icon" id="menu-icon" name="menu-icon">
<label for="menu-icon"></label>
<nav class="nav">
    <ul class="pt-5">
        <li><a href="http://localhost/Social/">Главная</a></li>
        <!-- Добавляем PHP-код для определения ссылки на страницу "Личный кабинет" и "Чат"-->
        <?php
        if (isset($_SESSION['id'])) {
            echo '<li><a href="http://localhost/Social/profile/accaunt.php">Личный кабинет</a></li>';
        } else {
            echo '<li><a href="http://localhost/Social/auth.php">Личный кабинет</a></li>';
        }
        if (isset($_SESSION['id'])) {
            echo '<li><a href="http://localhost/Social/chat/chat.php">Чат</a></li>';
        } else {
            echo '<li><a href="http://localhost/Social/auth.php">Чат</a></li>';
        }
        ?>
        <!-- Конец PHP-кода -->
        <li><a href="http://localhost/Social/posts/posts.php">Новости</a></li>
        <li><a href="http://localhost/Social/games/games.php">Игры</a></li>
    </ul>
</nav>