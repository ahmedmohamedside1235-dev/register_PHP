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

$error_update = [];
$old_values = [];


(function () {

    if (isset($_GET['isPassword']) && $_GET['isPassword'] === 'true') {
        global $error_update, $old_values;
        $requiredFields = ['password', 'New_password', 'Confirm_password'];
        foreach ($requiredFields as $inputName) {
            isEmptyInput($error_update, $old_values, $inputName);
        }

        if (empty($error_update)) {
            validateAndUpdatePassword($error_update, $old_values);
        }

        if (!empty($error_update)) {
            $_SESSION['error_update'] = $error_update;
            $_SESSION['old_values'] = $old_values;
            header("Location: ../profile/profile.php?update=password");
            exit;
        }

        unset($_SESSION['error_update']);
        unset($_SESSION['old_values']);
        header("Location: ../profile/profile.php?bool=updated&update=password");
        exit;
    } 

    if (!checkIsNewData()) {
        header("Location: ../profile/profile.php?bool=noUpdate");
        exit;
    }

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
