<?php include('includes/header.php') ?>

<?php


$password = $passwordErr = '';

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

    if (!empty($_POST['password'])) {
        $password =  filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($password === $current_password) {
            header("Location: /bottle_water_company_project/update-password.php?id= $id");
        } else {
            $passwordErr = 'Incorrect Password';
        }
    } else {
        $passwordErr = 'Current Password is required';
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
                        <label class="new-sale-form-input-label" for="name">Current password</label>
                        <input type="password" class="new-sale-form-input <?php echo $passwordErr ? 'err-style' : null; ?>" name="password" placeholder="Enter current password">
                        <span class="err-message"><?php echo $passwordErr ? $passwordErr : null; ?></span>

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