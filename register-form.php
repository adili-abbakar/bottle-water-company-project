<?php
include('config/database.php');
include('includes/functions.php');


session_start();

if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

$name = $username = $email = $password1 = $password2 = $phone = $address = '';
$nameErr = $usernameErr = $emailErr = $password1Err = $password2Err = $phoneErr = $addressErr = '';

$stmt = $conn->prepare("SELECT COUNT(*), username, email as user_count FROM users");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$user_count = $row['user_count'];

$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['submit'])) {
    $name_validation = validateInput($_POST['name'], "Name");
    $name = $name_validation['value'];
    $nameErr = $name_validation['error'];

    $username_validation = validateInput($_POST['username'], "Username", true, $users);
    $username = $username_validation['value'];
    $usernameErr = $username_validation['error'];

    $email_validation = validateInput($_POST['email'], "Email", true, $users);
    $email = $email_validation['value'];
    $emailErr = $email_validation['error'];

    $password_validation = validatePassword($_POST['password1'], "Password");
    $password1 = $password_validation['value'];
    $password1Err = $password_validation['error'];

    $password_validation = validatePassword($_POST['password2'], "Password Confirmation");
    $password2 = $password_validation['value'];
    $password2Err = $password_validation['error'];

    if (!empty($password1) && !empty($password2)) {
        $password_comparison = comparePassword($password1, 'Password', $password2, 'Password confirmation');
        $password = $password_comparison['value'];
        $password2Err = $password_comparison['error'];
    }

    $address_validation = validateInput($_POST['address'], "Address");
    $address = $address_validation['value'];
    $addressErr = $address_validation['error'];

    $phone_validation = validateInput($_POST['phone'], "Phone Number");
    $phone = $phone_validation['value'];
    $phoneErr = $phone_validation['error'];

    if (!empty($name) && !empty($username) && !empty($email) && !empty($address) && !empty($phone) && !empty($password)) {

        // If no users exist, assign role_id for Admin
        $role_id = NULL;
        if ($user_count == 0) {
            // Check if 'Admin' role exists
            $stmt = $conn->prepare("SELECT role_id FROM roles WHERE role_name = 'Admin'");
            $stmt->execute();
            $result = $stmt->get_result();
            $role = $result->fetch_assoc();

            if ($role) {
                $role_id = $role['role_id'];
            } else {
                // Create 'Admin' role
                $stmt = $conn->prepare("INSERT INTO roles (name) VALUES ('Admin')");
                $stmt->execute();
                $role_id = $stmt->insert_id; // Get the newly created role ID
            }
        }

        $stmt = $conn->prepare("INSERT INTO users (name, username, email, address, phone, password, role_id) VALUES (?,?,?,?,?,?,?)");

        if ($stmt) {
            $stmt->bind_param("ssssssi", $name, $username, $email, $address, $phone, $password, $role_id);

            if ($stmt->execute()) {
                $_SESSION['username'] = $username;
                header('Location: index.php');
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error preparing the statement: " . $conn->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/styles/main.css">
    <link rel="stylesheet" href="static/styles/form.css">

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
                    <input type="text" name="name" class="form-input <?php echo $nameErr ? "err-style" : null; ?>" placeholder="Enter Name" value="<?php echo $name; ?>">
                    <span class="err-message"><?php echo $nameErr ? $nameErr : null; ?></span>

                </div>

                <div class="form-input-ctn">
                    <Label for="username" class="form-input-label">Username </Label>
                    <input type="text" name="username" class="form-input <?php echo $usernameErr ? "err-style" : null; ?> " placeholder="Enter Username" value="<?php echo $username; ?>">
                    <span class=" err-message"><?php echo $usernameErr ? $usernameErr : null; ?></span>


                </div>

                <div class="form-input-ctn">
                    <Label for="email" class="form-input-label">Email </Label>
                    <input type="email" name="email" class="form-input <?php echo $emailErr ? "err-style" : null; ?>" placeholder=" Enter Email" value="<?php echo $email; ?>">
                    <span class=" err-message"><?php echo $emailErr ? $emailErr : null; ?></span>

                </div>


                <div class="form-input-ctn">
                    <Label for="phone" class="form-input-label">Phone Number </Label>
                    <input maxlenght="15" type="number" name="phone" class="form-input <?php echo $phoneErr ? 'err-style' : null; ?>" placeholder=" Enter Phone Number" value="<?php echo $phone; ?>">
                    <span class=" err-message"><?php echo $phoneErr ? $phoneErr : null; ?></span>

                </div>

                <div class="form-input-ctn">
                    <Label for="address" class="form-input-label">Address </Label>
                    <input type="text" name="address" class="form-input <?php echo $addressErr ? 'err-style' : null; ?>" placeholder="Enter Address" value="<?php echo $address; ?>">
                    <span class=" err-message"><?php echo $addressErr ? $addressErr : null;  ?></span>

                </div>

                <div class="form-input-ctn">
                    <Label for="password1" class="form-input-label">Password </Label>
                    <input type="password" class="form-input <?php echo $password1Err ? 'err-style' : null; ?>" name="password1" placeholder="Enter Password">
                    <span class=" err-message"><?php echo $password1Err ? $password1Err : null; ?></span>

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