<?php include('config/database.php') ?>

<?php
session_start();

if (isset($_SESSION['username'])) {
    header('Location: index.php');
}

$email = $password = '';
$emailErr = $passwordErr = '';


if(isset($_POST['submit'])){
        
        

        if (!empty($_POST['email'])) {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        }else{
            $emailErr = 'Email is required'; 
        }


        if(!empty($_POST['password'])){
        $password = $_POST['password'];
        }else{
            $passwordErr = 'Password is required';
        }


        
        if(!empty($password)  && !empty($email)){


        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);

            
                
    
        if ($user['email'] === $email && $user['password'] === $password) {
   
            $_SESSION['username'] = $user['username'];


            echo $_SESSION['username'];
            header('Location: index.php');
       
        }else{
            $incorrect_msg = 'Incorrect email or password';
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

            <?php if(!empty($incorrect_msg)){ 

                echo ' <p class="error-message"> '. $incorrect_msg .' </p> ';
            }
                ?>

                <div class="form-input-ctn">
                    <Label for="email" class="form-input-label">Email </Label>
                    <input type="email" name="email" class="form-input <?php echo $emailErr ? 'err-style' : null ; ?>" placeholder="Enter Email">
                    <span class="err-message"><?php echo $emailErr ? $emailErr: null ; ?></span>
                </div>

                <div class="form-input-ctn">
                    <Label for="password" class="form-input-label">Password </Label>
                    <input type="password" class="form-input <?php echo $passwordErr ? 'err-style' : null ; ?>" name="password" placeholder="Enter Password">
                    <span class="err-message"><?php echo $passwordErr ? $passwordErr : null ; ?></span>
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