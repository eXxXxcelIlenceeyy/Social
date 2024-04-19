<?php
include("create.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создать пост</title>
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/postcreate.css">
</head>

<body>
    <header>
        <h1>Создать новый пост</h1>
    </header>
    <?php
    include("../menu.php");
    ?>
    <main>
        <form action="createpost.php" method="post" enctype="multipart/form-data">
            <label for="title">Заголовок:</label><br>
            <input type="text" id="title" name="title" required><br><br>
            <label for="content">Содержание:</label><br>
            <textarea id="content" name="content" rows="6" required></textarea><br><br>
            <label for="image">Изображение:</label><br>
            <input type="file" id="image" name="image"><br><br>
            <button type="submit">Создать пост</button>
        </form>
    </main>
</body>

</html>