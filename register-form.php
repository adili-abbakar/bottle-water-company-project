<?php include('config/database.php') ?>


<?php

session_start();

if(isset($_SESSION['username'])){
    header('Location: index.php');
}

$name = $username =  $email = $password1 = $password2 = $phone_numberr = $address = '';
$nameErr = $usernameErr =  $emailErr = $password1Err = $password2Err = $phone_numberrErr = $addressErr =  '';

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);


if (isset($_POST['submit'])) {


    if (!empty($_POST['name'])) {
        $name  = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    } else {
        $nameErr = 'Name is required';
    }


    if (!empty($_POST['username'])) {
        if (count($users) > 0) {
            foreach ($users as $user) {
                if ($user['username'] === $_POST['username']) {
                    $usernameErr = 'Username is already taken, Use diffrent one';
                } else {
                    $username  = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        } else {
            $username =
                filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        }
    } else {
        $usernameErr = 'Username is required';
    }

    if (!empty($_POST['email'])) {
        if (count($users) > 0) {
            foreach ($users as $user) {
                if ($user['email'] === $_POST['email']) {
                    $emailErr = 'Email is already taken, Use diffrent one';
                } else {
                    $email  = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                }
            }
        } else {
            $email =
                filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        }
    } else {
        $emailErr = 'Email is required';
    }

    if (!empty($_POST['address'])) {
        $address  = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
    } else {
        $addressErr = 'Address is required';
    }

    if (!empty($_POST['phone_numberr'])) {
        $phone_numberr  = filter_input(INPUT_POST, 'phone_numberr', FILTER_SANITIZE_SPECIAL_CHARS);
    } else {
        $phone_numberrErr = 'Phone Number is required';
    }

    if (!empty($_POST['password1'])) {
        $password1  = $_POST['password1'];
    } else {
        $password1Err = 'Password is required';
    }

    if (!empty($_POST['password2'])) {
        if ($_POST['password2'] === $_POST['password1']) {
            $password2  = $_POST['password2'];
        } else {
            $password2Err = "Password and password confirmation didn't match";
        }
    } else {
        $password2Err = 'Password is required';
    }






    if (!empty($name) &&  !empty($username) &&  !empty($email) &&  !empty($address) &&  !empty($phone_numberr) &&  !empty($password1) &&  !empty($password2)) {

        $sql = "INSERT INTO users (name, username, email, address, phone_number, password) VALUES ('$name', '$username', '$email', '$address', '$phone_numberr', '$password1')";


        if (mysqli_query($conn, $sql)) {

            $_SESSION['username'] = $username;

            header('Location: index.php');
        } else {
            echo "Error " . mysqli_query($conn, $sql);
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

        <form action="" class="form-ctn" method="POST">
            <div class="form-header">
                Register
            </div>
            <div class="form-body">



                <div class="form-input-ctn">
                    <Label for="username" class="form-input-label">Name </Label>
                    <input type="text" name="name" class="form-input <?php echo $nameErr ? "err-style" : null; ?>" placeholder="Enter Name">
                    <span class="err-message"><?php echo $nameErr ? $nameErr : null; ?></span>

                </div>

                <div class="form-input-ctn">
                    <Label for="username" class="form-input-label">Username </Label>
                    <input type="text" name="username" class="form-input <?php echo $usernameErr ? "err-style" : null; ?> " placeholder="Enter Username">
                    <span class="err-message"><?php echo $usernameErr ? $usernameErr : null; ?></span>


                </div>

                <div class="form-input-ctn">
                    <Label for="email" class="form-input-label">Email </Label>
                    <input type="text" name="email" class="form-input <?php echo $emailErr ? "err-style" : null; ?>" " placeholder=" Enter Email">
                    <span class="err-message"><?php echo $emailErr ? $emailErr : null; ?></span>

                </div>


                <div class="form-input-ctn">
                    <Label for="phone_numberr" class="form-input-label">Phone Number </Label>
                    <input type="number" name="phone_numberr" class="form-input <?php echo $phone_numberrErr ? "err-style" : null; ?>" placeholder=" Enter Phone Number">
                    <span class="err-message"><?php echo $phone_numberrErr ? $phone_numberrErr : null; ?></span>

                </div>

                <div class="form-input-ctn">
                    <Label for="address" class="form-input-label">Address </Label>
                    <input type="text" name="address" class="form-input <?php echo $addressErr ? 'err-style' : null; ?>" placeholder="Enter Address">
                    <span class="err-message"><?php echo $addressErr ? $addressErr : null;  ?></span>

                </div>

                <div class="form-input-ctn">
                    <Label for="password1" class="form-input-label">Password </Label>
                    <input type="password" class="form-input <?php echo $password1Err ? 'err-style' : null; ?>" name="password1" placeholder="Enter Password">
                    <span class="err-message"><?php echo $password1Err ? $password1Err : null; ?></span>

                </div>

                <div class="form-input-ctn">
                    <Label for="password2" class="form-input-label">Confirm Password </Label>
                    <input type="password" class="form-input <?php echo $password2Err ? 'err-style' : null;  ?>" name="password2" placeholder="Confirm Password">
                    <span class="err-message"><?php echo $password2Err ? $password2Err : null; ?></span>

                </div>


                <div class="form-submit-ctn">
                    <input type="submit" name="submit" value="Register" class="form-submit-input">
                </div>
                <div class="form-option-message">Already Have Account <a href="login-form.php">Login</a>
                </div>
            </div>

        </form>

    </div>
</body>

</html>