//Переменные для поля
let blockSize = 25;
let rows = 20;
let cols = 30;
let board;
let context;
//Переменные для координат головы змейки
let snakeX;
let snakeY;
//Переменные для хранения направления движения
let vX = 0;
let vY = 0;
//Массив для хранения ячеек змейки
var snakeBody = [];
//Переменные для координат еды
let foodX;
let foodY;
//Переменная счётчика
var score = 0;


//Функция для отрисовки поля на странице
window.onload = function () {
    board = document.getElementById("board");
    board.height = rows * blockSize;
    board.width = cols * blockSize;
    //Задаём возможность рисовать на поле
    context = board.getContext("2d");
    //Вызов функций для появления змейки и яблока на поле
    placeFood();
    placeSnake();
    //Прослушивание нажатий клавиш
    document.addEventListener("keyup", changeDirection);
    //Каждые 100 миллисекунд будет перерисовываться поле(Нужно для движения змейки)
    setInterval(update, 150);
}

//Функция для изменения направления змейки
function changeDirection(event) {
    //Если нажата клавиша «W» и змейка не движется вниз
    if (event.code == "ArrowUp" && vY != 1) {
        //Не двигаемся по оси Х
        vX = 0;
        //Движемся по оси Y вверх
        vY = -1;
    }
    //Если нажата клавиша «S» и змейка не движется вверх
    else if (event.code == "ArrowDown" && vY != -1) {
        //Не двигаемся по оси Х
        vX = 0;
        //Движемся по оси Y вниз
        vY = 1;
    }
    //Если нажата клавиша «A» и змейка не движется вправо
    else if (event.code == "ArrowLeft" && vX != 1) {
        //Движемся по оси Х влево
        vX = -1;
        //Не двигаемся по оси Y
        vY = 0;
    }
    //Если нажата клавиша «D» и змейка не движется влево
    else if (event.code == "ArrowRight" && vX != -1) {
        //Движемся по оси Х вправо
        vX = 1;
        //Не двигаемся по оси Y
        vY = 0;
    }
}

//Генерация случайных координат для яблока
function placeFood() {
    foodX = Math.floor(Math.random() * cols) * blockSize;
    foodY = Math.floor(Math.random() * rows) * blockSize;
}
//Генерация случайных координат для змейки
function placeSnake() {
    snakeX = Math.floor(Math.random() * cols) * blockSize;
    snakeY = Math.floor(Math.random() * rows) * blockSize;
}

function update() {
    //Задаём фон полю
    context.fillStyle = "black";
    //Так как работаем с ячейками, нужно задать диапазон закрашивания
    context.fillRect(0, 0, board.width, board.height);

    //Задаём заливку яблоку
    context.fillStyle = "red";
    context.fillRect(foodX, foodY, blockSize, blockSize);
    //поедание яблока (Если координаты головы и яблока совпадают)
    if (snakeX == foodX && snakeY == foodY) {
        placeFood();
    }


    //Задаём заливку змейке
    context.fillStyle = "lime";
    //Изменяем координаты змейки
    snakeX += vX * blockSize;
    snakeY += vY * blockSize;
    context.fillRect(snakeX, snakeY, blockSize, blockSize);
}
