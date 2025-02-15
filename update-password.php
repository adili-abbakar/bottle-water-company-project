<?php include('includes/header.php') ?>

<?php


$new_password = $new_passwordErr = $confirm_password = $confirm_passwordErr = '';

if(isset($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = '';
}

$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);

if (isset($_GET['id'])) {
    $user_id =  $_GET['id'];
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_to_update = $result->fetch_assoc();

    $id = $user_to_update['user_id'];
    $current_password = $user_to_update['password'];
}

if (isset($_POST['submit'])) {

    $new_password_validation = validatePassword($_POST['new_password'], "Password");
    $new_password = $new_password_validation['value'];
    $new_passwordErr = $new_password_validation['error'];


    $confirm_password_validation = validatePassword($_POST['confirm_password'], "Password Confirmation");
    $confirm_password = $confirm_password_validation['value'];
    $confirm_passwordErr = $confirm_password_validation['error'];

    if (!empty($new_password)  && !empty($confirm_password)) {
        $password_coparison = comparePassword($new_password, 'Password', $confirm_password, 'Password confirmation');
        $password = $password_coparison['value'];
        $confirm_passwordErr = $password_coparison['error'];
    }



    if (!empty($password)) {
        $stmt =  $conn->prepare("UPDATE users SET password = ? WHERE user_id=?");

        if ($stmt) {
            $stmt->bind_param('si', $password, $id);
            if ($stmt->execute()) {
                if($page === "users-management"){
                header('Location: /bottle_water_company_project/users-management.php');

                }else{
                header('Location: /bottle_water_company_project/profile.php');
                }
            } else {
                echo "Error" . $stmt->error;
            }
        } else {
            echo "Error preparing statement" . $conn->error;
        }
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
                        <input type="submit" name="submit" class="new-sale-form-submit btn" value="Update">
                    </a>
                </div>


            </div>

        </form>

    </div>

</div>

<?php include 'includes/footer.php'; ?>