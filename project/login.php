<?php
session_start();
if (isset($_SESSION["customer_id"])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Log In</title>
    <style>
        body {
            background-image: url(img/login_bg.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
        include 'config/database.php';

        if ($_POST) {
            $username_email = $_POST['username_email'];
            $password = $_POST['password'];

            if (empty($username_email)) {
                $user_input = "Username/Email is required.";
            }
            if (empty($password)) {
                $password_input = "Password is required.";
            } else {
                try {
                    $query = "SELECT id, username, password, email,account_status FROM customers WHERE username=:username_email OR email=:username_email";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':username_email', $username_email);
                    $stmt->execute();
                    // $row 是array
                    //fetch 全部带进去
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($row) {
                        if (password_verify($password, $row['password'])) {
                            if ($row['account_status'] == 'Active') {;
                                $_SESSION['customer_id'] = $row['id'];
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
                        }
                    } else {
                        $error = "Username/Email Not Found.";
                    }
                } catch (PDOException $exception) {
                    $error = $exception->getMessage();
                }
            }
        }


        ?>
        <div class="row align-items-center m-auto position-absolute top-50 start-50 translate-middle w-75">
            <div class="col text-center">
                <img src="img/logo.png" alt="EcoMart">
            </div>
            <form action="" method="POST" class="col border border-2 border-dark rounded p-4 bg-white">
                <div class="form mb-3 ">
                    <label for="username_email">Username/Email</label>
                    <input type="text" class="form-control w-100 " name="username_email" id="username_email">
                    <span class="text-danger"> <?php echo isset($user_input) ? $user_input : '';  ?></span>
                </div>
                <div class="form mb-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control w-100" name="password" id="password">
                    <span class="text-danger"> <?php echo isset($password_input) ? $password_input : '';  ?></span>
                </div>
                <div class="button">
                    <button class="btn btn-outline-success text-center w-100" type="submit">Log in</button>
                </div>
                <span class="text-danger"><?php echo isset($error) ? $error : ''; ?></span>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>