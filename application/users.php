<?php
session_start();
include("db.php");
// Функция для установки значений в сессию
function setSession($id, $us_name, $admin, $age)
{
    $_SESSION['id'] = $id;
    $_SESSION['login'] = $us_name;
    $_SESSION['admin'] = $admin;
    $_SESSION['age'] = $age;
}

// Регистрация нового пользователя
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['button-reg'])) {
    // Получаем данные из формы
    $us_name = $_POST['login'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $pass_first = $_POST['pass-first'];
    $pass_second = $_POST['pass-second'];

    // Проверяем, совпадают ли пароли
    if ($pass_first !== $pass_second) {
        echo "Пароли не совпадают.";
    } else {
        // Хэшируем пароль
        $hashed_password = password_hash($pass_first, PASSWORD_DEFAULT);

        // Проверяем, существует ли пользователь с таким email
        $check_email_query = "SELECT * FROM users WHERE email='$email'";

        //Выполняет запрос к базе данных
        $check_email_result = $conn->query($check_email_query);

        if ($check_email_result->num_rows > 0) {
            echo "Пользователь с таким адресом электронной почты уже существует.";
        } else {
            // Устанавливаем значение поля admin
            $admin = 0;

            // Подготавливаем и выполняем запрос на вставку данных в базу
            $stmt = $conn->prepare("INSERT INTO users (admin, us_name, email, age, password) VALUES (?,?,?,?,?)");
            $stmt->bind_param("issss", $admin, $us_name, $email, $age, $hashed_password); // "issis" - по сути верный вариант

            if ($stmt->execute()) {
                echo "Регистрация успешна.";
                setSession($conn->insert_id, $us_name, 0, $age);
                header("Location: profile/accaunt.php");
                exit();
            } else {
                echo "Ошибка при регистрации: " . $conn->error;
            }
            // Закрываем подготовленный запрос
            $stmt->close();
        }
    }
}

// Авторизация пользователя
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['button-log'])) {
    // Получаем данные из формы
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Подготавливаем и выполняем запрос на выборку данных пользователя из базы
    $stmt = $conn->prepare("SELECT id, us_name, admin, age, password FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Проверяем введенный пароль с хэшированным паролем в базе
        if (password_verify($password, $row['password'])) {
            echo "Авторизация успешна. Добро пожаловать, " . $row['us_name'];
            setSession($row['id'], $row['us_name'], $row['admin'], $row['age']);

            header("Location: profile/accaunt.php");
            exit(); // Добавлено
        } else {
            echo "Неверный пароль.";
        }
    } else {
        echo "Пользователь с таким адресом электронной почты не найден.";
    }

    // Закрываем подготовленный запрос
    $stmt->close();
}

// Редактировать профиль
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['button-upd'])) {
    // Получаем данные из формы
    $id = $_SESSION['id'];
    $us_name = $_POST['user-name'];
    $email = $_POST['user-email'];
    $age = $_POST['user-age'];
    $info = $_POST['user-info'];
    $pass_first = $_POST['pass-first'];
    $pass_second = $_POST['pass-second'];
    // Проверяем, совпадают ли пароли
    if ($pass_first !== $pass_second) {
        echo "Пароли не совпадают.";
    } else {
        // Проверяем, был ли введен новый пароль, если да, то хешируем и помещаем в кусочек запроса,
        // иначе в запросе новый пароль не указываем
        if (!empty($pass_first)) {
            // Хэшируем новый пароль
            $hashed_password = password_hash($pass_first, PASSWORD_DEFAULT);
            $password_update = ", password = '$hashed_password'";
        } else {
            // Если пароль не введен, то оставляем прежний пароль
            $password_update = "";
        }
        // Проверяем, существует ли пользователь с таким email, исключая текущего пользователя
        $check_email_query = "SELECT * FROM users WHERE email='$email' AND id != $id";
        $check_email_result = $conn->query($check_email_query);
        if ($check_email_result && $check_email_result->num_rows > 0) {
            echo "Пользователь с таким адресом электронной почты уже существует.";
        } else {
            // Подготавливаем и выполняем запрос на обновление данных в базе
            $info_escaped = mysqli_real_escape_string($conn, $info);
            $update_query = "UPDATE users SET us_name = '$us_name', email = '$email', age = $age $password_update, info = '$info_escaped' WHERE id = $id";
            if ($conn->query($update_query) === TRUE) {
                echo "Данные успешно изменены.";
                $_SESSION['login'] = $us_name;
                $_SESSION['age'] = $age;
                header("Location: http://localhost/Social/profile/accaunt.php");
                exit();
            } else {
                echo "Ошибка при обновлении данных: " . $conn->error;
            }
        }
    }
}
