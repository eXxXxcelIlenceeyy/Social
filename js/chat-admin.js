// Объявляем переменные для хранения выбранного пользователя и состояния видимости списка стикеров
let selectedUserId = 0;
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

// Функция для загрузки сообщений пользователя
function loadMessages(receiverUserId) {
    const chatMessages = document.getElementById('chat-messages');
    chatMessages.innerHTML = '';
    // Отправляем AJAX-запрос на сервер для получения сообщений
    fetch('getMessages.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded', },
        body: `receiver_id=${receiverUserId}`, // Отправляем ID получателя
    })
        .then(response => response.text())
        .then(messagesText => {
            // Разбиваем текст на строки и отображаем каждую строку как сообщение
            const messagesArray = messagesText.split('\n');
            for (const messageText of messagesArray) {
                const messageElement = document.createElement('div');
                messageElement.textContent = messageText;
                chatMessages.appendChild(messageElement);
            }
        })
        .catch(error => {
            console.error('Error loading messages:', error);
        });
}

// Функция для отправки сообщения
function sendMessage() {
    const messageInput = document.getElementById('message');
    const messageText = messageInput.value;
    // Проверяем, выбран ли получатель сообщения
    if (!selectedUserId) {
        selectedUserId = 0;  // Значение 0 будет означать отправку всем администраторам
    }
    // Отправляем AJAX-запрос на сервер для отправки сообщения
    fetch('sendMessage.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded', },
        body: `receiver_id=${selectedUserId}&message=${encodeURIComponent(messageText)}`,
    })
        .then(response => response.text())
        .then(responseText => {
            console.log('Response from sendMessage.php:', responseText);
            loadMessages(selectedUserId);
        })
        .catch(error => {
            console.error('Error sending message:', error);
        });
    // Очищаем поле ввода сообщения после отправки
    messageInput.value = '';
}

// При загрузке страницы выполняем функцию для получения списка пользователей
document.addEventListener('DOMContentLoaded', () => {
    getUsers();
    loadMessages();
});