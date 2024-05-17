// Размеры окна и переменные для работы с полем
let board;
let bWidth = 500;
let bHeight = 500;
let context;
//Размеры ракетки
let pWidth = 80;
let pHeight = 10;
//Скорость ракетки(смещение на 10 пикселей)
let pX = 10;
//Список, в котором содержатся координаты и размеры ракетки
let player = {
    x: 210,
    y: 480,
    width: pWidth,
    height: pHeight,
    height: pHeight,
    vX: pX
}
//Размеры и скорость мяча
let ballWidth = 10;
let ballHeight = 10;
let ballVX = 3;
let ballVY = 2;
//Список с координатами мяча, его размерами и скоростью
let ball = {
    x: 250,
    y: 250,
    width: ballWidth,
    height: ballHeight,
    vX: ballVX,
    vY: ballVY
}
//Массив для хранения кирпичей
let blockArray = [];
//Ширина кирпичей
let blockWidth = 50;
//Высота кирпичей
let blockHeight = 10;
//Количество столбцов
let blockColumns = 8;
//Количество строк
let blockRows = 3;
//Максимальное количество строк (Каждый уровень будем увеличивать на 1 ряд)
let blockMaxRows = 10;
//Переменная для подсчёта количество блоков на поле
let blockCount = 0;
//Начальное положение блоков 
let blockX = 15;
let blockY = 45;
//Счёт
let score = 0;
//Завершение игры
let gameOver = false;



// При загрузке страницы получим элемент страницы
window.onload = function () {
    board = document.getElementById("board");
    //Укажем размеры
    board.height = bHeight;
    board.width = bWidth;
    //Сделаем возможность рисовать на поле
    context = board.getContext("2d");
    //Закрашиваем поле
    context.fillStyle = "black";
    context.fillRect(0, 0, board.width, board.height);
    //Заливка для ракетки
    context.fillStyle = "orange";
    context.fillRect(player.x, player.y, player.width, player.height);
    //Функция для обновления поля
    requestAnimationFrame(update);
    //Прослушивание нажатий клавиш
    document.addEventListener("keydown", movePlayer);
    //Вызываем функцию создания блоков
    createBlocks();
}

function createBlocks() {
    //Очищаем массив
    blockArray = [];
    //Цикл для заполнения блоков по колонкам
    for (let c = 0; c < blockColumns; c++) {
        //Цикл для заполнения блоков по строкам
        for (let r = 0; r < blockRows; r++) {
            //Создаём список со свойствами
            let block = {
                //Координата одного блока с отступами
                x: blockX + c * blockWidth + c * 10,
                y: blockY + r * blockHeight + r * 10,
                //Ширина и высота блока
                width: blockWidth,
                height: blockHeight,
                //Флаг, который показывает сломан ли блок или нет
                break: false
            }
            //Помещаем список в массив
            blockArray.push(block);
        }
    }
    //Помещаем в переменную количество элементов массива
    blockCount = blockArray.length;
}


//Функция дя определения пересечения
function Collision(a, b) {
    //Координата верхнего левого угла мяча по Х должна быть меньше, чем координата верхнего правого угла блока
    return a.x < b.x + b.width &&
        //Координата верхнего правого угла мяча по Х должна быть больше, чем координата верхнего левого угла блока
        a.x + a.width > b.x &&
        //Координата верхнего левого угла мяча по Y должна быть меньше, чем координата нижнего левого угла блока
        a.y < b.y + b.height &&
        //Координата нижнего правого угла мяча по Y должна быть больше, чем координата верхнего левого угла блока
        a.y + a.height > b.y;
}
//Функция дя определения пересечения сверху
function tCollision(ball, block) {
    //Возвращается значение True, если произошло пересечение и нижняя граница мяча больше верхней границы блока
    return Collision(ball, block) && (ball.y + ball.height) >= block.y;
}
//Функция дя определения пересечения снизу
function bCollision(ball, block) {
    //Возвращается значение True, если произошло пересечение и нижняя граница блока больше верхней границы мяча
    return Collision(ball, block) && (block.y + block.height) >= ball.y;
}
//Функция дя определения пересечения слева
function lCollision(ball, block) {
    //Возвращается значение True, если произошло пересечение и правая граница мяча больше левой границы блока
    return Collision(ball, block) && (ball.x + ball.width) >= block.x;
}
//Функция дя определения пересечения справа
function rCollision(ball, block) {
    //Возвращается значение True, если произошло пересечение и правая граница блока больше левой границы мяча
    return Collision(ball, block) && (block.x + block.width) >= ball.x;
}


