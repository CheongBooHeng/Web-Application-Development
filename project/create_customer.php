<!DOCTYPE HTML>
<html>

<head>
    <title>Create Customer</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    <div class="container">
        <?php
        include 'nav.php';
        ?>
        <div class="page-header">
            <h1>Create Customer</h1>
        </div>
        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->
        <?php
        date_default_timezone_set('asia/Kuala_Lumpur');
        if ($_POST) {
            // include database connection
            include 'config/database.php';
            try {
                // insert query
                $query = "INSERT INTO customers SET username=:username, password=:password, firstname=:firstname, lastname=:lastname, 
                gender=:gender, date_of_birth=:date_of_birth, registration_date_time=:registration_date_time, account_status=:account_status, email=:email";
                // prepare query for execution
                $stmt = $con->prepare($query);
                $username = $_POST['username'];
                $password = $_POST['password'];
                $confirmpassword = $_POST['confirmpassword'];
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $email = $_POST['email'];
                $gender = $_POST['gender'];
                $date_of_birth = $_POST['date_of_birth'];
                $account_status = $_POST['account_status'];


                $errors = array();
                if (empty($username)) {
                    $errors[] = 'Username is required.';
                } elseif (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_-]{5,}$/', $username)) {
                    $errors[] = 'Invalid username format.';
                }
                if (empty($password)) {
                    $errors[] = 'Password is required.';
                } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?!.*[-+$()%@#]).{6,}$/', $password)) {
                    $errors[] = 'Invalid password format.';
                }
                if (empty($confirmpassword)) {
                    $errors[] = 'Confirm password is required.';
                } elseif ($password !== $confirmpassword) {
                    $errors[] = 'Confirm password do not match.';
                }
                if (empty($firstname)) {
                    $errors[] = 'Fistname is required.';
                }
                if (empty($lastname)) {
                    $errors[] = 'Lastname is required.';
                }
                if (empty($email)) {
                    $errors[] = 'Email is required.';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = 'Invalid email format.';
                }
                if (empty($gender)) {
                    $errors[] = 'Gender is required.';
                }
                if (empty($date_of_birth)) {
                    $errors[] = 'Date of birth is required.';
                }
                if (empty($account_status)) {
                    $errors[] = 'Account status is required.';
                }

                // bind the parameters
                if (!empty($errors)) {
                    echo "<div class='alert alert-danger'>";
                    foreach ($errors as $displayError) {
                        echo $displayError . "<br>";
                    }
                    echo "</div>";
                } else {
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':password', $password);
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':lastname', $lastname);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':gender', $gender);
                    $registration_date_time = date('Y-m-d H:i:s'); // get the current date and time
                    $stmt->bindParam(':registration_date_time', $registration_date_time);
                    $stmt->bindParam(':date_of_birth', $date_of_birth);
                    $stmt->bindParam(':account_status', $account_status);

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                        $_POST = array();
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }
                }
            }

            // show error
            catch (PDOException $exception) {
                //  die('ERROR: ' . $exception->getMessage());
                if ($exception->getCode() == 23000) {
                    echo '<div class= "alert alert-danger role=alert">' . 'Username has been taken' . '</div>';
                } else {
                    echo '<div class= "alert alert-danger role=alert">' . $exception->getMessage() . '</div>';
                }
            }
        }
        ?>

        <!-- html form here where the product information will be entered -->
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Username</td>
                    <td><input type='text' name='username' class='form-control' value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" />
                        Username must be at least 6 characters long, start with a letter, and can only contain letters, digits, '_', or '-'.</td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type='password' name='password' class='form-control' value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>" />
                        At least 6 characters long and contain at least one uppercase letter, one lowercase letter, and one number. No special symbols allowed.</td>
                </tr>
                <tr>
                    <td>Confirm password</td>
                    <td><input type='password' name='confirmpassword' class='form-control' ; ?></td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><input type='text' name='firstname' class='form-control' value="<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : ''; ?>" /></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type='text' name='lastname' class='form-control' value="<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : ''; ?>" /></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>
                        <input type="radio" name="gender" id="genderMale" value="male" checked>
                        <label class="form-check-label" for="genderMale">Male</label>
                        <input type="radio" name="gender" id="genderFemale" value="female">
                        <label class="form-check-label" for="genderFemale">Female</label>
                    </td>
                </tr>
                <tr>
                    <td>Date Of Birth</td>
                    <td><input type='date' name='date_of_birth' class='form-control' value="<?php echo isset($_POST['date_of_birth']) ? $_POST['date_of_birth'] : ''; ?>" /></td>
                </tr>
                <tr>
                    <td>Account Status</td>
                    <td><input type="radio" name="account_status" id="active" value="active" checked>
                        <label class="form-check-label" for="active">Active</label>
                        <input type="radio" name="account_status" id="inactive" value="inactive">
                        <label class="form-check-label" for="inactive">Inactive</label>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>