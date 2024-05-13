<!-- Шаблон для создания html разметки -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" , content="width=device-width, initial-scale=1.0">
    <!-- Заголовок страницы -->
    <title>Змейка</title>
    <!-- Подключение файла snake.css -->
    <link rel="stylesheet" href="snake.css">
    <!-- Подключение файла menu.css -->
    <link rel="stylesheet" href="../../css/menu.css">
    <!-- Подключение файла loader.css -->
    <link rel="stylesheet" href="../../css/loader.css">
    <!-- Подключение файла loader.js для выполнения анимации -->
    <script src="../../js/loader.js"></script>
    <!-- Подключение файла snake.js для работы игры -->
    <script src="snake.js"></script>
</head>

<body>
    <?php
    //Подключение меню в файл
    include("../../menu.php");
    //Подключение Loader в файл
    include("../../application/loader.php");
    ?>
    <!-- Заголовок -->
    <header>
        <h1>Змейка</h1>
    </header>
    <!-- Область, в которой будет отображаться игра -->
    <canvas id="board"></canvas>
</body>

</html>