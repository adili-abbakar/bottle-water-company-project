<?php
include('includes/header.php');

$action = $_GET['action'];
$method_name = $method_nameErr = '';

if ($action === "update") {
    $id = $_GET['id'];



    $stmt = $conn->prepare("SELECT * FROM payment_methods WHERE method_id=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $method = $result->fetch_assoc();
    $stmt->close();
    $method_id = $method['method_id'];
    $method_name = $method['method_name'];


    if (isset($_POST['submit'])) {
        $method_name_valdation = validateInput(($_POST['method_name']), "Method name");
        $method_name = $method_name_valdation['value'];
        $method_nameErr = $method_name_valdation['error'];

        $method_id_valdation = validateInput(($_POST['method_id']), "Method Id");
        $method_id = $method_id_valdation['value'];
        $method_idErr = $method_id_valdation['error'];

        if (empty($method_nameErr)) {
            $stmt = $conn->prepare("UPDATE payment_methods set method_name=? where method_id =?");
            if ($stmt) {
                $stmt->bind_param("si", $method_name, $method_id);
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
        $method_name_valdation = validateInput(($_POST['method_name']), "method_name");
        $method_name = $method_name_valdation['value'];
        $method_nameErr = $method_name_valdation['error'];

        if (empty($method_nameErr)) {
            $stmt = $conn->prepare("INSERT INTO payment_methods (method_name) VALUE (?)");
            if ($stmt) {
                $stmt->bind_param("s", $method_name);
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
        <h2 class="main-title"> <?php echo $action === 'update' ?"Update":"Create " ;?> Method</h2>
        <button onclick="window.history.back()" class="btn">Back</button>
    </div>

    <div class="new-sale-form-ctn">

        <form action="" method="POST" class="new-sale-form">


            <div class="new-sale-form-body">
                <div class="new-sale-form-inputs-main-ctn  one-field-form-inputs-main-ctn">

                    <?php if ($_GET['action'] === 'update'): ?>
                        <input type="hidden" value="<?php echo $method_id ?>" name="method_id">
                    <?php endif; ?>


                    <div class="new-sale-form-input-ctn">
                        <label class="new-sale-form-input-label" for="name">Method name</label>
                        <input type="text" class="new-sale-form-input <?php echo $method_nameErr ? 'err-style' : null; ?>" name="method_name" value="<?php echo $method_name ? $method_name : ''; ?>" placeholder="Enter method name">
                        <span class="err-message"><?php echo $method_nameErr ? $method_nameErr : null; ?></span>

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