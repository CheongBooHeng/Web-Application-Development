<!DOCTYPE html>
<html>

<head>
  <title>Exercise 2</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col">
        <?php
        $number1 = rand(1, 50);
        $number2 = rand(1, 50);

        if ($number1 > $number2) {
          echo '<span class="text-primary fw-bold fs-1">' . $number1 . '</span>';
          echo $number2;
        } else if($number1 == $number2){
          echo 'Suprise';
        }
        else {
          echo $number1 . ' ';
          echo '<span class="text-secondary fw-bold fs-1">' . $number2 . '</span>';
        }
        ?>
      </div>
    </div>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</html>