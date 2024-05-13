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

// Функция для хода бота
function botMove() {
    let bestScore = -Infinity; // Лучший результат для бота, сначала задаём самый низкий возможный(минус бесконечность)
    let bestMove; // Лучший ход, который бот может сделать
    // Проходим по каждой пустой клетке на игровом поле
    for (let i = 0; i < board.length; i++) {
        if (board[i] === "") { // Проверяем, нет ли в клетке уже крестика или 
            нолика
            board[i] = "O"; // Помечаем текущую клетку как ход бота, ставим в неё нолик
            let score = minimax(board, 0, false); // Рассчитываем оценку хода с помощью минимакса
            board[i] = ""; // Отменяем ход бота, чтобы не повлиять на следующие проверки
            // Если оценка текущего хода лучше предыдущего лучшего результата
            if (score > bestScore) {
                bestScore = score; // Обновляем лучший результат
                bestMove = i; // Запоминаем индекс клетки, куда лучше всего сходить
            }
        }
    }
    // Выполняем лучший ход бота
    const cell = document.getElementById(`cell${bestMove}`);
    cell.textContent = currentPlayer; // Отображаем нолик в клетке, куда бот решил сходить
    cell.setAttribute('data-value', currentPlayer); // Устанавливаем атрибут data-value, чтобы стили применились
    board[bestMove] = currentPlayer; // Обновляем игровое поле
    // Проверяем, есть ли победитель или ничья после хода
    if (checkWinner(currentPlayer)) {// Если бот выиграл
        document.getElementById("message").textContent = `Игрок ${currentPlayer} победил!`;
        gameEnded = true; // Устанавливаем флаг окончания игры
    } else if (isBoardFull()) { // Если игровое поле заполнено и никто не победил
        document.getElementById("message").textContent = "Ничья!"; // Объявляем ничью
        gameEnded = true; // Устанавливаем флаг окончания игры
    } else { // Если игра продолжается
        currentPlayer = currentPlayer === "X" ? "O" : "X"; // Переключаемся на следующего игрока
    }
}
// Функция минимакса (пробуем поставить в любую свободную клетку и анализируем)
function minimax(board, depth, isMaximizing) {
    if (checkWinner("X")) { // Если победил крестик
        return -10; // Возвращаем оценку -10 (проигрыш для нолика)
    } else if (checkWinner("O")) { // Если победил нолик
        return 10; // Возвращаем оценку 10 (победа для нолика)
    } else if (isBoardFull()) { // Если игровое поле заполнено, но никто не выиграл
        return 0; // Возвращаем оценку 0 (ничья)
    }
    if (isMaximizing) { // Если сейчас ходит нолик (максимизируем результат для нолика)
        let bestScore = -Infinity; // Начальный лучший результат для нолика
        for (let i = 0; i < board.length; i++) {
            if (board[i] === "") { // Проверяем пустые клетки
                board[i] = "O"; // Помечаем текущую клетку как ход нолика
                let score = minimax(board, depth + 1, false); // Рекурсивно вызываем минимакс для следующего хода
                board[i] = ""; // Отменяем ход
                bestScore = Math.max(score, bestScore); // Выбираем максимальную оценку
            }
        }
        return bestScore; // Возвращаем наилучший результат для нолика
    } else { // Если сейчас ходит крестик (минимизируем результат для крестика)
        let bestScore = Infinity; // Начальный лучший результат для крестика
        for (let i = 0; i < board.length; i++) {
            if (board[i] === "") { // Проверяем пустые клетки
                board[i] = "X"; // Помечаем текущую клетку как ход крестика
                let score = minimax(board, depth + 1, true); // Рекурсивно вызываем минимакс для следующего хода
                board[i] = ""; // Отменяем ход
                bestScore = Math.min(score, bestScore); // Выбираем минимальную оценку
            }
        }
        return bestScore; // Возвращаем наилучший результат для крестика
    }
}