<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <title>W4 Question 3</title>
</head>

<body>
    <div class="container">
        <h3>Question 3</h3>
        <form method="POST" action="">
        <div class="form-group my-3">
                <label for="firstNumber">First Number:</label>
                <input type="text" class="form-control" id="firstNumber" name="firstNumber">
            </div>
            <div class="form-group my-3">
                <label for="secondNumber">Second Number:</label>
                <input type="text" class="form-control" id="secondNumber" name="secondNumber">
            </div>
            <button type="submit" class="btn btn-primary mb-3" name="submit">Submit</button>
        </form>

        <p id="result">
            <?php
            if (isset($_POST['submit'])) {
                $firstNumber = ($_POST['firstNumber']);
                $secondNumber = ($_POST['secondNumber']);

                if (is_numeric($firstNumber) && is_numeric($secondNumber)) {
                    $sum = floatval($firstNumber) + floatval($secondNumber);

                    echo "Sum: " . $sum;
                } else {
                    echo '<span class="text-danger">Please fill in a number.</span>';
                }
            }
            ?>
        </p>
    </div>
</body>

</html>