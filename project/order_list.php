<?php include "session.php" ?>
<!DOCTYPE HTML>
<html>

<head>
    <title>List of order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <?php
        include 'navbar/nav.php';
        ?>

        <div class="page-header">
            <h1>Read Order</h1>
        </div>

        <form class="d-flex" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="GET">
            <input class="form-control me-2 mb-2" type="text" name="search" placeholder="Search" aria-label="Search" value="<?php echo isset($_GET['search_keyword']) ? htmlspecialchars($_GET['search_keyword'], ENT_QUOTES) : ''; ?>">
            <button class="btn btn-outline-success mb-2" type="submit">Search</button>
        </form>

        <?php
        include 'config/database.php';

        // delete message prompt will be here
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        // if it was redirected from delete.php
        if ($action == 'deleted') {
            echo "<div class='alert alert-success'>Record was deleted.</div>";
        }

        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $query = "SELECT order_summary.order_id, customers.firstname, customers.lastname, order_summary.order_date FROM order_summary INNER JOIN customers ON order_summary.customer_id = customers.id";
        if (!empty($search)) {
            $query .= " WHERE customers.firstname LIKE :keyword OR customers.lastname LIKE :keyword";
            $search = "%{$search}%";
        }
        $query .= " ORDER BY id ASC";
        $stmt = $con->prepare($query);
        if (!empty($search)) {
            $stmt->bindParam(':keyword', $search);
        }

        $stmt->execute();
        $num = $stmt->rowCount();

        echo '<a href="order_create.php" class="btn btn-primary mb-3">Create New Order</a>';

        if ($num > 0) {
            echo "<table class='table table-hover table-responsive table-bordered'>";
            echo "<tr>";
            echo "<th>Order ID</th>";
            echo "<th>Customer Name</th>";
            echo "<th>Order Date</th>";
            echo "<th>Action</th>";
            echo "</tr>";

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo "<tr>";
                echo "<td>{$order_id}</td>";
                echo "<td>{$firstname} {$lastname}</td>";
                echo "<td>{$order_date}</td>";
                echo "<td>";
                // read one record
                echo "<a href='order_detail_read.php?id={$order_id}' class='btn btn-info me-3'>Read</a>";

                // we will use this links on next part of this post
                echo "<a href='order_update.php?id={$order_id}' class='btn btn-primary me-3'>Edit</a>";

                // we will use this links on next part of this post
                echo "<a href='#' onclick='delete_order({$order_id});'  class='btn btn-danger'>Delete</a>";
                echo "</td>";

                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        } else {
            echo '<div class="p-3">
                <div class="alert alert-danger">No records found.</div>
            </div>';
        }
        ?>
    </div>

    <script type='text/javascript'>
        // confirm record deletion
        function delete_order(id) {
            if (confirm('Are you sure?')) {
                // if user clicked ok,
                // pass the id to delete.php and execute the delete query
                window.location = 'order_delete.php?id=' + id;
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>