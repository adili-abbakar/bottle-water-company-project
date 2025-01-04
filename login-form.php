<?php 
include('config/database.php'); 
include('includes/functions.php'); 


session_start();

if (isset($_SESSION['username'])) {
    header('Location: index.php');
}

$email = $password = '';
$emailErr = $passwordErr = '';


if (isset($_POST['submit'])) {
    $email_validation = validateInput($_POST['email'], "Email"); 
    $email = $email_validation['value'];
    $emailErr = $email_validation['error'];

    $password_validation = validateInput($_POST['password'], "Password"); 
    $password = $password_validation['value'];
    $passwordErr = $password_validation['error'];


    if (!empty($password)  && !empty($email)) {

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if($user && password_verify($password, $user['password'])){
            session_regenerate_id(true);
            $_SESSION['username'] = $user['username'];
            header('Location: index.php');
            exit(); 
        }else{
            $incorrect_msg = "Incorrect email or password";
        }


    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/form.css">
    <link rel="stylesheet" href="styles/general.css">

    <title>BWC Login.</title>
</head>

<body>
    <div class="form-main-ctn">

        <form action="" method="POST" class="form-ctn">
            <div class="form-header">
                Login
            </div>
            <div class="form-body">

                <?php if (!empty($incorrect_msg)) {

                    echo ' <p class="error-message"> ' . $incorrect_msg . ' </p> ';
                }
                ?>

                <div class="form-input-ctn">
                    <Label for="email" class="form-input-label">Email </Label>
                    <input type="email" name="email" class="form-input <?php echo $emailErr ? 'err-style' : null; ?>" placeholder="Enter Email" <?php echo " value= '$email'  "; ?>>
                    <span class="err-message"><?php echo $emailErr ? $emailErr : null; ?></span>
                </div>

                <div class="form-input-ctn">
                    <Label for="password" class="form-input-label">Password </Label>
                    <input type="password" class="form-input <?php echo $passwordErr ? 'err-style' : null; ?>" name="password" placeholder="Enter Password">
                    <span class="err-message"><?php echo $passwordErr ? $passwordErr : null; ?></span>
                </div>

                <div class="form-submit-ctn">
                    <input type="submit" name="submit" value="Login" class="btn">
                </div>
                <div class="form-option-message">Don't Have Account <a href="register-form.php">Register</a>
                </div>
            </div>

        </form>

    </div>
</body>

</html>