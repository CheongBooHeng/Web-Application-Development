<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <title>W4 Question 4</title>
    </style>
</head>

<body>
    <div class="container">
        <h3>Question 4</h3>
        <form method="POST" action=" ">
            <div class="form-group my-3">
                <label for="number">Enter a Number:</label>
                <input type="text" class="form-control" id="number" name="number">
            </div>
            <button type="submit" class="btn btn-primary mb-3" name="submit">Submit</button>
        </form>

        <p id="result">
            <?php
            if (isset($_POST['submit'])) {
                $number = $_POST['number'];

                if (empty($number)) {
                    echo "<p class='error'>Please fill in a number.</p>";
                } elseif (!is_numeric($number)) {
                    echo "<p class='error'>Please enter a valid number.</p>";
                } else {
                    $number = (int)$number;
                    $sum = 0;

                    for ($i = intval($number); $i >= 1; $i--) {
                        $sum += $i;
                    }

                    echo "<h3>Sum:</h3>";
                    echo implode('+', range($number, 1)) . ' = ' . $sum;
                }
            }
            ?>

        </p>
    </div>
</body>

</html>