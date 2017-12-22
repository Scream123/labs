<?
//Хранение паролей пользователей
define('FILE_NAME', '.htpasswd');

//Генерация хеш пароля
function getHash($password) {
    $hash = password_hash($password, PASSWORD_BCRYPT);
    return trim($hash);
}

//Проверка пароля
function checkHash (
    $password, $hash) {
    return password_verify(trim($password), trim($hash));
}

//Создание новой записи в файле пользователей
function saveUser($login, $hash) {
    $str = "$login:$hash\n";
    if(file_put_contents(FILE_NAME, $str, FILE_APPEND))
        return true;
    else
        return false;
}

//проверка наличия пользователя в списке
function userExists($login) {
    if(!is_file(FILE_NAME))
    return false;
    $users = file(FILE_NAME);
    foreach($users as $user) {
        if(strpos($user, $login.':') !== false)
        return $user;
    }
    return false;
}

//Завершение сеанса пользователя
function logOut() {
    session_destroy();
    header('Location: secure/login.php');
    exit;
}