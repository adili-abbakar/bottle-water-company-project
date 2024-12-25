<?php include('includes/header.php') ?>

<?php


$new_password = $new_passwordErr = $confirm_password = $confirm_passwordErr = '';


$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (isset($_GET['id'])) {
    $user_id =  $_GET['id'];
    $sql = "SELECT * FROM users WHERE id=$user_id";
    $result = mysqli_query($conn, $sql);
    $user_to_update = mysqli_fetch_assoc($result);

    $id = $user_to_update['id'];
    $current_password = $user_to_update['password'];
}

if (isset($_POST['submit'])) {

    if (!empty($_POST['new_password'])) {
        $new_password =  filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_SPECIAL_CHARS);
    } else {
        $new_passwordErr = 'New Password is required';
    }

    if (!empty($_POST['confirm_password'])) {

        if ($_POST['new_password'] === $_POST['confirm_password']) {
            $confirm_password =  filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_SPECIAL_CHARS);
        } else {
            $confirm_passwordErr = "password and  password confirmation did'nt match'";
        }
    } else {
        $confirm_passwordErr = 'Password confirmation is required';
    }
}


if (!empty($new_password && $confirm_password)) {
    $sql = "UPDATE users SET password = '$confirm_password' WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header('Location: /bottle_water_company_project/profile.php');
    } else {
        echo "Invalid Query: " . mysqli_query($conn, $sql);
    }
}




?>




<div class="main-ctn">
    <div class="main-title-ctn">
        <h2 class="main-title">Update Password</h2>
        <button onclick="window.history.back()" class="btn">Back</button>
    </div>

    <div class="new-sale-form-ctn">

        <form action="" method="POST" class="new-sale-form">


            <div class="new-sale-form-body">
                <div class="new-sale-form-inputs-main-ctn  one-field-form-inputs-main-ctn">


                    <div class="new-sale-form-input-ctn">
                        <label class="new-sale-form-input-label" for="name">New password</label>
                        <input type="password" class="new-sale-form-input <?php echo $new_passwordErr ? 'err-style' : null; ?>" name="new_password" placeholder="Enter new password" value="<?php echo $new_password; ?>">
                        <span class="err-message"><?php echo $new_passwordErr ? $new_passwordErr : null; ?></span>

                    </div>

                    <div class="new-sale-form-input-ctn">
                        <label class="new-sale-form-input-label" for="confirm_password">Confirm password</label>
                        <input type="password" class="new-sale-form-input <?php echo $confirm_passwordErr ? 'err-style' : null; ?>" name="confirm_password" placeholder="Enter password again" value="<?php echo $confirm_password; ?>">
                        <span class="err-message"><?php echo $confirm_passwordErr ? $confirm_passwordErr : null; ?></span>

                    </div>

                </div>

                <div class="new-sale-form-submit-ctn">

                    <a href="">
                        <input type="submit" name="submit" class="new-sale-form-submit btn" value="Next">
                    </a>
                </div>


            </div>

        </form>

    </div>

</div>

<?php include 'includes/footer.php'; ?>