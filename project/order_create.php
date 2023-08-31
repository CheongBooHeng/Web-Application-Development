<?php include "session.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Create order</title>
</head>

<body>
    <div class="container">
        <?php
        include 'navbar/nav.php';
        ?>
        <div class="page-header">
            <h1>Create New Order</h1>
        </div>

        <?php
        date_default_timezone_set('asia/Kuala_Lumpur');
        // include database connection
        include 'config/database.php';

        $customer_query = "SELECT id, username FROM customers";
        $customer_stmt = $con->prepare($customer_query);
        $customer_stmt->execute();
        $customers = $customer_stmt->fetchAll(PDO::FETCH_ASSOC);

        $product_query = "SELECT * FROM products";
        $product_stmt = $con->prepare($product_query);
        $product_stmt->execute();
        $products = $product_stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($_POST) {
            try {
                $errors = array();
                $customer = $_POST['customer'];
                $product_id = $_POST['product'];
                $quantity_array = $_POST['quantity'];

                $status_query = "SELECT * FROM customers WHERE id=?";
                $status_stmt = $con->prepare($status_query);
                $status_stmt->bindParam(1, $customer);
                $status_stmt->execute();
                $status = $status_stmt->fetch(PDO::FETCH_ASSOC);

                //array里面有一样的东西就会删掉
                $noduplicate = array_unique($product_id);

                //有填到一样的东西才跑下面的
                if (sizeof($noduplicate) != sizeof($product_id)) {
                    foreach ($product_id as $key => $val) {
                        if (!array_key_exists($key, $noduplicate)) {
                            $errors[] = "Duplicated products have been chosen ";
                            unset($quantity_array[$key]);
                        }
                    }
                }
                $product_id = array_values($noduplicate);
                $quantity_array = array_values($quantity_array);

                $selected_product_count = isset($noduplicate) ? count($noduplicate) : count($_POST['product']);

                if ($customer == "") {
                    $errors[] = "Please choose your username.";
                }else if ($status['account_status'] == "Inactive") {
                    $errors[] = "Inactive account can't make a order";
                }

                if (isset($selected_product_count)) {
                    for ($i = 0; $i < $selected_product_count; $i++) {
                        if ($product_id[$i] == "") {
                            $errors[] = " Please choose the product for NO " . $i + 1 . ".";
                        }

                        if ($quantity_array[$i] == 0 || empty($quantity_array[$i])) {
                            $errors[] = "Quantity cannot be zero.";
                        } else if ($quantity_array[$i] < 0) {
                            $errors[] = "Quantity cannot be negative number.";
                        }
                    }
                }
                if (!empty($errors)) {
                    echo "<div class='alert alert-danger'>";
                    foreach ($errors as $displayError) {
                        echo $displayError . "<br>";
                    }
                    echo "</div>";
                } else {
                    $total_amount = 0;
                    for ($x = 0; $x < $selected_product_count; $x++) {
                        $price_query = "SELECT * FROM products WHERE id=?";
                        $price_stmt = $con->prepare($price_query);
                        $price_stmt->bindParam(1, $product_id[$x]);
                        $price_stmt->execute();
                        $prices = $price_stmt->fetch(PDO::FETCH_ASSOC);

                        $amount =  ($prices['promotion_price'] != 0) ?  $prices['promotion_price'] * $quantity_array[$x] : $prices['price'] * $quantity_array[$x];

                        $total_amount += $amount;
                    }

                    $summary_query = "INSERT INTO order_summary SET customer_id=:customer, order_date=:order_date, total_amount=:total_amount";
                    $order_date = date('Y-m-d H:i:s'); // get the current date and time
                    $summary_stmt = $con->prepare($summary_query);
                    $summary_stmt->bindParam(':customer', $customer);
                    $summary_stmt->bindParam(':order_date', $order_date);
                    $summary_stmt->bindParam(":total_amount", $total_amount);
                    $summary_stmt->execute();

                    // order details
                    $order_id = $con->lastInsertId();

                    for ($i = 0; $i < $selected_product_count; $i++) {
                        $details_query = "INSERT INTO order_details SET order_id=:order_id, product_id=:product_id, quantity=:quantity";
                        $details_stmt = $con->prepare($details_query);
                        $details_stmt->bindParam(':order_id', $order_id);
                        // 这边叫出来每个
                        $details_stmt->bindParam(':product_id', $product_id[$i]);
                        $details_stmt->bindParam(':quantity', $quantity_array[$i]);
                        $details_stmt->execute();
                    }
                    echo "<script>window.location.href = 'order_detail_read.php?id={$order_id}&action=create_order_successfully';</script>";
                    $_POST = array();
                }
            } catch (PDOException $exception) {
                echo "<div class='alert alert-danger'>Unable to place order.</div>";
            }
        }
        ?>

        <form action="" method="POST">
            <select class="form-select mb-3" name="customer">
                <option value=''>Select customer</option>";
                <?php
                // Generate select options
                for ($x = 0; $x < count($customers); $x++) {
                    $customer_selected = isset($_POST["customer"]) && $customers[$x]['id'] == $_POST["customer"] ? "selected" : "";
                    echo "<option value='{$customers[$x]['id']}' $customer_selected>{$customers[$x]['username']}</option>";
                } ?>
            </select>

            <table class='table table-hover table-responsive table-bordered' id="row_del">
                <tr>
                    <td class="text-center">#</td>
                    <td class="text-center">Product</td>
                    <td class="text-center">Quantity</td>
                    <td class="text-center">Action</td>
                </tr>

                <?php
                $product_keep = (!empty($errors)) ? $selected_product_count : 1;
                for ($x = 0; $x < $product_keep; $x++) {
                ?>
                    <tr class="pRow">
                        <td class="text-center"><?php echo $x + 1 ?></td>
                        <td class="d-flex">
                            <select class="form-select" name="product[]"> <!-- array -->
                                <option value=''>Select a product</option>;
                                <?php
                                // Generate select options
                                for ($i = 0; $i < count($products); $i++) {
                                    $product_selected = isset($_POST["product"]) && $products[$i]['id'] == $product_id[$x] ? "selected" : "";
                                    echo "<option value='{$products[$i]['id']}' $product_selected>{$products[$i]['name']}</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td><input class="form-control" type="number" name="quantity[]" value="<?php echo isset($_POST['quantity']) ? $_POST['quantity'][$x] : 0; ?>"></td> <!-- []array -->
                        <td><input href='#' onclick='deleteRow(this)' class='btn btn-danger m-auto' value="Delete" /></td>
                    <?php
                } ?>
                    </tr>
                    <tr>
                        <td>

                        </td>
                        <td colspan="4">
                            <input type='submit' value='Place Order' class='btn btn-primary' />
                            <input type="button" value="Add More Product" class="btn btn-success add_one" />
                            <a href='order_list.php' class='btn btn-danger'>Back to order list</a>
                        </td>
                    </tr>
            </table>
        </form>
        <script>
            document.addEventListener('click', function(event) {
                if (event.target.matches('.add_one')) {
                    var rows = document.getElementsByClassName('pRow');
                    // Get the last row in the table
                    var lastRow = rows[rows.length - 1];
                    // Clone the last row
                    var clone = lastRow.cloneNode(true);
                    // Insert the clone after the last row
                    lastRow.insertAdjacentElement('afterend', clone);

                    // Loop through the rows
                    for (var i = 0; i < rows.length; i++) {
                        // Set the inner HTML of the first cell to the current loop iteration number
                        rows[i].cells[0].innerHTML = i + 1;
                    }
                }
            }, false);

            function deleteRow(r) {
                var total = document.querySelectorAll('.pRow').length;
                if (total > 1) {
                    var i = r.parentNode.parentNode.rowIndex;
                    document.getElementById("row_del").deleteRow(i);

                    var rows = document.getElementsByClassName('pRow');
                    for (var i = 0; i < rows.length; i++) {
                        // Set the inner HTML of the first cell to the current loop iteration number
                        rows[i].cells[0].innerHTML = i + 1;
                    }
                } else {
                    alert("You need order at least one item.");
                }
            }
        </script>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>