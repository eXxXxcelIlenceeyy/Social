// Начинает игрок X
let currentPlayer = "X";
// Устанавливает начальное значение переменной, которая показывает, завершена ли игра
let gameEnded = false;
// Создает пустое поле для игры
let board = ["", "", "", "", "", "", "", "", ""];
// Определяет выигрышные комбинации для игры
const winPatterns = [
    [0, 1, 2], [3, 4, 5], [6, 7, 8],
    [0, 3, 6], [1, 4, 7], [2, 5, 8],
    [0, 4, 8], [2, 4, 6]
];
// Функция, вызываемая при клике на ячейку
// function cellClicked(cellIndex) {
//     // Проверяет, что игра не завершена и выбранная ячейка пуста
//     if (!gameEnded && board[cellIndex] === "") {
//         // Получает элемент ячейки по его индексу
//         const cell = document.getElementById(`cell${cellIndex}`);
//         // Устанавливает текст ячейки в значение текущего игрока
//         cell.textContent = currentPlayer;
//         // Устанавливает атрибут data-value в значение текущего игрока
//         cell.setAttribute('data-value', currentPlayer);
//         // Записывает значение текущего игрока в массив игрового поля
//         board[cellIndex] = currentPlayer;
//         // Проверяет, выиграл ли текущий игрок
//         if (checkWinner(currentPlayer)) {
//             // Выводит сообщение о победе текущего игрока
//             document.getElementById("message").textContent = `Игрок ${currentPlayer} победил!`;
//             // Устанавливает, что игра завершена
//             gameEnded = true;
//         } else if (isBoardFull()) {
//             // Выводит сообщение о ничьей, если игровое поле полностью заполнено
//             document.getElementById("message").textContent = "Ничья!";
//             // Устанавливает, что игра завершена
//             gameEnded = true;
//         } else {
//             // Переключает текущего игрока на другого игрока
//             currentPlayer = currentPlayer === "X" ? "O" : "X";
//         }
//     }
// }

// Функция, которая проверяет, выиграл ли игрок
function checkWinner(player) {
    // Перебирает все выигрышные комбинации
    for (const pattern of winPatterns) {
        // Получает индексы ячеек из текущей выигрышной комбинации
        const [a, b, c] = pattern;
        // Проверяет, что все три ячейки имеют значение текущего игрока
        if (board[a] === player && board[b] === player && board[c] === player) {
            // Возвращает true, если текущий игрок выиграл
            return true;
        }
    }
    // Возвращает false, если текущий игрок не выиграл
    return false;
}
// Функция, которая проверяет, заполнено ли игровое поле
function isBoardFull() {
    // Возвращает true, если все ячейки заполнены
    return board.every(cell => cell !== "");
}

// Функция обработки клика по клетке
function cellClicked(cellIndex) {
    if (!gameEnded && board[cellIndex] === "") {
        const cell = document.getElementById(`cell${cellIndex}`);
        cell.textContent = currentPlayer;
        cell.setAttribute('data-value', currentPlayer);
        board[cellIndex] = currentPlayer;
        if (checkWinner(currentPlayer)) {
            document.getElementById("message").textContent = `Игрок ${currentPlayer} победил!`;
            gameEnded = true;
        } else if (isBoardFull()) {
            document.getElementById("message").textContent = "Ничья!";
            gameEnded = true;
        } else {
            currentPlayer = currentPlayer === "X" ? "O" : "X";
            if (currentPlayer === "O") { // Если ходит бот
                setTimeout(botMove, 10); // Задержка перед ходом бота
            }
        }
    }
}
// Функция для хода бота
function botMove() {
    let emptyCells = []; // Массив для хранения индексов пустых клеток
    // Находим все пустые клетки на игровом поле
    for (let i = 0; i < board.length; i++) {
        if (board[i] === "") {
            emptyCells.push(i);
        }
    }
    // Выбираем случайную пустую клетку для хода бота
    const randomIndex = Math.floor(Math.random() * emptyCells.length);
    const randomCellIndex = emptyCells[randomIndex];
    const cell = document.getElementById(`cell${randomCellIndex}`);
    cell.textContent = currentPlayer;
    cell.setAttribute('data-value', currentPlayer); // Устанавливаем атрибут data-value для стилей
    board[randomCellIndex] = currentPlayer; // Обновляем состояние игрового поля
    if (checkWinner(currentPlayer)) { // Проверяем, выиграл ли текущий игрок
        document.getElementById("message").textContent = `Игрок ${currentPlayer} победил!`; // Выводим сообщение о победе
        gameEnded = true; // Устанавливаем флаг окончания игры
    } else if (isBoardFull()) { // Проверяем, заполнено ли поле
        document.getElementById("message").textContent = "Ничья!"; // Выводим сообщение о ничьей
        gameEnded = true; // Устанавливаем флаг окончания игры
    } else { // Если игра продолжается
        currentPlayer = currentPlayer === "X" ? "O" : "X"; // Переключаем игрока
    }
}
