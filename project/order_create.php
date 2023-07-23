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
        $product_query = "SELECT id, name FROM products";
        $product_stmt = $con->prepare($product_query);
        $product_stmt->execute();
        $products = $product_stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($_POST) {
            try {
                $summary_query = "INSERT INTO order_summary SET customer_id=:customer, order_date=:order_date";
                $customer = $_POST['customer'];
                $order_date = date('Y-m-d H:i:s'); // get the current date and time
                $summary_stmt = $con->prepare($summary_query);
                $summary_stmt->bindParam(':customer', $customer);
                $summary_stmt->bindParam(':order_date', $order_date);
                $summary_stmt->execute();

                // order details
                $details_query = "INSERT INTO order_details SET order_id=:order_id, customer_id=:customer_id, product_id=:product_id, quantity=:quantity";
                $order_id = $con->lastInsertId();
                $product_id = $_POST['product'];
                $quantity = $_POST['quantity'];
                $details_stmt = $con->prepare($details_query);
                $errors = array();
                for ($i = 0; $i < 3; $i++) {
                    $details_stmt->bindParam(':order_id', $order_id);
                    $details_stmt->bindParam(':customer_id', $customer);
                    $details_stmt->bindParam(':product_id', $product_id[$i]);
                    $details_stmt->bindParam(':quantity', $quantity[$i]);
                    $details_stmt->execute();
                }
                echo "<div class='alert alert-success'>Order successfully.</div>";
            } catch (PDOException $exception) {
                echo "<div class='alert alert-danger'>Unable to place order.</div>";
            }
        }
        ?>

        <form action="" method="POST">
            <span>Select customer</span>
            <select class="form-select mb-3" name="customer">
                <?php
                // Fetch categories from the database
                $query = "SELECT id, username FROM customers";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Generate select options
                foreach ($customers as $customer) {
                    echo "<option value='{$customer['id']}'>{$customer['username']}</option>";
                } ?>
            </select>

            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                </tr>
                <tr>
                    <td><select class="form-select" name="product[]"> <!-- array -->
                            <?php
                            // Generate select options
                            foreach ($products as $product) {
                                echo "<option value='{$product['id']}'>{$product['name']}</option>";
                            } ?>
                        </select>
                    <td><input class="form-control" type="number" name="quantity[]"></td> <!-- []array -->
                    </td>

                </tr>
                <tr>
                    <td><select class="form-select" name="product[]">
                            <?php
                            // Generate select options
                            foreach ($products as $product) {
                                echo "<option value='{$product['id']}'>{$product['name']}</option>";
                            } ?>
                        </select>
                    <td><input class="form-control" type="number" name="quantity[]"></td>
                    </td>

                </tr>
                <tr>
                    <td><select class="form-select" name="product[]">
                            <?php
                            // Generate select options
                            foreach ($products as $product) {
                                echo "<option value='{$product['id']}'>{$product['name']}</option>";
                            } ?>
                        </select>
                    <td><input class="form-control" type="number" name="quantity[]"></td>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type='submit' value='Place Order' class='btn btn-primary' /></td>
                </tr>
            </table>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>