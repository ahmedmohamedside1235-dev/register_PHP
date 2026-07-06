<?php session_start();
if (empty($_SESSION['user'])) {
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/plugins/all.min.css">
    <link rel="stylesheet" href="../css/plugins/bootstrap.css">
    <link rel="stylesheet" href="css/profile.css">
    <title>Profile <?php echo $_SESSION['user']['name'] ?? 'User'; ?></title>
</head>

<body>
    <header>
        <div class="container py-5">
            <div class="content py-4 px-3">
                <div class="head d-flex align-items-center flex-column justify-content-center">
                    <img src="<?php echo "../process/uploads/image/" . (($_SESSION['user']['image'] ?? '') === '' ? 'default.jpg' : $_SESSION['user']['image']); ?>" class="mb-3" alt="">
                    <h2><?php echo $_SESSION['user']['name'] ?? 'User'; ?></h2>
                </div>
                <hr>
                <div class="body py-3">
                    <div class="data_Id mb-4">
                        <div class="item memberId d-flex align-items-center justify-content-start">
                            <span><i class="fa-solid fa-address-card me-3 headData  "></i></span>
                            <div class="info">
                                <p class="mb-0 headData">Member ID</p>
                                <p class="value fw-bolder mb-0"><?php echo $_SESSION['user']['id'] ?? 'N/A'; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="data_email mb-4">
                        <div class="item memberId d-flex align-items-center justify-content-start">
                            <span><i class="fa-solid fa-envelope me-3 headData"></i></span>
                            <div class="info">
                                <p class="mb-0 headData">Email</p>
                                <p class="value fw-bolder mb-0"><?php echo $_SESSION['user']['email'] ?? 'N/A'; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="data_created_at mb-4">
                        <div class="item memberId d-flex align-items-center justify-content-start">
                            <span><i class="fa-solid fa-calendar-days me-3 headData"></i></span>
                            <div class="info">
                                <p class="mb-0 headData">Member since</p>
                                <p class="value fw-bolder mb-0"><?php echo $_SESSION['user']['created_at'] ?? 'N/A'; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="data_updated_at mb-4">
                        <div class="item memberId d-flex align-items-center justify-content-start">
                            <span><i class="fa-solid fa-calendar-check me-3 headData"></i></span>
                            <div class="info">
                                <p class="mb-0 headData">Last Updated</p>
                                <p class="value fw-bolder mb-0"><?php echo $_SESSION['user']['updated_at'] ?? 'N/A'; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="data_created_at mb-4">
                        <div class="item memberId d-flex align-items-center justify-content-start">
                            <span> <i class="fa-solid fa-language me-3 headData"></i> </span>
                            <div class="info">
                                <p class="mb-0 headData">Language</p>
                                <p class="value fw-bolder mb-0"><?php echo $_SESSION['user']['language'] ?? 'N/A'; ?></p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="buttons d-flex align-items-center justify-content-center mt-4">
                        <button class="btn btn-success me-2 w-100 d-block" onclick="openPopup('profile')"><i class="fa-solid fa-pen-to-square"></i> Edit Profile</button>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="popup" data-name="profile">
        <div class="box py-4 px-4">
            <div class="head mb-4 d-flex align-items-center justify-content-between">
                <h2 class="mb-0">Edit Profile</h2>
                <span class="edit-icon"><i class="fa-solid fa-user-pen"></i></span>
            </div>
            <hr>
            <div class="body">
                <form action="../process/update_profile.php" method="POST" enctype="multipart/form-data">
                    <!-- * input name -->
                    <div class="form-group mb-4 d-flex align-items-center">
                        <label class="me-2 d-block " for="Name">Name:</label>
                        <input type="text" autocomplete="off" required class="form-control" name="name" id="Name" value="<?php echo (($_SESSION['old_values']['name'] ?? '') ?  $_SESSION['old_values']['name'] : $_SESSION['user']['name']); ?>">
                    </div>

                    <!-- error name -->
                    <p class="alert alert-danger <?php echo isset($_SESSION['error_update']['name']) ? '' : 'd-none'; ?>">
                        <?php echo $_SESSION['error_update']['name'] ?? ''; ?>
                    </p>

                    <!-- input email -->
                    <div class="form-group mb-4 d-flex align-items-center">
                        <label class="me-2 d-block" for="Email">Email:</label>
                        <input type="text" autocomplete="off" required class="form-control" name="email" id="Email" value="<?php echo (($_SESSION['old_values']['email'] ?? '') ?  $_SESSION['old_values']['email'] : $_SESSION['user']['email']); ?>">
                    </div>

                    <!-- error email -->
                    <p class="alert alert-danger <?php echo isset($_SESSION['error_update']['email']) ? '' : 'd-none'; ?>">
                        <?php echo $_SESSION['error_update']['email'] ?? ''; ?>
                    </p>

                    <!-- select language -->
                    <div class="form-group mb-4 d-flex align-items-center">
                        <label class="me-2 d-block" for="Language">Language:</label>
                        <select class="form-control" name="language" autocomplete="off" id="Language" required>
                            <option value="" disabled <?php echo empty($_SESSION['old_values']['language']) && empty($_SESSION['user']['language']) ? 'selected' : ''; ?> hidden>
                                Select Language
                            </option>
                            <option value="Arabic" <?php echo ((($_SESSION['old_values']['language'] ?? '') ? $_SESSION['old_values']['language']  : $_SESSION['user']['language']) === 'Arabic') ? 'selected' : ''; ?>>
                                Arabic
                            </option>
                            <option value="English" <?php echo ((($_SESSION['old_values']['language'] ?? '') ? $_SESSION['old_values']['language']  : $_SESSION['user']['language']) === 'English') ? 'selected' : ''; ?>>
                                English
                            </option>
                        </select>
                    </div>

                    <!-- error language -->
                    <p class="alert alert-danger <?php echo isset($_SESSION['error_update']['language']) ? '' : 'd-none'; ?>">
                        <?php echo $_SESSION['error_update']['language'] ?? ''; ?>
                    </p>

                    <!-- file image -->
                    <div class="form-group mb-4 d-flex align-items-center">
                        <label class="me-2 d-block" for="Image">Profile Image:</label>
                        <input class="form-control" name="image" type="file" id="Image" multiple>
                    </div>

                    <!-- error image -->
                    <p class="alert alert-danger <?php echo isset($_SESSION['error_update']['image']) ? '' : 'd-none'; ?>">
                        <?php echo $_SESSION['error_update']['image'] ?? ''; ?>
                    </p>
                    <hr>
                    <div class="form-group d-flex align-items-center justify-content-center">
                        <button class="btn btn-success text-light fw-bolder me-2" type="submit"><i class="fa-solid fa-floppy-disk"></i> Save Change </button>
                        <button class="btn btn-secondary text-light fw-bolder " onclick="closePopup()" type="button"><i class="fa-solid fa-times"></i> Cancel </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../js/sweetAlert.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="js/profile.js"></script>
</body>

</html>