<?php
session_start();
require "./functions.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Post method is required');
}

if (empty($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

if (!checkIsNewData()) {
    header("Location: ../profile/profile.php?bool=noUpdate");
    exit;
}

$error_update = [];
$old_values = $_SESSION['old_values'];


(function () {
    //* check if the same data in session 

    //* check validation errors
    global $error_update, $old_values;
    $requiredFields = ['name', 'language', 'email'];
    foreach ($requiredFields as $inputName) {
        isEmptyInput($error_update, $old_values, $inputName);
    }

    checkImage($error_update, $old_values, false);

    if (empty($error_update['name'])) {
        validateName($error_update, $old_values);
    }

    if (empty($error_update['email'])) {
        validateEmail($error_update, $old_values);
    }

    checkErrorsUpdate($error_update, $old_values);
})();
