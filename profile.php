<?php include('includes/header.php') ?>


<?php
    $username = $_SESSION['username '];


    
    
    $sql = "SELECT * FROM users WHERE username = '$username' ";
    $result = mysqli_query($conn, $sql);

    $user = mysqli_fetch_assoc($result);



?>


<div class="main-ctn">

<h2>User Profile</h2>
    <div class="user-info-ctn">
        <div class="user-info">Name: <?php echo $user['name']; ?></div>
        <div class="user-info">username: <?php echo $user['username']; ?></div>
        <div class="user-info">Email: <?php echo $user['email']; ?></div>
        <div class="user-info">Address: <?php echo $user['address']; ?></div>
        <div class="user-info">Phone Number: <?php echo $user['phone_number']; ?></div>

    </div>

    
    
<div class="btn-ctn">
    <button class="btn">Update Profile</button>
    <button class="btn">Change Password</button>



</div>

</div>

<?php include('includes/footer.php') ?>
