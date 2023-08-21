<?php
// include database connection
include 'config/database.php';
try {     
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id=isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');

    $exists_query = "SELECT COUNT(*) FROM products WHERE category_name = ?";
    $exists_stmt = $con->prepare($exists_query);
    $exists_stmt->bindParam(1, $id);
    $exists_stmt->execute();
    $categories = $exists_stmt->fetchAll(PDO::FETCH_ASSOC);

    // delete query
    $query = "DELETE FROM categories WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $id);
    if ($categories > 0 ) {
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