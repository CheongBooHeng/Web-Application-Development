<!DOCTYPE html>
<html>

<head>
    <title>Exercise 1</title>
    <link rel="stylesheet" type="text/css" href="random_num.css">
</head>

<body>
    <?php
    $number1 = rand(100, 200);
    $number2 = rand(100, 200);
    $total = $number1 + $number2;
    $multi = $number1 * $number2;
    ?>
    <p class="italic green"><?php echo $number1; ?></p>
    <p class="italic blue"><?php echo $number2; ?></p>
    <p class="bold red"><?php echo $total; ?></p>
    <p class="bold italic"><?php echo $multi; ?></p>
</body>

</html>