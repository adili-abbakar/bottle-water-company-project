<?php
include "includes/header.php";

$search_query = isset($_GET['search_query']) ? '%' . $_GET['search_query'] . '%' : '';

if ($logged_in_user['role_name'] === "Admin") {


    if ($search_query) {
        $stmt = $conn->prepare('SELECT *  FROM users left JOIN roles on users.role_id = roles.user_id where id like ? or name like ? or username like ? or  email like ? or address like ? or phone like ? or role_name like ?');
        $stmt->bind_param("sssssss", $search_query, $search_query, $search_query, $search_query, $search_query, $search_query, $search_query,);
    } else {
        $stmt = $conn->prepare('SELECT *  FROM users left JOIN roles on users.role_id = roles.user_id');
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);
} else {
    header("Location: restriction-page.php");
}
?>

<div class="main-ctn">

    <h2 class="main-title">Users Management</h2>


    <div class="dashboard-navigation-links">
        <a href="/bottle_water_company_project/user-create-update-form.php ?action=create&page=users-management"><button class="btn add-btn"> + New User</button></a>

    </div>
    <h3>Products</h3>
    <div class="search-bar-ctn">
        <form method="get">
            <input
                name="search_query"
                class="search-bar"
                type="search"
                placeholder="Search user.." />

            <input class="search-bar-submit-btn" type="submit" name="submit" value="Search">
        </form>
    </div>
    <?php if ($search_query): ?>
        <div class="searcb-bar-cancel-btn-ctn">
            <div class="search-result-title">Search Result</div><button onclick="window.history.back()" class="searcb-bar-cancel-btn">X</button>
        </div>
    <?php endif; ?>

    <div class="dashboard-recent-sale-ctn">


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