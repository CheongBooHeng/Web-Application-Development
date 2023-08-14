<?php include "session.php"?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Contact Us</title>
</head>

<body>
    <div class="container">
        <?php
        include 'navbar/nav.php';
        ?>
        <div class="page-header">
            <h1>Contact Us</h1>
        </div>
        <?php
        date_default_timezone_set('asia/Kuala_Lumpur');
        if ($_POST) {
            // include database connection
            include 'config/database.php';
            try {
                // insert query
                $query = "INSERT INTO contact SET name=:name, phone_number=:phone_number, email=:email, message=:message";
                // prepare query for execution
                $stmt = $con->prepare($query);
                $name = $_POST['name'];
                $phone_number = $_POST['phone_number'];
                $email = $_POST['email'];
                $message = $_POST['message'];

                $errors = array();
                if (empty($name)) {
                    $errors[] = 'Mame is required.';
                }
                if (empty($phone_number)) {
                    $errors[] = 'Phone Number is required.';
                }
                if (empty($email)) {
                    $errors[] = 'Email is required.';
                  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = 'Invalid email format.';
                  }
                if (empty($message)) {
                    $errors[] = 'Message is required.';
                }
                // bind the parameters
                if (!empty($errors)) {
                    echo "<div class='alert alert-danger m-3'>";
                    foreach ($errors as $displayError) {
                        echo $displayError . "<br>";
                    }
                    echo "</div>";
                } else {
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':phone_number', $phone_number);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':message', $message);

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
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>


        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' class='form-control' value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>"/></td>
                </tr>
                <tr>
                    <td>Phone Number</td>
                    <td><input type='text' name='phone_number' class='form-control' value="<?php echo isset($_POST['phone_number']) ? $_POST['phone_number'] : ''; ?>"/></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type='email' name='email' class='form-control' value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"/></td>
                </tr>
                <tr>
                    <td>Message</td>
                    <td><textarea class="form-control" name="message" id="floatingTextarea" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>"></textarea>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Send' class='btn btn-primary' />
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>