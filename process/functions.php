<?php
/* ====== is Empty input ====== */
function isEmptyInput(array &$error_empty, array &$old_values, string $type)
{
    $input = $_REQUEST[$type] ?? "";
    $old_values[$type] = $input;
    $typeUpper = "";
    if (empty($input)) {
        $typeUpper = ucwords(str_replace('_', ' ', $type));
        $error_empty[$type] = "$typeUpper is required";
    }
}

// upload image after validation
$newFileName = "";
function checkImage(array &$error_empty, array &$old_values, bool $bool = true)
{
    global $newFileName;
    $noFileUploaded = !isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE;

    if ($noFileUploaded) {
        if ($bool) {
            $error_empty['image'] = "Profile Image is required";
        }
        return;
    }


    $file = $_FILES['image'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $originalFileName = pathinfo($fileName, PATHINFO_FILENAME);
    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Check if the file is an image
    if (!checkValidExtention($error_empty, $fileName)) {
        return;
    } else if (!checkValidFileImage($error_empty, $fileTmpName)) {
        return;
    } else {
        $currentTime = time();
        $newFileName = "{$originalFileName}_{$currentTime}.{$extension}";
        $uploadDir = __DIR__ . '/uploads/image';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $uploadPath = "$uploadDir/$newFileName";
        if (!move_uploaded_file($fileTmpName, $uploadPath)) {
            $error_empty['image'] = "Failed to upload image";
            return;
        }

        if (!$noFileUploaded) {
            $oldImage = $_SESSION['user']['image'] ?? "";
            if ($oldImage && $oldImage !== 'default.jpg') {
                $oldImagePath = "$uploadDir/$oldImage";
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }
    }
}

// validate file image if not match image/name
function checkValidFileImage(array &$error_empty, string $fileTmpName)
{
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $fileTmpName);
    $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
    if (!in_array($mime, $allowedMimes)) {
        $error_empty['image'] = "Invalid file content. The file does not match an allowed image type.";
        return false;
    }
    return true;
}

// validate extention of image
function checkValidExtention(array &$error_empty, string $fileName)
{
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $allowedExtensions)) {
        $error_empty['image'] = "Invalid file type. Only JPG, JPEG, PNG, and WEBP are allowed";
        return false;
    }
    return true;
}

//check error add user
function checkErrors(array &$error_empty, array &$old_values)
{
    if (!empty($error_empty)) {
        $_SESSION['errors'] = $error_empty;
        $_SESSION['old_values'] = $old_values;
        header("Location: ../index.php");
        exit;
    }
    addUser($_REQUEST['name'], $_REQUEST['email'], $_REQUEST['language']);
}

// check if the error input is found
function checkErrorsUpdate(array &$error_update, array &$old_values)
{
    if (!empty($error_update)) {
        $_SESSION['error_update'] = $error_update;
        $_SESSION['old_values'] = $old_values;
        header("Location: ../profile/profile.php?update=profile");
        exit;
    }
    updateUser($_REQUEST['name'], $_REQUEST['email'], $_REQUEST['language']);
}

// update the data user 
function updateUser(string $name, string $email, string $language)
{
    global $newFileName;
    $_SESSION['user'] = [
        'id' => $_SESSION['user']['id'],
        'name' => $name,
        'email' => $email,
        'language' => $language,
        'password' => $_SESSION['user']['password'],
        'image' => ($newFileName ?? '') === '' ? $_SESSION['user']['image'] : $newFileName,
        "created_at" => $_SESSION['user']['created_at'],
        "updated_at" => date('Y-m-d H:i:s')
    ];
    $_SESSION["old_values"] = [];
    $_SESSION["error_update"] = [];
    header("Location: ../profile/profile.php?bool=updated");
    exit;
}


// validate name
function validateName(array &$error_empty, array &$old_values)
{
    $name = $_REQUEST['name'] ?? '';
    $old_values['name'] = $name;
    if (!preg_match("/^[a-zA-Z]{3,}(\s+[a-zA-Z]{3,}){0,2}$/", $name)) {
        $error_empty['name'] = "Each word must be at least 3 letters long (up to 3 words)";
    }
}

