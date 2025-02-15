<?php
include('includes/header.php');


$password = $passwordErr = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_to_update = $result->fetch_assoc();
    $stmt->close();


    if (isset($_POST['submit'])) {
        $password_validation = validateInput($_POST['password'], "Password");
        $password = $password_validation['value'];
        $passwordErr = $password_validation['error'];
    }

    if (!empty($password)) {
        if ($user_to_update && password_verify($password, $user_to_update['password'])) {
            header("Location: /bottle_water_company_project/update-password.php?id=$id");
            exit();
        } else {
            $passwordErr = "Incorrect password";
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