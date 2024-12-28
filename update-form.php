<?php include('includes/header.php') ?>

<?php


$id = $name = $username =  $email = $phone = $address = '';
$nameErr = $usernameErr =  $emailErr  = $phoneErr = $addressErr =  '';

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (isset($_GET['id'])) {
    $user_id =  $_GET['id'];
    $sql = "SELECT * FROM users WHERE id=$user_id";
    $result = mysqli_query($conn, $sql);
    $user_to_update = mysqli_fetch_assoc($result);

    $id = $user_to_update['id'];
    $name = $user_to_update['name'];
    $username = $user_to_update['username'];
    $email = $user_to_update['email'];
    $phone = $user_to_update['phone'];
    $address = $user_to_update['address'];
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

    if(!empty($_POST['phone'])){
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);

        $phone_number = $_POST['phone'];
        $number_lenght =  strlen($phone_number);

        if($number_lenght > 12){
            $phoneErr = "Phone number must not exceed 12 numbers";
        }else{
            $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
        }


    }else{
        $phoneErr = 'Phone number is required';
        $phone = '';
    }


    if (empty($nameErr) && empty($usernameErr) && empty($emailErr) && empty($addressErr) && empty($phoneErr)) {
        

        $sql = "UPDATE users SET name = '$name', email='$email', username='$username', address='$address', phone='$phone' WHERE id='$id' ";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['username'] = $username;
            header('Location: /bwc/profile.php');
        } else {
            echo "Invalid Query: " . mysqli_query($conn, $sql);
        }
    }
}


?>




<div class="main-ctn">
    <div class="main-title-ctn">
        <h2 class="main-title">Update User</h2>
        <button onclick="window.history.back()" class="btn">Back</button>
    </div>

    <div class="new-sale-form-ctn">

        <form action="" method="POST" class="new-sale-form">


            <div class="new-sale-form-body">
                <div class="new-sale-form-inputs-main-ctn">

                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

    

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