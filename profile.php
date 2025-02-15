<?php include('includes/header.php') ?>


<div class="main-ctn">

    <h2>User Profile</h2>

    <div class="profile-main">
        <div class="user-info-ctn">
            <div class="user-info">Name: <?php echo $logged_in_user['name']; ?></div>
            <div class="user-info">username: <?php echo $logged_in_user['username']; ?></div>
            <div class="user-info">Email: <?php echo $logged_in_user['email']; ?></div>
            <div class="user-info">Address: <?php echo $logged_in_user['address']; ?></div>
            <div class="user-info">Phone Number: <?php echo $logged_in_user['phone']; ?></div>
            <div class="user-info">Role: <?php echo !empty($role_id) ? $logged_in_user['role_name'] : 'None'; ?></div>

        </div>



        <div class="btn-ctn profile-btns-ctn">
            <a href="/bottle_water_company_project/user-create-update-form.php?id=<?php echo $logged_in_user['user_id']; ?> &page=profile&action=update"><button class="btn">Update Profile</button></a>
            <a href="/bottle_water_company_project/update-password-validation.php?id=<?php echo $logged_in_user['user_id']; ?>"> <button class="btn">Change Password</button></a>


        </div>
    </div>

</div>

<?php include('includes/footer.php') ?>