<?php include "session.php"?>
<!DOCTYPE HTML>
<html>
<head>
    <title>List Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <?php
        include 'navbar/nav.php';
        ?>

        <div class="page-header">
            <h1>Read Order Detail</h1>
        </div>
         
        <?php
        $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        include 'config/database.php';
        $query = "SELECT customers.username, products.id, products.name, products.promotion_price, products.price, order_summary.customer_id, order_summary.order_date, order_details.orderdetail_id, order_details.order_id, order_details.product_id, order_details.quantity FROM order_details INNER JOIN products ON products.id = order_details.product_id INNER JOIN order_summary ON order_summary.order_id = order_details.order_id INNER JOIN customers ON customers.id = order_summary.customer_id WHERE order_details.order_id = :id";
        $stmt = $con->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $num = $stmt->rowCount();

        if ($num > 0) {
            $totalamount = 0;

            echo "<p>Username: $username</p>";
            echo "<table class='table table-hover table-responsive table-bordered'>";
            echo "<tr>";
            echo "<th>Product Name</th>";
            echo "<th class='text-end'>Price</th>";
            echo "<th>Quantity</th>";
            echo "<th class='text-end'>Total Price</th>";
            echo "</tr>";

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $totalprice = ($promotion_price > 0) ? $promotion_price * $quantity : $price * $quantity;
                $totalamount += $totalprice;
                echo "<tr>";
                echo "<td>{$name}</td>";
                echo "<td class='text-end'>";
                if (!empty($promotion_price)) {
                    // Display promotion price if available
                    echo "<div class='text-decoration-line-through'> RM" . number_format($price, 2) . "</div>";
                    echo "(Promotion price)RM" . number_format($promotion_price, 2);
                } else {
                    // Display regular price
                    echo "RM" . number_format($price, 2);
                }
                echo "</td>";
                echo "<td>{$quantity}</td>";
                echo "<td class='text-end'>RM" . number_format($totalprice, 2) . "</td>";
                echo "</tr>";
            }
            echo "<tr>";
            echo "<td colspan='3' class='text-end'><strong>Total amount: </strong></td>";
            echo "<td class='text-end fw-bold'>RM" . number_format($totalamount,2) . "</td>";
            echo "</tr>";
            echo "</table>";
            echo "<a href='order_list.php' class='btn btn-danger'>Back to order list</a>";

        } else {
            echo '<div class="p-3">
                <div class="alert alert-danger">No records found.</div>
            </div>';
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>