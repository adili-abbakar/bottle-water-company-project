<?php
include('includes/header.php');

$id = $name = $username =  $email = $phone = $address = $password1 = $password2 = $role_id = '';
$nameErr = $usernameErr =  $emailErr  = $phoneErr = $addressErr = $password1Err = $password2Err = $role_idErr = '';



$stmt = $conn->prepare("SELECT * FROM roles");
$stmt->execute();
$result = $stmt->get_result();
$roles  = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();




if (isset($_GET['action']) && isset($_GET['page'])) {

    $action = $_GET['action'];
    $page = $_GET['page'];


    $stmt = $conn->prepare("SELECT * FROM users join roles on users.role_id = roles.customer_id");
    $stmt->execute();
    $result = $stmt->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    if ($action === "update") {



        if (isset($_GET['id'])) {
            $user_id =  $_GET['id'];
            $stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user_to_update = $result->fetch_assoc();
            $stmt->close();


            $id = $user_to_update['id'];
            $name = $user_to_update['name'];
            $username = $user_to_update['username'];
            $email = $user_to_update['email'];
            $phone = $user_to_update['phone'];
            $address = $user_to_update['address'];
            $role_id = $user_to_update['role_id'];
        }

        if (isset($_POST['submit'])) {



            if (!empty($_POST['name'])) {
                $name  = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
            } else {
                $nameErr = 'Name is required';
                $name = '';
            }


            if (!empty($_POST['username'])) {

                if ($_POST['username'] !== $username) {

                    if (count($users) > 0) {
                        foreach ($users as $user) {
                            if ($user['username'] === $_POST['username']) {
                                $usernameErr = 'Username is already taken, Use diffrent one';
                            } else {
                                $username  = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
                            }
                        }
                    } else {
                        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                } else {
                    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
                }
            } else {
                $usernameErr = 'Username is required';
                $username = '';
            }

            if (!empty($_POST['email'])) {
                if ($_POST['email'] !== $email) {
                    if (count($users) > 0) {
                        foreach ($users as $user) {
                            if ($user['email'] === $_POST['email']) {
                                $emailErr = 'Email is already taken, Use diffrent one';
                            } else {
                                $email  = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                            }
                        }
                    } else {
                        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                    }
                } else {
                    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                }
            } else {
                $emailErr = 'Email is required';
                $email = '';
            }

            if (!empty($_POST['address'])) {
                $address  = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
            } else {
                $addressErr = 'Address is required';
                $address = '';
            }

            if (!empty($_POST['phone'])) {
                $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);

                $phone_number = $_POST['phone'];
                $number_lenght =  strlen($phone_number);

                if ($number_lenght > 12) {
                    $phoneErr = "Phone number must not exceed 12 numbers";
                } else {
                    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
                }
            } else {
                $phoneErr = 'Phone number is required';
                $phone = '';
            }

            if (!empty($_POST['role_id'])) {
                $role_id = filter_input(INPUT_POST, 'role_id', FILTER_SANITIZE_NUMBER_INT);
            } else {
                $role_idErr = "Role is required";
                $role_id = '';
            }



            if (empty($nameErr) && empty($usernameErr) && empty($emailErr) && empty($addressErr) && empty($phoneErr) && empty($role_idErr)) {


                $stmt = $conn->prepare("UPDATE users SET name = ?, email=?, username=?, address=?, phone=?, role_id=? WHERE id=? ");

                if ($stmt) {
                    $stmt->bind_param("sssssii", $name, $email, $username, $address, $phone, $role_id, $id);

                    if ($stmt->execute()) {
                        if ($page === 'users-management') {
                            header('Location: users-management.php');
                        } else {
                            header('Location: profile.php');
                        }
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                } else {
                    echo "Error Prepareing the statement" . $conn->error;
                }
            }
        }
    } else {


        if (isset($_POST['submit'])) {



            if (!empty($_POST['name'])) {
                $name  = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
            } else {
                $nameErr = 'Name is required';
                $name = '';
            }


            if (!empty($_POST['username'])) {

                if ($_POST['username'] !== $username) {

                    if (count($users) > 0) {
                        foreach ($users as $user) {
                            if ($user['username'] === $_POST['username']) {
                                $usernameErr = 'Username is already taken, Use diffrent one';
                            } else {
                                $username  = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
                            }
                        }
                    } else {
                        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                } else {
                    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
                }
            } else {
                $usernameErr = 'Username is required';
                $username = '';
            }

            if (!empty($_POST['email'])) {
                if ($_POST['email'] !== $email) {
                    if (count($users) > 0) {
                        foreach ($users as $user) {
                            if ($user['email'] === $_POST['email']) {
                                $emailErr = 'Email is already taken, Use diffrent one';
                            } else {
                                $email  = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                            }
                        }
                    } else {
                        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                    }
                } else {
                    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                }
            } else {
                $emailErr = 'Email is required';
                $email = '';
            }

            if (!empty($_POST['address'])) {
                $address  = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
            } else {
                $addressErr = 'Address is required';
                $address = '';
            }

            if (!empty($_POST['phone'])) {
                $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);

                $phone_number = $_POST['phone'];
                $number_lenght =  strlen($phone_number);

                if ($number_lenght > 12) {
                    $phoneErr = "Phone number must not exceed 12 numbers";
                } else {
                    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
                }
            } else {
                $phoneErr = 'Phone number is required';
                $phone = '';
            }

            if (!empty($_POST['role_id'])) {
                $role_id = filter_input(INPUT_POST, 'role_id', FILTER_SANITIZE_NUMBER_INT);
            } else {
                $role_idErr = "Role is required";
            }


            if (!empty($_POST['password1'])) {
                if (strlen($_POST['password1']) >= 8) {
                    $password1 = $_POST['password1'];
                } else {
                    $password1Err = "Password must be at least 8 characters";
                }
            } else {
                $password1Err = "Password is required";
            }

            if (!empty($_POST['password2'])) {
                if (strlen($_POST['password2']) >= 8) {
                    $password2 = $_POST['password2'];
                    if ($password1 === $password2) {
                        $hashed_password = password_hash($password1, PASSWORD_DEFAULT);
                    } else {
                        $password2Err = "Password and Password confirmation did not match";
                    }
                } else {
                    $password2Err = "Password  must be at least 8 characters";
                }
            } else {
                $password2Err = "Password confirmation is required";
            }




            if (empty($nameErr) && empty($usernameErr) && empty($emailErr) && empty($addressErr) && empty($phoneErr) && !empty($hashed_password)) {

                $stmt = $conn->prepare("INSERT INTO users (name, username, email, phone, address, password) VALUES (?,?,?,?,?,?)");

                if ($stmt) {
                    $stmt->bind_param('ssssss', $name, $username,  $email, $phone, $address, $hashed_password);

                    if ($stmt->execute()) {
                        if ($page === 'users-management') {
                            header('Location: users-management.php');
                        } else {
                            header('Location: profile.php');
                        }
                    } else {
                        echo "Error " . $stmt->error;
                    }
                } else {
                    echo "Error Preparing statement" . $conn->error;
                }
            }
        }
    }
}


?>




<div class="main-ctn">
    <div class="main-title-ctn">
        <h2 class="main-title"><?php echo $action === 'update' ? "Update" : "New"; ?> User</h2>
        <button onclick="window.history.back()" class="btn">Back</button>
    </div>

    <div class="new-sale-form-ctn">

        <form action="" method="POST" class="new-sale-form">


            <div class="new-sale-form-body">
                <div class="new-sale-form-inputs-main-ctn">

                    <?php if ($action === "update"):  ?>
                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                    <?php endif;  ?>



                    <div class="new-sale-form-input-ctn">
                        <label class="new-sale-form-input-label" for="name">Name</label>
                        <input type="text" class="new-sale-form-input <?php echo $nameErr ? 'err-style' : null; ?>" name="name" value="<?php echo $name; ?>" placeholder="Enter name">
                        <span class="err-message"><?php echo $nameErr ? $nameErr : null; ?></span>

                    </div>

                    <div class="new-sale-form-input-ctn">
                        <label class="new-sale-form-input-label" for="username">Username</label>
                        <input type="text" class="new-sale-form-inpu <?php echo $usernameErr ? 'err-style' : null; ?>" name="username" value="<?php echo $username; ?>" placeholder="Enter username">
                        <span class="err-message"><?php echo $usernameErr ? $usernameErr : null; ?></span>

                    </div>

                    <div class="new-sale-form-input-ctn">
                        <label class="new-sale-form-input-label" for="email">Email</label>
                        <input type="email" class="new-sale-form-input <?php echo $emailErr ? 'err-style' : null; ?>" name="email" value="<?php echo $email; ?>" placeholder="Enter Email">
                        <span class="err-message"><?php echo $emailErr ? $emailErr : null; ?></span>

                    </div>

                    <div class="new-sale-form-input-ctn">
                        <label class="new-sale-form-input-label" for="phone">Customer Phone Number</label>
                        <input type="number" class="new-sale-form-input  <?php echo $phoneErr ? 'err-style' : null; ?>" name="phone" value="<?php echo $phone; ?>" placeholder="Enter Phone Number">
                        <span class="err-message"><?php echo $phoneErr ? $phoneErr : null; ?></span>

                    </div>


                    <div class="new-sale-form-input-ctn">
                        <label class="new-sale-form-input-label" for="address">Customer Address</label>
                        <input type="text" class="new-sale-form-input  <?php echo $addressErr ? 'err-style' : null; ?>" name="address" value="<?php echo $address ?>" placeholder="Enter Address">
                        <span class="err-message"> <?php echo $addressErr ? $addressErr : null; ?></span>

                    </div>

                    <?php if ($page !== "profile") : ?>


                        <div class="new-sale-form-input-ctn">
                            <label class="new-sale-form-input-label" for="role">Role</label>
                            <select class="new-sale-form-input <?php echo $role_idErr ? 'err-style' : null; ?>" name="role_id">
                                <option value="">--Select user role--</option>

                                <?php foreach ($roles as $role): ?>

                                    <option value="<?php echo $role['customer_id']; ?>" <?php echo ($role_id == $role['customer_id']) ? 'selected' : ''; ?>>
                                        <?php echo $role['role_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="err-message"><?php echo $role_idErr ? $role_idErr : null; ?></span>
                        </div>


                    <?php endif;  ?>

                    <?php if ($action === "create"):  ?>
                        <div class="new-sale-form-input-ctn">
                            <Label for="password1" class="new-sale-form-input-label">Password </Label>
                            <input type="password" class="new-sale-form-input <?php echo $password1Err ? 'err-style' : null; ?>" name="password1" placeholder="Enter Password">
                            <span class=" err-message"><?php echo $password1Err ? $password1Err : null; ?></span>

                        </div>

                        <div class="new-sale-form-input-ctn">
                            <Label for="password2" class="new-sale-form-input-label">Confirm Password </Label>
                            <input type="password" class="new-sale-form-input <?php echo $password2Err ? 'err-style' : null;  ?>" name="password2" placeholder="Confirm Password">
                            <span class="err-message"><?php echo $password2Err ? $password2Err : null; ?></span>

                        </div>
                    <?php endif;  ?>


                </div>

                <div class="new-sale-form-submit-ctn">

                    <?php if ($action === "create"): ?>
                        <input type="submit" name="submit" class="new-sale-form-submit btn" value="Create">
                    <?php else: ?>
                        <input type="submit" name="submit" class="new-sale-form-submit btn" value="Update">
                    <?php endif ?>
                </div>


            </div>

        </form>

    </div>

</div>

<?php include 'includes/footer.php'; ?>