<?php
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<nav class="navbar navbar-expand-lg bg-info rounded-bottom py-0">
    <a class="navbar-brand ms-2" href="index.php">
        <img src="img/index_logo.png" alt="EcoMart" width="170" class="d-inline-block align-text-top">
    </a>
    <button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end me-3 ms-3 link-dark" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Customer
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="customer_create.php">Create Customer</a></li>
                    <li><a class="dropdown-item" href="customer_read.php">Read Customer</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Product
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="product_create.php">Create Product</a></li>
                    <li><a class="dropdown-item" href="product_read.php">Read Product</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Order
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="order_create.php">Create Order</a></li>
                    <li><a class="dropdown-item" href="order_list.php">Read Order</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Category
                </a>
                <ul class="dropdown-menu ">
                    <li><a class="dropdown-item" href="categories_create.php">Create Category</a></li>
                    <li><a class="dropdown-item" href="categories_read.php">Read Category</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact_form.php">Contact us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?logout=true">Logout</a>
            </li>
        </ul>
    </div>
</nav>