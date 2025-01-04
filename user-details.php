<?php
include('includes/header.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];


    $stmt = $conn->prepare("SELECT * FROM users left join roles on users.role_id = roles.customer_id where id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}
?>


<div class="main-ctn">

    <h2>User details</h2>

    <div class="profile-main">
        <div class="user-info-ctn">
            <div class="user-info">Name: <?php echo $user['name']; ?></div>
            <div class="user-info">username: <?php echo $user['username']; ?></div>
            <div class="user-info">Email: <?php echo $user['email']; ?></div>
            <div class="user-info">Address: <?php echo $user['address']; ?></div>
            <div class="user-info">Phone Number: <?php echo $user['phone']; ?></div>
            <div class="user-info">Role: <?php echo !empty($role_id) ? $user['role_name'] : 'None'; ?></div>
            
        

        </div>



    </div>

</div>

<?php include('includes/footer.php') ?>