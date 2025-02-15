<?php
include('includes/header.php');

$action = $_GET['action'];
$role_name = $role_nameErr = '';

if ($action === "update") {
    $id = $_GET['id'];



    $stmt = $conn->prepare("SELECT * FROM roles WHERE role_id=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $role = $result->fetch_assoc();
    $stmt->close();
    $role_id = $role['role_id'];
    $role_name = $role['role_name'];


    if (isset($_POST['submit'])) {
        $role_name_valdation = validateInput(($_POST['role_name']), "Role name");
        $role_name = $role_name_valdation['value'];
        $role_nameErr = $role_name_valdation['error'];

        $role_id_valdation = validateInput(($_POST['role_id']), "Role Id");
        $role_id = $role_id_valdation['value'];
        $role_idErr = $role_id_valdation['error'];

        if (empty($role_nameErr)) {
            $stmt = $conn->prepare("UPDATE roles set role_name=? where role_id =?");
            if ($stmt) {
                $stmt->bind_param("si", $role_name, $role_id);
                if ($stmt->execute()) {
                    header("Location: general-settings.php");
                } else {
                    echo "Error " . $stmt->error;
                }
            } else {
                echo "Error Preparing Statement " . $conn->error;
            }
        }
    }
} else {


    if (isset($_POST['submit'])) {
        $role_name_valdation = validateInput(($_POST['role_name']), "Role_name");
        $role_name = $role_name_valdation['value'];
        $role_nameErr = $role_name_valdation['error'];

        if (empty($role_nameErr)) {
            $stmt = $conn->prepare("INSERT INTO roles (role_name) VALUE (?)");
            if ($stmt) {
                $stmt->bind_param("s", $role_name);
                if ($stmt->execute()) {
                    header("Location: general-settings.php");
                } else {
                    echo "Error " . $stmt->error;
                }
            } else {
                echo "Error Preparing Statement " . $conn->error;
            }
        }
    }
}


?>




<div class="main-ctn">
    <div class="main-title-ctn">
        <h2 class="main-title"><?php echo $action === 'update' ? "Update" : "Create "; ?> Role</h2>
        <button onclick="window.history.back()" class="btn">Back</button>
    </div>

    <div class="new-sale-form-ctn">

        <form action="" method="POST" class="new-sale-form">


            <div class="new-sale-form-body">
                <div class="new-sale-form-inputs-main-ctn  one-field-form-inputs-main-ctn">

                    <?php if ($_GET['action'] === 'update'): ?>
                        <input type="hidden" value="<?php echo $role_id ?>" name="role_id">
                    <?php endif; ?>


                    <div class="new-sale-form-input-ctn">
                        <label class="new-sale-form-input-label" for="name">Role name</label>
                        <input type="text" class="new-sale-form-input <?php echo $role_nameErr ? 'err-style' : null; ?>" name="role_name" value="<?php echo $role_name ? $role_name : ''; ?>" placeholder="Enter role name">
                        <span class="err-message"><?php echo $role_nameErr ? $role_nameErr : null; ?></span>

                    </div>

                </div>

                <div class="new-sale-form-submit-ctn">
                    <?php if ($_GET['action'] === 'update'): ?>
                        <a href="">
                            <input type="submit" name="submit" class="new-sale-form-submit btn" value="Update">
                        </a>

                    <?php elseif ($_GET['action'] === 'create'): ?>
                        <a href="">
                            <input type="submit" name="submit" class="new-sale-form-submit btn" value="Create">
                        </a>
                    <?php endif ?>

                </div>


            </div>

        </form>

    </div>

</div>

<?php include 'includes/footer.php'; ?>