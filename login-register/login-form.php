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
                Login
            </div>
            <div class="form-body">

                <div class="error-message">
                    Name is required
                </div>

                <div class="form-input-ctn">
                    <Label for="username" class="form-input-label">Username </Label>
                    <input type="text" name="username" class="form-input" placeholder="Enter Username">
                </div>

                <div class="form-input-ctn">
                    <Label for="password" class="form-input-label">Password </Label>
                    <input type="password" class="form-input" name="password" placeholder="Enter Password">
                </div>

                <div class="form-submit-ctn">
                    <input type="submit" name="submit" value="Login" class="btn">
                </div>
                <div class="form-option-message">Don't Have Account <a href="register-form.html">Register</a>
                </div>
            </div>

        </form>

    </div>
</body>

</html>