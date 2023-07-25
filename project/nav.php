<!-- <nav class="nav justify-content-center bg-info p-2 rounded-bottom">   
    <a class="nav-link text-dark" href="index.php">Home</a>
    <a class="nav-link text-dark" href="product_create.php">Create Product</a>
    <a class="nav-link text-dark" href="product_read.php">Read Product</a>
    <a class="nav-link text-dark" href="customer_create.php">Create Customer</a>
    <a class="nav-link text-dark" href="customer_read.php">Read Customer</a>
    <a class="nav-link text-dark" href="categories_create.php">Create Category</a>
    <a class="nav-link text-dark" href="categories_read.php">Read Category</a>
    <a class="nav-link text-dark" href="contact_form.php">Contact Us</a>
</nav> -->

<nav class="navbar navbar-expand-lg bg-info">
            <div class="collapse navbar-collapse justify-content-end me-3 ms-3" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle " href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Customer
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="customer_create.php">Create Customer</a></li>
                            <li><a class="dropdown-item" href="customer_read.php">Read Customer</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Product
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="product_create.php">Create Product</a></li>
                            <li><a class="dropdown-item" href="product_read.php">Read Product</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Order
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="order_create.php">Create Order</a></li>
                            <li><a class="dropdown-item" href="order_list.php">Read Order</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
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
                </ul>
            </div>
        </nav>