<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/form.css">
    <link rel="stylesheet" href="styles/general.css">

    <title>BWC Login.</title>
</head>

<body>
    <div class="form-main-ctn">

        <form action="" class="form-ctn">
            <div class="form-header">
                Register
            </div>
            <div class="form-body">


                <div class="error-message">
                    Name is required
                </div>

                <div class="form-input-ctn">
                    <Label for="username" class="form-input-label">Name </Label>
                    <input type="text" name="name" class="form-input" placeholder="Enter Name">
                </div>

                <div class="form-input-ctn">
                    <Label for="username" class="form-input-label">Username </Label>
                    <input type="text" name="username" class="form-input" placeholder="Enter Username">
                </div>

                <div class="form-input-ctn">
                    <Label for="password" class="form-input-label">Password </Label>
                    <input type="password" class="form-input" name="password1" placeholder="Enter Password">
                </div>

                <div class="form-input-ctn">
                    <Label for="password" class="form-input-label">Confirm Password </Label>
                    <input type="password" class="form-input" name="password2" placeholder="Confirm Password">
                </div>


                <div class="form-submit-ctn">
                    <input type="submit" name="submit" value="Register" class="form-submit-input">
                </div>
                <div class="form-option-message">Already Have Account <a href="login-form.php">Login</a>
                </div>
            </div>

        </form>

    </div>
</body>

</html>