<?php

include('includes/header.php');

if ($logged_in_user['role_name']  === "Admin" || $_GET['page'] === 'profile') {

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


        $stmt = $conn->prepare("SELECT * FROM users join roles on users.role_id = roles.role_id");
        $stmt->execute();
        $result = $stmt->get_result();
        $users = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();



        if (isset($_GET['id'])) {
            $user_id =  $_GET['id'];
            $stmt = $conn->prepare("SELECT * FROM users WHERE user_id=?");
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user_to_update = $result->fetch_assoc();
            $stmt->close();

            $stmt = $conn->prepare("SELECT * FROM users");
            $stmt->execute();
            $result = $stmt->get_result();
            $users = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();



            $id = $user_to_update['user_id'];
            $name = $user_to_update['name'];
            $username = $user_to_update['username'];
            $email = $user_to_update['email'];
            $phone = $user_to_update['phone'];
            $address = $user_to_update['address'];
            $role_id = $user_to_update['role_id'];
        }
        if (isset($_POST['submit'])) {
            $name_valdation = validateInput(($_POST['name']), "Name");
            $name = $name_valdation['value'];
            $nameErr = $name_valdation['error'];



            $address_valdation = validateInput(($_POST['address']), "Address");
            $address = $address_valdation['value'];
            $addressErr = $address_valdation['error'];

            $phone_valdation = validateInput(($_POST['phone']), "Phone");
            $phone = $phone_valdation['value'];
            $phoneErr = $phone_valdation['error'];


            if ($_GET['page'] !== 'profile') {

                $role_id_valdation = validateInput(($_POST['role_id']), "Role");
                $role_id = $role_id_valdation['value'];
                $role_idErr = $role_id_valdation['error'];


                $password1_valdation = validatePassword(($_POST['password1']), "Password");
                $password1 = $password1_valdation['value'];
                $password1Err = $password1_valdation['error'];

                $password2_valdation = validatePassword(($_POST['password2']), "Password Confirmatino");
                $password2 = $password2_valdation['value'];
                $password2Err = $password2_valdation['error'];
            }
            if ($action === "update") {

                $username_valdation = validateInput(($_POST['username']), "Username");
                $username = $username_valdation['value'];
                $usernameErr = $username_valdation['error'];

                $email_valdation = validateInput(($_POST['email']), "Email",);
                $email = $email_valdation['value'];
                $emailErr = $email_valdation['error'];

                if (empty($nameErr) && empty($usernameErr) && empty($emailErr) && empty($addressErr) && empty($phoneErr) && empty($role_idErr)) {


                    $stmt = $conn->prepare("UPDATE users SET name = ?, email=?, username=?, address=?, phone=?, role_id=? WHERE user_id=? ");

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
            } else {
                $username_valdation = validateInput(($_POST['username']), "Username", true, $users);
                $username = $username_valdation['value'];
                $usernameErr = $username_valdation['error'];

                $email_valdation = validateInput(($_POST['email']), "Email", true, $users);
                $email = $email_valdation['value'];
                $emailErr = $email_valdation['error'];

                $password1_valdation = validatePassword(($_POST['password1']), "Password");
                $password1 = $password1_valdation['value'];
                $password1Err = $password1_valdation['error'];

                $password2_valdation = validatePassword(($_POST['password2']), "Password Confirmatino");
                $password2 = $password2_valdation['value'];
                $password2Err = $password2_valdation['error'];

                if (!empty($password1) && !empty($password2)) {
                    $hashed_password_validation =  comparePassword($password1, 'Password', $password2, 'Password Confirmaion');
                    $hashed_password = $hashed_password_validation['value'];
                    $password2Err = $hashed_password_validation['error'];
                }

                if (empty($nameErr) && empty($usernameErr) && empty($emailErr) && empty($addressErr) && empty($phoneErr) && empty($role_idErr) && !empty($hashed_password)) {

                    $stmt = $conn->prepare("INSERT INTO users (name, username, email, phone, address, role_id, password) VALUES (?,?,?,?,?,?,?)");

                    if ($stmt) {
                        $stmt->bind_param('sssssis', $name, $username,  $email, $phone, $address, $role_id, $hashed_password);
                      
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
    } else {
        header('Location: index.php');
    }
} else {
    header('Location: restriction-page.php');
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

                                    <option value="<?php echo $role['role_id']; ?>" <?php echo ($role_id == $role['role_id']) ? 'selected' : ''; ?>>
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
                    <?php endif; ?>
                </div>


            </div>

        </form>

    </div>

</div>


<?php include "includes/footer.php"; ?>