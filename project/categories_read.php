<?php include "session.php" ?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Read categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- Latest compiled and minified Bootstrap CSS -->
</head>

<body>
    <!-- container -->
    <div class="container">
        <?php
        include 'navbar/nav.php';
        ?>
        <div class="page-header">
            <h1>Read Categories</h1>
        </div>

        <form class="d-flex" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="GET">
            <input class="form-control me-2 mb-2" type="text" name="search" placeholder="Search" aria-label="Search" value="<?php echo isset($_GET['search_keyword']) ? htmlspecialchars($_GET['search_keyword'], ENT_QUOTES) : ''; ?>">
            <button class="btn btn-outline-success mb-2" type="submit">Search</button>
        </form>

        <!-- PHP code to read records will be here -->
        <?php
        // include database connection
        include 'config/database.php';

        // delete message prompt will be here
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        // if it was redirected from delete.php
        if ($action == 'deleted') {
            echo "<div class='alert alert-success'>Record was deleted.</div>";
        }

        if ($action == 'failed') {
            echo "<div class='alert alert-danger'>There are products inside this category.</div>";
        }

        // select all data
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $query = "SELECT id, category_name, description FROM categories";
        if (!empty($search)) {
            $query .= " WHERE name LIKE :keyword";
            $search = "%{$search}%";
        }
        $query .= " ORDER BY id DESC";
        $stmt = $con->prepare($query);
        if (!empty($search)) {
            $stmt->bindParam(':keyword', $search);
        }

        $stmt->execute();

        // this is how to get number of rows returned
        $num = $stmt->rowCount();

        // link to create record form
        echo "<a href='categories_create.php' class='btn btn-primary mb-3'>Create New Categories</a>";

        //check if more than 0 record found
        if ($num > 0) {

            // data from database will be here
            echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

            //creating our table heading
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Category name</th>";
            echo "<th>Description</th>";
            echo "<th>Action</th>";
            echo "</tr>";

            // table body will be here
            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td>{$category_name}</td>";
                echo "<td>{$description}</td>";
                echo "</td>";
                echo "<td>";

                // we will use this links on next part of this post
                echo "<a href='categories_update.php?id={$id}' class='btn btn-primary me-3'>Edit</a>";

                // we will use this links on next part of this post
                echo "<a href='#' onclick='delete_categories({$id});'  class='btn btn-danger'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }


            // end table
            echo "</table>";
        } else {
            echo "<div class='alert alert-danger'>No records found.</div>";
        }
        ?>



    </div> <!-- end .container -->

    <!-- confirm delete record will be here -->
    <script type='text/javascript'>
        // confirm record deletion
        function delete_categories(id) {
            if (confirm('Are you sure?')) {
                // if user clicked ok,
                // pass the id to delete.php and execute the delete query
                window.location = 'categories_delete.php?id=' + id;
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>