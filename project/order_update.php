<?php include "session.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Update order</title>
</head>

<body>
    <div class="container">
        <?php
        include 'navbar/nav.php';
        ?>
        <div class="page-header">
            <h1>Update Order</h1>
        </div>
        <?php
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        $action = isset($_GET['action']) ? $_GET['action'] : "";
        if ($action == 'record_updated') {
            echo "<div class='alert alert-success'>Product record was updated.</div>";
        }

        date_default_timezone_set('Asia/Kuala_Lumpur');
        //include database connection
        include 'config/database.php';

        $customer_query = "SELECT id, username FROM customers";
        $customer_stmt = $con->prepare($customer_query);
        $customer_stmt->execute();
        $customers = $customer_stmt->fetchAll(PDO::FETCH_ASSOC);

        $product_query = "SELECT id, name, price FROM products";
        $product_stmt = $con->prepare($product_query);
        $product_stmt->execute();
        $products = $product_stmt->fetchAll(PDO::FETCH_ASSOC);

        $order_summary_query = "SELECT * FROM order_summary WHERE order_id=:id";
        $order_summary_stmt = $con->prepare($order_summary_query);
        $order_summary_stmt->bindParam(":id", $id);
        $order_summary_stmt->execute();
        $order_summaries = $order_summary_stmt->fetch(PDO::FETCH_ASSOC);

        $order_detail_query = "SELECT * FROM order_details WHERE order_id=:order_id";
        $order_detail_stmt = $con->prepare($order_detail_query);
        $order_detail_stmt->bindParam(":order_id", $id);
        $order_detail_stmt->execute();
        $order_details = $order_detail_stmt->fetchAll(PDO::FETCH_ASSOC);

        $errors = array();

        if ($_POST) {
            $product_id = $_POST['product'];
            $quantity_array = $_POST['quantity'];

            $noduplicate = array_unique($product_id);

            if (sizeof($noduplicate) != sizeof($product_id)) {
                //key  //val
                //Array ( [0] => 1 [1] => 2 [2] => 3 )
                foreach ($product_id as $key => $val) {
                    if (!array_key_exists($key, $noduplicate)) {
                        $errors[] = "Duplicated products have been chosen " . $products[$val - 1]['name'] . ".";
                        unset($quantity_array[$key]);
                    }
                }
            }
            $product_id = array_values($noduplicate);
            $quantity_array = array_values($quantity_array);
            //如果有duplicate就算                         //没有就跑这个
            $selected_product_count = isset($noduplicate) ? count($noduplicate) : count($order_details);

            try {
                if (isset($selected_product_count)) {
                    for ($i = 0; $i < $selected_product_count; $i++) {
                        if ($product_id[$i] == "") {
                            $errors[] = " Please choose the product for NO " . $i + 1 . ".";
                        }

                        if ($quantity_array[$i] == 0 || empty($quantity_array[$i])) {
                            $errors[] = "Quantity Can not be zero or empty.";
                        } else if ($quantity_array[$i] < 0) {
                            $errors[] = "Quantity Can not be negative number.";
                        }
                    }
                }

                if (!empty($errors)) {
                    echo "<div class='alert alert-danger role='alert'>";
                    foreach ($errors as $error_message) {
                        echo $error_message . "<br>";
                    }
                    echo "</div>";
                } else {
                    $delete_details_query = "DELETE FROM order_details WHERE order_id=:order_id";
                    $delete_details_stmt = $con->prepare($delete_details_query);
                    $delete_details_stmt->bindParam(":order_id", $id);
                    $order_date = date('Y-m-d H:i:s');
                    $delete_details_stmt->execute();

                    for ($i = 0; $i < $selected_product_count; $i++) {
                        $order_details_query = "INSERT INTO order_details SET order_id=:order_id, product_id=:product_id, quantity=:quantity";
                        $order_details_stmt = $con->prepare($order_details_query);
                        $order_details_stmt->bindParam(":order_id", $id);
                        $order_details_stmt->bindParam(":product_id", $product_id[$i]);
                        $order_details_stmt->bindParam(":quantity", $quantity_array[$i]);
                        $order_details_stmt->execute();
                    }

                    $total_amount = 0;
                    for ($i = 0; $i < $selected_product_count; $i++) {
                        $price_query = "SELECT * FROM products WHERE id=?";
                        $price_stmt = $con->prepare($price_query);
                        $price_stmt->bindParam(1, $product_id[$i]);
                        $price_stmt->execute();
                        $prices = $price_stmt->fetch(PDO::FETCH_ASSOC);

                        $amount =  ($prices['promotion_price'] != 0) ?  $prices['promotion_price'] * $quantity_array[$i] : $prices['price'] * $quantity_array[$i];

                        $total_amount += $amount;
                    }

                    $summary_query = "UPDATE order_summary SET total_amount=:total_amount, order_date=:order_date WHERE order_id=:order_id";
                    $order_date = date('Y-m-d H:i:s'); // get the current date and time
                    $summary_stmt = $con->prepare($summary_query);
                    $summary_stmt->bindParam(":total_amount", $total_amount);
                    $summary_stmt->bindParam(':order_date', $order_date);
                    $summary_stmt->bindParam(":order_id", $id);
                    $summary_stmt->execute();
                    echo "<script>
                    window.location.href = 'order_update.php?id={$id}&action=record_updated';
                  </script>";
                    $_POST = array();
                }
            } catch (PDOException $exception) {
                echo '<div class="alert alert-danger role=alert">' . $exception->getMessage() . '</div>';
            }
        }
        ?>
        <form action="" method="post">
            <h5>Username : <?php echo $customers[$order_summaries['customer_id'] - 1]['username'] ?></h5>

            <table class="table table-hover table-responsive table-bordered" id="row_del">
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
                <?php
                $product_loop = empty($errors) ? count($order_details) : count($noduplicate);
                for ($x = 0; $x < $product_loop; $x++) {
                ?>
                    <tr class="pRow">
                        <td class="text-center"><?php echo $x + 1 ?></td>
                        <td class="d-flex">
                            <select name="product[]" id="product" class="form-select" value>
                                <option value="">Choose a Product</option>
                                <?php
                                for ($i = 0; $i < count($products); $i++) {
                                    //一样就出来 不一样就不出
                                    $product_selected = $products[$i]['id'] == $order_details[$x]['product_id'] ? "selected" : "";
                                    echo "<option value='{$products[$i]['id']}' $product_selected>{$products[$i]['name']}</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <input type="number" class="form-control" name="quantity[]" id="quantity" value="<?php echo $order_details[$x]['quantity'] ?>">

                        </td>
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