<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Date format</title>
    <style>
        .month {
            color: rgb(175, 123, 81)
        }

        .day {
            color: rgb(7, 55, 99)
        }

        .hour {
            color: rgb(91, 15, 0)
        }

        .min {
            color: rgb(76, 17, 48)
        }
    </style>
</head>

<body>
    <?php
    date_default_timezone_set('asia/Kuala_Lumpur');

    $month = date("M ");
    echo "<span class='month fs-3 text-uppercase'> <strong>$month</strong></span>";
    $date = date("d, Y");
    echo "<span class='fs-3'><strong>$date</strong></span>";
    $day = date(" (D) ");
    echo "<span class='day fs-3'>$day</span><br>";
    $hour = date("H");
    echo "<span class='hour fs-3'>$hour</span>";
    $min = date(":i");
    echo "<span class='min fs-3'>$min</span>";
    $sec = date(":s");
    echo "<span class='fs-3'>$sec</span>";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>