//Функция проверки выхода за экран
function outBoard(xPos) {
    //xPos это координата левого верхнего угла ракетки, чтобы проверить чтобы правая 
    //часть каретки не вышла за экран, нужно к xPos прибавить ширину ракетки, чтобы 
    //получить координату правого верхнего угла ракетки.
    return (xPos < 0 || xPos + pWidth > bWidth);
}

//Функция для движения ракетки
function movePlayer(e) {
    if (gameOver) {
        //Вызываем функцию рестарта при нажатии на кнопку Space
        if (e.code == "Space") {
            resetGame();
        }
    }
    if (e.code == "KeyA") {
        //В переменную записывается координата смещения влево
        let nextX = player.x - player.vX;
        //Если за границу не вышла, то смещаем влево
        if (!outBoard(nextX)) {
            player.x = nextX;
        }
    }
    else if (e.code == "KeyD") {
        //В переменную записывается координата смещения вправо
        let nextX = player.x + player.vX;
        if (!outBoard(nextX)) {
            //Если за границу не вышла, то смещаем вправо
            player.x = nextX;
        }
    }
}

//Функция рестарта. В ней обнуляем все значения, то есть устанавливаем им начальные 
значения
function resetGame() {
    gameOver = false;
    player = {
        x: 210,
        y: 480,
        width: pWidth,
        height: pHeight,
        vX: pX
    }
    ball = {
        x: 250,
        y: 250,
        width: ballWidth,
        height: ballHeight,
        vX: ballVX,
        vY: ballVY
    }
    blockArray = [];
    blockRows = 3;
    score = 0;
    createBlocks();
}


//Функция для перерисовки поля
function update() {
    requestAnimationFrame(update);
    //Завершение игры
    if (gameOver) {
        return;
    }
    //Очишаем заливку, для корректной перерисовки
    context.clearRect(0, 0, board.width, board.height);
    //Закрашиваем поле
    context.fillStyle = "black";
    context.fillRect(0, 0, board.width, board.height);
    //Заливка для ракетки
    context.fillStyle = "orange";
    context.fillRect(player.x, player.y, player.width, player.height);
    //Заливка для мяча
    context.fillStyle = "white";
    //Изменение координат мяча
    ball.x += ball.vX;
    ball.y += ball.vY;
    context.fillRect(ball.x, ball.y, ball.width, ball.height);

    // Если коснулся сверху или снизу, то меняем направление по оси Y
    if (tCollision(ball, player) || bCollision(ball, player)) {
        ball.vY *= -1;
    }
    // Если коснулся слева или справа, то меняем направление по оси Х
    else if (lCollision(ball, player) || rCollision(ball, player)) {
        ball.vX *= -1;
    }
    //Заливка для блоков
    context.fillStyle = "lightgreen";
    //Цикл для прохода по всем блокам в массиве
    for (let i = 0; i < blockArray.length; i++) {
        //Получаем один блок
        let block = blockArray[i];
        //Проверка сломан ли блок
        if (!block.break) {
            //Проверка касания сверху или снизу
            if (tCollision(ball, block) || bCollision(ball, block)) {
                //Устанавливаем значение, что блок сломан
                block.break = true;
                //Меняем направление движения 
                ball.vY *= -1;
                //Уменьшаем количество блоков на поле
                blockCount -= 1;
                //Увеличение счёта
                score += 1;
            }
            //Проверка касания слева или справа
            else if (lCollision(ball, block) || rCollision(ball, block)) {
                //Устанавливаем значение, что блок сломан
                block.break = true;
                //Меняем направление движения
                ball.vX *= -1;
                //Уменьшаем количество блоков на поле 
                blockCount -= 1;
                //Увеличение счёта
                score += 1;

            }
            //Устанавливаем заливку блоку
            context.fillRect(block.x, block.y, block.width, block.height);
        }
    }
    //Если блоков на поле не осталось
    if (blockCount == 0) {
        //Указываем количество рядов(не может быть больше 10)
        blockRows = Math.min(blockRows + 1, blockMaxRows);
        //Создаём блоки
        createBlocks();
    }
    //Отрисовываем счёт на поле
    context.fillStyle = "skyblue";
    context.font = "20px sans-serif";
    context.fillText(score, 10, 25);

    //Отскакивание мяча
    //Если коснулся верхней границы
    if (ball.y <= 0) {
        //То изменяем направление мяча по Y, умножив скорость на -1
        ball.vY *= -1;
    }
    //Если коснулся левой или правой границы
    else if (ball.x <= 0 || (ball.x + ball.width >= bWidth)) {
        //То изменяем направление мяча по Х, умножив скорость на -1
        ball.vX *= -1;
    }
    //Если коснулся нижней границы, то мы проигрываем
    else if (ball.y + ball.height >= bHeight) {
        context.font = "20px sans-serif";
        context.fillText("Game Over: Press 'Space' to Restart", 80, 400);
        gameOver = true;
    }
}
