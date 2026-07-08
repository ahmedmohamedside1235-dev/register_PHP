<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/plugins/all.min.css">
    <link rel="stylesheet" href="css/plugins/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Registration</title>
</head>

<body>
    <div class="container py-3">
        <div class="content py-4">
            <div class="head text-center d-flex align-items-center flex-column">
                <i class="fa-solid fa-user-plus mb-2"></i>
                <h2>Registration</h2>
                <p>Fill in the details to add register</p>
            </div>
            <div class="body py-2">
                <form action="process/process.php" method="POST" enctype="multipart/form-data">

                    <!--* input name -->
                    <div class="form-group mb-4 d-flex align-items-center">
                        <label class="me-2 d-block " for="Name">Name:</label>
                        <input type="text" autocomplete="off" required class="form-control" name="name" id="Name" value="<?php echo $_SESSION['old_values']['name'] ?? ''; ?>">
                    </div>

                    <!--* error name -->
                    <p class="alert alert-danger <?php echo isset($_SESSION['errors']['name']) ? '' : 'd-none'; ?>">
                        <?php echo $_SESSION['errors']['name'] ?? ''; ?>
                    </p>

                    <!--* input email -->
                    <div class="form-group mb-4 d-flex align-items-center">
                        <label class="me-2 d-block" for="Email">Email:</label>
                        <input type="text" autocomplete="off" required class="form-control" name="email" id="Email" value="<?php echo $_SESSION['old_values']['email'] ?? ''; ?>">
                    </div>
                    
                    <!--* error email -->
                    <p class="alert alert-danger <?php echo isset($_SESSION['errors']['email']) ? '' : 'd-none'; ?>">
                        <?php echo $_SESSION['errors']['email'] ?? ''; ?>
                    </p>

                    <!--* select language -->
                    <div class="form-group mb-4 d-flex align-items-center">
                        <label class="me-2 d-block" for="Language">Language:</label>
                        <select class="form-control" name="language" autocomplete="off" id="Language" required>
                            <option value="" disabled <?php echo empty($_SESSION['old_values']['language']) ? 'selected' : ''; ?> hidden>
                                Select Language
                            </option>
                            <option value="Arabic" <?php echo (($_SESSION['old_values']['language'] ?? '') === 'Arabic') ? 'selected' : ''; ?>>
                                Arabic
                            </option>
                            <option value="English" <?php echo (($_SESSION['old_values']['language'] ?? '') === 'English') ? 'selected' : ''; ?>>
                                English
                            </option>
                        </select>
                    </div>

                    <!--* error language -->
                    <p class="alert alert-danger <?php echo isset($_SESSION['errors']['language']) ? '' : 'd-none'; ?>">
                        <?php echo $_SESSION['errors']['language'] ?? ''; ?>
                    </p>

                    <!--* input password  -->
                    <div class="form-group mb-4 d-flex align-items-center">
                        <label class="me-2 d-block" for="Password">Password:</label>
                        <div class="password w-100">
                            <input type="password" autocomplete="off" required class="form-control" name="password" id="Password">
                            <i class="fa-solid eye_pass fa-eye-slash" onclick="togglePassword(this,false)"></i>
                        </div>
                    </div>

                    <!--* error password  -->
                    <p class="alert alert-danger <?php echo isset($_SESSION['errors']['password']) ? '' : 'd-none'; ?>">
                        <?php echo $_SESSION['errors']['password'] ?? ''; ?>
                    </p>

                    <!--* file image -->
                    <div class="form-group mb-4 d-flex align-items-center">
                        <label class="me-2 d-block" for="Image">Profile Image:</label>
                        <input class="form-control" name="image" type="file" id="Image" multiple>
                    </div>

                    <!--* error image -->
                    <p class="alert alert-danger <?php echo isset($_SESSION['errors']['image']) ? '' : 'd-none'; ?>">
                        <?php echo $_SESSION['errors']['image'] ?? ''; ?>
                    </p>

                    <div class="form-group">
                        <button class="btn btn-secondary text-light fw-bolder d-block w-100">Register <i class="fa-solid fa-person-circle-plus"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.js"></script>
    <script src="js/index.js"></script>
</body>

</html>