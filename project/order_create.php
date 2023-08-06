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


        if ($_POST) {
            try {
                $errors = array();
                $customer = $_POST['customer'];
                $product_id = $_POST['product'];
                $quantity_array = $_POST['quantity'];

                $noduplicate = array_unique($product_id);

                if (sizeof($noduplicate) != sizeof($product_id)) {
                    foreach ($product_id as $key => $val) {
                        if (!array_key_exists($key, $noduplicate)) {
                            $errors[] = "Duplicated products have been chosen " ;
                            array_splice($product_id, $key, 1);
                            array_splice($quantity_array, $key, 1);
                        }
                    }
                }

                $selected_product_count = isset($noduplicate) ? count($noduplicate) : count($_POST['product']);

                if (empty($customer)) {
                    $errors[] = 'Please select a customer.';
                }

                // foreach ($product_id as $product) {
                //     if (empty($product)) {
                //         $errors[] = "Please select the product.";
                //     }
                // }
                // foreach ($quantity_array as $quantity) {
                //     if (empty($quantity)) {
                //         $errors[] = "Please fill in the quantity for the selected products.";
                //     }
                //     if ($quantity <= 0) {
                //         $errors[] = "Quantity cannot be negative number or zero.";
                //     }
                // }

                if (isset($selected_product_count)) {
                    for ($i = 0; $i < $selected_product_count; $i++) {
                        if ($product_id[$i] == "") {
                            $errors[] = " Please choose the product for NO " . $i + 1 . ".";
                        }

                        if ($quantity[$i] == 0 || empty($quantity_array[$i])) {
                            $errors[] = "Quantity Can not be zero or empty.";
                        } else if ($quantity_array[$i] < 0) {
                            $errors[] = "Quantity Can not be negative number.";
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
                    $summary_query = "INSERT INTO order_summary SET customer_id=:customer, order_date=:order_date";
                    $order_date = date('Y-m-d H:i:s'); // get the current date and time
                    $summary_stmt = $con->prepare($summary_query);
                    $summary_stmt->bindParam(':customer', $customer);
                    $summary_stmt->bindParam(':order_date', $order_date);
                    $summary_stmt->execute();

                    // order details
                    $order_id = $con->lastInsertId();
                    // array
                    $quantity = $_POST['quantity'];
                    $details_query = "INSERT INTO order_details SET order_id=:order_id, customer_id=:customer_id, product_id=:product_id, quantity=:quantity";
                    $details_stmt = $con->prepare($details_query);
                    for ($i = 0; $i < count($product_id); $i++) {
                        $details_stmt->bindParam(':order_id', $order_id);
                        $details_stmt->bindParam(':customer_id', $customer);
                        // 这边叫出来每个
                        $details_stmt->bindParam(':product_id', $product_id[$i]);
                        $details_stmt->bindParam(':quantity', $quantity[$i]);
                        $details_stmt->execute();
                    }
                    echo "<div class='alert alert-success'>Order successfully.</div>";
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
                // Fetch categories from the database
                $query = "SELECT id, username FROM customers";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                $product_keep = (!empty($error)) ? $selected_product : 1;
                for ($x = 0; $x < $product_keep; $x++) {
                ?>
                    <tr class="pRow">
                        <td class="text-center">1</td>
                        <td class="d-flex">
                            <select class="form-select" name="product[]"> <!-- array -->
                                <option value=''>Select a product</option>;
                                <?php
                                $product_query = "SELECT id, name FROM products";
                                $product_stmt = $con->prepare($product_query);
                                $product_stmt->execute();
                                $products = $product_stmt->fetchAll(PDO::FETCH_ASSOC);
                                // Generate select options
                                for ($i = 0; $i < count($products); $i++) {
                                    $product_selected = isset($_POST["product"]) && $products[$i]['id'] == $_POST["product"][$x] ? "selected" : "";
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