// validate email
function validateEmail(array &$error_empty, array &$old_values)
{
    $email = $_REQUEST['email'] ?? '';
    $old_values['email'] = $email;
    if (!preg_match("/^[a-zA-Z][\w.]*@(gmail|yahoo)\.(com|org)$/", $email)) {
        $error_empty['email'] = "Invalid email format (example: user@gmail.com)";
    }
}

// validate password
function validatePassword(array &$error_empty, array &$old_values)
{
    $password = $_REQUEST['password'] ?? '';
    $old_values['password'] = $password;
    $errors = [];
    if (!preg_match("/^.{8,}$/", $password)) {
        $errors[] = "* Password must be at least 8 characters long";
    }
    if (!preg_match("/(?=.*[A-Z])/", $password)) {
        $errors[] = "* include at least one uppercase letter ";
    }
    if (!preg_match("/(?=.*[a-z])(?=.*\d)/", $password)) {
        $errors[] = "* include at least one lowercase letter and one number ";
    }
    if (!preg_match("/(?=.*[\W_])/", $password)) {
        $errors[] = "* include at least one special character ";
    }

    if (!empty($errors)) {
        $error_empty['password'] = implode('<br>', $errors);
        return;
    }
    return encryptPassword($password);
}

// encript the password
function encryptPassword(string $password): string
{
    return password_hash($password, PASSWORD_DEFAULT);
}

// add a new user
function addUser(string $name, string $email, string $language): void
{
    global $newFileName;
    $_SESSION['user'] = [
        'id' => time(),
        'name' => $name,
        'email' => $email,
        'language' => $language,
        'password' => encryptPassword($_REQUEST['password']),
        'image' => $newFileName,
        "created_at" => date('Y-m-d H:i:s'),
        "updated_at" => date('Y-m-d H:i:s')
    ];
    $_SESSION["old_values"] = [];
    $_SESSION["errors"] = [];
    header("Location: ../profile/profile.php");
    exit;
}

// check if the same data user in session 
function checkIsNewData(): bool
{
    $hasFile = isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE;

    if ($hasFile) {
        return true;
    }

    foreach ($_REQUEST as $request => $value) {
        if (isset($_SESSION['user'][$request]) && $_SESSION['user'][$request] != $value) {
            return true;
        }
    }

    return false;
}


// validate new password
function validateAndUpdatePassword(array &$error_update, array &$old_values)
{
    $currentPassword = $_REQUEST['password'] ?? '';
    $newPassword = $_REQUEST['New_password'] ?? '';
    $confirmPassword = $_REQUEST['Confirm_password'] ?? '';

    // check is the same password in session
    if (!password_verify($currentPassword, $_SESSION['user']['password'])) {
        $error_update['password'] = "Current password is incorrect";
        return;
    }

    // check regex password
    $errors = [];
    if (!preg_match("/^.{8,}$/", $newPassword)) {
        $errors[] = "* Password must be at least 8 characters long";
    }
    if (!preg_match("/(?=.*[A-Z])/", $newPassword)) {
        $errors[] = "* include at least one uppercase letter";
    }
    if (!preg_match("/(?=.*[a-z])(?=.*\d)/", $newPassword)) {
        $errors[] = "* include at least one lowercase letter and one number";
    }
    if (!preg_match("/(?=.*[\W_])/", $newPassword)) {
        $errors[] = "* include at least one special character";
    }
    if (!empty($errors)) {
        $error_update['New_password'] = implode('<br>', $errors);
        return;
    }

    // check if the new password the same Confirm password
    if ($newPassword !== $confirmPassword) {
        $error_update['Confirm_password'] = "Passwords do not match";
        return;
    }

    // check if the new pass the same current password
    if (password_verify($newPassword, $_SESSION['user']['password'])) {
        $error_update['New_password'] = "New password must be different from the current password";
        return;
    }

    $_SESSION['user']['password'] = encryptPassword($newPassword);
    $_SESSION['user']['updated_at'] = date('Y-m-d H:i:s');
}
