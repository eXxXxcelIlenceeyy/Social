// Объявляем переменные для хранения выбранного пользователя и состояния видимости списка стикеров
let selectedUserId = null;
let stickerListVisible = false;

// Функция для переключения видимости списка стикеров
function toggleStickerList() {
    const stickerList = document.getElementById('sticker-list');
    stickerList.classList.toggle('show');
}

// Добавляем обработчик события click для кнопки со стикерами
document.addEventListener('DOMContentLoaded', () => {
    const stickerButton = document.getElementById('sticker-button');
    stickerButton.addEventListener('click', toggleStickerList)
});

// Функция для вставки стикера в поле ввода сообщения
function insertSticker(sticker) {
    const messageInput = document.getElementById('message');
    messageInput.value += sticker;
    messageInput.focus();
}

// Функция для вставки стикера в поле ввода сообщения
function getUsers() {
    // Отправляем AJAX-запрос на сервер для получения списка пользователей
    fetch('getUsers.php')
        .then((response) => response.json())
        .then((users) => {
            const userList = document.getElementById('all-users');
            userList.innerHTML = '';

            // Добавляем каждого пользователя в список пользователей
            users.forEach((user) => {
                const listItem = document.createElement('li');
                listItem.textContent = user.username;
                listItem.onclick = () => {
                    // При выборе пользователя обновляем ID выбранного пользователя и загружаем его сообщения
                    selectedUserId = user.id;
                    loadMessages(selectedUserId);

                    // Убираем стиль выбранного у всех пользователей
                    document.querySelectorAll('#all-users li').forEach((item) => {
                        item.classList.remove('selected');
                    });
                    // Добавляем стиль выбранного пользователю
                    listItem.classList.add('selected');
                };
                userList.appendChild(listItem);
            });
        });
}
// При загрузке страницы выполняем функцию для получения списка пользователей
document.addEventListener('DOMContentLoaded', () => {
    getUsers();
});
