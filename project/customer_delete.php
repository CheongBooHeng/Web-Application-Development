<?php
// include database connection
include 'config/database.php';
try {     
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    //exists example
    // SELECT name FROM products WHERE EXISTS(SELECT products.id FROM order_detail WHERE order_detail.product_id=products.id)
    $id=isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');

    $exists_query = "SELECT id FROM customers WHERE EXISTS (SELECT customer_id FROM order_summary WHERE order_summary.customer_id = customers.id)";
    $exists_stmt = $con->prepare($exists_query);
    $exists_stmt->execute();
    $customers = $exists_stmt->fetchAll(PDO::FETCH_ASSOC);

    $image_query = "SELECT image FROM customers WHERE id=?";
    $image_stmt = $con->prepare($image_query);
    $image_stmt->bindParam(1, $id);
    $image_stmt->execute();
    $image = $image_stmt->fetch(PDO::FETCH_ASSOC);

    // delete query
    $query = "DELETE FROM customers WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $id);
    for ($i = 0; $i < count($customers); $i++) {
        if ($id == $customers[$i]['id'])
            $error = 1;
    }
    if (isset($error)) {
        header("Location: customer_read.php?action=failed");
    } else if($stmt->execute()){
        unlink("uploads/" . $image['image']);
        // redirect to read records page and
        // tell the user record was deleted
        header('Location: customer_read.php?action=deleted');
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