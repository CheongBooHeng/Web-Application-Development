<?php include "session.php" ?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Create product</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    <div class="container">
        <?php
        include 'navbar/nav.php';
        ?>
        <div class="page-header">
            <h1>Create Product</h1>
        </div>
        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->
        <?php
        date_default_timezone_set('asia/Kuala_Lumpur');
        // include database connection
        include 'config/database.php';
        if ($_POST) {
            try {
                $name = $_POST['name'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $promotion = $_POST['promotion'];
                $manufacture = $_POST['manufacture'];
                $expired = $_POST['expired'];
                $category_name = $_POST['category_name'];
                // new 'image' field
                $image = !empty($_FILES["image"]["name"])
                    ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                    : "";
                $image = htmlspecialchars(strip_tags($image));
                $target_file = '';
                $errors = array();

                // now, if image is not empty, try to upload the image
                if ($image) {
                    // upload to file to folder
                    $target_directory = "uploads/";
                    $target_file = $target_directory . $image;
                    //pathinfo找是不是.jpg,.png
                    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
                    $check = getimagesize($_FILES["image"]["tmp_name"]);
                    // make sure submitted file is not too large, can't be larger than 1 MB
                    if ($_FILES['image']['size'] > (524288)) {
                        $errors []= "Image must be less than 512 KB in size.";
                    }
                    if ($check == false) {
                        // make sure that file is a real image
                        $errors []= "Submitted file is not an image.";
                    }
                    // make sure certain file types are allowed
                    $allowed_file_types = array("jpg", "jpeg", "png", "gif");
                    if (!in_array($file_type, $allowed_file_types)) {
                        $errors []= "Only JPG, JPEG, PNG, GIF files are allowed.";
                    }else{
                        $image_width = $check[0];
                        $image_height = $check[1];
                        if ($image_width != $image_height) {
                            $errors[] = "Only square size image allowed.";
                        }
                    }
                    // make sure file does not exist
                    if (file_exists($target_file)) {
                        $errors []= "Image already exists. Try to change file name.";
                    }
                }
                if (empty($name)) {
                    $errors[] = 'Product name is required.';
                }

                if (empty($description)) {
                    $errors[] = 'Description is required.';
                }

                if (empty($price)) {
                    $errors[] = "Price is required.";
                } elseif (!is_numeric($price)) {
                    $errors[] = "Product price must be a numeric value.";
                }

                if ($promotion >= $price) {
                    $errors[] = 'Promotion price must be cheaper than original price.';
                }

                if (!empty($promotion) && !is_numeric($promotion)) {
                    $errors[] = 'Promotion price must be a numeric value.';
                }

                if (empty($expired)) {
                    $errors[] = "Expired date is required.";
                }

                if (empty($manufacture)) {
                    $errors[] = 'Manufacture date is required.';
                } elseif ($expired <= $manufacture) {
                    $errors[] = 'Expired date must be later than manufacture date.';
                }
                if($manufacture > date('Y-m-d')){
                    $errors[] = "Date of birth cannot be greater than the current date.";
                }

                if (!empty($errors)) {
                    echo "<div class='alert alert-danger'>";
                    foreach ($errors as $displayError) {
                        echo $displayError . "<br>";
                    }
                    echo "</div>";
                } else {
                    // insert query
                    $query = "INSERT INTO products SET name=:name, description=:description, price=:price, image=:image, created=:created, 
                promotion_price=:promotion, manufacture_date=:manufacture, expired_date=:expired, category_name=:category_name";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
                    // bind the parameters
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':price', $price);
                    $stmt->bindParam(':image', $target_file);
                    $created = date('Y-m-d H:i:s'); // get the current date and time
                    $stmt->bindParam(':created', $created);
                    $stmt->bindParam(':promotion', $promotion);
                    $stmt->bindParam(':manufacture', $manufacture);
                    $stmt->bindParam(':expired', $expired);
                    $stmt->bindParam(':category_name', $category_name);

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                        // make sure the 'uploads' folder exists
                        // if not, create it
                        if ($image) {
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
                                    echo "<div>Unable to upload photo.</div>";
                                    echo "<div>Update the record to upload photo.</div>";
                                    echo "</div>";
                                }
                            }

                            // if $file_upload_error_messages is NOT empty
                            else {
                                // it means there are some errors, so show them to user
                                echo "<div class='alert alert-danger'>";
                                echo "<div>{$file_upload_error_messages}</div>";
                                echo "<div>Update the record to upload photo.</div>";
                                echo "</div>";
                            }
                        }
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

        <!-- html form here where the product information will be entered -->
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' class='form-control' value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea class="form-control" name="description" id="floatingTextarea"><?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='text' name='price' class='form-control' value="<?php echo isset($_POST['price']) ? $_POST['price'] : ''; ?>" /></td>
                </tr>
                <tr>
                    <td>Promotion Price</td>
                    <td><input type='text' name='promotion' class='form-control' value="<?php echo isset($_POST['promotion']) ? $_POST['promotion'] : ''; ?>" /></td>
                </tr>
                <tr>
                    <td>Categories</td>
                    <td><select class="form-select" name="category_name">
                            <?php
                            // Fetch categories from the database
                            $query = "SELECT category_name FROM categories";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);

                            // Generate select options
                            foreach ($categories as $category) {
                                echo "<option value='$category'>$category</option>";
                            } ?></select>
                    </td>
                </tr>
                <tr>
                    <td>Manufacture Date</td>
                    <td><input type='date' name='manufacture' class='form-control' value="<?php echo isset($_POST['manufacture']) ? $_POST['manufacture'] : ''; ?>" /></td>
                </tr>
                <tr>
                    <td>Expired</td>
                    <td><input type='date' name='expired' class='form-control' value="<?php echo isset($_POST['expired']) ? $_POST['expired'] : ''; ?>" /></td>
                </tr>
                <tr>
                    <td>Photo</td>
                    <td><input type="file" name="image" accept="image/*"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='product_read.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>