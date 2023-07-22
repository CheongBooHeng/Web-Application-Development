<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Create Order</title>
</head>

<body>
    <div class="container">
        <?php
        include 'nav.php';
        ?>
        <div class="page-header">
            <h1>Create New Order</h1>
        </div>

        <?php
        date_default_timezone_set('asia/Kuala_Lumpur');
        // include database connection
        include 'config/database.php';
        ?>

        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="GET">
            <tr>
                <td>Select customer</td>
                <td><select class="form-select mb-3" name="customers">
                        <?php
                        // Fetch categories from the database
                        $query = "SELECT username FROM customers";
                        $stmt = $con->prepare($query);
                        $stmt->execute();
                        $customers = $stmt->fetchAll(PDO::FETCH_COLUMN);

                        // Generate select options
                        foreach ($customers as $customer) {
                            echo "<option value='$customer'>$customer</option>";
                        } ?></select>
                </td>
            </tr>
        </form>

        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
                <tr>
                    <td><select class="form-select" name="product">
                            <?php
                            // Fetch products from the database
                            $query = "SELECT name FROM products";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            $products = $stmt->fetchAll(PDO::FETCH_COLUMN);

                            // Generate select options
                            foreach ($products as $product) {
                                echo "<option value='$product'>$product</option>";
                            } ?>
                        </select>
                    <td><input class="form-control" type="number" name="quantity" ></td>
                    </td>
                    <td>
                        <?php
                        
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><select class="form-select" name="product">
                            <?php
                            // Fetch products from the database
                            $query = "SELECT name FROM products";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            $products = $stmt->fetchAll(PDO::FETCH_COLUMN);

                            // Generate select options
                            foreach ($products as $product) {
                                echo "<option value='$product'>$product</option>";
                            } ?>
                        </select>
                    <td><input class="form-control" type="number" name="quantity" ></td>
                    </td>
                    <td>
                        <?php
                        
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><select class="form-select" name="product">
                            <?php
                            // Fetch products from the database
                            $query = "SELECT name FROM products";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            $products = $stmt->fetchAll(PDO::FETCH_COLUMN);

                            // Generate select options
                            foreach ($products as $product) {
                                echo "<option value='$product'>$product</option>";
                            } ?>
                        </select>
                    <td><input class="form-control" type="number" name="quantity" ></td>
                    </td>
                    <td>
                        <?php
                        
                        ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-end fw-bold">Subtotal</td>
                    <td></td>
                </tr>
            </table>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>