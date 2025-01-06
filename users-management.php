<?php
 include "includes/header.php"; 

 if($logged_in_user['role_name'] === "Admin"){
    


$stmt = $conn->prepare('SELECT *  FROM users left JOIN roles on users.role_id = roles.customer_id');
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);

}else{
    header("Location: restriction-page.php");
}
?>

<div class="main-ctn">

    <h2 class="main-title">Users Management</h2>

    <div class="dashboard-navigation-links">
        <a href="/bottle_water_company_project/user-create-update-form.php ?action=create&page=users-management"><button class="btn add-btn"> + New User</button></a>

    </div>



    <div class="dashboard-recent-sale-ctn">

        <h3>Products</h3>
        <table class="table product-table">
            <tr class="table-head">

                <th>
                    Name
                </th>
                <th>
                    Email
                </th>
                <th>
                    Role
                </th>
                <th>
                    Actions
                </th>

            </tr>


            <?php foreach ($users as $user): ?>
                <tr class="sale-row" data-id="<?php echo $sale['id']; ?>">
                    <td><?php echo  $user['name']; ?></td>
                    <td> <?php echo  $user['email']; ?></td>
                    <td> <?php echo  $user['role_name']; ?></td>

                    <td>
                        <div class="table-btns-ctn">
                            <a href="/bottle_water_company_project/user-create-update-form.php?id=<?php echo $user['id']; ?>&action=update&page=users-management"><button class="btn table-btns update-btn">Update</button></a>
                            <a href="/bottle_water_company_project/update-password.php?id=<?php echo $user['id']; ?>&action=update&page=users-management"><button class="btn table-btns update-btn">Update Password</button></a>

                            <a href="/bottle_water_company_project/user-details.php?id=<?php echo $user['id']; ?>&page=users-management">
                                <button class="btn table-btns details-btn">More details</button>
                            </a>

                            <a href="remove.php?id=<?php echo $user['id']; ?>&page=users-management">
                                <button class="btn table-btns remove-btn">Remove</button>
                            </a>


                        </div>
                    </td>
                </tr>

            <?php endforeach; ?>

        </table>


    </div>



</div>


<?php include 'includes/footer.php'; ?>