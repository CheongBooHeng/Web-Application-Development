<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Log In</title>
</head>

<body>
    <div class="container">
        <div class="text-center mb-3">
            <h1>Log In</h1>
        </div>

        <?php
        include 'config/database.php';

        if ($_POST) {
            $username_email = $_POST['username_email'];
            $password = $_POST['password'];

            $errors = array();

            if (empty($username_email)) {
                $errors[] = "Username/Email is required.";
            }
            if (empty($password)) {
                $errors[] = "Password is required.";
            }
            if (!empty($errors)) {
                echo "<div class='alert alert-danger'>";
                foreach ($errors as $error) {
                    echo "<p class='error-message'>$error</p>";
                }
                echo "</div>";
            } else {
                try {
                    $query = "SELECT id, username, password, email,account_status FROM customers WHERE username=:username_email OR email=:username_email";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':username_email', $username_email);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($row) {
                        if (password_verify($password, $row['password'])) {
                            if ($row['account_status'] == 'Active') {
                                header("Location: index.php");
                                exit();
                            } else {
                                $error = "Inactive account.";
                                echo "<div class='alert alert-danger'>";

                                echo "<p class='error-message'>$error</p>";

                                echo "</div>";
                            }
                        } else {
                            $error = "Incorrect password.";
                            echo "<div class='alert alert-danger'>";

                            echo "<p class='error-message'>$error</p>";

                            echo "</div>";
                        }
                    } else {
                        $error = "Username/Email Not Found.";
                        echo "<div class='alert alert-danger'>";

                        echo "<p class='error-message'>$error</p>";

                        echo "</div>";
                    }
                } catch (PDOException $exception) {
                    $error = $exception->getMessage();
                }
            }
        }


        ?>
        <form action="" method="POST">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="username_email" id="username_email" placeholder="name@example.com">
                <label for="username_email">Username/Email</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                <label for="password">Password</label>
            </div>
            <div class="button">
                <button class="btn btn-outline-success mb-2" type="submit">Log in</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>