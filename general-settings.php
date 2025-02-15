<?php
include "includes/header.php";


if ($logged_in_user['role_name'] ===  "Admin" || $logged_in_user['role_name'] === "Inventory Manager") {

    $stmt = $conn->prepare('SELECT *  FROM roles');
    $stmt->execute();
    $result = $stmt->get_result();
    $roles = $result->fetch_all(MYSQLI_ASSOC);

    $stmt = $conn->prepare('SELECT *  FROM payment_methods');
    $stmt->execute();
    $result = $stmt->get_result();
    $payment_methods = $result->fetch_all(MYSQLI_ASSOC);
} else {
    header("Location: restriction-page.php");
}
?>

<div class="main-ctn">

    <h2 class="main-title">General Settings</h2>

    <div class="dashboard-navigation-links">




        <div class="dashboard-recent-sale-ctn">

            <div class="general-setting-head-ctn">
                <h3>Roles</h3> <a href="/bottle_water_company_project/role-update-create-form.php?action=create"><button class="btn add-btn"> + New Role</button></a>
            </div>
            <table class="table product-table">
                <tr class="table-head">

                    <th>
                        Role Id
                    </th>
                    <th>
                        Role Name
                    </th>

                    <th>
                        Actions
                    </th>

                </tr>


                <?php foreach ($roles as $role): ?>
                    <tr class="sale-row" data-id="<?php echo $sale['id']; ?>">
                        <td><?php echo  $role['role_id']; ?></td>
                        <td> <?php echo  $role['role_name']; ?></td>


                        <td>
                            <div class="table-btns-ctn">
                                <a href="/bottle_water_company_project/role-update-create-form.php?action=update&id=<?php echo  $role['role_id']; ?>">
                                    <button class="btn table-btns update-btn">Update</button>
                                </a>

                                <a href="/bottle_water_company_project/remove.php?page=role-delete&id=<?php echo  $role['role_id']; ?>">
                                    <button class="btn table-btns remove-btn">Remove</button>
                                </a>


                            </div>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </table>


        </div>


        <div class="dashboard-navigation-links">


        </div>



        <div class="dashboard-recent-sale-ctn">

            <div class="general-setting-head-ctn">
                <h3>Payment Methods</h3><a href="/bottle_water_company_project/methods-update-create-form.php?action=create"><button class="btn add-btn"> + New Method</button></a>
            </div>
            <table class="table product-table">
                <tr class="table-head">

                    <th>
                        Method Id
                    </th>
                    <th>
                        Method Name
                    </th>

                    <th>
                        Actions
                    </th>

                </tr>


                <?php foreach ($payment_methods as $method): ?>
                    <tr class="sale-row" data-id="<?php echo $sale['id']; ?>">
                        <td><?php echo  $method['method_id']; ?></td>
                        <td> <?php echo  $method['method_name']; ?></td>


                        <td>
                            <div class="table-btns-ctn">
                                <a href="/bottle_water_company_project/methods-update-create-form.php?action=update&id=<?php echo $method['method_id']; ?>">
                                    <button class="btn table-btns update-btn">Update</button>
                                </a>
                                <a href="/bottle_water_company_project/remove.php?page=method-delete&id=<?php echo  $method['method_id']; ?>">
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