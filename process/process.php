<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Post method is required');
}

session_start();
$error_empty = [];
$old_values = [];

require "./functions.php";

(function () {
    // check validation errors
    global $error_empty, $old_values;
    $requiredFields = ['name', 'language', 'email', 'password'];
    foreach ($requiredFields as $inputName) {
        isEmptyInput($error_empty, $old_values, $inputName);
    }

    checkImage($error_empty, $old_values , true);

    if (empty($error_empty['name'])) {
        validateName($error_empty, $old_values);
    }

    if (empty($error_empty['email'])) {
        validateEmail($error_empty, $old_values);
    }

    $hashedPassword = null;
    if (empty($error_empty['password'])) {
        $hashedPassword = validatePassword($error_empty, $old_values);
        $_SESSION['hashedPassword'] = $hashedPassword;
    }
    checkErrors($error_empty, $old_values);
    $_SESSION['errors'] = [];
})();
