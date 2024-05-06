window.addEventListener('load', function () {
    setTimeout(function () {
        let loader = document.querySelector('.loader'); // Находим элемент прелоадера 
        loader.style.transition = 'opacity 0.5s ease-in-out'; // Добавляем transition для плавного исчезновения 
        loader.style.opacity = '0'; // Устанавливаем нулевую прозрачность для начала анимации исчезновения 
        setTimeout(function () {
            loader.style.display = 'none'; // Скрываем прелоадер после окончания анимации 
            loader.style.zIndex = 'auto'; // Установка z-index для прелоадера на автоматический 
        }, 500); // 0.5 секунды на анимацию исчезновения 
    }, 500); // 3 секунды – длительность анимации прелоадера 
});