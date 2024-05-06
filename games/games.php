<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Меню игр</title>
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="../css/games-list.css">
    <link rel="stylesheet" href="../css/loader.css">
    <script src="../js/loader.js"></script>
</head>

<body>
    <header>Меню игр</header>
    <?php
    include("../menu.php");
    include("../application/loader.php");
    ?>
    <div class="container">
        <table class="game-list">
            <tr>
                <th>Игра</th>
                <th>Описание</th>
            </tr>
            <tr>
                <td><a href="x-o/x-o.php">Крестики-нолики</a></td>
                <td>
                    Добро пожаловать в классическую игру в крестики-нолики! Это
                    увлекательное соревнование, где два игрока соревнуются в умении выстраивать линии
                    из своих символов - крестиков или ноликов - на игровом поле. Стратегия, тактика и
                    интуиция игрока играют ключевую роль в этой игре. Умение предвидеть ходы противника
                    и одновременно строить собственные комбинации - вот что делает эту игру такой
                    захватывающей.
                </td>
            </tr>
        </table>
    </div>
</body>

</html>