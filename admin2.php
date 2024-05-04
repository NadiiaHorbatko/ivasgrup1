<?php

include('_config.php');

session_start();

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    if (isset($_POST['login']) && $_POST['login'] === $_admname && $_POST['pass'] === $_admpass) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $_admname;
    } else {
        die(require 'login_form.php');
    }
}

function echo_type($name) {
    echo "<select name='{$name}'>
            <option value='0'>желательно</option>
            <option value='1'>строго</option>
            <option value='-1'>не важно для отбора</option>
          </select>\r\n";
}

// Подключение к базе данных
$mysqli = new mysqli($sql_host, $sql_user, $sql_pass, $sql_dbnm);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");

// Далее - код для обработки данных, вывода и т.д., пример функции для работы с базой:
function deleteCandidate($id) {
    global $mysqli;
    $stmt = $mysqli->prepare("DELETE FROM candidates WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Пример вызова функции
if (isset($_GET['del'])) {
    deleteCandidate($_GET['del']);
}
?>
