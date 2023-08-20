<?php
// include database connection
include 'config/database.php';
try {     
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    //exists example
    // SELECT name FROM products WHERE EXISTS(SELECT products.id FROM order_detail WHERE order_detail.product_id=products.id)
    $id=isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');

    $exists_query = "SELECT id FROM categories WHERE EXISTS (SELECT category_name FROM products WHERE products.category_name = categories.category_name)";
    $exists_stmt = $con->prepare($exists_query);
    $exists_stmt->execute();
    $categories = $exists_stmt->fetchAll(PDO::FETCH_ASSOC);

    // delete query
    $query = "DELETE FROM products WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $id);
    for ($i = 0; $i < count($categories); $i++) {
        if ($id == $categories[$i]['id'])
            $error = 1;
    }
    if (isset($error)) {
        header("Location: categories_read.php?action=failed");
    } else if($stmt->execute()){
        // redirect to read records page and
        // tell the user record was deleted
        header('Location: categories_read.php?action=deleted');
    }else{
        die('Unable to delete record.');
    }
}
// show error
catch(PDOException $exception){
    echo "<div class = 'alert alert-danger'>";
    echo $exception->getMessage();
    echo "</div>";
}
?>