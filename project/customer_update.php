<?php include "session.php" ?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Update customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    <div class="container">
        <?php
        include 'navbar/nav.php';
        ?>
        <div class="page-header">
            <h1>Update Customer</h1>
        </div>
        <!-- PHP read record by ID will be here -->
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT id, username, password, firstname, lastname, gender, date_of_birth, account_status, email, image FROM customers WHERE id = ? LIMIT 0,1";
            //0=offset 
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $username = $row['username'];
            $password = $row['password'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $gender = $row['gender'];
            $date_of_birth = $row['date_of_birth'];
            $account_status = $row['account_status'];
            $email = $row['email'];
            $image = $row['image'];
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <?php
        // check if form was submitted
        if ($_POST) {
            try {
                if (isset($_POST['delete_image'])) {
                    $empty = "";
                    $delete_query = "UPDATE customers SET image=:image WHERE id = :id";
                    $delete_stmt = $con->prepare($delete_query);
                    $delete_stmt->bindParam(":image", $empty);
                    $delete_stmt->bindParam(":id", $id);
                    $delete_stmt->execute();
                    unlink($image);
                    echo "<script>
                    window.location.href = 'customer_read_one.php?id={$id}&action=record_updated';
                  </script>";
                } else {
                // write update query
                // in this case, it seemed like we have so many fields to pass and
                // it is better to label them and not use question marks
                $query = "UPDATE customers
                SET firstname=:firstname, lastname=:lastname, gender=:gender, date_of_birth=:date_of_birth, account_status=:account_status, email=:email, image=:image";
                // prepare query for excecution
                $stmt = $con->prepare($query);
                // posted values
                $oldpassword = $_POST['oldpassword'];
                $newpassword = $_POST['newpassword'];
                $confirmpassword = $_POST['confirmpassword'];
                $firstname = htmlspecialchars(strip_tags($_POST['firstname']));
                $lastname = htmlspecialchars(strip_tags($_POST['lastname']));
                $gender = $_POST['gender'];
                $date_of_birth = $_POST['date_of_birth'];
                $account_status = $_POST['account_status'];
                $email = $_POST['email'];
                // new 'image' field
                $image = !empty($_FILES["image"]["name"])
                    ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                    : "";
                $image = htmlspecialchars(strip_tags($image));
                // upload to file to folder
                $target_directory = "uploads/";
                $target_file = $target_directory . $image;
                //pathinfo找是不是.jpg,.png
                $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
                $errors = array();

                // now, if image is not empty, try to upload the image
                if ($image) {
                    $check = getimagesize($_FILES["image"]["tmp_name"]);
                    // make sure submitted file is not too large, can't be larger than 1 MB
                    if ($_FILES['image']['size'] > (524288)) {
                        $errors[] = "Image must be less than 512 KB in size.";
                    }
                    if ($check == false) {
                        // make sure that file is a real image
                        $errors[] = "Submitted file is not an image.";
                    }
                    // make sure certain file types are allowed
                    $allowed_file_types = array("jpg", "jpeg", "png", "gif");
                    if (!in_array($file_type, $allowed_file_types)) {
                        $errors[] = "Only JPG, JPEG, PNG, GIF files are allowed.";
                    }else{
                        $image_width = $check[0];
                        $image_height = $check[1];
                        if ($image_width != $image_height) {
                            $errors[] = "Only square size image allowed.";
                        }
                    }
                    // make sure file does not exist
                    if (file_exists($target_file)) {
                        $errors[] = "Image already exists. Try to change file name.";
                    }
                }



                //check 新pw format, newpw=cpw一样不一样, oldpw, oldpw==newpw
                // if (!empty($_POST['oldpassword']) && !empty($_POST['newpassword']) && !empty($_POST['confirmpassword'])) {
                //     if (password_verify($oldpassword, $row['password'])) {
                //         if ($newpassword == $oldpassword) {
                //             $errors[] = "New Password cannot same with old password.";
                //         } else if ($newpassword == $confirmpassword) {
                //             $formatted_password = password_hash($newpassword, PASSWORD_DEFAULT);
                //         } else {
                //             $errors[] = "Confirm password does not match with new password.";
                //         }
                //     } else {
                //         $errors[] = "You entered the wrong password for old password";
                //     }
                // } else {
                //     $formatted_password = $password;
                // }

                if (!empty($oldpassword) && !empty($newpassword) && !empty($confirmpassword)) {
                    // Password format validation
                    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?!.*[-+$()%@#]).{6,}$/', $newpassword)) {
                        $errors[] = 'Invalid new password format.';
                    } else {
                        if ($newpassword == $confirmpassword) {
                            if (password_verify($oldpassword, $password)) {
                                if ($oldpassword == $newpassword) {
                                    $errors[] = "New password can't be the same as the old password.";
                                } else {
                                    $hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);
                                }
                            } else {
                                $errors[] = "Wrong password entered in the old password column.";
                            }
                        } else {
                            $errors[] = "The confirm password doesn't match the new password.";
                        }
                    }
                } else {
                    $hashed_password = $password;
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Invalid Email format.";
                }

                if($date_of_birth >= date('Y-m-d')){
                    $errors[] = "Date of birth cannot be the same as the current date or greater than the current date.";
                }

                if (empty($firstname)) {
                    $errors[] = "First name is required";
                } elseif (preg_match('/\d/', $firstname)) {
                    $errors[] = 'First name cannot contain numbers';
                }
                
                if (empty($lastname)) {
                    $errors[] = "Last name is required";
                } elseif (preg_match('/\d/', $lastname)) {
                    $errors[] = 'Last name cannot contain numbers';
                }                

                if (!empty($errors)) {
                    echo "<div class='alert alert-danger'>";
                    foreach ($errors as $errorMessage) {
                        echo $errorMessage . "<br>";
                    }
                    echo "</div>";
                } else {
                    if (isset($hashed_password)) {
                        $query .= ", password=:password";
                    }
                    $query .= " WHERE id=:id";
                    $stmt = $con->prepare($query);
                    // bind the parameters
                    $stmt->bindParam(':id', $id);
                    if (isset($hashed_password)) {
                        $stmt->bindParam(':password', $hashed_password);
                    }
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':lastname', $lastname);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':date_of_birth', $date_of_birth);
                    $stmt->bindParam(':account_status', $account_status);
                    $stmt->bindParam(':email', $email);
                    if ($image == "") {
                        $stmt->bindParam(":image", $row['image']);
                    } else {
                        $stmt->bindParam(':image', $target_file);
                    }
                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<script>
                        window.location.href = 'customer_read_one.php?id={$id}&action=record_updated';
                      </script>";
                        // make sure the 'uploads' folder exists
                        // if not, create it
                        if ($image) {
                            if ($target_file != $row['image'] && $row['image'] != "") {
                                unlink($row['image']);
                            }

                            // make sure the 'uploads' folder exists
                            // if not, create it
                            if (!is_dir($target_directory)) {
                                mkdir($target_directory, 0777, true);
                            }
                            // if $file_upload_error_messages is still empty
                            if (empty($file_upload_error_messages)) {
                                // it means there are no errors, so try to upload the file
                                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                                    // it means photo was uploaded
                                } else {
                                    echo "<div class='alert alert-danger'>";
                                    echo "Unable to upload photo.";
                                    echo "Update the record to upload photo.";
                                    echo "</div>";
                                }
                            }

                            // if $file_upload_error_messages is NOT empty
                            else {
                                // it means there are some errors, so show them to user
                                echo "<div class='alert alert-danger'>";
                                echo "{$file_upload_error_messages}";
                                echo "Update the record to upload photo.";
                                echo "</div>";
                            }
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                    }
                }
            }
        }
            // show errors
            catch (PDOException $exception) {
                if ($exception->getCode() == 23000) {
                    echo '<div class= "alert alert-danger role=alert">' . 'Email has been taken. Please provide other email ' . '</div>';
                } else {
                    echo '<div class= "alert alert-danger role=alert">' . $exception->getMessage() . '</div>';
                }
            }
        } ?>



        <!-- HTML form to update record will be here -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Username</td>
                    <td><?php echo htmlspecialchars($username, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Old Password</td>
                    <td><input type="password" name='oldpassword' class='form-control' value="<?php isset($_POST['oldpassword']) ? $_POST['oldpassword'] : '' ?>"></textarea></td>
                </tr>
                <tr>
                    <td>New Password</td>
                    <td><input type="password" name='newpassword' class='form-control' value="<?php isset($_POST['newpassword']) ? $_POST['newpassword'] : '' ?>"></textarea></td>
                </tr>
                <tr>
                    <td>Confirm Password</td>
                    <td><input type="password" name='confirmpassword' class='form-control' value="<?php isset($_POST['confirmpassword']) ? $_POST['confirmpassword'] : '' ?>"></textarea></td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td><input type='text' name='firstname' value="<?php echo htmlspecialchars($firstname, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type='text' name='lastname' value="<?php echo htmlspecialchars($lastname, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td><input type="radio" name="gender" id="genderMale" value="Male" <?php if ($row['gender'] == "Male") {
                                                                                            echo 'checked';
                                                                                        } ?>>
                        <label class="form-check-label" for="genderMale">Male</label>
                        <input type="radio" name="gender" id="genderFemale" value="Female" <?php if ($row['gender'] == "Female") {
                                                                                                echo 'checked';
                                                                                            } ?>>
                        <label class="form-check-label" for="genderFemale">Female</label>
                    </td>
                </tr>
                <tr>
                    <td>Date of birth</td>
                    <td><input type='date' name='date_of_birth' value="<?php echo htmlspecialchars($date_of_birth, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Account Status</td>
                    <td>
                        <input type="radio" name="account_status" id="active" value="Active" <?php if ($row['account_status'] == "Active") {
                                                                                                    echo 'checked';
                                                                                                } ?>>
                        <label class="form-check-label" for="active">Active</label>
                        <input type="radio" name="account_status" id="inactive" value="Inactive" <?php if ($row['account_status'] == "Inactive") {
                                                                                                        echo 'checked';
                                                                                                    } ?>>
                        <label class="form-check-label" for="inactive">Inactive</label>
                    </td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type='email' name='email' value="<?php echo htmlspecialchars($email, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Photo</td>
                    <td>
                        <?php
                        if ($image != "") {
                            echo '<img src="' . htmlspecialchars($image, ENT_QUOTES) . '"width="100">';
                        } else {
                            echo '<img src="img/profile.jpeg" alt="image" width="100">';
                        }
                        ?>
                        <br>
                        <input type="file" class="mt-2" name="image" class="form-control-file" accept="image/*">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <?php if ($image != "") { ?>
                            <input type="submit" value="Delete Image" class="btn btn-danger" name="delete_image">
                        <?php } ?>
                        <a href='customer_read.php' class='btn btn-danger'>Back to read customers</a>
                    </td>
                </tr>
            </table>
        </form>


    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>